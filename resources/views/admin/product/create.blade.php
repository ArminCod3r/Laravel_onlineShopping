@extends('admin/layouts/adminLayout')



@section('header')
    <title>افزودن محصول</title>
    <link rel="stylesheet" type="text/css" href="{{ url('css/bootstrap-select.css') }}">
    <style type="text/css">
    	.bootstrap-select:not([class*="col-"]):not([class*="form-control"]):not(.input-group-btn)
    	{
    		width: 75%;
		}

		.add_product_tag
		{
			border-radius: 3px;
		    color:white;
		    background:#5CB85C;;
		    height:34px;
		    line-height: 34px;
		    float:right;
		    width:50px;
		    text-align:center;
		    cursor:pointer;
		    margin-right: 10px;
		    margin-top: 1px;
		}

		.tag_style
		{
			float:right;
		    margin-top: 10px;
		    padding-top: 5px;
		    padding-bottom:5px;
		    padding-right:10px;
		    padding-left:10px;
		    background:#F9F9F9;
		    margin-right:10px;
		    cursor:pointer;
		}

	</style>
@endsection

@section('custom-title')
  افزودن محصول
@endsection



@section('content1')
 <form action="{{ action('admin\ProductController@store') }}" method="POST" accept-charset="utf-8" enctype="multipart/form-data">
		{{ csrf_field() }}
		

		<div class="form-group">
			<label for="title">نام محصول</label>
  			<input type="text" name="title" id="title" class="form-control" value="" placeholder=""><br>

  			@if($errors->has('title'))
  				<span style="color: red;"> {{ $errors->first('title') }} </span>
  			@endif
		</div>


		<div class="form-group">
			<label for="title">انتخاب دسته</label>
			 <select multiple="multiple" name="cat[]" class="selectpicker" data-live-search="true">
			 <!--stack: 24627902-->

				 @for ($i=0; $i <=count($cat_list)-1; $i++)
			        <option value="{{ $i }}">{{ $cat_list[$i] }}</option>
			     @endfor
			  
			 </select> 

  			@if($errors->has('parent_id'))
  				<span style="color: red;"> {{ $errors->first('parent_id') }} </span>
  			@endif
		</div>

		<br/>
		<div class="form-group">
			<label for="code">نام لاتین محصول</label>
  			<input type="text" name="code" id="code" class="form-control" value="" placeholder="" style="text-align: left;"><br>

  			@if($errors->has('code'))
  				<span style="color: red;"> {{ $errors->first('code') }} </span>
  			@endif
		</div>

		<div class="form-group">
			<label for="price">هزینه محصول</label>
  			<input type="text" name="price" id="price" class="form-control " value="" placeholder="بر حسب تومان" style="text-align: left;" lang="fa"><br>

  			@if($errors->has('price'))
  				<span style="color: red;"> {{ $errors->first('price') }} </span>
  			@endif
		</div>

		<div class="form-group">
			<label for="discount">تخفیف</label>
  			<input type="text" name="discount" id="discount" class="form-control " value="" placeholder="بر حسب تومان" style="text-align: left;" lang="fa"><br>

  			@if($errors->has('discount'))
  				<span style="color: red;"> {{ $errors->first('discount') }} </span>
  			@endif
		</div>

		<div class="form-group">
			<label for="product_number">تعداد موجودی</label>
  			<input type="text" name="product_number" id="product_number" class="form-control " value="" placeholder="" style="text-align: left;" lang="fa"><br>

  			@if($errors->has('product_number'))
  				<span style="color: red;"> {{ $errors->first('product_number') }} </span>
  			@endif
		</div>

		<div class="form-group">
			<label for="bon">تعداد بن خرید محصول</label>
  			<input type="text" name="bon" id="bon" class="form-control " value="" placeholder="" style="text-align: left;" lang="fa"><br>

  			@if($errors->has('bon'))
  				<span style="color: red;"> {{ $errors->first('bon') }} </span>
  			@endif
		</div>


		<div class="form-group">
			<label for="article-ckeditor">توضیح</label>
  			<input type="text" name="article-ckeditor" id="article-ckeditor" class="form-control" value="" placeholder=""><br>
		</div>

		
		<br>
		<div class="form-group">
			<label for="product_status">وضعیت محصول</label>
  			<input type="checkbox" name="product_status" value="1" checked style="margin-right: 5%;">
  			موجود
  			<br>

  			@if($errors->has('product_status'))
  				<span style="color: red;"> {{ $errors->first('product_status') }} </span>
  			@endif
		</div>


		<div class="form-group">
			<label for="show_product">نمایش محصول</label>
  			<input type="checkbox" name="show_product" value="1" checked style="margin-right: 5%;"><br>

  			@if($errors->has('show_product'))
  				<span style="color: red;"> {{ $errors->first('show_product') }} </span>
  			@endif
		</div>


		<div class="form-group">
			<label for="special"> پیشنهاد ویژه </label>
  			<input type="checkbox" name="special" value="1" style="margin-right: 50px;"><br>

  			@if($errors->has('special'))
  				<span style="color: red;"> {{ $errors->first('special') }} </span>
  			@endif
		</div>


		<div class="form-group">
			<label> افزودن رنگ </label><br>
  			<input type="text" name="color[]" id="color" class="jscolor" style="margin-right: 10px;">
		</div>

		<div class="form-group" style="margin-right: 10px;">
  			<label class="fa fa-plus" style="color:red ; cursor:pointer" onclick="add_color()"></label>
		</div>

		<div class="form-group" id='colors_here' style="margin-right: 10px;">

		</div>


		<div class="form-group">
			<label>افزودن برچسب</label><br>
			<input type="text" name="tags" id="tag_list" class="form-control" style="float:right ; width:60%;"> </input>
			<div class="add_product_tag" onclick="add_tag()" > افزودن </div>
		</div>

		<br>
		<div class="form-group" id="show_tags" style="text-align: rtl;" dir="rtl">
			<!-- Tags will be shown here-->			
		</div>

		<input type="hidden" id="keywords" name="keywords">

	
		<br><br>
		<div class="form-group">
			<input type="file" name="img" id="img" style="display: none;" onchange="load_file(event)">
			<img src="{{ url('images/noimage.jpg') }}" id='res_img' width="150" onclick="select_file()">

			@if($errors->has('img'))
  				<span style="color: red;"> {{ $errors->first('img') }} </span>
  			@endif
		</div>

		<input type="submit" name="submit" value="ثبت" class="btn btn-primary">

	</form>
@endsection

@section('content2')
	<br><br><br><br><br><br>
@endsection

@section('footer')
	<script type="text/javascript" src="{{ url('js/bootstrap-select.js') }}"></script>
	<script type="text/javascript" src="{{ url('js/defaults-fa_IR.js') }}"></script>
	<script type="text/javascript" src="{{ url('js/jscolor.js') }}"></script>
	<script>

		select_file=function()
		{
		   document.getElementById('img').click();
		};

		load_file=function (event)
		{
		    var render=new FileReader;
		    render.onload=function ()
		    {
		        var res_img=document.getElementById('res_img');
		        res_img.src=render.result;
		    };
		    render.readAsDataURL(event.target.files[0]);
		}

		var number=2;
		add_color=function()
		{
			var colors_here = document.getElementById('colors_here'); 

			var input = document.createElement("input");
            input.type = "text";
            input.name = "color[]"
            //input.id = "";   //input.className="jscolor";
            var color = new jscolor(input);
            colors_here.appendChild(input);
            colors_here.appendChild(document.createElement("br"));



            // ANOTHER WAY OF CREATEING INPUT (stack: 37131370)

			/*var formgroup = $("<div/>", {
			  class: "form-group"
				});

			//formgroup.append($("<label>", {
			//  class: "col-sm-2 control-label",
			//  text: "Enter Name"
			//	}));

			var colsm = $("<div/>", {
			  class: "col-sm-10"
				});

			var input = $("<input/>", {
			  type: "text",
			  class: "jscolor",
			  id: "nameId",
			  //placeholder: "Enter Full Namee"
				});
			colsm.append(input);
			formgroup.append(colsm);
			$("#colors_here").append(formgroup);*/

		}

		$('.digit_to_persian').on('keyup', function(event){

			//console.log((new Error()).stack);
			//console.log("CALLER: " + event.target.id);
			//alert(event.target.value);

			$number = event.target.value;
			$number = $number.replace("1","۱");
	        $number = $number.replace("2","۲");
	        $number = $number.replace("3","۳");
	        $number = $number.replace("4","۴");
	        $number = $number.replace("5","۵");
	        $number = $number.replace("6","۶");
	        $number = $number.replace("7","۷");
	        $number = $number.replace("8","۸");
	        $number = $number.replace("9","۹");
	        $number = $number.replace("0","۰");

	        document.getElementById(event.target.id).value = $number;
        });

        add_tag = function(){
        	var tag_list = document.getElementById("tag_list").value;
        	var tag_split = tag_list.split(",");

        	var keywords = document.getElementById("keywords").value;
        	var keywords_temp = keywords;

        	var count=1;

        	for (var i=0 ; i<=(tag_split.length)-1 ; i++) 
        	{
        		if (tag_split[i].trim() != ' ' )
        		{
        			var char_count = keywords.search(tag_split[i]); // if nothingFound : ret -1 
        			if (char_count == -1)
        			{
        				keywords_temp += ","+tag_split[i];
        				var tag_html = '<div class="tag_style" id="TagItem'+count+'">'+
        							    "<span class='fa fa-remove' onclick='removeTag("+count+")'></span>"+
        							    tag_split[i]+
        								"</div>";
        				$("#show_tags").append(tag_html);
        			}
        		}
        		count++;
        	}

        	document.getElementById("keywords").value = keywords_temp;
        	document.getElementById("tag_list").value = ""; 

        	// $("#show_tags").append("<div>"+tag_split[i]+"</div>");
        }

        removeTag = function(id)
        {
        	keywords = document.getElementById('keywords').value;

        	removed_keyword = ((keywords.split(','))[id]);
        	new_keywords = keywords.replace(','+removed_keyword, '')

        	document.getElementById('keywords').value=new_keywords;

        	console.log(new_keywords);

        	$("#TagItem"+id).remove();
        }

	</script>

	<script src="/vendor/unisharp/laravel-ckeditor/ckeditor.js"></script>
    <script>
        CKEDITOR.replace( 'article-ckeditor' );
    </script>
@endsection