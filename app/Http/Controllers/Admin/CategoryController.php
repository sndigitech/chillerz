<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    // list of category
    public function list(){
        //$categories = Category::where('parent_id', null)->orderby('name', 'asc')->get();
        //$categories = Category::where('parent_id', null)->orderby('name', 'asc')->get();
        $categories = Category::all();
        try{
            if(!empty($categories)){
                return response()->json(['success' => true, 'message' => $categories, 'status' => 200]);
            }
            else{
                return response()->json(['success' => true, 'message' => 'No category found.', 'status' => 204]);
            }
        }catch (\Exception $e){
            return response()->json(["status" => 400, "message" => $e->getMessage()]); 
        }       
    }

    // create category
    public function create(Request $request){
        try{
            $validator = $request->validate([
                'name'      => 'required',
                'slug'      => 'required|unique:categories',
                'parent_id' => 'nullable|numeric'
            ]);

            $cat = Category::create([
                'name' => $request->name,
                'slug' => $request->slug,
                'parent_id' =>$request->parent_id
            ]);
                
            //return redirect()->back()->with('success', 'Category has been created successfully.');
            if (!empty($cat)) {
                return response()->json(['success' => true, 'message' => 'Category created.', 'status' => 200]);
            } else {
                return response()->json(['success' => false, 'message' => 'Category not created.', 'status' => 404]);
            }
        }catch (\Exception $e){
            return response()->json(["status" => 400, "message" => $e->getMessage()]); 
        }        
    }
    
    public function createCategory_xyz(Request $request)
    {
        $categories = Category::where('parent_id', null)->orderby('name', 'asc')->get();
        if($request->method()=='GET')
        {
            try{
                if(!empty($categories)){
                    return response()->json(['success' => true, 'message' => $categories, 'status' => 200]);
                }
                else{
                    return response()->json(['success' => true, 'message' => 'No category found.', 'status' => 204]);
                }
            }catch (\Exception $e){
                return response()->json(["status" => 400, "message" => $e->getMessage()]); 
            }           
            //return view('create-category', compact('categories'));
        }
        if($request->method()=='POST')
        {
            try{
                $validator = $request->validate([
                    'name'      => 'required',
                    'slug'      => 'required|unique:categories',
                    'parent_id' => 'nullable|numeric'
                ]);
    
                $cat = Category::create([
                    'name' => $request->name,
                    'slug' => $request->slug,
                    'parent_id' =>$request->parent_id
                ]);
                //var_dump($cat);    
                //return redirect()->back()->with('success', 'Category has been created successfully.');
                if (!empty($cat)) {
                    return response()->json(['success' => true, 'message' => 'Category created.', 'status' => 200]);
                } else {
                    return response()->json(['success' => false, 'message' => 'Category not created.', 'status' => 404]);
                }
            }catch (\Exception $e){
                return response()->json(["status" => 400, "message" => $e->getMessage()]); 
            }             
        }
    }
}
