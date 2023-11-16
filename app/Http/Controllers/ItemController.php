<?php

namespace App\Http\Controllers;

use App\Events\CategoriesUpdated;
use App\Events\ItemsUpdated;
use App\Http\Exceptions\CustomException;
use App\Http\Requests\Request;
use App\Http\Requests\StoreRequest;
use App\Http\Requests\UpdateRequest;
use App\Models\Category;
use App\Models\Item;
use App\Traits\ActivityLog\ActivityLog;
use App\Traits\Common\CommonTrait;
use App\Traits\Item\ItemTrait;
use App\Traits\Unit\UnitTrait;
use Illuminate\Support\Facades\DB;
use Lang\Locales\CommonWords;
use Lang\Locales\CommonWordsEnum;
use Lang\Locales\ItemWords;
use Lang\Locales\ItemWordsEnum;
use Lang\Translate;




class ItemController extends Controller
{
  use CommonTrait, ActivityLog, UnitTrait, ItemTrait;

  protected $item;
  public $itemMessage, $commonMessage;

  public function __construct(Item $item)
  {
    $this->itemMessage = new Translate(new ItemWords());
    $this->commonMessage = new Translate(new CommonWords());
    $this->item = $item;
  }

  public function getDefaultUnit()
  {
    foreach ($this->item['units'] as $unit) {
      if ($unit->is_default) {
        return $unit->unit_number;
      }
    }
  }

  public function index()
  {
    $parameters = ['id' => null];
    $items = Item::with('units')->select('name', 'code', 'flag', 'id', 'category_id')->get();
    $this->callActivityMethod('items', 'index', $parameters);
    return response()->json($items, 200);
  }

  public function all()
  {
    $parameters = ['id' => null];
    $items = Item::with('units')->get();
    $this->callActivityMethod('items', 'all', $parameters);
    return response()->json($items, 200);
  }

  public function store(StoreRequest $request)
  {
    $lang = $request->header('lang');

    DB::beginTransaction();
    try {
      $item = Item::create([
        'code' => $request['code'],
        'name' => $request['name'],
        'foreign_name' => $request['foreign_name'],
        'category_id' => $request['category_id'],
        'location' => $request['location'],
        'manuf_company' => $request['manuf_company'],
        'country_of_origin' => $request['country_of_origin'],
        'source' => $request['source'],
        'caliber' => $request['caliber'],
        'chemical_composition' => $request['chemical_composition'],
        'weight' => $request['weight'],
        'size' => $request['size'],
        'item_type' => $request['item_type'],
        'photo' => $request['photo'],
        'notes' => $request['notes'],
        'currency_id' => $request['currency_id'],
        'parity' => $request['parity'],
        'total_items' => $request['total_items'],
        'auto_discount_on_salse' => $request['auto_discount_on_salse'],
        'added_value_tax' => $request['added_value_tax'],
        'auto_counting_for_prices' => $request['auto_counting_for_prices'],
        'expired_date' => $request['expired_date'],
        'serial_number' => $request['serial_number'],
        'production_date' => $request['production_date'],
        'should_alert' => $request['should_alert'],
        'days_before_alert' => $request['days_before_alert']
      ]);

      $this->saveImage($request, 'photo', 'items', 'upload_image', $item->id, 'App\Models\Item');
      $this->saveUnit($request, $item->id);
      DB::commit();
    } catch (\Illuminate\Database\QueryException $e) {
      DB::rollback();
      $errorCode = $e->errorInfo[1];
      if ($errorCode === 1062) {

        $errors = ['message' => [$this->itemMessage->t(ItemWordsEnum::barcode_name_is_unique->name, $lang)]] ;
        return response()->json(["errors" => $errors], 400);
      }
      if ($e->errorInfo[1] === 1048) {

        $errors = ["message" => [$this->itemMessage->t(ItemWordsEnum::barcode_name_required->name, $lang)]];
        return response()->json(["errors" => $errors], 422);
      }
//      return;
    }

    $parameters = ['request' => $request, 'id' => $item->id];
    $this->callActivityMethod('items', 'store', $parameters);
    event(new CategoriesUpdated([...Category::with('items.units')->get()]));
    event(new ItemsUpdated([...Item::with('units')->get()]));

    return response()->json([

      'message' => $this->commonMessage->t(CommonWordsEnum::STORE->name, $lang),
      'id' => $item->id,
      'category_id' => $item->category_id
    ], 200);
  }


  public function show($id)
  {
    $parameters = ['id' => $id];
    $item = Item::with('units')->find($id);
    $this->callActivityMethod('items', 'show', $parameters);
    return response()->json($item, 200);
  }

  public function update(UpdateRequest $request, $id)
  {

    $lang = $request->header('lang');
    $old_data = Item::find($id)->toJson();
    $parameters = ['request' => $request, 'id' => $id, 'old_data' => $old_data];
    $item = Item::find($id);

    if (!$request->units[0]["unit_name"]) {

      $errors = ["message" => [$this->itemMessage->t(ItemWordsEnum::first_unit_is_required->name, $lang)]];
      return response()->json(["errors" => $errors], 400);
    }
    DB::beginTransaction();
    try {
      if ($item->image) {
        $this->deleteImage('upload_image', 'items/' . $item->image->file_name, $item->id);
      }
      $this->saveImage($request, 'photo', 'items', 'upload_image', $item->id, 'App\Models\Item');
      $item->update($request->all());
      $this->updateUnit($request, $item->id);
      DB::commit();
    } catch (\Illuminate\Database\QueryException $e) {
      DB::rollback();
      $errorCode = $e->errorInfo[1];
      if ($errorCode === 1062) {

        $errors = ['message' => [$this->itemMessage->t(ItemWordsEnum::barcode_name_is_unique->name, $lang)]] ;
        return response()->json(["errors" => $errors], 400);
      }
      if ($e->errorInfo[1] === 1048) {

        $errors = ["message" => [$this->itemMessage->t(ItemWordsEnum::barcode_name_required->name, $lang)]];
        return response()->json(["errors" => $errors], 422);
      }
    }
    $this->callActivityMethod('items', 'update', $parameters);
    event(new CategoriesUpdated([...Category::with('items.units')->get()]));
    event(new ItemsUpdated([...Item::with('units')->get()]));
    return response()->json([

      'message' => $this->commonMessage->t(CommonWordsEnum::UPDATE->name, $lang),
      'id' => $item->id,
      'category_id' => $item->category_id
    ], 200);
  }



  public function delete($id)
  {
    $lang  =   app('request')->header('lang');
    $parameters = ['id' => $id];
    DB::beginTransaction();
    try {
      $item = Item::find($id);
      $itemUnits = $item->units;

      foreach ($itemUnits as $itemUnit) {
        foreach ($itemUnits as $itemUnit) {
          $barcodes = $itemUnit['barcodes'];


          foreach ($barcodes as $barcode) {
            $barcode->delete();
          }
          $itemUnit->delete();
        }
      }
      if ($item->image) {
        $this->deleteImage('upload_image', 'items/' . $item->image->file_name, $item->id);
      }
      $item->delete();
      $this->callActivityMethod('items', 'delete', $parameters);
      event(new CategoriesUpdated([...Category::with('items.units')->get()]));
      event(new ItemsUpdated([...Item::with('units')->get()]));
      DB::commit();
      return response()->json([

        'message' => $this->commonMessage->t(CommonWordsEnum::DELETE->name, $lang)
      ], 200);
    } catch (CustomException $exc) {
      DB::rollback();
      $errors = ['message' => [$exc->message]];
      return response()->json(['errors'=> $errors], $exc->code);
    }
  }


  public function callGenerateCodes($id)
  {
    return $this->generateCodes($id, Category::class, Item::class, 'category_id');
  }



}
