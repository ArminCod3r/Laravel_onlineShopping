@extends('admin/layouts/adminLayout')


@section('header')
	<title>ویرایش محصولات شگفت انگیز</title>

	<style type="text/css">
       .header_long_title
       {
	       	margin-top: 5%;
	       	color:#1b701f
       }

       </style>

@endsection

@section('custom-title')
  ویرایش محصولات شگفت انگیز
  <h5 class="header_long_title">{{$amazing->long_title}}</h5>
@endsection


@section('content1')

<hr style="margin-bottom: 5%" />

<form action="{{route('amazing_products.update', $amazing->id ) }}" method="POST" accept-charset="utf-8" enctype="multipart/form-data">

	{{ csrf_field() }}

		
	<!-- Short title -->
	<div class="form-group">
		<label for="short_title">عنوانک</label>
  		<input type="text" name="short_title" id="short_title" class="form-control" value="{{$amazing->short_title}}">

  		@if($errors->has('short_title'))
  			<span style="color: red;"> {{ $errors->first('short_title') }} </span>
  		@endif
	</div>

	<!-- Long title -->
	<div class="form-group">
		<label for="long_title">عنوان</label>
  		<input type="text" name="long_title" id="long_title" class="form-control" value="{{$amazing->long_title}}">
  		
  		@if($errors->has('long_title'))
  			<span style="color: red;"> {{ $errors->first('long_title') }} </span>
  		@endif
	</div>

	<!-- Description -->
	<div class="form-group">

  		<label >توضیح</label>
  		<textarea name="description" id="description" class="form-control">{{$amazing->description}}</textarea>
  			  <!--name="article-ckeditor" id="article-ckeditor"-->

  		@if($errors->has('description'))
  			<span style="color: red;"> {{ $errors->first('description') }} </span>
  		@endif
	</div>

	<hr style="margin-top: 10%" />

	<!-- Main price -->
	<div class="form-group">
		<label for="price">هزینه اصلی محصول</label>
  		<input type="text" name="price" id="price" class="form-control" value="{{$amazing->price}}">

  		@if($errors->has('price'))
  			<span style="color: red;"> {{ $errors->first('price') }} </span>
  		@endif
	</div>

	<!-- Discounted price -->
	<div class="form-group">
		<label for="price_discounted">تخفیف %</label>
  		<input type="text" name="price_discounted" id="price_discounted" class="form-control" value="{{$amazing->price_discounted}}">

  		@if($errors->has('price_discounted'))
  			<span style="color: red;"> {{ $errors->first('price_discounted') }} </span>
  		@endif
	</div>

	<hr style="margin-top: 10%" />

	<!-- Products id -->
	<div class="form-group">
		<label for="product_id">شناسه محصول</label>
  		<input type="text" name="product_id" id="product_id" class="form-control" value="{{$amazing->product_id}}">

  		@if($errors->has('product_id'))
  			<span style="color: red;"> {{ $errors->first('product_id') }} </span>
  		@endif
	</div>

	<!-- Time -->
	<div class="form-group">
		<label for="time_amazing">مدت زمان شگفت انگیز بودن</label>
  		<input type="text" name="time_amazing" id="time_amazing" class="form-control" value="{{$amazing->time_amazing}}" placeholder="بر حسب ساعت">

  		@if($errors->has('time_amazing'))
  			<span style="color: red;"> {{ $errors->first('time_amazing') }} </span>
  		@endif
	</div>

	<hr style="margin-top: 10%" />


	<input type="hidden" name="_method" value="PATCH">

	<input type="submit" name="submit" value="ویرایش" class="btn btn-primary">

</form>
@endsection


@section('content2')
	<br><br><br><br><br><br>
@endsection


@section('footer')
	<script type="text/javascript" src="{{ url('js/defaults-fa_IR.js') }}"></script>
	<script src="/vendor/unisharp/laravel-ckeditor/ckeditor.js"></script>

    <script>
        CKEDITOR.replace( 'article-ckeditor' );
    </script>

@endsection