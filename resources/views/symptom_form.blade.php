<!DOCTYPE html>
<html>
<head>
    <title>AI Symptom Checker</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <div class="card shadow-lg rounded">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">AI-Powered Symptom Checker</h4>
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if(session('result'))
                <div class="alert alert-success">
                    <strong>Predicted Disease:</strong> {{ session('result') }}
                </div>
            @endif

            <form method="POST" action="{{ route('predict.disease') }}">
                @csrf
                <div class="mb-3">
                    <label for="symptoms" class="form-label">Select your symptoms:</label>
                    <select class="form-select" name="symptoms[]" id="symptoms" multiple size="10" required>
                        @foreach ($symptomList as $symptom)
                            <option value="{{ $symptom }}">{{ ucfirst(str_replace('_', ' ', $symptom)) }}</option>
                        @endforeach
                    </select>
                    <small class="text-muted">Hold Ctrl (Cmd on Mac) to select multiple symptoms.</small>
                </div>

                <button type="submit" class="btn btn-primary">Predict Disease</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>
