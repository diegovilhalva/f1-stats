<script setup lang="ts">
import { Link } from '@inertiajs/vue3';

defineProps<{ season: number }>();
</script>

<template>
    <header class="border-b border-track-800 bg-track-950">
        <div class="mx-auto flex max-w-5xl items-center justify-between px-6 py-4">
            <div class="flex items-center gap-8">
                <span class="font-display text-xl font-bold tracking-wide text-ink-100">F1 STATS</span>
                <nav class="flex gap-1 font-mono text-xs uppercase tracking-wider">
                    <Link
                        :href="`/seasons/${season}/standings`"
                        class="rounded border border-track-800 px-3 py-1.5 text-ink-100 hover:border-leader"
                    >
                        Standings
                    </Link>
                    <Link :href="`/seasons/${season}`" class="rounded px-3 py-1.5 text-ink-400 hover:text-ink-100">
                        Corridas
                    </Link>
                </nav>
            </div>
            <div class="flex items-center gap-2 font-mono text-xs text-ink-400">
                <span class="uppercase tracking-wider">Season</span>
                <span class="rounded border border-track-800 px-3 py-1.5 font-semibold text-ink-100">{{ season }}</span>
            </div>
        </div>
    </header>
</template>