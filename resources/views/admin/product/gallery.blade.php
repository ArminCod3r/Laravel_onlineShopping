@extends('admin/layouts/adminLayout')


@section('header')	
	<title>گالری</title>

  <!--Dropzone.css -->
	<link href="{{ url('css/dropzone.css') }}" rel="stylesheet">

	<style type="text/css">
		.imageProcessingArea{
			display: none;
		    background: #ccc;
		    width: 250px;
		    height: 100px;
		    padding: 20px;
		    color: #333;
		}
		.deleteImage {
			color: red;
			display:none;
			position: absolute;
			top: 10px;
			right: 100px;
			bottom: 0;
			left: 0;
			z-index: 10040;
			overflow: auto;
			overflow-y: auto;
		}

	</style>

@endsection

@section('custom-title')
  گالری	
@endsection

@section('content1')
	<form method="post" id="upload-file" action="{{url('admin/product/upload'.'/'.$product->id)}}" class="dropzone" enctype="multipart/form-data">

		{{ csrf_field() }}

		<input name="file" type="file" multiple style="display: none;">
		
	</form>
@endsection

@section('content2')
	<br/><br/>

	<table id="imagesTable" class="table table-striped">
		<thead>
          <tr>
            <th>تصاویر</th>
          </tr>
        </thead>

    <?php 
    	$startCell = 0;
    	$endCell   = 3;
    ?>
	@if(sizeof($images))
		
			@foreach($images as $key=>$item)	
				@if( $startCell == 0 )
					<tr>
					<?php $startCell += 4;?>
	            @endif
			
	            <td>
	                <img id="{{$item->id}}" src="{{ url('upload/'.$item->url) }}" width="80%" onclick="magnify_img(this)">
	            </td>

	            @if( $endCell == $key )
					</tr>
					<?php $endCell += 4;?>
	            @endif	

			@endforeach				

	@else
		<h4> تصویری وجود ندارد.</h4>

	@endif

	</table>

@endsection

@section('content4')

	@if(sizeof($images))
		<!-- stack: 29485224 -->
		<!-- http://jsfiddle.net/9RxLM/ -->
		<div class="imageDetails">

			<img src="{{ url('upload/'.$images->first()->url) }}" style="width: 80%;" id="biggerImage">

			<form action="{{ action('admin\ProductController@deleteImage', ['img' => $images->first()->id]) }}" method="POST"  accept-charset="utf-8" class="deleteImage" id="deleteImage"
					onsubmit="return confirm('آیا قصد حذف این دسته را دارید؟')"> <!--stack: 39790082-->
                {{ csrf_field() }}      
                <input type="hidden" name="_method" value="DELETE">
                <input type="submit" name="submit" value="حذف" class="btn btn-default">
            </form>

		</div>		
	@endif
	
@endsection

@section('footer')
	<!--Dropzone.js -->
	<script type="text/javascript" src="{{ url('js/dropzone.js') }}"></script>

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


    function magnify_img(img)
    {
	    var src = img.src;
	    document.getElementById("biggerImage").src = src; 
	    // Google: html javascript src in img, https://www.w3schools.com/jsref/prop_img_src.asp

	    var imageId = img.id;
	    //var action=String("\{\{route('product.deleteImage', "+imageId+" )\}\}");
	    document.getElementById('deleteImage').action = "/admin/product/deleteImage/"+imageId;
    }

    $(".imageDetails").mouseover(function() {
	    $(this).children(".deleteImage").show();

	     // bluring: https://www.w3schools.com/howto/howto_css_image_effects.asp
	     document.getElementById("biggerImage").style.filter = "blur(5px)";
	}).mouseout(function() {
	    $(this).children(".deleteImage").hide();
	     document.getElementById("biggerImage").style.filter = "blur(0px)";
	});
	

	</script>
@endsection