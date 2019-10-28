<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Category;
use App\Filter;

class FilterController extends Controller
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
            $filters_parent = Filter::where(
                                            ['category_id' => $selected_id,
                                            'parent_id'    => 0,
                                            ])
                                        ->get();
            
            // Adding new Element to the 'filters_parent' named 'get_childs' with the value of childs
            // e.g:
            // parent [id, category_id, name, ..., get_childs[ List-of-all-the-childs ] ]
            //
            // So just sending the 'filters_parent' will get the job done.
            //
            $childs = Filter::with('get_childs')
                            ->where(['category_id'=>$selected_id,'parent_id'=>0])
                            ->get();
            
            return view('admin/filter/index')->with(['categories'     => $categories,
                                                     'selected_id'    => $selected_id,
                                                     'filters_parent' => $filters_parent,
                                                     ]);
        }

        else
            return view('admin/filter/index')->with('categories', $categories);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $id = $request->get('id');
        $category = Category::findOrFail($id);

        $filter_name_parent  = $request->get('filter_name_parent');
        $filter_ename_parent = $request->get('filter_ename_parent');
        $select_option       = $request->get('parent_option');   // radio or color
        $filter_name_child   = $request->get('filter_name_child');
        $filter_color_child  = $request->get('filter_color_child');

        //return $request->all();

        $inserted_item_count = 0;

        foreach ($filter_name_parent as $key => $value)
        {
            if ($key<0 && !empty($value))
            {
                // Inserting parents-filter
                $ename = array_key_exists($key, $filter_ename_parent) ? $filter_ename_parent[$key] : '';
                $selected_option_item = array_key_exists($key, $select_option) ? $select_option[$key] : 1;

                $inserted_parent_id = DB::table('filter')->insertGetId(
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
                            DB::table('filter')->insert(
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

                            DB::table('filter')->insert(
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
                    DB::table('filter')->where('id', $key)->delete();

                    DB::table('filter')->where('parent_id', $key)->delete();
                }

                // 1. Editing parents-filter
                // 2. child-filter: Deleting, Editing, Inserting
                if(!empty($value))
                {
                    // Update the current value-parent whether changed or not
                    $previous_parent_filter = DB::table('filter')->where('id', $key)
                                                                 ->update(['name' => $value]);

                   if(is_array($filter_name_child) && array_key_exists($key, $filter_name_child))
                    {
                        foreach ($filter_name_child[$key] as $key_child => $value_child)
                        {
                            $previous_child_filter = DB::table('filter')->where('id', $key_child)
                                                                        ->pluck('name');

                            // Comparing current-child and inserted-child-databse
                            if($value_child != $previous_child_filter)
                            {
                                // Deleteing
                                if(empty($value_child))
                                {
                                    DB::table('filter')->where('id', $key_child)->delete();
                                }

                                // Editing                         
                                if(!empty($value_child))
                                {
                                    DB::table('filter')->where('id', $key_child)
                                                       ->update(['name' => $value_child]);
                                    
                                }

                                // Inserting:  if key_child<0 => New Child-filter
                                if($key_child<0 && !empty($value_child))
                                {                                    
                                    DB::table('filter')->insert(
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
                }
            }
        }

        return redirect()->back();
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
