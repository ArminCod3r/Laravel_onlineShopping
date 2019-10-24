@extends('admin/layouts/adminLayout')


@section('header')
    <title>افزودن فیلتر</title>
    <link rel="stylesheet" type="text/css" href="{{ url('css/bootstrap-select.css') }}">
    <style type="text/css">

    .bootstrap-select .dropdown-toggle .filter-option
    {
        text-align: right;
    }

    </style>  
@endsection

@section('custom-title')
  افزودن فیلتر
@endsection

@section('content1')

    <div class="form-group">
            <label for="title">انتخاب دسته</label>
             <select name="category" class="selectpicker selectFilterCSS" data-live-search="true" style="width: 100%; ">
             <!--stack: 24627902-->

                 <?php
                foreach ($categories as $id=>$item)
                {
                    $cat_name = explode(':', $item)[0];
                    $id       = explode(':', $item)[1];

                    echo '<option value="'.$id.'">'.$cat_name.'</option>';
                }
             ?>              
             </select> 

        </div>

@endsection


@section('footer')
    <script type="text/javascript" src="{{ url('js/bootstrap-select.js') }}"></script>
    <script type="text/javascript" src="{{ url('js/defaults-fa_IR.js') }}"></script>
    <script type="text/javascript" src="{{ url('js/jscolor.js') }}"></script>
@endsection