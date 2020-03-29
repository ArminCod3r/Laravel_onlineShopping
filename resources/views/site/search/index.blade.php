@extends('site/layouts/siteLayout')

@section('header')

	<style type="text/css">
	
		.checked_filters_class
		{
			display: none;
		}
	
	</style>

	<!--Plugin CSS file with desired skin-->
    <link rel="stylesheet" type="text/css" href="{{ url('css/ion.rangeSlider.css') }}">

@endsection

@section('content')
	<div>
		<div class="row" style="margin: 0px 20px 0px 20px;">

			<div class="col-2 col-sm-2 col-md-2 col-lg-2 col-xl-2 filters_area">

				<div>

					@foreach($selected_names as $key=>$value)
						<span style="background-color:#e1dfdf ; margin: 4px 4px 0px 0px; padding:4px ; border-radius: 4px; float: right;">

							<span style="cursor:pointer" onclick="delete_filter('{{$value->filter_id}}')">
								<span>{{ $value->FilterAssign[0]->value }}</span>
								<span class="fa fa-remove"></span>
							</span>
							

						</span>
					@endforeach
				</div>

				<div style="clear: both; padding-top: 20px"></div>

				<?php
					$count_to_show_search = 0;
					$show_search_box = array();
				?>

				<!--
					code  : which of the 'filter-parent' will have a search-box
					output: show_search_box[parent_ids] = 1
				-->
				@foreach($filters as $key_count=>$value_count)

					@foreach($filters as $key_count_2=>$value_count_2)

						@if($value_count_2->parent_id == $value_count->id )

							<?php $count_to_show_search++; ?>

							@if($count_to_show_search == 10)
								<?php $show_search_box[$value_count->id]=1; ?>				
							@endif

						@endif

					@endforeach

					<?php $count_to_show_search = 0;?>

				@endforeach

				<div style="width: 100%">
					<div style="direction: ltr ; width: 92% ; margin: auto">
						<input type="text" class="js-range-slider" name="my_range" id="price_slider" value=""
					        data-type="double"
					        data-min="{{ min($prices_range) }}"
					        data-max="{{ max($prices_range) }}"
					        
					        data-from=@if(app('request')->input('min_price')) {{app('request')->input('min_price')}} @else { min($prices_range) }} @endif

					        data-to=@if(app('request')->input('max_price')) {{app('request')->input('max_price')}} @else { min($prices_range) }} @endif
					    />
					</div>

					<div style="margin: 20px;">
						<button class="btn btn-primary" onclick="set_price_range(this)">اعمال محدوده قیمت</button>
					</div>
				</div>

				<?php $first_color=true; ?>
				@foreach($filters as $key=>$value)

					@if($value->parent_id == 0)

						<div onclick="show_sub_filters('{{$value->id}}')" class="filter_name">
							<span> {{$value->name}} </span>
							<span id="expand_icon_{{ $value->id }}" class="fa fa-angle-down icon"></span>
						</div>

						@if(array_key_exists($value->id, $show_search_box))
							<div id="search_{{ $value->id }}">
							<input class="search form-control" placeholder="جست و جو" onclick="filter_search('{{ $value->id }}')" id="search_filter_{{ $value->id }}" style="display:none" />
						@endif

						<div id="sub_filter_{{ $value->id }}" style="display: none">
						<ul class="filter_ul list" id="filter_ul">
						@foreach($filters as $key_2=>$value_2)
							@if($value_2->parent_id == $value->id )

								<li onclick="checking('{{$value_2->id}}')">

									<!-- simple filters -->
									@if($value_2->filled == 1)
										<div class="filters_filled_1">
										@if((in_array(array_search($value_2->id, $linked_filters), $selected_filters)))
											<span class="filter_checkbox_true" id="{{$value_2->id}}"></span>

											<input type="checkbox" value="{{$value->ename}}[]={{array_search($value_2->id, $linked_filters)}}" checked="checked" name="checked_filters" id="checked_filters_{{$value_2->id}}" style="display: none">
											<span class="filter_item name"> {{$value_2->name}} </span>
										@else
											<span class="filter_checkbox" id="{{$value_2->id}}"></span>

											<input type="checkbox" value="{{$value->ename}}[]={{array_search($value_2->id, $linked_filters)}}" name="checked_filters" id="checked_filters_{{$value_2->id}}" style="display: none">

											<span class="filter_item name"> {{$value_2->name}} </span>

										@endif
										</div>
									<!-- color filters -->							
									@else
										<?php
											$color_name = explode(':', $value_2->name)[0];
											$color_code = explode(':', $value_2->name)[1];
										?>

											@if($key_2 == $first_color)
												<div style="padding: 0px 0px 50px 0px; float: right">
												{{ $first_color = false }}
												
											@else
												<div style="padding: 0px 50px 50px 0px; float: right">
													
											@endif
													<span class="filter_color" style="background-color:#{{$color_code}}"></span>
												</div>

												<input type="checkbox" value="{{$value->ename}}[]=68" name="checked_filters" id="checked_filters_68" style="display: none">
											

									@endif

									
								</li>
							@endif
						@endforeach
						</ul>
						</div>
						<div style="clear: both"></div>

						@if(array_key_exists($value->id, $show_search_box))
							</div>
						@endif
						
					@endif
					
				@endforeach
			</div>

			<div class="col-10 col-sm-10 col-md-10 col-lg-10 col-xl-10">

				<div class="current_path">
					<?php $url = url('/search').'/'; ?>
					@foreach($page_cats as $key=>$value)
						<span>
							<a href="{{ $url = $url.$value->cat_ename.'/' }}" class="item">
								{{ $value->cat_name }}
							</a>

							@if(sizeof($page_cats) != $key)
								/
							@endif
							
						</span>
					@endforeach
				</div>

				<div class="row sort" >
					<div class="col-sm-1"></div>


					<div class="col-sm-2 sum_product_result">
						<div>
							<span>مجموع :</span>
							<span>{{sizeof($products)}}</span>
						</div>
					</div>

					<div class="col-sm-2 title">
						<span>
							مرتب سازی بر اساس
						</span>
					</div>

					 <div class="col-sm-7 options">
					 	<ul class="list-group list-group-horizontal">
						 	<li class="list-group-item active-sort-option" id="sort_option_1" onclick="sort('1')">جدید ترین</li>
						 	<li class="list-group-item" id="sort_option_2" onclick="sort('2')">پرفروش ترین</li>
						  	<li class="list-group-item" id="sort_option_3" onclick="sort('3')">ارزان ترین</li>
						  	<li class="list-group-item" id="sort_option_4" onclick="sort('4')">گران ترین</li>
						 	<li class="list-group-item" id="sort_option_5" onclick="sort('5')">پر بازدید ترین</li>
						 </ul>
					 </div>
					 
				 </div>
				 


				@include('include/products_list', ['products'=>$products])

			</div>
				
			</div>

		</div>
	</div>






@endsection

@section('footer')

<script type="text/javascript" src="{{ url('js/list.min.js') }}"></script>

 <!--jQuery-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<!--Plugin JavaScript file-->
<script type="text/javascript" src="{{ url('js/ion.rangeSlider.min.js') }}"></script>



<script type="text/javascript">

	
	checking = function(id)
	{
		filter = document.getElementById(id).className;

		// Enabling filter's checkbox
		if(filter == 'filter_checkbox')
		{
			document.getElementById(id).removeClass = 'filter_checkbox';
			document.getElementById(id).className   = 'filter_checkbox_true';

			document.getElementById("checked_filters_"+id).checked = true;
		}

		// Disabling filter's checkbox
		if(filter == 'filter_checkbox_true')
		{
			document.getElementById(id).removeClass = 'filter_checkbox_true';
			document.getElementById(id).className   = 'filter_checkbox';

			document.getElementById("checked_filters_"+id).checked = false;
		}

		// URL operation to add/delete filters
		var filter_checkbox = document.getElementsByName("checked_filters");
		var url            = window.location.search;
		const urlParams    = new URLSearchParams(url);
		filters            = new Array();
		var url_attributes = window.location.origin + window.location.pathname+'?';

		// Getting filters to generating new url
		for(var i=0 ; i<filter_checkbox.length ; i++)
		{
			if(filter_checkbox[i].checked)
			{
				filters.push(filter_checkbox[i].value);
			}				
		}

		// Generationg new URL with filters(attribute)
		if(filters.length > 0)
		{
			for(i=0 ; i<filters.length ; i++)
			{
				url_attributes = url_attributes + filters[i] + "&";
			}
		}

		// Redirecting to the new URL
		window.location.replace(url_attributes);

	}

	// Delteing filter from the selected-filters-box
	delete_filter = function(filter_id)
	{
		var filter_checkbox = document.getElementsByName("checked_filters");

		checking(filter_id);

	}

	// Searching among the filters
	var selected_search = 0;
	filter_search = function(search_id)
	{
		selected_search = search_id;

		var options = {
		  valueNames: [ 'name']
		};

		var userList = new List('search_'+selected_search, options);
	}

	// Handling pagination
	$('.pagination a').click(function(event){

		// prevent 'a' tag from redirecting
		event.preventDefault();

		// Generating new URL
		var filter_checkbox = document.getElementsByName("checked_filters");
		var url            = window.location.search;
		const urlParams    = new URLSearchParams(url);
		filters            = new Array();
		var url_attributes = window.location.origin + window.location.pathname+'?';

		// Getting filters to generating new url
		for(var i=0 ; i<filter_checkbox.length ; i++)
		{
			if(filter_checkbox[i].checked)
			{
				filters.push(filter_checkbox[i].value);
			}				
		}

		// Generating new url
		if(filters.length > 0)
		{
			for(i=0 ; i<filters.length ; i++)
			{
				url_attributes = url_attributes + filters[i] + "&";
			}
		}

		// Redirecting new URL
		window.location.replace(url_attributes+"page="+event['currentTarget']['innerText']);
	});

	// Collapsible filters
	show_sub_filters = function(parent_filter_id)
	{
		var sub_filter   = document.getElementById("sub_filter_"+parent_filter_id);
		var search_filter= document.getElementById("search_filter_"+parent_filter_id);


		if (sub_filter.style.display === "none")
		{
			// Showing sub-filter
		    sub_filter.style.display = "block";

		    // Changing the icon
		    $("#expand_icon_65").removeClass("fa-angle-down");
		    $("#expand_icon_65").addClass("fa-angle-up");

			// Showing search-filter
		    search_filter.style.display = "block";
		}
		else
		{
			// Hiding sub-filter
		    sub_filter.style.display = "none";

		    // Changing the icon
		    $("#expand_icon_65").removeClass("fa-angle-up");
		    $("#expand_icon_65").addClass("fa-angle-down");

			// Hiding search-filter
		    search_filter.style.display = "none";
		}
	}

	// Sorting
	sort = function(sortBy)
	{
		// Activating selected sorting-option
		enable_sorting_option(sortBy);

		
		// Add sorted-option to the url
		var url_params            = window.location.search;		

		var url = new URL(window.location.origin + window.location.pathname+window.location.search);

		var query_string = url.search;
		var search_params = new URLSearchParams(query_string); 

		// javascript change value of parameter
		// https://usefulangle.com/post/81/javascript-change-url-parameters
		if(url_params.includes("sortby"))
			search_params.set('sortby', sortBy);

		else
			search_params.append('sortby', sortBy);
			//url_for_sorting = url_attributes + url + sort_option;
		

		// change the search property of the main url
		url.search = search_params.toString();

		// the new url string
		var new_url = url.toString();

		console.log(new_url);


		// Redirecting new URL
		window.location.replace(new_url);
	}

	enable_sorting_option = function(sortby)
	{
		for (var i=0 ; i<=4 ; i++)
		{
			$("#sort_option_"+i).removeClass("active-sort-option");
		}

		$("#sort_option_"+sortby).addClass("active-sort-option");
	}

	enable_sorting_option(<?php echo $sortby;?>);

	
	// set defaults
	var from_ = document.getElementById('price_slider').getAttribute('data-min');
	var to_   = document.getElementById('price_slider').getAttribute('data-max');

	//  Price's range-slider initialize instance
	$(".js-range-slider").ionRangeSlider({
		min: document.getElementById('price_slider').getAttribute('data-min'),
        max: document.getElementById('price_slider').getAttribute('data-max'),
		onFinish: updateInputs
	});



	function updateInputs (data)
	{
        from_ = data.from;
        to_ = data.to;
    }

	set_price_range = function()
	{
        console.log(from_);
        console.log(to_);

		var url_params = window.location.search;	
		var url        = new URL(window.location.origin + window.location.pathname + url_params);

		var query_string  = url.search;
		var search_params = new URLSearchParams(query_string); 

		// javascript change value of parameter: https://usefulangle.com/post/81/javascript-change-url-parameters
		if(url_params.includes("min_price"))
			search_params.set('min_price', from_);

		else
			search_params.append('min_price', from_);

		if(url_params.includes("max_price"))
			search_params.set('max_price', to_);

		else
			search_params.append('max_price', to_);
		

		
		url.search = search_params.toString(); // change the search property of the main url
		
		var new_url = url.toString(); // the new url string

		console.log(new_url);


		// Redirecting new URL
		window.location.replace(new_url);
	}
	

</script>

@endsection