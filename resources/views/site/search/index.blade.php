@extends('site/layouts/siteLayout')

@section('header')
@endsection

@section('content')
	<div>
		<div class="row" style="margin: 0px 20px 0px 20px;">

			<div class="col-sm-2" style="background-color: white">

				@foreach($cat3_filters as $key=>$value)					
					
					@if($value->parent_id == 0)
						{{$value->name}}
					@endif
					
				@endforeach
			</div>

			<div class="col-sm-10">
				
			</div>

		</div>
	</div>
@endsection
