<?php

namespace Modules\Item\Dao\Repositories;

use Helper;
use Plugin\Notes;
use Illuminate\Support\Str;
use Modules\Item\Dao\Models\Brand;
use Modules\Item\Dao\Models\Product;
use Modules\Item\Dao\Models\Category;
use App\Dao\Interfaces\MasterInterface;
use Modules\Production\Dao\Models\Vendor;

class ProductRepository extends Product implements MasterInterface
{
    private static $brand;
    private static $category;

    public static function getBrand()
    {
        if (self::$brand == null) {
            self::$brand = new Brand();
        }

        return self::$brand;
    }

    public static function getCategory()
    {
        if (self::$category == null) {
            self::$category = new Category();
        }

        return self::$category;
    }

    public function dataRepository()
    {
        $brand = self::getBrand();
        $category = self::getCategory();
        $list = Helper::dataColumn($this->datatable, $this->primaryKey);
        $query = $this->select($list)
            ->leftJoin($brand->getTable(), $brand->getKeyName(), 'item_product_item_brand_id')
            ->leftJoin($category->getTable(), $category->getKeyName(), 'item_product_item_category_id')
            ->orderBy('item_product_created_at', 'DESC');
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

    public function slugRepository($slug, $relation = false)
    {
        if ($relation) {
            return $this->with($relation)->where('item_product_slug', $slug)->firstOrFail();
        }
        return $this->where('item_product_slug', $slug)->firstOrFail();
    }

    public function showRepository($id, $relation)
    {
        if ($relation) {
            return $this->with($relation)->findOrFail($id);
        }
        return $this->findOrFail($id);
    }
}
