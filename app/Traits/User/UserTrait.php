<?php

namespace App\Traits\User;

use App\Models\AssemblyAccount;
use App\Models\DistributedAccount;
use App\Models\JournalEntryPermissionUser;
use App\Models\PermissionGroup;
use App\Models\Setting;
use App\Models\User;
use App\Models\UserSetting;
use App\Traits\Branch\BranchTrait;
use Database\Seeders\PermissionSeeder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;


trait  UserTrait
{
  use HasRoles;

  public function checkUserInformation()
  {
    $id = auth('sanctum')->user()->id;
    $user = User::find($id);
    if ($user && $user->is_active == true) {
//      $user->with('roles', 'permissions')->get();
      $user = User::with('roles', 'permissions')->find($id);
      return response()->json(['User' => $user], 200);
    } else {
      return response()->json(
        ['errors' => ['message' => 'User not found']], 404);
    }
  }

  public function setUserPermissions($user, $request)
  {
    $userPermissions = $user->permission;
    $user->revokePermissionTo($userPermissions);

    $currentPermissions = $request->get('currentPermissions') ? $request->get('currentPermissions') : [];
    foreach ($currentPermissions as $groupPermission)
      foreach ($groupPermission['permissions'] as $permission)
        if ($permission['is_active'] == true)
          $user->givePermissionTo($permission['name']);
  }


  // public function setUserPermissions($user, $request)
  // {
  //     // $userPermissions = $user->permission;
  //     // $user->revokePermissionTo($userPermissions);

  //     $currentPermissions = $request->get('currentPermissions');
  //     foreach ($currentPermissions as $groupPermission)
  //         foreach ($groupPermission['permissions'] as $permission)
  //             // if ($permission['is_active'] == true) {
  //                 $user->syncPermissions($permission['name']);
  //             // }
  //         // dd($user);
  // }


  public function removeAllRolesFromUser($user)
  {
    $rolesNames = $user->getRoleNames();
    foreach ($rolesNames as $roleName)
      $user->removeRole($roleName);
  }

  public function setUserRole($user, $request)
  {
    $roleName = $request->get('role');
    $user->assignRole($roleName);
  }

  //  public function setUserRole($user, $request)
  //  {
  //    $role_id = $request->get('role');
  //    $role_name = Role::find($role_id);
  //    $user->assignRole($role_name);
  //  }

  // public function checkActive($id)
  // {
  //     if ($this->childsCount($id) != 0)
  //         return 1;
  //     return 0;
  // }

  public function CheckAdminPassword(Request $request)
  {
    $admin = User::find(1);
    if ($request->input('password') == $admin->password)
      return 1;
    return 0;
  }

  public function showUserPermissions($id)
  {
    $parameters = ['id' => $id];
    $user = User::find($id);
    $rolesNames = $user->getRoleNames();
    foreach ($rolesNames as $roleName) {
//      $user->removeRole($roleName);
    }
    if ($user) {
      $this->callActivityMethod('users', 'show', $parameters);
      $userGroupPermissions = PermissionGroup::select('caption_' . Config::get('app.locale') . ' as caption', 'id', 'name')->with(['permissions'])->get();
      foreach ($userGroupPermissions as $groups) {
        foreach ($groups->permissions as $permission) {
          if ($user->hasPermissionTo($permission['name'])) {
            $permission->is_active = true;
          } else {
            $permission->is_active = false;
          }
        }
      }
      return $userGroupPermissions;
    }
  }


  //-----------------first time-------------------//
  public function showUserPermissionsBack($id)
  {
    $parameters = ['id' => $id];
    $user = User::find($id);
    $permissions = $user->permissions;
    foreach ($permissions as $permission) {
      $result[] = $permission['name'];
    }
    return $result;
  }

  public function showRolePermissionsBack($id)
  {
    $parameters = ['id' => $id];
    $role = Role::find($id);
    $permissions = $role->permissions;
    foreach ($permissions as $permission) {
      $result[] = $permission['name'];
    }
    return $result;
  }

  //------------------------------------------------//
  public function isActive($id)
  {
    $user = User::find($id);
    return $user->is_active == true;
  }

  public function getRoles()
  {
    return Role::select('id', 'name')->get();
  }

  public function getUserRole($id)
  {
    $user = User::find($id);
    // return $user->roles;
    $result = [];
    $roles = $user->roles;
    foreach ($roles as $role) {
      $result[] = $role->name;
    }
    return $result;
  }

  public function rolePermission($roleId)
  {
    $groupPermissions = PermissionGroup::select('caption_' . Config::get('app.locale') . ' as caption', 'id', 'name')->with(['permissions'])->get();
    $role = Role::find($roleId);

    foreach ($groupPermissions as $groups) {
      foreach ($groups->permissions as $permission) {
        if ($role->hasPermissionTo($permission->name)) {
          $permission->is_active = true;
        } else {
          $permission->is_active = false;
        }
      }
    }
    return $groupPermissions;
  }


  public function setJournalEntryPermissionUser($id)
  {
    $show_setting = [
//      [
//        "columns" => [
//          [
//            "id" => 1,
//            "name" => "delete",
//            "field" => "delete",
//            "label" => "Delete",
//            "align" => "center",
//            "visibility" => true,
//            "bgColor" => ""
//          ],
//          [
//            "id" => 13,
//            "name" => "clear",
//            "field" => "clear",
//            "label" => "Clear",
//            "align" => "center",
//            "visibility" => true,
//            "bgColor" => ""
//          ],
//          [
//            "id" => 2,
//            "name" => "account_id",
//            "field" => "account",
//            "label" => "Account",
//            "align" => "center",
//            "visibility" => true,
//            "bgColor" => ""
//          ], [
//            "id" => 3,
//            "name" => "current_balance",
//            "field" => "current balance",
//            "label" => "Currenct Balance",
//            "align" => "center",
//            "visibility" => true,
//            "bgColor" => ""
//          ], [
//            "id" => 4,
//            "name" => "debit",
//            "field" => "debit",
//            "label" => "Debit",
//            "align" => "center",
//            "visibility" => true,
//            "bgColor" => ""
//          ], [
//            "id" => 5,
//            "name" => "credit",
//            "field" => "credit",
//            "label" => "Credit",
//            "align" => "center",
//            "visibility" => true,
//            "bgColor" => ""
//          ], [
//            "id" => 6,
//            "name" => "notes",
//            "field" => "notes",
//            "label" => "Notes",
//            "align" => "center",
//            "visibility" => true,
//            "bgColor" => ""
//          ], [
//            "id" => 7,
//            "name" => "currency_id",
//            "field" => "currency",
//            "label" => "Currency",
//            "align" => "center",
//            "visibility" => true,
//            "bgColor" => ""
//          ], [
//            "id" => 8,
//            "name" => "parity",
//            "field" => "parity",
//            "label" => "Parity",
//            "align" => "center",
//            "visibility" => true,
//            "bgColor" => ""
//          ], [
//            "id" => 9,
//            "name" => "equivalent",
//            "field" => "equivalent",
//            "label" => "Equivalent",
//            "align" => "center",
//            "visibility" => true,
//            "bgColor" => ""
//          ], [
//            "id" => 10,
//            "name" => "final_balance",
//            "field" => "final balance",
//            "label" => "Final Balance",
//            "align" => "center",
//            "visibility" => true,
//            "bgColor" => ""
//          ], [
//            "id" => 11,
//            "name" => "contra_account_id",
//            "field" => "contra account",
//            "label" => "Contra Account",
//            "align" => "center",
//            "visibility" => true,
//            "bgColor" => ""
//          ], [
//            "id" => 12, "name" => "cost_center_id",
//            "field" => "cost center",
//            "label" => "Cost Center",
//            "align" => "center",
//            "visibility" => true,
//            "bgColor" => ""
//          ]
//        ],
//        "visibleColumns" => [
//          "delete",
//          "clear",
//          "account_id",
//          "current_balance",
//          "debit",
//          "credit",
//          "notes",
//          "currency_id",
//          "parity",
//          "final_balance",
//          "equivalent",
//          "contra_account_id",
//          "cost_center_id"
//        ],
//        "tableSeparatorStyle" => "horizontal",
//        "tablePagination" => [
//          "sortBy" => null,
//          "descending" => false,
//          "page" => 1,
//          "rowsPerPage" => 10
//        ]
//      ],

    ];
    $print_setting = [];
    JournalEntryPermissionUser::create(

      [
        'user_id' => $id,
        'show_setting' => $show_setting,
        'print_setting' => $print_setting,
      ]

    );
  }

  public function setUserHomeSetting($id)
  {


    $setting = Setting::create(
      [
        'settings' => [],
        'user_id' => $id
      ]
    );

    UserSetting::create(
      [
        'setting_id' => $setting->id,
        'user_id' => $id
      ]
    );

  }

  public function Permission()
  {
    $seeder = new PermissionSeeder();
    $seeder->run();
  }


  public function setAllPermissionsToAdmin()
  {
//    $allPermissions = Permission::all();

    $admin = User::where('is_root', true)->first();

    return $admin->permissions;

//    foreach ($allPermissions as $permission) {
//      $admin->givePermissionTo($permission['name']);
//    }
//    return $admin->permissions;
  }
}
