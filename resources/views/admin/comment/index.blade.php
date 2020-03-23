@extends('admin/layouts/adminLayout')

@section('header')
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<title>نظرات کاربران</title>
@endsection

@section('custom-title')
  نظرات کاربران
@endsection


@section('content1')

<section class="col-lg-12 connectedSortable">

	<?php $score_names = ['ارزش خرید نسبت به قیمت', 'کیفیت ساخت', 'امکانات و قابلیت ها', 'شهولت استفاده ', 'کارایی و ظاهر', 'نوآوری']?>

	@foreach($comments_and_scores as $key=>$item)

		<div class="row comment_approval_product_title">
			<a href="{{ url('').'/product/'.$item->Product->code.'/'.str_replace(" ", "-", $item->Product->title) }}">
				<span class="fa fa-link"></span>
				<span>{{ $item->Product->title }}</span>
			</a>
		</div>

		<div class="row sumup">

			<div class="col-sm-6">

				<table>
					@foreach($item->ProductScore as $key_score=>$value_score)

						@if($item->user_id == $value_score->user_id)
						
						<tr>
							<td>{{ $value_score->score_value }}</td>
							<td>
								@for($i=1 ; $i<=5 ; $i++)

									@if($i <= $item->ProductScore[$key_score]->score_value)
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


				<div class="row" style="margin-top: 20px">

					<label></label>

					<div class="col-sm-2">
						<button class="btn btn-success" style="width: 100%" id="{{ $item->id }}" onclick="approval(this)"> تایید </button>
					</div>	

					<div class="col-sm-2">
						<button class="btn btn-danger" style="width: 100%" id="{{ $item->id }}" onclick="remove_comment('{{ $item->id }}')"> حذف </button>
                    </form>						
					</div>
				</div> 

				<div id="status_area" style="margin: 10px 2px 0px 0px ; font-size: 16px;">
					<span>وضعیت: </span>
					<span id='status'>
						<span style="color: red">تایید نشده</span>
					</span>
				</div>              

			</div>


			<div class="col-sm-6" style="border-right: 1px solid #eeeded">

				<div>{{ $item->subject }}</div>

				<div style="color:green ; margin-top: 20px">
					<span class="fa fa-arrow-up"></span>
					نقاط قوت
				</div>

				@if(sizeof($item->pros)>0)
					<?php
						$pros_arr = explode("-::-", $item->pros);								
						$pros_arr = array_filter($pros_arr);  // Remove an empty element
					?>

					@foreach($pros_arr as $key_pro=>$item_pro)
						<div style="margin-right: 15px"> {{$item_pro}} </div>	  					
	  				@endforeach
				@endif


				<div style="color:red ; margin-top: 20px">
					<span class="fa fa-arrow-down"></span>
					نقاط ضعف
				</div>				

				@if(sizeof($item->cons)>0)
					<?php
						$cons_arr = explode("-::-", $item->cons);								
						$cons_arr = array_filter($cons_arr);  // Remove an empty element
					?>

					@foreach($cons_arr as $key_con=>$item_con)
						<div style="margin-right: 15px"> {{$item_con}} </div>	  					
	  				@endforeach
				@endif

				<div class="comment_text">
					{{ $item->comment_text }}
				</div>

			</div>

		</div>

	@endforeach

@endsection

@section('content4')
	<section class="col-lg-5 connectedSortable">
@endsection


@section('footer')

<script type="text/javascript">
	

	<?php $url= url('admin/comment/approve/'); ?>
	approval = function(caller)
	{
		var comment_id = caller.id;
		url_approve = <?php echo json_encode($url); ?> + "/" + comment_id;

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
	    					$("#status").html(status);
	    				}
	    				else
	    				{
	    					alert("مجددا تلاش کنید");
	    				}
	    			}
	    		}
		  );
	}

	<?php $url_remove= url('admin/comment/remove/'); ?>
	remove_comment = function(comment_id)
	{
		url_remove = <?php echo json_encode($url_remove); ?> + "/" + comment_id;

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
	    					alert("نظر با موفقیت حذف شد.");

	    					status = '<span  style="color: red">حذف شد</span>';
	    					$("#status").html(status);
	    				}
	    				else
	    				{
	    					alert("مجددا تلاش کنید");
	    				}
	    			}
	    		}
		  );
	}

</script>

@endsection