<?php

namespace Modules\Item\Http\Controllers;

use Helper;
use Plugin\Notes;
use Plugin\Response;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Services\MasterService;
use Intervention\Image\Facades\Image;
use Modules\Item\Http\Services\ProductService;
use Modules\Item\Dao\Repositories\TagRepository;
use Modules\Item\Dao\Repositories\SizeRepository;
use Modules\Item\Dao\Repositories\BrandRepository;
use Modules\Item\Dao\Repositories\ColorRepository;
use Modules\Item\Dao\Repositories\ProductRepository;
use Modules\Item\Dao\Repositories\CategoryRepository;

class ProductController extends Controller
{
    public $template;
    public $folder;
    public static $model;

    public function __construct()
    {
        if (self::$model == null) {
            self::$model = new ProductRepository();
        }
        $this->folder = 'Item';
        $this->template  = Helper::getTemplate(__class__);
    }

    public function index()
    {
        return redirect()->route($this->getModule() . '_data');
    }

    private function share($data = [])
    {
        $brand = Helper::createOption((new BrandRepository()));
        $category = Helper::createOption((new CategoryRepository()));
        $tag = Helper::createOption((new TagRepository()), false);
        $color = Helper::createOption((new ColorRepository()));
        $size = Helper::createOption((new SizeRepository()));

        $view = [
            'key'       => self::$model->getKeyName(),
            'brand'      => $brand,
            'category'  => $category,
            'tag'  => $tag,
            'color'  => $color,
            'size'  => $size,
        ];

        return array_merge($view, $data);
    }

    public function create(MasterService $service)
    {
        if (request()->isMethod('POST')) {
            $service->save(self::$model);
        }
        return view(Helper::setViewSave($this->template, $this->folder))->with($this->share([
            'model' => self::$model,
        ]));
    }

    public function update(MasterService $service)
    {
        if (request()->isMethod('POST')) {
            $service->update(self::$model);
            return redirect()->route($this->getModule() . '_data');
        }

        if (request()->has('code')) {
            $data = $service->show(self::$model);

            return view(Helper::setViewSave($this->template, $this->folder))->with($this->share([
                'model'        => $data,
                'image_detail' => self::$model->getImageDetail($data->item_product_id),
                'key'          => self::$model->getKeyName()
            ]));
        }
    }

    public function delete_image()
    {
        if (request()->has('code')) {
            $code = request()->get('code');
            self::$model->deleteImageDetail($code);

            Helper::removeImage($code, 'product_detail');
            return redirect()->back();
        }
    }

    public function upload()
    {
        if (request()->has('code')) {

            $code = request()->get('code');
            $path = public_path('files/product_detail');
            $photos = request()->file('file');

            for ($i = 0; $i < count($photos); $i++) {
                $photo = $photos[$i];
                $name = sha1(date('YmdHis') . str_random(30));
                $save_name = $name . '.' . $photo->getClientOriginalExtension();
                $resize_name = 'thumbnail_' . $save_name;

                Image::make($photo)
                    ->resize(250, null, function ($constraints) {
                        $constraints->aspectRatio();
                    })
                    ->save($path . '/' . $resize_name);

                $photo->move($path, $save_name);
                self::$model->saveImageDetail($code, $save_name);
            }

            // return Notes::create('Data upload Success');
        }
    }

    public function delete(MasterService $service)
    {
        $service->delete(self::$model);
        return Response::redirectBack();;
    }

    public function data(MasterService $service)
    {
        if (request()->isMethod('POST')) {
            $datatable = $service->setRaw(['item_product_image'])->datatable(self::$model);
            $datatable->editColumn('item_product_sell', function ($select) {
                return number_format($select->item_product_sell);
            });
            $datatable->editColumn('item_product_image', function ($select) {
                return Helper::createImage(Helper::getTemplate(__CLASS__) . '/thumbnail_' . $select->item_product_image);
            });
            return $datatable->make(true);
        }

        return view(Helper::setViewData())->with([
            'fields'   => Helper::listData(self::$model->datatable),
            'template' => $this->template,
        ]);
    }

    public function show(MasterService $service)
    {
        if (request()->has('code')) {
            $data = $service->show(self::$model);
            return view(Helper::setViewShow())->with($this->share([
                'fields' => Helper::listData(self::$model->datatable),
                'model'   => $data,
                'key'   => self::$model->getKeyName()
            ]));
        }
    }
}
