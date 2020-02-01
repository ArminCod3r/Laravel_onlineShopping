@extends('admin/layouts/adminLayout')


@section('header')
    <title>مدیریت سفارش ها</title>
@endsection

@section('custom-title')
  مدیریت سفارش ها
@endsection


@section('content1')
<section class="col-lg-12 connectedSortable">



<form action="{{ url('admin/order') }}" method="GET">
    <div class="row">
        <div class="col-sm-2 form-group">
            <label for="order_id">شماره سفارش</label>
        </div>

        <div class="col-sm-5 form-group">
            <input type="text" name="order_id" id="order_id" class="form-control" value="{{ app('request')->input('order_id') }}" placeholder=""><br>
        </div>

        <div class="col-sm-5"></div>

        
    </div>
    
    <div class="row">
        <div class="col-sm-2 form-group">
            <input type="submit" class="btn btn-primary" value="جست و جو" style="width:100%">
        </div>
        <div class="col-sm-10"></div>        
    </div>

</form>


<table class="table table-striped" dir="rtl" style="width:98%; margin-top: 20px">
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
    		<td> {{ $value->order_id }}</td>
    		<td> {{ $users_details['mobile'] }} </td>
    		<td>
    			<?php
		    		$date = explode(' ', $value->created_at)[0];
		    		$time = explode(' ', $value->created_at)[1];
		    	?>
    			<span>{{ $time }}</span>
    			<span>{{ $date }}</span>
    		</td>
    		<td> {{ number_format($value->price) }} تومان </td>
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


{{ $orders->links() }}

@endsection
