<script setup lang="ts">
import PublicLayout from '@/Layouts/PublicLayout.vue';
import { Link, router } from '@inertiajs/vue3';
import { ref, watch } from 'vue';
import type { Collection } from '@/types';

const props = defineProps<{
    collections: Collection[];
    search: string;
}>();

const searchQuery = ref(props.search);
let debounce: ReturnType<typeof setTimeout>;

watch(searchQuery, (val) => {
    clearTimeout(debounce);
    debounce = setTimeout(() => {
        router.get('/koleksi', { search: val }, { preserveState: true, replace: true });
    }, 400);
});

function thumbnailUrl(path: string | null): string {
    if (!path) return '';
    return `/storage/${path}`;
}
</script>

<template>
    <PublicLayout>
        <!-- Header -->
        <section class="py-14 text-center" style="background: linear-gradient(135deg, var(--color-mauve-50) 0%, var(--color-blush-50) 100%)">
            <div class="max-w-2xl mx-auto px-4">
                <p class="text-xs tracking-widest uppercase mb-3" style="color: var(--color-mauve-500); font-family: var(--font-serif); font-style: italic">Jelajahi</p>
                <h1 class="text-3xl sm:text-4xl mb-4" style="font-family: var(--font-serif); color: var(--color-ink-900); font-weight: 600">Semua Koleksi</h1>
                <p class="text-sm mb-8" style="color: var(--color-ink-500)">Kumpulan karya yang disusun dengan penuh rasa</p>

                <!-- Search bar -->
                <div class="relative max-w-md mx-auto">
                    <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4" style="color: var(--color-ink-400)" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z"/>
                    </svg>
                    <input
                        v-model="searchQuery"
                        type="text"
                        placeholder="Cari koleksi..."
                        class="w-full pl-11 pr-4 py-3 rounded-full text-sm outline-none transition-shadow"
                        style="background-color: white; border: 1px solid var(--color-cream-300); color: var(--color-ink-800); box-shadow: 0 1px 4px rgba(0,0,0,0.05)"
                    />
                </div>
            </div>
        </section>

        <!-- Collections grid -->
        <section class="max-w-5xl mx-auto px-4 sm:px-6 py-14">
            <div v-if="collections.length === 0" class="text-center py-20">
                <p class="text-4xl mb-4">✦</p>
                <p class="text-sm" style="color: var(--color-ink-400)">Belum ada koleksi yang ditemukan.</p>
            </div>

            <div v-else class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <Link
                    v-for="col in collections"
                    :key="col.id"
                    :href="`/koleksi/${col.slug}`"
                    class="group block rounded-2xl overflow-hidden transition-all duration-200 hover:-translate-y-1 hover:shadow-lg"
                    style="background-color: white; border: 1px solid var(--color-cream-200)"
                >
                    <div class="aspect-[16/9] overflow-hidden">
                        <img v-if="col.thumbnail" :src="thumbnailUrl(col.thumbnail)" :alt="col.title" class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105" />
                        <div v-else class="w-full h-full flex flex-col items-center justify-center gap-2" style="background: linear-gradient(135deg, var(--color-mauve-50), var(--color-blush-50))">
                            <span style="color: var(--color-mauve-300); font-size: 2.5rem">📖</span>
                        </div>
                    </div>
                    <div class="p-5">
                        <h2 class="font-semibold text-base mb-2 group-hover:text-[--color-blush-700] transition-colors" style="font-family: var(--font-serif); color: var(--color-ink-800)">{{ col.title }}</h2>
                        <p v-if="col.description" class="text-xs line-clamp-2 mb-3" style="color: var(--color-ink-500); line-height: 1.6">{{ col.description }}</p>
                        <div class="flex items-center justify-between">
                            <span class="text-xs px-2 py-1 rounded-full" style="background-color: var(--color-blush-50); color: var(--color-blush-600)">
                                {{ col.published_writings_count ?? col.writings_count ?? 0 }} tulisan
                            </span>
                            <span class="text-xs font-medium" style="color: var(--color-blush-500)">Baca →</span>
                        </div>
                    </div>
                </Link>
            </div>
        </section>
    </PublicLayout>
</template>
