<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\AssetGroup;
use App\Http\Requests\StoreAssetGroupRequest;
use App\Http\Requests\UpdateAssetGroupRequest;
use App\Traits\ActivityLog\ActivityLog;
use App\Traits\Common\CommonTrait;

class AssetGroupController extends Controller
{
    use  ActivityLog, CommonTrait;

    public function index()
    {
        //
    }

    public function store(StoreAssetGroupRequest $request)
    {
      $lang = $request->header('lang');
        if ($result=$this->validateCode($request->code , $lang))
            return  $result;
        $assetGroup = AssetGroup::create($request->all());
        $parameters = ['request' => $request, 'id' =>$assetGroup->id];
        $this->callActivityMethod('asset_groups', 'store', $parameters);
        return response()->json([
            'message' => __('common.store'),
            'id' => $assetGroup->id,
            'asset_group_id' => $assetGroup->asset_group_id,
        ], 200);
    }

    public function show($id)
    {
        $parameters = ['id' => $id];
        $assetGroup = AssetGroup::find($id);
        $this->callActivityMethod('asset_groups', 'show', $parameters);
        return response()->json( $assetGroup, 200);
    }

    public function update(UpdateAssetGroupRequest $request, $id)
    {
      $lang = $request->header('lang');
        $old_data = AssetGroup::find($id)->toJson();
        $parameters = ['request' => $request, 'id' => $id, 'old_data' => $old_data];
        $assetGroup = AssetGroup::find($id);
        if ($result=$this->validateCode($request->code , $lang))
            return  $result;
        if ($result=$this->validateCodeNameAndForignname($id, $request , $lang) )
            return  $result;
        $assetGroup->update($request->all());
        $this->callActivityMethod('asset_groups', 'update', $parameters);
        return response()->json([
            'message' => __('common.update'),
            'id' => $assetGroup->id,
            'asset_group_id' => $assetGroup->asset_group_id,
        ], 200);
    }

    public function delete($id)
    {
        $parameters = ['id' => $id];
        $assetGroup = AssetGroup::find($id);
        if ($this->numOfSubChilds(AssetGroup::class, Asset::class, $id, 'asset_group_id') > 0) {
            $errors = ['message' => [__('common.delete error')]];
            return response()->json(['errors' => $errors], 400);
        }
        $assetGroup->delete();
        $this->callActivityMethod('asset_groups', 'delete', $parameters);
        return response()->json(['message' =>  __('common.delete') ,], 200);
    }

    public function callGenerateCodes($id)
    {
        return $this->generateCodes($id, AssetGroup::class, AssetGroup::class, 'asset_group_id');
    }

    public function validateCodeNameAndForignname($id,$request, $lang)
    {
      if ($result = $this->validateDuplicateCode($id, AssetGroup::class, $request->code , $lang))
        return $result;
      if ($result = $this->validateDuplicateName($id, AssetGroup::class,  $request->name , $lang))
        return $result;
      if ($result = $this->validateDuplicateForeignName($id, AssetGroup::class, $request->foreign_name , $lang))
        return $result;
    }

}
