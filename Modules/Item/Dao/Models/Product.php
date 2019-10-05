<?php

namespace Modules\Item\Dao\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Production\Models\Vendor;
use Modules\Sales\Models\OrderDetail;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
  protected $table = 'item_product';
  protected $primaryKey = 'item_product_id';
  protected $fillable = [
    'item_product_id',
    'item_product_slug',
    'item_product_min',
    'item_product_sku',
    'item_product_buy',
    'item_product_image_thumnail',
    'item_product_image',
    'item_product_sell',
    'item_product_item_category_id',
    'item_product_item_unit_id',
    'item_product_item_material_id',
    'item_product_item_currency_id',
    'item_product_production_vendor_id',
    'item_product_name',
    'item_product_description',
    'item_product_updated_at',
    'item_product_created_at',
    'item_product_updated_by',
    'item_product_created_by',
    'item_product_max',
  ];

  public $timestamps = true;
  public $incrementing = true;
  public $rules = [
    'item_product_name' => 'required|min:3',
    'item_product_sell' => 'required',
    'item_product_file' => 'file|image|mimes:jpeg,png,jpg|max:2048',
  ];

  const CREATED_AT = 'item_product_created_at';
  const UPDATED_AT = 'item_product_updated_at';
  const DELETED_AT = 'item_product_deleteed_at';

  public $searching = 'item_product_name';
  public $datatable = [
    'item_product_id'          => [false => 'ID'],
    'item_material_name'        => [true => 'Material'],
    'item_category_name'        => [true => 'Category'],
    'item_product_name'        => [true => 'Name'],
    'item_unit_name'        => [true => 'Unit'],
    'production_vendor_name'        => [true => 'Vendor'],
    'item_product_sell'        => [true => 'Price'],
    'item_currency_code'        => [true => 'Rate'],
    'item_product_slug'        => [false => 'Slug'],
    'item_product_description' => [false => 'Description'],
    'item_product_created_at'  => [false => 'Created At'],
    'item_product_created_by'  => [false => 'Updated At'],
  ];

  public $status = [
    '1' => ['Active', 'primary'],
    '0' => ['Not Active', 'danger'],
  ];
}
