<div id="tag" class="filter-widget mb-0">
    <h2 class="fw-title">Size</h2>
    <div class="fw-size-choose">

        @foreach ($size as $item_size)
        <div class="btn-group-toggle" style="display: initial" data-toggle="buttons">
            <label class="btn btn-light" active style="box-shadow: 1px 5px 5px rgba(0, 0, 0, 0.2);">
                <input type="checkbox" checked autocomplete="off">{{ $item_size }}
            </label>
        </div>
        @endforeach

    </div>
</div>