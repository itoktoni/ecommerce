@push('css')
<link rel="stylesheet" href="{{ Helper::backend('vendor/flatpickr/flatpickr.min.css') }}">
@endpush

@push('js')
<script src="{{ Helper::backend('vendor/flatpickr/flatpickr.min.js') }}"></script>
@endpush

@push('javascript')
    <script>
        $(".date").flatpickr({
            altInput: true,
            altFormat: "j F Y",
            dateFormat: "Y-m-d",
        });
    </script>
@endpush