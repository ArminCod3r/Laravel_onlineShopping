@extends('admin/layouts/adminLayout')

@section('header')
    <title>افزودن نقد و بررسی</title>
@endsection

@section('custom-title')
  افزودن نقد و بررسی
@endsection


@section('content1')

 <form action="{{ action('admin\ReviewController@store') }}" method="POST" accept-charset="utf-8">
	{{ csrf_field() }}
	
	<div class="form-group">
		<label for="article-ckeditor">توضیح</label>
			<div>
				<textarea name="desc" id="desc" class="form-control" value="" placeholder=""></textarea>
			</div>
			<br>
  			@if($errors->has('desc'))
  				<span style="color: red;"> {{ $errors->first('desc') }} </span>
  			@endif
	</div>



		<input type="submit" name="submit" value="ثبت" class="btn btn-success">

</form>

@endsection



@section('footer')
	<!-- CKEditor -->
	<script src="/vendor/unisharp/laravel-ckeditor/ckeditor.js"></script>


    <script>
        CKEDITOR.replace( 'desc' );
    </script>
    
@endsection