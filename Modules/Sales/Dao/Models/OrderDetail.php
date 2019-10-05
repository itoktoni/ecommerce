<?php

namespace Modules\Sales\Dao\Models;

use Modules\Item\Dao\Models\Product;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
  protected $table = 'sales_order_detail';
  protected $primaryKey = 'sales_order_detail_sales_order_id';
  // protected $with = ['product'];
  protected $fillable = [
    'sales_order_detail_sales_order_id',
    'sales_order_detail_item_product_id',
    'sales_order_detail_qty_order',
    'sales_order_detail_price_order',
    'sales_order_detail_total_order',
    'sales_order_detail_qty_prepare',
    'sales_order_detail_price_prepare',
    'sales_order_detail_total_prepare',
    'sales_order_detail_qty_delivery',
    'sales_order_detail_price_delivery',
    'sales_order_detail_total_delivery',
    'sales_order_detail_qty_invoice',
    'sales_order_detail_price_invoice',
    'sales_order_detail_total_invoice',
  ];

  public $timestamps = false;
  public $incrementing = false;

  public function detail()
  {
    return $this->belongsTo(Order::class, 'sales_order_detail_sales_id', 'sales_order_id');
  }

  public function product()
  {
    return $this->hasOne(Product::class, 'item_product_id', 'sales_order_detail_item_product_id');
  }
}
