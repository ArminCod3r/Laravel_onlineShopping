@extends('admin/layouts/adminLayout')


@section('header')
    <title>لیست اسلاید ها</title>
@endsection

@section('custom-title')
  لیست اسلاید ها
@endsection


@section('content1')
<a href="{{ url('admin/slider/create') }}" class="btn btn-success"> افزودن اسلاید </a>
<br><br>

    <table class="table table-hover" dir="rtl">
        <thead>
          <tr>
            <th>ردیف</th>
            <th>عوان اسلاید</th>
            <th>تصویر اسلاید</th>
            <th>آدرس اسلاید</th>
            <th>عملیات</th>
          </tr>
        </thead>
         
        <?php $i=1; ?>
        @foreach($sliders as $item)
            <tr>
                <td>{{ $i }}</td>
                <td>{{ $item->title }}</td>
                <td> <img src="{{ url('upload/'.$item->img) }}" style="width: 80%"> </td>
                <td>{{ $item->url }}</td>     
                <td>
                    <a href="slider/{{ $item->id }}/edit" class="btn btn-default"> ویرایش </a>
                </td>

                <td>
                    <form action="{{ action('admin\SliderController@destroy', ['id' => $item->id]) }}" method="POST"  accept-charset="utf-8" class="pull-right"  onsubmit="return confirm('آیا قصد حذف این دسته را دارید؟')"> <!--stack: 39790082-->
                        {{ csrf_field() }}      
                        <input type="hidden" name="_method" value="DELETE">
                        <input type="submit" name="submit" value="حذف" class="btn btn-default">
                    </form>
                
                </td>     
            </tr>
            <?php $i++; ?> 
        @endforeach

        @if(sizeof($sliders)==0)
            <tr>
                <td colspan="5"> <center>رکوردی یافت نشد.</center> </td>
            </tr>
        @endif

    </table>
    

    {{ $sliders->links() }}

@endsection

@section('content2')
    <br><br><br><br><br><br>
@endsection

@section('footer')
@endsection