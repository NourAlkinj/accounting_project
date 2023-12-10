<?php

use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
  return (int)$user->id === (int)$id;
});

Broadcast::channel('public.user', function ($user) {
  return true;
});



Broadcast::channel('public.branchesGuide', function ($branches) {
    return true;
});




Broadcast::channel('public.categoriesGuide', function ($categories) {
    return true;
});




Broadcast::channel('public.item', function ($item) {
  return true;
});


Broadcast::channel('public.department', function ($department) {
  return true;
});
Broadcast::channel('public.employee', function ($employee) {
  return true;
});


Broadcast::channel('public.branch', function ($branch) {
  return true;
});

Broadcast::channel('public.bill_template', function ($bill_templates) {
  return true;
});


Broadcast::channel('public.category', function ($categories) {
  return true;
});



Broadcast::channel('public.client', function ($clients) {
  return true;
});


Broadcast::channel('public.account', function ($account) {
  return true;
});

Broadcast::channel('public.currency', function ($currency) {
  return true;
});

Broadcast::channel('public.voucher-template', function ($currency) {
  return true;
});
//Broadcast::channel('public.permissions', function ($permission) {
//  return true;
//});


Broadcast::channel('user.{id}', function ($user, $id) {
  return $user->id === (int)$id;
});

Broadcast::channel('InformationUser.{id}', function ($user, $id) {
  return $user->id === (int)$id;
});

Broadcast::channel('public.report_templates', function ($report_templates) {
  return true;
});

Broadcast::channel('public.task', function ($tasks) {
  return true;
});


Broadcast::channel('notifications.{id}', function ($user, $id) {
  return $user->id === (int)$id;
});

Broadcast::channel('public.cost-center', function ($costCenters) {
  return true;
});
//Broadcast::channel('UserDeleted.{id}', function ($user, $id) {
//  return $user->id === (int) $id;
//});
