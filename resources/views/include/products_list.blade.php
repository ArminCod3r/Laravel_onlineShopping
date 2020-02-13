@foreach($products as $key=>$value)

	@if($key % 4 == 0)
	<div class="row products_list" style="height: 300px;">
	@endif

	<a href="/product/{{$value->product[0]->code}}/{{$value->product[0]->title_url}}">
		<div class="col-3 col-sm-3 col-md-3 col-lg-3 col-xl-3" style="height:750px; width: 244px">
		<div class="product_area">
			<div class="img">
			<img style="width: 48%" src="{{ url('/upload/'. $value->ProductImage->url ) }}">
		</div>

		<div class="text">
			
			<?php
				if(strlen($value->product[0]->title) > 26)
					echo mb_substr($value->product[0]->title, 0, 27, "utf-8")."...";
				else
					print $value->product[0]->title;
			?>
		</div>
		</div>
	</a>
		
			<br>			
	</div>

	@if($key % 3 == 0 and $key!=0)
	</div>
	@endif


@endforeach