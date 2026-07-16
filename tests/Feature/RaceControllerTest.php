<?php

use App\Models\Circuit;
use App\Models\Constructor;
use App\Models\Driver;
use App\Models\Race;
use App\Models\Result;
use App\Models\Season;
use Inertia\Testing\AssertableInertia as Assert;

it('shows race results ordered by position', function () {
    $season = Season::factory()->create(['year' => 2024]);
    $circuit = Circuit::factory()->create();
    $race = Race::factory()->create([
        'season_id' => $season->id,
        'circuit_id' => $circuit->id,
        'round' => 1,
        'name' => 'Bahrain Grand Prix',
    ]);

    $driver1 = Driver::factory()->create(['surname' => 'Verstappen']);
    $driver2 = Driver::factory()->create(['surname' => 'Norris']);
    $constructor = Constructor::factory()->create();

    Result::factory()->create([
        'race_id' => $race->id,
        'driver_id' => $driver2->id,
        'constructor_id' => $constructor->id,
        'position' => 2,
    ]);

    Result::factory()->create([
        'race_id' => $race->id,
        'driver_id' => $driver1->id,
        'constructor_id' => $constructor->id,
        'position' => 1,
    ]);

    $response = $this->get('/seasons/2024/races/1');

    $response->assertOk();
    $response->assertInertia(
        fn (Assert $page) => $page
            ->component('Races/Show')
            ->where('race.name', 'Bahrain Grand Prix')
            ->has('race.results', 2)
            ->where('race.results.0.driver.surname', 'Verstappen')
    );
});

it('returns 404 for a round that does not exist in the season', function () {
    Season::factory()->create(['year' => 2024]);

    $this->get('/seasons/2024/races/99')->assertNotFound();
});