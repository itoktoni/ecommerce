<?php

namespace Modules\Item\Dao\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Inventory\Dao\Models\Location;

class Stock extends Model
{
  protected $table = 'item_stock';
  protected $primaryKey = 'item_stock_id';
  protected $fillable = [
    'item_stock_id',
    'item_stock_type',
    'item_stock_barcode',
    'item_stock_product',
    'item_stock_size',
    'item_stock_color',
    'item_stock_location',
    'item_stock_qty',
    'item_stock_updated_at',
    'item_stock_created_at',
    'item_stock_deleted_at',
    'item_stock_updated_by',
    'item_stock_created_by',
  ];

  public $timestamps = true;
  public $incrementing = false;
  public $rules = [
    'item_stock_product' => 'required|min:3',
  ];

  public $with = ['color', 'location', 'location.warehouse'];

  const CREATED_AT = 'item_stock_updated_at';
  const UPDATED_AT = 'item_stock_updated_at';

  public $searching = 'item_stock_barcode';
  public $datatable = [
    'item_stock_id'        => [false => 'ID'],
    'item_product_name'        => [true => 'Full Name'],
    'item_color_name' => [true => 'Color'],
    'size' => [true => 'Size'],
    'qty' => [true => 'Qty'],
  ];

  public $status = [
    '1' => ['Active', 'primary'],
    '0' => ['Not Active', 'danger'],
  ];

  public function color()
  {
    return $this->hasOne(Color::class, 'item_color_id', 'item_stock_color');
  }

  public function location()
  {
    return $this->hasOne(Location::class, 'inventory_location_id', 'item_stock_location');
  }

}
