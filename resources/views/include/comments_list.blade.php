

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

			<div class="col-sm-6"></div>

		</div>

	@endforeach

@endif