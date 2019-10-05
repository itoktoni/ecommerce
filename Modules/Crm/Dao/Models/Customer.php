<?php

namespace Modules\Crm\Dao\Models;

use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
  protected $table = 'crm_customer';
  protected $primaryKey = 'crm_customer_id';
  protected $fillable = [
    'crm_customer_id',
    'crm_customer_name',
    'crm_customer_description',
    'crm_customer_created_at',
    'crm_customer_created_by',
  ];

  public $timestamps = true;
  public $incrementing = true;
  public $rules = [
    'crm_customer_name' => 'required|min:3',
  ];

  const CREATED_AT = 'crm_customer_created_at';
  const UPDATED_AT = 'crm_customer_created_by';

  public $searching = 'crm_customer_name';
  public $datatable = [
    'crm_customer_id'          => [false => 'ID'],
    'crm_customer_name'        => [true => 'Name'],
    'crm_customer_description' => [true => 'Description'],
    'crm_customer_created_at'  => [false => 'Created At'],
    'crm_customer_created_by'  => [false => 'Updated At'],
  ];

  public $status = [
    '1' => ['Active', 'primary'],
    '0' => ['Not Active', 'danger'],
  ];

  public static function boot(){
    parent::boot();

    parent::saving(function($model){
      if(Cache::has($model->getTable().'_api')){
        Cache::forget($model->getTable() . '_api');
      }
    });
  }
}
