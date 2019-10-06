<?php

namespace Modules\Marketing\Dao\Models;

use Illuminate\Database\Eloquent\Model;

class Promo extends Model
{
  protected $table = 'marketing_promo';
  protected $primaryKey = 'marketing_promo_id';
  protected $fillable = [
    'marketing_promo_id',
    'marketing_promo_name',
    'marketing_promo_slug',
    'marketing_promo_description',
    'marketing_promo_page',
    'marketing_promo_link',
    'marketing_promo_image',
    'marketing_promo_created_at',
    'marketing_promo_created_by',
  ];

  public $timestamps = true;
  public $incrementing = true;
  public $rules = [
    'marketing_promo_name' => 'required|min:3|unique:marketing_promo',
    'marketing_promo_file' => 'file|image|mimes:jpeg,png,jpg|max:2048',
    'marketing_promo_link' => 'url',
  ];

  const CREATED_AT = 'marketing_promo_created_at';
  const UPDATED_AT = 'marketing_promo_created_by';

  public $searching = 'marketing_promo_name';
  public $datatable = [
    'marketing_promo_id'          => [false => 'ID'],
    'marketing_promo_name'        => [true => 'Name'],
    'marketing_promo_button'        => [false => 'Button'],
    'marketing_promo_link'        => [false => 'Link'],
    'marketing_promo_slug'        => [false => 'Slug'],
    'marketing_promo_description' => [true => 'Description'],
    'marketing_promo_image'        => [true => 'Images'],
    'marketing_promo_created_by'  => [false => 'Updated At'],  
  ];
}
