@extends('admin/layouts/adminLayout')

@section('header')
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<!-- font awesome -->
	<link rel="stylesheet" href="{{ url('css/font-awesome.css') }}">
	
	<title>سوال و جواب کاربران</title>
@endsection

@section('custom-title')
  سوال و جواب کاربران
@endsection


@section('content1')

<section class="col-lg-12 connectedSortable">

<div>
	@if( sizeof($questions) > 0 )

		@foreach($questions as $key=>$question)

			@if( $question->parent_id == 0 )
				<div class="row comment_approval_product_title">
					<a href="{{ url('').'/product/'.$question->Product->code.'/'.str_replace(" ", "-", $question->Product->title) }}">
						<span class="fa fa-link"></span>
						<span>{{ $question->Product->title }}</span>
					</a>
				</div>
			@endif

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

									</div>
								@endif
							@endforeach
							<!-- ./Answers area -->

						</div>
					
						<div id="row_{{$question->id}}" style="margin-top: 20px; display: none">
							<div id="col_sm_12_{{$question->id}}">	

								<form action="{{ action('QuestionController@store') }}" onsubmit="answer_submit() ; return false;" method='post' id="answer_form">
								   {{ @csrf_field() }}

								   <span class="fa fa-mail-reply fa-rotate-270"></span>
								   <textarea class="answer form-control" name="question_text" id="{{$question->id}}"></textarea>
								   <div style="margin-top: 10px">
										<span style="color: red;" id="answer_text_error" class="answer_text_error">
											{{ $errors->first('question_text') }}
										</span>
									</div>
								   <input type="hidden" name="parent_id" id="{{$question->id}}" value="{{$question->id}}">
								   <input type="hidden" name="product_id" id="28" value="28">

								   <input type="submit" class="btn btn-success" value="ثبت" style="float:left; margin-top: 10px">
								   <div style="clear: both"></div>
							  	</form>	

							  	<div id="answer_alert_success" class="answer_alert_success"></div>

							</div>
						</div>
						
					</div>

					<div class="answer_btn"  onclick="answer('{{$question->id}}')">
						<span class="fa fa-mail-reply"></span>
						<span>به این پرسش پاسخ دهید</span>
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

