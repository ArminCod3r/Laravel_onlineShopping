@extends('admin/layouts/adminLayout')

@section('header')
	<title>خانه</title>
@endsection

@section('custom-title')
  داشبورد
@endsection

@section('stat-box')

<div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3>150</h3>

                <p>سفارشات جدید</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a href="#" class="small-box-footer">اطلاعات بیشتر <i class="fa fa-arrow-circle-left"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3>53<sup style="font-size: 20px">%</sup></h3>

                <p>افزایش امتیاز</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="#" class="small-box-footer">اطلاعات بیشتر <i class="fa fa-arrow-circle-left"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3>44</h3>

                <p>کاربران ثبت شده</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="#" class="small-box-footer">اطلاعات بیشتر <i class="fa fa-arrow-circle-left"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3>65</h3>

                <p>بازدید جدید</p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
              <a href="#" class="small-box-footer">اطلاعات بیشتر <i class="fa fa-arrow-circle-left"></i></a>
            </div>
          </div>
          <!-- ./col -->
        </div>

@endsection



@section('content1')

<section class="col-lg-12 connectedSortable">

<div>
  <div id="container" style="direction: rtl"></div>
</div>

@endsection

@section('content2')

@endsection


@section('content3')

@endsection

@section('content4')
<section class="connectedSortable">


@endsection

@section('content5')

@endsection

@section('content6')

@endsection

@section('footer')
  <script src="{{ url('js/highcharts.js') }}"></script>

  <?php
        $maxDays = date('t');

        $dates_chart        = '';
        $price_chart        = '';
        $transactions_chart = '';
        $dates = array_reverse($dates);

        for ($i=1; $i <= $maxDays; $i++)
        { 
          $dates_chart .= '"'.$dates[$maxDays-$i].'",';
          $price_chart .= $price[$i].',';
          $transactions_chart .= $transactions[$i].',';
        }        
  ?>


  <script type="text/javascript">
    
    Highcharts.chart('container', {
        chart: {
            type: 'line',
            style:{
              fontFamily: 'Vazir',
            }
        },
        title: {
            text: 'نمودار میزان درآمد این ماه فروشگاه'
        },
        subtitle: {
            text: '',
        },
        //27144967
        tooltip: {
            useHTML: true,
            style: {
                fontSize: '14px',
                fontFamily: 'tahoma',
                direction: 'rtl',
            },
            pointFormat: '{series.name}: <b>{point.y}</b><br/>',
        },
        xAxis: {
            categories: [<?php echo $dates_chart; ?>]
        },
        yAxis: {
            title: {
                text: ''
            }
        },
        legend:{
            verticalAlign: 'top',
            y:10,
        },
        plotOptions: {
            line: {
                dataLabels: {
                    enabled: true
                },
                enableMouseTracking: true
            }
        },
        series: [{
            name: 'میزان درآمد',
            data: [<?php echo $price_chart; ?>],
            color:'red',
        }, {
            name: 'تعداد تراکنش',
            data: [<?php echo $transactions_chart; ?>],
            marker:{
              symbol: 'circle'
            }
        }]
    });

    //15031749
    Highcharts.setOptions({
        lang: {
            decimalPoint: ',',
            thousandsSep: '.'
        }
    });

  </script>

@endsection