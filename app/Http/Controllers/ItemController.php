<?php

namespace App\Http\Controllers;

use App\Events\CategoriesUpdated;
use App\Events\ItemsUpdated;
use App\Http\Exceptions\CustomException;
use App\Http\Requests\Request;
use App\Http\Requests\StoreRequest;
use App\Http\Requests\UpdateRequest;
use App\Models\Barcode;
use App\Models\BillRecord;
use App\Models\Category;
use App\Models\Item;
use App\Models\JournalEntryRecord;
use App\Models\Quantity;
use App\Models\Serial;
use App\Models\SerialNumberBillRecord;
use App\Models\Unit;
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

        $items = Item::with('units')->select('name', 'code', 'flag', 'id', 'category_id')->get();

        return response()->json($items, 200);
    }

    public function all()
    {

        $items = Item::with('units')->get();

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
                'days_before_alert' => $request['days_before_alert'],


            ]);

            $this->saveImage($request, 'photo', 'items', 'upload_image', $item->id, 'App\Models\Item');
            $this->saveUnit($request, $item->id);


            $item->unit = $item->units()->get()->toArray();
            $item->save();

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

        $result = $this->activityParameters($lang, 'store', 'item', $item, null);
        $parameters = $result['parameters'];
        $table = $result['table'];
        $this->callActivityMethod('store', $table, $parameters);

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

        $item = Item::with('units')->find($id);

        return response()->json($item, 200);


//        return  DB::select('Select * from items  ');
//        return  Item::all();
    }

    public function update(UpdateRequest $request, $id)
    {

        $lang = $request->header('lang');
        $old_data = Item::find($id)->toJson();

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
        $result = $this->activityParameters($lang, 'update', 'item', $item, $old_data);
        $parameters = $result['parameters'];
        $table = $result['table'];
        $this->callActivityMethod('update', $table, $parameters);

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
        $lang = app('request')->header('lang');

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
            if ($this->isUseItem($id)) {
                $errors = ['item' => [$this->commonMessage->t(CommonWordsEnum::DELETE_ERROR->name, $lang)]];
        return response()->json(['errors' => $errors], 400);
      }
            $item->delete();
            $result = $this->activityParameters($lang, 'delete', 'item', $item, null);
            $parameters = $result['parameters'];
            $table = $result['table'];
            $this->callActivityMethod('delete', $table, $parameters);
            event(new CategoriesUpdated([...Category::with('items.units')->get()]));
            event(new ItemsUpdated([...Item::with('units')->get()]));
            DB::commit();
            return response()->json([

                'message' => $this->commonMessage->t(CommonWordsEnum::DELETE->name, $lang)
      ], 200);
    } catch (CustomException $exc) {
            DB::rollback();
            $errors = ['message' => [$exc->message]];
            return response()->json(['errors' => $errors], $exc->code);
        }
    }


    public function callGenerateCodes($id)
    {
        return $this->generateCodes($id, Category::class, Item::class, 'category_id');
    }

    public function isUseItem($item_id)
    {
        //item related to barcode
        $barcode = Barcode::where(function ($query) use ($item_id) {
            $query->where('item_id', $item_id);
        })->first();
        if ($barcode != null)
            return true;
//      return ['barcodeId' => $barcode->id, 'table' => 'barcodes'];

        //item related to bill record
        $billRecord = BillRecord::where(function ($query) use ($item_id) {
            $query->where('item_id', $item_id);
        })->first();
        if ($billRecord != null)
            return true;
//      return ['billRecordId' => $billRecord->id, 'table' => 'bill_records'];

        //item related to journalEntryRecord
        $journalEntryRecord = JournalEntryRecord::where(function ($query) use ($item_id) {
            $query->where('item_id', $item_id);
        })->first();
        if ($journalEntryRecord != null)
            return true;
//      return ['journalEntryRecordId' => $journalEntryRecord->id, 'table' => 'journal_entry_records'];

        //item related to quantity
        $quantity = Quantity::where(function ($query) use ($item_id) {
            $query->where('item_id', $item_id);
        })->first();
        if ($quantity != null)
            return true;
//      return ['quantityId' => $quantity->id, 'table' => 'quantities'];

        //item related to serial
        $serial = Serial::where(function ($query) use ($item_id) {
            $query->where('item_id', $item_id);
        })->first();
        if ($serial != null)
            return true;
//      return ['serialId' => $serial->id, 'table' => 'serials'];

        //item related to serialNumberBillRecord
        $serialNumberBillRecord = SerialNumberBillRecord::where(function ($query) use ($item_id) {
            $query->where('item_id', $item_id);
        })->first();
        if ($serialNumberBillRecord != null)
            return true;
//      return ['serialNumberBillRecordId' => $serialNumberBillRecord->id, 'table' => 'serial_number_bill_records'];

        //item related to unit
        $unit = Unit::where(function ($query) use ($item_id) {
            $query->where('item_id', $item_id);
        })->first();
        if ($unit != null)
            return true;
//      return ['unitId' => $unit->id, 'table' => 'units'];

//    return ['id' => null, 'table' => null];
        return false;

    }


}
