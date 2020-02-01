@extends('admin/layouts/adminLayout')


@section('header')
    <title>مدیریت سفارش ها</title>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
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

    <!-- From date -->
    <div class="row" style="margin-top:-30px">
        <div class="col-sm-2 form-group">
            <label for="from_date">از تاریخ</label>
        </div>

        <div class="col-sm-3 form-group">

            <!-- 51968355 -->
            <input type="date" name="from_date" id="from_date" class="form-control" value="{{ app('request')->input('from_date') }}"></input>
            <!-- Either pf these:
                <input type="date" ></input>
                <input type="text" name="date" id="datepicker"></input>
            -->
        </div>

        <div class="col-sm-7"></div>        
    </div>

    <!-- To date -->
    <div class="row" style="margin-top:-10px">
        <div class="col-sm-2 form-group">
            <label for="from_date">تا تاریخ</label>
        </div>

        <div class="col-sm-3 form-group">

            <!-- 51968355 -->
            <input type="date" name="to_date" id="to_date"class="form-control" value="{{ app('request')->input('to_date') }}"></input>
            <!-- Either pf these:
                <input type="date" ></input>
                <input type="text" name="date" id="datepicker"></input>
            -->
        </div>

        <div class="col-sm-7"></div>        
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


@section('footer')

  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>

  <!-- 51968355 -->
  <script>
  $(function() {
    $( "#datepicker" ).datepicker();
  });

  </script>


@endsection

