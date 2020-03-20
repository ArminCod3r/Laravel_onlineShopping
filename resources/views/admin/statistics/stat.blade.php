@extends('admin/layouts/adminLayout')

@section('header')
	<title>آمار سایت</title>
@endsection

@section('custom-title')
  آمار سایت
@endsection


@section('content1')

 <section class="col-lg-12 connectedSortable">
<div>
  <div id="container" style="direction: rtl"></div>
</div>
 @endsection

@section('content4')
	<section class="col-lg-5 connectedSortable">
@endsection

@section('footer')
  <script src="{{ url('js/highcharts.js') }}"></script>

  <?php
        $year    = date("Y");
        $month   = date("n");
        $maxDays = date('t');

        $date  = '';
        $view  = '';

        for ($i=1; $i <= $maxDays; $i++)
        { 
          $date .= '"'.$year.'-'.$month.'-'.$i.'",';
        }

        for ($i=1; $i <= $maxDays; $i++)
        { 
          $view .= $views[$i].',';
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
            text: 'نمودار آمار بازدید سایت'
        },
        subtitle: {
            text: '',
        },
        tooltip:{
          useHTML: true,
          style: {
              fontSize: '14px',
              fontFamily: 'tahoma',
              direction: 'rtl',
          },
          formatter:function(){
            if(this.series.name == 'میزان بازدید')
            {
              // https://www.highcharts.com/forum/viewtopic.php?f=9&t=7500
              return this.x+"<br>"+this.series.name+":"+Highcharts.numberFormat(this.y, 0)+"بازدید";
            }
            else
            {
              return this.x+"<br>بازدید:"+this.y+" بار";
            }
          }
        },
        xAxis: {
            categories: [<?php echo $date; ?>]
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
            name: 'میزان بازدید',
            data: [<?php echo $view; ?>],
            color:'blue',
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