<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Drug Interaction Checker</title>
</head>
<body>
    <h1>Drug Interaction Checker</h1>

    <!-- Display result message -->
    @if (isset($message))
        <p>{{ $message }}</p>
    @endif

    <!-- Drug interaction form -->
    <form action="{{ route('check-interaction') }}" method="POST">
        @csrf
        <label for="drug1">Enter Drug 1 (Generic or Trade Name):</label>
        <input type="text" name="drug1" required>
        <br>
        <label for="drug2">Enter Drug 2 (Generic or Trade Name):</label>
        <input type="text" name="drug2" required>
        <br>
        <button type="submit">Check Interaction</button>
    </form>
</body>
</html>
