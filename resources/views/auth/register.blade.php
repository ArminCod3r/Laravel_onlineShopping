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
                    <input type="text" class="form-control" name="username" placeholder="Phone number or Email" />
                </div>

                <div class="form-group register_name">
                    <label> کلمه عبور : </label>
                    <input type="text" class="form-control" name="password" placeholder="Password" />
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


                <div class="form-group">
                    <input type="submit" class="register_btn" value="ثبت‌نام در دیجی‌کالا" name="password"/>
                </div>

            </form>
        </div>

        <div class="col-sm-6">
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