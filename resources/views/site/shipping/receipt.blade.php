<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<title>فاکتور خرید</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
	<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
	<link rel="stylesheet" href="{{ url('dist/css/bootstrap-rtl.min.css') }}">

</head>

<body style="direction: rtl">

	<div style="text-align: center;padding-top: 40px;width: 80%;margin: auto;">
		<div class="row" style="background-color: #ebebeb">

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
				</table>
			</div>

			<div class="col-sm-6">
				<img src="{{ action('ShippingController@barcode_generator', ['order_id'=>$order->order_id]) }}" class="barcode" style="padding-top: 10px">
			</div>

		</div>
	</div>


</body>
</html>