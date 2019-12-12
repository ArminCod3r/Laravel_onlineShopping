@extends('site/layouts/siteLayout')

@section('header')
  <link rel="stylesheet" type="text/css" href="{{ url('slick/slick/slick.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ url('slick/slick/slick-theme.css') }}">
@endsection

@section('content')

<div class="row">

	<!-- Right Panel -->
	<div class="col-sm-3 col-md-3 col-md-3 col-xl-3 right_panel">
		<img src="{{ url('images/'.'0d72d29b.jpg') }}" >		
		<img src="{{ url('images/'.'9de147be.jpg') }}" >		
		<img src="{{ url('images/'.'86a4c9bc.jpg') }}" >		
		<img src="{{ url('images/'.'94cb3501.jpg') }}" >		
	</div>

	<!-- Left Panel -->
	<div class="col-sm-9 col-md-9 col-lg-9 col-xl-9 sliders" id="sliders">

		<!-- Sliders images -->
		@if(sizeof($sliders)>0)
			<div>			
				@foreach ($sliders as $key => $item)
					@if($key == 1)
						<img src="{{ url('upload/'.$item->img) }}" id="slider_img_{{ $key }}" 
												style="display: block" class="animation">
					@else
						<img src="{{ url('upload/'.$item->img) }}" id="slider_img_{{ $key }}"
												style="display: none" class="animation">
					@endif
				@endforeach			
			</div>
		@endif

		<!-- Sliders texts -->
		<div class="slider_name">

			@if(sizeof($sliders)>0)
				@foreach ($sliders as $key => $item)

					@if($key == 1)
						<div class="slider_text_active" id="slider_text_{{ $key }}"
												onclick="change_slider('{{ $key }}')">
							{{ $item->title }}
						</div>
					@else
						<div class="slider_text" id="slider_text_{{ $key }}"
							 					onclick="change_slider('{{ $key }}')"> 
							{{ $item->title }}
						</div>
					@endif
				@endforeach
			@endif

		</div>

		<!-- Amazing offers -->
		@if(sizeof($amazing_products)>0)

			@foreach($amazing_products as $key=>$value)

				<!-- Details -->
				<div class="col-md-12">

					@if($key == 0)

						<a href="#" class="amazing_products_links">

							<div class="amazing_product_active" id="amazing_product_{{ $key }}">
								<p style="color:red ; padding-top: 12px;">
									پیشنهاد شگفت انگیز امروز
								</p>
								<!-- Price -->
								<span class="price">
									<?php
										$price_figures = str_replace("000", "", $value->price);
									?>

									{{ number_format($price_figures) }}
								</span>

								<!-- Discounted price -->
								<span class="price_discounted">

									<span style="font-size: 15px;">
									<?php
										$discounted = ($value->price - (($value->price * $value->price_discounted )/100));
										$price_discounted_figures = str_replace("000", "", $discounted);
									?>
									</span>

									{{ number_format($price_discounted_figures) }}

									<span> 
										<?php
											$unit = array(
												4=> "هزار تومان" ,
												5=> "هزار تومان" ,
												6=> "هزار تومان" ,
												7=> "میلیون تومان",
												8=> "میلیون تومان",
												9=> "میلیون تومان",
												10=> "میلیازد تومان",
												11=> "میلیازد تومان",
												10=> "میلیازد تومان",
												);

											if(array_key_exists(strlen($discounted), $unit) )
												echo $unit[strlen($discounted)];
										?>
									</span>
									
								</span>							

								<div style="padding-top: 20px">
									{!! nl2br($value->description) !!}
								</div>
							
							
								<!-- Image -->
								<div>
									<p class="long_title" style="font-weight: bold; font-size:20px">
										{{ $value->long_title }}
										
										@if($value->ProductImage)
											<div class="amazing_product_image">
												<img src="{{ url('upload').'/'.$value->ProductImage->url }}">
											</div>
										@endif
									</p>
								</div>
							</div>
						</a>
					

					@else
						<a href="#" class="amazing_products_links">

								<div class="amazing_product_not_active" id="amazing_product_{{ $key }}">
									<p style="color:red ; padding-top: 12px;">
										پیشنهاد شگفت انگیز امروز
									</p>
									<!-- Price -->
									<span class="price">
										<?php
											$price_figures = str_replace("000", "", $value->price);
										?>

										{{ number_format($price_figures) }}
									</span>

									<!-- Discounted price -->
									<span class="price_discounted">

										<span style="font-size: 15px;">
										<?php
											$discounted = ($value->price - (($value->price * $value->price_discounted )/100));
											$price_discounted_figures = str_replace("000", "", $discounted);
										?>
										</span>

										{{ number_format($price_discounted_figures) }}

										<span> 
											<?php
												$unit = array(
													4=> "هزار تومان" ,
													5=> "هزار تومان" ,
													6=> "هزار تومان" ,
													7=> "میلیون تومان",
													8=> "میلیون تومان",
													9=> "میلیون تومان",
													10=> "میلیازد تومان",
													11=> "میلیازد تومان",
													10=> "میلیازد تومان",
													);

												if(array_key_exists(strlen($discounted), $unit) )
													echo $unit[strlen($discounted)];
											?>
										</span>
										
									</span>							

									<div style="padding-top: 20px">
										{!! nl2br($value->description) !!}
									</div>
								
								
									<!-- Image -->
									<div>
										<p class="long_title" style="font-weight: bold; font-size:20px">
											{{ $value->long_title }}
											
											@if($value->ProductImage)
												<div class="amazing_product_image">
													<img src="{{ url('upload').'/'.$value->ProductImage->url }}">
												</div>
											@endif
										</p>
									</div>
								</div>
							</a>
					
					@endif					
				</div>
					
				
			@endforeach

			<!-- Texts -->
			<div class="short_titles">

				@foreach ($amazing_products as $key => $value)
					@if($key == 0)
						<div class="title_active" id="short_title_{{ $key }}"
							 					  onclick="change_offer('{{ $key }}')">
							{{ $value->short_title }}
						</div>					
					@else
						<div class="title_not_active" id="short_title_{{ $key }}"
							 					      onclick="change_offer('{{ $key }}')">
							{{ $value->short_title }}
						</div>
					@endif
				@endforeach

			</div>
		@endif
		

		<!-- Newest products -->
		<div class="newest_product">

			<div class="newest_products_title">
				<span> جدیدترین محصولات فروشگاه </span>
			</div>

			<div class="right-space-arrow"></div>
			<div class="left-space-arrow"></div>

			<section class="view_products">

				@foreach($newest_products as $key=>$value)
					<div class="newest_products_image_box">

						@if(sizeof($value['product_image'])>0)

							@foreach($value['product_image'] as $key_img => $value_img)
								@if($key_img == 0 )

									<div class="newest_products_image">
										<img src="{{ url('upload/'.$value_img['url']) }}">
									</div>

								@endif
							@endforeach

						@endif

						<p>
							<a class="newest_product_title"
									href="{{ url('product').'/'.str_replace(' ','-', $value['code']).'/'.$value['title_url'] }}">

								@if(mb_strlen($value['title']) > 35)
									{{ substr($value['title'],35).'...' }} 
									
								@else
									{{ $value['title'] }}

								@endif
							</a>
						</p>

						<!-- Price -->
						@if($value['discounts'])
							<p class="newest_product_price" style="color: #b8b8b8 !important">
								{{ number_format($value['price']) }} تومان
							</p>							
						@else
							<p class="newest_product_price">
								{{ number_format($value['price']) }} تومان
							</p>
						@endif

						<!-- Discount -->
						<p class="newest_product_discount">
							@if($value['discounts'])
								{{ $value['discounts'] }}%
							@else
								<div style="display:none;"> 0%</div>
							@endif
						</p>

						<!-- Price with discount -->
						@if($value['discounts'])
							<p class="newest_product_price_with_discount">
								{{ number_format( $value['price'] - (($value['price'] * $value['discounts'] )/100) ) }} تومان
							</p>
						@endif
					</div>
				@endforeach


			</section>

		</div>
		

	</div>
	

</div>

@endsection

@section('footer')
	<script type="text/javascript" src="{{ url('slick/slick/slick.js') }}" charset="utf-8"></script>
	<script>

		slide_count = <?php echo sizeof($sliders); ?>;
		slide=0;

		setInterval(function(){
			next();

		}, 3000);


		next = function()
		{
			for (var i=0 ; i<slide_count; i++)
			{
				document.getElementById('slider_img_'+i).style.display="none";

				$('#slider_text_'+i).removeClass('slider_text_active');
				$('#slider_text_'+i).addClass('slider_text');
			}

			document.getElementById('slider_img_'+slide).style.display="block";
			$('#slider_text_'+slide).addClass('slider_text_active');

			slide = slide+1;

			if(slide == slide_count)
			{
				slide=0;
			}
		}

		back = function()
		{

		}

		change_slider = function(slider_key)
		{
		   for (var i=0 ; i<slide_count; i++)
			{
				document.getElementById('slider_img_'+i).style.display="none";

				$('#slider_text_'+i).removeClass('slider_text_active');
				$('#slider_text_'+i).addClass('slider_text');
			}

			document.getElementById('slider_img_'+slider_key).style.display="block";
			$('#slider_text_'+slider_key).addClass('slider_text_active');

			// if a user changed the slide manually, keep sliding after the selected one
			slide=Number(slider_key);
		};


		// Newest Products
		$(".view_products").slick({
	        //dots: true,
	        infinite: true,
	        centerMode: true,
	        slidesToShow: 4,
	        slidesToScroll:4,
	        rtl: true
	     });


		// Amazing Products -------------

		offer_count = <?php echo sizeof($amazing_products); ?>;

		change_offer = function(offer_key)
		{
			// Deactivating all the offers
			for (var i=0 ; i<offer_count; i++)
			{
				$('#amazing_product_'+i).removeClass('amazing_product_active');
				$('#amazing_product_'+i).addClass('amazing_product_not_active');


				$('#short_title_'+i).removeClass('title_active');
				$('#short_title_'+i).addClass('title_not_active');
			}

			// Activating the selected offer

			$('#amazing_product_'+offer_key).removeClass('amazing_product_not_active');
			$('#amazing_product_'+offer_key).addClass('amazing_product_active');

			$('#short_title_'+offer_key).removeClass('title_not_active');
			$('#short_title_'+offer_key).addClass('title_active');
		}

	</script>
@endsection