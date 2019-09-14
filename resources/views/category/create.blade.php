@extends('layouts/admin')


@section('header')
	<title>افزودن دسته</title>
	<link rel="stylesheet" type="text/css" href="{{ url('css/bootstrap-select.css') }}">
	<style type="text/css">
		.bootstrap-select .dropdown-toggle .filter-option{
			text-align:right;
		}

		.bootstrap-select:not([class*="col-"]):not([class*="form-control"]):not(.input-group-btn){
			width:100%;
		}
	</style>
@endsection

@section('content1')
 <form action="{{ action('admin\CategoryController@store') }}" method="POST" accept-charset="utf-8" enctype="multipart/form-data">
		{{ csrf_field() }}
		

		<div class="form-group">
			<label for="title">نام دسته</label>
  			<input type="text" name="cat_name" id="title" class="form-control" value="" placeholder=""><br>

  			@if($errors->has('cat_name'))
  				<span style="color: red;"> {{ $errors->first('cat_name') }} </span>
  			@endif
		</div>

		<div class="form-group">
			<label for="title">نام لاتین دسته</label>
  			<input type="text" name="cat_ename" id="title" class="form-control" value="" placeholder=""><br>

  			@if($errors->has('cat_ename'))
  				<span style="color: red;"> {{ $errors->first('cat_ename') }} </span>
  			@endif
		</div>

		<div class="form-group">
			<label for="title">انتخاب دسته</label>
			 <select name="parent_id" class="selectpicker" data-live-search="true">
			 <option value="a">aa</option>
			 <option value="b">bb</option>
			 <!--@if(count($cat) > 0)
				 @foreach($cat as $item)			 	
				 	<option value="{{ $item->id }}">{{ $item->cat_name }}</option>
				 @endforeach
			 @endif-->
			  
			</select> 

  			@if($errors->has('parent_id'))
  				<span style="color: red;"> {{ $errors->first('parent_id') }} </span>
  			@endif
		</div>
	
		<div class="form-group">
			<input type="file" name="img" id="fileToUpload">
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