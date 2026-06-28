<script setup lang="ts">
import PublicLayout from '@/Layouts/PublicLayout.vue';
import { Link } from '@inertiajs/vue3';
import type { Collection, Writing } from '@/types';

defineProps<{
    collection: Collection;
    writing: Writing;
}>();

function thumbnailUrl(path: string | null): string {
    return path ? `/storage/${path}` : '';
}

function formatDate(date: string | null): string {
    if (!date) return '';
    return new Date(date).toLocaleDateString('id-ID', { year: 'numeric', month: 'long', day: 'numeric' });
}

const typeColors: Record<string, string> = {
    puisi:  'background-color: var(--color-blush-50); color: var(--color-blush-600)',
    pantun: 'background-color: var(--color-mauve-50); color: var(--color-mauve-600)',
    cerita: 'background-color: var(--color-cream-200); color: var(--color-ink-600)',
    prosa:  'background-color: #f0fdf4; color: #166534',
    sajak:  'background-color: #fef9c3; color: #854d0e',
    lainnya:'background-color: var(--color-cream-100); color: var(--color-ink-500)',
};
</script>

<template>
    <PublicLayout>
        <article class="max-w-2xl mx-auto px-4 sm:px-6 py-14">
            <!-- Breadcrumb -->
            <nav class="flex items-center gap-2 text-xs mb-8" style="color: var(--color-ink-400)">
                <Link href="/koleksi" class="transition-colors hover:text-[--color-blush-500]">Koleksi</Link>
                <span>/</span>
                <Link :href="`/koleksi/${collection.slug}`" class="transition-colors hover:text-[--color-blush-500]">{{ collection.title }}</Link>
                <span>/</span>
                <span style="color: var(--color-ink-600)">{{ writing.title }}</span>
            </nav>

            <!-- Thumbnail -->
            <div v-if="writing.thumbnail" class="w-full aspect-[16/9] rounded-2xl overflow-hidden mb-8 shadow-sm">
                <img :src="thumbnailUrl(writing.thumbnail)" :alt="writing.title" class="w-full h-full object-cover" />
            </div>

            <!-- Meta -->
            <header class="mb-8">
                <div class="flex items-center gap-3 mb-4">
                    <span class="text-xs px-2.5 py-1 rounded-full capitalize" :style="typeColors[writing.type] ?? typeColors.lainnya">{{ writing.type }}</span>
                    <span v-if="writing.written_at" class="text-xs" style="color: var(--color-ink-400)">{{ formatDate(writing.written_at) }}</span>
                </div>
                <h1 class="text-3xl sm:text-4xl leading-tight mb-4" style="font-family: var(--font-serif); color: var(--color-ink-900); font-weight: 600">{{ writing.title }}</h1>
                <p v-if="writing.excerpt" class="text-base italic" style="color: var(--color-ink-500); font-family: var(--font-serif); border-left: 3px solid var(--color-blush-200); padding-left: 1rem;">
                    {{ writing.excerpt }}
                </p>
            </header>

            <!-- Divider -->
            <div class="flex items-center gap-3 mb-8">
                <div class="flex-1 h-px" style="background-color: var(--color-cream-200)" />
                <span style="color: var(--color-blush-300)">✦</span>
                <div class="flex-1 h-px" style="background-color: var(--color-cream-200)" />
            </div>

            <!-- Content -->
            <div class="prose-writing" v-html="writing.content" />

            <!-- Divider -->
            <div class="flex items-center gap-3 mt-12 mb-8">
                <div class="flex-1 h-px" style="background-color: var(--color-cream-200)" />
                <span style="color: var(--color-blush-300)">✦</span>
                <div class="flex-1 h-px" style="background-color: var(--color-cream-200)" />
            </div>

            <!-- Back link -->
            <Link
                :href="`/koleksi/${collection.slug}`"
                class="inline-flex items-center gap-2 text-sm transition-colors"
                style="color: var(--color-blush-500)"
            >
                ← Kembali ke {{ collection.title }}
            </Link>
        </article>
    </PublicLayout>
</template>
