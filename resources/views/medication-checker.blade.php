<form method="POST" action="/medication-checker">
    @csrf
    <label>Drug Name or Trade Name:
        <input type="text" name="drug_name" required>
    </label>
    <button type="submit">Check</button>
</form>

@if(isset($message))
    <div class="{{ $status }}">
        <pre>{{ $message }}</pre>
    </div>
@endif
