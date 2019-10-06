<?php

namespace Modules\Marketing\Dao\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
  protected $table = 'marketing_page';
  protected $primaryKey = 'marketing_page_id';
  protected $fillable = [
    'marketing_page_id',
    'marketing_page_name',
    'marketing_page_slug',
    'marketing_page_description',
    'marketing_page_page',
    'marketing_page_link',
    'marketing_page_image',
    'marketing_page_created_at',
    'marketing_page_created_by',
  ];

  public $timestamps = true;
  public $incrementing = true;
  public $rules = [
    'marketing_page_name' => 'required|min:3|unique:marketing_page',
    'marketing_page_file' => 'file|image|mimes:jpeg,png,jpg|max:2048',
    'marketing_page_link' => 'url',
  ];

  const CREATED_AT = 'marketing_page_created_at';
  const UPDATED_AT = 'marketing_page_created_by';

  public $searching = 'marketing_page_name';
  public $datatable = [
    'marketing_page_id'          => [false => 'ID'],
    'marketing_page_name'        => [true => 'Name'],
    'marketing_page_link'        => [false => 'Link'],
    'marketing_page_slug'        => [false => 'Slug'],
    'marketing_page_description' => [true => 'Description'],
    'marketing_page_image'        => [true => 'Images'],
    'marketing_page_created_by'  => [false => 'Updated At'],  
  ];
}
