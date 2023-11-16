<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Config;


class PermissionGroup extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'caption_ar', 'caption_en'];
    protected $hidden = ['created_at', 'updated_at'];

    public function permissions()
    {
        return $this->hasMany(Permission::class, 'permission_group_id')->select('name', 'caption_' . Config::get('app.locale') . ' as caption', 'permission_group_id');
    }
}
