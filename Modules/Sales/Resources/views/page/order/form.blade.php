@component('component.mask', ['array' => ['number', 'money']])
@endcomponent
@component('component.date', ['array' => ['date']])
@endcomponent
<div id="input-form">
    <div class="form-group">
        <label class="col-md-2 control-label" for="inputDefault">Order Date</label>
        <div class="col-md-4">
             {!! Form::text('sales_order_date', $model->sales_order_date ? $model->sales_order_date->format('Y-m-d') : date('Y-m-d'), ['class' => 'date'])
                !!}
        </div>
        {!! Form::label('name', 'Customer', ['class' => 'col-md-2 control-label']) !!}
        <div class="col-md-4 {{ $errors->has('sales_order_core_user_id') ? 'has-error' : ''}}">
            {{ Form::select('sales_order_core_user_id', $customer, null, ['data-placeholder' => 'please select','id' => 'customer','class'=> 'form-control']) }}
            {!! $errors->first('sales_order_core_user_id', '<p class="help-block">:message</p>') !!}
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-2 control-label" for="textareaDefault">Notes</label>
        <div class="col-md-4">
            {!! Form::textarea($form.'note', null, ['class' => 'form-control', 'rows' => '3']) !!}
        </div>

        {!! Form::label('name', 'Status', ['class' => 'col-md-2 control-label']) !!}
        <div class="col-md-4 {{ $errors->has('sales_order_status') ? 'has-error' : ''}}">
            {{ Form::select('sales_order_status',Helper::shareStatus($model->status) , null, ['class'=> 'form-control']) }}
            {!! $errors->first('sales_order_status', '<p class="help-block">:message</p>') !!}
        </div>
        @isset($model->$key)
        <hr>
        {!! Form::label('name', 'Status', ['class' => 'col-md-2 control-label']) !!}
        <div class="col-md-4">
            <input class="form-control" readonly value="{{ $model->status[$model->sales_order_status][0] }}"
                type="text">
        </div>
        @endisset
    </div>
</div>