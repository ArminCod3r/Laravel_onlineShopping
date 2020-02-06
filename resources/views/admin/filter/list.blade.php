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
 	@foreach($filter as $key=>$item)
 		<tr>
 			<td> {{ $i }} </td>
 			<td> 
 				{{ $item->cat_name }} 
 			</td>
 			<td>
 				@if( sizeof($item->filter) > 0)
 					@foreach($item->filter as $key_filter=>$item_filter)
 						
		 					
		 					
		 						@if( $item_filter->parent_id == 0 )
		 							<tr>
				 						<td></td>
				 						<td></td>
			 							<td>
				 							<strong style="color: red">
				 								{{ $item_filter->name }}
				 							</strong>
			 							</td>
		 							</tr>
		 							@foreach($item->filter as $key_child=>$value_child)
		 								@if($value_child->parent_id == $item_filter->id )
		 									<tr>
						 						<td></td>
						 						<td></td>
			 									<td>
			 										<div style="padding-right:20px"> {{ $value_child->name }} </div>
			 									</td>
		 									</tr>
		 								@endif
		 							@endforeach

		 						@endif
		 					
		 				
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

