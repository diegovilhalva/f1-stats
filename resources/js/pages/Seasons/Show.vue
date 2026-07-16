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

        <div class="mx-auto max-w-5xl px-6 py-8">
            <h1 class="font-display text-3xl font-bold">Calendário {{ props.season.year }}</h1>
            <p class="mt-1 font-mono text-xs uppercase tracking-wider text-ink-400">
                {{ props.races.length }} corridas
            </p>

            <div class="mt-8 divide-y divide-track-800 rounded border border-track-800 bg-track-900">
                <Link
                    v-for="race in props.races"
                    :key="race.id"
                    :href="`/seasons/${props.season.year}/races/${race.round}`"
                    class="flex items-center gap-5 px-5 py-4 transition hover:bg-track-800/40"
                >
                    <span class="w-10 font-mono text-xs text-ink-400">RND {{ race.round }}</span>
                    <div class="flex-1">
                        <p class="font-medium">{{ race.name }}</p>
                        <p class="font-mono text-xs text-ink-400">{{ race.circuit.name }}</p>
                    </div>
                    <span class="font-mono text-xs text-ink-400">{{ new Date(race.date).toLocaleDateString()}}</span>
                </Link>
            </div>
        </div>
    </div>
</template>