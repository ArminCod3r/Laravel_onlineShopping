<?php

$value = $categories[0];

$cat_name       = explode(':', $value)[0];
$parent_and_key = explode(':', $value)[1];
$parent         = explode('-', $parent_and_key)[0];
$key            = explode('-', $parent_and_key)[1];

preg_match('/([a-zA-Z0-9_]*)-/', $parent_and_key, $match);

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
              <div class="btn-shopping-cart">

                <div class="shopping-cart-icon">
                  <span class="fa fa-shopping-cart"></span>
                </div>
                
                <div class="shopping-cart-text">
                  <span style="float: right;">سبد خرید</span>
                  <span class="items-count-in-shopping-cart">0</span>
                </div>

              </div>
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
          <img src="{{ url('/images/logo.png') }}" class="logo">
        </div>
        
      </div>

    </div>
  </div>


<div class="container-fluid menu">

  <ul class="list-inline level1-ul">
     
    @foreach ($categories as $key => $value)

    
        <!-- No three-lines : level1-->  
        <?php
          $cat_name       = explode(':', $value)[0];
          $parent_and_key = explode(':', $value)[1];
          $parent         = explode('-', $parent_and_key)[0];
          $key            = explode('-', $parent_and_key)[1];

          preg_match('/([a-zA-Z0-9_]*)-/', $parent_and_key, $match);
          //echo ($match[0])
        ?>

        @if ( preg_match('/0\b/', $value) )
            
          <li class="list-inline-item level1-li">
            <?php echo $cat_name?>         

            <!--<div class="form-group subCategories" id="subCategories" style="display: none;">-->  
              <!-- Tags will be shown here-->     
            <!--</div>-->  

            <ul class="list-inline level2-ul" id="level2-ul">
            <?php
              

              foreach ($categories as $key_L2 => $value_L2)
              {
                $cat_name_L2       = explode(':', $value_L2)[0];
                $parent_and_key_L2 = explode(':', $value_L2)[1];
                $parent_L2         = explode('-', $parent_and_key_L2)[0];
                

                if ($parent_L2!=0)
                {
                  if ($parent_L2 == $key)
                  {
                    echo '<li>';
                    echo $cat_name_L2;
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

  </body>

  <script>

    $(".level1-li").mouseover(function() {
          $(this).children(".level2-ul").show();

      }).mouseout(function() {
                $(this).children(".level2-ul").hide();
      });
  </script>
</html>