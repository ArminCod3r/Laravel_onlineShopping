@extends('admin/layouts/adminLayout')


@section('header')
	<title>افزودن دسته</title>
	<link rel="stylesheet" type="text/css" href="{{ url('css/bootstrap-select.css') }}">	
@endsection

@section('custom-title')
  ایجاد اسلایدر
@endsection


@section('content1')
 <form action="{{ action('admin\SliderController@store') }}" method="POST" accept-charset="utf-8" enctype="multipart/form-data">
		{{ csrf_field() }}
		

		<div class="form-group">
			<label for="title">نام دسته</label>
  			<input type="text" name="title" id="title" class="form-control" value="" placeholder=""><br>

  			@if($errors->has('title'))
  				<span style="color: red;"> {{ $errors->first('title') }} </span>
  			@endif
		</div>

		<div class="form-group">
			<label for="title">آدرس</label>
  			<input type="text" name="url" id="title" class="form-control" value="" placeholder=""><br>

  			@if($errors->has('url'))
  				<span style="color: red;"> {{ $errors->first('url') }} </span>
  			@endif
		</div>
	
		<div class="form-group">
			<input type="file" name="img" id="img" style="display: none;" onchange="load_file(event)">
			<img src="{{ url('images/noimage.jpg') }}" id='res_img' width="150" onclick="select_file()">

			@if($errors->has('img'))
  				<span style="color: red;"> {{ $errors->first('img') }} </span>
  			@endif
		</div>

		<input type="submit" name="submit" value="ثبت" class="btn btn-primary">

	</form>
@endsection

@section('content2')
	<br><br><br><br><br><br>
@endsection

@section('footer')
	<script type="text/javascript" src="{{ url('js/bootstrap-select.js') }}"></script>
	<script type="text/javascript" src="{{ url('js/defaults-fa_IR.js') }}"></script>
@endsection