

<div>

	<div class="questions">

		<form action="{{ action('QuestionController@store') }}" onsubmit="question_submit() ; return false;" method="POST" id="question_form">
			{{ csrf_field() }}

			<div class="row">

				<div class="col-sm-12">
					<div class="form-group">
						<p for="text" class="title">متن پرسش</p>
						<textarea class="form-control" name="question_text" id="question_text"></textarea>

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
						{{$value->question}}
						<div class="row">
							<div class="col-sm-10"></div>
							<div class="col-sm-2">
								<button class="btn btn-primary" style="float: left;" onclick="answer('{{$value->id}}')">جواب دادن</button>
							</div>
						</div>
					</div>
				
					<div id="row_{{$value->id}}" style="margin-top: 20px">
						<div id="col_sm_12_{{$value->id}}">								
						</div>
					</div>
					
				</div>
			</div>
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

		$("#col_sm_12_"+question_id).addClass("col-sm-12");

		textarea = "<span class='fa fa-mail-reply fa-rotate-270'></span>"+
				   "<textarea id='"+question_id+"' class='answer form-control'></textarea>";

		$("#col_sm_12_"+question_id).append(textarea);
	}
</script>