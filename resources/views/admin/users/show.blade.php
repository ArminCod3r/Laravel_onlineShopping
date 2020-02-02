@extends('admin/layouts/adminLayout')

@section('header')
	<title> نمایش کاربر </title>

@endsection

@section('custom-title')
  کاربر - {{ $user->username }}
@endsection

@section('content1')
<section class="col-lg-11 connectedSortable">

<div class="users_account">
	<div style="padding-top: 20px;"></div>

	<table class="table table-striped" dir="rtl" style="width: 95%;margin: auto">
	    <tr>
    		<td> یوزرنیم </td>
    		<td> {{ $user->username }} </td>
    	</tr>

	    <tr>
    		<td> نقش کاربری </td>
    		<td>
    			@if($user->role == 'admin')
    				مدیر
    			@else
    				کاربر عادی
    			@endif
    		</td>
    	</tr>

	    <tr>
    		<td> تاریخ عضویت </td>
    		<td>
    			<?php
    				$date = explode(' ', $user->created_at)[0];
    				$time = explode(' ', $user->created_at)[1];
    			?>

    			{{ $time }}
    			{{ $date }}
		    </td>
    	</tr>

	    <tr>
    		<td> تغییر رمز عبور </td>
    		<td> <input type="text" class="form-control" style="width:50%" disabled="disabled"> </td>
    	</tr>
	</table>
</div>


<div class="orders_list" style="margin-bottom: 20px">

    <div class="code">
        <span>لیست سفارش ها</span>
        <span></span>
    </div>

    <div>
    	<table class="table table-striped" dir="rtl">
		    <thead>
		      <tr>
		        <th>ردیف</th>
		        <th>کد سفارش</th>
		        <th>مبلغ کل</th>
		        <th>مبلغ با اعمال تخفیف</th>
		        <th>تاریخ سفارش</th>
		        <th>جزییات</th>
		      </tr>
		    </thead>

		    
		    @if(sizeof($orders)>0)
			    <?php
			    	$i=1;
			    	$total_pay      = 0;
			    	$total_discount = 0;
			    ?>
			    @foreach($orders as $key=>$value)
			    	<?php
			    		$total_pay      = $total_pay+$value->total_price;
			    		$total_discount = $total_discount+$value->price;
			    	?>
			    	<tr>
			    		<td> {{ $i }} </td>
			    		<td> {{ $value->order_id }} </td>
			    		<td> {{ number_format($value->total_price) }} </td>
			    		<td> {{ number_format($value->price) }} </td>
			    		<td>
			    			<?php
			    				$date = explode(' ', $value->created_at)[0];
			    				$time = explode(' ', $value->created_at)[1];
			    			?>

			    			{{ $time }}
			    			{{ $date }}
			    		</td>
			    		<td>
			    			<a href="{{ action('admin\OrderController@show', ['id' => $value->id]) }}" class="fa fa-info-circle"></a>
			    		</td>
			    	</tr>

			    	<?php $i++; ?>
			    @endforeach

			    <tr style="background-color: #91cf80;font-weight: bold;">
			    	<td colspan="2"> مجموع پرداخت و تخفیف: </td>
			    	<td> {{ number_format($total_pay) }} تومان </td>
			    	<td> {{ number_format($total_discount) }} تومان </td>
			    	<td></td>
			    	<td></td>
			    </tr>

			@else
				<tr>
					<td colspan="6">این کاربری سفارشی ثبت نکرده است.</td>
				</tr>
		    @endif

    	</table>
    </div>
</div>


@endsection


@section('content4')
    <section class="col-lg-1 connectedSortable">
@endsection


