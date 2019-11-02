@extends(Helper::setExtendFrontend())

@component('component.mask', ['array' => ['number', 'money']])
@endcomponent

@section('content')
<!-- Page info -->
<div class="page-top-info">
	<div class="container">
		<h4>Confirmation</h4>
		<div class="site-pagination">
			<a href="{{ config('app.url') }}">Home</a> /
			<a class="active" href="{{ route('confirmation') }}">Confirmation</a>
		</div>
	</div>
</div>
<!-- Page info end -->

<!-- checkout section  -->
<section class="checkout-section spad">
	<div class="container">

		<div class="col-md-12 text-center">
			@if(session()->has('success'))
			<div style="margin-top:-20px;" class="alert alert-success alert-dismissible fade show" role="alert">
				<strong>Data Berhasil Dibuat, Segera lakukan Konfirmasi Pesanan !</strong>
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			@endif
		</div>

		<div id="billing" class="col-lg-12 order-2 order-lg-1">
			{!!Form::open(['route' => 'confirmation', 'class' => 'checkout-form', 'files' => true]) !!}
			<div class="cf-title">Description Transfer
			</div>

			<div class="row address-inputs">
				<div class="col-md-6">
					<input class="{{ $errors->has('finance_payment_person') ? 'error' : ''}}"
				name="finance_payment_person" type="text" value="{{ old('finance_payment_person') ?? '' }}" placeholder="Transfered By">
				</div>
				<div class="col-md-6">
					<input type="text" class="{{ $errors->has('finance_payment_email') ? 'error' : ''}}"
						name="finance_payment_email" value="{{ old('finance_payment_email') ?? '' }}" placeholder="Email">
				</div>

				<div class="col-md-12">
					<input type="text" class="{{ $errors->has('finance_payment_note') ? 'error' : ''}}"
						name="finance_payment_note" value="{{ old('finance_payment_note') ?? '' }}" placeholder="Note for admin">
				</div>
			</div>

			<div class="cf-title">Description Order</div>
			<div class="row address-inputs">

				<div class="col-md-6">
					<input class="{{ $errors->has('finance_payment_sales_order_id') ? 'error' : ''}}"
						name="finance_payment_sales_order_id" type="text" value="{{ old('finance_payment_sales_order_id') ?? '' }}" placeholder="Order No.">
				</div>

				<div class="col-md-6">
					<input class="date {{ $errors->has('finance_payment_date') ? 'error' : ''}}"
						name="finance_payment_date" type="text" value="{{ old('finance_payment_date') ?? '' }}" placeholder="Payment Date">
				</div>

				<div class="col-md-6">
					<input type="text" class="{{ $errors->has('finance_payment_from') ? 'error' : ''}}"
						name="finance_payment_from" value="{{ old('finance_payment_from') ?? '' }}" placeholder="From Bank">
				</div>

				<div class="col-md-6">
					<div id="select" class="{{ $errors->has('finance_payment_to') ? 'error' : ''}}"">
						{{ Form::select('finance_payment_to', $bank, null, ['class'=> 'form-control']) }}
					</div>

				</div>

				<div class="col-md-6">
					<input type="text" class="money {{ $errors->has('finance_payment_amount') ? 'error' : ''}}"
						name="finance_payment_amount" value="{{ old('finance_payment_amount') ?? '' }}" placeholder="Payment Amount">
				</div>

				<div class="col-md-6">
					<input type="file" name="files"
						class="{{ $errors->has('files') ? 'error' : ''}} btn btn-default btn-sm btn-block">
					{!! $errors->first('files', '<p class="help-block">:message</p>') !!}
				</div>

			</div>

			<button type="submit" class="site-btn pull-right">Proceed</button>

			{!! Form::close() !!}
		</div>

	</div>
</section>
<!-- checkout section end -->

@endsection