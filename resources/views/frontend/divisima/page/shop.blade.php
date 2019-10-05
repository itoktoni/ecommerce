@extends(Helper::setExtendFrontend())

@section('content')
<!-- Page info -->
<div class="page-top-info">
	<div class="container">
		<h4>Catalog Product</h4>
		<div class="site-pagination">
			<a href="">Home</a> /
			<a href="">Shop</a> /
		</div>
	</div>
</div>
<!-- Page info end -->

<!-- Category section -->
<section class="category-section spad">
	<div class="container">
		<div class="row">
			<div class="col-lg-3 order-2 order-lg-1">
				@include(Helper::setExtendFrontend('shop.category', true))
				@include(Helper::setExtendFrontend('shop.price', true))
				@include(Helper::setExtendFrontend('shop.color', true))
				@include(Helper::setExtendFrontend('shop.size', true))
				@include(Helper::setExtendFrontend('shop.brand', true))
				@include(Helper::setExtendFrontend('shop.tag', true))
			</div>

			<div class="col-lg-9  order-1 order-lg-2 mb-5 mb-lg-0">
				@include(Helper::setExtendFrontend('shop.product', true))
			</div>
		</div>
	</div>
</section>
<!-- Category section end -->
@endsection