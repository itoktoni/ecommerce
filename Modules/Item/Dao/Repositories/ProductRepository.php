<?php

namespace Modules\Item\Dao\Repositories;

use Helper;
use Plugin\Notes;
use Illuminate\Support\Str;
use Modules\Item\Dao\Models\Unit;
use Modules\Item\Dao\Models\Product;
use Modules\Item\Dao\Models\Category;
use Modules\Item\Dao\Models\Currency;
use Modules\Item\Dao\Models\Material;
use Modules\Production\Dao\Models\Vendor;
use App\Dao\Interfaces\MasterInterface;

class ProductRepository extends Product implements MasterInterface
{
    private static $unit;
    private static $category;
    private static $material;
    private static $currency;
    private static $production;

    public static function getUnit()
    {
        if (self::$unit == null) {
            self::$unit = new Unit();
        }

        return self::$unit;
    }

    public static function getCategory()
    {
        if (self::$category == null) {
            self::$category = new Category();
        }

        return self::$category;
    }

    public static function getCurrency()
    {
        if (self::$currency == null) {
            self::$currency = new Currency();
        }

        return self::$currency;
    }

    public static function getMaterial()
    {
        if (self::$material == null) {
            self::$material = new Material();
        }

        return self::$material;
    }

    public static function getProduction()
    {
        if (self::$production == null) {
            self::$production = new Vendor();
        }

        return self::$production;
    }
    
    public function dataRepository()
    {
        $unit = self::getUnit();
        $category = self::getCategory();
        $currency = self::getCurrency();
        $material = self::getMaterial();
        $production = self::getProduction();
        $list = Helper::dataColumn($this->datatable, $this->primaryKey);
        $query = $this->select($list)
            ->leftJoin($unit->getTable(), $unit->getKeyName(), 'item_product_item_unit_id')
            ->leftJoin($category->getTable(), $category->getKeyName(), 'item_product_item_category_id')
            ->leftJoin($currency->getTable(), $currency->getKeyName(), 'item_product_item_currency_id')
            ->leftJoin($material->getTable(), $material->getKeyName(), 'item_product_item_material_id')
            ->leftJoin($production->getTable(), $production->getKeyName(), 'item_product_production_vendor_id');
        return $query;
    }

    public function saveRepository($request)
    {
        try {
            $activity = $this->create($request);
            return Notes::create($activity);
        } catch (\Illuminate\Database\QueryException $ex) {
            return Notes::error($ex->getMessage());
        }
    }

    public function updateRepository($id, $request)
    {
        try {
            $activity = $this->findOrFail($id)->update($request);
            return Notes::update($activity);
        } catch (QueryExceptionAlias $ex) {
            return Notes::error($ex->getMessage());
        }
    }

    public function deleteRepository($data)
    {
        try {
            $activity = $this->Destroy(array_values($data));
            return Notes::delete($activity);
        } catch (\Illuminate\Database\QueryException $ex) {
            return Notes::error($ex->getMessage());
        }
    }

    public function showRepository($id, $relation)
    {
        if ($relation) {
            return $this->with($relation)->findOrFail($id);
        }
        return $this->findOrFail($id);
    }

    public static function boot()
    {
        parent::boot();
        parent::saving(function ($model) {
            if ($model->item_product_name && empty($model->item_product_slug)) {
                $model->item_product_slug = Str::slug($model->item_product_name);
            }
            $file = $model->item_product_image;
            if (!empty($file)) //handle images
            {
                $file = $model->item_product_image;
                if (!empty($file)) //handle images
                {
                    $name = Helper::upload($file, Helper::getTemplate(__CLASS__));
                    $model->item_product_image = $name;
                }
            }

            $model->item_product_created_by = auth()->user()->username;
            $model->item_product_updated_by = auth()->user()->username;
        });

        parent::updating(function ($model) {
            $name = $model->getOriginal('item_product_image');
            Helper::remove($name, Helper::getTemplate(__CLASS__));
        });
    }

}
