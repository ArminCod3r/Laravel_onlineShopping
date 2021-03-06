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



@section('content1')

<section class="col-lg-7 connectedSortable">

    @if(isset($selected_id))
     <form action="{{ url('admin/feature?id='.$selected_id) }}" method="POST" accept-charset="utf-8" enctype="multipart/form-data">
     {{ csrf_field() }}
    @endif

    <div class="form-group">
            <label for="title">انتخاب دسته</label>
             <select name="category" class="selectpicker selectFilterCSS col-md-9" id="select_category" data-live-search="true" onchange="get_category()">
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

	    <!-- Features will be shown here -->
	    <div class="form-group" id="features_box">

        <?php
            if (isset($parents_and_childs))
            {
              foreach ($parents_and_childs as $key_parent => $value_parent)
              {
                $name_parent = $value_parent['name'];
                $id_parent = $value_parent['id'];

                echo ''.
                  '<div style="margin-top:10px; margin-bottom:5px;" id="feature_parent_'.$id_parent.'_FromDB">' .

                    '<input type="text" name="feature_name_parent['.$id_parent.']" id="feature_name_parent['.$id_parent.']" class="form-control col-md-4" style="float: right" value="'.$name_parent.'" placeholder="نام گروه ...">'.

                    '<br/>'.

                    '<div id="feature_child_'.$id_parent.'_FromDB" class="form-submit" style="margin:20px;">';

                      foreach ($value_parent['get_childs'] as $key_child => $value_child)
                      {
                        $name_child = $value_child["name"];
                        $id_child = $value_child["id"];
                        echo ''.
                          '<input type="text" name="feature_name_child['.$id_parent.']['.$id_child.']" class="form-control col-md-6" style="display: inline-block ; margin-top:5px;" placeholder="نام ویژگی" value="'.$name_child.'">'.

                          '<select id="parent_option_'.$id_child.'" name="parent_option[-'.$id_parent.']['.$id_child.']" class="form-control col-md-4" style="display: inline-block ; margin-right:5px ; padding-top:5px">'.
                                '<option value="1"> فیلد input </option>'.
                                '<option value="2"> فیلد select </option>'.
                                '<option value="3"> فیلد textarea </option>'.
                            '</select>';
                      }

                    echo '</div>';
                  echo '</div>';

                echo '<br/>';

                echo '<span>'.
                         '<label class="fa fa-plus" style="color:green ; cursor:pointer" onclick="add_child(\''.$id_parent.'\',\'True\')"></label>'.
                       '</span>';
              }
            }
        ?>

	    </div>


	    <div class="form-group" style="margin-right: 10px;">
	            <label class="fa fa-plus" style="color:red ; cursor:pointer" onclick="add_feature()"></label>
	        </div>


	     <div class="form-submit">
	         <input type="submit" name="submit" value="ثبت" class="btn btn-primary">
	     </div>

	     </form>
    @endif

@endsection

@section('content4')
  <section class="col-lg-5 connectedSortable">
@endsection




@section('footer')
    <script type="text/javascript" src="{{ url('js/bootstrap-select.js') }}"></script>
    <script type="text/javascript" src="{{ url('js/defaults-fa_IR.js') }}"></script>

    <script type="text/javascript">

    	get_category = function()
        {
            var select_category = document.getElementById('select_category').value;
            
            window.location = "<?php echo url('admin/feature'); ?>" + "?id=" + select_category;
        }


        var count = 1;
        add_feature = function()
        {
        	this['count_child_for' + count] = 1;

            var feature='<div style="margin-top:10px; margin-bottom:5px;" id="feature_parent_'+count+'">' +

                          '<input type="text" name="feature_name_parent[-'+count+']" class="form-control col-md-4" style="float: right" placeholder="نام گروه ...">'+

                          '<br/>'+

                          '<div id="feature_child_'+count+'" class="form-submit" style="margin:20px;">'+
                          '</div>'+

                           '<span>'+
                             '<label class="fa fa-plus" style="color:green ; cursor:pointer" onclick="add_child(\'-'+count+'\',\'False\')"></label>'+
                           '</span>'+

                         '</div>';
            count++;

            $("#features_box").append(feature);
        }

        var count_child = 1;
        add_child = function(parent_count, isitFromDB)
        {

          var feature_child = '<input type="text" name="feature_name_child['+parent_count+'][-'+count_child+']" class="form-control col-md-6" style="display: inline-block ; margin-top:5px" placeholder="نام ویژگی">'+

            '<select id="parent_option_'+count+'" name="parent_option['+parent_count+'][-'+count_child+']" class="form-control col-md-4" style="display: inline-block ; margin-right:5px ; padding-top:5px">'+
                  '<option value="1"> فیلد input </option>'+
                  '<option value="2"> فیلد select </option>'+
                  '<option value="3"> فیلد textarea </option>'+
              '</select>'
              ;
          
          if (parent_count<0)
          {
            parent_count = -parent_count;
            $("#feature_child_"+parent_count).append(feature_child);
          }
          else
          {
            $("#feature_child_"+parent_count+"_FromDB").append(feature_child);
          }          

          count_child++;
        }

    </script>

@endsection