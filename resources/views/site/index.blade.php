@extends('site/layouts/siteLayout')



@section('content')

<div class="row">

	<!-- Right Panel -->
	<div class="col-md-3 right_panel">
		<img src="{{ url('images/'.'0d72d29b.jpg') }}" >		
		<img src="{{ url('images/'.'9de147be.jpg') }}" >		
		<img src="{{ url('images/'.'86a4c9bc.jpg') }}" >		
		<img src="{{ url('images/'.'94cb3501.jpg') }}" >		
	</div>

	<!-- Left Panel -->
	<div class="col-md-9 sliders">
		<div>
			@if(sizeof($sliders)>0)
				@foreach ($sliders as $key => $item)
					@if($key == 1)
						<img src="{{ url('upload/'.$item->img) }}" style="display: block" >
					@else
						<img src="{{ url('upload/'.$item->img) }}" style="display: none" >
					@endif
				@endforeach
			@endif
		</div>


		<div class="slider_name">

			@if(sizeof($sliders)>0)
				@foreach ($sliders as $key => $item)
					<!-- <span > {{ $item->title }} </span> -->

					@if($key == 1)
						<a href="#" class="slider_name_text">  {{ $item->title }} </a>
					@else
						<a href="#" class="slider_name_text">  {{ $item->title }} </a>
						<!-- <a href="#" class="slider_name_text">  {{ $item->title }} </a> -->
					@endif
				@endforeach
			@endif

		</div>
	</div>
</div>

@endsection
