@extends('admin/layouts/adminLayout')


@section('header')
    <title>افزودن فیلتر به محصول</title>
@endsection

@section('custom-title')
  افزودن فیلتر به محصول
  <br />

  <div class="productTitle">
    {{ $product->title }}
  </div>
@endsection


@section('content1')

<div style="margin-top: 40px">
	
	<div>
		محصول "{{ $product->title }}" در دسته بندی های زیر می باشد:
	</div>

	<table class="table table-hover" style="margin-top: 20px">
	 	<tr>
	 		<th>ردیف</th>
	 		<th>مشخصه</th>
	 		<th>دسته بنده</th>
	 		<th>اعمال</th>
	 	</tr>

		<?php $i=1; ?>

		@foreach($product_To_category as $key=>$value)

			<tr>
				<td style="width: 20%;"> {{ $i }} </td>
				<td style="width: 20%;"> {{ $value->id }} </td>
				<td> {{ $value->cat_name }} </td>
				<td>
					<a href="/admin/feature/{{ $product->id }}/{{ $value->id }}/add" class="fa fa-edit">
					</a>
				</td>
			</tr>
			<?php $i++; ?>

		@endforeach

	</table>

</div>

@endsection

@section('footer')

<script>
	goToAddingFeature = function(productID, categoryID)
	{
		var redirectTo = window.location.origin+"/admin/feature/"+productID+"/"+categoryID+"/add";

		document.location = redirectTo;
	}
</script>

@endsection