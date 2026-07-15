<?php

namespace App\Jobs;

use App\Models\Constructor;
use App\Models\Driver;
use App\Models\Season;
use App\Models\Standing;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Http;

class ImportStandingsJob implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public Season $season,
    ) {}

    public function handle(): void
    {
        $this->importDriverStandings();
        $this->importConstructorStandings();
    }

    private function importDriverStandings(): void
    {
        $list = Http::get("https://api.jolpi.ca/ergast/f1/{$this->season->year}/driverstandings.json", ['limit' => 100])
            ->json('MRData.StandingsTable.StandingsLists.0.DriverStandings') ?? [];

        foreach ($list as $entry) {
            $driver = Driver::firstOrCreate(
                ['ref' => $entry['Driver']['driverId']],
                [
                    'code' => $entry['Driver']['code'] ?? null,
                    'number' => $entry['Driver']['permanentNumber'] ?? null,
                    'forename' => $entry['Driver']['givenName'],
                    'surname' => $entry['Driver']['familyName'],
                    'nationality' => $entry['Driver']['nationality'] ?? null,
                    'dob' => $entry['Driver']['dateOfBirth'] ?? null,
                ]
            );

            // Um piloto pode ter corrido por mais de uma equipe na temporada;
            // a API retorna todas em "Constructors", mas guardamos a standing
            // vinculada à mais recente (última do array).
            $constructorData = collect($entry['Constructors'])->last();

            $constructor = Constructor::firstOrCreate(
                ['ref' => $constructorData['constructorId']],
                [
                    'name' => $constructorData['name'],
                    'nationality' => $constructorData['nationality'] ?? null,
                ]
            );

            Standing::updateOrCreate(
                [
                    'season_id' => $this->season->id,
                    'driver_id' => $driver->id,
                    'type' => 'driver',
                ],
                [
                    'constructor_id' => $constructor->id,
                    'points' => $entry['points'],
                    'position' => $entry['position'],
                    'wins' => $entry['wins'],
                ]
            );
        }
    }

    private function importConstructorStandings(): void
    {
        $list = Http::get("https://api.jolpi.ca/ergast/f1/{$this->season->year}/constructorstandings.json", ['limit' => 100])
            ->json('MRData.StandingsTable.StandingsLists.0.ConstructorStandings') ?? [];

        foreach ($list as $entry) {
            $constructor = Constructor::firstOrCreate(
                ['ref' => $entry['Constructor']['constructorId']],
                [
                    'name' => $entry['Constructor']['name'],
                    'nationality' => $entry['Constructor']['nationality'] ?? null,
                ]
            );

            Standing::updateOrCreate(
                [
                    'season_id' => $this->season->id,
                    'constructor_id' => $constructor->id,
                    'type' => 'constructor',
                ],
                [
                    'driver_id' => null,
                    'points' => $entry['points'],
                    'position' => $entry['position'],
                    'wins' => $entry['wins'],
                ]
            );
        }
    }
}