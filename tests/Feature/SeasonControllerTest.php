<?php

use App\Models\Circuit;
use App\Models\Race;
use App\Models\Season;
use Inertia\Testing\AssertableInertia as Assert;

it('lists all seasons ordered by most recent year', function () {
    Season::factory()->create(['year' => 2023]);
    Season::factory()->create(['year' => 2024]);

    $response = $this->get('/');

    $response->assertOk();
    $response->assertInertia(
        fn (Assert $page) => $page
            ->component('Seasons/Index')
            ->has('seasons', 2)
            ->where('seasons.0.year', 2024)
    );
});

it('shows races for a specific season', function () {
    $season = Season::factory()->create(['year' => 2024]);
    $circuit = Circuit::factory()->create(['name' => 'Interlagos']);

    Race::factory()->create([
        'season_id' => $season->id,
        'circuit_id' => $circuit->id,
        'round' => 1,
        'name' => 'Bahrain Grand Prix',
    ]);

    $response = $this->get('/seasons/2024');

    $response->assertOk();
    $response->assertInertia(
        fn (Assert $page) => $page
            ->component('Seasons/Show')
            ->where('season.year', 2024)
            ->has('races', 1)
            ->where('races.0.name', 'Bahrain Grand Prix')
    );
});

it('returns 404 for a season that does not exist', function () {
    $this->get('/seasons/1999')->assertNotFound();
});