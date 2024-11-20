<?php

namespace App\Http\Controllers;

use App\Imports\MemberImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\UsersImport;

class MemberImportController extends Controller
{
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);

        Excel::queueImport(new MemberImport, $request->file('file'));

        return back()->with('success', 'Data berhasil diimpor!');
    }



}
