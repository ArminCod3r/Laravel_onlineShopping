@extends('site/layouts/siteLayout')

@section('header')

	<style type="text/css">
	
		.checked_filters_class
		{
			display: none;
		}
	
	</style>

	<!--Plugin CSS file with desired skin-->
    <link rel="stylesheet" type="text/css" href="{{ url('css/ion.rangeSlider.css') }}">

@endsection

@section('content')
	<div>
		<div class="row" style="margin: 0px 20px 0px 20px;">

			<div class="col-2 col-sm-2 col-md-2 col-lg-2 col-xl-2 filters_area">

				<div>

				<div style="clear: both; padding-top: 20px"></div>


					<div style="margin: 20px;">
						<button class="btn btn-primary" onclick="set_price_range(this)">اعمال محدوده قیمت</button>
					</div>
				</div>

			</div>

			<div class="col-10 col-sm-10 col-md-10 col-lg-10 col-xl-10">


				<div class="row sort" >
					<div class="col-sm-1"></div>
					<div class="col-sm-2 sum_product_result">
						<div>
							<span>مجموع :</span>
							<span>{{sizeof($products)}}</span>
						</div>
					</div>

					<div class="col-sm-2 title">
						<span>
							مرتب سازی بر اساس
						</span>
					</div>

					 <div class="col-sm-7 options">
					 	<ul class="list-group list-group-horizontal">
						 	<li class="list-group-item active-sort-option" id="sort_option_1" onclick="sort('1')">جدید ترین</li>
						 	<li class="list-group-item" id="sort_option_2" onclick="sort('2')">پرفروش ترین</li>
						  	<li class="list-group-item" id="sort_option_3" onclick="sort('3')">ارزان ترین</li>
						  	<li class="list-group-item" id="sort_option_4" onclick="sort('4')">گران ترین</li>
						 	<li class="list-group-item" id="sort_option_5" onclick="sort('5')">پر بازدید ترین</li>
						 </ul>
					 </div>
					 
				 </div>

				@if( sizeof($products) > 0 )

					<div style="text-align: center;background:white;margin: 5px 0px 5px 0px;border-radius: 5px;">
						{!! $products->links() !!}
					</div>
				@endif

				@foreach($products as $key=>$value)

					@if($key % 4 == 0)
					<div class="row products_list" style="height: 330px;">
					@endif

					<a href="/product/{{$value->code}}/{{$value->title_url}}">
						<div class="col-3 col-sm-3 col-md-3 col-lg-3 col-xl-3" style="height:750px; width: 244px">
						<div class="product_area">
							<div class="img">
							<img style="width: 48%" src="{{ url('/upload/'. $value->ProductImage[0]->url ) }}">
						</div>

						<div class="text">
							
							<?php
								if(strlen($value->title) > 26)
									echo mb_substr($value->title, 0, 27, "utf-8")."...";
								else
									print $value->title;
							?>

							<div class="search_products_price">
								{{number_format($value->price)}} تومان
							</div>
						</div>
						</div>
					</a>
						
							<br>			
					</div>

					@if($key % 3 == 0 and $key!=0)
					</div>
					@endif


				@endforeach



			</div>
				
			</div>

		</div>
	</div>


@endsection

@section('footer')

<script type="text/javascript">	
</script>

@endsection