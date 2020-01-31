@extends('admin/layouts/adminLayout')


@section('header')
    <title>لیست فیلتر ها</title>
    <link rel="stylesheet" type="text/css" href="{{ url('css/bootstrap-select.css') }}"> 
@endsection

@section('custom-title')
  لیست فیلتر ها
@endsection

@section('content1')
<section class="col-lg-7 connectedSortable">

<br/>

 <table class="table table-hover">
 	<tr>
 		<th>ردیف</th>
 		<th>دسته بنده</th>
 		<th>فیلتر</th>
 	</tr>

 	<?php $i=1; ?>
 	@foreach($features as $key=>$item)
 		<tr>
 			<td> {{ $i }} </td>
 			<td> 
 				{{ $item->cat_name }} 
 			</td>
 			<td>
 				@if( sizeof($item->feature) > 0)
 					@foreach($item->feature as $key_filter=>$item_filter)
 						<tr>
		 					<td></td>
		 					<td></td>
		 					<td>
		 						@if( $item_filter->parent_id == 0 )
		 							<strong>{{ $item_filter->name }}</strong>
		 						@else
		 							<div style="padding-right:20px"> {{ $item_filter->name }} </div>
		 						@endif
		 					</td>
		 				</tr>
 					@endforeach
 				@endif
 				
 			</td>
 		</tr>

 		<?php $i++; ?> 
 	@endforeach
 </table>
@endsection

@section('content4')
	<section class="col-lg-5 connectedSortable">
@endsection

