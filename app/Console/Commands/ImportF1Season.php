<?php

namespace App\Console\Commands;

use App\Jobs\ImportRaceResultsJob;
use App\Jobs\ImportStandingsJob;
use App\Models\Season;
use Illuminate\Bus\Batch;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Http;
use Throwable;

class ImportF1Season extends Command
{
    protected $signature = 'f1:import-season {year}';
    protected $description = 'Importa corridas, resultados e classificações de uma temporada de F1';

    public function handle(): void
    {
        $year = $this->argument('year');
        $season = Season::firstOrCreate(['year' => $year]);

        $races = Http::get("https://api.jolpi.ca/ergast/f1/{$year}.json", ['limit' => 100])
            ->json('MRData.RaceTable.Races') ?? [];

        if (empty($races)) {
            $this->error("Nenhuma corrida encontrada para {$year}.");
            return;
        }

        $jobs = collect($races)->map(
            fn ($raceData, $index) => (new ImportRaceResultsJob($season, (int) $raceData['round']))
                ->delay(now()->addSeconds($index * 5))
        );

        $batch = Bus::batch($jobs)
            ->name("Import F1 season {$year}")
            ->then(function (Batch $batch) use ($season) {
                ImportStandingsJob::dispatch($season);
            })
            ->catch(function (Batch $batch, Throwable $e) {
                logger()->error("Falha na importação da temporada: {$e->getMessage()}");
            })
            ->dispatch();

        $this->info(count($races) . " corridas de {$year} enfileiradas.");
        $this->info("Classificações serão importadas automaticamente ao final. Batch ID: {$batch->id}");
    }
}