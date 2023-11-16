<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Http\Requests\StoreAssetRequest;
use App\Http\Requests\UpdateAssetRequest;
use App\Models\AssetGroup;
use App\Traits\ActivityLog\ActivityLog;
use App\Traits\Common\CommonTrait;

class AssetController extends Controller
{
    use  ActivityLog, CommonTrait;

    public function index()
    {
        //
    }

    public function store(StoreAssetRequest $request)
    {
         $lang = $request->header('lang');
        if ($result=$this->validateCode($request->code , $lang))
            return  $result;
        $asset = Asset::create($request->all());
        $parameters = ['request' => $request, 'id' =>$asset->id];
        $this->callActivityMethod('assets', 'store', $parameters);
        return response()->json([
            'message' => __('common.store'),
            'id' => $asset->id,
            'asset_group_id' => $asset->asset_group_id,
        ], 200);
    }

    public function show($id)
    {
        $parameters = ['id' => $id];
        $asset = Asset::find($id);
        $this->callActivityMethod('assets', 'show', $parameters);
        return response()->json( $asset, 200);
    }

    public function update(UpdateAssetRequest $request,$id)
    {
      $lang = $request->header('lang');
        $old_data = Asset::find($id)->toJson();
        $parameters = ['request' => $request, 'id' => $id, 'old_data' => $old_data];
        $asset = Asset::find($id);
        if ($result=$this->validateCode($request->code , $lang  ))
            return  $result;
        if ($result=$this->validateCodeNameAndForignname($id, $request , $lang) )
            return  $result;
        $asset->update($request->all());
        $this->callActivityMethod('assets', 'update', $parameters);
        return response()->json([
            'message' => __('common.update'),
            'id' => $asset->id,
            'asset_group_id' => $asset->asset_group_id,
        ], 200);
    }

    public function delete($id)
    {
        $parameters = ['id' => $id];
        $asset = Asset::find($id);
        $asset->delete();
        $this->callActivityMethod('assets', 'delete', $parameters);
        return response()->json(['message' =>  __('common.delete')], 200);

    }

    public function callGenerateCodes($id)
    {
        return $this->generateCodes($id, AssetGroup::class, Asset::class, 'asset_group_id');
    }

    public function validateCodeNameAndForignname($id,$request , $lang)
    {
      if ($result = $this->validateDuplicateCode($id, Asset::class, $request->code , $lang))
        return $result;
      if ($result = $this->validateDuplicateName($id, Asset::class,  $request->name , $lang))
        return $result;
      if ($result = $this->validateDuplicateForeignName($id, Asset::class, $request->foreign_name , $lang))
        return $result;
    }
}
