<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import type { Collection, Writing } from '@/types';

defineProps<{
    stats: {
        total_collections: number;
        total_writings: number;
        published_writings: number;
        draft_writings: number;
    };
    recentWritings: Writing[];
    recentCollections: Collection[];
}>();

function formatDate(date: string): string {
    return new Date(date).toLocaleDateString('id-ID', {
        day: 'numeric',
        month: 'short',
        year: 'numeric',
    });
}
</script>

<template>
    <AdminLayout>
        <template #header>
            <h1
                class="text-base font-semibold"
                style="
                    font-family: var(--font-serif);
                    color: var(--color-ink-800);
                "
            >
                Dashboard
            </h1>
        </template>

        <!-- Stat cards -->
        <div class="mb-8 grid grid-cols-2 gap-4 lg:grid-cols-4">
            <div
                class="rounded-2xl p-5"
                style="
                    background-color: white;
                    border: 1px solid var(--color-cream-200);
                "
            >
                <p class="mb-3 text-xs" style="color: var(--color-ink-400)">
                    Total Koleksi
                </p>
                <p
                    class="text-3xl font-bold"
                    style="
                        font-family: var(--font-serif);
                        color: var(--color-forest-700);
                    "
                >
                    {{ stats.total_collections }}
                </p>
            </div>
            <div
                class="rounded-2xl p-5"
                style="
                    background-color: white;
                    border: 1px solid var(--color-cream-200);
                "
            >
                <p class="mb-3 text-xs" style="color: var(--color-ink-400)">
                    Total Tulisan
                </p>
                <p
                    class="text-3xl font-bold"
                    style="
                        font-family: var(--font-serif);
                        color: var(--color-sage-600);
                    "
                >
                    {{ stats.total_writings }}
                </p>
            </div>
            <div
                class="rounded-2xl p-5"
                style="
                    background-color: white;
                    border: 1px solid var(--color-cream-200);
                "
            >
                <p class="mb-3 text-xs" style="color: var(--color-ink-400)">
                    Dipublikasikan
                </p>
                <p
                    class="text-3xl font-bold"
                    style="font-family: var(--font-serif); color: #15803d"
                >
                    {{ stats.published_writings }}
                </p>
            </div>
            <div
                class="rounded-2xl p-5"
                style="
                    background-color: white;
                    border: 1px solid var(--color-cream-200);
                "
            >
                <p class="mb-3 text-xs" style="color: var(--color-ink-400)">
                    Draft
                </p>
                <p
                    class="text-3xl font-bold"
                    style="
                        font-family: var(--font-serif);
                        color: var(--color-stone-400);
                    "
                >
                    {{ stats.draft_writings }}
                </p>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-5 lg:grid-cols-2">
            <!-- Recent Writings -->
            <div
                class="overflow-hidden rounded-2xl"
                style="
                    background-color: white;
                    border: 1px solid var(--color-cream-200);
                "
            >
                <div
                    class="flex items-center justify-between border-b px-5 py-4"
                    style="border-color: var(--color-cream-100)"
                >
                    <h2
                        class="text-sm font-semibold"
                        style="
                            font-family: var(--font-serif);
                            color: var(--color-ink-800);
                        "
                    >
                        Tulisan Terbaru
                    </h2>
                    <Link
                        href="/admin/writings"
                        class="text-xs transition-colors"
                        style="color: var(--color-sage-600)"
                        >Lihat semua →</Link
                    >
                </div>
                <div>
                    <div
                        v-for="w in recentWritings"
                        :key="w.id"
                        class="flex items-center justify-between gap-3 border-b px-5 py-3 last:border-0"
                        style="border-color: var(--color-cream-100)"
                    >
                        <div class="min-w-0">
                            <p
                                class="truncate text-sm font-medium"
                                style="color: var(--color-ink-800)"
                            >
                                {{ w.title }}
                            </p>
                            <p
                                class="text-xs"
                                style="color: var(--color-ink-400)"
                            >
                                {{ w.collection?.title }} ·
                                {{ formatDate(w.created_at) }}
                            </p>
                        </div>
                        <span
                            class="flex-shrink-0 rounded-full px-2 py-0.5 text-xs"
                            :style="
                                w.is_published
                                    ? 'background-color: #f0fdf4; color: #15803d'
                                    : 'background-color: var(--color-cream-100); color: var(--color-ink-400)'
                            "
                        >
                            {{ w.is_published ? 'Publik' : 'Draft' }}
                        </span>
                    </div>
                    <div
                        v-if="recentWritings.length === 0"
                        class="px-5 py-8 text-center text-sm"
                        style="color: var(--color-ink-400)"
                    >
                        Belum ada tulisan
                    </div>
                </div>
            </div>

            <!-- Recent Collections -->
            <div
                class="overflow-hidden rounded-2xl"
                style="
                    background-color: white;
                    border: 1px solid var(--color-cream-200);
                "
            >
                <div
                    class="flex items-center justify-between border-b px-5 py-4"
                    style="border-color: var(--color-cream-100)"
                >
                    <h2
                        class="text-sm font-semibold"
                        style="
                            font-family: var(--font-serif);
                            color: var(--color-ink-800);
                        "
                    >
                        Koleksi Terbaru
                    </h2>
                    <Link
                        href="/admin/collections"
                        class="text-xs transition-colors"
                        style="color: var(--color-sage-600)"
                        >Lihat semua →</Link
                    >
                </div>
                <div>
                    <div
                        v-for="c in recentCollections"
                        :key="c.id"
                        class="flex items-center justify-between gap-3 border-b px-5 py-3 last:border-0"
                        style="border-color: var(--color-cream-100)"
                    >
                        <div class="min-w-0">
                            <p
                                class="truncate text-sm font-medium"
                                style="color: var(--color-ink-800)"
                            >
                                {{ c.title }}
                            </p>
                            <p
                                class="text-xs"
                                style="color: var(--color-ink-400)"
                            >
                                {{ c.writings_count ?? 0 }} tulisan ·
                                {{ formatDate(c.created_at) }}
                            </p>
                        </div>
                        <span
                            class="flex-shrink-0 rounded-full px-2 py-0.5 text-xs"
                            :style="
                                c.is_published
                                    ? 'background-color: #f0fdf4; color: #15803d'
                                    : 'background-color: var(--color-cream-100); color: var(--color-ink-400)'
                            "
                        >
                            {{ c.is_published ? 'Publik' : 'Draft' }}
                        </span>
                    </div>
                    <div
                        v-if="recentCollections.length === 0"
                        class="px-5 py-8 text-center text-sm"
                        style="color: var(--color-ink-400)"
                    >
                        Belum ada koleksi
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick actions -->
        <div class="mt-5 flex flex-wrap gap-3">
            <Link
                href="/admin/collections/create"
                class="inline-flex items-center gap-2 rounded-xl px-4 py-2 text-sm font-medium transition-all hover:opacity-90"
                style="
                    background-color: var(--color-cream-100);
                    color: var(--color-forest-700);
                    border: 1px solid var(--color-cream-300);
                "
            >
                + Koleksi Baru
            </Link>
            <Link
                href="/admin/writings/create"
                class="inline-flex items-center gap-2 rounded-xl px-4 py-2 text-sm font-medium transition-all hover:opacity-90"
                style="background-color: var(--color-forest-800); color: white"
            >
                + Tulisan Baru
            </Link>
            <Link
                href="/admin/hero"
                class="inline-flex items-center gap-2 rounded-xl px-4 py-2 text-sm font-medium transition-all hover:opacity-90"
                style="
                    background-color: var(--color-cream-100);
                    color: var(--color-sage-700);
                    border: 1px solid var(--color-cream-300);
                "
            >
                Edit Hero
            </Link>
        </div>
    </AdminLayout>
</template>
