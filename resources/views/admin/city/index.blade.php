@extends('admin/layouts/adminLayout')

@section('header')
	<title>لیست شهر ها</title>
@endsection

@section('custom-title')
  لیست شهر ها
@endsection


@section('content1')

	@if(!empty($cities))
		<?php $count=1; ?>
		<table class="table table-hover" style="width: 90%; margin: 20px 20px 20px 0px;">
			<tr>
				<th style="width: 20%;text-align: center;">ردیف</th>
				<th class="city-index-table">نام شهر</th>
				<th class="city-index-table">نام استان</th>
				<th>عملیات</th>
			</tr>

			@foreach($cities as $key=>$value)			
				<tr>
					<td class="city-index-table">{{ $count }}</td>
					<td class="city-index-table">{{$value->name}}</td>					
					<td class="city-index-table"> {{ $value->state->name }} </td>
					<td>
						<a href="city/{{ $value->id }}/edit" class="fa fa-edit"> </a>

						<form action="{{ action('admin\CityController@destroy', ['id' => $value->id]) }}" method="POST"  accept-charset="utf-8" class="pull-right"  onsubmit="return confirm('آیا قصد حذف این دسته را دارید؟')"> <!--stack: 39790082-->
		                        {{ csrf_field() }} 

	                        <input type="hidden" name="_method" value="DELETE">
	                        <input type="submit" name="submit" value="X" class="submitStyle">
	                    </form>
					</td>

				</tr>
				<?php $count++; ?>
			@endforeach
		</table>

		{{ $cities->links() }}

	@else
		nothing in here
	@endif

@endsection