<?php

namespace App\Http\Controllers;

use App\Traits\Attachment\AttachmentTrait;
use App\Traits\Common\CommonTrait;
use App\Traits\Image\ImageTrait;
use Illuminate\Http\Request;

class AttachmentController extends Controller
{
  use AttachmentTrait  ,CommonTrait  , ImageTrait;
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
}
