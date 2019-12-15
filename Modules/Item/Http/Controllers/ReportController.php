<?php

namespace Modules\Item\Http\Controllers;

use Helper;
use Plugin\Response;
use App\Http\Controllers\Controller;
use Modules\Item\Dao\Repositories\ReportRepository;
use Maatwebsite\Excel\Excel;

class ReportController extends Controller
{
    public $template;
    public $folder;
    public $excel;
    public static $model;

    public function __construct(Excel $excel)
    {
        if (self::$model == null) {
            self::$model = new ReportRepository();
        }
        $this->excel = $excel;
        $this->template  = Helper::getTemplate(__CLASS__);
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

    public function stock()
    {
        if (request()->isMethod('POST')) {
           return $this->excel->download(new ReportRepository(), 'test.xlsx');
        }
        return view(Helper::setViewForm($this->template, __FUNCTION__, config('folder')))->with($this->share());
    }
}
