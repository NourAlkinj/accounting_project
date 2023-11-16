<?php

namespace App\Traits\Attachment;


use App\Models\Attachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


trait  AttachmentTrait
{


  public function uploadAttachment(Request $request, $input_name, $folder_name, $attachmentable_type, $attachmentable_id)
  {


    $appUrl = config('app.url');
    $parsedUrl = parse_url($appUrl);
    $scheme = isset($parsedUrl['scheme']) ? $parsedUrl['scheme'] : 'http';
    $domain = isset($parsedUrl['host']) ? $parsedUrl['host'] : 'localhost';
    $port = isset($parsedUrl['port']) ? $parsedUrl['port'] : 8000;

    if ($request->hasFile($input_name)) {

      $attachment = $request->file($input_name);
      $extension = $attachment->getClientOriginalExtension();

      $path = in_array($extension, ['png', 'jpeg', 'jpg']) ? 'images' : 'files';

      $folder_name = $path . '/' . $folder_name;

//      $attachments = $request->file($input_name);
//      $uploadedFiles = [];
//      foreach ($attachments as $attachment) {

      $maxFileSize = 20971520;
      if ($attachment->getSize() > $maxFileSize) {
        return "حجم الملف يجب ألا يتجاوز 20 ميغابايت";
      }

      if (!$attachment->isValid()) {
        return " الملف غير صالح.";
      }

      $file_name = $attachment->getClientOriginalName();
      $src = $scheme . '://' . $domain . ':' . $port . '/storage/' . $folder_name . '/' . $file_name;
      $data = new Attachment();
      $data->file_name = $file_name;
//        $data->attachmentable_type = $attachmentable_type;
      $data->attachmentable_type = $request->type;
      $data->attachmentable_id = $attachmentable_id;
      $data->src = $src;
      $allowedExtensions = ['txt', 'xlx', 'csv', 'xls', 'xlsx', 'pdf', 'docs', 'docx', 'doc', 'jfif', 'png', 'jpeg', 'jpg', 'rar', 'zip'];
      if (in_array($extension, $allowedExtensions)) {
        $data->type = in_array($extension, ['png', 'jpeg', 'jpg']) ? 'Image' : 'file';
        $disk = in_array($extension, ['png', 'jpeg', 'jpg']) ? 'upload_image' : 'upload_file';
      } else {
        return "This Type is not Allowed";
      }
      $data->save();
      $attachment->storeAs($folder_name, $file_name, $disk);

      return response([$attachment], 200);
//        $uploadedFiles[] = $attachment->storeAs($folder_name, $file_name, $disk);
//      }
//      return $uploadedFiles;
    }
  }


  public function uploadManyAttachment(Request $request, $input_name, $folder_name, $attachmentable_type, $attachmentable_id)
  {


    $appUrl = config('app.url');
    $parsedUrl = parse_url($appUrl);
    $scheme = isset($parsedUrl['scheme']) ? $parsedUrl['scheme'] : 'http';
    $domain = isset($parsedUrl['host']) ? $parsedUrl['host'] : 'localhost';
    $port = isset($parsedUrl['port']) ? $parsedUrl['port'] : 8000;

    if ($request->hasFile($input_name)) {
//      $attachment = $request->file($input_name);

      $attachments = $request->file($input_name);

      $uploadedFiles = [];

      foreach ($attachments as $attachment) {

        $extension = $attachment->getClientOriginalExtension();

        $maxFileSize = 20971520;
        if ($attachment->getSize() > $maxFileSize) {
          return ['error' => 'file size should not be more than 20 mega bites'];
        }

        if (!$attachment->isValid()) {
          return ['error' => 'the file is corrupted'];
        }

        $path = in_array($extension, ['png', 'jpeg', 'jpg']) ? 'images' : 'files';
        $folder_name = $path . '/' . $folder_name;


        $file_name = $attachment->getClientOriginalName();
        $src = $scheme . '://' . $domain . ':' . $port . '/storage/' . $folder_name . '/' . $file_name;
        $data = new Attachment();
        $data->file_name = $file_name;

        $data->attachmentable_type = $request->type;
//        $data->attachmentable_type =$attachmentable_type;

        $data->attachmentable_id = $attachmentable_id;
        $data->src = $src;

        $allowedExtensions = ['txt', 'xlx', 'csv', 'xls', 'xlsx', 'pdf', 'docs', 'docx', 'doc', 'jfif', 'png', 'jpeg', 'jpg', 'rar', 'zip'];
        if (in_array($extension, $allowedExtensions)) {
          $data->type = in_array($extension, ['png', 'jpeg', 'jpg']) ? 'image' : 'file';
          $disk = in_array($extension, ['png', 'jpeg', 'jpg']) ? 'upload_image' : 'upload_file';
        } else {
          return ['error' => 'This Type is not Allowed'];
        }
        $data->extension = $extension;
        $data->color = $data->type == 'file' ? 'blue' : 'orange';
        $data->title = 'attachment';

        $data->save();
        $uploadedFiles [] = [

          'src' => $scheme . '://' . $domain . ':' . $port . '/storage/' . $attachment->storeAs($folder_name, $file_name, $disk),
          'title' => 'attachment',
          'file_name' => $file_name,
          'type' => $data->type,
          'color' => $data->type == 'file' ? 'blue' : 'orange',
          'extension' => $extension,
          'id' => $data->id

        ];

      }

      return ['attachments' => $uploadedFiles];

    }

  }


  public function deleteAttachment($disk, $path, $id)
  {
//    File::delete(public_path($path));
    Storage::disk($disk)->delete($path);
    Attachment::where('attachmentable_id', $id)->delete();
  }



  public function folder($folder_name)
  {
    return response(['folder'=> $folder_name, 'attachments' => Attachment::where('attachmentable_type', $folder_name)->get()], 200);
  }


}
