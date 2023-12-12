<?php

namespace App\Traits\Unit;

use App\Http\Requests\StoreRequest;
use App\Http\Requests\UpdateRequest;
use App\Models\Barcode;
use App\Models\Item;
use App\Models\Unit;
use Illuminate\Http\Request;


trait  UnitTrait
{

    public function getItemUnits($id)
    {
        return Item::with('units')->get();
    }

    public function getUnitItem($id)
    {

        return Unit::with('item')->find($id);
    }

    public function getUnitBarcodes($id)
    {

        return Unit::with('barcodes')->find($id);
    }

    public function getItemUnitsBarcodes($id)
    {
        return Unit::with('barcodes')->where('item_id', $id)->get();
    }

    public function getAllItemUnitsBarcodes()
    {
        return Item::with('units.barcodes')->get();
    }


    public function setDefaultUnit($request)
    {

        $unit = Unit::where('name', $request->name)->get();

        return $unit->is_default = true;
    }


    public function saveUnit(StoreRequest $request, $itemId)
    {

        $itemUnit = Item::find($itemId)->units;
        if ($itemUnit) {
            foreach ($itemUnit as $unit) {
                $unit->delete();
            }
        }
        $units = $request->units;
        // return count($units);
        foreach ($units as $unit) {
            if ($unit['used'] == true) {
                $newUnit = Unit::create([
                    'unit_name' => $unit['unit_name'],
                    'unit_foreign_name' => $unit['unit_foreign_name'],
                    'is_default' => $unit['is_default'],
                    'item_id' => $itemId,

                    'relative_unit' => $unit['relative_unit'],
                    'unit_number' => $unit['unit_number'],
                    'conversion_factor' => $unit['conversion_factor'],
                    'prices' => $unit['prices'],
                ]);
                $this->saveUnitBarcodes($newUnit->id, $itemId, $unit['barcodes']);
            }
        }
    }

    public function saveUnitBarcodes($id, $itemId, $barcodes)
    {

        foreach ($barcodes as $barcode) {
            $barcode = Barcode::create([
                'item_id' => $itemId,
                'unit_id' => $id,
                'barcode_name' => $barcode['barcode_name'],
                'notes' => $barcode['notes']
            ]);
        }
    }

    public function updateUnit(UpdateRequest $request, $itemId)
    {

        $itemUnits = Item::find($itemId)->units;
        foreach ($itemUnits as $itemUnit) {
            foreach ($itemUnits as $itemUnit) {
                $barcodes = $itemUnit['barcodes'];
                foreach ($barcodes as $barcode) {
                    $barcode->delete();
                }
                $itemUnit->delete();
            }
        }
        $units = $request->units;
        foreach ($units as $unit) {
            if ($unit['used'] == true) {
                $newUnit = Unit::create([
                    'unit_name' => $unit['unit_name'],
                    'unit_foreign_name' => $unit['unit_foreign_name'],
                    'is_default' => $unit['is_default'],
                    'item_id' => $itemId,

                    'unit_number' => $unit['unit_number'],
                    'relative_unit' => $unit['relative_unit'],
                    'conversion_factor' => $unit['conversion_factor'],
                    'prices' => $unit['prices'],
                ]);

                $this->saveUnitBarcodes($newUnit->id, $itemId, $unit['barcodes']);
            }
        }
    }

    public function getItemByIdOrBarcode(Request $request)
    {
        $item = Item::where('name', $request->item_name)->first();
        if ($item) {
            $item = $item->id;
        } else {
            $unit = Unit::whereHas('barcodes', function ($query) use ($request) {
                $query->where('barcode_name', $request->barcode_name);
            })->first();
            $item = $unit['item_id'];
        }
        return $item;
    }


}
