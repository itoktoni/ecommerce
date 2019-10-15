@extends(Helper::setExtendFrontend())

@section('content')
<!-- Page info -->
<div class="page-top-info">
	<div class="container">
		<h4>Your cart</h4>
		<div class="site-pagination">
			<a href="">Home</a> /
			<a href="">Your cart</a>
		</div>
	</div>
</div>
<!-- Page info end -->
@php
$total = 0;
@endphp
<!-- cart section end -->
<section class="cart-section spad">
	<div class="container">
		<div class="row">
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
										<h5>Size</h5>
									</th>
									<th class="size-th">
										<h5>Color</h5>
									</th>
									<th class="total-th">
										<h5>Total</h5>
									</th>
								</tr>
							</thead>
							<tbody>
								@if (!Cart::isEmpty())
								
								@foreach (Cart::getContent() as $item_cart)
								@php
								$sub_total = $item_cart->quantity*$item_cart->price;
								$total = $total + $sub_total;
								@endphp
								<tr>
									<td class="product-col">
										<img src="{{ Helper::files('product/thumbnail_'.$item_cart->attributes['image']) }}" alt="">
										<div class="pc-title">
											<h4>{{ $item_cart->name}}</h4>
											<p>{{ number_format($item_cart->price) }}</p>
										<a onclick="return confirm('Are you sure to delete product ?');" class="btn btn-danger btn-xs" href="{{ route('delete', ['id' => $item_cart->id ]) }}">Delete</a>
										</div>
									</td>
									<td class="quy-col">
										<div class="quantity">
											<div class="pro-qty">
												<input type="text" value="{{ $item_cart->quantity}}">
											</div>
										</div>
									</td>
									<td class="size-col">
										<h4 style="margin-left:100px;">
											{{ Form::select('select', $item_cart->attributes['list_color'], $item_cart->attributes['color'], ['class' => 'form-control small']) }}
										</h4>
									</td>
									<td class="size-col">
										<h4 style="margin-left:50px;">
											{{ Form::select('select', $item_cart->attributes['list_size'], $item_cart->attributes['size'], ['class' => 'form-control small']) }}
										</h4>
									</td>
									<td class="total-col">
										<h4>{{ number_format($sub_total) }}</h4>
									</td>
								</tr>
								@endforeach
								@endif
							</tbody>
						</table>
					</div>
					<div class="total-cost">
					<h6>Total <span>{{ number_format($total) }}</span></h6>
					</div>
				</div>
			</div>
			<div style="margin-top:20px;" class="col-lg-12 card-right">
				<div class="row">
					<div class="col-md-5">
						<form class="promo-code-form">
							<input type="text" placeholder="Enter promo code">
							<button>Submit</button>
						</form>
					</div>
					<div class="col-md-4">
						<a href="{{ route('checkout') }}" class="site-btn">Proceed to checkout</a>
					</div>
					<div class="col-md-3">
						<a href="{{ route('shop') }}" class="site-btn sb-dark">Continue shopping</a>
					</div>
				</div>

			</div>
		</div>
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