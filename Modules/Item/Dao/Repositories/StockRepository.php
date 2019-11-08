<?php

namespace Modules\Item\Dao\Repositories;

use Helper;
use Plugin\Notes;
use Illuminate\Support\Facades\DB;
use Modules\Item\Dao\Models\Stock;
use App\Dao\Interfaces\MasterInterface;
use Modules\Item\Dao\Models\Product;

class StockRepository extends Stock implements MasterInterface
{
    public function dataRepository()
    {
        $product = new ProductRepository();
        $table = $product->select([DB::raw('IFNULL(view_stock_product.id, item_product.item_product_id) AS item_product_id'), 'item_color_name', 'item_product_name as product_id' ,'item_product_name', 'view_stock_product.*'])
            ->leftJoin('view_stock_product', 'product', 'item_product_id')
            ->leftJoin('item_color', 'color', 'item_color_id');
        return $table;
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
            return $this->with($relation)->where('item_brand_slug', $slug)->firstOrFail();
        }
        return $this->where('item_brand_slug', $slug)->firstOrFail();
    }


    public function showRepository($id, $relation)
    {
        if ($relation) {
            return $this->with($relation)->findOrFail($id);
        }
        return $this->findOrFail($id);
    }

    public function stockRepository($id)
    {
        return DB::table('view_stock')->where(['item_product_id' => $id])->first();
    }

    public function stockDetailRepository($product, $color = null, $size = null)
    {
        if ($color && $size) {
            $data = $this->where([
                'item_stock_product' => $product,
                'item_stock_color' => $color,
                'item_stock_size' => $size,
            ]);
        } else if ($color && !$size) {
            $data = $this->where([
                'item_stock_product' => $product,
                'item_stock_color' => $color,
            ]);
        } else if (!$color && $size) {
            $data = $this->where([
                'item_stock_product' => $product,
                'item_stock_size' => $size,
            ]);
        } else {
            $data = $this->where('item_stock_product', $product);
        }

        return $data->get();
    }
}
