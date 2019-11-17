@extends('admin/layouts/adminLayout')


@section('header')
    <title>افزودن ویژگی محصولات</title>
    <link rel="stylesheet" type="text/css" href="{{ url('css/bootstrap-select.css') }}">
    <style type="text/css">

    .bootstrap-select .dropdown-toggle .filter-option
    {
        text-align: right;
    }

    </style>  
@endsection

@section('custom-title')
  افزودن ویژگی محصولات
@endsection