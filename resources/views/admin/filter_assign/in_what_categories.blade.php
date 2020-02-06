@extends('admin/layouts/adminLayout')


@section('header')
    <title>افزودن فیلتر برای محصول</title>
@endsection

@section('custom-title')
  افزودن <span style="color: red">فیلتر</span> برای محصول
  <br />

  <div class="productTitle">
    {{ $product->title }}
  </div>
@endsection


@section('content1')

<section class="col-lg-10 connectedSortable">

<div style="margin-top: 40px">
	
	<div>
		محصول "<span style="color: #666">{{ $product->title }}</span>" در دسته بندی های زیر می باشد:
	</div>

	<table class="table table-hover" style="margin-top: 20px">
	 	<tr>
	 		<th>ردیف</th>
	 		<th>مشخصه</th>
	 		<th>دسته بنده</th>
	 		<th>اعمال</th>
	 	</tr>

		<?php $i=1; ?>

		@foreach($parent as $key=>$value)

			<tr>
				<td style="width: 20%;"> {{ $i }} </td>
				<td style="width: 20%;"> {{ $value->id }} </td>
				<td> {{ $value->cat_name }} </td>
				<td>
					<a href="/admin/filter_assign/show/{{ $value->id }}/{{ $product->id }}/" class="fa fa-edit">
					</a>
				</td>
			</tr>
			<?php $i++; ?>

		@endforeach

	</table>

</div>

@endsection

@section('content4')
	<section class="col-lg-2 connectedSortable">
@endsection



@section('footer')

<script>
	goToAddingFeature = function(productID, categoryID)
	{
		var redirectTo = window.location.origin+"/admin/feature/"+productID+"/"+categoryID;

		document.location = redirectTo;
	}
</script>

@endsection