<script setup lang="ts">
import { Link } from '@inertiajs/vue3';

interface DriverStanding {
    id: number;
    position: number;
    points: string;
    wins: number;
    driver: { forename: string; surname: string };
    constructor: { name: string };
}

interface ConstructorStanding {
    id: number;
    position: number;
    points: string;
    wins: number;
    constructor: { name: string };
}

const props = defineProps<{
    season: { id: number; year: number };
    driverStandings: DriverStanding[];
    constructorStandings: ConstructorStanding[];
}>();
</script>

<template>
    <div class="min-h-screen bg-neutral-950 text-neutral-100">
        <div class="mx-auto max-w-3xl px-6 py-16">
            <Link :href="`/seasons/${props.season.year}`" class="text-sm text-neutral-500 hover:text-neutral-300">
                &larr; Temporada {{ props.season.year }}
            </Link>

            <h1 class="mt-4 text-3xl font-bold tracking-tight">Classificação {{ props.season.year }}</h1>

            <h2 class="mt-10 text-lg font-semibold">Pilotos</h2>
            <table class="mt-3 w-full text-left text-sm">
                <tbody class="divide-y divide-neutral-900">
                    <tr v-for="standing in props.driverStandings" :key="standing.id">
                        <td class="py-2 pr-4 text-neutral-500">{{ standing.position }}</td>
                        <td class="py-2 pr-4 font-medium">
                            {{ standing.driver.forename }} {{ standing.driver.surname }}
                        </td>
                        <td class="py-2 pr-4 text-neutral-400">{{ standing.constructor.name }}</td>
                        <td class="py-2 text-right">{{ standing.points }} pts</td>
                    </tr>
                </tbody>
            </table>

            <h2 class="mt-10 text-lg font-semibold">Construtores</h2>
            <table class="mt-3 w-full text-left text-sm">
                <tbody class="divide-y divide-neutral-900">
                    <tr v-for="standing in props.constructorStandings" :key="standing.id">
                        <td class="py-2 pr-4 text-neutral-500">{{ standing.position }}</td>
                        <td class="py-2 pr-4 font-medium">{{ standing.constructor.name }}</td>
                        <td class="py-2 text-right">{{ standing.points }} pts</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>