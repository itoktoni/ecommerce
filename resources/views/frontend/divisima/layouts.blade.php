<!DOCTYPE html>
<html lang="zxx">

<head>
    @include(Helper::setExtendFrontend('meta'))
    @stack('css')
</head>

<body>
    <!-- Page Preloder -->
    {{-- <div id="preloder">
        <div class="loader"></div>
    </div> --}}
    @include(Helper::setExtendFrontend('header'))
    <div id="pjax">
        @yield('content')
    </div>
    @include(Helper::setExtendFrontend('footer'))
    @include(Helper::setExtendFrontend('js'))

    <div id="alert">
        @if ($errors->any())
        <script type="text/javascript">
            $(function() {
                @foreach ($errors->all() as $error)
                    $.notiny({ text: '{{ $error }}', position: 'right-top' });
                @endforeach
            });
        </script>
        @endif
    </div>

</body>
@stack('js')
<script>
$(document).ready(function() {
    $("select.form-control.chosen").chosen();
    $(".date").flatpickr({
        altInput: true,
        altFormat: "j F Y",
        dateFormat: "Y-m-d",
    });
});
</script>
</html>