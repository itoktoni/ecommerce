@if(!config('website.pjax'))
@push('css')
<link rel="stylesheet" href="{{ Helper::backend('vendor/summernote/summernote-lite.min.css') }}">
@endpush

@push('js')
<script src="{{ Helper::backend('vendor/summernote/summernote-lite.min.js') }}"></script>
@endpush
@endif
@if (isset($array) && in_array('lite', $array))
@push('javascript')
<script>
    $('.lite').summernote({
        toolbar: [
            ['fontsize', ['fontsize','ul', 'ol', 'paragraph', 'height']],
        ],
        height: 200
        });
</script>
@endpush
@endif

@if (isset($array) && in_array('basic', $array))
@push('javascript')
<script>
    $('.basic').summernote({
        height: 300
    });
</script>
@endpush
@endif