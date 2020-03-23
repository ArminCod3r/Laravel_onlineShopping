@extends('admin/layouts/adminLayout')

@section('header')
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<!-- font awesome -->
	<link rel="stylesheet" href="{{ url('css/font-awesome.css') }}">
	
	<title>مدیریت پرسش های کاربران</title>
@endsection

@section('custom-title')
  مدیریت پرسش های کاربران
@endsection


@section('content1')

<section class="col-lg-12 connectedSortable">

<div>
	@if( sizeof($questions) > 0 )

		@foreach($questions as $key=>$question)

			<!-- Product's Link -->
			@if( $question->parent_id == 0 )
				<div class="row comment_approval_product_title">
					<a href="{{ url('').'/product/'.$question->Product->code.'/'.str_replace(" ", "-", $question->Product->title) }}">
						<span class="fa fa-link"></span>
						<span>{{ $question->Product->title }}</span>
					</a>
				</div>
			@endif

			<!-- Question / Answers -->
			@if( $question->parent_id == 0 )
				<div class="prev_questions">
					<div style="width: 95%; margin:auto">

						<div class="row" style="padding-bottom: 10px; border-bottom: 1px solid #dfdfdf">
							<div class="col-sm-2">{{$question->User->name}}</div>
							<div class="col-sm-9"></div>
							<div class="col-sm-1">
								{{explode(" ", $question->created_at)[0]}}
							</div>
						</div>
					
						<div style="padding-top: 10px">

							{!! strip_tags(nl2br($question->question), '<br/>') !!}

							<!-- Answers area -->
							@foreach($questions as $key_answer=>$value_answer)
								@if( $question->id == $value_answer->parent_id)
									<div class="answered_area">

										<div class="row">
											<div class="col-sm-2">{{$question->User->name}}</div>
											<div class="col-sm-9"></div>
											<div class="col-sm-1 created_at">
												{{explode(" ", $value_answer->created_at)[0]}}
											</div>
										</div>

										<div class="text">
											{{ $value_answer->question }}
										</div>

										<!-- approve / remove -->
										<div style="position: relative;background-color: #f4f4f4; padding: 10px">

										@if($value_answer->status == 0)

											<div class="row">

												<div class="col-sm-1">
													<button class="btn btn-success fa fa-check approve_btn" id="{{ $question->id }}" onclick="approval('{{ $value_answer->id }}')"> </button>
												</div>

												<div class="col-sm-1">
													<button class="btn btn-danger fa fa-trash remove_btn" id="{{ $question->id }}" onclick="remove_comment('{{ $value_answer->id }}')"> </button>
												</div>

											</div>

											<div id="status_area" style="font-size: 16px;position: absolute;left:10px;top:0px;">
												<span>وضعیت: </span>
												<span id='status_{{$value_answer->id}}'>												
													<span style="color: red">تایید نشده</span>
												</span>
											</div>
										@else
											
												<div class="row">
													<div class="col-sm-1">
														<button class="btn btn-danger fa fa-trash remove_btn" id="{{ $question->id }}" onclick="remove_comment('{{ $value_answer->id }}')"> </button>
													</div>

												</div>

												<div id="status_area" style="font-size: 16px;position: absolute;left:10px;top:0px;">
													<span>وضعیت: </span>
													<span id='status_{{$value_answer->id}}'>
														<span style="color: green">تایید شده</span>
													</span>
												</div>
												

										@endif

										</div>

									</div>
								@endif
							@endforeach
							<!-- ./Answers area -->

						</div>
					
						<div id="row_{{$question->id}}" style="margin: 20px 0px 20px 0px; display: none">
							<div id="col_sm_12_{{$question->id}}">	

								<form action="{{ action('admin\QuestionController@store') }}" onsubmit="answer_submit('{{$question->id}}') ; return false;" method='post' id="answer_form">
								   {{ @csrf_field() }}

								   <span class="fa fa-mail-reply fa-rotate-270"></span>
								   <textarea class="answer form-control" name="question_text" id="{{$question->id}}"></textarea>
								   <div style="margin-top: 10px">
										<span style="color: red;" id="answer_text_error" class="answer_text_error">
											{{ $errors->first('question_text') }}
										</span>
									</div>
								   <input type="hidden" name="parent_id" id="{{$question->id}}" value="{{$question->id}}">
								   <input type="hidden" name="product_id" id="{{$question->Product->id}}" value="{{$question->Product->id}}">

								   <input type="submit" class="btn btn-success" value="ثبت" style="float:left; margin-top: 10px">
								   <div style="clear: both"></div>
							  	</form>	
							</div>

						</div>

						<div id="answer_alert_success" class="answer_alert_success"></div>
						
					</div>
					

					<div class="answer_btn"  onclick="answer('{{$question->id}}')" style="position: relative;bottom: 25px;">
						<span class="fa fa-mail-reply"></span>
						<span>به این پرسش پاسخ دهید</span>
					</div>

					<div style="margin-top: 40px ; background-color: #f4f4f4; padding: 10px">

					<div style="position: relative;">					

					@if($question->status == 0)

					<div class="row">

						<div class="col-sm-1">
							<button class="btn btn-success fa fa-check approve_btn" id="{{ $question->id }}" onclick="approval('{{ $question->id }}')" > </button>
						</div>

						<div class="col-sm-1">
							<button class="btn btn-danger fa fa-trash remove_btn" id="{{ $question->id }}" onclick="remove_question('{{ $question->id }}')"> </button>
						</div>

					</div>



					<div id="status_area" style="font-size: 16px;position: absolute;left:10px;top:0px;">
						<span>وضعیت: </span>
						<span id='status_{{$question->id}}'>
							<span style="color: red">تایید نشده</span>
						</span>
					</div>
				
				@else
					<div class="row">

						<div class="col-sm-1">
							<button class="btn btn-danger fa fa-trash remove_btn" id="{{ $question->id }}" onclick="remove_question('{{ $question->id }}')"> </button>
						</div>

					</div>
					<div id="status_area" style="font-size: 16px;position: absolute;left:10px;top:0px;">
						<span>وضعیت: </span>
						<span id='status_{{$value_answer->id}}'>
							<span style="color: green">تایید شده</span>
						</span>
					</div>				
				@endif

				</div>
			</div>
		</div>
				
			@endif
			

		@endforeach

	@endif
</div>

@endsection


@section('content4')
	<section class="col-lg-5 connectedSortable">
@endsection

@section('footer')

<script type="text/javascript">
	

	<?php $url= url('admin/question/approve/'); ?>
	approval = function(question_id)
	{
		console.log("#status_"+question_id);

		url_approve = <?php echo json_encode($url); ?> + "/" + question_id;

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

	    		'url': url_approve,
	    		'type': 'get',
	    		'data': '',
	    		success:function(data){
	    				if(data == 'true')
	    				{
	    					alert("نظر با موفقیت تایید شد.");

	    					status = '<span  style="color: green">تایید شد</span>';
	    					$("#status_"+question_id).html(status);
	    				}
	    				else
	    				{
	    					alert("مجددا تلاش کنید");
	    				}
	    			}
	    		}
		  );
	}

	<?php $url_remove= url('admin/question/remove/'); ?>
	remove_question = function(question_id)
	{
		url_remove = <?php echo json_encode($url_remove); ?> + "/" + question_id;

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

	    		'url': url_remove,
	    		'type': 'get',
	    		'data': '',
	    		success:function(data){
	    				if(data == 'true')
	    				{
	    					alert("با موفقیت حذف شد.");

	    					status = '<span  style="color: red">حذف شد</span>';
	    					$("#status_"+question_id).html(status);
	    				}
	    				else
	    				{
	    					alert("مجددا تلاش کنید");
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


	
	answer_submit = function(question_id)
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
	    				$("#row_"+question_id).css("display", "none");

	    				$("#answer_text_error").html("");
	    				
	    				$("#answer_alert_success").addClass("alert alert-success");	    				
	    				$("#answer_alert_success").html("ثبت شد.");
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

@endsection
