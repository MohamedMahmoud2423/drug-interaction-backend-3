@extends('layouts.app')

@section('content')
    <div class="container-lg">
        <h2 class="text-center">{{ "Welcome, $user->name" }}</h2>
        <hr>

        <form method="POST" action="{{ route('profile.update') }}">

            @csrf
            @method('PUT')

            <div class="row row-cols-2 g-3">

                <div class="col">
                    <label for="name" class="fw-bold">Name</label>
                    <input type="text" name="full_name" class="form-control" id="name" value="{{ old('full_name', $profile->full_name ?? '') }}">
                </div>

                <div class="col">
                    <label for="gender" class="fw-bold">Gender</label>
                    <select name="gender" id="gender" class="form-control">
                        <option value="">Select</option>
                        <option value="male" {{ (old('gender', $profile->gender ?? '') == 'male') ? 'selected' : '' }}>Male</option>
                        <option value="female" {{ (old('gender', $profile->gender ?? '') == 'female') ? 'selected' : '' }}>Female</option>
                        <option value="other" {{ (old('gender', $profile->gender ?? '') == 'other') ? 'selected' : '' }}>Other</option>
                    </select>
                </div>

                <div class="col">
                    <label for="dob" class="fw-bold">Date of Birth</label>
                    <input type="date" name="date_of_birth" class="form-control" id="dob" value="{{ old('date_of_birth', $profile->date_of_birth ?? '') }}">
                </div>



                <div class="col">
                    <label for="phone" class="fw-bold">Phone Number</label>
                    <input type="text" name="phone_number" class="form-control" id="phone" value="{{ old('phone_number', $profile->phone_number ?? '') }}">
                </div>

                <div class="col">
                    <label for="blood_type" class="fw-bold">Blood Type</label>
                    <input type="text" name="blood_type" class="form-control" id="blood_type" value="{{ old('blood_type', $profile->blood_type ?? '') }}">
                </div>

                <div class="col">
                    <label for="allergies" class="fw-bold">Allergies (comma-separated)</label>
                    <input type="text" name="allergies" class="form-control" id="allergies" value="{{ old('allergies', isset($profile->allergies) ? implode(',', $profile->allergies) : '') }}">
                </div>

                <div class="col">
                    <label for="chronic_conditions" class="fw-bold">Chronic Conditions (comma-separated)</label>
                    <input type="text" name="chronic_conditions" class="form-control" id="chronic_conditions" value="{{ old('chronic_conditions', isset($profile->chronic_conditions) ? implode(',', $profile->chronic_conditions) : '') }}">
                </div>

                <div class="col">
                    <label for="medications" class="fw-bold">Medications (comma-separated)</label>
                    <input type="text" name="medications" class="form-control" id="medications" value="{{ old('medications', isset($profile->medications) ? implode(',', $profile->medications) : '') }}">
                </div>

                <div class="col">
                    <label for="prescription" class="fw-bold">Prescriptions (comma-separated)</label>
                    <input type="text" name="prescription" class="form-control" id="prescription" value="{{ old('prescription', isset($profile->prescription) ? implode(',', $profile->prescription) : '') }}">
                </div>

                <div class="col">
                    <label for="pregnancy_status" class="fw-bold">Pregnancy Status (Only for Females)</label>
                    <select name="pregnancy_status" id="pregnancy_status" class="form-control">
                        <option value="">Select</option>
                        <option value="1" {{ (old('pregnancy_status', $profile->pregnancy_status ?? '') == '1') ? 'selected' : '' }}>Pregnant</option>
                        <option value="0" {{ (old('pregnancy_status', $profile->pregnancy_status ?? '') == '0') ? 'selected' : '' }}>Not Pregnant</option>
                    </select>
                </div>

                <div class="col">
                    <label for="weight" class="fw-bold">Weight (kg)</label>
                    <input type="number" step="0.1" name="weight" class="form-control" id="weight" value="{{ old('weight', $profile->weight ?? '') }}">
                </div>

                <div class="col">
                    <label for="height" class="fw-bold">Height (cm)</label>
                    <input type="number" step="0.1" name="height" class="form-control" id="height" value="{{ old('height', $profile->height ?? '') }}">
                </div>

                <div class="col-12">
                    <label for="notes" class="fw-bold">Additional Notes</label>
                    <textarea name="notes" class="form-control" id="notes" rows="4">{{ old('notes', $profile->notes ?? '') }}</textarea>
                </div>

                <div class="col-12 text-center mt-4">
                    <button type="submit" class="btn btn-success px-5">Save Profile</button>
                </div>

            </div>
        </form>
    </div>
@endsection
