<?php

namespace App\Http\Controllers;
use App\Models\MedicationPlan;
use Illuminate\Http\Request;

class MedicationPlanController extends Controller
{
    public function index()
{
    $plans = MedicationPlan::where('user_id', auth()->id())
        ->orderBy('date')
        ->orderBy('time')
        ->get();

    return view('medication_plan.index', compact('plans'));
}

public function store(Request $request)
{
    $request->validate([
        'medication_name' => 'required',
        'dosage' => 'nullable',
        'time' => 'required',
        'date' => 'required|date',
    ]);

    MedicationPlan::create([
        'user_id' => auth()->id(),
        'medication_name' => $request->medication_name,
        'dosage' => $request->dosage,
        'time' => $request->time,
        'note' => $request->note,
        'date' => $request->date,
    ]);

    return redirect()->back()->with('success', 'Medication added to your plan!');
}
}
