<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Enter Polling Unit Results</title>
    <style>
        body { font-family: Arial; background: #f4f6f9; padding: 40px; }
        .container { max-width: 750px; margin: auto; background: white; padding: 30px; border-radius: 10px; }
        input, select { width: 100%; padding: 10px; margin: 8px 0 18px; box-sizing: border-box; }
        button { padding: 12px 20px; background: #1f2937; color: white; border: 0; cursor: pointer; }
        h1 { color: #1f2937; }
    </style>
</head>
<body>
<div class="container">

    <h1>New Polling Unit Results</h1>

    <form method="POST" action="{{ route('polling-units.store') }}">
        @csrf

        <label>Polling Unit Name</label>
        <input type="text" name="polling_unit_name" required>

        <label>Polling Unit Number</label>
        <input type="text" name="polling_unit_number">

        <label>Polling Unit ID</label>
        <input type="number" name="polling_unit_id" required>

        <label>Ward ID</label>
        <input type="number" name="ward_id" required>

        <label>Local Government Area</label>
        <select name="lga_id" required>
            <option value="">-- Select LGA --</option>
            @foreach ($lgas as $lga)
                <option value="{{ $lga->lga_id }}">{{ $lga->lga_name }}</option>
            @endforeach
        </select>

        <h2>Party Scores</h2>

        @foreach ($parties as $party)
            <label>{{ $party->partyname }} ({{ $party->partyid }})</label>
            <input type="number" name="scores[{{ $party->partyid }}]" min="0" value="0" required>
        @endforeach

        <button type="submit">Save Polling Unit Results</button>
    </form>

</div>
</body>
</html>
