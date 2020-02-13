@extends('site/layouts/siteLayout')

@section('header')

	<style type="text/css">
	
		.checked_filters_class
		{
			display: none;
		}
	
	</style>

@endsection

@section('content')
	<div>
		<div class="row" style="margin: 0px 20px 0px 20px;">

			<div class="col-2 col-sm-2 col-md-2 col-lg-2 col-xl-2 filters_area">

				@foreach($filters as $key=>$value)
					
						
					
					@if($value->parent_id == 0)
						{{$value->name}}

						<ul class="filter_ul" id="filter_ul">
						@foreach($filters as $key_2=>$value_2)
							@if($value_2->parent_id == $value->id )

								<li onclick="checking('{{$value_2->id}}')">
									@if($value_2->filled == 1)

										@if((in_array(array_search($value_2->id, $brands_names), $selected_brands)))
											<span class="filter_checkbox_true" id="{{$value_2->id}}"></span>

<input type="checkbox" value="{{$value->ename}}[]={{array_search($value_2->id, $brands_names)}}" checked="checked" name="checked_filters" id="checked_filters_{{$value_2->id}}" style="display: none">

										@else
											<span class="filter_checkbox" id="{{$value_2->id}}"></span>

<input type="checkbox" value="{{$value->ename}}[]={{array_search($value_2->id, $brands_names)}}" name="checked_filters" id="checked_filters_{{$value_2->id}}" style="display: none">

										@endif
										
									@endif

									<span class="filter_item"> {{$value_2->name}} </span>
								</li>
							@endif
						@endforeach
						</ul>
						
					@endif
					
				@endforeach
			</div>

			<div class="col-10 col-sm-10 col-md-10 col-lg-10 col-xl-10">


				

					@foreach($products as $key=>$value)

						@if($key % 4 == 0)
						<div class="row products_list" style="height: 300px;">
						@endif

						<div class="col-3 col-sm-3 col-md-3 col-lg-3 col-xl-3" style="height:750px; width: 244px">
							<div class="img">
								<img height="100%" src="{{ url('/upload/'. $value->ProductImage->url ) }}">
							</div>

							<div class="text">
								
								<?php
									if(strlen($value->product[0]->title) > 26)
										echo mb_substr($value->product[0]->title, 0, 27, "utf-8")."...";
									else
										print $value->product[0]->title;
								?>
							</div>
							
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
	
	checking = function(id)
	{
		filter = document.getElementById(id).className;

		if(filter == 'filter_checkbox')
		{
			document.getElementById(id).removeClass = 'filter_checkbox';
			document.getElementById(id).className   = 'filter_checkbox_true';

			document.getElementById("checked_filters_"+id).checked = true;
		}

		if(filter == 'filter_checkbox_true')
		{
			document.getElementById(id).removeClass = 'filter_checkbox_true';
			document.getElementById(id).className   = 'filter_checkbox';

			document.getElementById("checked_filters_"+id).checked = false;
		}

		var filter_checkbox = document.getElementsByName("checked_filters");
		var url            = window.location.search;
		const urlParams    = new URLSearchParams(url);
		filters            = new Array();
		var url_attributes = window.location.origin + window.location.pathname+'?';

		for(var i=0 ; i<filter_checkbox.length ; i++)
		{
			if(filter_checkbox[i].checked)
			{
				filters.push(filter_checkbox[i].value);
			}				
		}

		if(filters.length > 1)
		{
			for(i=0 ; i<filters.length ; i++)
			{
				url_attributes = url_attributes + filters[i] + "&";
			}
		}

		window.location.replace(url_attributes);

	}

</script>

@endsection