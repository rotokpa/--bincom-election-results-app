<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>LGA Election Results</title>
    <style>
        body { font-family: Arial; background: #f4f6f9; padding: 40px; }
        .container { max-width: 850px; margin: auto; background: white; padding: 30px; border-radius: 10px; }
        select, button { padding: 10px; margin: 10px 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 12px; border-bottom: 1px solid #ddd; text-align: left; }
        th { background: #1f2937; color: white; }
    </style>
</head>
<body>
<div class="container">

    <h1>Aggregated LGA Election Results</h1>

    <form method="GET" action="{{ route('lga-results') }}">
        <label>Select Local Government Area:</label><br>

        <select name="lga_id" required>
            <option value="">-- Select LGA --</option>

            @foreach ($lgas as $lga)
                <option value="{{ $lga->lga_id }}"
                    {{ $selectedLgaId == $lga->lga_id ? 'selected' : '' }}>
                    {{ $lga->lga_name }}
                </option>
            @endforeach
        </select>

        <button type="submit">View Results</button>
    </form>

    @if ($selectedLgaId)
        <h2>Party Vote Totals</h2>

        <table>
            <thead>
                <tr>
                    <th>Party</th>
                    <th>Party Name</th>
                    <th>Total Votes</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($results as $result)
                    <tr>
                        <td>{{ $result->partyid }}</td>
                        <td>{{ $result->partyname }}</td>
                        <td>{{ number_format($result->total_votes) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3">No polling-unit results found for this LGA.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    @endif

</div>
</body>
</html>
