@component('component.summernote', ['array' => ['basic']])

@endcomponent
<div class="form-group">

    {!! Form::label('name', 'Name', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has($form.'name') ? 'has-error' : ''}}">
        {!! Form::text($form.'name', null, ['class' => 'form-control']) !!}
        {!! $errors->first($form.'name', '<p class="help-block">:message</p>') !!}
    </div>

    {!! Form::label('name', 'Default', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has($form.'default') ? 'has-error' : ''}}">
        {{ Form::select($form.'default', ['0' => 'No', '1' => 'Yes'], $model->marketing_promo_default ?? null, ['class'=> 'form-control']) }}
        {!! $errors->first($form.'default', '<p class="help-block">:message</p>') !!}
    </div>

</div>

<div class="form-group">

    {!! Form::label('name', 'Image', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has($form.'file') ? 'has-error' : ''}}">
        <input type="hidden" value="{{ $form.'image' }}" name="$form.'image'">
        <input type="file" name="{{ $form.'file' }}"
            class="{{ $errors->has($form.'file') ? 'has-error' : ''}} btn btn-default btn-sm btn-block">
        {!! $errors->first($form.'file', '<p class="help-block">:message</p>') !!}
    </div>

    {!! Form::label('name', 'Status', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-4 {{ $errors->has($form.'status') ? 'has-error' : ''}}">
        {{ Form::select($form.'status', $status, null, ['class'=> 'form-control']) }}
        {!! $errors->first($form.'status', '<p class="help-block">:message</p>') !!}
    </div>

</div>
<div class="form-group">
    {!! Form::label('name', 'Description', ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-10">
        {!! Form::textarea($form.'description', null, ['class' => 'form-control', 'rows' => '5']) !!}
    </div>
</div>
<div class="form-group">

    <div class="col-md-2">
        @isset($model->{$form.'image'})
        <img class="img-thumbnail" src="{{ Helper::files('promo/'.$model->{$form.'image'}) }}" alt="">
        @endisset
    </div>

    <div class="col-md-10">
        {!! Form::textarea($form.'page', null, ['class' => 'form-control basic', 'rows' => '5']) !!}
    </div>
</div>