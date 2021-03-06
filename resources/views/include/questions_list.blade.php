

<div>

	<div class="questions">

		<form action="{{ action('QuestionController@store') }}" onsubmit="question_submit() ; return false;" method="POST" id="question_form">
			{{ csrf_field() }}

			<div class="row">

				<div class="col-sm-12">
					<div class="form-group">
						<p for="text" class="title">متن پرسش</p>
						<textarea class="form-control" name="question_text" id="question_text"></textarea>
						<input type="hidden" name="parent_id" value="0">

						<div style="margin-top: 10px">
							<span style="color: red;" id="question_text_error" class="question_text_error">
								{{ $errors->first('question_text') }}
							</span>
						</div>

						<div id="alert_success" class="questions_alert_success"></div>

					</div>

				</div>

			</div>

			<div class="row submit_question" style="width: 98%; margin: auto;">
				<div class="col-sm-10"></div>
				<div class="col-sm-2">
					<button class="btn btn-primary">ثبت پرسش</button>
				</div>
			</div>

		</form>


	</div>

	@if( sizeof($questions)>0 )

		@foreach($questions as $key=>$value)
			@if( $value->parent_id == 0 )
				<div class="prev_questions" style="margin-top: 20px">
					<div style="width: 95%; margin:auto">

						<div class="row" style="padding-bottom: 10px; border-bottom: 1px solid #dfdfdf">
							<div class="col-sm-2">{{$value->User->name}}</div>
							<div class="col-sm-9"></div>
							<div class="col-sm-1">
								{{explode(" ", $value->created_at)[0]}}
							</div>
						</div>
					
						<div style="padding-top: 10px">

							{!! strip_tags(nl2br($value->question), '<br/>') !!}

							<!-- Answers area -->
							@foreach($questions as $key_answer=>$value_answer)
								@if( $value->id == $value_answer->parent_id)
									<div class="answered_area">

										<div class="row">
											<div class="col-sm-2">{{$value->User->name}}</div>
											<div class="col-sm-9"></div>
											<div class="col-sm-1 created_at">
												{{explode(" ", $value_answer->created_at)[0]}}
											</div>
										</div>

										<div class="text">
											{{ $value_answer->question }}
										</div>

									</div>
								@endif
							@endforeach
							<!-- ./Answers area -->

						</div>
					
						<div id="row_{{$value->id}}" style="margin-top: 20px; display: none">
							<div id="col_sm_12_{{$value->id}}">	

								<form action="{{ action('QuestionController@store') }}" onsubmit="answer_submit() ; return false;" method='post' id="answer_form">
								   {{ @csrf_field() }}

								   <span class="fa fa-mail-reply fa-rotate-270"></span>
								   <textarea class="answer form-control" name="question_text" id="{{$value->id}}"></textarea>
								   <div style="margin-top: 10px">
										<span style="color: red;" id="answer_text_error" class="answer_text_error">
											{{ $errors->first('question_text') }}
										</span>
									</div>
								   <input type="hidden" name="parent_id" id="{{$value->id}}" value="{{$value->id}}">
								   <input type="hidden" name="product_id" id="{{$product_id}}" value="{{$product_id}}">

								   <input type="submit" class="btn btn-success" value="ثبت" style="float:left; margin-top: 10px">
								   <div style="clear: both"></div>
							  	</form>	

							  	<div id="answer_alert_success" class="answer_alert_success"></div>

							</div>
						</div>
						
					</div>

					<div class="answer_btn"  onclick="answer('{{$value->id}}')">
						<span class="fa fa-mail-reply"></span>
						<span>به این پرسش پاسخ دهید</span>
					</div>
				</div>


				
			@endif

		@endforeach

	@else
		<div class="prev_questions" style="margin-top: 20px">
			<p style="color: red"> تاکنون پرسشی ثبت نشده </p>
		</div>
	
	@endif



</div>

<script type="text/javascript">
	
	question_submit = function()
	{
		var form_data = $("#question_form").serialize();
		console.log(form_data);

		$.ajaxSetup(
		    			{
		    				'headers':
		    				{
		    					'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
		    				}
		    			}
					);
		
		$.ajax(
	    		{

	    		'url': $("#question_form").attr('action'),
	    		'type': 'post',
	    		'data': 'form_data='+form_data+"&product_id="+<?php echo $product_id; ?>,
	    		success:function(data)
	    		{	    			
	    			if(data == '1')
	    			{
	    				$("#question_text_error").html("");

	    				$("#alert_success").addClass("alert alert-success");	    				
	    				$("#alert_success").html("با تشکر...پرسش شما پس از تایید مدیر منتشر خواهد");
	    			}
	    			else
	    			{
	    				if(data == '0')
	    					alert('مشکلی در پرسش سوال پیش آمده.');

	    				else
	    				{
	    					var data = Object.entries(data);

			    			data.forEach(([key, value]) => {
							  $("#"+key+"_error").html(value);
							});

    						$("#alert_success").removeClass("alert alert-success");	    				
		    				$("#alert_success").html("");
	    				}
	    			}
	    		}

	    		}
		  );
	}

	answer = function(question_id)
	{		
		$("#row_"+question_id).addClass("row");
		$("#row_"+question_id).css("border-top", "1px dotted #dfdfdf");
		$("#row_"+question_id).css("display", "block");

		$("#col_sm_12_"+question_id).addClass("col-sm-12");
	}


	
	answer_submit = function()
	{
		var form_data = $("#answer_form").serialize();
		console.log(form_data);

		$.ajaxSetup(
		    			{
		    				'headers':
		    				{
		    					'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
		    				}
		    			}
					);
		
		$.ajax(
	    		{

	    		'url': $("#answer_form").attr('action'),
	    		'type': 'post',
	    		'data': 'form_data='+form_data,
	    		success:function(data)
	    		{	    			
	    			if(data == '1')
	    			{
	    				$("#answer_text_error").html("");
	    				
	    				$("#answer_alert_success").addClass("alert alert-success");	    				
	    				$("#answer_alert_success").html("با تشکر...جواب شما پس از تایید مدیر منتشر خواهد");
	    			}
	    			else
	    			{
	    				if(data == '0')
	    					alert('مشکلی در پرسش سوال پیش آمده.');

	    				else
	    				{
	    					var data = Object.entries(data);

			    			data.forEach(([key, value]) => {
							  $("#answer_text_error").html(value);
							});

    						$("#answer_alert_success").removeClass("alert alert-success");	    				
		    				$("#answer_alert_success").html("");
	    				}
	    			}
	    		}

	    		}
		  );
	}
</script>