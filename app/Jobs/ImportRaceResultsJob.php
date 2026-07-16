<?php

namespace App\Jobs;

use App\Models\Circuit;
use App\Models\Constructor;
use App\Models\Driver;
use App\Models\Race;
use App\Models\Result;
use App\Models\Season;
use Illuminate\Bus\Batchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Http;

class ImportRaceResultsJob implements ShouldQueue
{
    use Batchable, Queueable;
    

    public function __construct(
        public Season $season,
        public int $round,
    ) {
    }

    public function handle(): void
    {
        $response = Http::get("https://api.jolpi.ca/ergast/f1/{$this->season->year}/{$this->round}/results.json", [
            'limit' => 100,
        ])->json('MRData.RaceTable.Races.0');


        if (!$response) {
            return;
        }

        $circuit = Circuit::firstOrCreate(
            ['ref' => $response['Circuit']['circuitId']],
            [
                'name' => $response['Circuit']['circuitName'],
                'location' => $response['Circuit']['Location']['locality'] ?? null,
                'country' => $response['Circuit']['Location']['country'] ?? null,
                'lat' => $response['Circuit']['Location']['lat'] ?? null,
                'lng' => $response['Circuit']['Location']['long'] ?? null,
            ]
        );

        $race = Race::updateOrCreate(
            ['season_id' => $this->season->id, 'round' => $this->round],
            [
                'circuit_id' => $circuit->id,
                'name' => $response['raceName'],
                'date' => $response['date'],
                'time' => isset($response['time']) ? rtrim($response['time'], 'Z') : null,
            ]
        );

        foreach ($response['Results'] ?? [] as $result) {
            $driver = Driver::firstOrCreate(
                ['ref' => $result['Driver']['driverId']],
                [
                    'code' => $result['Driver']['code'] ?? null,
                    'number' => $result['Driver']['permanentNumber'] ?? null,
                    'forename' => $result['Driver']['givenName'],
                    'surname' => $result['Driver']['familyName'],
                    'nationality' => $result['Driver']['nationality'] ?? null,
                    'dob' => $result['Driver']['dateOfBirth'] ?? null,
                ]
            );

            $constructor = Constructor::firstOrCreate(
                ['ref' => $result['Constructor']['constructorId']],
                [
                    'name' => $result['Constructor']['name'],
                    'nationality' => $result['Constructor']['nationality'] ?? null,
                ]
            );

            Result::updateOrCreate(
                ['race_id' => $race->id, 'driver_id' => $driver->id],
                [
                    'constructor_id' => $constructor->id,
                    'grid' => $result['grid'] ?? null,
                    'position' => $result['position'] ?? null,
                    'points' => $result['points'] ?? 0,
                    'status' => $result['status'] ?? null,
                    'fastest_lap_time' => $result['FastestLap']['Time']['time'] ?? null,
                ]
            );
        }
    }
}