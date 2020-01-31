@extends('admin/layouts/adminLayout')

@section('header')

	<link rel="stylesheet" type="text/css" href="{{ url('css/bootstrap-select.css') }}">
	<title>افزودن شهر</title>

	<style type="text/css">

    	.bootstrap-select > .dropdown-toggle
    	{
    		background-color: white;
    		width: 500px;
    		text-align-last: right;
    	}

	</style>

@endsection

@section('custom-title')
  افزودن شهر
@endsection

@section('content1')

 <section class="col-lg-7 connectedSortable">
 
 <form action="{{ action('admin\CityController@store') }}" method="POST" accept-charset="utf-8" enctype="multipart/form-data">
		{{ csrf_field() }}
		

		<div class="row" style="margin: 30px 0px 30px 0px;">
			<div class="col-sm-2">
				<label for="city" style="padding-top: 5px;">نام شهر</label>
			</div>

			<div class="col-sm-10">
				<input type="text" name="city" id="city" class="form-control" value="" placeholder=""><br>
			</div>

  			@if($errors->has('city'))
  				<span style="color: red;"> {{ $errors->first('city') }} </span>
  			@endif
		</div>

		<div class="form-group">
			<label for="state" style="margin-left: 20px">انتخاب استان</label>
			 <select name="state" class="selectpicker" data-live-search="true">
			 <!--stack: 24627902-->

			 	<option disabled selected value style="background-color: white !important"> چیزی انتخاب نشده است </option>

			 	@if(!empty($states))
					@foreach($states as $key=>$value)
						<option value="{{$value->id}}" style="width: 500px;">{{$value->name}}</option>
					@endforeach
				@else
					nothing in here
				@endif
			  
			 </select> 

  			@if($errors->has('state'))
  				<span style="color: red;"> {{ $errors->first('state') }} </span>
  			@endif
		</div>		



		<div class="row" style="margin-top: 50px">
			<div class="col-sm-2">
				<input type="submit" name="submit" value="ثبت" class="btn btn-success" style="width: 100%;">
			</div>

			<div class="col-sm-10">
			</div>
		</div>

	</form>
@endsection

@section('content4')
	<section class="col-lg-5 connectedSortable">
@endsection


@section('footer')
	<script type="text/javascript" src="{{ url('js/bootstrap-select.js') }}"></script>
	<script type="text/javascript" src="{{ url('js/defaults-fa_IR.js') }}"></script>
@endsection	