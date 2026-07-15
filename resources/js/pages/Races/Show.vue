<script setup lang="ts">
import { Link } from '@inertiajs/vue3';

interface Driver {
    id: number;
    forename: string;
    surname: string;
    code: string | null;
}

interface Constructor {
    id: number;
    name: string;
}

interface Result {
    id: number;
    position: number | null;
    grid: number | null;
    points: string;
    status: string;
    fastest_lap_time: string | null;
    driver: Driver;
    constructor: Constructor;
}

const props = defineProps<{
    season: { id: number; year: number };
    race: {
        id: number;
        round: number;
        name: string;
        date: string;
        circuit: { name: string; country: string | null };
        results: Result[];
    };
}>();
</script>

<template>
    <div class="min-h-screen bg-neutral-950 text-neutral-100">
        <div class="mx-auto max-w-3xl px-6 py-16">
            <Link :href="`/seasons/${props.season.year}`" class="text-sm text-neutral-500 hover:text-neutral-300">
                &larr; Temporada {{ props.season.year }}
            </Link>

            <h1 class="mt-4 text-3xl font-bold tracking-tight">{{ props.race.name }}</h1>
            <p class="mt-1 text-neutral-400">{{ props.race.circuit.name }} &middot; {{ props.race.date }}</p>

            <table class="mt-10 w-full text-left text-sm">
                <thead class="border-b border-neutral-800 text-neutral-500">
                    <tr>
                        <th class="py-2 pr-4">Pos</th>
                        <th class="py-2 pr-4">Piloto</th>
                        <th class="py-2 pr-4">Equipe</th>
                        <th class="py-2 pr-4">Grid</th>
                        <th class="py-2 pr-4">Pontos</th>
                        <th class="py-2">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-neutral-900">
                    <tr v-for="result in props.race.results" :key="result.id">
                        <td class="py-2 pr-4">{{ result.position ?? '-' }}</td>
                        <td class="py-2 pr-4 font-medium">
                            {{ result.driver.forename }} {{ result.driver.surname }}
                            <span class="text-neutral-500">{{ result.driver.code }}</span>
                        </td>
                        <td class="py-2 pr-4 text-neutral-400">{{ result.constructor.name }}</td>
                        <td class="py-2 pr-4 text-neutral-400">{{ result.grid ?? '-' }}</td>
                        <td class="py-2 pr-4">{{ result.points }}</td>
                        <td class="py-2 text-neutral-400">{{ result.status }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>