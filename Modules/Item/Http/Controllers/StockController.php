<?php

namespace Modules\Item\Http\Controllers;

use Helper;
use Plugin\Response;
use App\Http\Controllers\Controller;
use Modules\Item\Dao\Repositories\StockRepository;
use App\Http\Services\MasterService;
use Modules\Inventory\Dao\Repositories\LocationRepository;
use Modules\Item\Dao\Repositories\ColorRepository;
use Modules\Item\Dao\Repositories\ProductRepository;
use Modules\Item\Dao\Repositories\SizeRepository;

class StockController extends Controller
{
    public $template;
    public static $model;

    public function __construct()
    {
        if (self::$model == null) {
            self::$model = new StockRepository();
        }
        $this->template  = Helper::getTemplate(__class__);
    }

    public function index()
    {
        return redirect()->route($this->getModule() . '_data');
    }

    private function share($data = [])
    {
        $view = [
            'template' => $this->template,
        ];

        return array_merge($view, $data);
    }

    public function create(MasterService $service)
    {
        if (request()->isMethod('POST')) {

            $service->save(self::$model);
        }
        return view(Helper::setViewCreate())->with($this->share());
    }

    public function update(MasterService $service)
    {
        if (request()->isMethod('POST')) {

            $service->update(self::$model);
            return redirect()->route($this->getModule() . '_data');
        }

        if (request()->has('code')) {

            $data = $service->show(self::$model);
            $product = Helper::shareOption((new ProductRepository()));
            $size = Helper::shareOption((new SizeRepository()));
            $color = Helper::shareOption((new ColorRepository()));
            $location = new LocationRepository();
            $data_location = $location->dataRepository()->get()->map(function($item){
                return $item['inventory_location_id'] = 'Loc '.$item->inventory_location_name.' - WH : '.$item->inventory_warehouse_name;
            });
            return view(Helper::setViewUpdate())->with($this->share([
                'model'        => $data,
                'product'      => $product,
                'size'         => $size,
                'color'        => $color,
                'location'     => $data_location,
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

            $datatable = $service->setRaw(['item_stock_product'])->datatable(self::$model);
            $datatable->editColumn('item_stock_product', function ($select) {
                return $select->product;
            });
            $module = $this->getModule();
            $datatable->editColumn('action', function ($select) use ($module) {
                return $html = '<p align="center"><a id="linkMenu" href="' . route($module . '_show', ['code' => $select->item_product_id]) . '" class="btn btn-xs btn-success">show</a></p>';
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
            $code = request()->get('code');
            $check = self::$model->stockRepository($code);
            $stock = $data = false;
            if ($check) {
                $product = new ProductRepository();
                $data = $product->showRepository($check->product_id);
                $stock = self::$model->stockDetailRepository($check->product, $check->color, $check->size);
            }

            return view('Item::page.stock.show')->with($this->share([
                'fields' => Helper::listData(self::$model->datatable),
                'model'   => $data,
                'stock'   => $stock,
                'key' => 'item_product_id',
            ]));
        }
    }
}
