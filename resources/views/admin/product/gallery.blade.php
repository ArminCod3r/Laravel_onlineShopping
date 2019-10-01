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
	<form method="post" id="upload-file" action="{{url('admin/product/upload')}}" class="dropzone" enctype="multipart/form-data">

		{{ csrf_field() }}

		<input name="file" type="file" multiple style="display: none;">
		
	</form>
@endsection

@section('footer')
	<!--Dropzone.js -->
	<script type="text/javascript" src="{{ url('js/dropzone.js') }}"></script>
@endsection