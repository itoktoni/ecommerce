@isset($model->item_product_id)
<div class="panel panel-default">
    <div class="panel-body line">
        <div class="form-horizontal form-group">
            <div class="col-md-12 col-lg-12">
                <label class="col-md-2 control-label" for="">Upload</label>
                <div class="col-md-10">
                    <div class="form-group">
                        <form method="post"
                            action="{{ route('item_product_upload', ['code' => request()->get('code')]) }}"
                            enctype="multipart/form-data" class="dropzone" id="my-dropzone">
                            {{ csrf_field() }}
                            <div class="dz-message">
                                <div class="col-xs-12">
                                    <div class="message">
                                        <p>Drop files here or Click to Upload</p>
                                    </div>
                                </div>
                            </div>
                            <div class="fallback">
                                <input type="file" name="file" multiple>
                            </div>
                    </div>
                    </form>
                </div>
            </div>
            <div id="dropimage" class="col-md-12 col-lg-12">
                <label class="col-md-2 control-label" for="">Files</label>
                @foreach ($image_detail as $item_image)
                @isset($item_image)
                <div class="col-md-1">
                <a onclick="return confirm('Are you sure to delete image ?');" href="{{ route('item_product_delete_image', ['code' => $item_image->item_product_image_file]) }}">
                        <img
                            src="{{ Helper::files('product_detail/'.'thumbnail_'.$item_image->item_product_image_file) }}">
                            <span>Delete</span>
                    </a>
                </div>
                @endisset
                @endforeach
            </div>

        </div>
    </div>
</div>
</div>
</form>

@push('javascript')
<link rel="stylesheet" href="{{ Helper::backend('vendor/dropzone/dropzone.css') }}">
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.4.0/dropzone.js"></script>

<script type="text/javascript">
    Dropzone.options.myDropzone = {
        uploadMultiple: true,
        parallelUploads: 2,
        maxFilesize: 8,
        dictFileTooBig: 'Image is larger than 16MB',
        timeout: 10000,
        success: function (file, done) {
           new PNotify({
                title: 'Notification Success',
                text: 'Success Upload',
                type: 'success'
            });
          setTimeout(function(){location.reload()}, 1000);
        }
    };
</script>

@endpush
@endisset