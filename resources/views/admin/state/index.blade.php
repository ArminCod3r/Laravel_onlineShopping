@extends('admin/layouts/adminLayout')

@section('header')
	<link rel="stylesheet" type="text/css" href="{{ url('css/bootstrap-select.css') }}">
	<title>لیست استان ها</title>

	<style type="text/css">

    	.bootstrap-select > .dropdown-toggle
    	{
    		background-color: white;
    		width: 230px;
    		text-align-last: right;
    	}

    	.filter-option-inner-inner
    	{
    		color: black;
    	}

	</style>

@endsection

@section('custom-title')
  لیست استان ها
@endsection

@section('content1')

	@if(!empty($states))
		<?php $count=1; ?>
		<table class="table table-hover" style="width: 60%; margin: 20px 20px 20px 0px;">
			<tr>
				<th style="width: 20%;">ردیف</th>
				<th style="width: 50%;">نام استان</th>
				<th>عملیات</th>
			</tr>

			@foreach($states as $key=>$value)			
				<tr>
					<td>{{ $count }}</td>
					<td>

					      <div class="form-group">
							 <select name="state" class="selectpicker" data-live-search="true">
							 <!--stack: 24627902-->

							 	<option disabled selected value style="background-color: white !important"> {{$value->name}} </option>

							 	@if(sizeof($value->city) > 0)
									@foreach($value->city as $key_city=>$value_city)
										<option value="{{$value_city->id}}">{{$value_city->name}}</option>
									@endforeach
								@else
									nothing in here
								@endif
							  
							 </select> 
						</div>

					</td>
					<td>
						<a href="state/{{ $value->id }}/edit" class="fa fa-edit" style="margin-top: 10px"> </a>

						<form action="{{ action('admin\StateController@destroy', ['id' => $value->id]) }}" method="POST"  accept-charset="utf-8" class="pull-right"  onsubmit="return confirm('آیا قصد حذف این دسته را دارید؟')"> <!--stack: 39790082-->
		                        {{ csrf_field() }} 

	                        <input type="hidden" name="_method" value="DELETE">
	                        <input type="submit" name="submit" value="X" class="submitStyle" style="margin-top: 10px">
	                    </form>
					</td>


				</tr>
				<?php $count++; ?>
			@endforeach
		</table>

		{{ $states->links() }}

	@else
		nothing in here
	@endif

@endsection



@section('footer')
	<script type="text/javascript" src="{{ url('js/bootstrap-select.js') }}"></script>
	<script type="text/javascript" src="{{ url('js/defaults-fa_IR.js') }}"></script>
@endsection	