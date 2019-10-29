@extends('auth.credential')
@section('content')

{!! Form::open(['class' => '']) !!}
<img src="{{ Helper::files('logo/'.config('website.logo')) }}" id="icon" alt="Logo" />
<div class="input-div one">
    <div class="i">
        <i class="fas fa-user"></i>
    </div>
    <div class="div">
        <h5>Username</h5>
        {!! Form::text('login', null, ['autofocus', 'class' => 'input']) !!}
    </div>
</div>
<div class="input-div pass">
    <div class="i">
        <i class="fas fa-lock"></i>
    </div>
    <div class="div">
        <h5>Password</h5>
        {!! Form::password('password', ['class' => 'input']) !!}
    </div>
</div>
<a href="{{ route('password.request') }}">Forgot Password?</a>
<input type="submit" class="btn" value="Login">

<div style="height: 50px;margin-top: -10px;font-size: 12px;" class="text-left p-t-10">
    @if ($errors->any())
    @foreach ($errors->all() as $error)
    <span class="help-block text-danger text-left">
        <strong>{{ $error }}</strong><br>
    </span>
    @endforeach
    @endif
</div>

{!! Form::close() !!}



@endsection