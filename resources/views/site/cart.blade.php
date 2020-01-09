@extends('site/layouts/siteLayout')

@section('header')
	<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')

@if( count($cart) > 0 )

	<div class="container" style="background-color:white; border-radius:5px" id="aaaa">
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
							<?php
								$product_id = explode('-', $p_c)[0];
								$color_id   = explode('-', $p_c)[1];
							?>

							<div class="col-sm-3"></div>

							<div class="col-sm-1 cart_quantity_plus">
								<span onclick="change('{{$product_id}}', '{{$color_id}}', 'add', '{{ $cart_details[$p_c][0]->price }}')"
									  class="cart_quantity_plus">
									+ 
								</span>
							</div>

							<div class="col-sm-2" id="product_quantity_{{$p_c}}">
								{{ $count }}
							</div>

							<div class="col-sm-1 cart_quantity_negative" onclick="change('{{$product_id}}', '{{$color_id}}', 'subtract', '{{ $cart_details[$p_c][0]->price }}')">
								<span> - </span>
							</div>

							<div class="col-sm-5"></div>

						</div>
					</td>
					<td class="total_price" id="total_price_{{$p_c}}">
						{{ (int)$cart_details[$p_c][0]->price * (int)$count }}
					</td>

					<td class="cart_operation">
						<div>
							<?php
								$product_id = explode('-', $p_c)[0];
								$color_id   = explode('-', $p_c)[1];
							?>
							<span class="fa fa-remove" style="cursor:pointer" 
							onclick="change('{{$product_id}}', '{{$color_id}}' , 'remove')">
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

    	<?php
    		$url= url('cart/change');
    	?>
    	change = function(product_id, color_id, operation, price)
    	{
    		$.ajaxSetup(
			    			{
			    				'headers':
			    				{
			    					'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
			    				}
			    			}
    					);
    		
    		$.ajax(
		    		{
		    		'url': '{{ $url }}',
		    		'type': 'post',
		    		'data': 'product_id='+product_id+"&color_id="+color_id+"&operation="+operation,
		    		success:function(data){
		    			if(operation == 'remove')
		    			{
		    				var redirectTo = window.location.origin+"/cart/";
							document.location = redirectTo;
		    			}

		    			if(operation == 'add')
		    			{
		    				// Quantity
		    				cart_key = product_id+"-"+color_id;
		    				$("#product_quantity_"+cart_key).html(data);

		    				// Price
		    				$("#total_price_"+cart_key).html(data*price);
		    			}

		    			if(operation == 'subtract')
		    			{
		    				// Quantity
		    				cart_key = product_id+"-"+color_id;
		    				$("#product_quantity_"+cart_key).html(data);

		    				// Price
		    				$("#total_price_"+cart_key).html(data*price);
		    			}
		    		}

		    		}
			  );

    	}

    	</script>

@endsection