<?php

namespace Modules\Sales\Http\Controllers;

use PDF;
use Helper;
use Plugin\Response;
use App\Http\Controllers\Controller;
use App\Http\Services\MasterService;
use App\Http\Services\TransactionService;
use Modules\Sales\Dao\Repositories\OrderRepository;
use Modules\Crm\Dao\Repositories\CustomerRepository;
use Modules\Finance\Dao\Repositories\AccountRepository;
use Modules\Finance\Dao\Repositories\BankRepository;
use Modules\Item\Dao\Repositories\ProductRepository;
use Modules\Sales\Http\Services\OrderService;
use Modules\Forwarder\Dao\Repositories\VendorRepository as ForwarderRepository;
use Modules\Production\Dao\Repositories\WorkOrderCreateRepository;
use Modules\Production\Dao\Repositories\VendorRepository as ProductionRepository;
use Modules\Sales\Dao\Repositories\OrderCreateRepository;

class OrderController extends Controller
{
    public $template;
    public $folder;
    public static $model;
    public static $detail;

    public function __construct()
    {
        if (self::$model == null) {
            self::$model = new OrderRepository();
        }
        if (self::$detail == null) {
            self::$detail = new OrderCreateRepository();
        }
        $this->folder = 'sales';
        $this->template  = Helper::getTemplate(__class__);
    }

    public function index()
    {
        return redirect()->route($this->getModule() . '_data');
    }

    private function share($data = [])
    {
        $customer = Helper::createOption((new CustomerRepository()));
        $forwarder = Helper::createOption((new ForwarderRepository()));
        $product = Helper::createOption((new ProductRepository()), false, true);
        $account = Helper::createOption((new AccountRepository()));
        $bank = Helper::createOption((new BankRepository()));

        $view = [
            'key'       => self::$model->getKeyName(),
            'customer'      => $customer,
            'forwarder'  => $forwarder,
            'product'  => $product,
            'account'  => $account,
            'bank'  => $bank,
        ];

        return array_merge($view, $data);
    }

    public function create(OrderService $service)
    {
        if (request()->isMethod('POST')) {
            dd(request()->all());
            $post = $service->save(self::$detail);
            if ($post['status']) {
                return Response::redirectToRoute($this->getModule() . '_data');
            }
            return Response::redirectBackWithInput();
        }
        return view(Helper::setViewSave($this->template, $this->folder))->with($this->share([
            'data_product' => [],
            'model' => self::$model,
        ]));
    }

    public function update(TransactionService $service)
    {
        if (request()->isMethod('POST')) {

            $post = $service->update(self::$detail);
            if ($post['status']) {
                return Response::redirectToRoute($this->getModule() . '_data');
            }
            return Response::redirectBackWithInput();
        }
        if (request()->has('code')) {

            $data = $service->show(self::$model, ['detail', 'detail.product']);
            return view(Helper::setViewSave($this->template, $this->folder))->with($this->share([
                'model'        => $data,
                'detail'        => $data->detail,
                'key'          => self::$model->getKeyName()
            ]));
        }
    }

    public function payment(TransactionService $service)
    {
        if (request()->isMethod('POST')) {

            $post = $service->update(self::$detail);
            if ($post['status']) {
                return Response::redirectToRoute($this->getModule() . '_data');
            }
            return Response::redirectBackWithInput();
        }
        if (request()->has('code')) {

            $data = $service->show(self::$model, ['payment', 'payment.account']);
            return view(Helper::setViewForm($this->template, __FUNCTION__, $this->folder))->with($this->share([
                'model'        => $data,
                'detail'        => $data->payment,
                'key'          => self::$model->getKeyName()
            ]));
        }
    }

    public function print_payment(TransactionService $service)
    {
        if (request()->has('code')) {
            $data = $service->show(self::$model, ['forwarder', 'customer', 'detail', 'detail.product']);
            $id = request()->get('code');
            $pasing = [
                'master' => $data,
                'customer' => $data->customer,
                'forwarder' => $data->forwarder,
                'detail' => $data->detail,
            ];

            $pdf = PDF::loadView(Helper::setViewPrint('print_order', $this->folder), $pasing);
            return $pdf->download($id . '.pdf');
        }
    }

    public function delete(TransactionService $service)
    {
        $check = $service->delete(self::$detail);
        if ($check['data'] == 'master') {
            return Response::redirectBack();
        }
        return Response::redirectToRoute(config('module') . '_update', ['code' => request()->get('code')]);
    }

    public function data(MasterService $service)
    {
        if (request()->isMethod('POST')) {
            $datatable = $service
                ->setRaw(['sales_order_status', 'sales_order_total', 'sales_order_rajaongkir_service'])
                ->setAction(
                    [
                        'update' => ['primary', 'edit'],
                        'work_order' => ['warning', 'wo'],
                        'payment' => ['info', 'payment'],
                        'show'   => ['success', 'show'],
                    ]
                )
                ->datatable(self::$model);
            $datatable->editColumn('sales_order_status', function ($field) {
                return Helper::createStatus([
                    'value'  => $field->sales_order_status,
                    'status' => self::$model->status,
                ]);
            });
            $datatable->editColumn('sales_order_date', function ($field) {
                return $field->sales_order_date->toDateString();
            });
            $datatable->editColumn('sales_order_rajaongkir_service', function ($field) {
                return 'Courier '.strtoupper($field->sales_order_rajaongkir_courier).' <br> '.str_replace(') ', ' ', $field->sales_order_rajaongkir_service).' <br> Weight '.number_format(floatval($field->sales_order_rajaongkir_weight)).' g';
            });
            $datatable->editColumn('sales_order_total', function ($field) {
                return Helper::createTotal($field->sales_order_total);
            });
            return $datatable->make(true);
        }

        return view(Helper::setViewData())->with([
            'fields'   => Helper::listData(self::$model->datatable),
            'template' => $this->template,
        ]);
    }

    public function show(TransactionService $service)
    {
        if (request()->has('code')) {
            $data = $service->show(self::$model, ['forwarder', 'customer', 'detail', 'detail.product']);
            return view(Helper::setViewShow($this->template, $this->folder))->with($this->share([
                'fields' => Helper::listData(self::$model->datatable),
                'model'   => $data,
                'detail'  => $data->detail,
                'key'   => self::$model->getKeyName()
            ]));
        }
    }

    public function print_order(TransactionService $service)
    {
        if (request()->has('code')) {
            $data = $service->show(self::$model, ['forwarder', 'customer', 'detail', 'detail.product']);
            $id = request()->get('code');
            $pasing = [
                'master' => $data,
                'customer' => $data->customer,
                'forwarder' => $data->forwarder,
                'detail' => $data->detail,
            ];

            $pdf = PDF::loadView(Helper::setViewPrint('print_order', $this->folder), $pasing);
            return $pdf->download($id . '.pdf');
        }
    }

    public function work_order(OrderService $service, WorkOrderCreateRepository $work_order)
    {
        if (request()->isMethod('POST')) {
            $post = $service->saveWo($work_order);
            if ($post['status']) {
                return Response::redirectToRoute($this->getModule() . '_data');
            }
            return Response::redirectBackWithInput();
        }
        if (request()->has('code')) {
            $code = request()->get('code');
            $data = $service->show(self::$model);
            $detail = self::$model->split($code)->get();
            $sales_order = $work_order->getDetailBySalesOrder($code)->get();
            return view(Helper::setViewForm($this->template, __FUNCTION__, $this->folder))->with($this->share([
                'model'        => $data,
                'production'   => Helper::createOption((new ProductionRepository()), false, true),
                'detail'       => $detail,
                'sales_order'  => $sales_order,
                'key'          => self::$model->getKeyName()
            ]));
        }
    }
}
