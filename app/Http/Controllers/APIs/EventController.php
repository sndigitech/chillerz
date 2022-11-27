<?php

namespace App\Http\Controllers\APIs;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventType;
use App\Models\Genre;
use Illuminate\Http\Request;
use App\Http\Resources\EventResource;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class EventController extends Controller
{
    // create event type
    public function createEventType(Request $request){
        $validator = Validator::make($request->all(), [
            'name'      => 'required',                                
        ]);
        if ($validator->fails()) {           
            return response()->json(['success' => false, 'message' =>$validator->errors(), 'status' => 404]);
        }       
        try{
            $validator = $request->validate([
                'name'      => 'required',               
            ]);

            $createEType  = Genre::create([
                'name' => $request->name,               
            ]);
                
            //return redirect()->back()->with('success', 'Category has been created successfully.');
            if (!empty($createEType)) {
                return response()->json(['success' => true, 'message' => 'Created', 'status' => 200]);
            } else {
                return response()->json(['success' => false, 'message' => 'Not created', 'status' => 404]);
            }
        }catch (\Exception $e){
            return response()->json(["status" => false, "message" => $e->getMessage(), "status" => 400]); 
        }               
    } 

        // list of event types
    public function eventTypeList(){ 
        //return response()->json(['success' => 'hi']);             
        try{
            $eventTypes = Genre::all(); 
            if(!empty($eventTypes)){
                return response()->json(['success' => true, 'message' => $eventTypes, 'status' => 200]);
            }
            else{
                return response()->json(['success' => false, 'message' => 'No event found.', 'status' => 204]);
            }
        }catch (\Exception $e){            
            return response()->json(["status" => false, "message" => $e->getMessage(), "status" => 400]); 
        }       
    }

    // delete place type
    public function deleteEventType(Request $request){
        $pt = null;
        try{          
            $id = $request->genretype_id;
            //return response()->json(['success' => $id]);
            $pt = Genre::findOrFail($id);
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


        // list of event types
    public function eventtypeById($id){              
        try{
            $eventType = EventType::find($id);
            if(!empty($eventType)){
                return response()->json(['success' => true, 'message' => $eventType, 'status' => 200]);
            }
            else{
                return response()->json(['success' => false, 'message' => 'No event found.', 'status' => 204]);
            }
        }catch (\Exception $e){
            return response()->json(["status" => false, "message" => $e->getMessage(), "status" => 400,]); 
        }       
    }     
     

    /**
     * Display a listing of events
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
           // $data = new EventResource(Event::get());
            $data = Event::all();

            if(!empty($data)){               
                return response()->json(['success' => true, 'message' => $data, 'status' => 200]);
            }else{               
                return response()->json(['success' => false, 'message' => 'Not fond.', 'status' => 404]);
            }
        }catch (\Exception $e){
            return response()->json(["status" => false, "message" => $e->getMessage(), "status" => 400]); 
        }
    }


    /**
     * Display a list of event by id
     *
     * @return \Illuminate\Http\Response
     */
    public function getEventById($id)
    {
        try{           
           $eventData = Event::find($id);
            if(!empty($eventData)){               
                return response()->json(['success' => true, 'message' => $eventData, 'status' => 200]);
            }else{               
                return response()->json(['success' => false, 'message' => 'Not fond.', 'status' => 404]);
            }

        }catch (\Exception $e){
            return response()->json(["status" => false, "message" => $e->getMessage(), "status" => 400]);
        }
    }


    /**
     * create event resource
     *
     * @return \Illuminate\Http\Response
     */
    public function createEvent(Request $request)
    {           
        try{
            $validator = Validator::make($request->all(), [            
                'genre_id' => 'required',                      
                'name' => 'required|unique:events', // 'required|unique:events'
            ]);
            if ($validator->fails()) {           
                return response()->json(['success' => false, 'message' => $validator->errors(), 'status' => 422]);
            }

            $event = Event::create([               
                'genre_id' => $request->genre_id,
                'name' => $request->name,
                'artist_name' => $request->artist_name,
                //'s_date_time' => $request->s_date_time,
                's_date_time' => Carbon::parse($request->s_date_time)->format('d-m-Y H:i:s'),
                //'e_date_time' => $request->e_date_time,
                'e_date_time' => Carbon::parse($request->e_date_time)->format('d-m-Y H:i:s'),                 
                'place' => $request->place,
                'details' => $request->details,
                'why_event' => $request->why_event,
                'terms_conditions' => $request->terms_conditions,
                'cover_image' => $request->cover_image,
            ]);
            if($event){
                    return response()->json(['success' => true, 'message' => 'Event created.', 'status' => 200]);
            }else{
                    return response()->json(['success' => false, 'message' => 'Not created.', 'status' => 404]);
            }

        }catch (\Exception $e) {           
            return response()->json(["status" => false, "message" => $e->getMessage(), "status" => 400]);           
        }
    }

    /**
     * Vendor create api
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       /* try{
            $event = Event::create($request->all());
            $data = new EventResource($event);

            if(!empty($data)){               
                return response()->json(['success' => true, 'message' => 'Event created.', Response::HTTP_OK]);
            }else{               
                return response()->json(['success' => false, 'message' => 'Event not created.', Response::HTTP_NOT_FOUND]);
            }

        }catch (\Exception $e){
            return $this->sendError($e->getMessage());
        }
        */

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
     * Update the specified attribute based on id
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * @ PUT/PATCH
     */
    // updating partial data 
    // getting data from Postman using PATCH always using x-www-form-urlencoded 
    public function updateEvent(Request $request, $id)
    {
        try{            
            $eventData = Event::find($id);            
            if($eventData){
                $updateInfo = $eventData->update($request->all());
                if(!empty($updateInfo)){               
                    return response()->json(['success' => true, 'message' => 'Event updated.', 'status' => 200]);
                }else{               
                   return response()->json(['success' => false, 'message' => 'Not updated.', 'status' => 404]);
                }
            }else{
                return response()->json(['success' => false, 'message' => 'Event not exist.', 'status' => 404]);
            }            
        }catch (\Exception $e){
            return response()->json(["status" => false, "message" => $e->getMessage(), "status" => 400]);
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
            $delRes = Event::where('id', $id)->delete();
            if(!empty($delRes)){               
                return response()->json(['success' => true, 'message' => 'Event deleted.', 'status' => 200]);
            }else{               
                return response()->json(['success' => false, 'message' => 'Not deleted.', 'status' => 404]);
            }
        }catch (\Exception $e){
            return response()->json(["status" => false, "message" => $e->getMessage(), "status" => 400]);
        }
    }

}
