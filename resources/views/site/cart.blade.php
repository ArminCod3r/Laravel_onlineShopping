@extends('site/layouts/siteLayout')

@section('header')
@endsection

@section('content')

@if( count($cart) > 0 )

	<div class="container" style="background-color:white; border-radius:5px">
		<table class="table" style="font-size: 16px">
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

					<td> {{ $cart_details[$p_c][0]->price }} </td>
					<td>

						<div class="row">
							<div class="col-sm-3"></div>

							<div class="col-sm-1 cart_quantity_plus">
								<span onclick="add_quantity()" class="cart_quantity_plus"> + </span>
							</div>

							<div class="col-sm-2">
								{{ $count }}
							</div>

							<div class="col-sm-1 cart_quantity_negative">
								<span> - </span>
							</div>

							<div class="col-sm-5"></div>

						</div>
					</td>
					<td> {{ (int)$cart_details[$p_c][0]->price * (int)$count }} </td>

					<td class="cart_operation">
						<div>
							<?php
								$product_id = explode('-', $p_c)[0];
								$color_id   = explode('-', $p_c)[1];
							?>
							<span class="fa fa-remove" style="cursor:pointer" 
								  onclick="del_product('{{$product_id}}', '{{$color_id}}')">
							</span>
						</div>
					</td>
					
				</tr>
			@endforeach
		</table>
	</div>

@else
	<p style="color:red ; text-align:center ; padding-top:30px; padding-bottom:30px;">
		 سبد محصول خالی می باشد
	 </p>
@endif

@endsection


@section('footer')

    <script type="text/javascript" src="{{ url('js/jscolor.js') }}"></script>

    <script type="text/javascript">
    	del_product = function(product_id, color_id)
    	{
    		alert(product_id+":"+color_id);
    	}
    </script>

@endsection