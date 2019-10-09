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


    <title>فروشگاه اینترنتی دیجی کالا</title>
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
            
          <li class="list-inline-item level1-li"
            onmouseover="viewSubMenu('{{$cat_name}}', '{{$parent}}', '{{$key}}')"
            onmouseout="hideSubMenu('{{$value}}')"
            >
            <?php echo $cat_name?>         
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
      @if ( !stristr($value, "---") )
        </li>
      @endif

    @endforeach

    </ul>
</div>

  </body>

  <script>

    function viewSubMenu(cat_name, parent, key)
    {

      <?php foreach ($categories as $key2 => $value2): ?>

        <?php
          $cat_name_2       = explode(':', $value2)[0];
          $parent_and_key_2 = explode(':', $value2)[1];
          $parent_2         = explode('-', $parent_and_key_2)[0];
          //$key_2            = explode('-', $parent_and_key)[1];
        ?>

        if (key == {!! json_encode($parent_2) !!})
        {
          console.log({!! json_encode($cat_name_2) !!});
        }
        
      <?php endforeach ?>

    }

    function hideSubMenu(x)
    {
    }

  </script>
</html>