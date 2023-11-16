<?php

namespace App\Http\Controllers;

use App\Models\Quantity;
use App\Http\Requests\StoreQuantityRequest;
use App\Http\Requests\UpdateQuantityRequest;
use Illuminate\Support\Facades\Request;

class QuantityController extends Controller
{

  public function index()
  {
    $parameters = ['id' => null];
    $quantities = Quantity::all();
    $this->callActivityMethod('quantities', 'index', $parameters);
    return response()->json($quantities, 200);
  }

  public function store(StoreQuantityRequest $request)
  {

    $quantity = Quantity::create($request->all());
    $parameters = ['request' => $request, 'id' => $quantity->id];
    $this->callActivityMethod('quantities', 'store', $parameters);
    return response()->json([
      'message' => __('common.store'),
      'id' => $quantity->id,

    ], 200);
  }


  public function show($id)
  {
    $parameters = ['id' => $id];
    $quantity = Quantity::find($id);
    $this->callActivityMethod('quantity', 'show', $parameters);
    return response()->json($quantity, 200);
  }


  public function update(UpdateQuantityRequest $request, $id)
  {
    $old_data = Quantity::find($id)->toJson();
    $parameters = ['request' => $request, 'id' => $id, 'old_data' => $old_data];
    $quantity = Quantity::find($id);

    $quantity->update($request->all());
    $this->callActivityMethod('quantities', 'update', $parameters);
    $data = __('common.update');
    return response()->json([
      'message' => $data,

      'id' => $quantity->id
    ], 200);
  }

  public function delete($id)
  {
    $lang  =   app('request')->header('lang');
    $parameters = ['id' => $id];
    $quantity = Quantity::find($id);
    $quantity->delete();
    $this->callActivityMethod('quantities', 'delete', $parameters);
    return response()->json(['message' => __('common.delete')], 200);
  }


}
