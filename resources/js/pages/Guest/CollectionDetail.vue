<script setup lang="ts">
import PublicLayout from '@/Layouts/PublicLayout.vue';
import { Link } from '@inertiajs/vue3';
import { onMounted } from 'vue';
import type { Collection, Writing, PaginatedData } from '@/types';

defineProps<{
    collection: Collection;
    writings: PaginatedData<Writing>;
}>();

const typeColors: Record<string, string> = {
    puisi:   'background-color: var(--color-sage-50); color: var(--color-sage-700)',
    pantun:  'background-color: #f0fdf4; color: #15803d',
    cerita:  'background-color: var(--color-cream-100); color: var(--color-ink-600)',
    prosa:   'background-color: #fafaf5; color: #713f12',
    sajak:   'background-color: #fdf4ff; color: #86198f',
    lainnya: 'background-color: var(--color-stone-100); color: var(--color-stone-600)',
};

function thumbnailUrl(path: string | null): string {
    return path ? `/storage/${path}` : '';
}

function formatDate(date: string | null): string {
    if (!date) return '';
    return new Date(date).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });
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
        <!-- Header -->
        <section style="background-color: white; border-bottom: 1px solid var(--color-cream-200)">
            <div class="max-w-6xl mx-auto px-5 sm:px-10 py-12 sm:py-16">
                <Link
                    href="/koleksi"
                    class="inline-flex items-center gap-1.5 text-xs font-medium mb-8 transition-all hover:gap-2.5"
                    style="color: var(--color-sage-600)"
                >
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18"/>
                    </svg>
                    Semua Koleksi
                </Link>

                <div class="flex flex-col sm:flex-row gap-6 items-start">
                    <!-- Thumbnail -->
                    <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-2xl overflow-hidden flex-shrink-0 shadow-sm">
                        <img v-if="collection.thumbnail" :src="thumbnailUrl(collection.thumbnail)" :alt="collection.title" class="w-full h-full object-cover"/>
                        <div v-else class="w-full h-full flex items-center justify-center" style="background: linear-gradient(135deg, var(--color-forest-800), var(--color-sage-500))">
                            <svg class="w-8 h-8 opacity-50" style="color: white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                        </div>
                    </div>
                    <div>
                        <p class="text-xs font-semibold tracking-[0.18em] uppercase mb-2" style="color: var(--color-sage-500)">Koleksi</p>
                        <h1 class="font-semibold mb-2" style="font-family: var(--font-serif); color: var(--color-ink-900); font-size: clamp(1.6rem, 4vw, 2.4rem)">
                            {{ collection.title }}
                        </h1>
                        <p v-if="collection.description" class="text-sm max-w-lg" style="color: var(--color-ink-500); line-height: 1.7">
                            {{ collection.description }}
                        </p>
                        <p class="text-xs font-medium mt-3" style="color: var(--color-sage-500)">
                            {{ collection.writings?.length ?? 0 }} tulisan
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Writings list -->
        <section class="max-w-6xl mx-auto px-5 sm:px-10 py-12 sm:py-16">
            <div v-if="writings.length === 0" class="flex flex-col items-center justify-center py-24 rounded-2xl" style="border: 1px dashed var(--color-cream-300)">
                <p class="text-3xl mb-4" style="color: var(--color-sage-200)">✦</p>
                <p class="text-sm" style="color: var(--color-ink-400)">Belum ada tulisan dalam koleksi ini.</p>
            </div>

            <div v-else class="flex flex-col gap-3">
                <Link
                    v-for="(w, i) in writings.data"
                    :key="w.id"
                    :href="`/koleksi/${collection.slug}/${w.slug}`"
                    class="reveal group flex items-center gap-4 sm:gap-5 p-4 sm:p-5 rounded-2xl card-hover"
                    style="background-color: white; border: 1px solid var(--color-cream-200)"
                    :style="`animation-delay: ${i * 0.05}s`"
                >
                    <!-- Thumbnail -->
                    <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-xl overflow-hidden flex-shrink-0">
                        <img v-if="w.thumbnail" :src="thumbnailUrl(w.thumbnail)" :alt="w.title" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"/>
                        <div v-else class="w-full h-full flex items-center justify-center" style="background: linear-gradient(135deg, var(--color-sage-50), var(--color-mint-100))">
                            <span style="color: var(--color-sage-300); font-size: 1.2rem">✦</span>
                        </div>
                    </div>
                    <!-- Content -->
                    <div class="flex-1 min-w-0">
                        <div class="flex flex-wrap items-center gap-2 mb-1.5">
                            <span
                                class="text-xs font-medium capitalize px-2.5 py-0.5 rounded-full"
                                :style="typeColors[w.type] ?? typeColors.lainnya"
                            >{{ w.type }}</span>
                            <span v-if="w.written_at" class="text-xs" style="color: var(--color-stone-400)">
                                {{ formatDate(w.written_at) }}
                            </span>
                        </div>
                        <h3 class="font-semibold text-sm sm:text-base leading-snug mb-1 transition-colors group-hover:text-[--color-sage-600]" style="font-family: var(--font-serif); color: var(--color-ink-800)">
                            {{ w.title }}
                        </h3>
                        <p v-if="w.excerpt" class="text-xs sm:text-sm line-clamp-1 sm:line-clamp-2" style="color: var(--color-ink-400); line-height: 1.6">
                            {{ w.excerpt }}
                        </p>
                    </div>
                    <svg class="w-4 h-4 flex-shrink-0 transition-transform duration-200 group-hover:translate-x-1" style="color: var(--color-sage-300)" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </Link>
            </div>

            <!-- Pagination -->
            <div v-if="writings.last_page > 1" class="flex items-center justify-center gap-2 mt-10">
                <Link
                    v-for="link in writings.links"
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
    transform: translateY(20px);
    transition: opacity 0.45s ease, transform 0.45s ease;
}
.reveal.revealed {
    opacity: 1;
    transform: translateY(0);
}
</style>
