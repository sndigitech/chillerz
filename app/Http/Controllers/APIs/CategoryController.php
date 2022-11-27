<?php

namespace App\Http\Controllers\APIs;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    // list of category
    public function list(){       
        //$categories = Category::all();
        try{
            $categories = Category::where('id', '>', 0)->orderby('id', 'desc')->get();
            if(!empty($categories)){
                return response()->json(['success' => true, 'message' => $categories, 'status' => 200]);
            }
            else{
                return response()->json(['success' => true, 'message' => 'Not found.', 'status' => 204]);
            }
        }catch (\Exception $e){
            return response()->json(["status" => 400, "message" => $e->getMessage()]); 
        }       
    }

    // create category / OK / Tested
    public function create(Request $request){
        //return response()->json(['success' => 'create category.']);
        try{
            $validator = $request->validate([
                'name'      => 'required',
                'slug'      => 'required|unique:categories',                
            ]);

            $cat = Category::create([
                'name' => $request->name,
                'slug' => $request->slug,               
            ]);
                
            //return redirect()->back()->with('success', 'Category has been created successfully.');
            if (!empty($cat)) {
                return response()->json(['success' => true, 'message' => 'Created', 'status' => 200]);
            } else {
                return response()->json(['success' => false, 'message' => 'Not created', 'status' => 404]);
            }
        }catch (\Exception $e){
            return response()->json(["status" => 400, "message" => $e->getMessage()]); 
        }               
    }  
    
    public function deleteCategory(Request $request){
        try{
            $id = $request->cat_id;
            //return response()->json(['success' => $id]);
            $cat = Category::findOrFail($id);
            $result = $cat->delete();
            if($result){            
                return response()->json(['success' => true, 'message' => 'Record has been deleted', 'status' => 200]);
            }
            else{
                return response()->json(['success' => false, 'message' => 'Record not deleted', 'status' => 404]);
            }
        }catch (\Exception $e){
            return response()->json(["status" => 400, "message" => $e->getMessage()]); 
        }   
    }

    // list of category based on parent_id
    public function listByParentId($parent_id){               
        $categories = Category::where('parent_id', $parent_id)->orderby('id', 'desc')->get();        
        try{
            if(!empty($categories)){
                return response()->json(['success' => true, 'message' => $categories, 'status' => 200]);
            }
            else{
                return response()->json(['success' => true, 'message' => 'Not found.', 'status' => 204]);
            }
        }catch (\Exception $e){
            return response()->json(["status" => 400, "message" => $e->getMessage()]); 
        }       
    } 

    // list of category by id
    public function listByCategoryId($category_id){        
        $categories = Category::where('id', $category_id)->orderby('id', 'desc')->get();
        //$categories = Category::all();
        try{
            if(!empty($categories)){
                return response()->json(['success' => true, 'message' => $categories, 'status' => 200]);
            }
            else{
                return response()->json(['success' => true, 'message' => 'Not found.', 'status' => 204]);
            }
        }catch (\Exception $e){
            return response()->json(["status" => 400, "message" => $e->getMessage()]); 
        }       
    }  
        
}
