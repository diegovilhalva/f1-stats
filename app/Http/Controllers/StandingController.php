<?php

namespace App\Http\Controllers;

use App\Models\Season;
use Inertia\Inertia;
use Inertia\Response;

class StandingController extends Controller
{
    public function index(Season $season): Response
    {
        $driverStandings = $season->standings()
            ->where('type', 'driver')
            ->with('driver', 'constructor')
            ->orderBy('position')
            ->get();

        $constructorStandings = $season->standings()
            ->where('type', 'constructor')
            ->with('constructor')
            ->orderBy('position')
            ->get();

        return Inertia::render('Standings/Index', [
            'season' => $season->only('id', 'year'),
            'driverStandings' => $driverStandings,
            'constructorStandings' => $constructorStandings,
        ]);
    }
}