@extends('site/layouts/siteLayout')

@section('content')
<div class="container register">

    <div class="register_header">
        ثبت نام در دیجیکالا
    </div>
    <div class="row justify-content-center">

        <div class="col-sm-6" style="background-color: white; border-radius: 5px">
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="form-group register_name">
                    <label> شماره همراه یا پست الکترونیکی : </label>
                    <input type="text" class="form-control" name="username" id="username" placeholder="Phone number or Email" value="{{ old('username') }}" />

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

                <div class="form-group" style="padding-top: 10px">
                    <div class="row">

                        <div class="col-sm-1">
                        </div>

                        <div class="col-sm-1">
                            <input type="checkbox" value="1" name="privacy_check" id="privacy_check" checked="checked">
                        </div>

                        <div class="col-sm-9">
                            <label onclick="privacy_checkbox()">
                                حریم خصوصی و شرایط و قوانین استفاده از سرویس های سایت دیجی‌کالا را مطالعه نموده و با کلیه موارد آن موافقم.
                            </label>
                        </div>

                        <div class="col-sm-1">
                        </div>
                    </div>
                </div>



                <div class="form-group captcha">
                    <img src="{{ url('captcha') }}">
                    <input type="text" class="form-control" name="captcha" id="captcha" placeholder="کد امنیتی بالا را وارد کنید"/>

                    @if($errors->has('captcha'))
                        <span class="has_error"> {{ $errors->first('captcha') }} </span>
                    @endif
                </div>


                <div class="form-group">
                    <input type="submit" class="register_btn" value="ثبت‌نام در دیجی‌کالا" name="password"/>
                </div>

            </form>
        </div>

        <div class="col-sm-6 register-icon-box">

            <div class="icon login-icon">                
            </div>

            <li class="list-inline" style="margin-top: 10%">
                <ul>
                    <span class="icon icon-userbox-cart"></span>
                    <span>سریع تر و ساده تر خرید کنید.</span>
                </ul>

                <ul>
                    <span class="icon icon-userbox-list"></span>
                    <span>به سادگی سوابق خرید و فعالیت های خود را مدیریت کنید.</span>
                </ul> 
                
                <ul>
                    <span class="icon icon-userbox-love"></span>
                    <span>لیست علاقه مندی های خود را بسازید و تغییرات آنها را دنبال کنید.</span>
                </ul> 
                
                <ul>
                    <span class="icon icon-userbox-comment"></span>
                    <span>نقد و بررسی و نظرات خود را با دیگران به اشتراک بگذارید</span>
                </ul>
            </li>

        </div>

        
    </div>
</div>
@endsection

@section('footer')

    <script type="text/javascript">

        privacy_checkbox = function()
        {
            if(document.getElementById("privacy_check").checked)
                document.getElementById("privacy_check").checked = false;
            else
                document.getElementById("privacy_check").checked = true;
        }

    </script>

@endsection