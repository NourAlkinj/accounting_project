<?php

namespace App\Http\Controllers;

use App\Events\ReportTemplatesUpdated;
use App\Http\Requests\StoreReportTemplateRequest;
use App\Http\Requests\UpdateReportTemplateRequest;
use App\Models\ReportTemplate;

use App\Traits\ActivityLog\ActivityLog;
use App\Traits\Common\CommonTrait;
use Illuminate\Http\Request;
use Lang\Locales\CommonWords;
use Lang\Translate;
use Lang\Locales\CommonWordsEnum;


class ReportTemplateController extends Controller
{
  use ActivityLog, CommonTrait;
  public  $commonMessage;

  function __construct()
  {
    $this->commonMessage = new Translate(new CommonWords());
  }

  public function index()
  {

    $AllReportTemplates = ReportTemplate::all();

    return response()->json($AllReportTemplates, 200);
  }

  public function show($id)
  {

    $reportTemplate = ReportTemplate::find($id);

    return response()->json($reportTemplate, 200);
  }

  public function store(StoreReportTemplateRequest $request)
  {
    $lang = $request->header('lang') ;
    $reportTemplate = ReportTemplate::create($request->all());
    $this->saveImage($request, 'photo', 'reports', 'upload_image', $reportTemplate->id, 'App\Models\ReportTemplate');

    $result = $this->activityParameters($lang, 'store', 'reportTemplate', $reportTemplate,     null);
    $parameters = $result['parameters'];
    $table = $result['table'];
    $this->callActivityMethod('store', $table, $parameters);

    event(new ReportTemplatesUpdated([...ReportTemplate::all()]));
    return response()->json([

      'message' => $this->commonMessage->t(CommonWordsEnum::STORE->name, $lang),
      'id' => $reportTemplate->id,
    ], 200);
  }

  public function update(UpdateReportTemplateRequest $request, $id)
  {
    $lang = $request->header('lang') ;
    $old_data = ReportTemplate::find($id)->toJson();

    $reportTemplate = ReportTemplate::find($id);

    if ($request->has('photo')) {
      $this->deleteImage('upload_image', 'reports/' . $reportTemplate->image->file_name, $reportTemplate->id);
    }
    $this->saveImage($request, 'photo', 'reports', 'upload_image', $reportTemplate->id, 'App\Models\ReportTemplate');
    $reportTemplate->update($request->all());
    $result = $this->activityParameters($lang, 'update', 'reportTemplate', $reportTemplate,     $old_data);
    $parameters = $result['parameters'];
    $table = $result['table'];
    $this->callActivityMethod('update', $table, $parameters);
    event(new ReportTemplatesUpdated([...ReportTemplate::all()]));
    return response()->json([

      'message' => $this->commonMessage->t(CommonWordsEnum::UPDATE->name, $lang),
      'id' => $reportTemplate->id,
    ], 200);
  }

  public function delete($id)
  {
    $lang  =   app('request')->header('lang');;

    $reportTemplate = ReportTemplate::find($id);
    if ($reportTemplate->image) {
      $this->deleteImage('upload_image', 'reports/' . $reportTemplate->image->file_name, $reportTemplate->id);
    }
    $reportTemplate->delete();
    $result = $this->activityParameters($lang, 'delete', 'reportTemplate', $reportTemplate,     null);
    $parameters = $result['parameters'];
    $table = $result['table'];
    $this->callActivityMethod('delete', $table, $parameters);
    event(new ReportTemplatesUpdated([...ReportTemplate::all()]));
    return response()->json([
      'message' => $this->commonMessage->t(CommonWordsEnum::DELETE->name, $lang),
    ], 200);
  }

  public function saveImages(Request $request)
  {
    $this->saveImage($request, 'photo', 'reports', 'upload_image', null, null);
  }

  public function all()
  {

    $reportTemplates = ReportTemplate::all();
    return $reportTemplates;
  }
}
