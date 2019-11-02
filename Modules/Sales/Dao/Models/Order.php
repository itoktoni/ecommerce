<?php

namespace Modules\Sales\Dao\Models;

use Plugin\Helper;
use Illuminate\Support\Facades\Auth;
use Modules\Crm\Dao\Models\Customer;
use Illuminate\Database\Eloquent\Model;
use Modules\Finance\Dao\Models\Payment;
use Modules\Forwarder\Dao\Models\Vendor;
use Modules\Sales\Dao\Models\OrderDetail;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
  use SoftDeletes;
  protected $table = 'sales_order';
  protected $primaryKey = 'sales_order_id';
  public $detail_table = 'sales_order_detail';
  protected $fillable = [
    'sales_order_id',
    'sales_order_reff',
    'sales_order_email',
    'sales_order_delivery',
    'sales_order_invoice',
    'sales_order_date',
    'sales_order_prepare_date',
    'sales_order_delivery_date',
    'sales_order_marketing_promo_code',
    'sales_order_marketing_promo_name',
    'sales_order_marketing_promo_value',
    'sales_order_total',
    'sales_order_invoice_date',
    'sales_order_attachment',
    'sales_order_note',
    'sales_order_status',
    'sales_order_updated_at',
    'sales_order_created_at',
    'sales_order_updated_by',
    'sales_order_created_by',
    'sales_order_crm_customer_id',
    'sales_order_deleted_at',
    'sales_order_rajaongkir_province_id',
    'sales_order_rajaongkir_city_id',
    'sales_order_rajaongkir_location',
    'sales_order_rajaongkir_courier',
    'sales_order_rajaongkir_expedition',
    'sales_order_rajaongkir_ongkir',
    'sales_order_rajaongkir_service',
    'sales_order_rajaongkir_address',
    'sales_order_rajaongkir_postcode',
    'sales_order_rajaongkir_name',
    'sales_order_rajaongkir_phone',
    'sales_order_rajaongkir_notes',
    'sales_order_rajaongkir_weight',
  ];

  public $timestamps = true;
  public $incrementing = false;
  public $rules = [
    'sales_order_rajaongkir_province_id' => 'required',
    'sales_order_rajaongkir_city_id' => 'required',
    'sales_order_rajaongkir_location' => 'required',
    'sales_order_rajaongkir_courier' => 'required',
    'sales_order_rajaongkir_ongkir' => 'required|numeric',
    'sales_order_rajaongkir_address' => 'required',
    'sales_order_email' => 'required|email',
    'sales_order_rajaongkir_name' => 'required',
    'sales_order_rajaongkir_phone' => 'required',
    'sales_order_rajaongkir_weight' => 'required',
  ];

  public $validate = true;

  public $prefix = 'SO';
  public $order = 'sales_order_date';

  // public $with = ['detail', 'detail.product'];

  const CREATED_AT = 'sales_order_created_at';
  const UPDATED_AT = 'sales_order_updated_at';
  const DELETED_AT = 'sales_order_deleted_at';

  public $searching = 'sales_order_id';
  public $datatable = [
    'sales_order_id'                  => [true => 'ID'],
    'sales_order_date'                => [true => 'Order Date'],
    'sales_order_rajaongkir_name'     => [true => 'Name'],
    'sales_order_email'               => [false => 'Email'],
    'crm_customer_name'               => [false => 'Customer Name'],
    'sales_order_rajaongkir_phone'  => [true => 'Phone'],
    'sales_order_rajaongkir_weight'  => [false => 'Weight'],
    'sales_order_rajaongkir_courier'  => [false => 'Courier'],
    'sales_order_rajaongkir_service'  => [true => 'Ongkir'],
    'sales_order_total'               => [true => 'Total'],
    'sales_order_status'              => [true => 'Status'],
    'sales_order_created_at'          => [false => 'Created At'],
    'sales_order_created_by'          => [false => 'Updated At'],
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

  public $custom_attribute = [

    'sales_order_rajaongkir_province_id' => 'Province',
    'sales_order_rajaongkir_city_id' => 'City',
    'sales_order_rajaongkir_location' => 'Location',
    'sales_order_rajaongkir_courier' => 'Courier',
    'sales_order_rajaongkir_ongkir' => 'Ongkir',
    'sales_order_rajaongkir_address' => 'Address',
    'sales_order_rajaongkir_postcode' => 'Postcode',
    'sales_order_rajaongkir_phone' => 'Phone',

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

      if (Auth::check()) {
        $model->sales_order_created_by = auth()->user()->username;
      } else {

        $model->sales_order_created_by = 'no login';
      }

      if (!request()->has('sales_order_crm_customer_id')) {
        $model->sales_order_crm_customer_id = 0;
      }

      if (!request()->has('sales_order_date')) {
        $model->sales_order_date = date('Y-m-d');
      }

      $model->sales_order_status = 1;
      $model->sales_order_id = Helper::autoNumber($model->getTable(), $model->getKeyName(), 'SO' . date('Ym'), config('website.autonumber'));
    });
  }

  public function scopeStatusCreate($query)
  {
    return $query->where('sales_order_status', 1);
  }
}
