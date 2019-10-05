<?php

namespace Modules\Sales\Dao\Models;

use Modules\Crm\Dao\Models\Customer;
use Modules\Forwarder\Dao\Models\Vendor;
use Modules\Sales\Dao\Models\OrderDetail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Finance\Dao\Models\Payment;

class Order extends Model
{
  use SoftDeletes;
  protected $table = 'sales_order';
  protected $primaryKey = 'sales_order_id';
  public $detail_table = 'sales_order_detail';
  protected $fillable = [
    'sales_order_id',
    'sales_order_reff',
    'sales_order_delivery',
    'sales_order_invoice',
    'sales_order_date',
    'sales_order_prepare_date',
    'sales_order_delivery_date',
    'sales_order_invoice_date',
    'sales_order_attachment',
    'sales_order_note',
    'sales_order_crm_customer_id',
    'sales_order_forwarder_vendor_id',
    'sales_order_status',
    'sales_order_updated_at',
    'sales_order_created_at',
    'sales_order_updated_by',
    'sales_order_created_by',
  ];

  public $timestamps = true;
  public $incrementing = false;
  public $rules = [
    'sales_order_date' => 'required',
    'sales_order_crm_customer_id' => 'required',
    'sales_order_forwarder_vendor_id' => 'required',
    'temp_id' => 'required',
  ];

  public $prefix = 'SO';
  public $order = 'sales_order_date';

  // public $with = ['detail', 'detail.product'];

  const CREATED_AT = 'sales_order_created_at';
  const UPDATED_AT = 'sales_order_updated_at';
  const DELETED_AT = 'sales_order_deleted_at';

  public $searching = 'sales_order_id';
  public $datatable = [
    'sales_order_id'             => [true => 'ID'],
    'sales_order_date'           => [true => 'Order Date'],
    'crm_customer_name'           => [true => 'Customer Name'],
    'sales_order_status'           => [true => 'Status'],
    'sales_order_created_at'     => [false => 'Created At'],
    'sales_order_created_by'     => [false => 'Updated At'],
  ];

  protected $dates = [
    'sales_order_created_at',
    'sales_order_updated_at',
    'sales_order_date',
    'sales_order_prepare_date',
    'sales_order_delivery_date',
    'sales_order_invoice_date',
  ];

  public $status = [
    '0' => ['CANCEL', 'danger'],
    '1' => ['CREATE', 'warning'],
    '2' => ['PREPARE', 'success'],
    '3' => ['PRODUCTION', 'info'],
    '4' => ['DELIVER', 'primary'],
  ];

  public $custom_message = [
    'sales_order_crm_customer_id.required' => 'Customer Data Require',
    'sales_order_forwarder_vendor_id.required'  => 'Forwarder Vendor Required',
    'temp_id.required'  => 'Data Product Required',
  ];

  public function detail()
  {
    return $this->hasMany(OrderDetail::class, 'sales_order_detail_sales_order_id', 'sales_order_id');
  }

  public function payment()
  {
    return $this->hasMany(Payment::class, 'finance_payment_sales_order_id', 'sales_order_id');
  }

  public function customer()
  {
    return $this->hasOne(Customer::class, 'crm_customer_id', 'sales_order_crm_customer_id');
  }

  public function forwarder()
  {
    return $this->hasOne(Vendor::class, 'forwarder_vendor_id', 'sales_order_forwarder_vendor_id');
  }

  public static function boot()
  {
    parent::boot();
    parent::creating(function ($model) {
      $model->sales_order_created_by = auth()->user()->username;
      $model->sales_order_status = 1;
    });
  }

  public function scopeStatusCreate($query)
  {
    return $query->where('sales_order_status', 1);
  }
}
