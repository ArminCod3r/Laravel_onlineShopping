@extends('site/layouts/siteLayout')



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
	<div class="col-sm-9 col-md-9 col-lg-9 col-xl-9 sliders" id="sliders" class="sliders">

		@if(sizeof($sliders)>0)
			<div>			
				@foreach ($sliders as $key => $item)
					@if($key == 1)
						<img src="{{ url('upload/'.$item->img) }}" id="slider_img_{{ $key }}"
																   style="display: block" >
					@else
						<img src="{{ url('upload/'.$item->img) }}" id="slider_img_{{ $key }}"
																   style="display: none" >
					@endif
				@endforeach			
			</div>
		@endif


		<div class="slider_name">

			@if(sizeof($sliders)>0)
				@foreach ($sliders as $key => $item)

					@if($key == 1)
						<div class="slider_name_text slider_name_active" id="slider_text_{{ $key }}"
												onclick="change_slider('{{ $key }}')">
							{{ $item->title }}
						</div>
					@else
						<div class="slider_name_text" id="slider_text_{{ $key }}"
							 					onclick="change_slider('{{ $key }}')"> 
							{{ $item->title }}
						</div>
					@endif
				@endforeach
			@endif

		</div>

	</div>
	

</div>

@endsection

@section('footer')
	<script>

		slide_count = <?php echo sizeof($sliders); ?>;
		slide=0;

		setInterval(function(){
			next();

		}, 3000);

		console.log(slide_count);
		next = function()
		{
			for (var i=0 ; i<slide_count; i++)
			{
				console.log('slider_img_'+i);
				document.getElementById('slider_img_'+i).style.display="none";
			}
			document.getElementById('slider_img_'+slide).style.display="block";

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
		   console.log(slider_key);


		   //var img = document.getElementById(slider_name);
		   //img.style.display = "block";

		   //document.getElementById('sliders').style.display = "none"; 
		};

	</script>
@endsection