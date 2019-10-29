<section class="footer-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-5 col-sm-6">
                <div class="footer-widget about-widget">
                    <h2>About</h2>
                    {!! config('website.description') !!}
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="footer-widget about-widget">
                    <h2>Page</h2>
                    @if ($public_page->count() > 5)
                     
                    @else
                    <ul>
                    @foreach ($public_page as $public_item_page)
                    <li><a href="">{{ $public_item_page->marketing_page_name }}</a></li>
                    @endforeach
                    @endif
                    </ul>
                    <ul>
                        <li><a href="">Bloggers</a></li>
                        <li><a href="">Support</a></li>
                        <li><a href="">Terms of Use</a></li>
                        <li><a href="">Shipping</a></li>
                        <li><a href="">Blog</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-4 col-sm-6">
                <div class="footer-widget contact-widget">
                    <h2>Address</h2>
                    <div class="con-info">
                    <p>{{ strtoupper(config('website.name')) }}</p>
                    </div>
                    <div id="address" class="con-info">
                        {!! html_entity_decode(config('website.address')) !!}
                    </div>
                    <div class="con-info">
                        <span>Phone : </span><p>{{ config('website.phone') }}</p>
                    </div>
                    <div class="con-info">
                       <span>Email : </span>
                       <a href="mailto:{{ config('website.email') }}"><p>{{ config('website.email') }}</p></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="social-links-warp">
        <div class="container">
            @include(Helper::setExtendFrontend('sosmed'))
            <p class="text-white text-center mt-5">{{ config('website.footer') }}</p>

            {{ dump(Cart::getContent()) }}
        </div>
    </div>
</section>