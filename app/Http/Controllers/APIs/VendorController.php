<?php

namespace App\Http\Controllers\APIs;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\VendorResource;
use App\Models\Vendor;
use App\Models\Placetype;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;

class VendorController extends Controller
{
    // create place type
    public function createPlaceType(Request $request){
        try{
            $validator = Validator::make($request->all(), [
                'name'      => 'required',
            ]);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' =>$validator->errors(), 'status' => 404]);
            }

            $createPType  = Placetype::create([
                'name' => $request->name,
            ]);

            //return redirect()->back()->with('success', 'Category has been created successfully.');
            if (!empty($createPType)) {
                return response()->json(['success' => true, 'message' => 'Created', 'status' => 200]);
            } else {
                return response()->json(['success' => false, 'message' => 'Not created', 'status' => 404]);
            }
        }catch (\Exception $e){
            return response()->json(["status" => false, "message" => $e->getMessage(), "status" => 400]);
        }
    }

    // place type list
    public function listPlaceType(){
        //return response()->json(['success' => Placetype::all()]);
        $pList = null;
        try{
            $pList = Placetype::all();

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

        // delete place type
    public function deletePlaceType(Request $request){
        try{
            $pt = null;
            $id = $request->placetype_id;
            //return response()->json(['success' => $id]);
            $pt = PlaceType::findOrFail($id);
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
     * Display a listing of Vendor's.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $data = new VendorResource(Vendor::get());

            if(!empty($data)){
                return response()->json(['success' => true, 'message' => 'Vendor\'s list.', Response::HTTP_CREATED]);
            }else{
                return response()->json(['success' => false, 'message' => 'No. list fond', Response::HTTP_NOT_FOUND]);
            }

        }catch (\Exception $e){
            return $this->sendError($e->getMessage());
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Vendor create api
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            $vendor = Vendor::create($request->all());
            $data = new VendorResource($vendor);

            if(!empty($data)){
                return response()->json(['success' => true, 'message' => 'Vendor created.', Response::HTTP_CREATED]);
            }else{
                return response()->json(['success' => false, 'message' => 'Not created.', Response::HTTP_NOT_FOUND]);
            }

        }catch (\Exception $e){
            return $this->sendError($e->getMessage());
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
     * Update the specified vendor based on id
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try{
            $updateInfo = Vendor::where('id', $id)->update($request->all());
            if(!empty($updateInfo)){
                return response()->json(['success' => true, 'message' => 'Vendor updated.', Response::HTTP_OK]);
            }else{
                return response()->json(['success' => false, 'message' => 'Not updated.', Response::HTTP_NOT_FOUND]);
            }
        }catch (\Exception $e){
            return $this->sendError($e->getMessage());
        }
    }


    /**
     * Soft delete the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $delRes = Vendor::where('id', $id)->delete();
            if(!empty($delRes)){
                //return $this->sendResponse('', 'Vendor soft deleted.', Response::HTTP_OK);
                return response()->json(['success' => true, 'message' => 'Vendor soft deleted.', Response::HTTP_OK]);
            }else{
                return response()->json(['success' => false, 'message' => 'Not deleted.', Response::HTTP_NOT_FOUND]);
            }
        }catch (\Exception $e){
            return $this->sendError($e->getMessage());
        }
    }

}

