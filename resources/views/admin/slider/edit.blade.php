@extends('admin/layouts/adminLayout')


@section('header')
	<title>ویارایش اسلاید</title>
@endsection

@section('custom-title')
  ویرایش : {{ $slider->title }}
@endsection


@section('content1')
 <form action="{{route('slider.update', $slider->id ) }}" method="POST" accept-charset="utf-8" enctype="multipart/form-data"> <!--stack: 40803339-->
		{{ csrf_field() }}
		

		<div class="form-group">
			<label for="title">عنوان اسلایدر</label>
  			<input type="text" name="title" id="title" class="form-control" value="{{$slider->title}}" placeholder=""><br>

  			@if($errors->has('title'))
  				<span style="color: red;"> {{ $errors->first('title') }} </span>
  			@endif
		</div>

		<div class="form-group">
			<label for="title">آدرس اسلایدر</label>
  			<input type="text" name="url" id="url" class="form-control" value="{{$slider->url}}" placeholder=""><br>

  			@if($errors->has('url'))
  				<span style="color: red;"> {{ $errors->first('url') }} </span>
  			@endif
		</div>
	
		<div class="form-group">
			<input type="file" name="img" id="img" style="display: none;" onchange="load_file(event)">
			@if(!empty($slider->img))
				<img src="{{ url('upload/'.$slider->img) }}" id='res_img' width="150" onclick="select_file()">
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