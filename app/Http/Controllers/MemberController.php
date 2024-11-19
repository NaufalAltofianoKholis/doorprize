<?php

namespace App\Http\Controllers;


use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $members = Member::all();
        $member = null;
        if ($request->has('edit')) {
            $member = Member::findOrFail($request->input('edit'));
        }
        return view('pages.mastermember', compact('members','member'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'member_code' => 'required|string|max:4|min:4|unique:members,member_code',
        ],
        [
            'name.required' => 'Nama haris diisi.',
            'name.string' => 'Name must be a string.',
            'name.max' => 'Name cannot exceed 255 characters.',
            'member_code.required' => 'Member code harus diisi.',
            'member_code.string' => 'Member code must be a string.',
            'member_code.max' => 'Member code maximal berisi 4 digit.',
            'member_code.min' => 'Member code minimal berisi 4 digit.',
            'member_code.unique' => 'Member code sudah ada.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $statusAktif=1;

        // $latestMember= Member::orderBy('id','desc')->first();

        // $code = $latestMember ? $latestMember->id+1 : 1;

        // $memberCode= str_pad((string)$request['member_code'],4,"0",STR_PAD_LEFT);

        $memberCode=$request['member_code'];

        Member::create([
            'name'=>$request['name'],
            'status'=>$statusAktif,
            'member_code'=>$memberCode
        ]);


        return redirect()->route('members.index')->with('success', 'Member added successfully!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $member = Member::findOrFail($id);
        return response()->json($member);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'member_code' => 'required|string|max:255',
            // 'email' => 'required|email',
            // 'phone' => 'required|string|max:15',
        ]);

        $member = Member::findOrFail($id);

        $member->update($request->all());

        return redirect()->route('members.index')->with('success', 'Member updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $member = Member::find($id);

        if (!$member) {
            return response()->json(['message' => 'Member not found'], 404);
        }

        $member->delete();
        return redirect()->route('members.index')->with('success', 'Member deleted successfully!');
    }


}
