@extends('site/layouts/siteLayout')

@section('header')
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


	<div class="bullet green">
		<span>بررسی سفارش</span>
	</div>

	<div class="shipping-line gray-line"></div>

	<div class="bullet grey">
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

@endsection