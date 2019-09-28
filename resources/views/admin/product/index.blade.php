@extends('admin/layouts/adminLayout')


@section('header')
    <title>لیست محصولات</title>
@endsection

@section('custom-title')
  لیست محصولات
@endsection

@section('content1')
<a href="{{ url('admin/products/create') }}" class="btn btn-success"> افزودن محصول </a>
<br><br>

    <table class="table table-hover" dir="rtl" style="white-space: nowrap;">
        <thead>
          <tr>
            <th>نام</th>
            <th>عملیات</th>
            <th>نام لاتین</th>
            <th>رنگها</th>
            <th>قیمت</th>
            <th>تخفیف</th>
            <th>بازدید</th>
            <th>موجود</th>
            <th>بن</th>
            <th>محصول</th>
            <th>تعداد فروش</th>
            <th>پیشنهاد ویژه</th>
          </tr>
        </thead>
         
        <?php $i=1; ?>
        @foreach($products as $item)
            <tr>
                <td> {{ $item->title }} </td>
                <td>
                	<a href="slider/{{ $item->id }}/edit" class="fa fa-edit">  </a>
                	
                	<form action="{{ action('admin\SliderController@destroy', ['id' => $item->id]) }}" method="POST"  accept-charset="utf-8" class="pull-right"  onsubmit="return confirm('آیا قصد حذف این دسته را دارید؟')" id="removeForm"> <!--stack: 39790082-->
                        {{ csrf_field() }}      
                        <input type="hidden" name="_method" value="DELETE">
                        <a id="submitBtn" class="fa fa-remove" style="color:red; cursor:pointer; margin-left:10px">  </a>
                    </form>

                </td>
                <td> {{ $item->code }} </td>
                <td></td>
                <td> {{ $item->price }} </td>
                <td> {{ $item->discount }} </td>
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

@endsection

@section('content2')
    <br><br><br><br><br><br>
@endsection

@section('footer')
	<script type="text/javascript">
		$("#submitBtn").bind('click', function(event) {
		   $("#removeForm").submit();
		});
	</script>
@endsection