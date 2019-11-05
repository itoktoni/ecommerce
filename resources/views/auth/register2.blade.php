@extends('auth.credential')
@section('content')

{!! Form::open(['class' => 'form login', 'id' => 'register']) !!}
<div class="form__field_register form__field--email">
    <div class="form__input-wrapper {{ $errors->has('username') ? 'error' : ''}}">
        {!! Form::text('username', null, ['autofocus', 'class' => 'input']) !!}
    </div>
</div>
<div class="form__field_register form__field--email">
    <div class="form__input-wrapper{{ $errors->has('name') ? 'error' : ''}}">
        {!! Form::text('name', null, ['autofocus', 'class' => 'input']) !!}
    </div>
</div>
<div class="form__field_register form__field--email">
    <div class="form__input-wrapper{{ $errors->has('email') ? 'error' : ''}}">
        {!! Form::text('email', null, ['autofocus', 'class' => 'input']) !!}
    </div>
</div>
<div class="input-div pass">
    <div class="form__input-wrapper{{ $errors->has('password') ? 'error' : ''}}">
        {!! Form::password('password', ['class' => 'input']) !!}
    </div>
</div>
<div class="input-div pass">
    <div class="form__input-wrapper{{ $errors->has('password_confirmation') ? 'error' : ''}}">
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
   