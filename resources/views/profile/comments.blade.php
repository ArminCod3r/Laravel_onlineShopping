@extends('layouts/profile')

@section('profile_content')

@if( sizeof($comments) > 0 )
	@foreach($comments as $key=>$comment)
		<div class="users_comments">

			<!-- Title & Link -->
			<p class="title">
				<a href="{{url('product').'/'.$comment->Product->code.'/'.$comment->Product->title_url }}">
					<span class="fa fa-link"></span>
					<span> {{$comment->Product->title}} </span>
				</a>
			</p>

			<!-- Comment's text -->
			<p class="text">
				{{$comment->comment_text}}
			</p>

			<!-- Pros & Cons -->
			<div class="container-fluid">

				<!-- Pros -->
				<div class="row">
					<div class="col-sm-6">
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
					</div>

					<!-- Cons -->
					<div class="col-sm-6">
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

					</div>

				</div>
			</div>

		</div>
	@endforeach
@else
	<p> کامنتی ثبت نشده است. </p>
@endif

@endsection