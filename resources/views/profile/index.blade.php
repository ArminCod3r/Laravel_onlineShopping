@extends('layouts/profile')

<?php
	
	$order_status = array();

    $order_status[1] = 'سفارش انجام شده';
    $order_status[2] = 'تایید سفارش';
    $order_status[3] = 'آماده سازی سفارش';
    $order_status[4] = 'ارسال';
    $order_status[5] = 'تحویل داده شده';
    $order_status[6] = 'عدم دریافت محصول';

?>

@section('profile_content')

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

@endsection