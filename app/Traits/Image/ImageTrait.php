<?php

namespace App\Traits\Image;


use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


trait  ImageTrait
{
  public function saveImage(Request $request, $input_name, $folder_name, $disk, $imageable_id, $imageable_type)
  {

    if ($request->hasFile($input_name)) {
      if (!$request->file($input_name)->isValid()) {
        flash('Invalid Image!')->error()->important();
      }
      $photo = $request->file($input_name);
      if ($request->name) {
        $name = \Str::slug($request->input('name'));
      }
      else{
        $name =Str::random(30) ;
      }
      $file_name = $name . '.' . $photo->getClientOriginalExtension();
      $Image = new Image();
      $Image->file_name = $file_name;
      $Image->imageable_id = $imageable_id;
      $Image->imageable_type = $imageable_type;
      $Image->save();
      return $request->file($input_name)->storeAs($folder_name, $file_name, $disk);
    }
    return null;
  }



  public function deleteImage($disk, $path, $id)
  {
    Storage::disk($disk)->delete($path);
    image::where('imageable_id', $id)->delete();
  }



















//    public $public_path = "/public/Image/users";
//    public $storage_path = "/storage/Image/users";
//
//    public function getImageURL(Request $request)
//    {
//        if ($file = $request->file('profile_photo_path')) {
//            $path = 'photos/users';
//            $url = $this->saveImage($file, $path, 300, 400);
//        }
//    }
//
//    public function saveImage($file, $path, $width, $height): string
//    {
//        if ($file) {
//            $extension = $file->getClientOriginalExtension();
//            $file_name = $path . '-' . Str::random(30) . '.' . $extension;
//            $url = $file->storeAs($this->public_path, $file_name);
//            $public_path = public_path($this->storage_path . $file_name);
//            $img = Image::make($public_path)->resize($width, $height);
//            $url = preg_replace("/public/", "", $url);
//            return $img->save($public_path) ? $url : '';
//        }
//    }


//
//    public function testShowUserImage(){
//        return Inertia::render('BranchAndUser/Index',[
//            'user' => User::all()->map([function($user){
//                return [
//                    'name' =>$user->name,
//                    'image'=>asset('storage/'.$user->image)];
//            }])
//        ]);
//
//    }
//    public function testStoreUserImage(){
//        $image= Request::file('image')->store('users','public');
//        User::create([
//            'image' =>$image
//        ]);
//
//    }

}
