<script setup lang="ts">
import { Link } from '@inertiajs/vue3';

interface Season {
    id: number;
    year: number;
}

defineProps<{
    seasons: Season[];
}>();
</script>

<template>
    <div class="min-h-screen bg-track-950 font-sans text-ink-100">
        <header class="border-b border-track-800 bg-track-950">
            <div class="mx-auto max-w-5xl px-4 py-4 sm:px-6">
                <span class="font-display text-lg font-bold tracking-wide sm:text-xl">F1 STATS</span>
            </div>
        </header>

        <div class="mx-auto max-w-5xl px-4 py-6 sm:px-6 sm:py-8">
            <h1 class="font-display text-2xl font-bold sm:text-3xl">Temporadas</h1>
            <p class="mt-1 font-mono text-xs uppercase tracking-wider text-ink-400">
                {{ seasons.length }} disponíveis
            </p>

            <div class="mt-6 grid grid-cols-2 gap-3 sm:mt-8 sm:grid-cols-3 md:grid-cols-4">
                <Link
                    v-for="season in seasons"
                    :key="season.id"
                    :href="`/seasons/${season.year}`"
                    class="group rounded border border-track-800 bg-track-900 p-4 transition hover:border-leader sm:p-5"
                >
                    <p class="font-display text-2xl font-bold text-ink-100 group-hover:text-leader sm:text-3xl">
                        {{ season.year }}
                    </p>
                    <p class="mt-1 font-mono text-[11px] uppercase tracking-wider text-ink-400 sm:text-xs">
                        Ver temporada &rarr;
                    </p>
                </Link>
            </div>
        </div>
    </div>
</template>