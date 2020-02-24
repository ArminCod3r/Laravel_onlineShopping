

<?php
$score_names = ['ارزش خرید نسبت به قیمت', 'کیفیت ساخت', 'امکانات و قابلیت ها', 'سهولت استفاده ', 'کارایی و ظاهر', 'نوآوری'];

$half_score = true;
?>


<div class="sumup average_score">
	<table>
		@foreach($average as $key=>$value)
			<tr>
				<td>{{$score_names[$key-1]}}</td>
				<td>{{$value}}</td>
				<td>

					@for($i=1 ; $i<=5 ; $i++)

						@if($i <= $value)
							<span class="bar done"></span>
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
									<span class="bar_half"></span>
								@endif

								@if($fraction > 5)
									<span class="done_3-4"></span>
									<span class="bar_1-4"></span>
								@endif


							@else
								<span class="bar"></span>
							@endif
							
						@endif

					@endfor
					<?php $half_score = true;?>
					
				</td>
			</tr>
		@endforeach
	</table>
</div>

<div style="margin-top: 20px"></div>

@if( sizeof($comments)>0 and sizeof($scores)>0  )

	@foreach($scores as $key=>$value)

		<div class="comment_username">
			@if($value[0]->user->name)
				<p>{{$value[0]->user->name}}</p>
			@else
				<p> کاربر سایت </p>
			@endif
		</div>

		<div class="row sumup">
			<div class="col-sm-6">
				<table>
					@foreach($value as $key_2=>$value_2)
						
						<tr>
							<td> {{ $score_names[$value_2->score_id-1] }} </td>
							<td>
								@for($i=1 ; $i<=5 ; $i++)

									@if($i <= $value_2->score_value)
										<span class="bar done"></span>
									@else
										<span class="bar"></span>
									@endif

								@endfor
							</td>
						</tr>
						
					@endforeach
				</table>
			</div>

			<div class="col-sm-6" style="border-right: 1px solid #eeeded">
				<div>{{ $comments[$key][0]->subject }}</div>

				<div style="color:green ; margin-top: 20px">
					<span class="fa fa-arrow-up"></span>
					نقاط قوت
				</div>				

				@if(sizeof($comments[$key])>0)
					<?php
						$pros_arr = explode("-::-", $comments[$key][0]->pros);								
						$pros_arr = array_filter($pros_arr);  // Remove an empty element
					?>

					@foreach($pros_arr as $key_3=>$item)
						<div style="margin-right: 15px"> {{$item}} </div>	  					
	  				@endforeach
				@endif



				<div style="color:red ; margin-top: 20px">
					<span class="fa fa-arrow-down"></span>
					نقاط ضعف
				</div>				

				@if(sizeof($comments)>0)
					<?php
						$cons_arr = explode("-::-", $comments[$key][0]->cons);								
						$cons_arr = array_filter($cons_arr);  // Remove an empty element
					?>

					@foreach($cons_arr as $key_3=>$item)
						<div style="margin-right: 15px"> {{$item}} </div>	  					
	  				@endforeach
				@endif

				<div class="comment_text">
					{{ $comments[$key][0]->comment_text }}
				</div>

			</div>

		</div>

	@endforeach

@endif