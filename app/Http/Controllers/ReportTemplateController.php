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
    $parameters = ['id' => null];
    $AllReportTemplates = ReportTemplate::all();
    $this->callActivityMethod('report_templates', 'index', $parameters);
    return response()->json($AllReportTemplates, 200);
  }

  public function show($id)
  {
    $parameters = ['id' => $id];
    $reportTemplate = ReportTemplate::find($id);
    $this->callActivityMethod('report_templates', 'show', $parameters);
    return response()->json($reportTemplate, 200);
  }

  public function store(StoreReportTemplateRequest $request)
  {
    $lang = $request->header('lang') ;
    $reportTemplate = ReportTemplate::create($request->all());
    $this->saveImage($request, 'photo', 'reports', 'upload_image', $reportTemplate->id, 'App\Models\ReportTemplate');
    $parameters = ['request' => $request, 'id' => $reportTemplate->id];
    $this->callActivityMethod('report_templates', 'store', $parameters);
    event(new ReportTemplatesUpdated([...ReportTemplate::all()]));
    return response()->json([
//      'message' => __('common.store'),
      'message' => $this->commonMessage->t(CommonWordsEnum::STORE->name, $lang),
      'id' => $reportTemplate->id,
    ], 200);
  }

  public function update(UpdateReportTemplateRequest $request, $id)
  {
    $lang = $request->header('lang') ;
    $old_data = ReportTemplate::find($id)->toJson();
    $parameters = ['request' => $request, 'id' => $id, 'old_data' => $old_data];
    $reportTemplate = ReportTemplate::find($id);

    if ($request->has('photo')) {
      $this->deleteImage('upload_image', 'reports/' . $reportTemplate->image->file_name, $reportTemplate->id);
    }
    $this->saveImage($request, 'photo', 'reports', 'upload_image', $reportTemplate->id, 'App\Models\ReportTemplate');
    $reportTemplate->update($request->all());
    $this->callActivityMethod('report_templates', 'update', $parameters);
    event(new ReportTemplatesUpdated([...ReportTemplate::all()]));
    return response()->json([
//      'message' => __('common.update'),
      'message' => $this->commonMessage->t(CommonWordsEnum::UPDATE->name, $lang),
      'id' => $reportTemplate->id,
    ], 200);
  }

  public function delete($id)
  {
    $lang  =   app('request')->header('lang');;
    $parameters = ['id' => $id];
    $reportTemplate = ReportTemplate::find($id);
    if ($reportTemplate->image) {
      $this->deleteImage('upload_image', 'reports/' . $reportTemplate->image->file_name, $reportTemplate->id);
    }
    $reportTemplate->delete();
    $this->callActivityMethod('report_templates', 'delete', $parameters);
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
    $parameters = ['id' => null];
    $this->callActivityMethod('report_templates', 'allReportTemplates', $parameters);
    $reportTemplates = ReportTemplate::all();
    return $reportTemplates;
  }
}
