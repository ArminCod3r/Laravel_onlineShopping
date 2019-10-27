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

    @if(isset($selected_id))
     <form action="{{ url('admin/filter?id='.$selected_id) }}" method="POST" accept-charset="utf-8" enctype="multipart/form-data">
     {{ csrf_field() }}
    @endif

    <div class="form-group">
            <label for="title">انتخاب دسته</label>
             <select name="category" class="selectpicker selectFilterCSS col-md-9" id="select_category" data-live-search="true" onchange="get_filter()">
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

    @if(isset($selected_id))

    <!-- Filters will be shown here -->
    <div class="form-group" id="filters_box">
        <?php

            foreach ($filters_parent as $key => $value)
            {
                if ($value['parent_id'] == 0)
                {
                    echo '<div style="margin-top:10px; margin-bottom:5px;" id="filter_parent_'.$value['id'].'_FromDB">';

                    echo '<input type="text" value="'.$value['name'].'" name="filter_name_parent['.$value['id'].']" class="form-control col-md-4" style="float: right" placeholder="نام فیلتر ...">';

                    echo '<input type="text" value="'.$value['ename'].'" name="filter_ename_parent['.$value['id'].']" class="form-control col-md-4" style="float: right" placeholder="نام لاتین فیلتر ...">';

                    echo '<select id="parent_option_'.$value['id'].'_FromDB" name="parent_option[]" class="form-control col-md-4" style="margin-right:10px;">';
                    echo '<option value="1"> radio </option>';
                    echo '<option value="2"> color </option>';
                    echo '</select>';

                    echo '<div id="filter_child_'.$value['id'].'_FromDB" class="form-submit" style="margin:20px;">';
                    echo '</div>';

                    $arg1 = "'".$value['id']."'";
                    $arg2 = "'"."True"."'";
                    echo '<span>';
                    echo '<label class="fa fa-plus" style="color:green ; cursor:pointer" onclick="add_child('.$arg1.','.$arg2.')"></label>';
                    echo '</span>';

                    echo '</div>';
                }

                if ($value['parent_id'] == 0)
                {

                }
            }

        ?>
    </div>


    <div class="form-group" style="margin-right: 10px;">
            <label class="fa fa-plus" style="color:red ; cursor:pointer" onclick="add_filter()"></label>
        </div>


     <div class="form-submit">
         <input type="submit" name="submit" value="ثبت" class="btn btn-primary">
     </div>

     </form>
    @endif

@endsection


@section('footer')
    <script type="text/javascript" src="{{ url('js/bootstrap-select.js') }}"></script>
    <script type="text/javascript" src="{{ url('js/defaults-fa_IR.js') }}"></script>
    <script type="text/javascript" src="{{ url('js/jscolor.js') }}"></script>

    <script type="text/javascript">
        get_filter = function()
        {
            var select_category = document.getElementById('select_category').value;
            
            window.location = "<?php echo url('admin/filter'); ?>" + "?id=" + select_category;
        }

        document.addEventListener('DOMContentLoaded', function() {

            <?php if (isset($selected_id)): ?>
                document.getElementById('select_category').value=<?php echo $selected_id; ?>;              
            <?php endif ?>

        }, false);


        var count = 1;

        add_filter = function()
        {
            this['count_child_for' + count] = 1;
            //console.log('count_child_for1');

            var filter='<div style="margin-top:10px; margin-bottom:5px;" id="filter_parent_'+count+'">' +

                          '<input type="text" name="filter_name_parent[-'+count+']" class="form-control col-md-4" style="float: right" placeholder="نام فیلتر ...">'+

                          '<input type="text" name="filter_ename_parent[-'+count+']" class="form-control col-md-4" style="float: right" placeholder="نام لاتین فیلتر ...">'+

                          '<select id="parent_option_'+count+'" name="parent_option[]" class="form-control col-md-4" style="margin-right:10px;">'+
                            '<option value="1"> radio </option>'+
                            '<option value="2"> color </option>'+
                          '</select>'+

                          '<div id="filter_child_'+count+'" class="form-submit" style="margin:20px;">'+
                          '</div>'+

                           '<span>'+
                             '<label class="fa fa-plus" style="color:green ; cursor:pointer" onclick="add_child(\''+count+'\',\'False\')"></label>'+
                           '</span>'+

                         '</div>';
            count++;

            $("#filters_box").append(filter);
        }

        var count_child = 1;
        add_child = function(parent_count, isItFromDB)
        {

            // Check whether if the add_child() called from filled parents or new added parents-input

            if (isItFromDB == "True")
                var selected_option = document.getElementById('parent_option_'+parent_count+"_FromDB").value;

            if (isItFromDB == "False")
                var selected_option = document.getElementById('parent_option_'+parent_count).value;


            if (selected_option == 1)
            {
                // NOTE: POSITIVE / NEGATIVE ARRAY IS IMPORTANT
                //
                // if the function's caller has made from DB,
                // it means a new child-input is about to be made, so: 
                //      ['+parent_count+'] 
                // NOT: [-'+parent_count+']
                //
                if (isItFromDB == "True")
                {
                    var filter_child = '<input type="text" name="filter_name_child['+parent_count+'][-'+count_child+']" class="form-control col-md-4" style="margin-top:10px">';

                    $("#filter_child_"+parent_count+"_FromDB").append(filter_child);
                }

                if (isItFromDB == "False")
                {
                    var filter_child = '<input type="text" name="filter_name_child[-'+parent_count+'][-'+count_child+']" class="form-control col-md-4" style="margin-top:10px">';

                    $("#filter_child_"+parent_count).append(filter_child);
                }
            }


            if (selected_option == 2)
            {
                var filter_child = '<input type="text" name="filter_color_child[-'+parent_count+'][-'+count_child+'][]" class="form-control col-md-4" style="float:right;" placeholder="نام رنگ ...">';
                $("#filter_child_"+parent_count).append(filter_child);

                var colors_here = document.getElementById('filter_child_'+parent_count); 

                var input = document.createElement("input");
                input.type = "text";
                input.name = "filter_color_child[-"+parent_count+"][-"+count_child+"][]";
                input.className="form-control col-md-4";
                //input.style["margin-top"] = "10px";

                var color = new jscolor(input);
                colors_here.appendChild(input);
                colors_here.appendChild(document.createElement("br"));
            }

            count_child++;
        }

    </script>

@endsection