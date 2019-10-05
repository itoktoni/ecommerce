<?php

namespace Modules\Item\Dao\Repositories;

use Helper;
use Plugin\Notes;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;
use Modules\Item\Dao\Models\Category;
use App\Dao\Interfaces\MasterInterface;

class CategoryRepository extends Category implements MasterInterface
{
    public function dataRepository()
    {
        $list = Helper::dataColumn($this->datatable, $this->getKeyName());
        return $this->select($list);
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

    public function getDataIn($in)
    {
        return $this->whereIn($this->getKeyName(), $in)->get();
    }

    public static function boot()
    {
        parent::boot();
        parent::saving(function ($model) {

            $file = 'item_category_file';
            if (request()->has($file)) {
                $image = $model->item_category_image;
                if ($image) {
                    Helper::removeImage($image, Helper::getTemplate(__CLASS__));
                }

                $file = request()->file($file);
                $name = Helper::uploadImage($file, Helper::getTemplate(__CLASS__));
                $model->item_category_image = $name;
            }

            if ($model->item_category_name && empty($model->item_category_slug)) {
                $model->item_category_slug = Str::slug($model->item_category_name);
            }

            if (Cache::has('item_category_api')) {
                Cache::forget('item_category_api');
            }
        });

        parent::deleting(function ($model) {
            if (request()->has('id')) {
                $data = $model->getDataIn(request()->get('id'));
                if ($data) {
                    foreach ($data as $value) {
                        Helper::removeImage($value->item_category_image, Helper::getTemplate(__CLASS__));
                    }
                }
            }
        });
    }
}
