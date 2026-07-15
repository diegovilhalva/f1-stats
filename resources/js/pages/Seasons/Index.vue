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
    <div class="min-h-screen bg-neutral-950 text-neutral-100">
        <div class="mx-auto max-w-3xl px-6 py-16">
            <h1 class="text-3xl font-bold tracking-tight">F1 Stats</h1>
            <p class="mt-2 text-neutral-400">Temporadas importadas</p>

            <ul class="mt-10 divide-y divide-neutral-800 rounded-lg border border-neutral-800">
                <li v-for="season in seasons" :key="season.id">
                    <Link
                        :href="`/seasons/${season.year}`"
                        class="flex items-center justify-between px-5 py-4 transition hover:bg-neutral-900"
                    >
                        <span class="text-lg font-medium">{{ season.year }}</span>
                        <span class="text-neutral-500">&rarr;</span>
                    </Link>
                </li>
            </ul>
        </div>
    </div>
</template>