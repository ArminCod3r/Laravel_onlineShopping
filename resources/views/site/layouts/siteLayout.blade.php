<?php

$value = $categories[0];

$cat_name       = explode(':', $value)[0];
$parent_and_key = explode(':', $value)[1];
$parent         = explode('-', $parent_and_key)[0];
$key            = explode('-', $parent_and_key)[1];

preg_match('/([a-zA-Z0-9_]*)-/', $parent_and_key, $match);

$shown_item = 0;

?> 

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
                <span> <a href="/login">وارد شوید</a> </span>
            </li>

            <li class="list-inline-item">
              <span class="fa fa-user" ></span>
              <span> <a href="/regsiter">ثبت نام </a> </span>
            </li>

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
     
     <?php // -------------------- Category Level 1 ------------------ ?>
    @foreach ($categories as $key => $value)

    
        <!-- No three-lines : level1-->  
        <?php
          $cat_name       = explode(':', $value)[0];
          $parent_and_key = explode(':', $value)[1];
          $parent         = explode('-', $parent_and_key)[0];
          $key            = explode('-', $parent_and_key)[1];

          preg_match('/([a-zA-Z0-9_]*)-/', $parent_and_key, $match);
        ?>

        @if ( preg_match('/0\b/', $value) )

            <!-- Level 1 -->

          <li class="list-inline-item level1-li" id="level1-li" value="{{$key}}">
            <?php echo $cat_name?>     

            <span class="fa fa-chevron-down" id="level1-li-{{$key}}"></span>

            <ul class="list-inline level2-ul" id="level2-ul">

            <!-- ./Level 1 -->

            <?php
              
              foreach ($categories as $key_L2_ => $value_L2)
              {
                $cat_name_L2       = explode(':', $value_L2)[0];
                $parent_and_key_L2 = explode(':', $value_L2)[1];
                $parent_L2         = explode('-', $parent_and_key_L2)[0];
                $key_L2            = explode('-', $parent_and_key_L2)[1];
                

                if ($parent_L2!=0)
                {
                  if ($parent_L2 == $key)
                  {
                    //  Level 2
                    echo '<li class="list-inline-item level2-li">';
                    echo '<span>'.$cat_name_L2.'</span>'; // style="color:#16C1F3"

                    // ./Level 2

                    
                    echo '<ul class="level3-ul" id="level3-ul">';
                    // Level 3
                    foreach ($categories as $key_L3 => $value_L3)
                    {
                      $cat_name_L3       = explode(':', $value_L3)[0];
                      $parent_and_key_L3 = explode(':', $value_L3)[1];
                      $parent_L3         = explode('-', $parent_and_key_L3)[0];
                      
                      //echo "<h1>".$cat_name_L3."</h1>";

                      if ($parent_L3!=0)
                      {
                        if ($parent_L3 == $key_L2)
                        {
                          if ($shown_item<10 && $shown_item != 0)
                          {
                            echo '<li class="level3-li">';
                            echo $cat_name_L3;
                            echo '</li>'; 
                          }
                          if ($shown_item == 0)
                          {
                            echo '<li class="level3-li">';
                            echo '<span style="color:#16C1F3">'.$cat_name_L3.'</span>';
                            echo '</li>';
                          }
                          else
                          {
                            if ($shown_item == 10)
                            {
                              echo '<li class="level3-li">';
                              echo '<span style="color:#16C1F3">'.'+ مشاهده موارد بیشتر'.'</span>';
                              echo '</li>';
                            }
                          }                       
                          $shown_item++;                      
                        }
                      }
                    }
                    
                    // ./ Level 3
                    $shown_item=0;

                    echo '</ul>';
                    //---------------------------------------------------------

                    echo '</li>';
                  }                  
                }
              }
            ?>            
            </ul>
        @endif

        <!--
        <ul class="list-inline">   
          @foreach ($categories as $key2 => $value2)

            @if ($key2 > $key) 

              @if ( substr_count($value2, '---') == 1 )
                  <li class="list-inline-item">
                    {{$value2}}
                  </li>
              @else
                  @break               
              @endif

            @endif

          @endforeach               
        </ul>
      -->

    @endforeach

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