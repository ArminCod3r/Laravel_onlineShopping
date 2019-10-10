@extends('admin/layouts/adminLayout')


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

@section('custom-title')
  ایجاد دسته جدید
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
			 <option value="0">انتخاب دسته</option>

			 <?php
			 	foreach ($categories as $id=>$item)
			 	{
			 		$cat_name = explode(':', $item)[0];
					$id       = explode(':', $item)[1];

					echo '<option value="'.$id.'">'.$cat_name.'</option>';
			 	}
			 ?>

			  
			</select> 

  			@if($errors->has('parent_id'))
  				<span style="color: red;"> {{ $errors->first('parent_id') }} </span>
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

	<script>

		select_file=function()
		{
		   document.getElementById('img').click();
		};

		load_file=function (event)
		{
		    var render=new FileReader;
		    render.onload=function ()
		    {
		        var res_img=document.getElementById('res_img');
		        res_img.src=render.result;
		    };
		    render.readAsDataURL(event.target.files[0]);
		}

	</script>
@endsection