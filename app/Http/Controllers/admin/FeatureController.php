<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Feature;
use App\Category;
use App\Product;
use App\ParentProduct;
use App\Filter;

class FeatureController extends Controller
{
    private $categories = array();


    public function index(Request $request)
    {
    	$categories = self::categoryTree();

    	if($request->get('id'))
        {
            $selected_id = $request->get('id');


            // Get the parents' feature
            $parent = Feature::where([
            						 'category_id' => $selected_id,
                                     'parent_id'   => 0,
                                     ])
                                   ->get();
            
            // Adding 'get_childs'(array) to the 'parent' 
            // e.g: parent [id, category_id, name, ..., get_childs[ List-of-all-the-childs ] ]
            //
            // So just sending the 'childs' will get the job done.

            $parents_and_childs = Feature::with('get_childs')
                            	->where(['category_id'=>$selected_id,'parent_id'=>0])
                            	->get();

    		return view('admin/feature/index')->with(['categories'    => $categories,
                                                      'selected_id'   => $selected_id,
                                                      'parents_and_childs' => $parents_and_childs,
                                                     ]);
    	}
    	else
    		return view('admin/feature/index')->with('categories', $categories);

    }

    public function create(Request $request)
    {
    	$id = $request->get('id');

        $feature_names_parent  = $request->get('feature_name_parent');
        $select_option         = $request->get('parent_option');
        $feature_names_child   = $request->get('feature_name_child');

        foreach ($feature_names_parent as $key_parent => $value_parent)
        {
        	if($key_parent<0 && !empty($value_parent))
        	{
        		// Inserting parent-feature
        		// Getting inserted current-id => to be: parent-id for the child-features
        		$inserted_parent_id =  DB::table('feature')->insertGetId(
		                                        ['category_id' => $id    ,
		                                         'name'        => $value_parent ,
		                                         'parent_id'   => 0 ,
		                                         'filled'      => 1 ,
		                                         ]
		                                    );

        		// Inserting child-features
        		if(array_key_exists($key_parent, $feature_names_child))
        		{
        			foreach ($feature_names_child[$key_parent] as $key_child => $value_child)
        			{
        				if(!empty($value_child))
        				{
        					DB::table('feature')->insert(
		                                        ['category_id' => $id    ,
		                                         'name'        => $value_child ,
		                                         'parent_id'   => $inserted_parent_id ,
		                                         'filled'      => 1 ,
		                                         ]
		                                    );
        				}        				
        			}
        		}
        	}
        	else
        	{
        		// If parent's input was removed:  1.Delete parents  2.Delete childs-feature
        		if(empty($value_parent))
                {
                    DB::table('feature')->where('id', $key_parent)->delete();

                    DB::table('feature')->where('parent_id', $key_parent)->delete();
                }

                // 1. Editing parents-feature
                // 2. child-feature: Deleting, Editing, Inserting
                if(!empty($value_parent))
                {
                	// Parent: Editing               	
                	$previous_child = DB::table('feature')->where('id', $key_parent)->pluck('name');
                	if( $previous_child != $value_parent )
                	{
                		DB::table('feature')->where('id', $key_parent)->update(['name' => $value_parent]);
                	}

                	// Child: Inserting, Deleting, Editing
	        		if(array_key_exists($key_parent, $feature_names_child))
	        		{
		        		foreach ($feature_names_child[$key_parent] as $key_child => $value_child)
		        		{
		        			// Inserting
		        			if( $key_child<0 && !empty($value_child))
		        			{
		        				DB::table('feature')->insert([
		        											 'category_id' => $id    ,
					                                         'name'        => $value_child ,
					                                         'parent_id'   => $key_parent ,
					                                         'filled'      => 1 ,
					                                         ]);
		        			}
		        			
		        			else
		        			{
		        				// Deleting
		        				if(empty($value_child))
			        			{
			        				DB::table('feature')->where('id', $key_child )->delete();
			        			}

			        			// Editing
			        			else
			        			{
			        				$previous_child = DB::table('feature')->where('id', $key_child)
                                                                	 	  ->pluck('name');

                                    if ( $previous_child != $value_child )
                                    {
                                    	DB::table('feature')->where('id', $key_child)
                                                  			->update(['name' => $value_child]);
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


    public function list()
    {
        $features = Category::with('Feature')->get();

        return view('admin/feature/list')->with('features', $features);
    }

    public function add($product_id=null , $category_id=null)
    {

        if( !empty($product_id) and empty($category_id)  )
        {
            $product = Product::findOrFail($product_id);

            $product_To_category = Product::ProductID_To_CategoryName($product_id);

            $category_id=(array)$product_To_category[0]->parent_id;
            $parents = Product::getParent($category_id);

            return view('admin/feature/add')->with(['product' => $product,
                                                    'parents' => $parents]);
        }

        else
        {
            if( !empty($product_id) and !empty($category_id) )
            {
                $features = Feature::where('category_id', $category_id)->get();
                $product  = Product::findOrFail($product_id);
                $category = Category::findOrFail($category_id);

                //return [$features, $product, $category];

                return view('admin/feature/implement')->with(['features' => $features,
                                                              'product'  => $product,
                                                              'category' => $category,
                                                            ]);
            }

            else
            {
                return abort(404);
            }
        }

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
