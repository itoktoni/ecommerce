@extends(Helper::setExtendFrontend())

@section('content')
<!-- Page info -->
<div class="page-top-info">
	<div class="container">
		<h4>Your cart</h4>
		<div class="site-pagination">
			<a href="{{ config('app.url') }}">Home</a> /
			<a href="{{ route('cart') }}">Your cart</a>
		</div>
	</div>
</div>
<!-- Page info end -->
<!-- cart section end -->
<section class="cart-section spad">
	<div class="container">
		<div class="col-md-5 pull-right">
			@if ($errors)
			@foreach ($errors->all() as $error)
			<div style="margin-top:-20px;" class="alert alert-danger alert-dismissible fade show" role="alert">
				<strong>{{ $error }}
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
			</div>
			@endforeach
			@endif
		</div>
		@if (Cart::getContent()->count() > 0)
		<div class="row clearfix" style="clear: both;">
			{!!Form::open(['route' => 'cart', 'class' => 'header-search-form', 'files' => true]) !!}
			<div class="col-lg-12">
				<div class="cart-table">
					<div class="cart-table-warp">
						<table>
							<thead>
								<tr>
									<th class="product-th">
										<h5>Product</h5>
									</th>
									<th class="quy-th">
										<h5>Qty</h5>
									</th>
									<th class="size-th">
										<h5>Stock</h5>
									</th>
									<th class="total-th">
										<h5 class="text-right">Total</h5>
									</th>
								</tr>
							</thead>
							<tbody>
								@if (!Cart::isEmpty())
								@foreach (Cart::getContent() as $item_cart)
								<tr class="{{ $errors->has("cart.$loop->index.qty") ? 'border-error' : '' }}">
									<td class="product-col">
										<img src="{{ Helper::files('product/thumbnail_'.$item_cart->attributes['image']) }}"
											alt="{{ $item_cart->name }}">
										<div style="margin-left:60px;" class="pc-title d-none d-sm-block">
											<h4>
												<a class="text-secondary"
													href="{{ route('single_product', ['slug' => str_slug($item_cart->name)]) }}">
													{{ $item_cart->name}} {{ $item_cart->attributes['size'] }}
													{{ $item_cart->attributes['color'] }}
												</a>
											</h4>
											<p>{{ number_format($item_cart->price) }}</p>
											<a onclick="return confirm('Are you sure to delete product ?');"
												class="btn btn-danger btn-xs"
												href="{{ route('delete', ['id' => $item_cart->id ]) }}">Delete</a>
										</div>
									</td>
									<td class="quy-col">
										<div class="quantity">
											<div class="pro-qty">
												{!! Form::text("cart[$loop->index][qty]", old("cart[$loop->index][qty]") ?? $item_cart->quantity) !!}
											</div>
										</div>
									</td>
									<td class="size-col">
										<input type="hidden" value="{{ $item_cart->attributes['option'] }}" name="cart[{{ $loop->index }}][option]">
										<h4 class="text-center">Stock ( {{ $item_cart->attributes['stock'] }} )</h4>
									</td>
									<td class="total-col">
										<h4 class="text-right">{{ number_format($item_cart->quantity * $item_cart->price) }}</h4>
									</td>
								</tr>
								@endforeach
								@endif
								@if (Cart::getConditions()->count() > 0)
								<tr>
									<td class="total-col" colspan="5" style="border-top:1px solid #f51167;">
										<h4 style="margin-top:20px;float:left;">
											Redem Discount :
											{{ Cart::getConditions()->first()->getAttributes()['name'] }}
										</h4>
										<h4 style="margin-top:20px;float:right">
											{{ number_format(Cart::getConditions()->first()->getValue()) }}
										</h4>
									</td>
								</tr>
								@endif
							</tbody>
						</table>
					</div>
					<div class="total-cost">
						<h6>Total <span>{{ number_format(Cart::getTotal()) }}</span></h6>
					</div>
				</div>
			</div>

			<div style="margin-top:20px;" class="col-lg-12 card-right">
				<div class="row">
					<div class="col-lg-7" >
						<div class="row">
							<div class="col-md-6 col-sm-12 col-sx-12">
								<a style="margin-left:-10px;" href="{{ route('shop') }}"
									class="site-btn sb-dark">Continue shopping</a>
							</div>
							<div class="col-md-3 col-sm-12 col-sx-12">
								<button type="submit" class="site-btn">Update</button>
							</div>
							<div class="col-md-3 col-sm-12 col-sx-12">
							<a style="margin-left:-25px;" class="site-btn sb-dark" href="{{ route('checkout') }}">Checkout</a>
							</div>
						</div>
					</div>

					{!! Form::close() !!}

					<div class="col-md-5 col-sm-12 col-sx-12 promo-code-form">
						{!! Form::open(['route' => 'cart', 'class' => 'promo-code-form', 'files' => true]) !!}
						<input type="text" name="code" value="{{ old('code') ?? null }}" placeholder="Enter promo code">
						<button type="submit">Submit</button>
						{!! Form::close() !!}
					</div>

				</div>

			</div>
		</div>
		@else
		<div class="col-lg-12 card-right">
			<div class="row">
				<a href="{{ route('shop') }}" class="site-btn">Go to list catalog </a>
			</div>
		</div>
		@endif
	</div>
</section>
<!-- cart section end -->

@endsection

@push('javascript')

<script>
	$(document).on('click', '.add-card', function() {
	var product = $(this).attr('alt');
    $.notiny({ text: 'ADD '+product, position: 'right-top' });
});

</script>

@endpush