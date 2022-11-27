<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EventType;
use App\Models\Event;

class DemoController extends Controller
{
    // check for dummy data    
    public function add()
    {
            // add event type
        $eventType = EventType::find(1);
        //dd($eventType->id);       
        Event::create([
        'eventtype_id' => $eventType->id, 'name' => 'Daily Music Party',    
        ]);
        
    }

    public function list()
    {
        
    }
}
