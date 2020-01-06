@extends('site/layouts/siteLayout')

@section('header')
@endsection

@section('content')

@if($cart_status == 'true')

	<div class="container">
		<table class="table table-hover">
			<tr>
				<th>محصول</th>
				<th>رنگ</th>
				<th>قیمت</th>
			</tr>

			@foreach()
			@endforeach
		</table>
	</div>

@else
	<p style="color:red ; text-align:center ; padding-top:30px; padding-bottom:30px;">
		 سبد محصول خالی می باشد
	 </p>
@endif

@endsection