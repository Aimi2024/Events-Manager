<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\EventResource;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return EventResource::collection(Event::with('user','attendees')->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       

     $validated = $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'start_time' => 'required|date',
        'end_time' => 'required|date|after_or_equal:start_time',
    ]);

    // Add user_id to the validated data
    $validated['user_id'] = 1;

    $event = Event::create($validated);

    return new EventResource($event);
    }
 
    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {

        $event->load('user','attendees'); // Eager load the user relationship
        return new EventResource($event);
    }
  

    /** 
     * Update the specified resource in storage.
     */
 public function update(Request $request, Event $event)
{
    $validated = $request->validate([
        'name' => 'sometimes|string|max:255',
        'description' => 'nullable|string',
        'start_time' => 'sometimes|date',
        'end_time' => 'sometimes|date|after_or_equal:start_time',
    ]);

    $event->update($validated);

    return new EventResource($event);
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        $event->delete();
        return response(status: 204); // No Content
    }
}
