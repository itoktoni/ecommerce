<?php

namespace Modules\Finance\Dao\Models;

use Plugin\Helper;
use Illuminate\Support\Facades\Auth;
use Modules\Finance\Dao\Models\Bank;
use Illuminate\Database\Eloquent\Model;
use Modules\Finance\Dao\Models\Account;
use Modules\Sales\Dao\Models\Order;
use Modules\Sales\Dao\Repositories\OrderRepository;

class Payment extends Model
{
  protected $table = 'finance_payment';
  protected $primaryKey = 'finance_payment_id';
  protected $fillable = [
    'finance_payment_id',
    'finance_payment_from',
    'finance_payment_to',
    'finance_payment_sales_order_id',
    'finance_payment_reference',
    'finance_payment_payment_account_id',
    'finance_payment_date',
    'finance_payment_person',
    'finance_payment_amount',
    'finance_payment_attachment',
    'finance_payment_description',
    'finance_payment_note',
    'finance_payment_in',
    'finance_payment_out',
    'finance_payment_approve_amount',
    'finance_payment_status',
    'finance_payment_approved_at',
    'finance_payment_approved_by',
    'finance_payment_created_by',
    'finance_payment_created_at',
    'finance_payment_updated_at',
    'finance_payment_updated_by',
    'finance_payment_voucher',
    'finance_payment_email',
  ];

  public $with = ['account', 'bank', 'order'];
  public $timestamps = true;
  public $incrementing = true;
  public $rules = [
    'finance_payment_amount' => 'required',
    'finance_payment_sales_order_id' => 'required|exists:sales_order,sales_order_id',
    'finance_payment_person' => 'required',
    'finance_payment_email' => 'required|email',
    'finance_payment_date' => 'required',
    'files' => 'required|file',
    'finance_payment_to' => 'required',
  ];

  const CREATED_AT = 'finance_payment_created_at';
  const UPDATED_AT = 'finance_payment_updated_at';

  public $searching = 'finance_payment_note';
  public $datatable = [
    'finance_payment_id'             => [false => 'ID'],
    'finance_payment_voucher'           => [true => 'Voucher'],
    'finance_payment_sales_order_id'         => [true => 'Order No'],
    'finance_payment_reference'         => [false => 'Reference'],
    'finance_payment_email'         => [false => 'Email'],
    'finance_payment_to'         => [true => 'Bank'],
    'finance_payment_payment_account_id'         => [true => 'Account'],
    'finance_payment_amount'  => [true => 'Amount'],
    'finance_payment_approve_amount'  => [true => 'Approve'],
    'finance_payment_status'  => [true => 'Status'],
    'finance_payment_note' => [false => 'Notes'],
    'finance_payment_created_at'     => [false => 'Created At'],
    'finance_payment_created_by'     => [false => 'Updated At'],
  ];

  protected $dates = [
    'finance_payment_created_at',
    'finance_payment_updated_at',
    'finance_payment_date',
    'finance_payment_approved_at',
  ];

  public $status = [
    '0' => ['APPROVE', 'success'],
    '1' => ['PENDING', 'warning'],
    '2' => ['REJECT', 'danger'],
  ];

  public function account()
  {
    return $this->hasOne(Account::class, 'finance_account_id', 'finance_payment_payment_account_id');
  }

  public function bank()
  {
    return $this->hasOne(Bank::class, 'finance_bank_id', 'finance_payment_to');
  }

  public function order()
  {
    return $this->hasOne(Order::class, 'sales_order_id', 'finance_payment_sales_order_id');
  }

  public static function boot()
  {
    parent::boot();
    parent::saving(function ($model) {
      if (request()->has('finance_payment_description')) {
        $model->finance_payment_approved_by = auth()->user()->username;
        $model->finance_payment_approved_at = date('Y-m-d H:i:s');
      }

      $file = request()->file('files');
      if (!empty($file)) //handle images
      {
        $name = Helper::uploadFile($file, Helper::getTemplate(__CLASS__));
        $model->finance_payment_attachment = $name;
      }

      $model->finance_payment_amount = Helper::filterInput($model->finance_payment_amount);
      if (request()->has('finance_payment_approve_amount')) {

        $model->finance_payment_approve_amount = Helper::filterInput($model->finance_payment_approve_amount);
      }

      if (Auth::check()) {
        $model->finance_payment_updated_by = auth()->user()->username;
      }

      if (request()->has('order_paid') && request()->get('order_paid') == 1) {

        $order = new OrderRepository();
        $getOrder = $order->showRepository($model->finance_payment_sales_order_id);
        if ($getOrder && $getOrder->sales_order_status < 2) {
          $order->updateRepository($model->finance_payment_sales_order_id, [
            'sales_order_status' => 2
          ]);
        }
      }
    });

    parent::creating(function ($model) {

      $file = request()->file('files');
      if (!empty($file)) //handle images
      {
        $name = Helper::uploadFile($file, Helper::getTemplate(__CLASS__));
        $model->finance_payment_attachment = $name;
      }

      $model->finance_payment_status = 1;
      $model->finance_payment_payment_account_id = 1;
      $model->finance_payment_created_by = request()->get('finance_payment_person');
      $model->finance_payment_voucher = Helper::autoNumber($model->getTable(), 'finance_payment_voucher', 'VC' . date('Ym'), 13);
    });
  }
}
