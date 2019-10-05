@component('component.select2')
@endcomponent
@component('component.mask', ['array' => ['money']])
@endcomponent

<div class="form-group">

    {!! Form::label('name', 'Payment Date', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4">
        <div class="input-group">
            {!! Form::text($form.'date', $model->finance_payment_date ??
            date('Y-m-d'), ['class' => 'date
            form-control', 'readonly', 'data-plugin-datepicker'])
            !!}
            <span class="input-group-addon">
                <i class="fa fa-calendar"></i>
            </span>
        </div>
    </div>

    {!! Form::label('name', 'Status', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has($form.'status') ? 'has-error' : ''}}">
        {{ Form::select($form.'status', $status, null, ['class'=> 'form-control']) }}
        {!! $errors->first($form.'status', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group">

    {!! Form::label('name', 'Key', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has($form.'key') ? 'has-error' : ''}}">
        {{ Form::select($form.'key',$order, null, ['class'=> 'form-control', 'data-plugin-selectTwo' ,'id' => 'reference']) }}
        {!! $errors->first($form.'key', '<p class="help-block">:message</p>') !!}
    </div>

    {!! Form::label('name', 'Reference Person', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4">
        {!! Form::text($form.'person', null, ['class' => 'form-control']) !!}
    </div>

</div>

<div class="form-group">
    {!! Form::label('name', 'Account', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has($form.'payment_account_id') ? 'has-error' : ''}}">
        {{ Form::select($form.'payment_account_id', $account, null, ['class'=> 'form-control', 'data-plugin-selectTwo']) }}
        {!! $errors->first($form.'payment_account_id', '<p class="help-block">:message</p>') !!}
    </div>

    <label class="col-md-2 control-label">Attachment</label>
    <div class="col-md-4 {{ $errors->has('files') ? 'has-error' : ''}}">
        {!! Form::file('files', ['class' => 'btn btn-default btn-sm btn-block']) !!}
    </div>

</div>
<div class="form-group">

    {!! Form::label('name', 'Amount', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has($form.'approve_amount') ? 'has-error' : ''}}">
        {!! Form::text($form.'approve_amount', null, ['class' => 'form-control money']) !!}
        {!! $errors->first($form.'approve_amount', '<p class="help-block">:message</p>') !!}
    </div>

    {!! Form::label('name', 'Description', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has($form.'note') ? 'has-error' : ''}}">
        {!! Form::textarea($form.'note', null, ['class' => 'form-control', 'rows' => '3']) !!}
        {!! $errors->first($form.'note', '<p class="help-block">:message</p>') !!}
    </div>
</div>