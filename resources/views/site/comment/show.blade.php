@extends('site/layouts/siteLayout')

@section('header')
<link rel="stylesheet" type="text/css" href="{{ url('css/rangeslider.css') }}">
@endsection

@section('content')
	<div class="commenting">
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
				<div style="margin-top: 20px">
					<input type="range" min="0" max="5" step="1" data-rangeslider id="range_1" />
                    <p id="output_range_1"></p>
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
</script>


@endsection