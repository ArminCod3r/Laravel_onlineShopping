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

	<div class="bullet green">
		<span>اطلاعات ارسال</span>
	</div>

	<div class="shipping-line gray-line"></div>

	<div class="bullet grey">
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


<div class="shipping-review">	


@if( count($cart) > 0 )
	<div class="loader" id="loader" style="display: none">
	</div>

	<div class="row shipping-review-cart">
		<div class="col-sm-1"></div>

		<div class="col-sm-2 cart-title">
			<span style="font-weight: bold;">
				سبد خرید شما در دیجی کالا
			</span>
		</div>

		<div class="col-sm-6"></div>

		<div class="col-sm-3" style="padding-right: 80px;">
			
		</div>
	</div>

	<div class="container" style="background-color:white; border-radius:5px;" id="aaaa">
		<table class="table table-bordered" style="font-size: 16px">
			<tr class="cart_headers">
				<th>تصویر</th>
				<th>محصول</th>
				<th>رنگ</th>
				<th>قیمت</th>
				<th>تعداد</th>
				<th colspan="2">قیمت کل</th>
			</tr>

			@foreach($cart as $p_c=>$count)
				<tr class="cart_values">

					<td style="width: 10%;">
						<img style="width: 50%;" src="{{ url('upload').'/'.$cart_details[$p_c][0]->url }}" </img>
					</td>

					<td style="width: 40%;">
						{{ $cart_details[$p_c][0]->title }}
					</td>

					<td>
						<label style="background-color: #{{ $cart_details[$p_c][0]->color_code }}" class="cart_product_color">
						</label>
					</td>

					<td> {{ number_format($cart_details[$p_c][0]->price) }} </td>
					<td>

						<div class="row">
							<?php
								$product_id = explode('-', $p_c)[0];
								$color_id   = explode('-', $p_c)[1];
							?>

							<div class="col-sm-3"></div>

							<div class="col-sm-2" id="product_quantity_{{$p_c}}">
								{{ $count }}
							</div>

							<div class="col-sm-5"></div>

						</div>
					</td>
					<td class="total_price" id="total_price_{{$p_c}}">
						{{ number_format((int)$cart_details[$p_c][0]->price * (int)$count) }}
					</td>
					
				</tr>
			@endforeach
		</table>
	</div>



	<div class="row shipping-review-invoice-summary">
		<div class="col-sm-1"></div>

		<div class="col-sm-2 cart-title">
			<span style="font-weight: bold;">
				خلاصه صورت حساب
			</span>
		</div>

		<div class="col-sm-6"></div>

		<div class="col-sm-3" style="padding-right: 80px;">
			
		</div>
	</div>


	<!-- Get the total-price / discounted-price -->
	<?php
		$total_price = 0;
		$discount_price = 0;
		$discount = 0;

		foreach ($cart as $key_count => $value_count)
		{
			$price = (int)$cart_details[$key_count][0]->price;

			$total_price += $price * $value_count;
		}

		foreach ($cart as $key_count => $value_count)
		{
			$price    = (int)$cart_details[$key_count][0]->price;
			$discount = (int)$cart_details[$key_count][0]->discounts;

			$discount_price += ($price-(($price*$discount)/100))* $value_count;
		}

	?>


	<div class="container">
		<table class="table" style="width: 100%">
			<tr>
				<td> جمع کل خرید </td>
				<td style="width: 10%"> {{number_format($total_price)}} </td>
				<td style="width: 5%"> تومان </td>
			</tr>

			<tr style="background-color:#cdf2fa">
				<td> هزینه ارسال و بیمه و بسته بندی سفارش </td>
				<td style="width: 10%">
					@if($shipping_data['type'] == 1)
						{{number_format(15000)}}
					@else
						پس کرایه
					@endif
				</td>
				<td style="width: 5%">
					@if($shipping_data['type'] == 1)
						تومان
					@endif
				</td>
			</tr>

			<tr>
				<td> هزینه با تخفیف </td>
				<td style="width: 10%"> {{number_format($discount_price)}} </td>
				<td style="width: 5%"> تومان </td>
			</tr>

			<tr style="background-color:#cdf2fa">
				<td> مبلغ قابل پرداخت </td>
				<td style="width: 10%">
					@if($shipping_data['type'] == 1)
						{{number_format($discount_price + 150000 )}}
					@else
						{{number_format($discount_price)}}
					@endif
				
				</td>
				<td style="width: 5%"> تومان </td>
			</tr>

		</table>
	</div>

@else
	<p style="color:red ; text-align:center ; padding-top:30px; padding-bottom:30px;">
		 سبد محصول خالی می باشد
	 </p>
@endif


</div>
	
@endsection