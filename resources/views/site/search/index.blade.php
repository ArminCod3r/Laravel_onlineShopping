@extends('site/layouts/siteLayout')

@section('header')
@endsection

@section('content')
	<div>
		<div class="row" style="margin: 0px 20px 0px 20px;">

			<div class="col-sm-2 filters_area">

				@foreach($cat3_filters as $key=>$value)
					
						
					
					@if($value->parent_id == 0)
						{{$value->name}}

						<ul class="filter_ul" id="filter_ul">
						@foreach($cat3_filters as $key_2=>$value_2)
							@if($value_2->parent_id == $value->id )

								<li onclick="checking('{{$value_2->id}}')">
									@if($value_2->filled == 1)
										<span class="filter_checkbox" id="{{$value_2->id}}"></span>
									@endif

									<span class="filter_item"> {{$value_2->name}} </span>
								</li>
							@endif
						@endforeach
						</ul>
						
					@endif
					
				@endforeach
			</div>

			<div class="col-sm-10">
				
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
		}

		if(filter == 'filter_checkbox_true')
		{
			document.getElementById(id).removeClass = 'filter_checkbox_true';
			document.getElementById(id).className   = 'filter_checkbox';
		}
	}

</script>

@endsection