<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $events = Event::all();

        // Check if an event ID is provided for editing
        $event = null;
        if ($request->has('edit')) {
            $event = Event::findOrFail($request->input('edit'));
        }

        return view('pages.masterevent', compact('events', 'event'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'date_start' => 'required|date',
            'date_end' => 'required|date|after_or_equal:date_start',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

       Event::create($request->all());

        return redirect()->route('events.index')->with('success', 'Event created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $event = Event::find($id);

        if (!$event) {
            return response()->json(['message' => 'Event not found'], 404);
        }

        return response()->json($event);
    }

    public function edit($id)
{
    $event = Event::findOrFail($id);

    return view('events.edit', compact('event'));
}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
{

    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'date_start' => 'required|date',
        'date_end' => 'required|date',
    ]);

    $event = Event::findOrFail($id);

    $event->update([
        'name' =>$request->name ,
        'date_start' => $request->date_start,
        'date_end' => $request->date_end,
    ]);


    return redirect()->route('events.index')->with('success', 'Event updated successfully!');
}
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $event = Event::find($id);

        if (!$event) {
            return response()->json(['message' => 'Event not found'], 404);
        }

        $event->delete();
        return redirect()->route('events.index')->with('success','Event deleted succesfully');
    }
}
