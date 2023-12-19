<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillPermission extends Model
{
    use HasFactory;
    protected $fillable = [
        'name' ,
        'caption_ar',
        'caption_en'
    ];

    public function billTemplatePermissionUser()
    {
        return $this->hasMany(BillTemplatePermissionUser::class, 'bill_template_id');
    }
}
