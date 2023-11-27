<?php

namespace App\Http\Controllers;


use App\Http\Exceptions\CustomException;
use App\Http\Requests\StoreCompanyInformationRequest;
use App\Http\Requests\UpdateCompanyInformationRequest;
use App\Models\CompanyInformation;
use App\Traits\ActivityLog\ActivityLog;
use App\Traits\Common\CommonTrait;
use App\Traits\Image\ImageTrait;
use Illuminate\Support\Facades\DB;
use Lang\Locales\CommonWords;
use Lang\Locales\CommonWordsEnum;
use Lang\Translate;

class CompanyInformationController extends Controller
{
  use  ImageTrait, ActivityLog, CommonTrait;


  public $commonMessage;

  function __construct()
  {

    $this->commonMessage = new Translate(new CommonWords());
  }


  public function index()
  {
    $parameters = ['id' => null];
    $this->callActivityMethod('company_information', 'index', $parameters);
    $companies_information = CompanyInformation::all();
    return $companies_information;
  }


  public function store(StoreCompanyInformationRequest $request)
  {
    $lang = $request->header('lang');

    DB::beginTransaction();
    try {

      $company_information = CompanyInformation::create($request->all());

      $this->saveImage($request, 'photo', 'Company_Information', 'upload_image', $company_information->id, 'App\Models\CompanyInformation');

      $result = $this->activityParameters($lang, 'store', 'company_information', $company_information,   'pc_name' , null);
      $parameters = $result['parameters'];
      $table = $result['table'];
      $this->callActivityMethod('delete', $table, $parameters);


      DB::commit();
      return [

        'message' => $this->commonMessage->t(CommonWordsEnum::STORE->name, $lang),
        'id' => $company_information->id,

    ];
        } catch (CustomException $exc) {
      DB::rollback();
      return response()->json(
        [
          'message' => $exc->message,
        ],
        $exc->code
      );
    }
  }

  public function show($id)
  {


    $company_information = CompanyInformation::find($id);

    if ($company_information) {


      return response([
        'company_information' => $company_information
      ], 200);
    } else {

      return response([
        'message' => 'Not Found',
      ], 404);


    }
  }

  public function update(UpdateCompanyInformationRequest $request, $id)
  {
    $lang = $request->header('lang');
    $old_data = CompanyInformation::find($id)->toJson();
    $company_information = CompanyInformation::find($id);

    if ($result = $this->validateNameAndForeignNameAndEmail($id, $request, $lang))
      return $result;

    DB::beginTransaction();
    try {

      if ($company_information->image) {
        $this->deleteImage('upload_image', 'Company_Information/' . $company_information->image->file_name, $company_information->id);
      }
      $this->saveImage($request, 'photo', 'Company_Information', 'upload_image', $company_information->id, 'App\Models\CompanyInformation');

      $company_information->update($request->all());


      $result = $this->activityParameters($lang, 'update', 'company_information', $company_information,   'pc_name' , $old_data);
      $parameters = $result['parameters'];
      $table = $result['table'];
      $this->callActivityMethod('update', $table, $parameters);


      DB::commit();
      return [
        'company_information' => $company_information,

        'message' => $this->commonMessage->t(CommonWordsEnum::UPDATE->name, $lang),

        'id' => $company_information->id,

    ];
    } catch (CustomException $exc) {
      DB::rollback();
      return response()->json(['message' => $exc->message,], $exc->code);
    }
  }

  public function validateNameAndForeignNameAndEmail($id, $request, $lang)
  {

    if ($result = $this->validateDuplicateName($id, CompanyInformation::class, $request->name, $lang))
      return $result;
    if ($result = $this->validateDuplicateForeignName($id, CompanyInformation::class, $request->foreign_name, $lang))
      return $result;
    if ($result = $this->validateDuplicateEmail($id, CompanyInformation::class, $request->email, $lang))
      return $result;
  }

  public function delete($id)
  {
    $lang = app('request')->header('lang');

    $company_information = CompanyInformation::find($id);


    try {

      if ($company_information->image) {
        $this->deleteImage('upload_image', 'Company_Information/' . $company_information->image->file_name, $company_information->id);
      }
      $company_information->delete();

      $result = $this->activityParameters($lang, 'delete', 'company_information', $company_information,   'pc_name' , null);
      $parameters = $result['parameters'];
      $table = $result['table'];
      $this->callActivityMethod('delete', $table, $parameters);


      return response()->json([

        'message' => $this->commonMessage->t(CommonWordsEnum::DELETE->name, $lang)

    ], 200);
  } catch (CustomException $exc) {

      return response()->json(['message' => $exc->message,], $exc->code);
    }
  }

}
