@extends('site/layouts/siteLayout')

@section('header')
	<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')

<div class="shipping-steps">

	<div class="shipping-steps-dash">
		<div style="margin-right: 25px"></div>
		<div></div>
		<div></div>
		<div></div>
	</div>

	<div class="bullet green tick">
		<span>ورود به دیجی کالا</span>
	</div>

	<div class="shipping-line green-line"></div>


	<div class="bullet green tick">
		<span>بررسی سفارش</span>
	</div>

	<div class="shipping-line green-line"></div>

	<div class="bullet green tick">
		<span>اطلاعات ارسال</span>
	</div>

	<div class="shipping-line green-line"></div>

	<div class="bullet green">
		<span>اطلاعات پرداخت</span>
	</div>

	<div class="shipping-steps-dash-gray">
		<div style="margin-right: 10px"></div>
		<div></div>
		<div></div>
		<div></div>
	</div>
	
</div>

<div style="position: absolute;">
	<br/>
	<br/>
</div>

<div>
	<form action="{{ action('ShippingController@payment') }}" method="POST">
		{{ csrf_field() }}

		<input type="hidden" value="1" id="selected_payment_type" name="selected_payment_type">


		<div class="payment_type_title">

			<div style="padding: 20px 20px 0px 0px">
				<span>
					انتخاب شیوه پرداخت:
				</span>
			</div>

			<!-- Payment Types -->
			<div class="width_range">
				<table class="table table-bordered" style="width: 40%">
					<tbody>

						<tr>
							<td class="payment_type" onclick="payment_type('1')">
								<span class="fa fa-circle" id="payment_type_1" style="color: #828181"></span>
							</td>
							<td> پرداخت آنلاین </td>
						</tr>

						<tr>
							<td class="payment_type" onclick="payment_type('2')">
								<span class="fa fa-circle" id="payment_type_2"></span>
							</td>
							<td> پرداخت در محل </td>
						</tr>

						<tr>
							<td class="payment_type" onclick="payment_type('3')">
								<span class="fa fa-circle" id="payment_type_3"></span>
							</td>
							<td> کارت به کارت </td>
						</tr>

					</tbody>
				</table>

			</div>
			
		</div>

		<!-- Button to go to the next step -->
		<div class="order_confirmation">
			<div class="row">
				<div class="col-sm-10"></div>

				<div class="col-sm-2">

					<div class="btn">
						<input type="submit" value="ثبت سفارش" class="btn btn-success">
					</div>

				</div>
			</div>
		</div>		

	</form>
</div>

@endsection

@section('footer')

	<script type="text/javascript">
		
		payment_type = function(id)
		{
			document.getElementById('selected_payment_type').value=id;


			document.getElementById('payment_type_1').style.color="white";
			document.getElementById('payment_type_2').style.color="white";
			document.getElementById('payment_type_3').style.color="white";
			
			document.getElementById('payment_type_'+id).style.color="#828181";
		}

	</script>

@endsection