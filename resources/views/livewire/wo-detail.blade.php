<table id="transaction" class="table table-no-more table-bordered table-striped">
    <thead>
        <tr>
            <th class="text-left" style="width:50px;">ID</th>
            <th class="text-left col-md-4">Product Name</th>
            <th class="text-right col-md-1">Price</th>
            <th class="text-right col-md-1">Qty</th>
            <th class="text-right col-md-1">Total</th>
            <th id="action" class="text-center col-md-1">Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($detail as $item)
        <tr>
            <td data-title="ID Product">
                {{ $item->product->item_product_id }}
                <input type="hidden" value="{{ $item->product->item_product_id }}" name="temp[{{$loop->index}}][id]">
            </td>
            <td data-title="Product">
                {{ $item->product->item_product_name }}
                <input type="hidden" value="{{ $item->product->item_product_name }}"
                    name="temp[{{$loop->index}}][name]">
            </td>
            <td data-title="Price" class="text-right col-lg-1">
                <input type="text" name="temp_price[]"
                    class="form-control text-right money temp[{{$loop->index}}][price]"
                    value="{{ $item->production_work_order_detail_price_order }}">
            </td>
            <td data-title="Min" class="text-right col-lg-1">
                <input type="text" name="temp_qty[]" class="form-control text-right number temp[{{$loop->index}}][qty]"
                    value="{{ $item->production_work_order_detail_qty_order }}">
            </td>
            <td data-title="Total" class="text-right col-lg-1">
                <input type="text" readonly name="temp[{{$loop->index}}][total]"
                    class="form-control text-right number temp_total"
                    value="{{ $item->production_work_order_detail_total_order }}">
            </td>
            <td data-title="Action">
                @if ($action_function == 'show')
                <a id="progress" value="{{ $item->product->item_product_id }}"
                    href="{{ route(config('module').'_survey', ['code' => $item->production_work_order_detail_production_work_order_id, 'detail' => $item->product->item_product_id ]) }}"
                    class="btn btn-success btn-block">Survey</a>
                @else
                <a id="delete" value="{{ $item->product->item_product_id }}"
                    href="{{ route(config('module').'_delete', ['code' => $item->production_work_order_detail_production_work_order_id, 'detail' => $item->product->item_product_id ]) }}"
                    class="btn btn-danger btn-block delete-{{ $item->product->item_product_id }}">Delete</a>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>