<script setup lang="ts">
import { Link } from '@inertiajs/vue3';

interface Circuit {
    id: number;
    name: string;
    country: string | null;
}

interface Race {
    id: number;
    round: number;
    name: string;
    date: string;
    circuit: Circuit;
}

const props = defineProps<{
    season: { id: number; year: number };
    races: Race[];
}>();
</script>

<template>
    <div class="min-h-screen bg-neutral-950 text-neutral-100">
        <div class="mx-auto max-w-3xl px-6 py-16">
            <Link href="/" class="text-sm text-neutral-500 hover:text-neutral-300">&larr; Temporadas</Link>

            <div class="mt-4 flex items-baseline justify-between">
                <h1 class="text-3xl font-bold tracking-tight">Temporada {{ props.season.year }}</h1>
                <Link
                    :href="`/seasons/${props.season.year}/standings`"
                    class="text-sm text-neutral-400 underline hover:text-neutral-200"
                >
                    Ver classificação
                </Link>
            </div>

            <ul class="mt-10 divide-y divide-neutral-800 rounded-lg border border-neutral-800">
                <li v-for="race in props.races" :key="race.id">
                    <Link
                        :href="`/seasons/${props.season.year}/races/${race.round}`"
                        class="flex items-center justify-between px-5 py-4 transition hover:bg-neutral-900"
                    >
                        <div>
                            <span class="text-neutral-500">R{{ race.round }}</span>
                            <span class="ml-3 font-medium">{{ race.name }}</span>
                        </div>
                        <span class="text-sm text-neutral-500">{{ race.circuit.name }}</span>
                    </Link>
                </li>
            </ul>
        </div>
    </div>
</template>