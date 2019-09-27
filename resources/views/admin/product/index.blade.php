@extends('admin/layouts/adminLayout')


@section('header')
    <title>لیست محصولات</title>
@endsection

@section('custom-title')
  لیست محصولات
@endsection

@section('content1')
<a href="{{ url('admin/products/create') }}" class="btn btn-success"> افزودن اسلاید </a>
<br><br>

    <table class="table table-hover" dir="rtl">
        <thead>
          <tr>
            <th>نام</th>
            <th>نام لاتین</th>
            <th>رنگها</th>
            <th>قیمت</th>
            <th>تخفیف</th>
            <th>بازدید</th>
            <th>موجود</th>
            <th>بن</th>
            <th>نمایش محصول</th>
            <th>تعداد فروش</th>
            <th>پیشنهاد ویژه</th>
          </tr>
        </thead>
         
        <?php $i=1; ?>
        @foreach($products as $item)
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>     
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