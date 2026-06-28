<script setup lang="ts">
import PublicLayout from '@/Layouts/PublicLayout.vue';
import { Link, router } from '@inertiajs/vue3';
import { onMounted, ref } from 'vue';
import type { Collection, PaginatedData } from '@/types';

const props = defineProps<{
    collections: PaginatedData<Collection>;
    search: string;
}>();

const searchQuery = ref(props.search);
let debounce: ReturnType<typeof setTimeout>;

import { watch } from 'vue';
watch(searchQuery, (val) => {
    clearTimeout(debounce);
    debounce = setTimeout(() => {
        router.get('/koleksi', { search: val }, { preserveState: true, replace: true });
    }, 400);
});

function thumbnailUrl(path: string | null): string {
    return path ? `/storage/${path}` : '';
}

onMounted(() => {
    const io = new IntersectionObserver((entries) => {
        entries.forEach(e => {
            if (e.isIntersecting) {
                (e.target as HTMLElement).classList.add('revealed');
                io.unobserve(e.target);
            }
        });
    }, { threshold: 0.1 });
    document.querySelectorAll('.reveal').forEach(el => io.observe(el));
});
</script>

<template>
    <PublicLayout>
        <!-- Page header -->
        <section class="py-14 sm:py-20" style="background-color: white; border-bottom: 1px solid var(--color-cream-200)">
            <div class="max-w-6xl mx-auto px-5 sm:px-10">
                <p class="text-xs font-semibold tracking-[0.18em] uppercase mb-3" style="color: var(--color-sage-500)">Jelajahi</p>
                <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-5">
                    <h1 style="font-family: var(--font-serif); color: var(--color-ink-900); font-size: clamp(1.8rem, 4vw, 2.6rem); font-weight: 600">
                        Semua Koleksi
                    </h1>
                    <!-- Search -->
                    <div class="relative w-full sm:w-72">
                        <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 pointer-events-none" style="color: var(--color-ink-400)" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z"/>
                        </svg>
                        <input
                            v-model="searchQuery"
                            type="text"
                            placeholder="Cari koleksi..."
                            class="w-full pl-10 pr-4 py-2.5 rounded-xl text-sm outline-none transition-all"
                            style="border: 1px solid var(--color-cream-300); background-color: var(--color-cream-50); color: var(--color-ink-800)"
                        />
                    </div>
                </div>
            </div>
        </section>

        <!-- Collections grid -->
        <section class="max-w-6xl mx-auto px-5 sm:px-10 py-14 sm:py-20">
            <!-- Empty state -->
            <div v-if="collections.data.length === 0" class="flex flex-col items-center justify-center py-24 rounded-2xl" style="border: 1px dashed var(--color-cream-300)">
                <p class="text-3xl mb-4" style="color: var(--color-sage-200)">✦</p>
                <p class="text-sm font-medium mb-1" style="color: var(--color-ink-600)">
                    {{ search ? 'Koleksi tidak ditemukan' : 'Belum ada koleksi' }}
                </p>
                <p class="text-xs" style="color: var(--color-ink-400)">
                    {{ search ? `Tidak ada hasil untuk "${search}"` : 'Koleksi akan tampil di sini.' }}
                </p>
            </div>

            <div v-else class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
                <Link
                    v-for="(col, i) in collections.data"
                    :key="col.id"
                    :href="`/koleksi/${col.slug}`"
                    class="reveal group flex flex-col rounded-2xl overflow-hidden card-hover"
                    style="background-color: white; border: 1px solid var(--color-cream-200)"
                    :style="`animation-delay: ${i * 0.06}s`"
                >
                    <!-- Thumbnail -->
                    <div class="relative h-44 overflow-hidden flex-shrink-0" style="background: linear-gradient(135deg, var(--color-sage-100), var(--color-mint-100))">
                        <img
                            v-if="col.thumbnail"
                            :src="thumbnailUrl(col.thumbnail)"
                            :alt="col.title"
                            class="w-full h-full object-cover transition-transform duration-600 group-hover:scale-105"
                        />
                        <div v-else class="w-full h-full flex items-center justify-center">
                            <svg class="w-8 h-8" style="color: var(--color-sage-300)" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                        </div>
                    </div>
                    <!-- Body -->
                    <div class="flex flex-col flex-1 p-5">
                        <h3 class="font-semibold text-base mb-2 transition-colors group-hover:text-[--color-sage-600]" style="font-family: var(--font-serif); color: var(--color-ink-800)">
                            {{ col.title }}
                        </h3>
                        <p v-if="col.description" class="text-sm line-clamp-2 mb-4 flex-1" style="color: var(--color-ink-400); line-height: 1.65">
                            {{ col.description }}
                        </p>
                        <div v-else class="flex-1"/>
                        <div class="flex items-center justify-between mt-auto pt-3" style="border-top: 1px solid var(--color-cream-100)">
                            <span class="text-xs font-medium px-2.5 py-1 rounded-full" style="background-color: var(--color-sage-50); color: var(--color-sage-600)">
                                {{ col.published_writings_count ?? col.writings_count ?? 0 }} tulisan
                            </span>
                            <span class="text-xs font-medium flex items-center gap-1 transition-all duration-200 group-hover:gap-2" style="color: var(--color-sage-500)">
                                Buka
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </span>
                        </div>
                    </div>
                </Link>
            </div>

            <!-- Pagination -->
            <div v-if="collections.last_page > 1" class="flex items-center justify-center gap-2 mt-12">
                <Link
                    v-for="link in collections.links"
                    :key="link.label"
                    :href="link.url ?? ''"
                    :class="['px-3 py-1.5 rounded-lg text-sm transition-all', !link.url ? 'pointer-events-none opacity-30' : '']"
                    :style="link.active
                        ? 'background-color: var(--color-forest-800); color: white'
                        : 'border: 1px solid var(--color-cream-200); color: var(--color-ink-600)'"
                    v-html="link.label"
                />
            </div>
        </section>
    </PublicLayout>
</template>

<style scoped>
.reveal {
    opacity: 0;
    transform: translateY(24px);
    transition: opacity 0.5s ease, transform 0.5s ease;
}
.reveal.revealed {
    opacity: 1;
    transform: translateY(0);
}
</style>
