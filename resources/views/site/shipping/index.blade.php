@extends('site/layouts/siteLayout')

@section('header')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
@endsection

@section('content')

<div class="shipping-steps">

	<div class="shipping-steps-dash">
		<div style="margin-right: 25px"></div>
		<div></div>
		<div></div>
		<div></div>
	</div>

	<div class="bullet green tick">
		<span>ورود به دیجی کالا</span>
	</div>

	<div class="shipping-line green-line"></div>


	<div class="bullet green">
		<span>بررسی سفارش</span>
	</div>

	<div class="shipping-line gray-line"></div>

	<div class="bullet grey">
		<span>اطلاعات ارسال</span>
	</div>

	<div class="shipping-line gray-line"></div>

	<div class="bullet grey">
		<span>اطلاعات پرداخت</span>
	</div>

	<div class="shipping-steps-dash-gray">
		<div style="margin-right: 10px"></div>
		<div></div>
		<div></div>
		<div></div>
	</div>
	
</div>

<div style="position: absolute;">
	<br/>
	<br/>
</div>

<div class="shipping-address">

	<div class="add-address">
		<span>آدرس: </span>

		<a href="#" class="btn btn-primary" onclick="add_address()" data-target="#myAddress">
			<i class="fa fa-plus"></i> 
            <span style="font-size: 16px">افزودن آدرس </span>
        </a>
	</div>


</div>



<div class="container">

  <!-- Modal -->
  <div class="modal fade" id="myAddress" role="dialog" style="background-color:transparent !important">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">

        <div class="modal-header"  style="direction: ltr">
          <button type="button" class="close" data-dismiss="modal"></button>
          <h5 class="modal-title" >آدرس</h5>
        </div>

        <div class="modal-body">

        	<select onchange="state_changed()">
			 	<option value="">استان</option>

			 	@if(sizeof($states) > 0)
					@foreach($states as $key_state=>$value_state)
						<option value="{{$value_state->id}}">{{$value_state->name}}</option>
					@endforeach
				@else
					nothing in here
				@endif

			</select>

			<select>
			 	<option value="">شهر</option>			  
			</select> 
    	</div>

      </div>      
    </div>
  </div>
  
</div>



@endsection

@section('footer')

<script type="text/javascript">
	
	add_address = function()
	{
		$('#myAddress').modal('show');
	}

	state_changed = function()
	{
		alert(1);
	}

</script>

@endsection