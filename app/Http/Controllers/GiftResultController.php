<?php

namespace App\Http\Controllers;

use App\Models\GiftResult;
use App\Http\Requests\StoreGiftResultRequest;
use App\Http\Requests\UpdateGiftResultRequest;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;

class GiftResultController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $giftResults=GiftResult::all();


        return view('pages.mastergiftresult',compact('giftResults'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // $validator = Validator::make($request->all(), [
            //     'event_id' => 'required|integer',
            //     'gift_id' => 'required|integer',
            //     'member_code' => 'required',
            // ]);

            // if(validator()->fails()){
            //     return response()->json(['errors' => $validator->errors()], 422);
            // }

            GiftResult::create([
                'event_id' => $request['event_id'], // Use a valid ID from your database
                'gift_id' =>   $request['gift_id'],  // Use a valid ID from your database
                'member_code' => $request['member_code'], // Use a valid ID from your database
                'status' => 0,
            ]);
            return response()->json(['message' => 'Data has been created successfully!'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to store lottery result'], 500);
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(GiftResult $giftResult)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(GiftResult $giftResult)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGiftResultRequest $request, GiftResult $giftResult)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(GiftResult $giftResult)
    {
        //
    }
}
