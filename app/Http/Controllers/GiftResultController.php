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
        dd($request->all());

        $validateData=Validator::make($request->all(),
        [
                'event_id' => 'required|integer',
                'member_id' => 'required|integer',
                'gift_id' => 'required|integer',
                'status'=>'required|integer',
        ]);

        if ($validateData->fails()) {
            return response()->json($validateData->errors());
        }
        else{
           GiftResult::create($request->all());
            return redirect()->route('giftresults.index')->with('success','data has been created');
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
