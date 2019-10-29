@extends(Helper::setExtendFrontend())

@section('content')

<!-- Page info -->
<div class="page-top-info">
	<div class="container">
		<h4>Product Detail</h4>
		<div class="site-pagination">
			<a href="{{ Helper::base_url() }}">Home</a> /
			<a href="{{ route('shop') }}">Shop</a> /
			<a href="{{ route('single_product', ['slug' => $single_product->item_product_slug]) }}">Product</a>
		</div>
	</div>
</div>

<!-- Page info end -->
{!! Form::model($single_product, ['route'=> ['single_product', 'slug' =>
$single_product->item_product_slug],'class'=>'form-horizontal','files'=>true])
!!}
<!-- product section -->
<section id="pjax" class="product-section">
	<div class="container">
		<div class="row">
			<div class="col-lg-6">
				<div class="product-pic-zoom">
					<img class="product-big-img"
						src="{{ Helper::files('product/'.$single_product->item_product_image) }}"
						alt="{{ $single_product->item_product_name }}">
				</div>
				<div class="product-thumbs" tabindex="1" style="overflow: hidden; outline: none;">
					<div class="product-thumbs-track">
						<div class="pt" data-imgbigurl="{{ Helper::files('product/'.$single_product->item_product_image) }}">
							<img src="{{ Helper::files('product/thumbnail_'.$single_product->item_product_image) }}"
								alt="{{ $single_product->item_product_name }}">
						</div>
						@foreach ($product_image as $item_product_image)
						<div class="pt"
							data-imgbigurl="{{ Helper::files('product_detail/'.$item_product_image->item_product_image_file) }}">
							<img src="{{ Helper::files('product_detail/thumbnail_'.$item_product_image->item_product_image_file) }}"
								alt="{{ $item_product_image->item_product_image_file }}">
						</div>
						@endforeach
					</div>
				</div>
			</div>
			<div class="col-lg-6 product-details">
				<h2 class="p-title">{{ $single_product->item_product_name }}</h2>
				@if ($discount > 0)
				<h3 class="p-price coret">Price {{ number_format($single_product->item_product_sell) }}</h3>
				<h3 class="p-price">After Discount {{ number_format($single_product->item_product_sell - $discount) }}
				</h3>
				@else
				<h3 class="p-price">Price {{ number_format($single_product->item_product_sell) }}</h3>
				@endif
				@if($stock->count() > 0)
				<h5 style="margin-top:50px;"> Available Stock </h5>
				<div id="option_product" class="col-md-5">
					<div class="row">
						{{ Form::select('option', $list, old('option') ?? null, ['class' => 'form-control']) }}
					</div>
				</div>
				<div class="quantity">
					<p>Quantity</p>
				<div class="pro-qty"><input type="text" name="qty" value="{{ old('qty') ?? 1}}"></div>
				</div>
				<button type="submit" id="pjax" class="site-btn">SHOP NOW</button>
				@else
				<button type="button" class="site-btn">Out Of Stock</button>
				@endif
				<div id="accordion" class="accordion-area">
					<div class="panel">
						<div class="panel-header" id="headingOne">
							<button class="panel-link active" data-toggle="collapse" data-target="#collapse1"
								aria-expanded="true" aria-controls="collapse1">information</button>
						</div>
						<div id="collapse1" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
							<div class="panel-body">
								<p>{!! html_entity_decode($single_product->item_product_description) !!}</p>
							</div>
						</div>
					</div>
					<div class="panel">
						<div class="panel-header" id="headingTwo">
							<button class="panel-link" data-toggle="collapse" data-target="#collapse2"
								aria-expanded="false" aria-controls="collapse2">care details </button>
						</div>
						<div id="collapse2" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
							<div class="panel-body">
								<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin pharetra tempor so
									dales. Phasellus sagittis auctor gravida. Integer bibendum sodales arcu id te mpus.
									Ut consectetur lacus leo, non scelerisque nulla euismod nec.</p>
							</div>
						</div>
					</div>
					<div class="panel">
						<div class="panel-header" id="headingThree">
							<button class="panel-link" data-toggle="collapse" data-target="#collapse3"
								aria-expanded="false" aria-controls="collapse3">shipping & Returns</button>
						</div>
						<div id="collapse3" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
							<div class="panel-body">
								<h4>7 Days Returns</h4>
								<p>Cash on Delivery Available<br>Home Delivery <span>3 - 4 days</span></p>
								<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin pharetra tempor so
									dales. Phasellus sagittis auctor gravida. Integer bibendum sodales arcu id te mpus.
									Ut consectetur lacus leo, non scelerisque nulla euismod nec.</p>
							</div>
						</div>
					</div>
				</div>
				<div class="social-sharing">
					<a href=""><i class="fa fa-google-plus"></i></a>
					<a href=""><i class="fa fa-pinterest"></i></a>
					<a href=""><i class="fa fa-facebook"></i></a>
					<a href=""><i class="fa fa-twitter"></i></a>
					<a href=""><i class="fa fa-youtube"></i></a>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- product section end -->
{!! Form::close() !!}
@endsection