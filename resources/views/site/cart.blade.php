@extends('site/layouts/siteLayout')

@section('header')
@endsection

@section('content')

@if( count($cart) > 0 )

	<div class="container">
		<table class="table table-hover">
			<tr>
				<th>محصول</th>
				<th>رنگ</th>
				<th>تعداد</th>
				<th>قیمت</th>
			</tr>

			@foreach($cart as $p_c=>$count)
				<tr>
					<td> {{ $cart_details[$p_c][0]->title }} </td>
					<td>						
						<input type="text" id="color"
						class="jscolor {valueElement:null,value:'{{ $cart_details[$p_c][0]->color_code }}'} colorStyle form-control"
						value="" disabled>
					</td>
					<td> {{ $count }} </td>
					<td> {{ $cart_details[$p_c][0]->price }} </td>
				</tr>
			@endforeach
		</table>
	</div>

@else
	<p style="color:red ; text-align:center ; padding-top:30px; padding-bottom:30px;">
		 سبد محصول خالی می باشد
	 </p>
@endif

@endsection


@section('footer')

    <script type="text/javascript" src="{{ url('js/jscolor.js') }}"></script>


@endsection