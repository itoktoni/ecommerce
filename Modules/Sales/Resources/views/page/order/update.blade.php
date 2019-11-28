<div class="panel-body {{ $errors->has('temp_id') ? 'has-error' : ''}}">
    <div class="panel panel-default">
        <div class="row">
            <div class="col-md-6">
                @if ($model->$key && !old('temp_id'))
                <h2 id="total" class="panel-title text-left">
                    <span id="total_name">Total</span> <span class="money"
                        id="total_value">{{ number_format($detail->sum('sales_order_detail_total_order')) }}</span>
                    <input type="hidden" id="hidden_total" value="{{ $detail->sum('sales_order_detail_total_order') }}"
                        name="total">
                </h2>
                @else
                <h2 id="total" class="panel-title text-left">
                    <span id="total_name">{{ old('total') ? 'Total' : '' }}</span> <span class="money"
                        id="total_value">{{ old('total') ? number_format(old('total')) : '' }}</span>
                    <input type="hidden" id="hidden_total" value="{{ old('total') ? old('total') : 0 }}" name="total">
                </h2>
                @endif
            </div>
        </div>
        <div class="panel-body line">
            <div class="col-md-12 col-lg-12">
                @include($folder.'::page.'.$template.'.list_update')
            </div>
        </div>

    </div>
</div>