@extends('admin/layouts/adminLayout')


@section('header')
    <title> اعمال فیلتر </title>
@endsection

@section('custom-title')
  اعمال فیلتر
@endsection

@section('content1')

<section class="col-lg-7 connectedSortable">

@if(sizeof($filters) and sizeof($image))

<form action="{{ action('admin\FilterAssignController@store') }}" method="POST">	

	{{ csrf_field() }}

	<table class="table table-hover filters_implementation">
		
		@foreach($filters as $key=>$value)
			@if($value->parent_id == 0)
				<tr class="header">
					<th colspan="2">
						<p>
							{{$value->name}}
						</p>
					</th>
				</tr>
			@endif

			

			@foreach($filters as $key_child=>$value_child)
				@if($value_child->parent_id == $value->id)
					<tr onclick='select_radio_when_tr_clicked("{{$value_child->id}}")'>
						<td></td>
						<td>
							@if($value->name != "رنگ")
								<input type="radio" name="{{$value->id}}" id="{{$value_child->id}}" value="{{$value_child->name}}"> {{$value_child->name}} <br>
							@else
								<input type="checkbox" name="{{$value->id}}" id="{{$value_child->id}}" value="{{$value_child->name}}"> {{$value_child->name}} <br>
							@endif


						</td>
					</tr>
				@endif
			@endforeach

		@endforeach

		<tr>
			<td colspan="2">
				<input type="submit" name="submit" value="ثبت" class="btn btn-success" style="width: 100%;">
			</td>
		</tr>

	</table>
</form>

@else

	<div>
		<p>
			<span>فیلتری برای </span>
			<span style="color: red">دسته بندی ای</span>
			<span> که محصول در آن قرار دارد ثبت نشده است.</span>
		</p>
		<p>
			<span>یا</span>
		</p>
		<p>
			<span>محصولی یافت نشد.</span>
		</p>
	</div>

	<button class="btn btn-success">
		<a href="{{ url('admin/filter') }}" style="color: white"> افزودن فیلتر </a>
	</button>

@endif

@endsection

@section('content4')
    <section class="col-lg-5 connectedSortable">
    	@if(sizeof($filters) and sizeof($image))
    		<img src="{{ url('upload/'.$image->url) }}">
    	@endif
@endsection




@section('footer')

<script type="text/javascript">
	select_radio_when_tr_clicked = function(tr)
	{
		document.getElementById(tr).checked = true;
	}
</script>

@endsection