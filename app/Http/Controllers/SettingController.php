<?php

namespace App\Http\Controllers;

use App\Http\Requests\SettingRequest;
use App\Models\AppSetting;
use App\Models\ReportSetting;
use App\Models\Setting;
use App\Models\UserSetting;
use App\Traits\ActivityLog\ActivityLog;
use App\Traits\Common\CommonTrait;
use Lang\Locales\CommonWords;
use Lang\Locales\CommonWordsEnum;
use Lang\Translate;


class SettingController extends Controller
{

    use ActivityLog, CommonTrait;

    public $commonMessage;

    function __construct()
    {
        $this->commonMessage = new Translate(new CommonWords());
    }


    public function update(SettingRequest $request, $id)
    {
        try {
            $user_id = auth('sanctum')->user()->id;
            $lang = $request->header('lang');
            UserSetting::where('setting_id', $id)->delete();
            $setting = Setting::find($id);
            $setting->update(
                [
                    'settings' => $request['settings'],
                    'user_id' => $user_id,
                ]
            );
            UserSetting::create(
                [
                    'setting_id' => $setting->id,
                    'user_id' => $user_id
                ]
            );
            return response()->json([
                'message' => $this->commonMessage->t(CommonWordsEnum::UPDATE->name, $lang) ,
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

    public function show($id)
    {

        $setting = Setting::find($id);

        return response()->json($setting, 200);
    }


    public function store(SettingRequest $request)
    {
        try {
            $lang = $request->header('lang');
            $user = auth('sanctum')->user();
            if ($user->homeSetting) {
                foreach ($user->homeSetting as $homeSetting) {
                    $homeSetting->delete();
                }
            }

            $setting = Setting::create(
                [
                    'settings' => $request->settings,
                    'user_id' => $user->id
                ]
            );
            UserSetting::create(
                [
                    'setting_id' => $setting->id,
                    'user_id' => $user->id
                ]
            );


            return response()->json([
                'message' => $this->commonMessage->t(CommonWordsEnum::save->name, $lang),

      'id' => $setting->id,
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

    public function delete($id)
    {
        try {
            $lang = app('request')->header('lang');

            $setting = Setting::find($id);
            $setting->delete();

            return response()->json(['message' =>

                $this->commonMessage->t(CommonWordsEnum::DELETE->name, $lang)
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


    // App Settings //
    public function saveAppSettings(SettingRequest $request)
    {
        try {
            $lang = $request->header('lang');
            $user = auth('sanctum')->user();
            if ($user->homeSetting) {
                foreach ($user->homeSetting as $homeSetting) {
                    $homeSetting->delete();
                }
            }
            $setting = AppSetting::create(
                [
                    'settings' => $request->settings,
                    'user_id' => $user->id
                ]
            );

            return response()->json([
                'message' => $this->commonMessage->t(CommonWordsEnum::save->name, $lang),
        'id' => $setting->id,
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

    public function saveReportSettings(SettingRequest $request)
    {
        try {
            $lang = $request->header('lang');
            $user = auth('sanctum')->user();
            if ($user->homeSetting) {
                foreach ($user->homeSetting as $homeSetting) {
                    $homeSetting->delete();
                }
            }
            $setting = ReportSetting::create(
                [
                    'settings' => $request->settings,
                    'user_id' => $user->id
                ]
            );

            return response()->json([
                'message' => $this->commonMessage->t(CommonWordsEnum::save->name, $lang),
        'id' => $setting->id,
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


//  public function updateReportSetting(SettingRequest $request, $id)
//  {
//    try {
//      $user = auth('sanctum')->user();
//      $lang = $request->header('lang');
//      $setting = ReportSetting::find($id);
//      $setting->update(
//        [
//          'settings' => $request['settings'],
//          'user_id' => $user->id,
//        ]
//      );
//      return response()->json([
//        'message' => $this->commonMessage->t(CommonWordsEnum::UPDATE->name, $lang) ,
//    ], 200);
//  } catch (CustomException $exc) {
//      return response()->json(
//        [
//          'errors' => ['message' => [$exc->message]]
//        ],
//        $exc->code
//      );
//    }
//  }
//
//
//
//  public function updateAppSetting(SettingRequest $request, $id)
//  {
//    try {
//      $user = auth('sanctum')->user();
//      $lang = $request->header('lang');
//      $setting = AppSetting::find($id);
//      $setting->update(
//        [
//          'settings' => $request['settings'],
//          'user_id' => $user->id,
//        ]
//      );
//      return response()->json([
//        'message' => $this->commonMessage->t(CommonWordsEnum::UPDATE->name, $lang) ,
//    ], 200);
//  } catch (CustomException $exc) {
//      return response()->json(
//        [
//          'errors' => ['message' => [$exc->message]]
//        ],
//        $exc->code
//      );
//    }
//  }

}
