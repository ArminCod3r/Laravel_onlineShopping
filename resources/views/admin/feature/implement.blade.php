@extends('admin/layouts/adminLayout')


@section('header')
    <title>پیاده سازی مشخصات برای محصول</title>
@endsection

@section('custom-title')

  پیاده سازی مشخصات برای محصول
  
  <br/><br/>

  <table>
  	<tr>
  		<td> <span class="productTitle"> محصول </span></td>
  		<td> <span class="productTitle"> : {{ $product->title }} </span></td>
  	</tr>
  	<tr>
  		<td> <span class="productTitle"> دسته بندی </span></td>
  		<td> <span class="productTitle"> : {{ $category->cat_name }} </span></td>
  	</tr>
  </table>
  
@endsection


@section('content1')

 <section class="col-lg-7 connectedSortable">

 <form action="{{ action('admin\FeatureController@feature_assign', ['product_id' => $product->id]) }}" method="POST" accept-charset="utf-8" enctype="multipart/form-data">

		{{ csrf_field() }}

	<table class="table table-hover" style="margin-top: 20px">


		@foreach($features as $key=>$value)
			
			@if($value->parent_id == 0)
				<tr>
					<th colspan="2">
						<span style="color:red"> {{ $value->name }} </span>
					</th>
				</tr>
			@else
				<tr>
					<td> {{ $value->name }} </td>
					<td>
						@if($value->filled == 1)

							<!-- Editing -->
							@if( array_key_exists($value->id, $assigned_features_key))

								<input type="text" name="feature[{{$value->id}}]" class="form-control" value="{{ $assigned_features_key[$value->id] }}">

							<!-- Creating / Filling -->
							@else

								<input type="text" name="feature[{{$value->id}}]" class="form-control" value="">

							@endif


						@endif
					</td>
				</tr>
			@endif
			
		@endforeach
	</table>


	<input type="submit" name="submit" value="ثبت" class="btn btn-success">

</form>
@endsection

@section('content4')
	<section class="col-lg-5 connectedSortable">
@endsection

