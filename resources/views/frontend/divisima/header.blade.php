<!-- Header section -->
<header class="header-section">
    <div class="header-top">
        <div class="container">
            <div class="row">
                <div class="col-lg-2 text-center text-lg-left">
                    <!-- logo -->
                    <a href="{{ Helper::base_url() }}" class="site-logo">
                        <img src="{{ Helper::files('logo/'.config('website.logo')) }}" alt="">
                    </a>
                </div>
                <div class="col-xl-6 col-lg-5">
                    <form class="header-search-form">
                        <input type="text" placeholder="Search on divisima ....">
                        <button><i class="flaticon-search"></i></button>
                    </form>
                </div>
                <div class="col-xl-4 col-lg-5">
                    <div class="user-panel">
                        <div class="up-item">
                            <i class="flaticon-profile"></i>
                            <a href="{{ route('login') }}">Sign In</a> or <a href="{{ route('register') }}">Create
                                Account</a>
                        </div>
                        <div class="up-item">
                            <div class="shopping-card">
                                <i class="flaticon-bag"></i>
                                <span>0</span>
                            </div>
                            <a href="{{ route('cart') }}">Shopping Cart</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <nav class="main-navbar">
        <div class="container">
            <!-- menu -->
            <ul class="main-menu">
                <li><a href="{{ config('app.url') }}">Home</a></li>
                <li><a href="{{ route('about') }}">About</a>
                <li><a href="{{ route('shop') }}">Shop <span class="new"> Sale </span></a></li>
                <li><a href="{{ route('category') }}">Category</a>
                    @isset($public_category)
                    <ul class="sub-menu">
                        @foreach ($public_category as $category_item)
                        <li><a
                                href="{{ route('single_category', ['slug' => $category_item->item_category_slug]) }}">{{ ucfirst($category_item->item_category_name) }}</a>
                        </li>
                        @endforeach
                    </ul>
                    @endisset
                </li>
                <li><a href="{{ route('promo') }}">Promo</a>
                <li><a href="{{ route('contact') }}">Contact Us</a></li>
            </ul>
        </div>
    </nav>
</header>
<!-- Header section end -->