<?php

namespace Modules\Finance\Http\Controllers;

use Helper;
use Plugin\Response;
use App\Http\Controllers\Controller;
use Modules\Finance\Dao\Repositories\PaymentRepository;
use App\Http\Services\MasterService;
use Modules\Finance\Dao\Repositories\AccountRepository;
use Modules\Finance\Dao\Repositories\BankRepository;
use Modules\Finance\Dao\Repositories\FlagRepository;
use Modules\Sales\Dao\Repositories\OrderRepository;
use Plugin\Alert;

class PaymentController extends Controller
{
    public $template;
    public static $model;

    public function __construct()
    {
        if (self::$model == null) {
            self::$model = new PaymentRepository();
        }
        $this->template  = Helper::getTemplate(__class__);
    }

    public function index()
    {
        return redirect()->route($this->getModule() . '_data');
    }

    private function share($data = [])
    {
        $flag = Helper::createOption((new FlagRepository()), false);
        $account = Helper::createOption((new AccountRepository()));
        $bank = Helper::createOption((new BankRepository()));
        $order = Helper::createOption((new OrderRepository()));
        $view = [
            'template' => $this->template,
            'status' => Helper::shareStatus(self::$model->status),
            'account' => $account,
            'bank' => $bank,
            'order' => $order,
            'flag' => $flag,
        ];

        return array_merge($view, $data);
    }

    public function create(MasterService $service)
    {
        if (request()->isMethod('POST')) {

            $service->save(self::$model);
        }

        return view(Helper::setViewCreate())->with($this->share([
            'model' => self::$model
        ]));
    }

    public function update(MasterService $service)
    {
        if (request()->isMethod('POST')) {

            $service->update(self::$model);
            if (request()->has('order_paid')) {
                self::$model->paidRepository(request()->get('finance_payment_sales_order_id'));
            }
            return redirect()->route($this->getModule() . '_data');
        }

        if (request()->has('code')) {

            $data = $service->show(self::$model);
            return view(Helper::setViewUpdate())->with($this->share([
                'model'        => $data,
                'key'          => self::$model->getKeyName()
            ]));
        }

        if (request()->has('so')) {
            $id = request()->get('so');
            $data = self::$model->soRepository($id);
            if(!$data){
                Alert::error('SO '.$id.' Belum dibayar');
                return redirect()->back();
            }
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
            $datatable = $service->setRaw(['finance_payment_status', 'finance_payment_payment_account_id', 'finance_payment_amount', 'finance_payment_approve_amount'])->datatable(self::$model);
            $datatable->editColumn('finance_payment_payment_account_id', function ($data) {
                return $data->account->finance_account_name;
            });
            $datatable->editColumn('finance_payment_to', function ($data) {
                return $data->bank->finance_bank_name;
            });
            $datatable->editColumn('finance_payment_amount', function ($data) {
                return number_format($data->finance_payment_amount);
            });

            $datatable->editColumn('finance_payment_approve_amount', function ($data) {
                return number_format($data->finance_payment_approve_amount);
            });

            $datatable->editColumn('finance_payment_status', function ($data) {
                return Helper::createStatus($data->finance_payment_status, $data->status);
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
