<?php

namespace Modules\Item\Dao\Models;

use Plugin\Helper;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;
use Modules\Production\Models\Vendor;
use Modules\Sales\Models\OrderDetail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
  protected $table = 'item_product';
  protected $primaryKey = 'item_product_id';
  protected $fillable = [
    'item_product_id',
    'item_product_slug',
    'item_product_min',
    'item_product_max',
    'item_product_sku',
    'item_product_buy',
    'item_product_image',
    'item_product_sell',
    'item_product_item_category_id',
    'item_product_item_brand_id',
    'item_product_item_tag_id',
    'item_product_name',
    'item_product_description',
    'item_product_updated_at',
    'item_product_created_at',
    'item_product_deleted_at',
    'item_product_updated_by',
    'item_product_created_by',
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
  const DELETED_AT = 'item_product_deleted_at';

  public $searching = 'item_product_name';
  public $datatable = [
    'item_product_id'          => [false => 'ID'],
    'item_category_name'        => [true => 'Category'],
    'item_product_name'        => [true => 'Name'],
    'item_brand_name'        => [true => 'Brand'],
    'item_product_sell'        => [true => 'Price'],
    'item_product_image'        => [true => 'Images'],
    'item_product_slug'        => [false => 'Slug'],
    'item_product_description' => [false => 'Description'],
    'item_product_created_at'  => [false => 'Created At'],
    'item_product_created_by'  => [false => 'Updated At'],
  ];

  public $status = [
    '1' => ['Active', 'primary'],
    '0' => ['Not Active', 'danger'],
  ];

  public static function boot()
  {
    parent::boot();
    parent::saving(function ($model) {

      $file = 'item_product_file';
      if (request()->has($file)) {
        $image = $model->item_product_image;
        if ($image) {
          Helper::removeImage($image, Helper::getTemplate(__CLASS__));
        }

        $file = request()->file($file);
        $name = Helper::uploadImage($file, Helper::getTemplate(__CLASS__));
        $model->item_product_image = $name;
      }

      $model->item_product_item_tag_id = json_encode(request()->get('item_product_item_tag_id'));

      if ($model->item_product_name && empty($model->item_product_slug)) {
        $model->item_product_slug = Str::slug($model->item_product_name);
      } else {
        $model->item_product_slug = Str::slug($model->item_product_slug);
      }

      $model->item_product_name = strtoupper($model->item_product_name);
      if (Cache::has('item_product_api')) {
        Cache::forget('item_product_api');
      }
    });

    parent::deleting(function ($model) {
      if (request()->has('id')) {
        $data = $model->getDataIn(request()->get('id'));
        if ($data) {
          Cache::forget('item_product_api');
          foreach ($data as $value) {
            if ($value->item_product_image) {
              Helper::removeImage($value->item_product_image, Helper::getTemplate(__CLASS__));
            }
          }
        }
      }
    });
  }
}
