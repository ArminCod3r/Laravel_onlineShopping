@if( sizeof($products) > 0 )

	<div style="text-align: center;background:white;margin: 5px 0px 5px 0px;border-radius: 5px;">
		{!! $products->links() !!}
	</div>
@endif

@foreach($products as $key=>$value)

	@if($key % 4 == 0)
	<div class="row products_list" style="height: 300px;">
	@endif

	<a href="/product/{{$value->code}}/{{$value->title_url}}">
		<div class="col-3 col-sm-3 col-md-3 col-lg-3 col-xl-3" style="height:750px; width: 244px">
		<div class="product_area">
			<div class="img">
			<img style="width: 48%" src="{{ url('/upload/'. $images[$value->product_id]->url ) }}">
		</div>

		<div class="text">
			
			<?php
				if(strlen($value->title) > 26)
					echo mb_substr($value->title, 0, 27, "utf-8")."...";
				else
					print $value->title;
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
