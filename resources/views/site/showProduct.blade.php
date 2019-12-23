@extends('site/layouts/siteLayout')

@section('header')
  <link rel="stylesheet" type="text/css" href="{{ url('slick/slick/slick.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ url('slick/slick/slick-theme.css') }}">

  <link rel="stylesheet" href="{{ url('css/flipclock.css') }}">
  <script src="{{ url('js/flipclock.js') }}"></script>
@endsection

@section('content')

<div class="container">
	<div class="row" style="margin-top:20px ; background:white">

		<div class="col-sm-4">
			<img src="{{ url('upload').'/'.$product->ProductImage[0]->url }}" class="product_img">
		</div>


		<div class="col-sm-8">
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

		</div>

	</div>
</div>

@endsection