@extends('admin/layouts/adminLayout')

@section('header')
	<title>لیست استان ها</title>
@endsection

@section('custom-title')
  لیست استان ها
@endsection

@section('content1')

	@if(!empty($states))
		<?php $count=1; ?>
		<table class="table" style="width: 60%; margin: 20px 20px 20px 0px;">
			<tr>
				<th style="width: 20%;">ردیف</th>
				<th>نام استان</th>
			</tr>

			@foreach($states as $key=>$value)			
				<tr>
					<td>{{ $count }}</td>
					<td>{{$value->name}}</td>
				</tr>
				<?php $count++; ?>
			@endforeach
		</table>
	@else
		nothing in here
	@endif

@endsection