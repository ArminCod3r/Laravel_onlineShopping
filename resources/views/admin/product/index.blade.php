@extends('admin/layouts/adminLayout')


@section('header')
    <title>لیست محصولات</title>
    <style type="text/css">
    .modal {
       position: absolute;
       top: 10px;
       right: 100px;
       bottom: 0;
       left: 0;
       z-index: 10040;
       overflow: auto;
       overflow-y: auto;
    }


    .modal-header .close {
      margin: 0;
      position: absolute;
      top: -10px;
      right: -10px;
      width: 23px;
      height: 23px;
      border-radius: 23px;
      background-color: #00aeef;
      color: #ffe300;
      font-size: 18px;
      opacity: 1;
      z-index: 50;
    }
    .modal-header .close, .modal-header .mailbox-attachment-close{
        padding:0rem;
    }

    .dotStyle{
      height: 15px;
      width: 15px;
      background-color: #bbb;
      border-radius: 50%;
      display: inline-block;
      margin: 0px;
      padding: 0px;
    }

    .submitStyle{
      background-color: Transparent;
      background-repeat:no-repeat;
      border: none;
      cursor:pointer;
      overflow: hidden;
      outline:none;
      color: red;
      font-weight: bold;
    }
</style>
@endsection

@section('custom-title')
  لیست محصولات
@endsection

@section('content1')
<a href="{{ url('admin/product/create') }}" class="btn btn-success"> افزودن محصول </a>
<br><br>

<form action="{{ url('admin/product') }}" id="list_form">
    <table class="table table-hover" dir="rtl" style="white-space: nowrap;">
        <thead>
          <tr>
            <th>نام</th>
            <th>عملیات</th>
            <th>متن</th>
            <th>نام لاتین</th>
            <th>رنگها</th>
            <th>قیمت</th>
            <th>تخفیف</th>
            <th>بازدید</th>
            <th>موجود</th>
            <th>بن</th>
            <th>محصول</th>
            <th>تعداد فروش</th>
            <th>ویژه</th>
          </tr>
        </thead>

        <tr>
            <td colspan="4">
              <input type="text" name="search_product" class="form-control search_input" style="width: 100%; " placeholder="متن سرچ">
              </input>
            </td>

            <td></td>
            <td></td>
        </tr>
         
        <?php $i=1; ?>
        @foreach($products as $item)
            <tr>
                <td> {{ $item->title }} </td>
                <td>
                  <div style="float:left;">
                    <a href="/admin/product/{{ $item->id }}/edit" class="fa fa-edit">  </a>
                  </div>
                	
                	<div style="float:left;">
                  <form></form> <!--if it is not writtern, then first 'X' will not work-->
                  
                	<form action="/admin/product/{{ $item->id }}" method="POST"> <!--stack: 39790082-->

                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}

                        <input type="submit" value="X" class="submitStyle">
                        <!--<a id="submitBtn" class="fa fa-remove" style="color:red; cursor:pointer; margin-left:10px">  </a>-->
                    </form>
                  </div>
                </td>

                <td>
                    <button type="button" class="btn btn-default" data-toggle="modal"
                        onclick="show_text('{{$item->title}}','{{$item->text}}')">
                    <span class="fa fa-twitch"></span>
                    </button>
                </td>

                <td style="text-align: left"> {{ $item->code }} </td>

                <td>
                  @foreach($colors as $key=>$color)
                    @if( $item->id == $color->product_id)                      
                      <input type="text" class="jscolor {valueElement:null,value:'{{ $color->color_code }}'} dotStyle" size="1" >
                    @endif
                  @endforeach
                </td>

                <td> {{ $item->price }} </td>
                <td> 
                    <?php
                        if ($item->price == null)
                          echo 0;
                    ?>
                </td>
                <td> {{ $item->view }} </td>

                <td> 
                	<input type="checkbox" name="product_status"  value="1"
                        <?php if($item->product_status) { echo "checked"; }?> disabled >
                </td>

                <td> {{ $item->bon }} </td>

                <td align="center">
                	<input type="checkbox" name="show_product"  value="1"
                        <?php if($item->show_product) { echo "checked"; }?> disabled >
                </td>

                <td> <center> {{ $item->order_product }} </center> </td>

                <td align="center">
                	<input type="checkbox" name="special"  value="1"
                        <?php if($item->special) { echo "checked"; }?> disabled >
                </td>

            </tr>
            <?php $i++; ?> 
        @endforeach

        @if(sizeof($products)==0)
            <tr>
                <td colspan="4"> <center>رکوردی یافت نشد.</center> </td>
            </tr>
        @endif

    </table>
    

    {{ $products->links() }}
</form>
@endsection

@section('content2')
    <br><br><br><br><br><br>
    <!-- Button trigger modal -->

<!-- Modal -->
<div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">

        <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">بستن</button>
      </div>
    </div>
  </div>
</div>

@endsection

@section('footer')
       <script type="text/javascript" src="{{ url('js/jscolor.js') }}"></script>

	<script type="text/javascript">

		$("#submitBtn").bind('click', function(event) {
		   $("#removeForm").submit();
		});

        show_text = function($id, $text){

            // stack: 27959117
            $("#exampleModalLongTitle").html($id);
            $(".modal-body").html($text);

            $('#exampleModalLong').modal('show'); 
        }

    // When ENTER hit, submit the form
    $('.search_input').on('keydown', function(event){
            if(event.keyCode == 13)
            {
                $('#list_form').submit();
                //document.getElementById("list_form").submit(); 
                //alert('a');
            }
        });
	</script>
@endsection