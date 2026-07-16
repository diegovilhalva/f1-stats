<script setup lang="ts">
import AppNav from '@/components/AppNav.vue';
import { teamColor } from '@/lib/teamColors';

interface Standing {
    id: number;
    position: number;
    points: string;
    wins: number;
    gap?: number;
    podiums?: number;
    driver?: { forename: string; surname: string };
    constructor: { ref: string; name: string };
}

const props = defineProps<{
    season: { id: number; year: number };
    driverStandings: Standing[];
    constructorStandings: Standing[];
    stats: {
        racesCompleted: number;
        mostWins: Standing;
        pointsLeader: Standing;
    };
}>();
</script>

<template>
    <div class="min-h-screen bg-track-950 font-sans text-ink-100">
        <AppNav :season="props.season.year" />

        <div class="mx-auto max-w-5xl px-6 py-8">
            <!-- Stat cards -->
            <div class="grid grid-cols-3 gap-4">
                <div class="rounded border border-track-800 bg-track-900 p-4">
                    <p class="font-mono text-xs uppercase tracking-wider text-ink-400">Corridas</p>
                    <p class="mt-1 font-display text-3xl font-bold">{{ stats.racesCompleted }}</p>
                </div>
                <div class="rounded border border-track-800 bg-track-900 p-4">
                    <p class="font-mono text-xs uppercase tracking-wider text-ink-400">Mais vitórias</p>
                    <p class="mt-1 font-display text-3xl font-bold" :style="{ color: teamColor(stats.mostWins.constructor.ref) }">
                        {{ stats.mostWins.driver?.surname }}
                    </p>
                    <p class="font-mono text-xs text-ink-400">{{ stats.mostWins.wins }} vitórias</p>
                </div>
                <div class="rounded border border-track-800 bg-track-900 p-4">
                    <p class="font-mono text-xs uppercase tracking-wider text-ink-400">Líder</p>
                    <p class="mt-1 font-display text-3xl font-bold text-points">+{{ stats.pointsLeader.points }} pts</p>
                    <p class="font-mono text-xs text-ink-400">{{ stats.pointsLeader.driver?.surname }}</p>
                </div>
            </div>

            <!-- Driver standings -->
            <h2 class="mt-10 font-display text-2xl font-bold">Pilotos</h2>
            <table class="mt-4 w-full border-collapse text-sm">
                <thead>
                    <tr class="border-b border-track-800 font-mono text-xs uppercase tracking-wider text-ink-400">
                        <th class="py-2 text-left">Pos</th>
                        <th class="py-2 text-left">Piloto</th>
                        <th class="py-2 text-right">Gap</th>
                        <th class="py-2 text-right">Wins</th>
                        <th class="py-2 text-right">Pódios</th>
                        <th class="py-2 text-right">Pts</th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        v-for="standing in driverStandings"
                        :key="standing.id"
                        class="border-b border-track-800/60 transition hover:bg-track-900"
                    >
                        <td class="py-3 font-mono text-ink-400">P{{ standing.position }}</td>
                        <td class="py-3">
                            <div class="flex items-center gap-2">
                                <span
                                    class="h-4 w-1 rounded-full"
                                    :style="{ backgroundColor: teamColor(standing.constructor.ref) }"
                                />
                                <span class="font-medium">
                                    {{ standing.driver?.forename }} {{ standing.driver?.surname }}
                                </span>
                                <span
                                    class="rounded px-1.5 py-0.5 font-mono text-[10px] font-semibold"
                                    :style="{
                                        color: teamColor(standing.constructor.ref),
                                        backgroundColor: teamColor(standing.constructor.ref) + '22',
                                    }"
                                >
                                    {{ standing.constructor.name }}
                                </span>
                            </div>
                        </td>
                        <td class="py-3 text-right font-mono text-ink-400">
                            {{ standing.gap === 0 ? 'LEADER' : `+${standing.gap} pts` }}
                        </td>
                        <td class="py-3 text-right font-mono">{{ standing.wins }}</td>
                        <td class="py-3 text-right font-mono">{{ standing.podiums }}</td>
                        <td class="py-3 text-right font-mono text-lg font-bold text-points">{{ standing.points }}</td>
                    </tr>
                </tbody>
            </table>

            <!-- Constructor standings -->
            <h2 class="mt-10 font-display text-2xl font-bold">Construtores</h2>
            <table class="mt-4 w-full border-collapse text-sm">
                <tbody>
                    <tr
                        v-for="standing in constructorStandings"
                        :key="standing.id"
                        class="border-b border-track-800/60 hover:bg-track-900"
                    >
                        <td class="py-3 font-mono text-ink-400">P{{ standing.position }}</td>
                        <td class="py-3">
                            <div class="flex items-center gap-2">
                                <span
                                    class="h-4 w-1 rounded-full"
                                    :style="{ backgroundColor: teamColor(standing.constructor.ref) }"
                                />
                                <span class="font-medium">{{ standing.constructor.name }}</span>
                            </div>
                        </td>
                        <td class="py-3 text-right font-mono">{{ standing.wins }} wins</td>
                        <td class="py-3 text-right font-mono text-lg font-bold text-points">{{ standing.points }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>