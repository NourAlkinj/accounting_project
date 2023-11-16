<?php

namespace App\Http\Controllers;

use App\Http\Exceptions\CustomException;
use App\Http\Requests\BillRequest;
use App\Models\BillPermissionUser;
use App\Models\User;
use App\Traits\Bill\BillRecordTrait;
use Lang\Locales\CommonWords;
use Lang\Locales\CommonWordsEnum;
use Lang\Translate;

class BillPermissionUserController extends Controller
{

  use BillRecordTrait;

  public $commonMessage;

  function __construct()
  {
    $this->commonMessage = new Translate(new CommonWords());
  }

  public function index()
  {
    $parameters = ['id' => null];
    $billPermissionaUser = BillPermissionUser::all();
    $this->callActivityMethod('bill_permission_users', 'index', $parameters);
    return response()->json($billPermissionaUser, 200);
  }


  public function store(BillRequest $request, $bill_template_id)
  {
  
    try {
      
      $lang = $request->header('lang');
      $id = auth('sanctum')->user()->id;
      $oldBillPermissionsUser = User::find($id)->billPermissionUser;
      
      if ($oldBillPermissionsUser) {
        $oldBillPermissionsUser->forceDelete();
      }
    
      BillPermissionUser::create(
        [
          'print_setting' => $request['print_setting'],
          'show_setting' => $request['show_setting'],
          'user_id' => $id,
          'bill_template_id' => $bill_template_id
        ]
      );
    
      return response()->json(['message' => $this->commonMessage->t(CommonWordsEnum::STORE->name, $lang) ], 200);
  

    }  catch (CustomException $exc) {

    $id = auth('sanctum')->user()->id;
    $oldBillPermissionsUser = User::find($id)->billPermissionUser;
    if ($oldBillPermissionsUser) {
      $oldBillPermissionsUser->forceDelete();
    }
    BillPermissionUser::create(
      [
        'print_setting' => $request['print_setting'],
        'show_setting' => $request['show_setting'],
        'user_id' => $id,
        'bill_template_id' => $bill_template_id
      ]
    );
    return response()->json(['message' => $this->commonMessage->t(CommonWordsEnum::save->name, $lang) ], 200);
  }
    catch (CustomException $exc) {
      return response()->json(['message' => $exc->message,], $exc->code);

    }

  }

}
