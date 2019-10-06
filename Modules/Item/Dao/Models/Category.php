<?php

namespace Modules\Item\Dao\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
  protected $table = 'item_category';
  protected $primaryKey = 'item_category_id';
  protected $fillable = [
    'item_category_id',
    'item_category_slug',
    'item_category_name',
    'item_category_image',
    'item_category_flag',
    'item_category_flag',
    'item_category_description',
    'item_category_created_at',
    'item_category_created_by',
  ];

  public $timestamps = true;
  public $incrementing = true;
  public $rules = [
    'item_category_name' => 'required|min:3|unique:item_category',
    'item_product_file' => 'file|image|mimes:jpeg,png,jpg|max:2048',
  ];

  const CREATED_AT = 'item_category_created_at';
  const UPDATED_AT = 'item_category_created_by';

  public $searching = 'item_category_name';
  public $datatable = [
    'item_category_id'          => [false => 'ID'],
    'item_category_name'        => [true => 'Name'],
    'item_category_flag'        => [true => 'Flag'],
    'item_category_slug'        => [false => 'Slug'],
    'item_category_image'        => [true => 'Images'],
    'item_category_description' => [false => 'Description'],
    'item_category_created_by'  => [false => 'Updated At'],
  ];
}
