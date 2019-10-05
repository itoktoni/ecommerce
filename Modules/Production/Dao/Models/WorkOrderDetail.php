<?php

namespace Modules\Production\Dao\Models;

use Modules\Item\Dao\Models\Product;
use Illuminate\Database\Eloquent\Model;

class WorkOrderDetail extends Model
{
  protected $table = 'production_work_order_detail';
  protected $primaryKey = 'production_work_order_detail_production_work_order_id';
  // protected $with = ['product'];
  protected $fillable = [
    'production_work_order_detail_production_work_order_id',
    'production_work_order_detail_item_product_id',
    'production_work_order_detail_qty_order',
    'production_work_order_detail_price_order',
    'production_work_order_detail_total_order',
    'production_work_order_detail_qty_prepare',
    'production_work_order_detail_price_prepare',
    'production_work_order_detail_total_prepare',
    'production_work_order_detail_qty_delivery',
    'production_work_order_detail_price_delivery',
    'production_work_order_detail_total_delivery',
    'production_work_order_detail_qty_invoice',
    'production_work_order_detail_price_invoice',
    'production_work_order_detail_total_invoice',
  ];

  public $timestamps = false;
  public $incrementing = false;

  public function product()
  {
    return $this->hasOne(Product::class, 'item_product_id', 'production_work_order_detail_item_product_id');
  }
}
