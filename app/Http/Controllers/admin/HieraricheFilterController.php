<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\HierarchieFilter;
use App\Category;
use App\ProductImage;
use App\FilterAssign;
use App\Product;
use DB;

class HieraricheFilterController extends Controller
{
    private $categories = array();

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $categories = self::categoryTree();

        if($request->get('id'))
        {
            $selected_id = $request->get('id');

            // Get the parents' filter
            $filters_parent = HierarchieFilter::where([
                                                      'category_id' => $selected_id,
                                                      'parent_id'   => 0,
                                                     ])
                                                ->get();
            

            
            $category = Category::find($selected_id);

            $filters_category_parent = HierarchieFilter::where('category_id', $category->parent_id)->get();

            $parent_has_filters = false;
            if(sizeof($filters_category_parent)>0)
                $parent_has_filters = true;

            $childs = HierarchieFilter::with('get_childs')
                            ->where(['category_id'=>$selected_id,'parent_id'=>0])
                            ->get();
            
            return view('admin/hierarchie_filter/index')->with([
                                        'categories'     => $categories,
                                        'selected_id'    => $selected_id,
                                        'filters_parent' => $filters_parent,
                                        'filters_category_parent' => $filters_category_parent,
                                        'parent_has_filters' => $parent_has_filters,
                                                     ]);
        }

        else
            return view('admin/hierarchie_filter/index')->with('categories', $categories);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //return $request->get('parents_filters');

        $parents_filters = $request->get('parents_filters');

        $id = $request->get('id');
        $category = Category::findOrFail($id);

        $filter_name_parent  = $request->get('filter_name_parent');
        $filter_ename_parent = $request->get('filter_ename_parent');
        $select_option       = $request->get('parent_option');   // radio or color
        $filter_name_child   = $request->get('filter_name_child');
        $filter_color_child  = $request->get('filter_color_child');

        //return $parents_filters;


        $inserted_item_count = 0;

        $arr  = array();
        $update_or_insert = array();

        if( sizeof($parents_filters) > 0)
        {
            foreach ($parents_filters as $key => $value)
            {
                $parents_id   = explode(':', $value)[0];
                $selected_sub = explode(':', $value)[1];

                array_push($arr, $parents_id.'-'.$selected_sub.'-'.$id);

                // if new value(s) added there is where we can handle it to insert the new one(s)
                array_push($update_or_insert, $selected_sub);

                $existance = DB::table('hierarchie_filter')
                                ->where(['name'=>$parents_id,'category_id'=> $id])
                                //->wherein('parent_id', $update_or_insert)
                                ->first();
                
                
                // Inserting
                if( sizeof($existance) == 0)
                {
                    array_push($arr, 'insert');
                    DB::table('hierarchie_filter')->insert(
                                                        [
                                                          'name'       => $parents_id ,
                                                          'ename'      => '-' ,
                                                          'parent_id'  => $selected_sub,
                                                          'category_id'=> $id,
                                                          'filled'     => 1,
                                                         ]
                                                      );
                }
                // Updating
                else                    
                {
                    array_push($arr, 'update');
                DB::table('hierarchie_filter')->where(['name'=>$parents_id,'category_id'=> $id])->update(['parent_id' => $selected_sub]);
                }
            }

            
        }

        return $arr;


        foreach ($filter_name_parent as $key => $value)
        {
            if ($key<0 && !empty($value))
            {
                // Inserting parents-filter
                $ename = array_key_exists($key, $filter_ename_parent) ? $filter_ename_parent[$key] : '';
                $selected_option_item = array_key_exists($key, $select_option) ? $select_option[$key] : 1;

                $inserted_parent_id = DB::table('hierarchie_filter')->insertGetId(
                                        ['category_id' => $id    ,
                                         'name'        => $value ,
                                         'ename'       => $ename ,
                                         'parent_id'   => 0      ,
                                         'filled'      => $select_option[$inserted_item_count],
                                         ]
                                    );

                // Inserting childs-filter
                if(is_array($filter_name_child) && array_key_exists($key, $filter_name_child))
                {
                    foreach ($filter_name_child[$key] as $key_child => $value_child)
                    {
                        if(!empty($value_child))
                        {
                            DB::table('hierarchie_filter')->insert(
                                ['category_id' => $id    ,
                                 'name'        => $value_child ,
                                 'ename'       => '' ,
                                 'parent_id'   => $inserted_parent_id ,
                                 'filled'      => $select_option[$inserted_item_count],
                                 ]
                            );
                        }
                    }
                }
                $inserted_item_count++;

                // Inserting colors-child
                if(is_array($filter_color_child) && array_key_exists($key, $filter_color_child))
                {
                    foreach ($filter_color_child[$key] as $key_child_color => $value_child_color)
                    {
                        if(!empty($value_child_color))
                        {
                            $child_color = $value_child_color[0].':'.$value_child_color[1];

                            DB::table('hierarchie_filter')->insert(
                                ['category_id' => $id    ,
                                 'name'        => $child_color ,
                                 'ename'       => '' ,
                                 'parent_id'   => $inserted_parent_id ,
                                 'filled'      => 2,
                                 ]
                            );
                        }
                    }
                }
            }

            else
            {
                // If parent's input was removed:  1.Delete parents 2.Delete childs-filter
                if(empty($value))
                {
                    DB::table('hierarchie_filter')->where('id', $key)->delete();

                    DB::table('hierarchie_filter')->where('parent_id', $key)->delete();
                }

                // 1. Editing parents-filter
                // 2. child-filter: Deleting, Editing, Inserting
                if(!empty($value))
                {
                    // Update the current value-parent whether changed or not
                    $previous_parent_filter = DB::table('hierarchie_filter')->where('id', $key)
                                                                 ->update(['name' => $value]);

                   if(is_array($filter_name_child) && array_key_exists($key, $filter_name_child))
                    {
                        foreach ($filter_name_child[$key] as $key_child => $value_child)
                        {
                            $previous_child_filter = DB::table('hierarchie_filter')->where('id', $key_child)
                                                                        ->pluck('name');
                            
                            // Comparing current-child and inserted-child-databse
                            if($value_child != $previous_child_filter)
                            {
                                // Deleteing
                                if(empty($value_child))
                                {
                                    DB::table('hierarchie_filter')->where('id', $key_child)->delete();
                                }

                                // Editing                         
                                if(!empty($value_child))
                                {
                                    DB::table('hierarchie_filter')->where('id', $key_child)
                                                       ->update(['name' => $value_child]);
                                    
                                }

                                // Inserting:  if key_child<0 => New Child-filter
                                if($key_child<0 && !empty($value_child))
                                {
                                    $selected_option_item = array_key_exists($key, $select_option) ? $select_option[$key] : 1;                  
                                    DB::table('hierarchie_filter')->insert(
                                        ['category_id' => $id    ,
                                         'name'        => $value_child ,
                                         'ename'       => '' ,
                                         'parent_id'   => $key ,
                                         'filled'      => $selected_option_item,
                                         ]
                                    );
                                }
                            }                            
                        }
                    }

                    // Adding childs-color to the current colors
                    if(is_array($filter_color_child) && array_key_exists($key, $filter_color_child))
                    {
                        foreach ($filter_color_child as $key_child_color => $value_child_color)
                        {
                            foreach ($value_child_color as $key_ => $value_)
                            {
                                // Inserting
                                if($key_ == -1 && !empty($value_))
                                {
                                    $child_color = $value_[0].':'.$value_[1];

                                    DB::table('hierarchie_filter')->insert(
                                        ['category_id' => $id    ,
                                         'name'        => $child_color ,
                                         'ename'       => '' ,
                                         'parent_id'   => $key_child_color ,
                                         'filled'      => 2,
                                         ]
                                    );
                                }

                                // Deleting, Editing
                                else //if(empty($value_[0]))
                                {
                                    $blades_colors_trimming = array();
                                    $colors_trim_db = array();

                                    $previous_colors_filter = DB::table('hierarchie_filter')
                                                                 ->where('parent_id', $key_child_color)
                                                                 ->pluck('name');
                                    
                                    // white:FFFFFF ->to-> white (array form)
                                    foreach ($previous_colors_filter as $key_trim_db => $value_trim_db)
                                    {
                                        array_push($colors_trim_db, explode(":", $value_trim_db)[0]);
                                    }

                                    // convert blades-color into simple array
                                    foreach ($value_child_color as $key_trimming => $value_trimming)
                                    {
                                        array_push($blades_colors_trimming, $value_trimming[0]);
                                    }

                                    // Comparing
                                    $db_result = array_diff($colors_trim_db, $blades_colors_trimming);

                                    if($db_result)
                                    {
                                        // in case of multiple inputs going to change
                                        foreach ($db_result as $key_del_edit_color => $value_del_edit_color)
                                        {
                                            // Delete  : if blades-input were removed, which is gonna to be empty-input
                                            if ( empty($blades_colors_trimming[$key_del_edit_color]) )
                                            {
                                                DB::table('hierarchie_filter')
                                                    ->where('name', 'like', '%'.$value_del_edit_color.'%')
                                                    ->delete();

                                                
                                            }

                                            // Editing
                                            else
                                            {
                                                $prev_color_txt = $colors_trim_db[$key_del_edit_color];
                                                $prev_color = $previous_colors_filter[$key_del_edit_color];

                                                $new_color_txt= $blades_colors_trimming[$key_del_edit_color];

                                                $edited_color = str_replace($prev_color_txt,
                                                                            $new_color_txt,
                                                                            $prev_color);

                                                DB::table('hierarchie_filter')
                                                    ->where('name', 'like', $prev_color)
                                                    ->update(['name' => $edited_color]);

                                            }
                                        }
                                    }
                                }
                            }
                        }
                    } 
                }
            }
        }

        return redirect()->back();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    public function sub_adding(Request $request)
    {
        $sub_childs = $request->all();
        $parent_id  = $request->get('parent_id');
        $arr        = array();

        foreach ($sub_childs as $key => $value)
        {
            if( gettype($value) == 'array' )
            {
                foreach ($value as $key_2 => $value_2)
                {
                    foreach ($value_2 as $key_3 => $value_3)
                    {
                        $existance = DB::table('hierarchie_filter')->where('name', $value_3)->first();
                        array_push($arr, $existance);

                        // insert
                        if(!$existance)
                        DB::table('hierarchie_filter')->insert(
                                                [
                                                  'name'       => $value_3 ,
                                                  'ename'      => '-' ,
                                                  'parent_id'  => $key_2,
                                                  'category_id'=> $parent_id,
                                                  'filled'     => 1,
                                                 ]
                                              );

                        // update
                        else
                        {
                            DB::table('hierarchie_filter')
                                      ->where([
                                                'name'        => $value_3,
                                                'category_id' => $parent_id
                                             ])
                                      ->update([
                                                  'name'       => $value_3 ,
                                                  'ename'      => '-' ,
                                                  'parent_id'  => $key_2,
                                                  'category_id'=> $parent_id,
                                                ]);
                        }
                    }
                }
            }
        }

        

        return 'Done';
    }







    // Recursive Method to get all the categories/subcategories
    private function categoryTree($parent_id = 0, $sub_mark = '')
    {
        $query = DB::table('category')
                ->select('*')
                ->where('parent_id',$parent_id)
                ->get()
                ->pluck('cat_name','id');

        
        foreach ($query as $id => $value)
        {
            //echo $key." : ".$sub_mark.$value."</br>";
            array_push($this->categories, $sub_mark.$value.':'.$id);
            $this->categoryTree($id, $sub_mark.'---');
        }
        return $this->categories;
    }

}
