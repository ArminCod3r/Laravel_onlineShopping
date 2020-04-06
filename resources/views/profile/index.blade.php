@extends('site/layouts/siteLayout')

@section('header')
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<title>پروفایل</title>
@endsection

<?php
	
	$order_status = array();

    $order_status[1] = 'سفارش انجام شده';
    $order_status[2] = 'تایید سفارش';
    $order_status[3] = 'آماده سازی سفارش';
    $order_status[4] = 'ارسال';
    $order_status[5] = 'تحویل داده شده';
    $order_status[6] = 'عدم دریافت محصول';

?>

@section('content')
	<div class="container-fluid users_profile">
		<div class="row">

			<div class="col-sm-3 right_side">
				<ul>

					<li>
						<a href="{{ url('profile') }}"> سفارشات من </a>
					</li>

					<li>
						<a href="#">لیست مورد علاقه</a>
					</li>

					<li>
						<a href="#"> نقدهای من </a>
					</li>

					<li>
						<a href="#"> نظرات من </a>
					</li>

					<li>
						<a href="#"> آدرس ها </a>
					</li>

				</ul>
			</div>

			<div class="col-sm-9 left_side">

				<div style="padding-top: 20px">
					<p>آخرین سفارش‌ها </p>
				</div>

				<table class="table table-striped">
					<tr>
						<th>#</th>
						<th> شماره سفارش </th>
						<th> تاریخ ثبت سفارش </th>
						<th> مبلغ کل </th>
						<th> عملیت پرداخت </th>
						<th> جزییات </th>
					</tr>					

					@if( sizeof($orders) > 0 )
						@foreach($orders as $key=>$order)
							<tr>
								<td> {{ $key+1 }} </td>
								<td style="color:#538cf5"> {{ $order->order_id }} </td>
								<td> {{ $order->created_at }} </td>
								<td style="color:green" >
									{{ number_format($order->price) }}
								</td>
								<td> {{ $order_status[$order->order_step] }} </td>
								<td>
									<a href="{{ url('shipping/payment/cash-on-delivery'.'/'.$order->id) }}">
										<span class="fa fa-eye"></span>
									</a>
								</td>
							</tr>
						@endforeach
					@else
						<p> سفارشی ثبت نشده است. </p>
					@endif
				</table>

				{{ $orders->links() }}
			</div>

		</div>		
	</div>
@endsection