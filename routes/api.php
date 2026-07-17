<?php

use App\Console\Commands\ImportF1Season;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

Route::post('/system/import-season/{year}', function (Request $request, int $year) {
    abort_unless(
        hash_equals(config('services.import_token'), (string) $request->header('X-Import-Token')),
        403
    );

    try {
        Artisan::call('f1:import-season', ['year' => $year]);

        return response()->json(['status' => 'queued', 'year' => $year]);
    } catch (\Throwable $e) {
        return response()->json([
            'error' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
        ], 500);
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