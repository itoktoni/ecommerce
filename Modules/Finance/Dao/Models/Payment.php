<?php

namespace Modules\Finance\Dao\Models;

use Plugin\Helper;
use Illuminate\Database\Eloquent\Model;
use Modules\Finance\Dao\Models\Account;

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
  ];

  public $with = ['account'];
  public $timestamps = true;
  public $incrementing = true;
  public $rules = [
    'finance_payment_approve_amount' => 'required',
    'finance_payment_note' => 'required',
  ];

  const CREATED_AT = 'finance_payment_created_at';
  const UPDATED_AT = 'finance_payment_updated_at';

  public $searching = 'finance_payment_note';
  public $datatable = [
    'finance_payment_id'             => [false => 'ID'],
    'finance_payment_voucher'           => [true => 'Voucher'],
    'finance_payment_description' => [true => 'Description'],
    'finance_payment_sales_order_id'         => [true => 'Order No'],
    'finance_payment_reference'         => [false => 'Reference'],
    'finance_payment_payment_account_id'         => [true => 'Account'],
    'finance_payment_approve_amount'  => [true => 'Amount'],
    'finance_payment_status'  => [true => 'Status'],
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
    '1' => ['APPROVE', 'success'],
    '0' => ['PENDING', 'warning'],
    '2' => ['REJECT', 'danger'],
  ];

  public function account()
  {
    return $this->hasOne(Account::class, 'finance_account_id', 'finance_payment_payment_account_id');
  }

  public static function boot()
  {
    parent::boot();
    parent::saving(function ($model) {
      if (request()->has('finance_payment_note') && empty(request()->get('finance_payment_description'))) {
        $model->finance_payment_description = request()->get('finance_payment_note');
        $model->finance_payment_approved_by = auth()->user()->username;
        $model->finance_payment_approved_at = date('Y-m-d H:i:s');
      }

      $file = request()->file('files');
      if (!empty($file)) //handle images
      {
        $name = Helper::uploadFile($file, Helper::getTemplate(__CLASS__));
        $model->finance_payment_attachment = $name;
      }

      $model->finance_payment_approve_amount = Helper::filterInput($model->finance_payment_approve_amount);
      $model->finance_payment_amount = Helper::filterInput($model->finance_payment_approve_amount);
      $model->finance_payment_created_by = auth()->user()->username;
      $model->finance_payment_updated_by = auth()->user()->username;

      if ($model->account->finance_account_type == 1) {
        $model->finance_payment_in = $model->finance_payment_approve_amount;
      } else {
        $model->finance_payment_out = $model->finance_payment_approve_amount;
      }
    });

    parent::creating(function ($model) {
      $model->finance_payment_voucher = Helper::autoNumber($model->getTable(), 'finance_payment_voucher', 'VC' . date('Ym'), 15);
    });
  }
}