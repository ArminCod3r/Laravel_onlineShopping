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


		$(".view_products").slick({
	        //dots: true,
	        infinite: true,
	        centerMode: true,
	        slidesToShow: 4,
	        slidesToScroll:4,
	        rtl: true
	     });

	</script>
@endsection