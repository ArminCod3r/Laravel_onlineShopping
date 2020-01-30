<html>
   
   <head>
      <title> ورود به بخش مدیریت </title>
      
     <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- font awesome -->
    <link rel="stylesheet" href="{{ url('css/font-awesome.css') }}">

    <!-- bootstrap + bootstrap rtl (NOTE: PRIORITY IS IMPORTANT) -->
    <link rel="stylesheet" href="{{ url('css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ url('dist/css/bootstrap-rtl.min.css') }}">

    <!-- Frontend CSS-->
    <link rel="stylesheet" type="text/css" href="{{ url('css/frontend.css') }}">

    <!-- jQuery -->
    <script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>

    <meta name="csrf-token" content="{{ csrf_token() }}">
      
   </head>
   
   <body class="admin_login">

      <div class="form_area">

         <div class="title">
            <span> ورود به بخش مدیریت </span>
         </div>

         <form method="POST" action="{{ route('login') }}">
             @csrf

             <div class="form-group register_name">
                 <label> نام کاربری : </label>
                 <input type="text" class="form-control" name="username" id="username" placeholder="Phone number or Email" value="{{ old('username') }}" autofocus/>

                 @if($errors->has('username'))
                     <span class="has_error"> {{ $errors->first('username') }} </span>
                 @endif
             </div>

             <div class="form-group register_name">
                 <label> کلمه عبور : </label>
                 <input type="password" class="form-control" name="password" id="password"/>


                 @if($errors->has('password'))
                     <span class="has_error"> {{ $errors->first('password') }} </span>
                 @endif
             </div>

             <div class="form-group row">
                 <div class="col-md-6 offset-md-4">
                     <div class="form-check">
                         <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                         <label class="form-check-label" for="remember">
                             {{ __('مرا به خاطر بسپار') }}
                         </label>
                     </div>
                 </div>
             </div>


             <div class="form-group" style="width: 80%; margin: auto;">

                 <div class="row">

                     <div class="col-sm-6">
                         <p class="icon_login">
                             <span class="fa fa-sign-in fa-rotate-180" style="color: #18838f"></span>
                         </p>                            
                         <input type="submit" class="register_btn" value="ورود"/>
                     </div>

                     <div class="col-sm-6">
                         <div class="modal-exit-btn">
                             <button type="button" class="btn btn-primary" data-dismiss="modal">خروج</button>
                         </div>

                     </div>
                 </div>

                 
                 
             </div>

         </form>
      </div>

   </body>
</html>