<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code',
        'name_th',
        'name_en',
        'tax_code',
        'tel',
        'fax',
        'zip_code',
        'province',
        'district',
        'sub_district',
        'address',
        'juristic_manager_name_th',
        'juristic_manager_name_en',
        'project_manager_name_th',
        'project_manager_name_en',
        'accounting_manager_name_th',
        'accounting_manager_name_en',
        'is_active',
        'created_by',
        'updated_by'
    ];
}
