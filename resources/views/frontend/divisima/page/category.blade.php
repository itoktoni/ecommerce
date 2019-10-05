@extends(Helper::setExtendFrontend())

@section('content')
<!-- Page info -->
<div class="page-top-info">
	<div class="container">
		<h4>Category Product</h4>
		<div class="site-pagination">
			<a href="">Home</a> /
			<a href="">Category</a> /
		</div>
	</div>
</div>
<!-- Page info end -->

<!-- Category section -->
<section id="category" class="category-section spad">
	<div class="container">
		<div class="row">
			<div class="col-lg-12  order-1 order-lg-2 mb-5 mb-lg-0">
				<div class="row">
					<div class="col-lg-3 col-sm-6">
						<div class="product-item">
							<a href="">
								<div class="pi-pic">
									<div class="tag-sale">New</div>
									<img src="{{ Helper::frontend('img/product/6.jpg') }}" alt="">
								</div>
								<div class="pi-text">
									<p class="text-center">Black and White Stripes Dress</p>
								</div>
							</a>
						</div>
					</div>
					<div class="col-lg-3 col-sm-6">
						<div class="product-item">
							<div class="pi-pic">
								<img src="{{ Helper::frontend('img/product/7.jpg') }}" alt="">
							</div>
							<div class="pi-text">
								<p class="text-center">Flamboyant Pink Top</p>
							</div>
						</div>
					</div>
					<div class="col-lg-3 col-sm-6">
						<div class="product-item">
							<div class="pi-pic">
								<img src="{{ Helper::frontend('img/product/8.jpg') }}" alt="">

							</div>
							<div class="pi-text">

								<p class="text-center">Flamboyant Pink Top </p>
							</div>
						</div>
					</div>
					<div class="col-lg-3 col-sm-6">
						<div class="product-item">
							<div class="pi-pic">
								<img src="{{ Helper::frontend('img/product/10.jpg') }}" alt="">

							</div>
							<div class="pi-text">

								<p class="text-center">Black and White Stripes Dress</p>
							</div>
						</div>
					</div>
					<div class="col-lg-3 col-sm-6">
						<div class="product-item">
							<div class="pi-pic">
								<img src="{{ Helper::frontend('img/product/11.jpg') }}" alt="">

							</div>
							<div class="pi-text">

								<p class="text-center">Flamboyant Pink Top</p>
							</div>
						</div>
					</div>
					<div class="col-lg-3 col-sm-6">
						<div class="product-item">
							<div class="pi-pic">
								<img src="{{ Helper::frontend('img/product/12.jpg') }}" alt="">

							</div>
							<div class="pi-text">

								<p class="text-center">Flamboyant Pink Top </p>
							</div>
						</div>
					</div>
					<div class="col-lg-3 col-sm-6">
						<div class="product-item">
							<div class="pi-pic">
								<img src="{{ Helper::frontend('img/product/5.jpg') }}" alt="">

							</div>
							<div class="pi-text">

								<p class="text-center">Flamboyant Pink Top</p>
							</div>
						</div>
					</div>
					<div class="col-lg-3 col-sm-6">
						<div class="product-item">
							<div class="pi-pic">
								<img src="{{ Helper::frontend('img/product/9.jpg') }}" alt="">

							</div>
							<div class="pi-text">

								<p class="text-center">Flamboyant Pink Top</p>
							</div>
						</div>
					</div>
					<div class="col-lg-3 col-sm-6">
						<div class="product-item">
							<div class="pi-pic">
								<img src="{{ Helper::frontend('img/product/1.jpg') }}" alt="">

							</div>
							<div class="pi-text">

								<p class="text-center">Flamboyant Pink Top </p>
							</div>
						</div>
					</div>
					<div class="col-lg-3 col-sm-6">
						<div class="product-item">
							<div class="pi-pic">
								<div class="tag-new">new</div>
								<img src="{{ Helper::frontend('img/product/2.jpg') }}" alt="">

							</div>
							<div class="pi-text">

								<p class="text-center">Black and White Stripes Dress</p>
							</div>
						</div>
					</div>
					<div class="col-lg-3 col-sm-6">
						<div class="product-item">
							<div class="pi-pic">
								<img src="{{ Helper::frontend('img/product/3.jpg') }}" alt="">

							</div>
							<div class="pi-text">

								<p class="text-center">Flamboyant Pink Top </p>
							</div>
						</div>
					</div>
					<div class="col-lg-3 col-sm-6">
						<div class="product-item">
							<div class="pi-pic">
								<img src="{{ Helper::frontend('img/product/4.jpg') }}" alt="">

							</div>
							<div class="pi-text">

								<p class="text-center">Flamboyant Pink Top </p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- Category section end -->
@endsection