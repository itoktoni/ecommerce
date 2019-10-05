<div class="form-group">
    {!! Form::label('name', 'Name', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has($form.'name') ? 'has-error' : ''}}">
        {!! Form::text($form.'name', null, ['class' => 'form-control']) !!}
        {!! $errors->first($form.'name', '<p class="help-block">:message</p>') !!}
    </div>

    {!! Form::label('name', 'Slug', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has($form.'slug') ? 'has-error' : ''}}">
        {!! Form::text($form.'slug', null, ['class' => 'form-control']) !!}
        {!! $errors->first($form.'slug', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('name', 'Buying Price', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has($form.'buy') ? 'has-error' : ''}}">
        {!! Form::number($form.'buy', null, ['class' => 'form-control']) !!}
        {!! $errors->first($form.'buy', '<p class="help-block">:message</p>') !!}
    </div>

    {!! Form::label('name', 'Selling Price', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has($form.'sell') ? 'has-error' : ''}}">
        {!! Form::number($form.'sell', null, ['class' => 'form-control']) !!}
        {!! $errors->first($form.'sell', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<hr>

<div class="form-group">
    {!! Form::label('name', 'Minimal Stock', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has($form.'min') ? 'has-error' : ''}}">
        {!! Form::number($form.'min', null, ['class' => 'form-control']) !!}
        {!! $errors->first($form.'min', '<p class="help-block">:message</p>') !!}
    </div>

    {!! Form::label('name', 'Max Stock', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has($form.'max') ? 'has-error' : ''}}">
        {!! Form::number($form.'max', null, ['class' => 'form-control']) !!}
        {!! $errors->first($form.'max', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('name', 'Material', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has($form.'item_material_id') ? 'has-error' : ''}}">
        {{ Form::select($form.'item_material_id', $material, null, ['class'=> 'form-control', 'data-plugin-selectTwo']) }}
        {!! $errors->first($form.'item_material_id', '<p class="help-block">:message</p>') !!}
    </div>

    {!! Form::label('name', 'Unit', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has($form.'item_unit_id') ? 'has-error' : ''}}">
        {{ Form::select($form.'item_unit_id', $unit, null, ['class'=> 'form-control', 'data-plugin-selectTwo']) }}
        {!! $errors->first($form.'item_unit_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('name', 'Category', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has($form.'item_category_id') ? 'has-error' : ''}}">
        {{ Form::select($form.'item_category_id', $category, null, ['class'=> 'form-control', 'data-plugin-selectTwo']) }}
        {!! $errors->first($form.'item_category_id', '<p class="help-block">:message</p>') !!}
    </div>

    {!! Form::label('name', 'Currency', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has($form.'item_currency_id') ? 'has-error' : ''}}">
        {{ Form::select($form.'item_currency_id', $currency, null, ['class'=> 'form-control', 'data-plugin-selectTwo']) }}
        {!! $errors->first($form.'item_currency_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('name', 'Vendor', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has('item_product_production_vendor_id') ? 'has-error' : ''}}">
        {{ Form::select('item_product_production_vendor_id', $production, null, ['class'=> 'form-control', 'data-plugin-selectTwo']) }}
        {!! $errors->first('item_product_production_vendor_id', '<p class="help-block">:message</p>') !!}
    </div>

    {!! Form::label('name', 'SKU', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has($form.'sku') ? 'has-error' : ''}}">
        {!! Form::text($form.'sku', null, ['class' => 'form-control']) !!}
        {!! $errors->first($form.'sku', '<p class="help-block">:message</p>') !!}
    </div>

</div>

<div class="form-group">

    {!! Form::label('name', 'Image', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has($form.'image') ? 'has-error' : ''}}">
        <input type="file" name="{{ $form.'file' }}"
            class="{{ $errors->has($form.'file') ? 'has-error' : ''}} btn btn-default btn-sm btn-block">
        {!! $errors->first($form.'image', '<p class="help-block">:message</p>') !!}
    </div>

    {!! Form::label('name', 'Description', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-{{ isset($model->item_product_image) && !empty($model->item_product_image) ? '2' : '4' }}">
        {!! Form::textarea($form.'description', null, ['class' => 'form-control', 'rows' => '3']) !!}
    </div>

    <div class="col-md-2">
        @isset ($model)
        <img class="img-thumbnail" src="{{ Helper::files($template.'/thumbnail_'.$model->item_product_image) }}" alt="">
        @endisset
    </div>
</div>