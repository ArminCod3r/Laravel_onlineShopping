@extends('admin/layouts/adminLayout')


@section('header')	
	<title>گالری</title>

  <!--Dropzone.css -->
	<link href="{{ url('css/dropzone.css') }}" rel="stylesheet">

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
	</script>
@endsection