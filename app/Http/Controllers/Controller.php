<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\CostCenter;
use App\Models\Store;
use App\Traits\Attachment\AttachmentTrait;
use App\Traits\Common\CommonTrait;
use App\Traits\Image\ImageTrait;
use App\Traits\Item\ItemTrait;
use App\Traits\Task\TaskTrait;
use Database\Seeders\PerformanceSeeder;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
  use AuthorizesRequests, DispatchesJobs, ValidatesRequests, CommonTrait  , ImageTrait, AttachmentTrait;

  public function saveImages(Request $request)
  {

    $this->saveImage($request, 'photo', 'Commons', 'upload_image', null, null);

  }

  public function uploadAttachmentss(Request $request)
  {

    return $this->uploadAttachment($request, 'attachment', $request->type, $request->type,null);

  }

  public function uploadManyAttachments(Request $request)
  {

    return response($this->uploadManyAttachment($request , 'attachments', $request->type, $request->type , null), 200);

  }




  public function performanceSeeder()
  {
    $seeder = new PerformanceSeeder();
    $seeder->run();
//    return $this->index();
  }


  public function initialize()
  {
    $all_leaf_stores =  $this->getAllLeafModelsWithCondition(Store::class, 'store_id', 'is_normal', true);
    $all_leaf_accounts =    $this->getAllLeafModelsWithCondition(Account::class, 'account_id', 'is_normal', true);
    $all_leaf_cost_centers =   $this->getAllLeafModelsWithCondition(CostCenter::class, 'cost_center_id', 'is_normal', true);
    $data = [
      'leafNormalStores' => $all_leaf_stores,
      'leafNormalAccounts' => $all_leaf_accounts,
      'leafNormalCostCenters' => $all_leaf_cost_centers,
    ];
    return response()->json($data, 200);
  }

}
