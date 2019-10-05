<!DOCTYPE html>
<html lang="zxx">

<head>
    @include(Helper::setExtendFrontend('meta'))
</head>

<body>
    <!-- Page Preloder -->
    {{-- <div id="preloder">
        <div class="loader"></div>
    </div> --}}
    
    @include(Helper::setExtendFrontend('header'))
    
    @yield('content')
    @include(Helper::setExtendFrontend('footer'))
    @include(Helper::setExtendFrontend('js'))

</body>

</html>