<div class="filter-widget mb-0">
    <h2 class="fw-title">Brand</h2>
    <ul class="category-menu">
        @foreach ($brand as $key => $item_brand)
        <li><a href="{{ route('single_brand', ['slug' => $item_brand]) }}">{{ $key }}</a></li>
        @endforeach
    </ul>
</div>