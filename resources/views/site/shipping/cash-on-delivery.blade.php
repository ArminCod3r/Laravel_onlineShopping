@extends('site/layouts/siteLayout')

@section('header')
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<link rel="stylesheet" type="text/css" href="{{ url('slick/slick/slick.css') }}">
	<link rel="stylesheet" type="text/css" href="{{url('slick/slick/slick-theme.css')}}">

@endsection

@section('content')

<?php
	
	$order_status = array();

    $order_status[1] = 'سفارش انجام شده';
    $order_status[2] = 'تایید سفارش';
    $order_status[3] = 'آماده سازی سفارش';
    $order_status[4] = 'ارسال';
    $order_status[5] = 'تحویل داده شده';
    $order_status[6] = 'عدم دریافت محصول';

?>

<div class="cash-on-delivery">

	<h4>		
		<div>
			<img src="{{ url('images/successfull_payment.png') }}">
		</div>
		
		<div style="margin-top: 10px">
			<span>سفارش</span>
			<span class="code">
			{{ substr($order[0]->time,0,5).$order[0]->user_id.substr($order[0]->time,5,10) }}
			</span>
			<span>با موفقیت ثبت گردید.</span>
		</div>
	</h4>

	<p>
		سفارش شما با موفقیت ثبت شد و به زودی برای شما ارسال خواهد شد.
		<br/>
		از اینکه دیجی‌کالا را برای خرید انتخاب کردید از شما سپاسگزاریم.
	</p>

</div>


<div class="cash-on-delivery-details">

		
	<div class="code">
		<span>کد سفارش:</span>
		<span>
		{{ substr($order[0]->time,0,5).$order[0]->user_id.substr($order[0]->time,5,10) }}
		</span>
	</div>

	<p>
		سفارش شما با موفقیت در سیستم ثبت شد و هم اکنون
		<span> درحال پردازش </span>
		است.
	</p>

	<div style="width: 95%; padding-top: 25px">
		<table class="table table-striped" style="width: 100%; margin-right: 20px;font-size: 18px; border-bottom: 1px solid #dee2e6">
			<tr>
				<td>
					<span>نام تحویل گیرنده:</span>
					<span> {{ $users_addr['username'] }} </span>
				</td>
				<td>
					<span>شماره تماس: </span>
					<span> {{ $users_addr['mobile'] }} </span>
				</td>
			</tr>

			<tr>
				<td>
					<span>تعداد مرسوله: </span>
					<span> {{ $order[0]->count }} </span>
				</td>
				<td>
					<span>مبلغ قابل پرداخت: </span>
					<span> {{ number_format($order[0]->price) }} تومان </span>
				</td>
			</tr>

			<tr>
				<td>
					<span>روش پرداخت: </span>
					<span> پرداخت در محل </span>
				</td>
				<td>
					<span>وضعیت سفارش: </span>
					<span> {{ $order_status[$order[0]->order_step] }} </span>
				</td>
			</tr>

			<tr>
				<td colspan="2">
					<span> آدرس: </span>
					<span> {{ $users_addr['address'] }} </span>
				</td>
			</tr>

		</table>

		<!-- Checking if user-inputed-address still exists -->
		@if(!($addr_exists))
			<div style="margin: 10px 20px 0px 0px; font-size: 14px; color: #a0a0a0">
				این آدرس در آدرس های فعلی شما قرار ندارد.
			</div>
		@endif
	</div>



</div>

<div class="posts_steps" dir="rtl">

		<div>
			<span>
				<img class="step" src="{{ url('images/posts_steps/'.'2.svg') }}"  >
			</span>
			<span>سفارش انجام شده</span>
		</div>

		<img class="link opacity" src="{{ url('images/posts_steps/link.png') }}"  >


		<div class="opacity" id="post_step_2">
			<span>
				<img class="step" src="{{ url('images/posts_steps/'.'1.svg') }}"  >
			</span>
			<span>در انتظار تایید</span>
		</div>

		<img class="link opacity" src="{{ url('images/posts_steps/link.png') }}"  >


		<div class="opacity" id="post_step_3">
			<span>
				<img class="step" src="{{ url('images/posts_steps/'.'3.svg') }}"  >
			</span>
			<span>آماده سازی سفارش</span>
		</div>

		<img class="link opacity" src="{{ url('images/posts_steps/link.png') }}"  >

		<div class="opacity" id="post_step_4">
			<span>
				<img class="step" src="{{ url('images/posts_steps/'.'4.svg') }}"  >
			</span>
			<span>ارسال</span>
		</div>

		<img class="link opacity" src="{{ url('images/posts_steps/link.png') }}"  >


		
		<div class="opacity" id="post_step_5">
			<span style="position: relative;">
				<img src="{{ url('images/posts_steps/'.'6.svg') }}" style="-moz-transform: scale(0.55); margin-top:-25px" >
			</span>
			<span style="position:absolute ; top: 0px; left:140px ; margin-top: 130px;">
				تحویل مرسوله به مشتری
			</span>
		</div>

		
		<div>
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
				<tr style="background-color:#c6f5d3;color:#32ad55;">
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




@endsection

@section('footer')
	<script type="text/javascript" src="{{ url('slick/slick/slick.js') }}" charset="utf-8"></script>

	<script type="text/javascript">

		$(".posts_steps").slick({
	        infinite: false,
	        slidesToShow: 8,
	        slidesToScroll:1,
	        rtl: true
	     });

		var order_step = <?php echo $order[0]->order_step; ?>;
        for (var i = 2; i <= order_step; i++)
        {
            // Removing opacity
            $('#post_step_'+i).removeClass('opacity');
        }

	</script>
@endsection