@extends('layouts.app')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">

            <h2 class="text-center mb-4 text-primary">
                <i class="bi bi-capsule-pill"></i> My Medication Plan
            </h2>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card shadow-sm mb-5">
                <div class="card-header bg-primary text-white">
                    Add New Medication
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('medication-plan.store') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="medication_name" class="form-label">Medication Name</label>
                            <input type="text" name="medication_name" class="form-control" placeholder="e.g., Paracetamol" required>
                        </div>

                        <div class="mb-3">
                            <label for="dosage" class="form-label">Dosage</label>
                            <input type="text" name="dosage" class="form-control" placeholder="e.g., 1 tablet">
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="time" class="form-label">Time</label>
                                <input type="time" name="time" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label for="date" class="form-label">Date</label>
                                <input type="date" name="date" class="form-control" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="note" class="form-label">Note (optional)</label>
                            <textarea name="note" rows="3" class="form-control" placeholder="Additional information..."></textarea>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-plus-circle"></i> Add Medication
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <h4 class="text-secondary mb-3">📋 Your Scheduled Medications</h4>

            @forelse($plans as $plan)
                <div class="card mb-3 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title text-primary">{{ $plan->medication_name }}</h5>
                        <p class="card-text mb-1"><strong>Dosage:</strong> {{ $plan->dosage }}</p>
                        <p class="card-text mb-1"><strong>Date:</strong> {{ $plan->date }} &nbsp;&nbsp;|&nbsp;&nbsp; <strong>Time:</strong> {{ $plan->time }}</p>
                        @if($plan->note)
                            <p class="card-text"><strong>Note:</strong> {{ $plan->note }}</p>
                        @endif
                    </div>
                </div>
            @empty
                <div class="alert alert-info text-center">
                    No medications scheduled yet.
                </div>
            @endforelse

        </div>
    </div>
</div>
@endsection
