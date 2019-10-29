@extends('auth.credential')
@section('content')

{!! Form::open(['class' => '']) !!}
<img src="{{ Helper::files('logo/'.config('website.logo')) }}" id="icon" alt="Logo" />
<div class="input-div one">
    <div class="{{ $errors->has('username') ? 'error' : ''}}">
        <h5>Username</h5>
        {!! Form::text('username', null, ['autofocus', 'class' => 'input']) !!}
    </div>
</div>
<div class="input-div one">
    <div class="{{ $errors->has('name') ? 'error' : ''}}">
        <h5>Name</h5>
        {!! Form::text('name', null, ['autofocus', 'class' => 'input']) !!}
    </div>
</div>
<div class="input-div one">
    <div class="{{ $errors->has('email') ? 'error' : ''}}">
        <h5>Email</h5>
        {!! Form::text('email', null, ['autofocus', 'class' => 'input']) !!}
    </div>
</div>
<div class="input-div pass">
    <div class="{{ $errors->has('password') ? 'error' : ''}}">
        <h5>Password</h5>
        {!! Form::password('password', ['class' => 'input']) !!}
    </div>
</div>
<div class="input-div pass">
    <div class="{{ $errors->has('password_confirmation') ? 'error' : ''}}">
        <h5>Confirmation</h5>
        {!! Form::password('password_confirmation', ['class' => 'input']) !!}
    </div>
</div>
<a href="{{ route('login') }}">Already have account ?</a>
<input type="submit" class="btn" value="Register">

@if ($errors->any())
@foreach ($errors->all() as $error)
@if ($loop->first)
<span class="help-block text-danger text-left">
    <strong>{{ $error }}</strong><br>
</span>
@endif
@endforeach
@endif

{!! Form::close() !!}

@endsection
   