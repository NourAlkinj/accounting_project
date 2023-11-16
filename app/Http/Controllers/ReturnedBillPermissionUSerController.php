<?php

namespace App\Http\Controllers;

use App\Http\Exceptions\CustomException;
use App\Http\Requests\ReturnedBillRequest;
use App\Models\ReturnedBillPermissionUSer;
use App\Models\User;
use App\Traits\Bill\ReturnedBillRecordTrait;
use Lang\Locales\CommonWords;
use Lang\Locales\CommonWordsEnum;
use Lang\Translate;


class ReturnedBillPermissionUSerController extends Controller
{
  use  ReturnedBillRecordTrait;

  public $commonMessage;

  function __construct()
  {
    $this->commonMessage = new Translate(new CommonWords());
  }

  public function index()
  {
    $parameters = ['id' => null];
    $billPermissionaUser = ReturnedBillPermissionUser::all();
    return response()->json($billPermissionaUser, 200);
  }


  public function store(ReturnedBillRequest $request, $bill_template_id)
  {
    try {
      $lang = $request->header('lang');
      $user_id = auth('sanctum')->user()->id;
      $oldBillPermissionsUser = User::find($user_id)->returnedBillPermissionUser;
      if ($oldBillPermissionsUser) {
        $oldBillPermissionsUser->forceDelete();
      }
      ReturnedBillPermissionUSer::create(
        [
          'print_setting' => $request['print_setting'],
          'show_setting' => $request['show_setting'],
          'user_id' => $user_id,
          'bill_template_id' => $bill_template_id
        ]
      );
      return response()->json(['message' =>
//      __('common.update')
        $this->commonMessage->t(CommonWordsEnum::STORE->name, $lang),
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
}
