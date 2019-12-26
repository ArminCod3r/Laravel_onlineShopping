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

<form method="post" action="{{url('admin/review/upload'.'/'.$product->id)}}"
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

            <?php $img_link = url('upload'.'/'.$item->url); ?>
            <img src="{{ $img_link }}" class="review_images"
                                       onclick="get_link('{{ $img_link }}')"
                                       ondblclick="biggerImg('{{ $item->id }}','{{ $img_link }}')">

        @endforeach

    @endif

@endsection


@section('content2')
    <br><br><br><br><br><br>

<!-- Modal -->
<div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">

        <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">


            <img id="bigger_img" class="bigger_img" src="">


      </div>
      <div class="modal-footer" style="position: absolute;padding-top: 110%;">

        <button type="button" class="btn btn-default closeModalimg" data-dismiss="modal">بستن</button>

        <form action="#" method="POST"  accept-charset="utf-8" class="deleteImage" id="deleteImage" onsubmit="return confirm('آیا قصد حذف این دسته را دارید؟')"> <!--stack: 39790082-->
                {{ csrf_field() }}      
                <input type="hidden" name="_method" value="DELETE">
                <input type="submit" name="submit" value="حذف" class="btn btn-default imgDelBtn">
            </form> 

      </div>
    </div>
  </div>
</div>

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

    biggerImg = function(img_id, img_link)
    {
        $("#exampleModalLongTitle").html(img_link);

        var img = document.getElementById("bigger_img").src=img_link;

        var img_name = (img_link.split("/"))[4];
        var img_del_link = "http://localhost:8000/admin/review/deleteImage/"+img_id;
        document.getElementById("deleteImage").action=img_del_link;

        //$(".modal-body").html(img_link);

        $('#exampleModalLong').modal('show'); 
    }

    $(".modal-body").mouseover(function() {
        $(this).children(".deleteImage").show();
    });


    </script>

@endsection