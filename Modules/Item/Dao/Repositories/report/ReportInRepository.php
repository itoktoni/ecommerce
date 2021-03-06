<?php

namespace Modules\Item\Dao\Repositories\report;

use Helper;
use Plugin\Notes;
use Illuminate\Support\Facades\DB;
use Modules\Item\Dao\Models\Color;
use Modules\Item\Dao\Models\Stock;
use Modules\Item\Dao\Models\Product;
use App\Dao\Interfaces\MasterInterface;
use Illuminate\Database\QueryException;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Modules\Item\Dao\Repositories\StockRepository;
use Modules\Procurement\Dao\Models\PurchaseDetail;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Modules\Procurement\Dao\Repositories\PurchaseRepository;

class ReportInRepository extends Stock implements FromCollection, WithHeadings, ShouldAutoSize, WithColumnFormatting
{
    public function headings(): array
    {
        return [
            'Purchase ID',
            'Date',
            'Product Name',
            'Product ID',
            'Color',
            'Size',
            'SKU',
            'Qty',
        ];
    }

    public function collection()
    {
        $query = DB::table('view_purchase')
            ->where('purchase_detail_qty_prepare', '>', 0)
            ->select(['purchase_id', 'purchase_date','item_product_name', 'item_product_id', 'item_color_name', 'purchase_detail_size', 'purchase_detail_option', 'purchase_detail_qty_prepare']);
        if ($product = request()->get('product')) {
            $query->where('item_product_id', $product);
        }
        if ($color = request()->get('color')) {
            $query->where('purchase_detail_color_id', $color);
        }
        if ($size = request()->get('size')) {
            $query->where('purchase_detail_size', $size);
        }
        return $query->get();
    }

    public function columnFormats(): array
    {
        return [
            'B' => NumberFormat::FORMAT_DATE_DATETIME,
            'G' => NumberFormat::FORMAT_NUMBER,
            'H' => NumberFormat::FORMAT_NUMBER,
        ];
    }
}
