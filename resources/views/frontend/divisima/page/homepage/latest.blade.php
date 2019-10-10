<!-- letest product section -->
<section class="top-letest-product-section">
    <div class="container">
        <div class="section-title">
            <h2>LATEST PRODUCTS</h2>
        </div>
        <div class="product-slider owl-carousel">
            @foreach ($public_product->slice(0,5)->all() as $homepage_public)
            <div class="product-item">
                <div class="pi-pic">
                    <a href="{{ route('single_product', ['slug' => $homepage_public->item_product_slug]) }}">
                        <img src="{{ Helper::files('product/'.$homepage_public->item_product_image) }}"
                            alt="{{ $homepage_public->item_product_name }}">
                    </a>
                    <div class="pi-links">
                        <a href="#" class="add-card"><i class="flaticon-bag"></i><span>ADD TO CART</span></a>
                        @auth
                        <a href="#" class="wishlist-btn"><i class="flaticon-heart"></i></a>
                        @endauth
                    </div>
                </div>
                <a href="{{ route('single_product', ['slug' => $homepage_public->item_product_slug]) }}">
                    <div class="pi-text">
                        <h6>{{ number_format($homepage_public->item_product_sell) }}</h6>
                        <p>{{ $homepage_public->item_product_name }}</p>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>
<!-- letest product section end -->