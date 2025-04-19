<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\DrugsImport;
use Maatwebsite\Excel\Facades\Excel;

class DrugImportController extends Controller
{
    public function showImportForm()
    {
        return view('import');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls'
        ]);

        Excel::import(new DrugsImport, $request->file('file'));

        return back()->with('success', 'Drugs imported successfully!');
    }
}

