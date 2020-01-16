@extends('admin/layouts/adminLayout')

@section('header')

	<link rel="stylesheet" type="text/css" href="{{ url('css/bootstrap-select.css') }}">
	<title>ویرایش شهر</title>

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
  ویرایش شهر  <span class="city-edit-header"> - {{ $city->name }} </span>
@endsection

@section('content1')
 <form action="{{ route('city.update', $city->id ) }}" method="POST" accept-charset="utf-8" enctype="multipart/form-data">
		{{ csrf_field() }}
		

		<div class="row" style="margin: 30px 0px 30px 0px;">
			<div class="col-sm-2">
				<label for="city" style="padding-top: 5px;">نام شهر</label>
			</div>

			<div class="col-sm-10">
				<input type="text" name="city" id="city" class="form-control" value="{{ $city->name }}" placeholder=""><br>
			</div>

  			@if($errors->has('city'))
  				<span style="color: red;"> {{ $errors->first('city') }} </span>
  			@endif
		</div>

		<div class="form-group">
			<label for="state" style="margin-left: 20px">انتخاب استان</label>
			 <select name="state" class="selectpicker" data-live-search="true">
			 <!--stack: 24627902-->

			 	@if(!empty($states))
					@foreach($states as $key_state=>$value_state)

						@if($value_state->id == $city->state_id)

							<option selected value="{{$value_state->id}}" style="width: 500px;">
								{{$value_state->name}}
							</option>

						@else

							<option value="{{$value_state->id}}" style="width: 500px;">
								{{$value_state->name}}
							</option>

						@endif

						
					@endforeach
				@else
					nothing in here
				@endif
			  
			 </select> 

  			@if($errors->has('state'))
  				<span style="color: red;"> {{ $errors->first('state') }} </span>
  			@endif
		</div>		


		<input type="hidden" name="_method" value="PATCH">

		<div class="row" style="margin-top: 50px">
			<div class="col-sm-2">
				<input type="submit" name="submit" value="ویرایش" class="btn btn-primary" style="width: 100%;">
			</div>

			<div class="col-sm-10">
			</div>
		</div>

	</form>
@endsection

@section('footer')
	<script type="text/javascript" src="{{ url('js/bootstrap-select.js') }}"></script>
	<script type="text/javascript" src="{{ url('js/defaults-fa_IR.js') }}"></script>
@endsection	