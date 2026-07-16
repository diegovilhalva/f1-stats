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

        $leaderPoints = $driverStandings->first()?->points ?? 0;

        $podiumCounts = \App\Models\Result::query()
            ->whereIn('driver_id', $driverStandings->pluck('driver_id'))
            ->whereHas('race', fn($q) => $q->where('season_id', $season->id))
            ->whereIn('position', [1, 2, 3])
            ->selectRaw('driver_id, count(*) as podiums')
            ->groupBy('driver_id')
            ->pluck('podiums', 'driver_id');

        $driverStandings = $driverStandings->map(function ($standing) use ($leaderPoints, $podiumCounts) {
            $standing->gap = $leaderPoints - $standing->points;
            $standing->podiums = $podiumCounts[$standing->driver_id] ?? 0;
            return $standing;
        });

        $constructorStandings = $season->standings()
            ->where('type', 'constructor')
            ->with('constructor')
            ->orderBy('position')
            ->get();

        return Inertia::render('Standings/Index', [
            'season' => $season->only('id', 'year'),
            'driverStandings' => $driverStandings,
            'constructorStandings' => $constructorStandings,
            'stats' => [
                'racesCompleted' => $season->races()->count(),
                'mostWins' => $driverStandings->sortByDesc('wins')->first(),
                'pointsLeader' => $driverStandings->first(),
            ],
        ]);
    }
}