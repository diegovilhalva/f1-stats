<?php

namespace App\Http\Controllers;

use App\Models\Season;
use Inertia\Inertia;
use Inertia\Response;

class SeasonController extends Controller
{
    public function index(): Response
    {
        $seasons = Season::orderByDesc('year')->get(['id', 'year']);

        return Inertia::render('Seasons/Index', [
            'seasons' => $seasons,
        ]);
    }

    public function show(Season $season): Response
    {
        $races = $season->races()
            ->with('circuit:id,name,country')
            ->orderBy('round')
            ->get(['id', 'season_id', 'circuit_id', 'round', 'name', 'date']);

        return Inertia::render('Seasons/Show', [
            'season' => $season->only('id', 'year'),
            'races' => $races,
        ]);
    }
}