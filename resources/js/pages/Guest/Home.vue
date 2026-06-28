<script setup lang="ts">
import PublicLayout from '@/Layouts/PublicLayout.vue';
import { Link } from '@inertiajs/vue3';
import type { AuthorProfile, Collection, Writing } from '@/types';

defineProps<{
    latestWritings: Writing[];
    latestCollections: Collection[];
    author: AuthorProfile | null;
}>();

function thumbnailUrl(path: string | null): string {
    if (!path) return '';
    return `/storage/${path}`;
}
</script>

<template>
    <PublicLayout>
        <!-- Hero -->
        <section class="relative overflow-hidden" style="background: linear-gradient(135deg, var(--color-blush-50) 0%, var(--color-mauve-50) 50%, var(--color-cream-100) 100%)">
            <div class="max-w-5xl mx-auto px-4 sm:px-6 py-20 sm:py-28 text-center">
                <p class="text-sm tracking-widest uppercase mb-4" style="color: var(--color-blush-500); font-family: var(--font-serif); font-style: italic">Selamat datang</p>
                <h1 class="text-4xl sm:text-5xl lg:text-6xl mb-6" style="font-family: var(--font-serif); color: var(--color-ink-900); line-height: 1.2; font-weight: 600">
                    {{ author?.tagline ?? 'Setiap kata adalah jejak rasa.' }}
                </h1>
                <p class="text-base sm:text-lg max-w-xl mx-auto mb-10" style="color: var(--color-ink-500); line-height: 1.7">
                    Karya-karya pribadi dari <strong style="color: var(--color-blush-700)">{{ author?.name ?? 'Suci' }}</strong> — puisi, pantun, dan cerita yang lahir dari hati.
                </p>
                <div class="flex flex-wrap justify-center gap-3">
                    <Link href="/koleksi" class="px-6 py-3 rounded-full text-sm font-medium text-white transition-all hover:opacity-90 shadow-sm" style="background-color: var(--color-blush-500)">
                        Jelajahi Koleksi
                    </Link>
                    <Link href="/penulis" class="px-6 py-3 rounded-full text-sm font-medium transition-all" style="background-color: white; color: var(--color-blush-600); border: 1px solid var(--color-blush-200)">
                        Tentang Penulis
                    </Link>
                </div>
            </div>
            <!-- Decorative circles -->
            <div class="absolute -top-10 -right-10 w-64 h-64 rounded-full opacity-20" style="background: radial-gradient(circle, var(--color-blush-300), transparent)" />
            <div class="absolute -bottom-16 -left-10 w-80 h-80 rounded-full opacity-10" style="background: radial-gradient(circle, var(--color-mauve-400), transparent)" />
        </section>

        <!-- Latest Writings -->
        <section class="max-w-5xl mx-auto px-4 sm:px-6 py-16">
            <div class="flex items-end justify-between mb-8">
                <div>
                    <p class="text-xs tracking-widest uppercase mb-1" style="color: var(--color-blush-500); font-family: var(--font-serif); font-style: italic">Terbaru</p>
                    <h2 class="text-2xl sm:text-3xl" style="font-family: var(--font-serif); color: var(--color-ink-800); font-weight: 600">Tulisan Terkini</h2>
                </div>
                <Link href="/koleksi" class="text-sm transition-colors" style="color: var(--color-blush-600)">Lihat semua →</Link>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
                <Link
                    v-for="writing in latestWritings"
                    :key="writing.id"
                    :href="`/koleksi/${writing.collection?.slug}/${writing.slug}`"
                    class="group block rounded-2xl overflow-hidden transition-all duration-200 hover:-translate-y-1 hover:shadow-lg"
                    style="background-color: white; border: 1px solid var(--color-cream-200)"
                >
                    <div v-if="writing.thumbnail" class="aspect-[4/3] overflow-hidden">
                        <img :src="thumbnailUrl(writing.thumbnail)" :alt="writing.title" class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105" />
                    </div>
                    <div v-else class="aspect-[4/3] flex items-center justify-center" style="background: linear-gradient(135deg, var(--color-blush-50), var(--color-mauve-50))">
                        <span style="font-family: var(--font-serif); color: var(--color-blush-300); font-size: 2rem">✦</span>
                    </div>
                    <div class="p-4">
                        <span class="inline-block text-xs px-2 py-0.5 rounded-full mb-2 capitalize" style="background-color: var(--color-blush-50); color: var(--color-blush-600)">{{ writing.type }}</span>
                        <h3 class="font-semibold text-base leading-snug mb-1.5 group-hover:text-[--color-blush-700] transition-colors" style="font-family: var(--font-serif); color: var(--color-ink-800)">{{ writing.title }}</h3>
                        <p v-if="writing.excerpt" class="text-xs line-clamp-2" style="color: var(--color-ink-500)">{{ writing.excerpt }}</p>
                        <p class="text-xs mt-2" style="color: var(--color-ink-400)">{{ writing.collection?.title }}</p>
                    </div>
                </Link>
            </div>
        </section>

        <!-- Latest Collections -->
        <section class="py-16" style="background-color: var(--color-cream-100)">
            <div class="max-w-5xl mx-auto px-4 sm:px-6">
                <div class="flex items-end justify-between mb-8">
                    <div>
                        <p class="text-xs tracking-widest uppercase mb-1" style="color: var(--color-mauve-500); font-family: var(--font-serif); font-style: italic">Koleksi</p>
                        <h2 class="text-2xl sm:text-3xl" style="font-family: var(--font-serif); color: var(--color-ink-800); font-weight: 600">Koleksi Terbaru</h2>
                    </div>
                    <Link href="/koleksi" class="text-sm transition-colors" style="color: var(--color-mauve-600)">Semua koleksi →</Link>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <Link
                        v-for="col in latestCollections"
                        :key="col.id"
                        :href="`/koleksi/${col.slug}`"
                        class="group flex gap-4 p-5 rounded-2xl transition-all duration-200 hover:shadow-md"
                        style="background-color: white; border: 1px solid var(--color-cream-200)"
                    >
                        <div class="w-16 h-16 rounded-xl overflow-hidden flex-shrink-0">
                            <img v-if="col.thumbnail" :src="thumbnailUrl(col.thumbnail)" :alt="col.title" class="w-full h-full object-cover" />
                            <div v-else class="w-full h-full flex items-center justify-center" style="background: linear-gradient(135deg, var(--color-mauve-100), var(--color-blush-100))">
                                <span style="color: var(--color-mauve-400); font-size: 1.2rem">📖</span>
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h3 class="font-semibold text-sm leading-snug mb-1 group-hover:text-[--color-blush-700] transition-colors" style="font-family: var(--font-serif); color: var(--color-ink-800)">{{ col.title }}</h3>
                            <p v-if="col.description" class="text-xs line-clamp-2 mb-2" style="color: var(--color-ink-500)">{{ col.description }}</p>
                            <span class="text-xs" style="color: var(--color-ink-400)">{{ col.published_writings_count ?? col.writings_count ?? 0 }} tulisan</span>
                        </div>
                    </Link>
                </div>
            </div>
        </section>
    </PublicLayout>
</template>
