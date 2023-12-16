<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'code',
        'name',
        'email',
        'foreign_name',
        'password',
        'role_id', // الصفة
        'branch_id',
        'first_name',
        'middle_name',
        'last_name',
        'phone',
        'mobile',
        'address',
        'id_number',
        'profile_photo_path',
        'notes',
        // 'account-box_id',
        // 'store_id',
        'is_active',
        'national_number',
        'flag',
        'is_root',
        'password',
        'photo',
        'security_level'

    ];
    protected $hidden = [
        'pivot',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
        'profile_photo_url',
    ];
    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_root' => 'boolean',
        'is_active' => 'boolean',
        'databases' => 'array'
    ];
    protected $appends = [
        'profile_photo_url',
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id')->select('code', 'name', 'branch_id');
    }

    public function journalEntryPermissionUser()
    {
        return $this->hasOne(JournalEntryPermissionUser::class, 'user_id');
    }

    public function voucherPermissionUser()
    {
        return $this->hasOne(VoucherPermissionUser::class, 'user_id');
    }

    public function billPermissionUser()
    {
        return $this->hasOne(BillPermissionUser::class, 'user_id');
    }

//    public function returnedBillPermissionUser()
//    {
//        return $this->hasOne(ReturnedBillPermissionUSer::class, 'user_id');
//    }

    public function homeSetting()
    {
        return $this->belongsToMany(Setting::class, 'user_settings', 'user_id', 'setting_id');
    }

    public function appSetting()
    {
        return $this->hasOne(AppSetting::class, 'user_id');
    }

    public function reportSetting()
    {
        return $this->hasOne(ReportSetting::class, 'user_id');
    }

    public function voucherTemplatePermissionUSer()
    {
        return $this->hasMany(VoucherTemplatePermissionUser::class, 'user_id');
    }

    public function billTemplatePermissionUSer()
    {
        return $this->hasMany(BillTemplatePermissionUser::class, 'user_id');
    }
//  public function attachments()
//  {
//    return $this->morphMany(Attachment::class, 'attachmentable');
//  }

    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }
}
