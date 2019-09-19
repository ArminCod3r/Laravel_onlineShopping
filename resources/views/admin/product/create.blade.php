@extends('admin/layouts/adminLayout')



@section('header')
    <title>افزودن محصول</title>
    <link rel="stylesheet" type="text/css" href="{{ url('css/bootstrap-select.css') }}">
    <style type="text/css">
    	.bootstrap-select:not([class*="col-"]):not([class*="form-control"]):not(.input-group-btn)
    	{
    		width: 75%;
		}
	</style>
@endsection

@section('custom-title')
  افزودن محصول
@endsection



@section('content1')
 <form action="{{ action('admin\ProductController@store') }}" method="POST" accept-charset="utf-8" enctype="multipart/form-data">
		{{ csrf_field() }}
		

		<div class="form-group">
			<label for="title">نام محصول</label>
  			<input type="text" name="title" id="title" class="form-control" value="" placeholder=""><br>

  			@if($errors->has('title'))
  				<span style="color: red;"> {{ $errors->first('title') }} </span>
  			@endif
		</div>


		<div class="form-group">
			<label for="title">انتخاب دسته</label>
			 <select multiple="multiple" name="cat[]" class="selectpicker" data-live-search="true">
			 <!--stack: 24627902-->

				 @for ($i=0; $i <=count($cat_list)-1; $i++)
			        <option value="{{ $i }}">{{ $cat_list[$i] }}</option>
			     @endfor
			  
			 </select> 

  			@if($errors->has('parent_id'))
  				<span style="color: red;"> {{ $errors->first('parent_id') }} </span>
  			@endif
		</div>



		<div class="form-group">
			<label for="article-ckeditor">توضیح</label>
  			<input type="text" name="article-ckeditor" id="article-ckeditor" class="form-control" value="" placeholder=""><br>

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

	<script src="/vendor/unisharp/laravel-ckeditor/ckeditor.js"></script>
    <script>
        CKEDITOR.replace( 'article-ckeditor' );
    </script>
@endsection