<?php

namespace Modules\Item\Dao\Repositories;

use Helper;
use Plugin\Notes;
use Illuminate\Support\Facades\DB;
use Modules\Item\Dao\Models\Stock;
use App\Dao\Interfaces\MasterInterface;
use Illuminate\Database\QueryException;
use Modules\Item\Dao\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ReportRepository extends Stock implements FromCollection, WithHeadings, ShouldAutoSize
{
    public function headings(): array
    {
        return [
            'Product ID',
            'Color',
            'Name',
        ];
    }

    public function collection()
    {
        $model = new StockRepository();
        return $stock = $model->dataRepository()->get();
    }
}
