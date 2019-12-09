@extends('admin/layouts/adminLayout')


@section('header')
	<title>نمایش محصولات شگفت انگیز</title>

	<style type="text/css">

    .submitStyle{
      background-color: Transparent;
      background-repeat:no-repeat;
      border: none;
      cursor:pointer;
      overflow: hidden;
      outline:none;
      color: red;
      font-weight: bold;
    }
    </style>

@endsection

@section('custom-title')
  نمایش محصولات شگفت انگیز
@endsection


@section('content1')
<a href="{{ url('admin/amazing_products/create') }}" class="btn btn-success"> افزودن محصول </a>
<br><br>

    <table class="table table-hover" dir="rtl" style="white-space: nowrap;">
        <thead>
          <tr>
            <th>#</th>
            <th>شناسه</th>            
            <th>عملیات</th>
            <th>عنوانک</th>
            <th>هزینه</th>
            <th>تخفیف</th>
            <th>هزینه با اعمال تخفیف</th>
            <th>مدت زمان شگفت انگیز بودن</th>
          </tr>
        </thead>

        <?php $i=1; ?>
        @foreach($amazing as $item)
        	<tr>
        		<td> {{ $i }} </td>
        		<td> {{ $item->id }} </td>
        		<td>
                    <div style="float:right;">
                    <a href="/admin/amazing_products/{{ $item->id }}/edit" class="fa fa-edit">  </a>
                  </div>
                  
                  <div style="float:right;">
                  <form></form> <!--if it is not writtern, then first 'X' will not work-->
                  
                  <form action="/admin/amazing_products/{{ $item->id }}" method="POST" onsubmit="return confirm('آیا قصد حذف این دسته را دارید؟')"> <!--stack: 39790082-->

                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}

                        <input type="submit" value="X" class="submitStyle">
                    </form>
                  </div>
                </td>
        		<td> {{ $item->short_title }} </td>
        		<td> {{ $item->price }} </td>
        		<td> {{ number_format($item->price_discounted) }} %</td>
        		<td> <center>{{ number_format( $item->price - (($item->price * $item->price_discounted )/100) ) }} </center></td>
        		<td> <center>{{ $item->time_amazing }}</center> </td>
        	</tr>

        	<?php $i++; ?>
        @endforeach

</table>
    
{{ $amazing->links() }}
@endsection
