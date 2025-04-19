<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SymptomCheckerController extends Controller
{
    public function showForm()
    {
        $symptoms = file(base_path('symptoms.txt'), FILE_IGNORE_NEW_LINES);
        return view('symptom_form', ['symptomList' => $symptoms]);
    }

    public function predict(Request $request)
    {
        $response = Http::post('http://127.0.0.1:5000/predict', [
            'symptoms' => $request->input('symptoms')
        ]);

        if ($response->successful()) {
            return back()->with('result', $response['disease']);
        } else {
            return back()->withErrors(['error' => 'Could not get prediction']);
        }
    }
}

