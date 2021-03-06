@extends('admin/layouts/adminLayout')

@section('header')
	<title> افزودن کاربر </title>
    <link rel="stylesheet" type="text/css" href="{{ url('css/bootstrap-select.css') }}">


	<style type="text/css">

    	.bootstrap-select > .dropdown-toggle
    	{
    		background-color: #e7e7e7;
    		width: 100%;
    		text-align-last: right;
    	}

	</style>

@endsection

@section('custom-title')
   افزودن کاربر 
@endsection

@section('content1')
<section class="col-lg-11 connectedSortable">

<div class="users_account">
	<div style="padding-top: 20px;"></div>

	<form action="{{ action('admin\UserController@store') }}" method="POST">
		{{ csrf_field() }}

		<table class="table borderless" dir="rtl" style="width: 95%;margin: auto;">
		    <tr>
	    		<td style="width: 20%"> نام کاربری </td>
	    		<td>
	    			<input type="text" class="form-control" style="width:50%" name="username" id="username">

	    			@if($errors->has('username'))
		  				<span style="color: red;"> {{ $errors->first('username') }} </span>
		  			@endif
	    		</td>
	    	</tr>

		    <tr>
	    		<td> کلمه عبور </td>
	    		<td>
	    			<input type="text" class="form-control" style="width:50%" name="password" id="password">

	    			@if($errors->has('password'))
		  				<span style="color: red;"> {{ $errors->first('password') }} </span>
		  			@endif
	    		</td>
	    	</tr>

		    <tr>
	    		<td> نقش کاربری </td>
	    		<td>
	    			<select name="role" class="selectpicker">
	    				<option disabled selected value style="background-color: white !important"> چیزی انتخاب نشده است </option>
	    				<option value="user">کاربر عادی</option>	
	    				<option value="admin">مدیر</option>				  
					 </select> 

	    			@if($errors->has('role'))
		  				<span style="color: red;"> {{ $errors->first('role') }} </span>
		  			@endif
	    		</td>
	    	</tr>

		    <tr>
	    		<td>
	    			<input type="submit" name="submit" value="ثبت" class="btn btn-success" style="width: 100%;">
	    		</td>
	    	</tr>

		</table>

	</form>
</div>



@endsection


@section('content4')
    <section class="col-lg-1 connectedSortable">
@endsection


@section('footer')
    <script type="text/javascript" src="{{ url('js/bootstrap-select.js') }}"></script>
    <script type="text/javascript" src="{{ url('js/defaults-fa_IR.js') }}"></script>
@endsection