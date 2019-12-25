@extends('admin/layouts/adminLayout')

@section('header')
    <title>افزودن نقد و بررسی</title>

    <!--Dropzone.css -->
	<link href="{{ url('css/dropzone.css') }}" rel="stylesheet">

@endsection

@section('custom-title')
  افزودن نقد و بررسی
@endsection


@section('content1')

 <form action="{{route('review.store', $product->id ) }}" method="POST" accept-charset="utf-8">
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

<form method="post" action="{{url('admin/review/upload'.'/28')}}"
					class="dropzone"
					id="upload-file"
					enctype="multipart/form-data">

	{{ csrf_field() }}

	<input name="file" type="file" multiple style="display: none;">
	
</form>

@endsection

@section('content4')

    <div class="link_box">
        <span> لینک تصویر: </span>
        <div class="link_area_style"></div>
        <div id="img_link" class="img_link">  </div>
    </div>

    @if(sizeof($review_images) > 0)

        @foreach($review_images as $key=>$item)

            <?php $img_link = url('upload'.'/'.$item); ?>
            <img src="{{ $img_link }}" class="review_images" onclick="get_link('{{ $img_link }}')">

        @endforeach

    @endif

@endsection



@section('footer')
	<!-- CKEditor -->
	<script src="/vendor/unisharp/laravel-ckeditor/ckeditor.js"></script>

	<!--Dropzone.js -->
	<script type="text/javascript" src="{{ url('js/dropzone.js') }}"></script>


    <script>
        CKEDITOR.replace( 'desc' );
    </script>


    <!-- Checking file extension + Editing error messages -->
	<script>
		Dropzone.options.uploadFile={

        acceptedFiles:".png,.jpg,.gif,.jpeg",
        addRemoveLinks:true,
        init:function() {

            this.options.dictRemoveFile='حذف',
                this.options.dictInvalidFileType='امکان آپلود این فایل وجود ندارد',
                this.on('success',function(file,response) {
                    if(response==1)
                    {
                        file.previewElement.classList.add('dz-success');
                    }
                    else
                    {
                        file.previewElement.classList.add('dz-error');
                        $(file.previewElement).find('.dz-error-message').text('خطا در آپلود فایل');
                    }
                });

        }
    };


    // Getting the link of the uploaded images
    get_link = function(img_link)
    {
        $(".img_link").html(img_link);
    }
    </script>

@endsection