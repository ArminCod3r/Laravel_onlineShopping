@extends('site/layouts/siteLayout')

@section('header')
  <link rel="stylesheet" type="text/css" href="{{ url('slick/slick/slick.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ url('slick/slick/slick-theme.css') }}">

  <link rel="stylesheet" href="{{ url('css/flipclock.css') }}">
  <script src="{{ url('js/flipclock.js') }}"></script>


@endsection

@section('content')

<div class="container">
	<div class="row" style="margin-top:20px ; background:white ; height: 470px;">

		<div class="col-sm-4">
			<img src="{{ url('upload').'/'.$product->ProductImage[0]->url }}" 
				 data-zoom-image="{{ url('upload').'/'.$product->ProductImage[0]->url }}"
				 class="product_img"
				 id="product_img">

			<div style="position: absolute;bottom: 0;margin-bottom: 10px;">
				<?php $key; ?>
				@foreach($product->ProductImage as $key=>$item)

					@if($key < 3)
						<?php $imgLink = url('upload').'/'.$item->url ?>
						<div class="otherProductImages">
							<img src="{{ url('upload').'/'.$item->url }}"
								 onclick="imgToShow('{{ $imgLink }}')">
						</div>

					@else
						<div class="otherProductImages">
							<div onclick="imgToShow('{{ $imgLink }}')">
								...
							</div>
						</div>
						@break

					@endif

				@endforeach
			</div>
		</div>

		
		<div class="col-sm-8">
			<div id="imgZoom" class="imgZoom"></div>

			<div class="row product_title">
				<div class="col-sm-10">				
					<div class="">
						<h4> {{ $product->title }} </h4>
						<p> {{ $product->code }} </p>
					</div>
				</div>

				<div class="col-sm-2">				
					<div class="rating">
						<div class="gray">

							<!--
								rated stars should be 'width'ed within the inline 'style' 
								why? value is caluclated using php and changing value is 
									 possible.
							-->
							<div class="activate_stars" style="width: 70%">	
							</div>	

						</div>
					</div>

					<p class="vote"> از 10 رای </p>
				</div>

		    </div>

		    @if($product->product_status == 1)

		    	<form action="{{ action('SiteController@cart') }}" method="POST" accept-charset="utf-8">
					{{ csrf_field() }}

				    <?php
				    	$color_count = $product->color_product_frontend;
				    ?>
				    @if(sizeof($color_count) > 0)

						<div class="">
						 	<div class="row product_colors_list">

						    	@foreach($product->color_product_frontend as $key=>$item)


						    		<div class="col-sm-2 color_area list-group panel">
										<a class="list-group-item color_a" style="cursor:pointer" id="color_{{$item->id}}">

											<input type="text" id="color"
											class="jscolor {valueElement:null,value:'{{ $item->color_code }}'} colorStyle form-control"
											value="" disabled>

										</a>
									</div>

						    		<div class="col-sm-10">
									</div>


								@endforeach


							</div>
						</div>

					@endif


					<div class="price_product">
						<?php

							function toPersianNum($number)
						    {
						        $number = str_replace("1","۱",$number);
						        $number = str_replace("2","۲",$number);
						        $number = str_replace("3","۳",$number);
						        $number = str_replace("4","۴",$number);
						        $number = str_replace("5","۵",$number);
						        $number = str_replace("6","۶",$number);
						        $number = str_replace("7","۷",$number);
						        $number = str_replace("8","۸",$number);
						        $number = str_replace("9","۹",$number);
						        $number = str_replace("0","۰",$number);

						        return $number;
						    }

						    $product_price_persian = toPersianNum(number_format($product->price));

						?>

						<div class="price_org"> {{$product_price_persian}} </div>
						<span style="color:#fb3449;"> تومان </span>


						<input type="submit" value="افزودن به سبد خرید" class="add_cart_btn"
							   id="add_cart_btn" />
						 

					</div>

					<input type="hidden" name="color_session" id="color_session">
					<input type="hidden" name="product_session" id="product_session" value="{{ $product->id }}">

				</form>
		    @endif

		</div>
	</div>
</div>

<div class="tabs">

	  <!-- Nav tabs -->
	  <ul class="nav nav-tabs" role="tablist">

	    <li role="presentation" class="active">
	    	<a href="#review" aria-controls="review" role="tab" data-toggle="tab"> 
		    	<i class="fa fa-search fa-2x"></i>
		    	نقد و بررسی تخصصی
	    	</a>
	    </li>

	    <li role="presentation">
		    <a href="#features" aria-controls="features" role="tab" data-toggle="tab">
			    <i class="fa fa-list fa-rotate-180 fa-2x"></i>
			    مشخصات
		    </a>
	    </li>

	    <li role="presentation">
		    <a href="#comments" aria-controls="comments" role="tab" data-toggle="tab">
			    <i class="fa fa-comment fa-2x"></i>
			    نظرات کاربران
		    </a>
	    </li>

	    <li role="presentation">
		    <a href="#questions" aria-controls="questions" role="tab" data-toggle="tab">
			    <i class="fa fa-question fa-2x"></i>
			    پرسش و پاسخ
		    </a>
	    </li>

	  </ul>

	  <!-- Tab panes -->
	  <div class="tab-content">

	    <div role="tabpanel" class="tab-pane active" id="review" style="font-size: 15px;">

	    	<div style="width:95% ; margin-top:30px ; margin-right:30px">
	    		<h3 style="padding-bottom: 20px"> نقد و بررسی متخصصین </h3>

	    		@if(sizeof($review)>0)
	    			{!! nl2br(strip_tags($review[0]->desc, '<img>')) !!}

	    		@else

	    			<p style="color:red ; text-align:center ; padding-top:30px; padding-bottom:30px;">
		    			 نقد و بررسی ای برای این محصول ثبت نشده
	    			 </p>

	    		@endif
	    	</div>
	    </div>

	    <div role="tabpanel" class="tab-pane" id="features">

	    	<div class="feature_heading">
	    		 مشخصات فنی
	    		 <span> {{ $product->code }} </span>
	    	</div>

		    <table class="feature_table">
		    	
		    	@if( count($assigned_features_key) > 0 )

			    	@foreach($features as $key=>$value)

			    		@if( array_key_exists($value->id, $assigned_features_key) OR
			    			 ($value->parent_id == 0)
			    			)

					    	@if($value->parent_id == 0)
					    			
								<tr>
									<th colspan="2">
										<span> {{ $value->name }} </span>
									</th>
								</tr>
							@else
								<tr>
									<td style="width: 30%;">

										<div class="feature_name">
											@if( array_key_exists($value->id, $assigned_features_key))
												{{ $value->name }}
											@endif
										</div>
									

									</td>

									<td style="width: 70%;">
										@if($value->filled == 1)

											@if( array_key_exists($value->id, $assigned_features_key))

												<div class="feature_value" style="width: 100%;">
													{{$assigned_features_key[$value->id]}}
												</div>										

											@endif

										@endif
									</td>
								</tr>
							@endif
						@endif
		    		@endforeach

		    	@else
		    		 <p style="color:red ; text-align:center ; padding-top:30px; padding-bottom:30px;">
		    			 نقد و بررسی ای برای این محصول ثبت نشده
	    			 </p>
		    	@endif

		    </table>
	    	
	    </div>

	    <div role="tabpanel" class="tab-pane" id="comments"> comments </div>
	    <div role="tabpanel" class="tab-pane" id="questions"> questions </div>
	  </div>

</div>


@endsection

@section('footer')

    <script type="text/javascript" src="{{ url('js/jscolor.js') }}"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script type="text/javascript" src="{{ url('js/jquery.elevateZoom-3.0.8.min.js') }}"></script>
    
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>



    <script type="text/javascript">

    	// Changing 'background-color' of the selected product-color (29767380)
    	$('.list-group').on('click','> a', function(e) {
		   var $this = $(this);
		    $('.list-group').find('.active').removeClass('active');
		    $this.addClass('active');

		    // color_session => color_id
		    document.getElementById('color_session').value=event.srcElement.id;
		});

    	// Preventing href="#" Going to Top of Page (13003044)
		$('.color_a').click(function(e) {
		    e.preventDefault();
		});

		// Zoom on img
		$("#product_img").elevateZoom({
			zoomWindowPosition:'imgZoom',
			borderSize:1,
			scrollZoom:true,
			cursor:'zoom-in',
			/*zoomWindowWidth:100,
			zoomWindowHeight:100,
			zoomLevel:0.5*/
		});


		// Changing img+ZoomedImg when clicked on thumbnails
		imgToShow = function(img)
		{
			var imageElement = $('#product_img');
			imageElement.attr('src', img);

			// 19110330 - 31910882
			var prev_img = document.getElementById("product_img").src;
			var ez = $("#product_img").data("elevateZoom");
			ez.swaptheimage(prev_img, img);
		}


		// Tab: Review-features-comments-questions
		$('#myTabs a').click(function (e) {
		  e.preventDefault()
		  $(this).tab('show')
		});

		// Choosing/Setting default color
		document.addEventListener('DOMContentLoaded', function() {

			var $first_color = <?php echo json_encode($product->color_product_frontend[0]->id); ?>;

			// Choosing
			$('#color_'+$first_color).addClass('active');

			// Setting: color_session => color_id (First color of the color[])			
		    document.getElementById('color_session').value = "color_"+$first_color;

		}, false);


    </script>

@endsection