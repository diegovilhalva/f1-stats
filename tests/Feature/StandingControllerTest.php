<?php

use App\Models\Constructor;
use App\Models\Driver;
use App\Models\Season;
use App\Models\Standing;
use Inertia\Testing\AssertableInertia as Assert;

it('shows driver and constructor standings separately', function () {
    $season = Season::factory()->create(['year' => 2024]);
    $driver = Driver::factory()->create(['surname' => 'Verstappen']);
    $constructor = Constructor::factory()->create(['name' => 'Red Bull']);

    Standing::factory()->create([
        'season_id' => $season->id,
        'driver_id' => $driver->id,
        'constructor_id' => $constructor->id,
        'type' => 'driver',
        'position' => 1,
    ]);

    Standing::factory()->create([
        'season_id' => $season->id,
        'constructor_id' => $constructor->id,
        'driver_id' => null,
        'type' => 'constructor',
        'position' => 1,
    ]);

    $response = $this->get('/seasons/2024/standings');

    $response->assertOk();
    $response->assertInertia(
        fn (Assert $page) => $page
            ->component('Standings/Index')
            ->has('driverStandings', 1)
            ->has('constructorStandings', 1)
            ->where('driverStandings.0.driver.surname', 'Verstappen')
            ->where('constructorStandings.0.constructor.name', 'Red Bull')
    );
});