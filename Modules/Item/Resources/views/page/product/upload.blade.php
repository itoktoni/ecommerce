@isset($model->item_product_id)
<div class="form-horizontal">
    <label class="col-md-2 control-label" for="">Upload</label>
    <div class="col-md-10">
        <form method="post" action="{{ route('item_product_upload', ['code' => request()->get('code')]) }}" enctype="multipart/form-data" class="dropzone"
            id="my-dropzone">
            {{ csrf_field() }}
            <div class="">
                <div class="message">
                    <p>Drop files here or Click to Upload</p>
                </div>
            </div>
        </form>
    </div>
</div>

</form>

@push('javascript')
<link rel="stylesheet" href="{{ Helper::backend('vendor/dropzone/dropzone.css') }}">
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.4.0/dropzone.js"></script>

<script type="text/javascript">
    Dropzone.options.dropzone =
        {
        maxFilesize: 12,
        renameFile: function(file) {
            var dt = new Date();
            var time = dt.getTime();
            return time+file.name;
        },
        acceptedFiles: ".jpeg,.jpg,.png,.gif",
        addRemoveLinks: true,
        timeout: 5000,
        success: function(file, response) 
        {
            return new PNotify({
                title: 'Notification Success',
                text: 'Success Upload',
                type: 'success'
            });
        },
        error: function(file, response)
        {
            return false;
        }
    };
</script>

@endpush
@endisset