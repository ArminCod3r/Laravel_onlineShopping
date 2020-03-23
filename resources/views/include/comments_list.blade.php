

<?php
$score_names = ['ارزش خرید نسبت به قیمت', 'کیفیت ساخت', 'امکانات و قابلیت ها', 'سهولت استفاده ', 'کارایی و ظاهر', 'نوآوری'];

$half_score = true;
$round_number_loop = true;
?>


<div class="sumup average_score">
	<table>
		@foreach($average as $key=>$value)
			<tr>
				<td>{{$score_names[$key-1]}}</td>
				<td>

					@for($i=1 ; $i<=5 ; $i++)

						@if($i <= $value)
							@if($i != 5 )
								<span class="bar done"></span>
							@else
								@if( $i == 5)
									<span class="bar done" style="position: relative;">
										<span class="average_in_bar_round">{{$value}}</span>
									</span>
									<?php $round_number_loop = false;?>
								@endif
							@endif
						@else
							@if( is_float($value) and $half_score )
								<?php

									$float_to_string = strval($value);
									$fraction = explode(".", $float_to_string)[1];
									$half_score = false;
								?>
								@if($fraction < 5)
									<span class="done_1-4"></span>
									<span class="bar_3-4"></span>
								@endif

								@if($fraction == 5)
									<span class="done_half"></span>
									<span class="bar_half"><span class="average_in_bar">{{$value}}</span></span>
								@endif

								@if($fraction > 5)
									<span class="done_3-4"></span>
									<span class="bar_1-4"></span>
								@endif


							@else
								@if( is_int($value) and $round_number_loop)
									<span class="bar" style="position: relative;"><span class="average_in_bar">{{$value}}</span></span>
									<?php $round_number_loop = false;?>
								@else
									<span class="bar"></span>
								@endif
								
							@endif
							
						@endif

					@endfor
					<?php $half_score = true;?>
					<?php $round_number_loop = true;?>
					
				</td>
			</tr>
		@endforeach
	</table>

	<div class="row" style="margin: auto">
		<div class="col-sm-7"></div>

		<div class="col-sm-5">

			<h5>شما هم می توانید در مورد این کالا نظر بدهید</h5>

			<div class="you_can_comment">

				<p>
					برای ثبت نظرات و نقد و بررسی  شما لازم است ابتدا وارد حساب کاربری خود شده. اگر این محصول را قبلا" از دیجکالا خریداری خرید کرده باشید نظر شما به عنوان مالک ثبت خواهد شد.
				</p>

				<a href="{{ url('comment').'/'.$product_id }}" style="float: left">
					<button class="btn btn-primary">ثبت نظر</button>
				</a>

			</div>

		</div>

	</div>
</div>

<div style="margin-top: 20px"></div>



@if( sizeof($comments)>0 )


	@foreach($comments as $key=>$comment)

		<div class="comment_username">
			@if($comment->User->name)
				<p>{{$comment->User->name}}</p>
			@else
				<p> کاربر سایت </p>
			@endif
		</div>
		
		<div class="row sumup">

			<!-- Scores -->
			<div class="col-sm-6">
				<table>
					@foreach($comment->ProductScore as $key_score=>$score)

						@if($comment->user_id == $score->user_id)				
						
							<tr>
								<td> {{ $score_names[$score->score_id - 1] }} </td>
								<td>
									@for($i=1 ; $i<=5 ; $i++)

										@if($i <= $score->score_value)
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
			</div>

			<div class="col-sm-6" style="border-right: 1px solid #eeeded">

				<!-- Comment's subject -->
				<div>{{ $comment->subject }}</div>


				<!-- Pros -->
				<div style="color:green ; margin-top: 20px">
					<span class="fa fa-arrow-up"></span>
					نقاط قوت
				</div>

				@if(sizeof($comments)>0)
					<?php
						$pros_arr = explode("-::-", $comment->pros);								
						$pros_arr = array_filter($pros_arr);  // Remove an empty element
					?>

					@foreach($pros_arr as $key_3=>$item)
						<div style="margin-right: 15px"> {{$item}} </div>	  					
	  				@endforeach
				@endif


				<!-- Cons -->
				<div style="color:red ; margin-top: 20px">
					<span class="fa fa-arrow-down"></span>
					نقاط ضعف
				</div>				

				@if(sizeof($comment)>0)
					<?php
						$cons_arr = explode("-::-", $comment->cons);								
						$cons_arr = array_filter($cons_arr);  // Remove an empty element
					?>

					@foreach($cons_arr as $key_3=>$item)
						<div style="margin-right: 15px"> {{$item}} </div>	  					
	  				@endforeach
				@endif

				<!-- Comment's text -->
				<div class="comment_text">
					{{ $comment->comment_text }}
				</div>

			</div>

		</div>

	@endforeach

@endif