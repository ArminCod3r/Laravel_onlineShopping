

<div style="margin-top: 20px"></div>

<?php $score_names = ['ارزش خرید نسبت به قیمت', 'کیفیت ساخت', 'امکانات و قابلیت ها', 'سهولت استفاده ', 'کارایی و ظاهر', 'نوآوری']?>

@if( sizeof($comments)>0 and sizeof($scores)>0  )

	@foreach($scores as $key=>$value)

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