<?php

namespace App\Http\Controllers;


use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
            // 'email' => 'required|email',
            // 'phone' => 'required|string|max:15',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        Member::create($request->all());

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
