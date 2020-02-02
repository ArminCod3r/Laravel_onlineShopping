@extends('admin/layouts/adminLayout')


@section('header')
    <title>مدیریت سفارش ها</title>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" type="text/css" href="{{ url('slick/slick/slick.css') }}">
    <link rel="stylesheet" type="text/css" href="{{url('slick/slick/slick-theme.css')}}">


@endsection

@section('custom-title')
  مدیریت سفارش ها
@endsection


@section('content1')

<?php
    
    $order_status = array();

    $order_status[0] = 'در انتظار پرداخت';
    $order_status[1] = 'در انتظار تایید';
    $order_status[2] = 'آماده سازی سفارش';
    $order_status[3] = 'ارسال';
    $order_status[4] = 'تحویل داده شده';
    $order_status[5] = 'عدم دریافت محصول';

?>

<form action="{{route('order.update', $order->id ) }}" onsubmit="return false;" method="POST" name="confirmation_form" id="confirmation_form">
    {{ csrf_field() }}
    <input type="hidden" name="active_step" id="active_step" value="">
    <input type="hidden" name="_method" value="PATCH">
</form>

<section class="col-lg-12 connectedSortable">


<!-- orders details -->
<div class="details_1">

    <div class="code">
        <span>کد سفارش:</span>
        <span>
        {{ $order->order_id }}
        </span>
    </div>

    <div style="width: 95%; padding-top: 25px">
        <table class="table table-striped" style="width: 100%; margin-right: 20px;font-size: 18px; border-bottom: 1px solid #dee2e6">

            <tr>
                <td>
                    <span>نام تحویل گیرنده:</span>
                    <span> {{ $users_addr['username'] }} </span>
                </td>
                <td>
                    <span>شماره تماس: </span>
                    <span> {{ $users_addr['mobile'] }} </span>
                </td>
            </tr>

            <tr>
                <td>
                    <span>تعداد مرسوله: </span>
                    <span> {{ $order->count }} </span>
                </td>
                <td>
                    <span>مبلغ قابل پرداخت: </span>
                    <span> {{ number_format($order->price) }} تومان </span>
                </td>
            </tr>

            <tr>
                <td>
                    <span>روش پرداخت: </span>
                    <span> پرداخت در محل </span>
                </td>
                <td>
                    <span>وضعیت سفارش: </span>
                    <span> {{ $order_status[$order->order_step] }} </span>
                </td>
            </tr>

            <tr>
                <td colspan="2">
                    <span> آدرس: </span>
                    <span> {{ $users_addr['address'] }} </span>
                </td>
            </tr>

        </table>

        <!-- Checking if user-inputed-address still exists -->
        @if(!($addr_exists))
            <div style="margin: 10px 20px 0px 0px; font-size: 14px; color: #a0a0a0">
                این آدرس در آدرس های فعلی شما قرار ندارد.
            </div>
        @endif
    </div>
</div>


<!-- posts steps -->
<div class="posts_steps" dir="rtl">

        <div>
            <span>
                <img class="step" src="{{ url('images/posts_steps/'.'2.svg') }}"  >
            </span>
            <span>سفارش انجام شده</span>            
        </div>

        <img class="link opacity" src="{{ url('images/posts_steps/link.png') }}"  >


        <div class="opacity" style="position: relative;" id="post_step_2">
            <span>
                <img class="step" src="{{ url('images/posts_steps/'.'1.svg') }}"  >
            </span>
            <span>در انتظار تایید</span>
            <span class="confirmation">
                <button class="btn btn-primary" id="confirm2" onclick="confirm_post_steps('2')" style="margin-top: 20px;">تایید کردن</button>
            </span>
        </div>

        <img class="link opacity" src="{{ url('images/posts_steps/link.png') }}"  >


        <div class="opacity" id="post_step_3">
            <span>
                <img class="step" src="{{ url('images/posts_steps/'.'3.svg') }}"  >
            </span>
            <span>آماده سازی سفارش</span>
            <span class="confirmation">
                <button class="btn btn-primary" id="confirm3" onclick="confirm_post_steps('3')" style="margin-top: 20px;">تایید کردن</button>
            </span>
        </div>

        <img class="link opacity" src="{{ url('images/posts_steps/link.png') }}"  >

        <div class="opacity" id="post_step_4">
            <span>
                <img class="step" src="{{ url('images/posts_steps/'.'4.svg') }}"  >
            </span>
            <span>ارسال</span>
            <span class="confirmation">
                <button class="btn btn-primary" id="confirm4" onclick="confirm_post_steps('4')" style="margin-top: 20px;">تایید کردن</button>
            </span>
        </div>

        <img class="link opacity" src="{{ url('images/posts_steps/link.png') }}"  >


        
        <div class="opacity" id="post_step_5">
            <span style="position: relative;">
                <img src="{{ url('images/posts_steps/'.'6.svg') }}" style="-moz-transform: scale(0.4); margin-top:-49px;margin-right: -40px;" >
            </span>
            <span style="position:absolute ; top: 0px; left:130px ; margin-top:7.5%;">
                تحویل مرسوله به مشتری
            </span>
            <span class="confirmation">
                <button class="btn btn-primary" id="confirm5" onclick="confirm_post_steps('5')">تایید کردن</button>
            </span>
        </div>

        
        <div>
        </div>
</div>


<!-- bought items -->
<div class="bought_items" style="width: 95%; margin: auto">


    <div class="container">

    <div class="title">
        اجناس خریداری شده
    </div>

        <table class="table">
            <tr class="cart_headers">
                <th>تصویر</th>
                <th>محصول</th>
                <th>رنگ</th>
                <th>قیمت</th>
                <th>تعداد</th>
                <th colspan="2">قیمت کل</th>
            </tr>

            @foreach($bought_items as $key=>$value)
                <tr class="cart_values">

                    <td style="width: 10%;">
                        <img style="width: 50%;" src="{{ url('upload').'/'.$value->image->url}}" </img>
                    </td>

                    <td style="width: 40%;">
                        {{ $value->product->title }}
                    </td>

                    <td>
                        <label style="background-color: #{{ $value->color->color_code }}" class="cart_product_color">
                        </label>
                    </td>

                    <td> {{ number_format($value->product->price) }} </td>
                    <td>

                        <div class="row">

                            <div class="col-sm-4"></div>

                            <div class="col-sm-2">
                                {{ $value->number }}
                            </div>

                            <div class="col-sm-6"></div>

                        </div>
                    </td>
                    <td class="total_price">
                        {{ number_format((int)$value->product->price * (int)$value->number) }}
                    </td>
                    
                </tr>
            @endforeach
        </table>

        <!-- Get the total-price / discounted-price -->
        <?php
            $total_price    = 0;
            $discount_price = 0;

            foreach ($bought_items as $key => $value)
            {
                $price = (int)$value->product->price;

                $total_price += $price * $value->number;
            }

            foreach ($bought_items as $key => $value)
            {
                $price    = (int)$value->product->price;
                $discount = (int)$value->product->discounts;

                $discount_price += ($price-(($price*$discount)/100))* $value->number;
            }

        ?>


        <div class="row" style="margin-bottom: 20px;">
            <div class="col-sm-8"></div>

            <div class="col-sm-4 total-price-factor">
                <table>
                    <tr>
                        <td style="padding-right: 15px">جمع کل خرید</td>
                        <td>
                            <strong id="invoice_total_price">
                                {{number_format($total_price)}}
                            </strong>
                            <span>تومان</span>
                        </td>
                    </tr>
                    <tr style="background-color:#c6f5d3;color:#32ad55;">
                        <td style="padding-right: 15px">مبلغ قابل پرداخت</td>
                        <td>
                            <strong>{{number_format($discount_price)}}</strong>
                            تومان
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>


@endsection

@section('footer')
    <script type="text/javascript" src="{{ url('slick/slick/slick.js') }}" charset="utf-8"></script>

    <script type="text/javascript">

        $(".posts_steps").slick({
            infinite: false,
            slidesToShow: 8,
            slidesToScroll:1,
            rtl: true
         });

        confirm_post_steps = function(step)
        {
            document.getElementById('active_step').value=step;

            document.getElementById("confirmation_form").submit();
        }

        var order_step = <?php echo $order->order_step; ?>;
        for (var i = 2; i <= order_step; i++)
        {
            // Removing opacity
            $('#post_step_'+i).removeClass('opacity');

            // Removing the confirmation-btn 
            document.getElementById('confirm'+i).remove();
        }
        

    </script>
@endsection