@extends('admin/layouts/adminLayout')

@section('header')
	<title>لیست کاربران</title>

@endsection

@section('custom-title')
  لیست کاربران
@endsection

@section('content1')
	<section class="col-lg-11 connectedSortable">


<div class="users_details">
	<table class="table table-striped" dir="rtl">
	    <thead>
	      <tr>
	        <th>ردیف</th>
	        <th>نام کاربری</th>
	        <th>تاریخ عضویت</th>
	        <th>نقش کاربری</th>
	        <th>عملیات</th>
	      </tr>
	    </thead>

	    <?php $i=1; ?>
	    @foreach($users as $key=>$value)
	    	<tr>
	    		<td> {{ $i }} </td>
	    		<td> {{ $value->username }} </td>
	    		<td> {{ explode(' ' ,$value->created_at)[0] }} </td>
	    		<td> {{ $value->role }} </td>
	    		<td>
	    			<a href="#" class="fa fa-eye" style="color: green"></a>
	    			<a href="#" class="fa fa-edit"></a>
	    			<a href="#" class="fa fa-remove" style="color: red"></a>
	    		</td>
	    	</tr>

	    	<?php $i++; ?>

	    @endforeach

	</table>

	{{ $users->links() }}
</div>

@endsection


@section('content4')
    <section class="col-lg-1 connectedSortable">
@endsection


