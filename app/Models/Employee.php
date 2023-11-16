<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
  use HasFactory;
  protected $fillable = [
    'code',
    'name',
    'foreign_name',
    'department_id',
    'user_id' ,

    //first tab personal information
    //general
    'father_name',
    'mother_name',
    'gender',
    'nationality',
    'birth_place',
    'birth_date',
    'blood_type',
    'id_card_no',
    'id_card_issued_by',
    'diagnostics',
    'registration_no',
    'is_smoker',
    //family information
    'marital_status',
    'children_no',
    'partner_name',
    'partner_work',
    'father_work',
    'mother_work',
    //contact information
    'telephone',
    'mobile1',
    'mobile2',
    'email',
    'address',
    //
    'photo',
    'notes',

    //second tab certificates and skills
    //education
    'education_level',
    'specialization',
    'degree',
    'issued_by',
    'issued_date',
    //other certificates
    'certificate1',
    'date1',
    'certificate2',
    'date2',
    'certificate3',
    'date3',
    //previous work
    'work',
    'leave_reason',
    'leave_date',
    //skills
    'skill1',
    'skill2',
    'skill3',
    'skill4',
    'skill5',
    'skill6',

    //third tab identity cards
    'passport_number',
    'passport_issued_by',
    'passport_issued_date',
    'passport_expired_date',
    //driver license
    'driver_license_number',
    'driver_license_issued_by',
    'driver_license_issued_date',
    'driver_license_expired_date',
    //residence
    'residence_number',
    'residence_issued_by',
    'residence_issued_date',
    'residence_expired_date',
    //health insurance
    'health_insurance_number',
    'health_insurance_company',
    'health_insurance_type',
    'health_insurance_issued_by',
    'health_insurance_issued_date',
    //visa
    'visa_munber',
    'visa_entry_port',
    'visa_issued_by',
    'visa_issued_date',
    'visa_expired_date',
    'visa_entry_date',

    'flag',
    'is_root'


  ];
  
  protected $casts = [
    'is_smoker',
    'is_root'
  ];


  public function department()
  {
    return $this->belongsTo(Department::class, 'department_id')->select('id', 'department_id', 'code', 'name');
  }
  public function tasks()
  {
    return $this->belongsToMany(Task::class, 'employee_tasks', 'employee_id', 'task_id');
  }
  public function user()
  {
    return $this->belongsTo(User::class, 'user_id')->select('id', 'user_id', 'code', 'name');
  }

}
