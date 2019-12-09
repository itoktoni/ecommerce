<?php

namespace Modules\Procurement\Dao\Repositories;

use Helper;
use Plugin\Notes;
use Illuminate\Support\Facades\DB;
use App\Dao\Interfaces\MasterInterface;
use Modules\Procurement\Dao\Repositories\PurchaseRepository;

class PurchasePrepareRepository extends PurchaseRepository implements MasterInterface
{
    public static $detail;
    public $data;
    public $mapping  = [
        'primary' => 'purchase_detail_purchase_id',
        'foreign' => 'purchase_detail_option',
        'detail' => [
            'purchase_detail_item_product_id' =>  'temp_product',
            'purchase_detail_option' =>  'temp_option',
            'purchase_detail_qty_prepare' => 'temp_qty_prepare',
            'purchase_detail_price_prepare' => 'temp_price_prepare',
            'purchase_detail_total_prepare' => 'temp_total_prepare',
        ]
    ];

    public function updateDetailRepository($id, array $data)
    {
        try {
            $where = [
                $this->mapping['primary'] => $id,
                $this->mapping['foreign'] => $data[$this->mapping['foreign']],
            ];
            $check = DB::table($this->detail_table)->updateOrInsert($where, $data);
            return Notes::create($check);
        } catch (\Illuminate\Database\QueryException $ex) {
            return Notes::error($ex->getMessage());
        }
    }
}
