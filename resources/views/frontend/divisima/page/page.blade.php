@extends(Helper::setExtendFrontend())

@section('content')
<!-- Page info -->
<div class="page-top-info">
	<div class="container">
		<h2>{{ $title }}</h2>
		<br>
		<div class="row">
			<img class="img-fluid" width="100%" src="{{ $image }}" alt="">
		</div>
		<br>
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
							{!! html_entity_decode($page) !!}
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- product section end -->
@endsection