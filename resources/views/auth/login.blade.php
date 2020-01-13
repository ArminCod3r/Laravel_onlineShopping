@extends('site/layouts/siteLayout')

@section('header')
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

@endsection

@section('content')
<div class="container">

    <div class="row justify-content-center">

        <div class="col-sm-6 login-box-right">
            <div class="login-area">
                <div class="icon"></div>
                <p>عضو دیجی آنلاین هستید</p>
                <p> برای تکمیل فرآیند خود وارد شوید </p>
                <a href="#" class="btn btn-primary" onclick="if_loggedin()" data-toggle="modal" data-target="#myModal">
                    ورود به دیجی آنلاین
                </a>
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


<div class="container">

  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog" style="background-color:transparent !important">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header"  style="direction: ltr">
          <button type="button" class="close" data-dismiss="modal"></button>
          <h4 class="modal-title" >ورود به دیجی آنلاین</h4>
        </div>
        <div class="modal-body">
          <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-group register_name">
                    <label> شماره همراه یا پست الکترونیکی : </label>
                    <input type="text" class="form-control" name="username" id="username" placeholder="Phone number or Email" value="{{ old('username') }}" autofocus/>

                    @if($errors->has('username'))
                        <span class="has_error"> {{ $errors->first('username') }} </span>
                    @endif
                </div>

                <div class="form-group register_name">
                    <label> کلمه عبور : </label>
                    <input type="password" class="form-control" name="password_" id="password_"/>

                    @error('password_')
                        <span class="has_error" role="alert">
                            {{ $message }}
                        </span>
                    @enderror
                </div>


                <div class="form-group captcha">
                    <img src="{{ url('captcha') }}">
                    <input type="text" class="form-control" name="captcha" id="captcha" placeholder="کد امنیتی بالا را وارد کنید"/>

                    @if($errors->has('captcha'))
                        <span class="has_error"> {{ $errors->first('captcha') }} </span>
                    @endif
                </div>


                <div class="form-group">

                    <div class="row">

                        <div class="col-sm-6">
                            <p class="icon_login">
                                <span class="fa fa-sign-in fa-rotate-180" style="color: #18838f"></span>
                            </p>                            
                            <input type="submit" class="register_btn" value="ورود"/>
                        </div>

                        <div class="col-sm-6">
                            <div class="modal-exit-btn">
                                <button type="button" class="btn btn-default" data-dismiss="modal">خروج</button>
                            </div>
                            
                        </div>
                    </div>

                    
                    
                </div>

            </form>
        </div>
      </div>
      
    </div>
  </div>
  
</div>


@endsection

@section('footer')

    <script type="text/javascript">

        <?php $url=url('if_loggedin') ?>

        if_loggedin = function(product_id, color_id, operation, price)
        {
            $.ajaxSetup(
                            {
                                'headers':
                                {
                                    'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
                                }
                            }
                        );
            
            $.ajax(
                    {

                        'url': '{{ $url }}',
                        'type': 'post',
                        success:function(data)
                        {
                            if(data == 'no')
                                $('#myModal').modal('show');

                            if(data == 'yes')
                                document.location = window.location.origin+"/";
                        }

                    }
              );

        }
    </script>

    @if($errors->any())
        <script>
            $('#myModal').modal('show');
        </script>
    @endif

@endsection
