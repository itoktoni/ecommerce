@extends(Helper::setExtendFrontend())

@section('content')
<!-- Page info -->
<div class="page-top-info">
	<div class="container">
		<h4>Personal Data</h4>
		<div class="site-pagination">
			<a href="{{ Helper::base_url() }}">Home</a> |
			<a href="{{ route('about') }}">About</a>
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
							
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- product section end -->
@endsection