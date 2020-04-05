
<!doctype html>
<html lang="en">
  <head>
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

    @yield('header')


    <title>فروشگاه اینترنتی دیجی کالا</title>

    <script type="text/javascript">
      var cat_array = new Array();
    </script>

    <style type="text/css">
      .menu a
      {
          color: inherit;
          text-decoration: none;
      }
    </style>
  </head>
  <body>

  <div class="container-fluid header">
    <div class="container">

      <div class="row">

        <div class="col-md-9 col-sm-9">

          <ul class="list-inline">

            <li class="list-inline-item"> 
                <span class="fa fa-lock"></span>
                <span>فروشگاه اینترنتی دیجی کالا</span>

                @if(Auth::check())
                  <span style="margin-right: 20px"> {{ Auth::user()->username }} </span>
                @else
                  <span> <a href="/login">وارد شوید</a> </span>
                @endif
            </li>

            @if(!Auth::check())
              <li class="list-inline-item">
                <span class="fa fa-user" ></span>
                <span> <a href="/regsiter">ثبت نام </a> </span>
              </li>
            @endif

            <li class="list-inline-item">
              <span class="fa fa-gift" ></span>
              <span> <a href="/gift"> کارت هدیه </a> </span>
            </li>

          </ul>

          <ul class="list-inline">

            <li class="list-inline-item">

              <a href="{{ url('cart') }}">
                <div class="btn-shopping-cart">

                <div class="shopping-cart-icon">
                  <span class="fa fa-shopping-cart"></span>
                </div>
                
                <div class="shopping-cart-text">
                  <span style="float: right;">سبد خرید</span>
                  <span class="items-count-in-shopping-cart" id="items-count-in-shopping-cart">0</span>
                </div>

              </div>
              </a>

            </li>

            <li class="list-inline-item">              

              <div class="list-inline-item searching-box">
                <div class="input-group">

                  <span class="fa fa-search seach-btn"></span>
                  <input type="text" class="form-control search-input" placeholder=" … جستجو در دیجی‌کالا">

                </div>
              </div>

            </li>

          </ul>

        </div>

        <div class="col-md-3 col-sm-3">
          <a href=" {{ url('/') }} ">
            <img src="{{ url('/images/logo.png') }}" class="logo">
          </a>
        </div>
        
      </div>

    </div>
  </div>


<div class="container-fluid menu">

  <ul class="list-inline level1-ul">

    <?php $shown_item=0; $category_items=0; ?>
    <!-- Level 1 -->
    @foreach($categories as $key_L1=>$value_L1)      

      @if($value_L1['parent_id'] == '0')

          <li class="list-inline-item level1-li" id="level1-li" value="{{$key_L1}}">
            {{$value_L1['cat_name']}}    

          <span class="fa fa-chevron-down" id="level1-li-{{$key_L1}}"></span>

            <ul class="list-inline level2-ul" id="level2-ul">

              <!-- Level 2 -->
              @foreach($categories as $key_L2=>$value_L2)

                  @if( $value_L2['parent_id'] == $value_L1['id'] )
                      
                          <li class="list-inline-item level2-li">
                          <span>{{$value_L2['cat_name']}}</span> <!-- style="color:#16C1F3" -->

                          <ul class="level3-ul main" id="level3-ul">

                            <!-- Level 3/4 (level4: will be shown on the area as the level3)-->
                            @foreach($categories as $key_L3=>$value_L3)
                                @if( $value_L3['parent_id'] == $value_L2['id'] )
                                    
                                    <div>
                                      <li class="level3-li">

                                        <!-- Header -->
                                            <span style="color:#16C1F3">
                                                <a href="{{ '/search/'.$value_L1['cat_ename'].'/'.$value_L2['cat_ename'].'/'.$value_L3['cat_ename']}}">
                                                  {{$value_L3['cat_name']}}
                                                </a>
                                            </span>
                                            <?php $shown_item++; ?>
                                            <?php $category_items++; ?>

                                        <!-- Content -->
                                        @foreach($categories as $key_L4=>$value_L4)
                                              @if( $value_L4['parent_id'] == $value_L3['id'] )
                                                @if($shown_item<13)
                                                  <li class="level3-li">
                                                      <a href="{{ '/search/'.$value_L1['cat_ename'].'/'.$value_L2['cat_ename'].'/'.$value_L3['cat_ename'].'?brand[0]='.$value_L4['id']}}">
                                                        {{$value_L4['cat_name']}}
                                                      </a>
                                                  </li>
                                                  <?php $shown_item++; ?>
                                                  <?php $category_items++; ?>
                                                @endif

                                              @endif
                                          @endforeach

                                          <!-- More -->
                                          @if($shown_item > 4)
                                              <span style="color:#16C1F3">
                                                <a href="{{ '/search/'.$value_L1['cat_ename'].'/'.$value_L2['cat_ename'].'/'.$value_L3['cat_ename'].'/more'}}">
                                                  مشاهده موارد بیشتر
                                                </a>

                                                <!-- After each 'Show More' close the </li></div> -->
                                                </li>
                                              </div>

                                              </span>
                                              <?php $category_items++; ?>
                                              <?php $shown_item++; ?>

                                          @endif

                                          <?php
                                              $shown_item++;
                                              $category_items++;
                                              echo "<br>";
                                          ?>

                                  <!-- will be shown right below each other -->
                                  @if($shown_item > 12)
                                    <?php $shown_item=0;?>
                                  @endif

                                  <!-- Using another variable for entering the third column -->
                                  @if($category_items > 27)
                                      </li>
                                    </div>
                                  @endif


                                @endif
                            @endforeach
                            <!-- ./Level 3 -->

                            <?php $shown_item=0;?>
                          </ul>
                  @endif
              @endforeach
              <!-- ./Level 2 -->

            </ul>
          </li>
      @endif
    @endforeach
    <!-- ./Level 1 -->
  </ul>


</div>


@yield('content')

@yield('footer')

  </body>

  <script>
    // why below code? if not, first hover all the the categories on last level will shown 
    $(document).ready(function(){
      $(".level3-ul").hide();
      cart_count();
    });

    $(".level1-li").mouseover(function() {
          $(this).children(".level2-ul").show();

          var upDown_icon = "level1-li-"+this.value;
          document.getElementById(upDown_icon).className="fa fa-chevron-up";

          $(".level2-li").mouseover(function() {
              $(this).children(".level3-ul").show();

          }).mouseout(function() {
                    $(this).children(".level3-ul").hide();
          });

      }).mouseout(function() {
                $(this).children(".level2-ul").hide();

                var upDown_icon = "level1-li-"+this.value;
                document.getElementById(upDown_icon).className="fa fa-chevron-down";
      });




      // Cart count
      <?php $url= url('cart/count'); ?>
      
      cart_count = function()
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
              success:function(data){
                document.getElementById("items-count-in-shopping-cart").innerText = data;
              }

              }
          );
      }

  </script>
</html>