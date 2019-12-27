@extends('admin/layouts/adminLayout')

@section('header')
    <title>لیست نقد و بررسی ها</title>
@endsection

@section('custom-title')
  لیست نقد و بررسی ها
@endsection

@section('content1')
<br/>

 <table class="table table-hover">
 	<tr>
 		<th>ردیف</th>
 		<th>کد کالا</th>
 		<th>نام کالا</th>
 		<th>عملیات</th>
 	</tr>

 	<?php $i=1; ?>
 	@foreach($reviews as $key=>$item)
 		<tr>
 			<td> {{ $i }} </td>
 			<td> {{ $item->product_id }} </td>
 			<td>
 				 @if(mb_strlen($item->product->title) > 35)
					{{ substr($item->product->title,35).'...' }} 
					
				@else
					{{ $item->product->title }}

				@endif
			</td>

			<td>
				<a href="review/{{ $item->product_id }}/edit" class="fa fa-edit"> </a>

				<form action="{{ action('admin\ReviewController@destroy', ['id' => $item->id]) }}" method="POST"  accept-charset="utf-8" class="pull-right"  onsubmit="return confirm('آیا قصد حذف این دسته را دارید؟')"> <!--stack: 39790082-->
                        {{ csrf_field() }}      
                        <input type="hidden" name="_method" value="DELETE">
                        <input type="submit" name="submit" value="X" class="submitStyle">
                    </form>
			</td>
 		</tr>

 		<?php $i++; ?> 
 	@endforeach
 </table>
@endsection