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
		<table class="table table-hover" style="width: 60%; margin: 20px 20px 20px 0px;">
			<tr>
				<th style="width: 20%;">ردیف</th>
				<th>نام استان</th>
				<th>عملیات</th>
				<th>شهرها</th>
				<th>عنملیات</th>
			</tr>

			@foreach($states as $key=>$value)			
				<tr>
					<td>{{ $count }}</td>
					<td>{{$value->name}}</td>
					<td>
						<a href="state/{{ $value->id }}/edit" class="fa fa-edit"> </a>

						<form action="{{ action('admin\StateController@destroy', ['id' => $value->id]) }}" method="POST"  accept-charset="utf-8" class="pull-right"  onsubmit="return confirm('آیا قصد حذف این دسته را دارید؟')"> <!--stack: 39790082-->
		                        {{ csrf_field() }} 

	                        <input type="hidden" name="_method" value="DELETE">
	                        <input type="submit" name="submit" value="X" class="submitStyle">
	                    </form>
					</td>
					<td></td>
					<td></td>

					@if( sizeof($value->city) > 0)
	 					@foreach($value->city as $key_city=>$item_city)
	 						<tr>
			 					<td></td>
			 					<td></td>
			 					<td></td>
			 					<td>
			 						<div style="padding-right:20px"> {{ $item_city->name }} </div>
			 					</td>
			 					<td>
			 						
									<a href="city/{{ $item_city->id }}/edit" class="fa fa-edit"> </a>

									<form action="{{ action('admin\CityController@destroy', ['id' => $item_city->id]) }}" method="POST"  accept-charset="utf-8" class="pull-right"  onsubmit="return confirm('آیا قصد حذف این دسته را دارید؟')"> <!--stack: 39790082-->
					                        {{ csrf_field() }} 

				                        <input type="hidden" name="_method" value="DELETE">
				                        <input type="submit" name="submit" value="X" class="submitStyle">
				                    </form>
			 					</td>
			 				</tr>
	 					@endforeach
	 				@endif

				</tr>
				<?php $count++; ?>
			@endforeach
		</table>

		{{ $states->links() }}

	@else
		nothing in here
	@endif

@endsection