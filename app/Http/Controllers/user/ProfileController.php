<?php


namespace App\Http\Controllers\user;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\Profile;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user() ?? null;
        return view('profile.index', compact('user')); //compact('user')
        //This is a PHP function that takes a variable name as a string and creates an associative array using the variable.

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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show()
{
    $user = auth()->user();
    $profile = $user->profile;

    if (!$profile) {
        return redirect()->route('profile')->with('error', 'Profile not found.');
    }

    return view('profile.show', compact('profile'));
}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Profile $profile)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
{
    $user = auth()->user();

    $validatedData = $request->validate([
        'full_name' => 'required|string|max:255',
        'gender' => 'nullable|in:male,female,other',
        'date_of_birth' => 'nullable|date',
        'phone_number' => 'nullable|string|max:20',
        'blood_type' => 'nullable|string|max:3',
        'allergies' => 'nullable|string', // Will be exploded into array
        'chronic_conditions' => 'nullable|string',
        'medications' => 'nullable|string',
        'prescription' => 'nullable|string',
        'pregnancy_status' => 'nullable|boolean',
        'weight' => 'nullable|numeric',
        'height' => 'nullable|numeric',
        'notes' => 'nullable|string'
    ]);

    $profile = $user->profile ?: new Profile(['user_id' => $user->id]);
    $profile->user_id = $user->id;
    $profile->full_name = $validatedData['full_name'];
    $profile->gender = $validatedData['gender'];
    $profile->date_of_birth = $validatedData['date_of_birth'];
    $profile->phone_number = $validatedData['phone_number'];
    $profile->blood_type = $validatedData['blood_type'];

    // Convert comma-separated strings to arrays, then JSON encode
    $profile->allergies = $request->allergies ? explode(',', $request->allergies) : [];
    $profile->chronic_conditions = $request->chronic_conditions ? explode(',', $request->chronic_conditions) : [];
    $profile->medications = $request->medications ? explode(',', $request->medications) : [];
    $profile->prescription = $request->prescription ? explode(',', $request->prescription) : [];

    $profile->pregnancy_status = $validatedData['pregnancy_status'];
    $profile->weight = $validatedData['weight'];
    $profile->height = $validatedData['height'];
    $profile->notes = $validatedData['notes'];

    $profile->save();

    return redirect()->route('profile.show')->with('success', 'Profile saved successfully.');

}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Profile $profile)
    {
        //
    }
}
