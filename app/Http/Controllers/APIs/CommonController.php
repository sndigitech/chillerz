<?php

namespace App\Http\Controllers\APIs;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Menuitem;
use App\Models\Menu;
use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CommonController extends Controller
{

    // create menu name
public function createmenuName(Request $request){
    try{
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' =>$validator->errors(), 'status' => 404]);
        }
        $menuName = $request->name;
        // $data = new EventResource(Event::get());
         $data = Menu::create([
            'name' => $menuName
         ]);

         if(!empty($data)){
             return response()->json(['success' => true, 'message' => $data, 'status' => 200]);
         }else{
             return response()->json(['success' => false, 'message' => 'Not created.', 'status' => 404]);
         }
     }catch (\Exception $e){
         return response()->json(["status" => false, "message" => $e->getMessage(), "status" => 400]);
     }

}


     /**
     * Display a listing of menu name items
     *
     * @return \Illuminate\Http\Response
     */
    public function menuNameList()
    {
        try{
           // $data = new EventResource(Event::get());
            $data = Menu::all();

            if(!empty($data)){
                return response()->json(['success' => true, 'message' => $data, 'status' => 200]);
            }else{
                return response()->json(['success' => false, 'message' => 'Not created.', 'status' => 404]);
            }
        }catch (\Exception $e){
            return response()->json(["status" => false, "message" => $e->getMessage(), "status" => 400]);
        }
    }

    /**
     * Display a listing of menu name by id
     *
     * @return \Illuminate\Http\Response
     */
    public function menuNameListById($id)
    {
        try{
           // $data = new EventResource(Event::get());
            $data = Menu::find($id);

            if(!empty($data)){
                return response()->json(['success' => true, 'message' => $data, 'status' => 200]);
            }else{
                return response()->json(['success' => false, 'message' => 'Not created.', 'status' => 404]);
            }
        }catch (\Exception $e){
            return response()->json(["status" => false, "message" => $e->getMessage(), "status" => 400]);
        }
    }

    // update menuname
    public function menunameupdate(Request $request, $id){
        try{
            $menuData = Menu::find($id);
            $updateInfo = $menuData->update($request->all());
            if(!empty($updateInfo)){
                return response()->json(['success' => true, 'message' => 'Updated.', 'status' => 200]);
            }else{
               return response()->json(['success' => false, 'message' => 'Not updated.', 'status' => 404]);
            }

        }catch (\Exception $e){
            return response()->json(["status" => false, "message" => $e->getMessage(), "status" => 400]);
        }

    }

     // delete menu name
     public function menunamedelete(Request $request, $id){
        try{
           // $pt = null;
           // $id = $request->menuitem_id;
            //return response()->json(['success' => $id]);
            $pt = Menu::findOrFail($id);
            $result = $pt->delete();
            if($result){
                return response()->json(['success' => true, 'message' => 'Deleted', 'status' => 200]);
            }
            else{
                return response()->json(['success' => false, 'message' => 'Not deleted', 'status' => 404]);
            }
        }catch (\Exception $e){
            return response()->json(["status" => 400, "message" => $e->getMessage()]);
        }
    }


    /**
     * Display a listing of status items
     *
     * @return \Illuminate\Http\Response
     */
    public function statusList()
    {
        try{
           // $data = new EventResource(Event::get());
            $data = Status::all();

            if(!empty($data)){
                return response()->json(['success' => true, 'message' => $data, 'status' => 200]);
            }else{
                return response()->json(['success' => false, 'message' => 'Not created.', 'status' => 404]);
            }
        }catch (\Exception $e){
            return response()->json(["status" => false, "message" => $e->getMessage(), "status" => 400]);
        }
    }

    //  create menu item
    public function createMenu(Request $request){
        $validator = Validator::make($request->all(), [
            'category_id' => 'required',
            'brand' => 'required',
            'price' => 'required',
            'uploaded_brand_image' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' =>$validator->errors(), 'status' => 404]);
        }

        try{

            $menuResponse = Menuitem::create([
                'category_id' => $request->category_id,
                'brand' => $request->brand,
                'price' => $request->price,
                'uploaded_brand_image' => $request->uploaded_brand_image,
            ]);

            if(!empty($menuResponse)){
                    return response()->json(['success' => true, 'message' => $menuResponse, 'status' => 200]);
            }else{
                    return response()->json(['success' => false, 'message' => 'Not created.', 'status' => 404]);
            }

        }catch (\Exception $e){
            return response()->json(["status" => false, "message" => $e->getMessage(), "status" => 400]);
        }
    }


    /**
     * Display a listing of menu items
     *
     * @return \Illuminate\Http\Response
     */
    public function menuList()
    {
        try{
           // $data = new EventResource(Event::get());
            $data = Menuitem::all();

            if(!empty($data)){
                return response()->json(['success' => true, 'message' => $data, 'status' => 200]);
            }else{
                return response()->json(['success' => false, 'message' => 'Not created.', 'status' => 404]);
            }
        }catch (\Exception $e){
            return response()->json(["status" => false, "message" => $e->getMessage(), "status" => 400]);
        }
    }

        // menu list based on id
    public function menuListById($id){
        $menuData = Menuitem::find($id);
            if(!empty( $menuData)){
                return response()->json(['success' => true, 'message' =>  $menuData, 'status' => 200]);
            }else{
                return response()->json(['success' => false, 'message' => 'Not fond.', 'status' => 404]);
            }
    }

    /**
     * Update the specified attribute based on id
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * @ PUT/PATCH
     */
    // updating partial data
    // getting data from Postman using PATCH always using x-www-form-urlencoded
    public function update(Request $request, $id)
    {
        try{
                $menuData = Menuitem::find($id);
                $updateInfo = $menuData->update($request->all());
                //$updateInfo = Menuitem::where('id', $id)->update($request->all());
               // return response()->json(['success' =>  $updateInfo]);
                if(!empty($updateInfo)){
                    return response()->json(['success' => true, 'message' => 'Updated.', 'status' => 200]);
                }else{
                   return response()->json(['success' => false, 'message' => 'Not updated.', 'status' => 404]);
                }

        }catch (\Exception $e){
            return response()->json(["status" => false, "message" => $e->getMessage(), "status" => 400]);
        }
    }

     // delete menu items
     public function deleteMenu(Request $request){
        try{
            $pt = null;
            $id = $request->menuitem_id;
            //return response()->json(['success' => $id]);
            $pt = Menuitem::findOrFail($id);
            $result = $pt->delete();
            if($result){
                return response()->json(['success' => true, 'message' => 'Deleted', 'status' => 200]);
            }
            else{
                return response()->json(['success' => false, 'message' => 'Not deleted', 'status' => 404]);
            }
        }catch (\Exception $e){
            return response()->json(["status" => 400, "message" => $e->getMessage()]);
        }
    }

}
