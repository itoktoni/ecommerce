<div class="filter-widget mb-0">
    <h2 class="fw-title">color by</h2>
    <div class="fw-color-choose">
        @foreach ($color as $item_color)

        <div class="cs-item">
            <a href="{{ $item_color }}">
            <label style="background:#{{ $item_color }}"></label>
            </a>
        </div>
        @endforeach
        
    </div>
</div>