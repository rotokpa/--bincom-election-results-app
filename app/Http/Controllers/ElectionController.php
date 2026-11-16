<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ElectionController extends Controller
{
    // REQUIREMENT 1: Display results for an individual polling unit
    public function showPollingUnit($id)
    {
        $pollingUnit = DB::table('polling_unit')
            ->where('uniqueid', $id)
            ->first();

        if (!$pollingUnit) {
            abort(404, 'Polling unit not found.');
        }

        $results = DB::table('announced_pu_results as results')
            ->join('party as parties', 'parties.partyid', '=', 'results.party_abbreviation')
            ->where('results.polling_unit_uniqueid', (string) $pollingUnit->uniqueid)
            ->select(
                'parties.partyid',
                'parties.partyname',
                'results.party_score'
            )
            ->orderBy('parties.partyid')
            ->get();

        return view('elections.polling-unit', compact('pollingUnit', 'results'));
    }

    // REQUIREMENT 2: Aggregate results by LGA
    public function lgaResults(Request $request)
    {
        $lgas = DB::table('lga')->orderBy('lga_name')->get();

        $selectedLgaId = $request->input('lga_id');

        $results = collect();

        if ($selectedLgaId) {
            $results = DB::table('announced_pu_results as results')
                ->join('polling_unit as pu', 'pu.uniqueid', '=', 'results.polling_unit_uniqueid')
                ->join('party as parties', 'parties.partyid', '=', 'results.party_abbreviation')
                ->where('pu.lga_id', $selectedLgaId)
                ->select(
                    'parties.partyid',
                    'parties.partyname',
                    DB::raw('SUM(COALESCE(results.party_score, 0)) as total_votes')
                )
                ->groupBy('parties.partyid', 'parties.partyname')
                ->orderBy('parties.partyid')
                ->get();
        }

        return view('elections.lga-results', compact(
            'lgas',
            'selectedLgaId',
            'results'
        ));
    }

    // REQUIREMENT 3: Display the new polling unit form
    public function createPollingUnit()
    {
        $lgas = DB::table('lga')->orderBy('lga_name')->get();
        $parties = DB::table('party')->orderBy('partyid')->get();

        return view('elections.create-polling-unit', compact('lgas', 'parties'));
    }

    // REQUIREMENT 3: Save polling unit and party results
    public function storePollingUnit(Request $request)
    {
        $partyIds = DB::table('party')->pluck('partyid')->all();

        $rules = [
            'polling_unit_name' => ['required', 'string', 'max:50'],
            'polling_unit_number' => ['nullable', 'string', 'max:50'],
            'polling_unit_id' => ['required', 'integer'],
            'ward_id' => ['required', 'integer'],
            'lga_id' => ['required', 'integer'],
        ];

        foreach ($partyIds as $partyId) {
            $rules["scores.$partyId"] = ['required', 'integer', 'min:0'];
        }

        $validated = $request->validate($rules);

        $pollingUnitId = DB::transaction(function () use ($request, $validated, $partyIds) {

            $id = DB::table('polling_unit')->insertGetId([
                'polling_unit_id' => $validated['polling_unit_id'],
                'polling_unit_name' => $validated['polling_unit_name'],
                'polling_unit_number' => $validated['polling_unit_number'] ?? null,
                'ward_id' => $validated['ward_id'],
                'lga_id' => $validated['lga_id'],
                'entered_by_user' => 'admin',
                'date_entered' => now(),
                'user_ip_address' => $request->ip(),
            ]);

            foreach ($partyIds as $partyId) {
                DB::table('announced_pu_results')->insert([
                    'polling_unit_uniqueid' => (string) $id,
                    'party_abbreviation' => $partyId,
                    'party_score' => $validated['scores'][$partyId],
                    'entered_by_user' => 'admin',
                    'date_entered' => now(),
                    'user_ip_address' => $request->ip(),
                ]);
            }

            return $id;
        });

        return redirect()
            ->route('polling-units.show', $pollingUnitId)
            ->with('success', 'Polling unit results saved successfully.');
    }
}
