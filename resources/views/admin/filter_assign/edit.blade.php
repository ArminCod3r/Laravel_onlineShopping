@extends('admin/layouts/adminLayout')


@section('header')
    <title> ویرایش فیلتر </title>
    <link rel="stylesheet" type="text/css" href="{{ url('css/bootstrap-select.css') }}">

@endsection

@section('custom-title')
  ویرایش فیلتر

@endsection

@section('content1')

<section class="col-lg-7 connectedSortable">

<div class="productTitle" style="margin: 0px 10px 20px 0px">
	<p>{{ $product[0]->title }}</p>
	<p style="font-size: 16px;color: #a7a7a7">{{ $product[0]->code }}</p>
</div>

@if(sizeof($filters) and sizeof($product) and sizeof($assigned))

<form action="{{ route('filter_assign.update', $category_id.'/'.$product[0]->id) }}" method="POST">
	
	{{ csrf_field() }}

	<!-- 
		These inputs are necessary ,because in update() we will be redirected
		to the store(), so existance of these two-inputs are a must.
	-->
	<input type="hidden" name="product_id" id="product_id" value="{{ $product[0]->id }}">	
	<input type="hidden" name="category_id" id="category_id" value="{{ $category_id }}">


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
								<input type="radio" name="filter[{{$value->id}}]" id="{{$value_child->id}}" value="{{$value_child->id.'-'.$value_child->name}}"> {{$value_child->name}} <br>
							@else
								<?php
									$color_name = explode(':', $value_child->name)[0];
									$color_code = explode(':', $value_child->name)[1];
								?>
								
								
								<div class="row">

									<div class="col-sm-1">
										<input type="checkbox" name="filter[]" id="{{$value_child->id}}" value="{{$value_child->id.'-'.$value_child->name}}">
									</div>

									<div class="col-sm-1">
										{{$color_name}}
									</div>
									<div class="col-sm-1">
										<div class="filters_colors" style="background-color: #{{ $color_code }};"></div>
									</div>

									<div class="col-sm-9">
									</div>

								</div>

								<br>
							@endif


						</td>
					</tr>
				@endif
			@endforeach

		@endforeach

		<tr>
			<td colspan="2">
				<input type="hidden" name="_method" value="PATCH">
				<input type="submit" name="submit" value="ویرایش" class="btn btn-primary" style="width: 100%;">
			</td>
		</tr>

	</table>
</form>

@endif

@endsection

@section('content4')
    <section class="col-lg-5 connectedSortable">
    	@if(sizeof($filters) and sizeof($image))
    		<img src="{{ url('upload/'.$image->url) }}">
    	@endif
@endsection




@section('footer')

<script type="text/javascript" src="{{ url('js/jscolor.js') }}"></script>

<script type="text/javascript">
	select_radio_when_tr_clicked = function(tr)
	{
		if(!document.getElementById(tr).checked)
			document.getElementById(tr).checked= true;
		else
			document.getElementById(tr).checked = false;
	}

	<?php foreach ($assigned as $key => $value): ?>
		document.getElementById(<?php echo $value->value_id;?>).checked = true;
	<?php endforeach ?>
</script>

@endsection