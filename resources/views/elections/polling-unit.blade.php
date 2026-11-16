<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Polling Unit Results</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            margin: 0;
            padding: 40px;
        }

        .container {
            max-width: 850px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
        }

        h1 {
            color: #1f2937;
        }

        .details {
            margin-bottom: 25px;
            line-height: 1.8;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }

        th {
            background: #1f2937;
            color: white;
        }

        .empty {
            padding: 20px;
            color: #666;
        }
    </style>
</head>

<body>
    <div class="container">

        <h1>Polling Unit Election Results</h1>

        <div class="details">
            <strong>Polling Unit:</strong>
            {{ $pollingUnit->polling_unit_name }}<br>

            <strong>Polling Unit ID:</strong>
            {{ $pollingUnit->uniqueid }}<br>

            <strong>Ward ID:</strong>
            {{ $pollingUnit->ward_id }}<br>

            <strong>LGA ID:</strong>
            {{ $pollingUnit->lga_id }}
        </div>

        <h2>Party Results</h2>

        <table>
            <thead>
                <tr>
                    <th>Party</th>
                    <th>Party Name</th>
                    <th>Votes</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($results as $result)
                    <tr>
                        <td>{{ $result->partyid }}</td>
                        <td>{{ $result->partyname }}</td>
                        <td>{{ number_format($result->party_score) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="empty">
                            No election results have been recorded for this polling unit.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

    </div>
</body>
</html>
