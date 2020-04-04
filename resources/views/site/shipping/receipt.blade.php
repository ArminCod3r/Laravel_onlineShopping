<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<title>فاکتور خرید</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
	<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
	<link rel="stylesheet" href="{{ url('dist/css/bootstrap-rtl.min.css') }}">

	<!-- Frontend CSS-->
    <link rel="stylesheet" type="text/css" href="{{ url('css/receipt.css') }}">

</head>

<body>

	<div class="order-details">
		<div class="row" style="border: 1px solid black">

			<div class="col-sm-6">
				<table class="table">
					<tr>
						<th> کد سفارش: </th>
						<th>{{ $order->order_id }}</th>
					</tr>
					<tr>
						<th>نام کاربری:</th>
						<th>{{ $users_addr['username'] }}</th>
					</tr>
					<tr>
						<th>شماره همراه:</th>
						<th>{{ $users_addr['mobile'] }}</th>
					</tr>
				</table>
			</div>

			<div class="col-sm-6">
				<img src="{{ action('ShippingController@barcode_generator', ['order_id'=>$order->order_id]) }}" class="barcode">
			</div>

		</div>
	</div>

	<div class="bought_items">

		<div style="margin: 10px 20px 20px 0px ; font-size:17px ; font-weight:bold;">
			اجناس خریداری شده
		</div>

		<div class="container" style="background-color:white; border-radius:5px;">
			<table class="table" style="font-size: 16px ; border-bottom: 1px solid #dee2e6">
				<tr class="cart_headers">
					<th>تصویر</th>
					<th>محصول</th>
					<th>رنگ</th>
					<th>قیمت</th>
					<th>تعداد</th>
					<th colspan="2">قیمت کل</th>
				</tr>

				@foreach($bought_items as $key=>$value)
					<tr class="cart_values">

						<td style="width: 10%;">
							<img style="width: 50%;" src="{{ url('upload').'/'.$value->image->url}}" </img>
						</td>

						<td style="width: 40%;">
							{{ $value->product->title }}
						</td>

						<td>
							<label style="background-color: #{{ $value->color->color_code }}" class="cart_product_color">
							</label>
						</td>

						<td> {{ number_format($value->product->price) }} </td>
						<td>

							<div class="row">

								<div class="col-sm-4"></div>

								<div class="col-sm-2">
									{{ $value->number }}
								</div>

								<div class="col-sm-6"></div>

							</div>
						</td>
						<td class="total_price">
							{{ number_format((int)$value->product->price * (int)$value->number) }}
						</td>
						
					</tr>
				@endforeach
			</table>
		</div>


	<!-- Get the total-price / discounted-price -->
		<?php
			$total_price    = 0;
			$discount_price = 0;

			foreach ($bought_items as $key => $value)
			{
				$price = (int)$value->product->price;

				$total_price += $price * $value->number;
			}

			foreach ($bought_items as $key => $value)
			{
				$price    = (int)$value->product->price;
				$discount = (int)$value->product->discounts;

				$discount_price += ($price-(($price*$discount)/100))* $value->number;
			}

		?>


		<div class="row" style="margin-bottom: 20px;">
			<div class="col-sm-8"></div>

			<div class="col-sm-4 total-price-factor">
				<table>
					<tr>
						<td style="padding-right: 15px">جمع کل خرید</td>
						<td>
							<strong id="invoice_total_price">
								{{number_format($total_price)}}
							</strong>
							<span>تومان</span>
						</td>
					</tr>
					<tr>
						<td style="padding-right: 15px">مبلغ قابل پرداخت</td>
						<td>
							<strong>{{number_format($discount_price)}}</strong>
							تومان
						</td>
					</tr>
				</table>
			</div>
		</div>

	</div>

</body>
</html>