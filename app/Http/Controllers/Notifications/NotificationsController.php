<?php

namespace App\Http\Controllers\Notifications;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationsController extends Controller
{

  public function notSeenNotifications()
  {
    $id = auth('sanctum')->user()->id;
    return response(Notification::where('seen', false)->where('to_user_id', $id)->get()->toArray());
  }

  public function registerAsSeen( $user_id , $id)
  {

    $notification = Notification::where('id', $id)->where('to_user_id', $user_id)->first();
    $notification['seen'] = true ;
    $notification->save();
    return response($notification->toArray());

  }

  public function delete($user_id , $id)
  {
    $notification = Notification::where('id', $id)->where('to_user_id', $user_id)->first();
    $notification->seen = false ;
    $notification->save();
    return response($notification->toArray());

//    $user_id = auth('sanctum')->user()->id;
//    $notifications = Notification::where('to_user_id', $user_id)->get();
//    foreach ($notifications as $notification) {
//      $notification->update(['seen' => false]);
//    }
//    return response($notifications->toArray());
  }

}
