<!DOCTYPE html>
<html>

<head>
    <title>{{ config('website.name', 'Laravel') }}</title>
    <link href="{{ Helper::files('logo/'.config('website.favicon','default_favicon.png')) }}" rel="shortcut icon">
    <link rel="stylesheet" type="text/css" href="{{ Helper::credential('default/css/style.min.css') }}">
    <link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet">
</head>

<body>
    <img class="wave" src="{{ Helper::credential('default/img/w.svg') }}">
    <div class="container">
        <div class="img">
            <img src="{{ Helper::credential('default/img/bg.svg') }}">
        </div>
        <div class="login-content">
            @yield('content')
        </div>
    </div>
    <script type="text/javascript" src="{{ Helper::credential('default/js/main.js') }}"></script>
</body>

</html>