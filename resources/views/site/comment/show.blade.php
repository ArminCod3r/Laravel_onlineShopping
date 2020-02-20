@extends('site/layouts/siteLayout')

@section('header')
<link rel="stylesheet" type="text/css" href="{{ url('css/rangeslider.css') }}">
@endsection

<?php $count_pros = 1;?>
<?php $count_cons = 1;?>

@section('content')
	<div class="scoring" style="margin-bottom: 30px">
		<div class="row" style="width: 95% ; margin: auto ; background-color: white ; border-radius: 5px">
			<div class="col-sm-5" style="text-align: center">
				<div>
					<img style="width:45%" src="{{ url('upload').'/'.$product->ProductImage[0]->url }}">
				</div>
				<div style="font-weight: bold ; padding-top: 10px">
					<p>{{$product->title}}</p>
					<p>{{$product->code}}</p>
				</div>
			</div>

			<div class="col-sm-7">

				<form action="{{ action('CommentController@store_score', $product->id) }}" method="POST">

					{{ csrf_field() }}

					<h5 style="margin-top:20px">
						امتیاز شما به این محصول
					</h5>

					<div style="margin-top: 30px">
						<label>کیفیت ساخت</label>
						<input type="range" min="0" max="5" step="1" name="score[1]" data-rangeslider id="range_1" value="<?php if(sizeof($score)>0) echo $score[0]->score_value; else echo 3;?>" />
	                    <p id="output_range_1"></p>
					</div>

					<div style="margin-top: 20px">
						<label>ارزش خرید نسبت به قیمت</label>
						<input type="range" min="0" max="5" step="1" name="score[2]" data-rangeslider id="range_2" value="<?php if(sizeof($score)>0) echo $score[1]->score_value; else echo 3;?>"/>
	                    <p id="output_range_2"></p>
					</div>

					<div style="margin-top: 20px">
						<label>نوآوری</label>
						<input type="range" min="0" max="5" step="1" name="score[3]" data-rangeslider id="range_3" value="<?php if(sizeof($score)>0) echo $score[2]->score_value; else echo 3;?>"/>
	                    <p id="output_range_3"></p>
					</div>

					<div style="margin-top: 20px">
						<label>امکانات و قابلیت ها</label>
						<input type="range" min="0" max="5" step="1" name="score[4]" data-rangeslider id="range_4" value="<?php if(sizeof($score)>0) echo $score[3]->score_value; else echo 3;?>"/>
	                    <p id="output_range_4"></p>
					</div>

					<div style="margin-top: 20px">
						<label>سهولت استفاده</label>
						<input type="range" min="0" max="5" step="1" name="score[5]" data-rangeslider id="range_5" value="<?php if(sizeof($score)>0) echo $score[4]->score_value; else echo 3;?>"/>
	                    <p id="output_range_5"></p>
					</div>

					<div style="margin-top: 20px">
						<label>طراحی و ظاهر</label>
						<input type="range" min="0" max="5" step="1" name="score[6]" data-rangeslider id="range_6" value="<?php if(sizeof($score)>0) echo $score[5]->score_value; else echo 3;?>"/>
	                    <p id="output_range_6"></p>
					</div>

					@if(sizeof($score) == 0)
						<input type="submit" value="ثبت" class="btn btn-primary" style="margin-bottom:30px ; width: 20% ; float:left">
					@endif

				</form>

			</div>
		</div>
	</div>

	<div class="commenting" <?php if(sizeof($score)==0) echo "style='background-color:#fff ; opacity:0.5 ; cursor:not-allowed'"; ?> >

		<form action="{{ action('CommentController@store_comment', $product->id) }}" method="GET">

			{{ csrf_field() }}
		
			<h5> دیگران را با نوشتن نقد و بررسی و نظرات خود برای انتخاب این محصول راهنمایی کنید </h5>	

			<div class="row title">
				<div class="col-sm-6">

					<div class="form-group">
						<label for="title">عنوان نقد و بررسی (اجباری)</label>
			  			<input type="text" name="title" id="title" class="form-control" value="<?php if(sizeof($comment)>0) echo $comment[0]->subject; ?>"><br>
					</div>
				</div>

				<div class="col-sm-6"></div>
			</div>

			<!-- Pros and Cons -->
			<div class="row pros_cons">

				<!-- Pros -->
				<div class="col-sm-6">
					<div class="form-group pros">
						<p for="pros" style="color: green">نقاط قوت</p>

						@if(sizeof($comment)>0)
							<?php
								$pros_arr = explode("-::-", $comment[0]->pros);								
								$pros_arr = array_filter($pros_arr);  // Remove an empty element
							?>
							@foreach($pros_arr as $key=>$item)

								@if($key==0)
									<input type="text" name="pros[{{$count_pros}}]" id="pros_{{$count_pros}}" class="form-control header" value="{{$item}}"><br>
									<span class="fa fa-plus-circle" onclick="add_pros()"></span>
			  						<span class="fa fa-minus-circle" onclick="remove_pros()"></span>

			  						<?php $count_pros++;?>

								@else
									<input type="text" id="pros_{{$count_pros}}" name="pros[{{$count_pros}}]" class="form-control" style="width:80%;margin-top:10px" value="{{$item}}">
									<?php $count_pros++;?>
								@endif
			  					
			  				@endforeach

						@else
							<input type="text" name="pros[1]" id="pros" class="form-control header" value=""><br>
							<span class="fa fa-plus-circle" @if(sizeof($score)>0) onclick="add_pros()" @endif></span>
			  				<span class="fa fa-minus-circle" @if(sizeof($score)>0) onclick="remove_pros()" @endif></span>
						@endif

			  			<!-- User's commented 'pros' -->
			  			<div id="pros_area">
			  			</div>

					</div>
				</div>

				<!-- Cons -->
				<div class="col-sm-6">

					<div class="form-group cons">
						<p for="cons" style="color: red">نقاط ضعف</p>


						@if(sizeof($comment)>0)
							<?php
								$cons_arr = explode("-::-", $comment[0]->cons);								
								$cons_arr = array_filter($cons_arr);  // Remove an empty element
							?>
							@foreach($cons_arr as $key=>$item)

								@if($key==0)
									<input type="text" name="cons[{{$count_cons}}]" id="cons_{{$count_cons}}" class="form-control header" value="{{$item}}"><br>
									<span class="fa fa-plus-circle" onclick="add_cons()"></span>
			  						<span class="fa fa-minus-circle" onclick="remove_cons()"></span>

			  						<?php $count_cons++;?>

								@else
									<input type="text" id="cons_{{$count_cons}}" name="cons[{{$count_cons}}]" class="form-control" style="width:80%;margin-top:10px" value="{{$item}}">
									<?php $count_cons++;?>
								@endif
			  					
			  				@endforeach

			  			@endif

			  			<!-- User's commented 'cons' -->
			  			<div id="cons_area">

			  			</div>
					</div>
				</div>
			</div>

			<div class="row comment_text">
				<div class="col-sm-12">
					<div class="form-group">
						<p for="">متن نقد و بررسی شما (اجباری)</p>
						<textarea class="form-control" name="comment_text" id="comment_text"><?php if(sizeof($comment)>0) echo $comment[0]->comment_text; ?></textarea>
					</div>
				</div>
			</div>

			<div style="text-align: left">
				<input type="submit" value="ثبت نظر" class="btn btn-primary comment_submit_btn">
			</div>
		
		</form>

	</div>
@endsection

@section('footer')
<script type="text/javascript" src="{{ url('js/rangeslider.js') }}"></script>
<script>
    function valueOutput(element)
    {
        var value = element.value;
        $("#output_"+element.id).html(element.value);
        $("#"+element.id).value=element.value;
    };
    $('[data-rangeslider]').rangeslider({


        polyfill: false,


        onInit: function()
        {
           valueOutput(this.$element[0]);
        },
        onSlideEnd: function(position, value) {
            valueOutput(this.$element[0]);
        }


    });

    count_pros = <?php echo $count_pros; ?>;
    add_pros = function()
    {
    	var custom_pros='<input type="text" id="pros_'+count_pros+'" name="pros['+count_pros+']" class="form-control" style="width:80%;margin-top:10px" placeholder="'+count_pros+'">';
        count_pros++;

        $("#pros_area").append(custom_pros);
    }

    remove_pros = function()
    {
    	count_pros--;

    	// Removing the created input
    	if(count_pros > 1)
    		$("#pros_"+count_pros).remove();
		
		// Empty the value of the first input
		if(count_pros == 1)
			$("#pros_"+count_pros).val('');
    }

    count_cons = <?php echo $count_cons; ?>;
    add_cons = function()
    {
    	console.log(count_cons);
    	var custom_cons='<input type="text" id="cons_'+count_cons+'" name="cons['+count_cons+']" class="form-control" style="width:80%;margin-top:10px" placeholder="'+count_cons+'">';
        count_cons++;

        $("#cons_area").append(custom_cons);
    	console.log(count_cons);
    }

    remove_cons = function()
    {
    	count_cons--;
    	console.log(count_cons);

    	// Removing the created input
    	if(count_cons > 1)
    		$("#cons_"+count_cons).remove();
		
		// Empty the value of the first input
		if(count_cons == 1)
			$("#cons_"+count_cons).val('');
    }

</script>


@endsection