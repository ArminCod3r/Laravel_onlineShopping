<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ url('plugins/font-awesome/css/font-awesome.min.css') }}">
  <script src='{{ url("js/fontAwesomKit.js") }}'></script>  <!--source: https://www.w3schools.com/icons/fontawesome_icons_webapp.asp-->
  
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ url('dist/css/adminlte.min.css') }}">
  
  <!-- iCheck -->
  <link rel="stylesheet" href="{{ url('plugins/iCheck/flat/blue.css') }}">
  
  <!-- Morris chart -->
  <link rel="stylesheet" href="{{ url('plugins/morris/morris.css') }}">
  
  <!-- jvectormap -->
  <link rel="stylesheet" href="{{ url('plugins/jvectormap/jquery-jvectormap-1.2.2.css') }}">
  
  <!-- Date Picker -->
  <link rel="stylesheet" href="{{ url('plugins/datepicker/datepicker3.css') }}">
  
  <!-- Daterange picker -->
  <link rel="stylesheet" href="{{ url('plugins/daterangepicker/daterangepicker-bs3.css') }}">
  
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="{{ url('plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css') }}">
  
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  
  <!-- bootstrap rtl -->
  <link rel="stylesheet" href="{{ url('dist/css/bootstrap-rtl.min.css') }}">
  
  <!-- template rtl version -->
  <link rel="stylesheet" href="{{ url('dist/css/custom-style.css') }}">
  
  <!-- Custom CSS -->
  <link rel="stylesheet" type="text/css" href="{{ url('css/admin.css') }}">

  @yield('header')
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand bg-white navbar-light border-bottom">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fa fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="index3.html" class="nav-link">خانه</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">تماس</a>
      </li>
    </ul>

    <!-- SEARCH FORM -->
    <form class="form-inline ml-3">
      <div class="input-group input-group-sm">
        <input class="form-control form-control-navbar" type="search" placeholder="جستجو" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-navbar" type="submit">
            <i class="fa fa-search"></i>
          </button>
        </div>
      </div>
    </form>

    <!-- Right navbar links -->
    <ul class="navbar-nav mr-auto">
      <!-- Messages Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="fa fa-comments-o"></i>
          <span class="badge badge-danger navbar-badge">3</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-left">
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="{{ url('dist/img/user1-128x128.jpg') }}" alt="User Avatar" class="img-size-50 ml-3 img-circle">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  حسام موسوی
                  <span class="float-left text-sm text-danger"><i class="fa fa-star"></i></span>
                </h3>
                <p class="text-sm">با من تماس بگیر لطفا...</p>
                <p class="text-sm text-muted"><i class="fa fa-clock-o mr-1"></i> 4 ساعت قبل</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="dist/img/user8-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle ml-3">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  پیمان احمدی
                  <span class="float-left text-sm text-muted"><i class="fa fa-star"></i></span>
                </h3>
                <p class="text-sm">من پیامتو دریافت کردم</p>
                <p class="text-sm text-muted"><i class="fa fa-clock-o mr-1"></i> 4 ساعت قبل</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="dist/img/user3-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle ml-3">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  سارا وکیلی
                  <span class="float-left text-sm text-warning"><i class="fa fa-star"></i></span>
                </h3>
                <p class="text-sm">پروژه اتون عالی بود مرسی واقعا</p>
                <p class="text-sm text-muted"><i class="fa fa-clock-o mr-1"></i>4 ساعت قبل</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">مشاهده همه پیام‌ها</a>
        </div>
      </li>
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="fa fa-bell-o"></i>
          <span class="badge badge-warning navbar-badge">15</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-left">
          <span class="dropdown-item dropdown-header">15 نوتیفیکیشن</span>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fa fa-envelope ml-2"></i> 4 پیام جدید
            <span class="float-left text-muted text-sm">3 دقیقه</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fa fa-users ml-2"></i> 8 درخواست دوستی
            <span class="float-left text-muted text-sm">12 ساعت</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fa fa-file ml-2"></i> 3 گزارش جدید
            <span class="float-left text-muted text-sm">2 روز</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">مشاهده همه نوتیفیکیشن</a>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#"><i
                class="fa fa-th-large"></i></a>
      </li>

      <li class="nav-item">
        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
            {{ Auth::user()->username }}
            <span class="caret"></span>
        </a>

        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-left" aria-labelledby="navbarDropdown" style="width:50%">
            <a class="dropdown-item" href="{{ route('logout') }}"
               onclick="event.preventDefault();
                             document.getElementById('logout-form').submit();">
                {{ __('Logout') }}
            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </div>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <img src="{{ url('dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">پنل مدیریت</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar" style="direction: ltr">
      <div style="direction: rtl">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div class="image">
            <img src="{{ url('images/avatar.png') }}" class="img-circle elevation-2" alt="User Image">
          </div>
          <div class="info">
            <a href="#" class="d-block">username</a>
          </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
                 with font-awesome or any other icon font library -->
            <li class="nav-item has-treeview">
              <a href="/admin/" class="nav-link active">
                <i class="nav-icon fa fa-home"></i>
                <p>
                  خانه
                  <i class="right"></i>
                </p>
              </a>              
            </li>

            
            <li class="nav-item has-treeview" id="products">
              <a href="#" class="nav-link">
                <i class="nav-icon fa fa-cart-plus"></i>
                <p>
                  محصول
                  <i class="right fa fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="/admin/product#products" class="nav-link">
                    <i class="fa fa-circle-o nav-icon"></i>
                    <p>لیست محصولات</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="/admin/product/create#products" class="nav-link">
                    <i class="fa fa-circle-o nav-icon"></i>
                    <p>افزودن محصول</p>
                  </a>
                </li>
                
              </ul>
            </li>
            <li class="nav-item has-treeview" id="slider">
              <a href="#" class="nav-link">
                <i class="nav-icon fa fa-tree"></i>
                <p>
                  اسلاید
                  <i class="fa fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{ url('admin/slider#slider') }}" class="nav-link">
                    <i class="fa fa-circle-o nav-icon"></i>
                    <p>لیست اسلاید ها</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ url('admin/slider/create#slider') }}" class="nav-link">
                    <i class="fa fa-circle-o nav-icon"></i>
                    <p>افزودن اسلایدر</p>
                  </a>
                </li>
              </ul>
            </li>
            <li class="nav-item has-treeview" id="category">
              <a href="#" class="nav-link">
                <i class="nav-icon fa fa-edit"></i>
                <p>
                  مدیریت دسته ها
                  <i class="fa fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="/admin/category#category" class="nav-link">
                    <i class="fa fa-circle-o nav-icon"></i>
                    <p>لیست دسته ها</p>
                  </a>
                </li>

                <li class="nav-item">
                  <a href="/admin/category/create#category" class="nav-link">
                    <i class="fa fa-circle-o nav-icon"></i>
                    <p>افزودن دسته</p>
                  </a>
                </li>
              </ul>
            </li>
            <li class="nav-item has-treeview" id="amazing_products">
              <a href="#" class="nav-link">
                <i class="nav-icon fa fa-bolt"></i>
                <p>
                  محصولات شگفت انگیز
                  <i class="fa fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{ url('admin/amazing_products#amazing_products') }}" class="nav-link">
                    <i class="fa fa-circle-o nav-icon"></i>
                    <p>لیست</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ url('admin/amazing_products/create#amazing_products') }}" class="nav-link">
                    <i class="fa fa-circle-o nav-icon"></i>
                    <p>افزودن</p>
                  </a>
                </li>
              </ul>
            </li>


            <li class="nav-item has-treeview" id="review">
              <a href="#" class="nav-link">
                <i class="nav-icon fa fa-search-plus"></i>
                <p>
                  نقد و بررسی
                  <i class="fa fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{ url('admin/review#review') }}" class="nav-link">
                    <p>لیست</p>
                  </a>
                </li>
              </ul>
            </li>


            <li class="nav-item has-treeview" id="filter">
              <a href="#" class="nav-link">
                <i class="nav-icon fa fa-filter"></i>
                <p>
                  فیلتر ها
                  <i class="fa fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="#" class="nav-link">
                    <p>لیست (در دست ساخت)</p>
                  </a>
                </li>
              </ul>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{ url('admin/filter#filter') }}" class="nav-link">
                    <p>افزودن</p>
                  </a>
                </li>
              </ul>
            </li>


            <li class="nav-item has-treeview" id="feature">
              <a href="#" class="nav-link">
                <i class="nav-icon fa fa-newspaper-o"></i>
                <p>
                  مشخصات محصولات
                  <i class="fa fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{ url('admin/feature/list#feature') }}" class="nav-link">
                    <p>لیست</p>
                  </a>
                </li>
              </ul>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{ url('/admin/feature/#feature') }}" class="nav-link">
                    <p>افزودن</p>
                  </a>
                </li>
              </ul>
            </li>


            <li class="nav-item has-treeview" id="state">
              <a href="#" class="nav-link">
                <i class="nav-icon fa fa-compass"></i>
                <p>
                  استان
                  <i class="fa fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{ url('admin/state#state') }}" class="nav-link">
                    <p>لیست</p>
                  </a>
                </li>
              </ul>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{ url('admin/state/create#state') }}" class="nav-link">
                    <p>افزودن</p>
                  </a>
                </li>
              </ul>
            </li>


            <li class="nav-item has-treeview" id="city">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-city"></i>
                <p>
                  شهر
                  <i class="fa fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{ url('admin/city#city') }}" class="nav-link">
                    <p>لیست</p>
                  </a>
                </li>
              </ul>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{ url('admin/city/create#city') }}" class="nav-link">
                    <p>افزودن</p>
                  </a>
                </li>
              </ul>
            </li>


            <li class="nav-item has-treeview" id="order">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-reorder"></i>
                <p>
                  سفارش ها
                  <i class="fa fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{ url('admin/order#order') }}" class="nav-link">
                    <p>لیست</p>
                  </a>
                </li>
              </ul>
            </li>


            <li class="nav-item has-treeview" id="user">
              <a href="#" class="nav-link">
                <i class="nav-icon fa fa-user"></i>
                <p>
                  کاربران
                  <i class="fa fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{ url('admin/user#user') }}" class="nav-link">
                    <p>لیست</p>
                  </a>
                </li>
              </ul>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{ url('admin/user/create#user') }}" class="nav-link">
                    <p>افزودن</p>
                  </a>
                </li>
              </ul>
            </li>


            <li class="nav-item has-treeview" id="stat">
              <a href="{{ url('admin/stat#stat') }}" class="nav-link">

                <i class="nav-icon fa fa-line-chart"></i>
                <p>
                  آمار بازدید سایت
                </p>

              </a>
            </li>


            <li class="nav-item has-treeview" id="comment">
              <a href="#" class="nav-link">
                <i class="nav-icon far fa-comment"></i>
                <p>
                  نظرات کاربران
                  @if( $unapproved_comments )
                    <span> ({{ $unapproved_comments }}) </span>
                  @endif
                  <i class="fa fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="#" class="nav-link">
                    <p>لیست</p>
                  </a>
                </li>
              </ul>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{ url('admin/comment#comment') }}" class="nav-link">
                    <p>تایید نشده</p>
                  </a>
                </li>
              </ul>
            </li>

            
        </nav>
        <!-- /.sidebar-menu -->
      </div>
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">
              @yield('custom-title')
            </h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-left">
              <li class="breadcrumb-item"><a href="#">خانه</a></li>
              <li class="breadcrumb-item active">داشبورد ورژن 2</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        @yield('stat-box')
        <!-- /.row -->
        <!-- Main row -->
        <div class="row">
          <!-- Left col -->
          
            <!-- Custom tabs (Charts with tabs)-->
            @yield('content1')
            <!-- /.card -->

            <!-- DIRECT CHAT -->
            @yield('content2')
            <!--/.direct-chat -->

            <!-- TO DO List -->
            @yield('content3')
            <!-- /.card -->
          </section>
          <!-- /.Left col -->
          <!-- right col (We are only adding the ID to make the widgets sortable)-->
          

            <!-- Map card -->
            @yield('content4')
            <!-- /.card -->

            <!-- solid sales graph -->
            @yield('content5')
            <!-- /.card -->

            <!-- Calendar -->
            @yield('content6')
            <!-- /.card -->

          </section>
          <!-- right col -->
        </div>
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer" dir="rtl">
    <strong>Copyright &copy; 2018 <a href="https://github.com/ArminCod3r">Armin</a>.</strong>
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="{{ url('plugins/jquery/jquery.min.js') }}"></script>
<!-- jQuery UI 1.11.4 -->
<!-- >> <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js') }}"></script>-->
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="{{ url('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- Morris.js charts -->
<!-- >> <script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>-->
<script src="{{ url('plugins/morris/morris.min.js') }}"></script>
<!-- Sparkline -->
<script src="{{ url('plugins/sparkline/jquery.sparkline.min.js') }}"></script>
<!-- jvectormap -->
<script src="{{ url('plugins/jvectormap/jquery-jvectormap-1.2.2.min.js') }}"></script>
<script src="{{ url('plugins/jvectormap/jquery-jvectormap-world-mill-en.js') }}"></script>
<!-- jQuery Knob Chart -->
<script src="{{ url('plugins/knob/jquery.knob.js') }}"></script>
<!-- daterangepicker -->
<!-- >> <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>-->
<script src="{{ url('plugins/daterangepicker/daterangepicker.js') }}"></script>
<!-- datepicker -->
<script src="{{ url('plugins/datepicker/bootstrap-datepicker.js') }}"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="{{ url('plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js') }}"></script>
<!-- Slimscroll -->
<script src="{{ url('plugins/slimScroll/jquery.slimscroll.min.js') }}"></script>
<!-- FastClick -->
<script src="{{ url('plugins/fastclick/fastclick.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ url('dist/js/adminlte.js') }}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{ url('dist/js/pages/dashboard.js') }}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ url('dist/js/demo.js') }}"></script>


<script>

  // Keeping the selected nav-bar open
  document.addEventListener('DOMContentLoaded', function() {

        $(window.location.hash).addClass('menu-open');
    }, false);

</script>


@yield('footer')

</body>
</html>
