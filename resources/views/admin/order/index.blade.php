@extends('admin/layouts/adminLayout')


@section('header')
    <title>مدیریت سفارش ها</title>
@endsection

@section('custom-title')
  مدیریت سفارش ها
@endsection


@section('content1')
<section class="col-lg-12 connectedSortable">


<table class="table table-hover" dir="rtl" style="width:98%;">
    <thead>
      <tr>
        <th>ردیف</th>
        <th>شماره سفارش</th>
        <th>موبایل</th>
        <th>زمان خرید</th>
        <th>مبلغ سفارش</th>
        <th>وضعیت پرداخت </th>
        <th>عملیات</th>
      </tr>
    </thead>

    <?php $i=1; ?>
    @foreach($orders as $key=>$value)
    	<?php
    		$users_details = json_decode($value->address_text, true);
    	?>
    	<tr>
    		<td> {{ $i }} </td>
    		<td>{{substr($value->time,0,5).$value->user_id.substr($value->time,5,10)}}</td>
    		<td> {{ $users_details['mobile'] }} </td>
    		<td>
    			<?php
		    		$date = explode(' ', $value->created_at)[0];
		    		$time = explode(' ', $value->created_at)[1];
		    	?>
    			<span>{{ $time }}</span>
    			<span>{{ $date }}</span>
    		</td>
    		<td> {{ $value->price }} نومان </td>
    		<td>
    			@if($value->pay_status == 1)
    				<span style="color: green">پرداخت شده</span>
    			@else
    				<span style="color: red">در انتظار پرداخت</span>
    			@endif
    		</td>
    		<td>
    			<a href="#" class="fa fa-eye" style="cursor:pointer"></a>
    		</td>
    	</tr>

    	<?php $i++; ?>

    @endforeach



</table>
    


</form>
@endsection
