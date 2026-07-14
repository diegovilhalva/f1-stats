<?php

namespace App\Console\Commands;

use App\Jobs\ImportRaceResultsJob;
use App\Models\Season;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class ImportF1Season extends Command
{
    protected $signature = 'f1:import-season {year}';
    protected $description = 'Importa uma temporada de F1 a partir da API Jolpica';

    public function handle(): void
    {
        $year = $this->argument('year');
        $season = Season::firstOrCreate(['year' => $year]);

        $races = Http::get("https://api.jolpi.ca/ergast/f1/{$year}.json")
            ->json('MRData.RaceTable.Races') ?? [];

        if (empty($races)) {
            $this->error("Nenhuma corrida encontrada para {$year}.");
            return;
        }

        foreach ($races as $index => $raceData) {
            ImportRaceResultsJob::dispatch($season, (int) $raceData['round'])
                ->delay(now()->addSeconds($index * 20));
        }

        $this->info(count($races) . " corridas de {$year} enfileiradas para importação.");
    }
}