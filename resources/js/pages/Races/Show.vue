<script setup lang="ts">
import AppNav from '@/components/AppNav.vue';
import { Link } from '@inertiajs/vue3';
import { teamColor } from '@/lib/teamColors';

interface Driver {
    id: number;
    forename: string;
    surname: string;
    code: string | null;
}

interface ConstructorRef {
    id: number;
    ref: string;
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
    constructor: ConstructorRef;
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

function rowAccent(result: Result): string {
    if (result.status !== 'Finished' && !result.status.includes('Lap')) return 'border-l-dnf';
    if (result.position && result.position <= 3) return 'border-l-leader';
    if (result.position && result.position <= 10) return 'border-l-points';
    return 'border-l-track-800';
}
</script>

<template>
    <div class="min-h-screen bg-track-950 font-sans text-ink-100">
        <AppNav :season="props.season.year" />

        <div class="mx-auto max-w-5xl px-4 py-6 sm:px-6 sm:py-8">
            <Link
                :href="`/seasons/${props.season.year}`"
                class="font-mono text-xs uppercase tracking-wider text-ink-400 hover:text-ink-100"
            >
                &larr; Calendário {{ props.season.year }}
            </Link>

            <div class="mt-4 flex flex-wrap items-center gap-3 sm:gap-4">
                <span class="rounded border border-track-800 px-3 py-1 font-mono text-xs text-ink-400">
                    RND {{ props.race.round }}
                </span>
                <h1 class="font-display text-xl font-bold sm:text-3xl">{{ props.race.name }}</h1>
            </div>
            <p class="mt-1 font-mono text-xs text-ink-400">
                {{ props.race.circuit.name }} &middot; {{ new Date(props.race.date).toLocaleDateString('en-GB', { day: '2-digit', month: 'short', year: 'numeric' }) }}
            </p>

            <div class="mt-6 overflow-x-auto sm:mt-8">
                <table class="w-full min-w-[640px] border-collapse text-sm">
                    <thead>
                        <tr class="border-b border-track-800 font-mono text-xs uppercase tracking-wider text-ink-400">
                            <th class="py-2 pl-4 text-left">Pos</th>
                            <th class="py-2 text-left">Piloto</th>
                            <th class="py-2 text-right">Grid</th>
                            <th class="py-2 text-right">Volta rápida</th>
                            <th class="py-2 text-right">Pts</th>
                            <th class="py-2 pr-4 text-right">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="result in props.race.results"
                            :key="result.id"
                            class="border-b border-l-2 border-track-800/60 bg-track-900/40"
                            :class="rowAccent(result)"
                        >
                            <td class="py-3 pl-4 font-mono font-semibold">{{ result.position ?? '-' }}</td>
                            <td class="py-3">
                                <div class="flex items-center gap-2">
                                    <span class="h-4 w-1 rounded-full" :style="{ backgroundColor: teamColor(result.constructor.ref) }" />
                                    <span class="whitespace-nowrap font-medium">
                                        {{ result.driver.forename }} {{ result.driver.surname }}
                                    </span>
                                    <span class="font-mono text-xs text-ink-400">{{ result.driver.code }}</span>
                                </div>
                            </td>
                            <td class="py-3 text-right font-mono text-ink-400">{{ result.grid ?? '-' }}</td>
                            <td class="py-3 text-right font-mono">{{ result.fastest_lap_time ?? '-' }}</td>
                            <td class="py-3 text-right font-mono font-semibold">{{ result.points }}</td>
                            <td class="py-3 pr-4 text-right font-mono text-xs text-ink-400">{{ result.status }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>