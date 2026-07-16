<script setup lang="ts">
import { Link } from '@inertiajs/vue3';

defineProps<{ season: number }>();
</script>

<template>
    <header class="border-b border-track-800 bg-track-950">
        <div class="mx-auto flex max-w-5xl flex-wrap items-center justify-between gap-3 px-4 py-4 sm:px-6">
            <div class="flex items-center gap-4 sm:gap-8">
                <Link href="/" class="font-display text-lg font-bold tracking-wide text-ink-100 sm:text-xl">
                F1 STATS
                </Link>
                <nav class="flex gap-1 font-mono text-[11px] uppercase tracking-wider sm:text-xs">
                    <Link :href="`/seasons/${season}/standings`"
                        class="rounded border border-track-800 px-2 py-1.5 text-ink-100 hover:border-leader sm:px-3">
                        Standings
                    </Link>
                    <Link :href="`/seasons/${season}`"
                        class="rounded px-2 py-1.5 text-ink-400 hover:text-ink-100 sm:px-3">
                        Corridas
                    </Link>
                </nav>
            </div>
            <div class="flex items-center gap-2 font-mono text-xs text-ink-400">
                <span class="hidden uppercase tracking-wider sm:inline">Season</span>
                <span class="rounded border border-track-800 px-2.5 py-1.5 font-semibold text-ink-100 sm:px-3">{{ season
                    }}</span>
            </div>
        </div>
    </header>
</template>