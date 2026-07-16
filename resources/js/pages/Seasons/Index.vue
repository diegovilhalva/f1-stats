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
            <div class="mx-auto max-w-5xl px-6 py-4">
                <span class="font-display text-xl font-bold tracking-wide">F1 STATS</span>
            </div>
        </header>

        <div class="mx-auto max-w-5xl px-6 py-8">
            <h1 class="font-display text-3xl font-bold">Temporadas</h1>
            <p class="mt-1 font-mono text-xs uppercase tracking-wider text-ink-400">
                {{ seasons.length }} disponíveis
            </p>

            <div class="mt-8 grid grid-cols-4 gap-3">
                <Link
                    v-for="season in seasons"
                    :key="season.id"
                    :href="`/seasons/${season.year}`"
                    class="group rounded border border-track-800 bg-track-900 p-5 transition hover:border-leader"
                >
                    <p class="font-display text-3xl font-bold text-ink-100 group-hover:text-leader">
                        {{ season.year }}
                    </p>
                    <p class="mt-1 font-mono text-xs uppercase tracking-wider text-ink-400">
                        Ver temporada &rarr;
                    </p>
                </Link>
            </div>
        </div>
    </div>
</template>