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
  ویرایش : {{ $category->cat_name }}
@endsection


@section('content1')
 <form action="{{route('category.update', $category->id ) }}" method="POST" accept-charset="utf-8" enctype="multipart/form-data"> <!--stack: 40803339-->
		{{ csrf_field() }}
		

		<div class="form-group">
			<label for="title">نام دسته</label>
  			<input type="text" name="cat_name" id="title" class="form-control" value="{{$category->cat_name}}" placeholder=""><br>

  			@if($errors->has('cat_name'))
  				<span style="color: red;"> {{ $errors->first('cat_name') }} </span>
  			@endif
		</div>

		<div class="form-group">
			<label for="title">نام لاتین دسته</label>
  			<input type="text" name="cat_ename" id="title" class="form-control" value="{{$category->cat_ename}}" placeholder=""><br>

  			@if($errors->has('cat_ename'))
  				<span style="color: red;"> {{ $errors->first('cat_ename') }} </span>
  			@endif
		</div>

		<div class="form-group">
			<label for="title">انتخاب دسته</label>
			 <select name="parent_id" class="selectpicker" id="selectpicker" data-live-search="true" >

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
			@if(!empty($category->img))
				<img src="{{ url('upload/'.$category->img) }}" id='res_img' width="150" onclick="select_file()">
			@else
				<img src="{{ url('images/noimage.jpg') }}" id='res_img' width="150" onclick="select_file()">

			@endif

			@if($errors->has('img'))
  				<span style="color: red;"> {{ $errors->first('img') }} </span>
  			@endif
		</div>


		<input type="hidden" name="_method" value="PATCH">

		<input type="submit" name="submit" value="ویرایش" class="btn btn-primary">

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

		document.addEventListener('DOMContentLoaded', function() {

		    // stack: 14804253 -- https://jsfiddle.net/t0xicCode/96ntuxnz/

			var selectpicker_ = [];

			console.log(selectpicker_);

			$('.selectpicker').selectpicker('val', 20); //id of the current category

			// set jscolor's first input(FFFFFF) to none
			$('#color').val(color.style.backgroudColor);
		}, false);

	</script>
@endsection