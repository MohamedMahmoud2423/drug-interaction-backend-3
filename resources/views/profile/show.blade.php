@extends('layouts.app')

@section('content')
<div class="container">
    <h2>My Profile</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <tr><th>Full Name</th><td>{{ $profile->full_name }}</td></tr>
        <tr><th>Gender</th><td>{{ $profile->gender }}</td></tr>
        <tr><th>Date of Birth</th><td>{{ $profile->date_of_birth }}</td></tr>
        <tr><th>Phone Number</th><td>{{ $profile->phone_number }}</td></tr>
        <tr><th>Blood Type</th><td>{{ $profile->blood_type }}</td></tr>
        <tr><th>Allergies</th><td>{{ implode(', ', $profile->allergies ?? []) }}</td></tr>
        <tr><th>Chronic Conditions</th><td>{{ implode(', ', $profile->chronic_conditions ?? []) }}</td></tr>
        <tr><th>Medications</th><td>{{ implode(', ', $profile->medications ?? []) }}</td></tr>
        <tr><th>Prescription</th><td>{{ implode(', ', $profile->prescription ?? []) }}</td></tr>
        <tr><th>Pregnancy Status</th><td>{{ $profile->pregnancy_status ? 'Yes' : 'No' }}</td></tr>
        <tr><th>Weight</th><td>{{ $profile->weight }} kg</td></tr>
        <tr><th>Height</th><td>{{ $profile->height }} cm</td></tr>
        <tr><th>Notes</th><td>{{ $profile->notes }}</td></tr>
    </table>

    <a href="{{ route('profile') }}" class="btn btn-primary">Update Profile</a>
</div>
@endsection
