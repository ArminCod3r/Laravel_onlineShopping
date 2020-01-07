@extends('site/layouts/siteLayout')

@section('header')
@endsection

@section('content')

@if( count($cart) > 0 )

	<div class="container" style="background-color:white; border-radius:30px">
		<table class="table table-hover" style="font-size: 16px">
			<tr>
				<th>تصویر</th>
				<th>محصول</th>
				<th>رنگ</th>
				<th>قیمت</th>
				<th>تعداد</th>
				<th>قیمت کل</th>
			</tr>

			@foreach($cart as $p_c=>$count)
				<tr style="line-height: 80px;">
					<td style="width: 10%;">
						<img style="width: 50%;" src="{{ url('upload').'/'.$cart_details[$p_c][0]->url }}" </img>
					</td>

					<td style="width: 40%;">
						{{ $cart_details[$p_c][0]->title }}
					</td>

					<td style="padding-top: 30px;">
						<input type="text" id="color"
						class="jscolor {valueElement:null,value:'{{ $cart_details[$p_c][0]->color_code }}'} colorStyle form-control"
						value="" disabled>
					</td>
					<td> {{ $cart_details[$p_c][0]->price }} </td>
					<td> {{ $count }} </td>
					<td> {{ (int)$cart_details[$p_c][0]->price * (int)$count }} </td>
					
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