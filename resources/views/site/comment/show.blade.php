@extends('site/layouts/siteLayout')

@section('header')
<link rel="stylesheet" type="text/css" href="{{ url('css/rangeslider.css') }}">
@endsection

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

				<form action="#" method="POST">

					{{ csrf_field() }}

					<h5 style="margin-top:20px">
						امتیاز شما به این محصول
					</h5>

					<div style="margin-top: 30px">
						<label>کیفیت ساخت</label>
						<input type="range" min="0" max="5" step="1" data-rangeslider id="range_1" />
	                    <p id="output_range_1"></p>
					</div>

					<div style="margin-top: 20px">
						<label>ارزش خرید نسبت به قیمت</label>
						<input type="range" min="0" max="5" step="1" data-rangeslider id="range_2" />
	                    <p id="output_range_2"></p>
					</div>

					<div style="margin-top: 20px">
						<label>نوآوری</label>
						<input type="range" min="0" max="5" step="1" data-rangeslider id="range_3" />
	                    <p id="output_range_3"></p>
					</div>

					<div style="margin-top: 20px">
						<label>امکانات و قابلیت ها</label>
						<input type="range" min="0" max="5" step="1" data-rangeslider id="range_4" />
	                    <p id="output_range_4"></p>
					</div>

					<div style="margin-top: 20px">
						<label>سهولت استفاده</label>
						<input type="range" min="0" max="5" step="1" data-rangeslider id="range_5" />
	                    <p id="output_range_5"></p>
					</div>

					<div style="margin-top: 20px">
						<label>طراحی و ظاهر</label>
						<input type="range" min="0" max="5" step="1" data-rangeslider id="range_6" />
	                    <p id="output_range_6"></p>
					</div>

					<input type="submit" value="ثبت" class="btn btn-primary" style="margin-bottom:30px ; width: 20% ; float:left">

				</form>

			</div>
		</div>
	</div>

	<div class="commenting">
		
		<h5> دیگران را با نوشتن نقد و بررسی و نظرات خود برای انتخاب این محصول راهنمایی کنید </h5>	

		<div class="row title">
			<div class="col-sm-6">

				<div class="form-group">
					<label for="title">عنوان نقد و بررسی (اجباری)</label>
		  			<input type="text" name="title" id="title" class="form-control" value=""><br>
				</div>
			</div>

			<div class="col-sm-6"></div>
		</div>

		<div class="row pros_cons">
			<div class="col-sm-6">

				<div class="form-group pros">
					<p for="pros" style="color: green">نقاط قوت</p>
		  			<input type="text" name="pros[1]" id="pros" class="form-control header" value=""><br>
		  			<span class="fa fa-plus-circle" onclick="add_pros()"></span>
		  			<span class="fa fa-minus-circle" onclick="remove_pros()"></span>

		  			<!-- User's commented 'pros' -->
		  			<div id="pros_area">

		  			</div>
				</div>
			</div>

			<div class="col-sm-6">

				<div class="form-group cons">
					<p for="cons" style="color: red">نقاط ضعف</p>
		  			<input type="text" name="cons[1]" id="cons" class="form-control header" value=""><br>
		  			<span class="fa fa-plus-circle" onclick="add_cons()"></span>
		  			<span class="fa fa-minus-circle" onclick="remove_cons()"></span>

		  			<!-- User's commented 'cons' -->
		  			<div id="cons_area">

		  			</div>
				</div>
			</div>
		</div>

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

    count = 2;
    add_pros = function()
    {
    	var custom_pros='<input type="text" id="pros_'+count+'" name="pros['+count+']" class="form-control" style="width:80%;margin-top:10px" placeholder="'+count+'">';
        count++;

        $("#pros_area").append(custom_pros);
    }

    remove_pros = function()
    {
    	if(count > 2)
    		count--;

    	$("#pros_"+count).remove();
    }

</script>


@endsection