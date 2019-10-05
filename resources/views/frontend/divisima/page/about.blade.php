@extends(Helper::setExtendFrontend())

@section('content')
<!-- Page info -->
<div class="page-top-info">
	<div class="container">
		<h4>About Page</h4>
		<div class="site-pagination">
			<a href="">Home</a> /
			<a href="">about</a>
		</div>
	</div>
</div>
<!-- Page info end -->


<!-- product section -->
<section class="product-section">
	<div class="container">
		<div class="row">
			<div class="col-lg-12 product-details">
				<div class="panel">
					<div aria-labelledby="headingOne" data-parent="#accordion">
						<div class="panel-body">
							{!! html_entity_decode(config('website.about')) !!}
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- product section end -->
@endsection