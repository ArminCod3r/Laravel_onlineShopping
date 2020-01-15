@extends('admin/layouts/adminLayout')

@section('header')
	<title>افزودن استان</title>
@endsection

@section('custom-title')
  افزودن استان
@endsection


@section('content1')
 <form action="{{ action('admin\StateController@store') }}" method="POST" accept-charset="utf-8" enctype="multipart/form-data">
		{{ csrf_field() }}
		

		<div class="row" style="margin: 30px 0px 30px 0px;">
			<div class="col-sm-2">
				<label for="state" style="padding-top: 5px;">نام استان</label>
			</div>

			<div class="col-sm-10">
				<input type="text" name="state" id="state" class="form-control" value="" placeholder=""><br>
			</div>

			
  			

  			@if($errors->has('state'))
  				<span style="color: red;"> {{ $errors->first('state') }} </span>
  			@endif
		</div>

		<div class="row">
			<div class="col-sm-2">
				<input type="submit" name="submit" value="ثبت" class="btn btn-success" style="width: 100%;">
			</div>

			<div class="col-sm-10">
			</div>
		</div>

		

	</form>
@endsection
