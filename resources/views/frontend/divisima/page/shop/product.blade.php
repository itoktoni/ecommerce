<div class="row">
    @foreach ($product as $item_product)
    <div class="col-lg-4 col-sm-6">
        <div class="product-item">
            <div class="pi-pic">
                <a href="{{ route('single_product', ['slug' => $item_product->item_product_slug]) }}">
                    <img src="{{ Helper::files('product/'.$item_product->item_product_image) }}"
                        alt="{{ $item_product->item_product_name }}">
                </a>
                <div class="pi-links">
                    <a href="#" class="add-card"><i class="flaticon-bag"></i><span>ADD TO CART</span></a>
                    @auth
                    <a href="#" class="wishlist-btn"><i class="flaticon-heart"></i></a>
                    @endauth
                </div>
            </div>
            <a href="{{ route('single_product', ['slug' => $item_product->item_product_slug]) }}">
                <div class="pi-text">
                    <h6>{{ number_format($item_product->item_product_sell) }}</h6>
                    <p>{{ $item_product->item_product_name }}</p>
                </div>
            </a>
        </div>
    </div>
    @endforeach
    
    <div class="text-xs-center text-center pagination pagination-centered w-100 pt-3">

        {{ $product->render("pagination::bootstrap-4") }}

    </div>
</div>