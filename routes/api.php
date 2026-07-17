<?php

use App\Console\Commands\ImportF1Season;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

Route::post('/system/import-season/{year}', function (Request $request, int $year) {
    abort_unless(
        hash_equals(config('services.import_token'), (string) $request->header('X-Import-Token')),
        403
    );

    set_time_limit(300); 

    try {
        $season = \App\Models\Season::firstOrCreate(['year' => $year]);

        $races = Http::get("https://api.jolpi.ca/ergast/f1/{$year}.json", ['limit' => 100])
            ->json('MRData.RaceTable.Races') ?? [];

        foreach ($races as $raceData) {
            (new \App\Jobs\ImportRaceResultsJob($season, (int) $raceData['round']))->handle();
        }

        (new \App\Jobs\ImportStandingsJob($season))->handle();

        return response()->json([
            'status' => 'completed',
            'year' => $year,
            'races_imported' => count($races),
        ]);
    } catch (\Throwable $e) {
        return response()->json(['error' => $e->getMessage(), 'line' => $e->getLine()], 500);
    }
});



Route::get('/system/status', function () {
    return response()->json([
        'seasons' => \App\Models\Season::count(),
        'races' => \App\Models\Race::count(),
        'results' => \App\Models\Result::count(),
        'standings' => \App\Models\Standing::count(),
    ]);
});

Route::get('/system/queue-debug', function () {
    return response()->json([
        'pending_jobs' => DB::table('jobs')->count(),
        'failed_jobs' => DB::table('failed_jobs')->count(),
        'batches' => DB::table('job_batches')->select('id', 'total_jobs', 'processed_jobs', 'failed_jobs', 'finished_at')->get(),
    ]);
});