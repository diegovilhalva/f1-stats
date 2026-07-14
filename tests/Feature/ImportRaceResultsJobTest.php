<?php

use App\Jobs\ImportRaceResultsJob;
use App\Models\Circuit;
use App\Models\Driver;
use App\Models\Race;
use App\Models\Result;
use App\Models\Season;
use Illuminate\Support\Facades\Http;

it('imports race, circuit, driver, constructor and result data from the API', function () {
    Http::fake([
        'api.jolpi.ca/*' => Http::response([
            'MRData' => [
                'RaceTable' => [
                    'Races' => [
                        [
                            'raceName' => 'Brazilian Grand Prix',
                            'date' => '2024-11-03',
                            'time' => '17:00:00Z',
                            'Circuit' => [
                                'circuitId' => 'interlagos',
                                'circuitName' => 'Autódromo José Carlos Pace',
                                'Location' => [
                                    'locality' => 'São Paulo',
                                    'country' => 'Brazil',
                                    'lat' => '-23.7036',
                                    'long' => '-46.6997',
                                ],
                            ],
                            'Results' => [
                                [
                                    'grid' => '1',
                                    'position' => '1',
                                    'points' => '25',
                                    'status' => 'Finished',
                                    'Driver' => [
                                        'driverId' => 'max_verstappen',
                                        'code' => 'VER',
                                        'permanentNumber' => '1',
                                        'givenName' => 'Max',
                                        'familyName' => 'Verstappen',
                                        'nationality' => 'Dutch',
                                        'dateOfBirth' => '1997-09-30',
                                    ],
                                    'Constructor' => [
                                        'constructorId' => 'red_bull',
                                        'name' => 'Red Bull',
                                        'nationality' => 'Austrian',
                                    ],
                                    'FastestLap' => [
                                        'Time' => ['time' => '1:12.345'],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ]),
    ]);

    $season = Season::factory()->create(['year' => 2024]);

    (new ImportRaceResultsJob($season, 21))->handle();

    expect(Circuit::where('ref', 'interlagos')->exists())->toBeTrue();
    expect(Race::where('season_id', $season->id)->where('round', 21)->exists())->toBeTrue();
    expect(Driver::where('ref', 'max_verstappen')->exists())->toBeTrue();

    $race = Race::where('season_id', $season->id)->where('round', 21)->first();
    $result = Result::where('race_id', $race->id)->first();

    expect($result->position)->toBe(1)
        ->and($result->points)->toEqual(25.0)
        ->and($result->fastest_lap_time)->toBe('1:12.345');
});

it('does nothing when the API returns no race data', function () {
    Http::fake([
        'api.jolpi.ca/*' => Http::response([
            'MRData' => ['RaceTable' => ['Races' => []]],
        ]),
    ]);

    $season = Season::factory()->create(['year' => 2024]);

    (new ImportRaceResultsJob($season, 99))->handle();

    expect(Race::count())->toBe(0);
});