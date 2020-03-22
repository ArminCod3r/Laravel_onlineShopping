@extends('admin/layouts/adminLayout')

@section('header')
	<title>نظرات کاربران</title>
@endsection

@section('custom-title')
  نظرات کاربران
@endsection


@section('content1')

<section class="col-lg-12 connectedSortable">

	<?php $score_names = ['ارزش خرید نسبت به قیمت', 'کیفیت ساخت', 'امکانات و قابلیت ها', 'شهولت استفاده ', 'کارایی و ظاهر', 'نوآوری']?>

	@foreach($comments_and_scores as $key=>$item)

		<div class="row sumup">

			<div class="col-sm-6">

				<table>
					@foreach($item->ProductScore as $key_score=>$value_score)

						@if($item->user_id == $value_score->user_id)
						
						<tr>
							<td>{{ $value_score->score_value }}</td>
							<td>
								@for($i=1 ; $i<=5 ; $i++)

									@if($i <= $item->ProductScore[$key_score]->score_value)
										<span class="bar done"></span>
									@else
										<span class="bar"></span>
									@endif

								@endfor
							</td>
						</tr>
						@endif
					@endforeach					
				</table>


				<div class="row" style="margin-top: 20px">

					<div class="col-sm-2">
						<a href="comment/{{ $item->id }}/edit" class="btn btn-success" style="width: 100%"> تایید </a>
					</div>	

					<div class="col-sm-2">
						<form action="{{ action('admin\CommentController@destroy', ['id' => $item->id]) }}" method="POST"  accept-charset="utf-8" class="pull-right"  onsubmit="return confirm('آیا قصد حذف این دسته را دارید؟')" style="width: 100%"> <!--stack: 39790082-->
                        {{ csrf_field() }}      
                        <input type="hidden" name="_method" value="DELETE">
                        <input type="submit" name="submit" value="حذف" class="btn btn-danger" style="width: 100%">
                    </form>						
					</div>					
				</div>               

			</div>


			<div class="col-sm-6" style="border-right: 1px solid #eeeded">

				<div>{{ $item->subject }}</div>

				<div style="color:green ; margin-top: 20px">
					<span class="fa fa-arrow-up"></span>
					نقاط قوت
				</div>

				@if(sizeof($item->pros)>0)
					<?php
						$pros_arr = explode("-::-", $item->pros);								
						$pros_arr = array_filter($pros_arr);  // Remove an empty element
					?>

					@foreach($pros_arr as $key_pro=>$item_pro)
						<div style="margin-right: 15px"> {{$item_pro}} </div>	  					
	  				@endforeach
				@endif


				<div style="color:red ; margin-top: 20px">
					<span class="fa fa-arrow-down"></span>
					نقاط ضعف
				</div>				

				@if(sizeof($item->cons)>0)
					<?php
						$cons_arr = explode("-::-", $item->cons);								
						$cons_arr = array_filter($cons_arr);  // Remove an empty element
					?>

					@foreach($cons_arr as $key_con=>$item_con)
						<div style="margin-right: 15px"> {{$item_con}} </div>	  					
	  				@endforeach
				@endif

				<div class="comment_text">
					{{ $item->comment_text }}
				</div>

			</div>

		</div>

	@endforeach

@endsection

@section('content4')
	<section class="col-lg-5 connectedSortable">
@endsection


@section('footer')

@endsection