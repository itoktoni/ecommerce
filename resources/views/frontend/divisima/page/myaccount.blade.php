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
							<div class="accordion" id="accordionExample">
								<div class="card">
									<div class="card-header" id="headingOne">
										<h2 class="mb-0">
											<button class="btn btn-link" type="button" data-toggle="collapse"
												data-target="#collapseOne" aria-expanded="true"
												aria-controls="collapseOne">
												Personal Data [ {{ Auth::user()->username }} ]
											</button>
										</h2>
									</div>

									<div id="collapseOne" class="collapse show" aria-labelledby="headingOne"
										data-parent="#">
										<div class="card-body">
											{!! Form::model($model, ['route' => 'myaccount', 'class' =>
											'form-horizontal', 'files' => true]) !!}
											<div class="row">
												<div class="col-md-4">
													<div class="form-group">
														<label>Name</label>
														{!! Form::text('name', null, ['class' => 'form-control']) !!}
														{!! $errors->first('name', '<p class=text-danger">:message</p>')
														!!}
													</div>
													<div class="form-group">
														<label>Email</label>
														{!! Form::email('email', null, ['class' => 'form-control']) !!}
														{!! $errors->first('email', '<p class=text-danger">:message</p>
														') !!}
													</div>
													<div class="form-group">
														<label>Phone</label>
														{!! Form::text('phone', null, ['class' => 'form-control']) !!}
														{!! $errors->first('phone', '<p class=text-danger">:message</p>
														') !!}
													</div>
												</div>

												<div class="col-md-4">

													<div class="form-group">
														<label>Password</label>
														{!! Form::password('password', ['class' => 'form-control']) !!}
														{!! $errors->first('password', '<p class=text-danger">:message
														</p>
														') !!}
													</div>

													<div class="form-group">
														<label>Address</label>
														{!! Form::textarea('address', null, ['class' => 'form-control',
														'rows' => '3']) !!}
														{!! $errors->first('address', '<p class=text-danger">:message
														</p>
														') !!}
													</div>

													<div class="form-group row">
														<div class="col-md-3">
															<label>Postcode</label>
														</div>
														<div class="col-md-9">
															{!! Form::text('postcode', null, ['class' =>
															'form-control'])
															!!}
															{!! $errors->first('postcode', '<p class=text-danger">
																:message
															</p>
															') !!}
														</div>
													</div>

												</div>

												<div class="col-md-4">
													<div class="form-group">
														<label>Province</label>
														{{ Form::select('province', $list_province, $province, ['id' => 'province', 'class'=> 'form-control chosen '.($errors->has('province') ? 'error':'')]) }}
													</div>
													<div class="form-group">
														<label>City</label>
														{{ Form::select('city', $list_city, $city, ['id' => 'city','class'=> 'form-control chosen']) }}
													</div>
													<div class="form-group">
														<label>Location</label>
														{{ Form::select('location', $list_location, $location, ['id' => 'location','class'=> 'form-control chosen '.($errors->has('location') ? 'error':'')]) }}
													</div>
													<div class="pull-right">
														<button type="submit" class="btn btn-primary btn-sm">Save
															Data</button>
													</div>

												</div>

											</div>
											{!! Form::close() !!}
										</div>
										<div class="card">
											<div class="card-header" id="headingTwo">
												<h2 class="mb-0">
													<button class="btn btn-link collapsed" type="button"
														data-toggle="collapse" data-target="#collapseTwo"
														aria-expanded="false" aria-controls="collapseTwo">
														List Data - { Sales Order }
													</button>
												</h2>
											</div>
											<div id="collapseTwo" class="collapse" aria-labelledby="headingTwo"
												data-parent="#collapseTwo">
												<div class="card-body">
													<div class="row">
														<table id="force-responsive" class="table table-table table-bordered table-striped table-hover">
															<thead>
																<tr>
																	<th scope="col">No. Order</th>
																	<th scope="col">Date</th>
																	<th scope="col">Name</th>
																	<th scope="col">Ongkir</th>
																	<th style="text-align:right" scope="col">Total</th>
																	<th style="text-align:right" scope="col">Status</th>
																	<th style="text-align:right" scope="col">Detail</th>
																</tr>
															</thead>
														
														</table>

													</div>
												</div>
											</div>
										</div>
										<div class="card">
											<div class="card-header" id="headingThree">
												<h2 class="mb-0">
													<button class="btn btn-link collapsed" type="button"
														data-toggle="collapse" data-target="#collapseThree"
														aria-expanded="false" aria-controls="collapseThree">
														Wish List - (Loved Product)
													</button>
												</h2>
											</div>
											<div id="collapseThree" class="collapse" aria-labelledby="headingThree"
												data-parent="#collapseThree">
												<div class="card-body">
													Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus
													terry richardson ad squid. 3 wolf
													moon officia aute, non cupidatat skateboard dolor brunch. Food truck
													quinoa nesciunt laborum eiusmod.
													Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid
													single-origin coffee nulla assumenda
													shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes
													anderson cred nesciunt sapiente ea
													proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat
													craft
													beer farm-to-table, raw denim
													aesthetic synth nesciunt you probably haven't heard of them
													accusamus
													labore sustainable VHS.
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
</section>
@endsection

@push('javascript')
<script>
	$(document).ready(function() {
	
		$('#province').change(function() { // Jika Select Box id provinsi dipilih
			var data = $("#province option:selected");
			var province = data.val(); // Ciptakan variabel provinsi
			var city = $('#city');
			$.ajax({
				type: 'GET', // Metode pengiriman data menggunakan POST
				url: '{{ route("city") }}',
				data: 'province=' + province, // Data yang akan dikirim ke file pemroses
				success: function(response) { // Jika berhasil
					city.empty();
					city.append('<option value=""></option>');
					$.each(response, function (idx, obj) {
						city.append('<option postcode="'+obj.postal_code+'" value="' + obj.city_id + '">' + obj.city_name + '</option>');
					});
					city.trigger("chosen:updated");
				}
			});
		});
	
		$('#city').change(function() { // Jika Select Box id provinsi dipilih
			var data = $("#city option:selected");
			var city = data.val(); // Ciptakan variabel provinsi
			// var postcode = data.attr('postcode');
			var location = $('#location');
			// $('#postcode').val(postcode);
			$.ajax({
				type: 'GET', // Metode pengiriman data menggunakan POST
				url: '{{ route("location") }}',
				data: 'city=' + city, // Data yang akan dikirim ke file pemroses
				success: function(response) { // Jika berhasil
					location.empty();
					location.append('<option value=""></option>');
					$.each(response, function (idx, obj) {
						location.append('<option value="' + obj.subdistrict_id + '">' + obj.subdistrict_name + '</option>');
					});
					$("#location").trigger("chosen:updated");
				}
			});
		});

	});
</script>
@endpush

@push('css')
<style>
	@media screen and (max-width: 520px) {
		#force-responsive table {
			width: 100%;
		}

		#force-responsive thead {
			display: none;
		}

		#force-responsive td {
			display: block;
			text-align: right;
			border-right: 1px solid #e1edff;
		}

		#force-responsive td::before {
			float: left;
			text-transform: uppercase;
			font-weight: bold;
			content: attr(data-header);
		}

		#force-responsive tr td:last-child {
			border-bottom: 2px solid #dddddd;
		}
	}
</style>
@endpush