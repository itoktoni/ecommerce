@if(config('website.env') == 'local')
@include(Helper::setExtendBackend('jsdev'))
@else
@include(Helper::setExtendBackend('jspro'))
@endif
@stack('js')
<script src="{{ Helper::backend('vendor/jquery/jquery.checkboxes.js') }}"></script>
<script src="{{ Helper::backend('vendor/jquery/jquery.alertable.min.js') }}"></script>
<script src="{{ Helper::backend('vendor/jquery/arrow-table.min.js') }}"></script>
<script src="{{ Helper::backend('vendor/pnotify/pnotify.custom.js') }}"></script>
<script src="{{ Helper::backend('javascripts/theme.custom.js') }}"></script>
@if(config('website.pjax'))
<script src="{{ Helper::backend('javascripts/pjax.js') }}"></script>
@endif