<script setup lang="ts">
import PublicLayout from '@/Layouts/PublicLayout.vue';
import { Link } from '@inertiajs/vue3';
import type { Collection, Writing } from '@/types';

defineProps<{
    collection: Collection;
    writings: Writing[];
}>();

const typeColors: Record<string, string> = {
    puisi:  'background-color: var(--color-blush-50); color: var(--color-blush-600)',
    pantun: 'background-color: var(--color-mauve-50); color: var(--color-mauve-600)',
    cerita: 'background-color: var(--color-cream-200); color: var(--color-ink-600)',
    prosa:  'background-color: #f0fdf4; color: #166534',
    sajak:  'background-color: #fef9c3; color: #854d0e',
    lainnya:'background-color: var(--color-cream-100); color: var(--color-ink-500)',
};

function thumbnailUrl(path: string | null): string {
    return path ? `/storage/${path}` : '';
}

function formatDate(date: string | null): string {
    if (!date) return '';
    return new Date(date).toLocaleDateString('id-ID', { year: 'numeric', month: 'long', day: 'numeric' });
}
</script>

<template>
    <PublicLayout>
        <!-- Header -->
        <section class="py-14" style="background: linear-gradient(135deg, var(--color-blush-50) 0%, var(--color-mauve-50) 100%)">
            <div class="max-w-5xl mx-auto px-4 sm:px-6">
                <Link href="/koleksi" class="inline-flex items-center gap-2 text-xs mb-6 transition-colors" style="color: var(--color-blush-500)">
                    ← Semua Koleksi
                </Link>
                <div class="flex flex-col sm:flex-row gap-6 items-start">
                    <div v-if="collection.thumbnail" class="w-28 h-28 rounded-2xl overflow-hidden flex-shrink-0 shadow-md">
                        <img :src="thumbnailUrl(collection.thumbnail)" :alt="collection.title" class="w-full h-full object-cover" />
                    </div>
                    <div v-else class="w-28 h-28 rounded-2xl flex items-center justify-center flex-shrink-0" style="background: linear-gradient(135deg, var(--color-mauve-100), var(--color-blush-100))">
                        <span style="font-size: 2.5rem">📖</span>
                    </div>
                    <div>
                        <h1 class="text-3xl sm:text-4xl mb-3" style="font-family: var(--font-serif); color: var(--color-ink-900); font-weight: 600">{{ collection.title }}</h1>
                        <p v-if="collection.description" class="text-sm max-w-xl" style="color: var(--color-ink-500); line-height: 1.7">{{ collection.description }}</p>
                        <p class="mt-3 text-xs" style="color: var(--color-ink-400)">{{ writings.length }} tulisan</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Writings list -->
        <section class="max-w-5xl mx-auto px-4 sm:px-6 py-14">
            <div v-if="writings.length === 0" class="text-center py-20">
                <p class="text-4xl mb-4">✦</p>
                <p class="text-sm" style="color: var(--color-ink-400)">Belum ada tulisan dalam koleksi ini.</p>
            </div>

            <div v-else class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
                <Link
                    v-for="writing in writings"
                    :key="writing.id"
                    :href="`/koleksi/${collection.slug}/${writing.slug}`"
                    class="group block rounded-2xl overflow-hidden transition-all duration-200 hover:-translate-y-1 hover:shadow-md"
                    style="background-color: white; border: 1px solid var(--color-cream-200)"
                >
                    <div class="aspect-[4/3] overflow-hidden">
                        <img v-if="writing.thumbnail" :src="thumbnailUrl(writing.thumbnail)" :alt="writing.title" class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105" />
                        <div v-else class="w-full h-full flex items-center justify-center" style="background: linear-gradient(135deg, var(--color-blush-50), var(--color-mauve-50))">
                            <span style="font-family: var(--font-serif); color: var(--color-blush-200); font-size: 2rem">✦</span>
                        </div>
                    </div>
                    <div class="p-4">
                        <span class="inline-block text-xs px-2 py-0.5 rounded-full mb-2 capitalize" :style="typeColors[writing.type] ?? typeColors.lainnya">{{ writing.type }}</span>
                        <h3 class="font-semibold text-base leading-snug mb-1.5" style="font-family: var(--font-serif); color: var(--color-ink-800)">{{ writing.title }}</h3>
                        <p v-if="writing.excerpt" class="text-xs line-clamp-2 mb-2" style="color: var(--color-ink-500)">{{ writing.excerpt }}</p>
                        <p v-if="writing.written_at" class="text-xs" style="color: var(--color-ink-400)">{{ formatDate(writing.written_at) }}</p>
                    </div>
                </Link>
            </div>
        </section>
    </PublicLayout>
</template>
