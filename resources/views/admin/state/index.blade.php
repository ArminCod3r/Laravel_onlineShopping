@extends('admin/layouts/adminLayout')

@section('header')
	<link rel="stylesheet" type="text/css" href="{{ url('css/bootstrap-select.css') }}">
	<title>لیست استان ها</title>

	<style type="text/css">

    	.bootstrap-select > .dropdown-toggle
    	{
    		background-color: white;
    		width: 230px;
    		text-align-last: right;
    	}

    	.filter-option-inner-inner
    	{
    		color: black;
    	}

	</style>

@endsection

@section('custom-title')
  لیست استان ها
@endsection

@section('content1')
	<section class="col-lg-7 connectedSortable">

	<a href="{{ url('admin/state/create') }}" class="btn btn-success"> افزودن استان </a>
	<br><br>

	@if(!empty($states))
		<?php $count=1; ?>
		<table class="table table-hover" style="width: 80%; margin: 20px 20px 20px 0px;">
			<tr>
				<th style="width: 20%;">ردیف</th>
				<th style="width: 50%;">نام استان</th>
				<th>عملیات</th>
			</tr>

			@foreach($states as $key=>$value)			
				<tr>
					<td>{{ $count }}</td>
					<td>

					      <div class="form-group">
							 <select name="state" class="selectpicker" data-live-search="true">
							 <!--stack: 24627902-->

							 	<option disabled selected value style="background-color: white !important"> {{$value->name}} </option>

							 	@if(sizeof($value->city) > 0)
									@foreach($value->city as $key_city=>$value_city)
										<option value="{{$value_city->id}}">{{$value_city->name}}</option>
									@endforeach
								@else
									nothing in here
								@endif
							  
							 </select> 
						</div>

					</td>
					<td>
						<a href="state/{{ $value->id }}/edit" class="fa fa-edit" style="margin-top: 10px"> </a>

						<form action="{{ action('admin\StateController@destroy', ['id' => $value->id]) }}" method="POST"  accept-charset="utf-8" class="pull-right"  onsubmit="return confirm('آیا قصد حذف این دسته را دارید؟')"> <!--stack: 39790082-->
		                        {{ csrf_field() }} 

	                        <input type="hidden" name="_method" value="DELETE">
	                        <input type="submit" name="submit" value="X" class="submitStyle" style="margin-top: 10px">
	                    </form>

	                    <a href="#" data-toggle="tooltip" data-placement="left" title="نمایش همه شهرها">
	                    	<span class="fa fa-eye" style="cursor:pointer; color: green" id="{{ $value->id }}" onclick="show_cities('{{ $value }}')"></span>
	                    </a>

					</td>


				</tr>
				<?php $count++; ?>
			@endforeach
		</table>

		{{ $states->links() }}

	@else
		nothing in here
	@endif

@endsection

@section('content4')

<section class="col-lg-5 connectedSortable">

<div class="form-group list-group" id="cities" style="width: 90%">
	<!-- cities will be shown here-->
	<span id="link_to_create_city" style="display: none">
		<span>شهری وارد نشده...</span>
		<span>
			<a href="/admin/city/create"> افزودن شهر</a>
		</span>
	</span>
	 
	 <ul class="list-group" id="cities_list">
	</ul> 		
</div>

@endsection



@section('footer')
	<script type="text/javascript" src="{{ url('js/bootstrap-select.js') }}"></script>
	<script type="text/javascript" src="{{ url('js/defaults-fa_IR.js') }}"></script>

	<script type="text/javascript">

	$(document).ready(function(){

	  // showing bootstrap-tooltip
	  $('[data-toggle="tooltip"]').tooltip();

	  // hiding tooltip when item got clicked
	  $('[data-toggle="tooltip').on('click', function () {
	    $(this).tooltip('hide');
	  });

	});

		show_cities = function(state)
		{
			// clearing the previous result
			document.getElementById('cities_list').innerHTML = "";

			//string to JSON
			var state = JSON.parse(state);


			// check to see if city exits
			if(state["city"].length > 0)
			{
				document.getElementById("link_to_create_city").style.display = "none";

				// Loop on array
				for (var i = 0; i < state["city"].length; i++)
				{
					city_name = state["city"][i]["name"];

					var cities = '<li class="list-group-item">'+city_name+'</li>';
					$("#cities_list").append(cities);
				}
			}

			else
			{
				document.getElementById("link_to_create_city").style.display = "block";
			}
		}

	</script>

@endsection	