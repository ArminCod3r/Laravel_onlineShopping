@extends('site/layouts/siteLayout')

@section('content')
<div class="container">

    <div class="row justify-content-center">

        <div class="col-sm-6 login-box-right">
            <div class="login-area">
                <div class="icon"></div>
                <p>عضو دیجی آنلاین هستید</p>
                <p> برای تکمیل فرآیند خود وارد شوید </p>
                <a href="{{url('login')}}" class="btn btn-primary">ورود به دیجی آنلاین</a>
            </div>
        </div>

        <div class="col-sm-6 register-box-left">
            <div class="register-area">
                <div class="icon"></div>
                <p style="fontweight: bold">تازه وارد هستید</p>
                <p> برای تکمیل فرآیند خود ثبت نام کنید. </p>
                <a href="{{url('register')}}" class="btn btn-success">ثبت نام در دیجی آنلاین</a>

                <p style="padding-top: 25px;width: 80%; textalign: center;margin: 0 auto;">
                    با عضویت در دیجیکالا تجربه متفاوتی از خرید اینترنتی داشته باشید. وضعیت سفارش خود را پیگیری نموده و سوابق خریدتان را مشاهده کنید.
                </p>
            </div>
        </div>


    </div>
</div>
@endsection

@section('footer')

    <script type="text/javascript">

    </script>

@endsection
