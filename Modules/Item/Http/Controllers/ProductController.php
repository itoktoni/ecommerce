<?php

namespace Modules\Item\Http\Controllers;

use Helper;
use Plugin\Response;
use Modules\Item\Models\Unit;
use App\Http\Controllers\Controller;
use App\Http\Services\MasterService;
use Modules\Item\Dao\Repositories\UnitRepository;
use Modules\Item\Dao\Repositories\ProductRepository;
use Modules\Item\Dao\Repositories\CategoryRepository;
use Modules\Item\Dao\Repositories\CurrencyRepository;
use Modules\Item\Dao\Repositories\MaterialRepository;
use Modules\Item\Http\Services\ProductService;
use Modules\Production\Dao\Repositories\VendorRepository;

class ProductController extends Controller
{
    public $template;
    public static $model;

    public function __construct()
    {
        if (self::$model == null) {
            self::$model = new ProductRepository();
        }
        $this->template  = Helper::getTemplate(__class__);
    }

    public function index()
    {
        return redirect()->route($this->getModule() . '_data');
    }

    private function share($data = [])
    {
        $unit = Helper::createOption((new UnitRepository()));
        $category = Helper::createOption((new CategoryRepository()));
        $currency = Helper::createOption((new CurrencyRepository()));
        $material = Helper::createOption((new MaterialRepository()));
        $production = Helper::createOption((new VendorRepository()));

        $view = [
            'key'       => self::$model->getKeyName(),
            'unit'      => $unit,
            'category'  => $category,
            'currency'  => $currency,
            'material'  => $material,
            'production'  => $production,
        ];

        return array_merge($view, $data);
    }

    public function create(ProductService $service)
    {
        if (request()->isMethod('POST')) {
            $service->save(self::$model);
        }
        return view(Helper::setViewCreate())->with($this->share());
    }

    public function update(ProductService $service)
    {
        if (request()->isMethod('POST')) {
            $service->update(self::$model);
            return redirect()->route($this->getModule() . '_data');
        }

        if (request()->has('code')) {
            $data = $service->show(self::$model);

            return view(Helper::setViewUpdate())->with($this->share([
                'model'        => $data,
                'key'          => self::$model->getKeyName()
            ]));
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
            $datatable = $service->datatable(self::$model);
            $datatable->editColumn('item_product_sell', function ($select) {
                return number_format($select->item_product_sell);
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
