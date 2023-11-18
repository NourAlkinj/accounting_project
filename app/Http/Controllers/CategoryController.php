<?php

namespace App\Http\Controllers;

use App\Events\CategoriesUpdated;
use App\Http\Exceptions\CustomException;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\BillRecord;
use App\Models\Category;
use App\Models\Item;
use App\Models\JournalEntryRecord;
use App\Traits\ActivityLog\ActivityLog;
use App\Traits\Common\CommonTrait;
use Lang\Locales\CommonWords;
use Lang\Locales\CommonWordsEnum;
use Lang\Translate;


class CategoryController extends Controller
{
  use CommonTrait, ActivityLog;

  public $commonMessage;

  function __construct()
  {
    $this->commonMessage = new Translate(new CommonWords());
  }

  public function index()
  {
    $parameters = ['id' => null];
    $categoryWithItems = Category::whereNull('category_id')->with('children', 'items.units.barcodes')->get();;
    $this->callActivityMethod('categories', 'index', $parameters);
    return response()->json($categoryWithItems, 200);
  }

  public function all()
  {
    $parameters = ['id' => null];
    $categories = Category::with('items.units.barcodes')->get();
    $this->callActivityMethod('categories', 'all', $parameters);
    return response()->json($categories, 200);
  }

  public function store(StoreCategoryRequest $request)
  {
    try {
      $lang = $request->header('lang');


      $category = Category::create($request->all());
      $parameters = ['request' => $request, 'id' => $category->id];
      $this->callActivityMethod('categories', 'store', $parameters);
      event(new CategoriesUpdated([...Category::with('items.units.barcodes')->get()]));
      return response()->json([

        'message' => $this->commonMessage->t(CommonWordsEnum::STORE->name, $lang),

            'id' => $category->id,
            'category_id' => $category->category_id
        ], 200);
    } catch (CustomException $exc) {
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
    $parameters = ['id' => $id];
    $category = Category::find($id);
    $this->callActivityMethod('categories', 'show', $parameters);
    return response()->json($category, 200);
  }


  public function update(UpdateCategoryRequest $request, $id)
  {
    $lang = $request->header('lang');
    $old_data = Category::find($id)->toJson();
    $parameters = ['request' => $request, 'id' => $id, 'old_data' => $old_data];
    $category = Category::find($id);

    try {
      $category->update($request->all());
      $this->callActivityMethod('categories', 'update', $parameters);
      event(new CategoriesUpdated([...Category::with('items.units.barcodes')->get()]));

      return response()->json([
        'message' => $this->commonMessage->t(CommonWordsEnum::UPDATE->name, $lang),

            'category_id' => $category->category_id,
            'id' => $category->id
        ], 200);
    } catch (CustomException $exc) {
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
    try {
      $lang = app('request')->header('lang');
      $parameters = ['id' => $id];
      $category = Category::find($id);
      if ($this->numOfSubChilds(Category::class, Item::class, $id, 'category_id') > 0) {
        $errors =  ['message' => [$this->commonMessage->t(CommonWordsEnum::DELETE_ERROR->name, $lang)]];
            return response()->json(['errors' => $errors], 404);

        }

        if($this->isUseCategory($id)) {
            $errors = ['store' => [$this->commonMessage->t(CommonWordsEnum::DELETE_ERROR->name, $lang)]];
        return response()->json(['errors' => $errors], 400);
      }
      $category->delete();
      $this->callActivityMethod('categories', 'delete', $parameters);
      event(new CategoriesUpdated([...Category::with('items.units.barcodes')->get()]));
      return response()->json(['message' => $this->commonMessage->t(CommonWordsEnum::DELETE->name, $lang)], 200);
    } catch (CustomException $exc) {
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
    return $this->AutoCompleteCategory($id, Category::class, 'category_id', 'id', '!=', null, false, null, null);
    // return $this->AutoComplete($id, Category::class, 'category_id', 'internalModels',  null, null);
  }

  public function callGenerateCodes($id)
  {
    return $this->generateCodes($id, Category::class, Category::class, 'category_id');
  }

  public function callGetNameAndCode($id)
  {
    return $this->getNameAndCode($id, Category::class);
  }

  public function callGetAllCodesAndNames()
  {
    return $this->getAllCodesAndNames(Category::class);
  }

    public function isUseCategory($category_id)
    {
        //category related to bill record
        $billRecord = BillRecord::where(function ($query) use ($category_id) {
            $query->where('category_id', $category_id);})->first();
        if ($billRecord != null)
            return true;
//      return ['billRecordId' => $billRecord->id, 'table' => 'bill_records'];

        //category related to category
        $category = Category::where(function ($query) use ($category_id) {
            $query->where('category_id', $category_id);})->first();
        if ($category != null)
            return true;
//      return ['categoryId' => $category->id, 'table' => 'categories'];

        //category related to item
        $item = Item::where(function ($query) use ($category_id) {
            $query->where('category_id', $category_id);})->first();
        if ($item != null)
            return true;
//      return ['itemId' => $item->id, 'table' => 'items'];

        //category related to journal entry record
        $journalEntryRecord = JournalEntryRecord::where(function ($query) use ($category_id) {
            $query->where('category_id', $category_id);})->first();
        if ($journalEntryRecord != null)
            return true;
//      return ['journalEntryRecordId' => $journalEntryRecord->id, 'table' => 'journal_entry_records'];

//    return ['id' => null, 'table' => null];
        return false;

    }



}
