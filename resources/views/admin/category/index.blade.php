@extends('admin/layouts/adminLayout')


@section('header')
    <title>افزودن دسته</title>
    <link rel="stylesheet" type="text/css" href="{{ url('css/bootstrap-select.css') }}">
    <style type="text/css">
        .bootstrap-select .dropdown-toggle .filter-option{
            text-align:right;
        }

        .bootstrap-select:not([class*="col-"]):not([class*="form-control"]):not(.input-group-btn){
            width:100%;
        }
    </style>
@endsection

@section('custom-title')
  لیست دسته ها
@endsection


@section('content1')
<section class="col-lg-7 connectedSortable">

<a href="{{ url('admin/category/create') }}" class="btn btn-success"> افزودن دسته </a>
<br><br>

<form action="{{ url('admin/category') }}" id="list_form">
    <table class="table table-hover" dir="rtl">
        <thead>
          <tr>
            <th>ردیف</th>
            <th>نام دسته</th>
            <th>نام لاتین دسته</th>
            <th>دسته والد</th>
            <th>عملیات</th>
            <th></th>
          </tr>
        </thead>

        <tr>
            <td></td>
            <td> <input type="text" value="@if(Request::get('cat_name')){{Request::get('cat_name')}} @endif" name="cat_name" class="form-control search_input" style="width: 100px"></input> </td>
            <td> <input type="text" name="cat_ename" class="form-control search_input" style="width: 100px"></input> </td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
         
        <?php $i=1; ?>
        @foreach($categories as $item)
            <tr>
                <td>{{ $i }}</td>
                <td>{{ $item->cat_name }}</td>
                <td>{{ $item->cat_ename }}</td>     
                <td>{{ $item->getParent->cat_name }}</td>       
                <td>
                    <a href="category/{{ $item->id }}/edit" class="btn btn-default"> ویرایش </a>
                </td>

                <td>
                    <form action="{{ action('admin\CategoryController@destroy', ['id' => $item->id]) }}" method="POST"  accept-charset="utf-8" class="pull-right"  onsubmit="return confirm('آیا قصد حذف این دسته را دارید؟')"> <!--stack: 39790082-->
                        {{ csrf_field() }}      
                        <input type="hidden" name="_method" value="DELETE">
                        <input type="submit" name="submit" value="حذف" class="btn btn-default">
                    </form>
                
                </td>     
            </tr>
            <?php $i++; ?> 
        @endforeach

        @if(sizeof($categories)==0)
            <tr>
                <td colspan="5"> <center>رکوردی یافت نشد.</center> </td>
            </tr>
        @endif

    </table>
    

    {{ $categories->links() }}

</form>
@endsection

@section('content2')
    <br><br><br><br><br><br>
@endsection

@section('content')
<section class="col-lg-5 connectedSortable">
@endsection

@section('footer')
    <script type="text/javascript" src="{{ url('js/bootstrap-select.js') }}"></script>
    <script type="text/javascript" src="{{ url('js/defaults-fa_IR.js') }}"></script>

    <script>

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