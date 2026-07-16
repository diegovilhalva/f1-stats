<script setup lang="ts">
import AppNav from '@/components/AppNav.vue';
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
    <div class="min-h-screen bg-track-950 font-sans text-ink-100">
        <AppNav :season="props.season.year" />

        <div class="mx-auto max-w-5xl px-4 py-6 sm:px-6 sm:py-8">
            <h1 class="font-display text-2xl font-bold sm:text-3xl">Calendário {{ props.season.year }}</h1>
            <p class="mt-1 font-mono text-xs uppercase tracking-wider text-ink-400">
                {{ props.races.length }} corridas
            </p>

            <div class="mt-6 divide-y divide-track-800 rounded border border-track-800 bg-track-900 sm:mt-8">
                <Link
                    v-for="race in props.races"
                    :key="race.id"
                    :href="`/seasons/${props.season.year}/races/${race.round}`"
                    class="flex flex-col gap-1 px-4 py-3 transition hover:bg-track-800/40 sm:flex-row sm:items-center sm:gap-5 sm:px-5 sm:py-4"
                >
                    <span class="font-mono text-xs text-ink-400 sm:w-10">RND {{ race.round }}</span>
                    <div class="flex-1">
                        <p class="font-medium">{{ race.name }}</p>
                        <p class="font-mono text-xs text-ink-400">{{ race.circuit.name }}</p>
                    </div>
                    <span class="font-mono text-xs text-ink-400">{{ new Date(race.date).toLocaleDateString('en-GB', { day: '2-digit', month: 'short', year: 'numeric' }) }}</span>
                </Link>
            </div>
        </div>
    </div>
</template>