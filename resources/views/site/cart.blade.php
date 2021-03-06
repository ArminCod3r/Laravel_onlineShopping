@extends('site/layouts/siteLayout')

@section('header')
	<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')

@if( count($cart) > 0 )
	<div class="loader" id="loader" style="display: none">
	</div>

	<div class="row" style="margin-bottom:10px;">
		<div class="col-sm-1"></div>

		<div class="col-sm-2 cart-title">
			<span>
				سبد خرید شما در دیجی کالا
			</span>
		</div>

		<div class="col-sm-6"></div>

		<div class="col-sm-3" style="padding-right: 80px;">
			<a href="{{ url('shipping') }}" class="btn btn-success">
				<span>ادامه ثبت سفارش</span>
				<span class="fa fa-arrow-left"></span>
			</a>
		</div>
	</div>

	<div class="container" style="background-color:white; border-radius:5px;" id="aaaa">
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

					<td> {{ number_format($cart_details[$p_c][0]->price) }} </td>
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
						{{ number_format((int)$cart_details[$p_c][0]->price * (int)$count) }}
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


	<!-- Get the total-price / discounted-price -->
	<?php
		$total_price = 0;
		$discount_price = 0;

		foreach ($cart as $key_count => $value_count)
		{
			$price = (int)$cart_details[$key_count][0]->price;

			$total_price += $price * $value_count;
		}

		foreach ($cart as $key_count => $value_count)
		{
			$price    = (int)$cart_details[$key_count][0]->price;
			$discount = (int)$cart_details[$key_count][0]->discounts;

			$discount_price += ($price-(($price*$discount)/100))* $value_count;
		}

	?>


	<div class="row">
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

			<a href="{{ url('shipping') }}" class="btn btn-success cart-order-continue">
				<span>ادامه ثبت سفارش</span>
				<span class="fa fa-arrow-left"></span>
			</a>
		</div>
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

	    // showing "loader" if ajax takes less than 500 miliseconds (35349470)
	    var ajaxLoadTimeout;

		$(document).ajaxStart(function() {
		    ajaxLoadTimeout = setTimeout(function() { 
		        $("#loader").css("display","block");
		    }, 500);

		}).ajaxSuccess(function() {
		    clearTimeout(ajaxLoadTimeout);
		    $("#loader").css("display","none");
		});

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
		    				// https://www.samanthaming.com/tidbits/76-converting-object-to-array

		    				const objectArray = Object.entries(data);
		    				var total_price=0;
		    				cart_key = product_id+"-"+color_id;

							objectArray.forEach(([key, value]) => {
							  console.log(key+":"+value);

							  if (key == cart_key) 
							  {
								  // Quantity			    				  
			    				  $("#product_quantity_"+cart_key).html(value);

			    				  // Price
			    				  price_temp = value*price;
			    				  $("#total_price_"+cart_key).html(price_temp.toLocaleString());
			    				  total_price += price_temp;
		    				  }
		    				  else
		    				  {
		    				  	var other_prices = $("#total_price_"+key)[0];
		    				  	other_prices = (other_prices['innerText']).replace(/,/gi,"");
		    				  	other_prices = parseInt(other_prices);
		    				  	
		    				  	total_price += other_prices;
		    				  }
							})
			    			
			    			console.log(total_price.toLocaleString());
		    				$("#invoice_total_price").html(total_price.toLocaleString());

		    			}

		    			if(operation == 'subtract')
		    			{
		    				const objectArray = Object.entries(data);
		    				var total_price=0;
		    				cart_key = product_id+"-"+color_id;

							objectArray.forEach(([key, value]) => {
							  console.log(key+":"+value);

							  if (key == cart_key) 
							  {
								  // Quantity			    				  
			    				  $("#product_quantity_"+cart_key).html(value);

			    				  // Price
			    				  price_temp = value*price;
			    				  $("#total_price_"+cart_key).html(price_temp.toLocaleString());
			    				  total_price += price_temp;
		    				  }
		    				  else
		    				  {
		    				  	var other_prices = $("#total_price_"+key)[0];
		    				  	other_prices = (other_prices['innerText']).replace(/,/gi,"");
		    				  	other_prices = parseInt(other_prices);
		    				  	
		    				  	total_price += other_prices;
		    				  }
							})
			    			
			    			console.log(total_price.toLocaleString());
		    				$("#invoice_total_price").html(total_price.toLocaleString());
		    			}
		    		}

		    		}
			  );

    	}

    	</script>

@endsection