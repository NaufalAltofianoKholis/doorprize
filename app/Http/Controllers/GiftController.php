<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Gift;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GiftController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $gifts = Gift::all();
        $events= Event::all();

        // Check if a gift ID is provided for editing
        $gift = null;
        if ($request->has('edit')) {
            $gift = Gift::findOrFail($request->input('edit'));
        }

        return view('pages.mastergift', compact('gifts', 'gift', 'events'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'event_id' => 'required|integer',
            'stock' => 'required|integer|min:0',
            'is_main_doorprize' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        Gift::create($request->all());

        return redirect()->route('gifts.index')->with('success', 'Gift created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $gift = Gift::find($id);

        if (!$gift) {
            return response()->json(['message' => 'Gift not found'], 404);
        }

        return response()->json($gift);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $gift = Gift::findOrFail($id);

        // Return gift data as JSON
        return response()->json($gift);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'event_id' => 'required|integer',
            'stock' => 'required|integer|min:0',
            'is_main_doorprize' => 'required|boolean',
        ]);

        $gift = Gift::findOrFail($id);

        $gift->update([
            'name' => $request->name,
            'event_id' => $request->event_id,
            'stock' => $request->stock,
            'is_main_doorprize' => $request->is_main_doorprize,
        ]);

        return redirect()->route('gifts.index')->with('success', 'Gift updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $gift = Gift::find($id);

        if (!$gift) {
            return response()->json(['message' => 'Gift not found'], 404);
        }

        $gift->delete();
        return redirect()->route('gifts.index')->with('success', 'Gift deleted successfully');
    }
}
