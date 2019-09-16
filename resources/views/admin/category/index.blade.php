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
 <table class="table table-hover" dir="rtl">
    <thead>
      <tr>
        <th>ردیف</th>
        <th>نام دسته</th>
        <th>نام لاتین دسته</th>
        <th>دسته والد</th>
        <th>عملیات</th>
      </tr>
    </thead>
     
    <?php $i=1; ?>
    @foreach($categories as $item)
        <tr>
            <td>{{ $i }}</td>
            <td>{{ $item->cat_name }}</td>
            <td>{{ $item->cat_ename }}</td>     
            <td>{{ $item->getParent->cat_name }}</td>       
            <td> ویرایش | حذف </td>     
        </tr>
        <?php $i++; ?> 
    @endforeach
</table>

@endsection

@section('content2')
    <br><br><br><br><br><br>
@endsection

@section('footer')
    <script type="text/javascript" src="{{ url('js/bootstrap-select.js') }}"></script>
    <script type="text/javascript" src="{{ url('js/defaults-fa_IR.js') }}"></script>

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

    </script>
@endsection