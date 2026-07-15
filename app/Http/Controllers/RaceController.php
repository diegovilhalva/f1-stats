<?php

namespace App\Http\Controllers;

use App\Models\Season;
use Inertia\Inertia;
use Inertia\Response;

class RaceController extends Controller
{
    public function show(Season $season, int $round): Response
    {
        $race = $season->races()
            ->where('round', $round)
            ->with([
                'circuit',
                'results' => fn($query) => $query->orderBy('position'),
                'results.driver',
                'results.constructor',
            ])
            ->firstOrFail();

        return Inertia::render('Races/Show', [
            'season' => $season->only('id', 'year'),
            'race' => $race,
        ]);
    }
}