<?php

namespace App\Http\Controllers;

use App\Models\VoucherPermissionUser;
use App\Http\Requests\StoreVoucherPermissionUserRequest;
use App\Http\Requests\UpdateVoucherPermissionUserRequest;
use App\Http\Requests\VoucherRequest;
use App\Models\User;
use App\Traits\Voucher\VoucherRecordTrait;
use Laravel\Sanctum\PersonalAccessToken;

class VoucherPermissionUserController extends Controller
{
  use VoucherRecordTrait;

  public function index()
  {

    $voucherPermissionaUser = VoucherPermissionUser::all();

    return response()->json($voucherPermissionaUser, 200);
  }


  public function store(VoucherRequest $request, $voucher_template_id)
  {

    $id = auth('sanctum')->user()->id;
    $oldVoucherPermissionsUser = User::find($id)->voucherPermissionUser;
    if ($oldVoucherPermissionsUser) {
      $oldVoucherPermissionsUser->forceDelete();
    }
    VoucherPermissionUser::create(
      [
        'print_setting' => $request['print_setting'],
        'show_setting' => $request['show_setting'],
        'user_id' => $id,
        'voucher_template_id' => $voucher_template_id
      ]
    );
    return response()->json(['message' => __('common.update'),], 200);
  }
}
