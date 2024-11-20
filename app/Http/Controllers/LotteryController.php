<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Gift;
use App\Models\Member;
use Illuminate\Http\Request;

class LotteryController extends Controller
{
    //buat nyari event&nampilin
    public function showEvent(){
        $events=Event::all();
        return response()->json($events);
    }

    //buat nyari gift yang berkaitan dengan event tertentu, dan bukan sebuah doorprize
    public function showRegularGift($id){
        $gift= Gift::where('event_id',$id)
        ->get();

        return response()->json($gift);
    }

    public function showItemStock($id){
        $giftStock= Gift::where('id',$id)->get();
        return response()->json($giftStock);
    }

    public function getMemberCodes(){
        $member= Member::where('status',1)->get();

        // $member= Member::all();

        return response()->json($member);
    }
}
