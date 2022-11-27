<?php

namespace App\Http\Controllers\APIs;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\ArtistResource;
use App\Models\Artist;
use App\Models\Artisttype;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;

class ArtistController extends Controller
{
        // create artist type
    public function createArtistType(Request $request){
        //return response()->json(['success' => $request->all()]);
        try{
            $validator = Validator::make($request->all(), [
                'name'      => 'required',                                
            ]);
            if ($validator->fails()) {           
                return response()->json(['success' => false, 'message' =>$validator->errors(), 'status' => 404]);
            }           

            $createAType  = Artisttype::create([
                'name' => $request->name,               
            ]);                
            
            if (!empty($createAType)) {
                return response()->json(['success' => true, 'message' => 'Created', 'status' => 200]);
            } else {
                return response()->json(['success' => false, 'message' => 'Not created', 'status' => 404]);
            }
        }catch (\Exception $e){
            return response()->json(["status" => false, "message" => $e->getMessage(), "status" => 400]); 
        }               
    } 
    
    // artist type list
    public function listArtistType(){       
        $pList = null;
        try{
            $pList = Artisttype::all();
                
            //return redirect()->back()->with('success', 'Category has been created successfully.');
            if (!empty($pList)) {
                return response()->json(['success' => true, 'message' => $pList, 'status' => 200]);
            } else {
                return response()->json(['success' => false, 'message' => 'Not cotent', 'status' => 404]);
            }
        }catch (\Exception $e){
            return response()->json(["status" => false, "message" => $e->getMessage(), "status" => 400]); 
        }               
    }

     // delete artist type
     public function deleteArtistType(Request $request){
        try{
            $pt = null;
            $id = $request->artisttype_id;
            //return response()->json(['success' => $id]);
            $pt = Artisttype::findOrFail($id);
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
     * Display a listing of the Artist.
     *
     * @return \Illuminate\Http\Response
     */
    public function artistList()
    {
        try{
            $data = Artist::all();

            if(!empty($data)){                
                return response()->json(['success' => true, 'message' => $data, 'status' => 200]);
            }else{               
                return response()->json(['success' => false, 'message' => 'list notfond', 'status' => 404]);
            }
        }catch (\Exception $e) {           
            return response()->json(["status" => false, "message" => $e->getMessage(), "status" => 400]);           
        }
    }

    /**
     * Display a list of event by id
     *
     * @return \Illuminate\Http\Response
     */
    public function artistListById($id)
    {       
        try{           
           $artistData = Artist::find($id);
            if(!empty($artistData)){               
                return response()->json(['success' => true, 'message' => $artistData, 'status' => 200]);
            }else{               
                return response()->json(['success' => false, 'message' => 'Not fond.', 'status' => 404]);
            }

        }catch (\Exception $e){
            return response()->json(["status" => false, "message" => $e->getMessage(), "status" => 400]);
        }
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Create Artist API
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            $validator = Validator::make($request->all(), [
                'artisttype_id'      => 'required',
                'name'      => 'required',
                'email'      => 'required',
                'gender'      => 'required',
                'contact_number' => 'required',                                             
            ]);
            if ($validator->fails()) {           
                return response()->json(['success' => false, 'message' =>$validator->errors(), 'status' => 404]);
            } 
           // dd($request->all());
            $data = Artist::create($request->all());
            
            
           // $data = new ArtistResource($artist);


            if(!empty($data)){               
                return response()->json(['success' => true, 'message' => 'Created.',  'status' => 200]);
            }else{                
                return response()->json(['success' => false, 'message' => 'Not created.', 'status' => 404]);
            }

        }catch (\Exception $e) {           
            return response()->json(["status" => false, "message" => $e->getMessage(), "status" => 400]);           
        }
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
     * Update the specified artist based on id
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try{
            $updateInfo = Artist::where('id', $id)->update($request->all());
            if(!empty($updateInfo)){                
                return response()->json(['success' => true, 'message' => 'Updated.',  'status' => 200]);
            }else{                
                return response()->json(['success' => false, 'message' => 'Not updated.', 'status' => 404]);
            }
        }catch (\Exception $e){
            return response()->json(["status" => 400, "message" => $e->getMessage()]); 
        }  
    }

    /**
     * Soft delete the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        try{
            $delRes = Artist::where('id', $id)->delete();
            if(!empty($delRes)){               
                return response()->json(['success' => true, 'message' => 'Deleted.',  Response::HTTP_OK]);
            }else{             
                return response()->json(['success' => false, 'message' => 'Not deleted.', Response::HTTP_NOT_FOUND]);
            }
        }catch (\Exception $e){
            return response()->json(["status" => 400, "message" => $e->getMessage()]); 
        }  
    }
}
