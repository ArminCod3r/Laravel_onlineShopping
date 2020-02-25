

<div>

	<div class="questions">

		<form action="{{ action('QuestionController@store') }}" onsubmit="question_submit() ; return false;" method="POST" id="question_form">
			{{ csrf_field() }}

			<input type="hidden" name="product_id" id="product_id" value="28">
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
	    		'data': 'form_data='+form_data+"&product_id="+<?php echo $product_id;?>,
	    		success:function(data)
	    		{	    			
	    			if(data == '1')
	    			{
	    				alert('پرسش با موفقیت ثبت شد');
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
	    				}
	    			}
	    		}

	    		}
		  );
	}
</script>