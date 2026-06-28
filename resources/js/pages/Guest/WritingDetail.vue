<script setup lang="ts">
import PublicLayout from '@/Layouts/PublicLayout.vue';
import { Link } from '@inertiajs/vue3';
import type { Collection, Writing } from '@/types';

defineProps<{
    collection: Collection;
    writing: Writing;
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
</script>

<template>
    <PublicLayout>
        <article class="max-w-2xl mx-auto px-5 sm:px-8 py-14 sm:py-20 animate-fade-up">
            <!-- Breadcrumb -->
            <nav class="flex items-center flex-wrap gap-1.5 text-xs mb-10" style="color: var(--color-ink-400)">
                <Link href="/koleksi" class="hover:text-[--color-sage-600] transition-colors">Koleksi</Link>
                <svg class="w-3 h-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
                <Link :href="`/koleksi/${collection.slug}`" class="hover:text-[--color-sage-600] transition-colors truncate max-w-[120px]">
                    {{ collection.title }}
                </Link>
                <svg class="w-3 h-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
                <span class="truncate max-w-[150px]" style="color: var(--color-ink-600)">{{ writing.title }}</span>
            </nav>

            <!-- Hero thumbnail -->
            <div v-if="writing.thumbnail" class="w-full aspect-[16/9] rounded-2xl overflow-hidden mb-10 shadow-sm">
                <img :src="thumbnailUrl(writing.thumbnail)" :alt="writing.title" class="w-full h-full object-cover"/>
            </div>

            <!-- Header -->
            <header class="mb-10">
                <div class="flex items-center flex-wrap gap-2.5 mb-5">
                    <span class="text-xs px-2.5 py-1 rounded-full font-medium capitalize" :style="typeColors[writing.type] ?? typeColors.lainnya">
                        {{ writing.type }}
                    </span>
                    <span v-if="writing.written_at" class="text-xs" style="color: var(--color-stone-400)">
                        {{ formatDate(writing.written_at) }}
                    </span>
                </div>
                <h1 class="font-semibold mb-4 leading-tight" style="font-family: var(--font-serif); color: var(--color-ink-900); font-size: clamp(1.6rem, 5vw, 2.4rem)">
                    {{ writing.title }}
                </h1>
                <p v-if="writing.excerpt" class="text-base italic" style="color: var(--color-ink-500); font-family: var(--font-serif); line-height: 1.75">
                    {{ writing.excerpt }}
                </p>
            </header>

            <!-- Divider -->
            <div class="flex items-center gap-3 mb-10">
                <div class="flex-1 h-px" style="background-color: var(--color-cream-200)"/>
                <svg class="w-3.5 h-3.5 flex-shrink-0" style="color: var(--color-sage-300)" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/>
                </svg>
                <div class="flex-1 h-px" style="background-color: var(--color-cream-200)"/>
            </div>

            <!-- Content from TipTap -->
            <div
                class="tiptap-content prose-writing"
                v-html="writing.content"
            />

            <!-- End ornament -->
            <div class="flex items-center gap-3 mt-14 mb-10">
                <div class="flex-1 h-px" style="background-color: var(--color-cream-200)"/>
                <span style="color: var(--color-sage-400); font-size: 1rem">✦</span>
                <div class="flex-1 h-px" style="background-color: var(--color-cream-200)"/>
            </div>

            <!-- Back link -->
            <Link
                :href="`/koleksi/${collection.slug}`"
                class="inline-flex items-center gap-2 text-sm font-medium transition-all duration-200 hover:gap-3"
                style="color: var(--color-sage-600)"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18"/>
                </svg>
                Kembali ke {{ collection.title }}
            </Link>
        </article>
    </PublicLayout>
</template>

<style scoped>
/* Prose styling untuk konten TipTap */
.tiptap-content {
    font-family: var(--font-serif);
    color: var(--color-ink-800);
    line-height: 1.95;
    font-size: 1.05rem;
}
.tiptap-content :deep(p) {
    margin-bottom: 1.4em;
}
.tiptap-content :deep(h1),
.tiptap-content :deep(h2),
.tiptap-content :deep(h3) {
    font-family: var(--font-serif);
    color: var(--color-ink-900);
    font-weight: 600;
    margin-top: 1.8em;
    margin-bottom: 0.6em;
    line-height: 1.25;
}
.tiptap-content :deep(h1) { font-size: 1.6rem; }
.tiptap-content :deep(h2) { font-size: 1.3rem; }
.tiptap-content :deep(h3) { font-size: 1.1rem; }
.tiptap-content :deep(blockquote) {
    border-left: 3px solid var(--color-sage-300);
    padding-left: 1.25rem;
    margin: 1.5em 0;
    font-style: italic;
    color: var(--color-ink-500);
}
.tiptap-content :deep(img) {
    width: 100%;
    border-radius: 12px;
    margin: 1.5em 0;
}
.tiptap-content :deep(iframe) {
    width: 100%;
    aspect-ratio: 16/9;
    border-radius: 12px;
    margin: 1.5em 0;
    border: none;
}
.tiptap-content :deep(a) {
    color: var(--color-sage-600);
    text-decoration: underline;
    text-underline-offset: 3px;
}
.tiptap-content :deep(ul),
.tiptap-content :deep(ol) {
    padding-left: 1.5rem;
    margin-bottom: 1.2em;
}
.tiptap-content :deep(li) { margin-bottom: 0.4em; }
.tiptap-content :deep(strong) { font-weight: 700; color: var(--color-ink-900); }
.tiptap-content :deep(em) { font-style: italic; }
.tiptap-content :deep(hr) {
    border: none;
    border-top: 1px solid var(--color-cream-200);
    margin: 2em 0;
}
</style>
