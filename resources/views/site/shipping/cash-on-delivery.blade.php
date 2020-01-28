@extends('site/layouts/siteLayout')

@section('header')
	<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')

<?php
	
	$order_status = array();

	$order_status[0] = 'در انتظار پرداخت';
	$order_status[1] = 'در انتظار تایید';
	$order_status[2] = 'آماده سازی سفارش';
	$order_status[3] = 'ارسال';
	$order_status[4] = 'تحویل داده شده';
	$order_status[5] = 'عدم دریافت محصول';

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
					<span> {{ $users_addr->username }} </span>
				</td>
				<td>
					<span>شماره تماس: </span>
					<span> {{ $users_addr->mobile }} </span>
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
					<span> {{ $users_addr->address }} </span>
				</td>
			</tr>

		</table>
	</div>

</div>

@endsection