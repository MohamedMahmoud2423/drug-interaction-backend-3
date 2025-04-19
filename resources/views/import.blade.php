@extends('layouts.app')

@section('content')
<div class="container">
    <h2>📦 Import Drugs Excel</h2>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="/import-drugs" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="file">Choose Excel File</label>
            <input type="file" name="file" class="form-control" required>
        </div>
        <button class="btn btn-primary mt-2">Upload</button>
    </form>
</div>
@endsection
