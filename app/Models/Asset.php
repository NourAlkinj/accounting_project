<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    use HasFactory;
    protected $fillable = [
        'code',
        'name',
        'foreign_name',
        'asset_group_id',
//tab1
        'size',
        'model',
        'weight',
        'chasseh_no',
        'country_of',
        'color',
        'barcode',
        'is_serial_number',
       ' is_multi_quantities',
        'photo',
        'notes',
//tab2
        'manufacturer',
        'manufac_address',
        'supplier_company',
        'sup_comp_address',
        'phone1',
        'phone2',
        'fax',
        'email',
        'receiving_notes',

        'manufac_date',
        'contract_no',
        'customs',
        'shipment_no',
        'shipment_method',
        'import_license_no',
        'arrival_place',
        'warranty_no',
        'receipt_date',

        'purchase_date',
        'contract_date',
        'customs_declaration',
        'shipment_date',
        'arrival_date',
        'warranty_begining',
        'warranty_ending',

        //tab3
        'is_not_subject_to_reappraisal',
        'is_not_subject_to_depreciation',
        'depreciation_method',//
        'default_age_value',
        'default_age',//
        'annual_depreciation',
        'begining_data_of',
        'scrap_value',//

        //tab4
        'asset_account_id',
        'depreciation_account_id',
        'accumulated_account_id',
        'expenses_account_id',
        'captial_gains_account_id',
        'captial_losses_account_id',
        'surplus_of_reappraisal_account_id',
        'deficit_of_reappraisal_account_id',
    ];
    protected $hidden =['created_at' , 'updated_at'];

    protected $casts = [
        'is_serial_number'=> 'boolean',
        'is_multi_quantities'=> 'boolean',
        'is_not_subject_to_reappraisal'=> 'boolean',
        'is_not_subject_to_depreciation'=> 'boolean',
    ];
}
