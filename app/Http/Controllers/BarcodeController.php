<?php

namespace App\Http\Controllers;

use App\Http\Exceptions\CustomException;
use App\Http\Requests\StoreBarcodeRequest;
use App\Http\Requests\StoreRequest;
use App\Http\Requests\UpdateBarcodeRequest;
use App\Http\Requests\UpdateRequest;
use App\Models\Barcode;
use Lang\Locales\CommonWords;
use Lang\Locales\CommonWordsEnum;
use Lang\Translate;

class BarcodeController extends Controller
{
  public $commonMessage;

  function __construct()
  {
    $this->commonMessage = new Translate(new CommonWords());
  }

  public function index()
  {


    $barcodes = Barcode::whereNull('category_id')->with('children', 'items')->select('id', 'name', 'code', 'category_id', 'flag')->get();;


    return response()->json($barcodes, 200);
  }

  public function store(StoreRequest $request)
  {
    $lang = $request->header('lang');
    if ($result = $this->validateCode($request->code, $lang))
      return $result;

    try {
      $barcode = Barcode::create($request->all());

      return response()->json([

        'message' => $this->commonMessage->t(CommonWordsEnum::STORE->name, $lang),

      'id' => $barcode->id,

    ], 200);

  } catch (CustomException $exc) {
      return response()->json(['message' => $exc->message,], $exc->code);
    }
  }


  public function show($id)
  {

    $barcode = Barcode::find($id);

    return response()->json($barcode, 200);
  }


  public function update(UpdateRequest $request, $id)
  {
    $lang = $request->header('lang');


    $barcode = Barcode::find($id);
    if ($result = $this->validateCode($request->code, $lang))
      return $result;
    if ($result = $this->validateCodeName($id, $request, $lang))
      return $result;
    try {
      $barcode->update($request->all());


      return response()->json([
        'message' => $this->commonMessage->t(CommonWordsEnum::UPDATE->name, $lang)
    ], 200);
  } catch (CustomException $exc) {
      return response()->json(['message' => $exc->message,], $exc->code);
    }
  }


  public function delete($id)
  {
    $lang = app('request')->header('lang');


    $barcode = Barcode::find($id);
    if ($this->numOfSubChilds(Barcode::class, $id, 'barcode_id') > 0) {
      $errors = ['store' => [
        $this->commonMessage->t(CommonWordsEnum::DELETE_ERROR->name, $lang)
      ]];
      return response()->json(['errors' => $errors], 400);
    }
    try {

      $barcode->delete();


      return response()->json([
        'message' => $this->commonMessage->t(CommonWordsEnum::DELETE->name, $lang)  ], 200);
  } catch (CustomException $exc) {
      return response()->json(['message' => $exc->message,], $exc->code);
    }
  }


  public function validateCodeName($id, $request, $lang)
  {
    if ($result = $this->validateDuplicateCode($id, Barcode::class, $request->code, $lang))
      return $result;
    if ($result = $this->validateDuplicateName($id, Barcode::class, $request->name, $lang))
      return $result;

  }
}
