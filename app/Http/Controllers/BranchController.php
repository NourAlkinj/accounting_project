<?php

namespace App\Http\Controllers;

use App\Events\BranchesGuideUpdated;
use App\Events\BranchesUpdated;
use App\Http\Exceptions\CustomException;
use App\Http\Requests\StoreBranchRequest;
use App\Http\Requests\UpdateBranchRequest;
use App\Models\Activity;
use App\Models\Bill;
use App\Models\BillTemplate;
use App\Models\Branch;
use App\Models\Department;
use App\Models\JournalEntry;
use App\Models\JournalEntryRecord;
use App\Models\ReportTemplate;
use App\Models\User;
use App\Models\Voucher;
use App\Models\VoucherTemplate;
use App\Traits\ActivityLog\ActivityLog;
use App\Traits\Common\CommonTrait;
use Illuminate\Support\Facades\DB;
use Lang\Locales\BranchWords;
use Lang\Locales\BranchWordsEnum;
use Lang\Locales\CommonWords;
use Lang\Locales\CommonWordsEnum;
use Lang\Translate;

class BranchController extends Controller
{
    use  ActivityLog, CommonTrait;

    public $branchMessage, $commonMessage;

    function __construct()
    {
        $this->branchMessage = new Translate(new BranchWords());
        $this->commonMessage = new Translate(new CommonWords());
    }


    public function index()
    {
//        $BranchesAndUsersTree = Branch::whereNull('branch_id')->with('children', 'users')->get();
////        $BranchesAndUsersTree = JournalEntryRecord::all();
//        return $BranchesAndUsersTree;

//        $posts = DB::select('SELECT settings FROM report_templates');
        $posts = ReportTemplate::find(2);

        return var_dump($posts->settings);
    }

    public function branchesGuide()
    {
        event(new BranchesGuideUpdated([...Branch::whereNull('branch_id')->with('children', 'users')->get()]));
    }

    public function all()
    {
        $branches = Branch::with('users')->get();
        return $branches;
    }

    public function store(StoreBranchRequest $request)
    {
        $lang = $request->header('lang');
        DB::beginTransaction();
        try {

            $branch = Branch::create($request->all());

            if ($this->getCountRawsInModel(Branch::class) == 1) {
                $this->updateValueInDB($branch->id, Branch::class, 'is_root', true);
            }


            $result = $this->activityParameters($lang, 'store', 'branch', $branch, null);
            $parameters = $result['parameters'];
            $table = $result['table'];
            $this->callActivityMethod('store', $table, $parameters);


            event(new BranchesUpdated([...Branch::with('users')->get()]));
            $lang = $request->header('lang');

            DB::commit();

            return response()->json([
                'message' => $this->commonMessage->t(CommonWordsEnum::STORE->name, $lang),
        'id' => $branch->id,
        'branch_id' => $request->branch_id,
      ], 200);

  } catch (CustomException $exc) {

            DB::rollback();
            return response()->json(
                [
                    'errors' => ['message' => [$exc->message]]
                ],
                $exc->code
            );

        }

    }

    public function show($id)
    {
        $branch = Branch::find($id);
        if ($branch) {
            return $branch;
        }
    }

    public function update(UpdateBranchRequest $request, $id)
    {
        $lang = $request->header('lang');
        $old_data = Branch::find($id)->toJson();
        $parameters = ['request' => $request, 'id' => $id, 'old_data' => $old_data];
        $branch = Branch::find($id);

        DB::beginTransaction();
        try {

            $branch->update($request->all());
            if (!$request->is_active) {
                $this->callDeActivateChildren($id);
            }
            if ($request->is_active) {
                $this->callActivateChildren($id);
            }

            $result = $this->activityParameters($lang, 'update', 'branch', $branch, $old_data);
            $parameters = $result['parameters'];
            $table = $result['table'];
            $this->callActivityMethod('update', $table, $parameters);

            event(new BranchesUpdated([...Branch::with('users')->get()]));

            DB::commit();
            return response()->json([
                'message' => $this->commonMessage->t(CommonWordsEnum::UPDATE->name, $lang),
      'id' => $branch->id,
      'branch_id' => $branch->branch_id
    ], 200);
  } catch (CustomException $exc) {
            DB::rollback();
            return response()->json(
                [
                    'errors' => ['message' => [$exc->message]]
                ],
                $exc->code
            );
        }
    }


    public function delete($id)
    {
        $lang = app('request')->header('lang');
        $parameters = ['id' => $id];
        $branch = Branch::find($id);
        if ($branch) {
            if ($branch['is_root'] == true) {
                $errors = ['message' => [$this->branchMessage->t(BranchWordsEnum::root_branch_can_not_be_deleted->name, $lang)]];
      return response()->json(['errors' => $errors], 400);
    }
            if ($this->numOfSubChilds(Branch::class, User::class, $id, 'branch_id') > 0) {

                $errors = ['message' => [$this->commonMessage->t(CommonWordsEnum::DELETE_ERROR->name, $lang)]];
      return response()->json(['errors' => $errors], 400);
    }
        } else {

            $errors = ['message' => [$this->branchMessage->t(BranchWordsEnum::branch_not_found->name, $lang)]];
      return response()->json(['errors' => $errors], 404);
    }
        DB::beginTransaction();
        try {
            if ($this->isUseBranch($id)) {
                $errors = ['branch' => [$this->commonMessage->t(CommonWordsEnum::DELETE_ERROR->name, $lang)]];
        return response()->json(['errors' => $errors], 400);
      }
            $branch->delete();

            $result = $this->activityParameters($lang, 'delete', 'branch', $branch, null);
            $parameters = $result['parameters'];
            $table = $result['table'];
            $this->callActivityMethod('delete', $table, $parameters);


            event(new BranchesUpdated([...Branch::with('users')->get()]));
            DB::commit();
            return response()->json([
                'message' => $this->commonMessage->t(CommonWordsEnum::DELETE->name, $lang)
    ], 200);
  } catch (CustomException $exc) {
            DB::rollback();
            return response()->json(
                [
                    'errors' => ['message' => [$exc->message]]
                ],
                $exc->code
            );
        }
    }

    public function callAutoComplete($id)
    {
        return $this->AutoComplete($id, Branch::class, 'branch_id', 'true', 'internalModels', 'is_active', true);
    }

    public function callGenerateCodes($id)
    {
        return $this->generateCodes($id, Branch::class, Branch::class, 'branch_id');
    }

    public function callGetNameAndCode($id)
    {
        return $this->getNameAndCode($id, Branch::class);
    }

    public function callGetAllCodesAndNames()
    {
        return $this->getAllCodesAndNames(Branch::class);
    }

    public function getName($id)
    {
        return $this->getModelData(Branch::class, $id, 'name');
    }

    public function getCode($id)
    {
        return $this->getModelData(Branch::class, $id, 'code');
    }

    public function callGetAllIDs()
    {
        return $this->getAllIDs(Branch::class);
    }

    public function callGetObjectByValue($code)
    {
        return $this->getObjectByValue(Branch::class, $code, 'code');
    }

    public function callGetRootCode()
    {
        return $this->getModelData(Branch::class, 1, 'code');
    }

    public function callGetCountRawsInModel()
    {
        return $this->getCountRawsInModel(Branch::class);
    }

    public function callNumOfSubModels($id)
    {
        return $this->numOfSubModels(Branch::class, $id, 'branch_id');
    }

    public function callValidateCode($code)
    {
        return $this->validateCode($code);
    }

    public function callGetParentName($id)
    {
        return $this->getParentName(Branch::class, $id);
    }


    public function callActivateDeActivateBranch($id)
    {
        return $this->ActivateDeActivateBranch($id);
    }

    public function callDeActivateChildren($id)
    {
        return $this->DeActivateBranchChildren($id);
    }

    public function callActivateChildren($id)
    {
        return $this->ActivateBranchChildren($id);
    }

    public function lastId()
    {
        return $this->generateModelID(User::class);
    }


    public function callRoot()
    {
        return $this->rootModel(Branch::class);
    }

    public function callNotRoot()
    {
        return $this->notRootModel(Branch::class);
    }

    public function isUseBranch($branch_id)
    {
        //branch related to activity
        $activity = Activity::where(function ($query) use ($branch_id) {
            $query->where('branch_id', $branch_id);
        })->first();
        if ($activity != null)
            return true;
//      return ['activityId' => $activity->id, 'table' => 'activities'];

        //branch related to bill
        $bill = Bill::where(function ($query) use ($branch_id) {
            $query->where('branch_id', $branch_id);
        })->first();
        if ($bill != null)
            return true;
//      return ['billId' => $bill->id, 'table' => 'bills'];

        //branch related to billTemplate
        $billTemplate = BillTemplate::where(function ($query) use ($branch_id) {
            $query->where('branch_id', $branch_id);
        })->first();
        if ($billTemplate != null)
            return true;
//      return ['billTemplateId' => $billTemplate->id, 'table' => 'bill_templates'];

        //branch related to branch
        $branch = Branch::where(function ($query) use ($branch_id) {
            $query->where('branch_id', $branch_id);
        })->first();
        if ($branch != null)
            return true;
//      return ['branchId' => $branch->id, 'table' => 'branches'];

        //branch related to department
        $department = Department::where(function ($query) use ($branch_id) {
            $query->where('branch_id', $branch_id);
        })->first();
        if ($department != null)
            return true;
//      return ['departmentId' => $department->id, 'table' => 'departments'];

        //branch related to journalEntry
        $journalEntry = JournalEntry::where(function ($query) use ($branch_id) {
            $query->where('branch_id', $branch_id);
        })->first();
        if ($journalEntry != null)
            return true;
//      return ['journalEntryId' => $journalEntry->id, 'table' => 'journal_entries'];

        //branch related to journalEntryRecord
        $journalEntryRecord = JournalEntryRecord::where(function ($query) use ($branch_id) {
            $query->where('branch_id', $branch_id);
        })->first();
        if ($journalEntryRecord != null)
            return true;
//      return ['journalEntryRecordId' => $journalEntryRecord->id, 'table' => 'journal_entry_records'];

        //branch related to user
        $user = User::where(function ($query) use ($branch_id) {
            $query->where('branch_id', $branch_id);
        })->first();
        if ($user != null)
            return true;
//      return ['userId' => $user->id, 'table' => 'users'];

        //branch related to voucher
        $voucher = Voucher::where(function ($query) use ($branch_id) {
            $query->where('branch_id', $branch_id);
        })->first();
        if ($voucher != null)
            return true;
//      return ['voucherId' => $voucher->id, 'table' => 'vouchers'];

        //branch related to voucherTemplate
        $voucherTemplate = VoucherTemplate::where(function ($query) use ($branch_id) {
            $query->where('branch_id', $branch_id);
        })->first();
        if ($voucherTemplate != null)
            return true;
//      return ['voucherTemplateId' => $voucherTemplate->id, 'table' => 'voucher_templates'];


//    return ['id' => null, 'table' => null];
        return false;
    }


}
