@extends('admin/layouts/adminLayout')

@section('header')
	<title>ویرایش استان</title>
@endsection

@section('custom-title')
  ویرایش استان
@endsection


@section('content1')

 <section class="col-lg-7 connectedSortable">

 <form action="{{ route('state.update', $state->id ) }}" method="POST" accept-charset="utf-8" enctype="multipart/form-data">
		{{ csrf_field() }}
		

		<div class="row" style="margin: 30px 0px 30px 0px;">
			<div class="col-sm-2">
				<label for="state" style="padding-top: 5px;">نام استان</label>
			</div>

			<div class="col-sm-10">
				@if(!empty($state))
					<input type="text" name="state" id="state" class="form-control" value="{{$state->name}}" placeholder="">
				@else
					<input type="text" name="state" id="state" class="form-control" value="" placeholder="">
				@endif
				<br>
			</div>

  			@if($errors->has('state'))
  				<span style="color: red;"> {{ $errors->first('state') }} </span>
  			@endif
		</div>

		<input type="hidden" name="_method" value="PATCH">

		<div class="row">
			<div class="col-sm-2">
				<input type="submit" name="submit" value="ثبت" class="btn btn-primary" style="width: 100%;">
			</div>

			<div class="col-sm-10">
			</div>
		</div>

		

	</form>
@endsection

@section('content4')
	<section class="col-lg-5 connectedSortable">
@endsection
