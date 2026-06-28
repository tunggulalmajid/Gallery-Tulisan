<script setup lang="ts">
import PublicLayout from '@/Layouts/PublicLayout.vue';
import type { AuthorProfile } from '@/types';

defineProps<{
    author: AuthorProfile | null;
}>();

function photoUrl(path: string | null): string {
    return path ? `/storage/${path}` : '';
}
</script>

<template>
    <PublicLayout>
        <section class="max-w-3xl mx-auto px-4 sm:px-6 py-16">
            <!-- Card -->
            <div class="rounded-3xl overflow-hidden shadow-sm" style="background-color: white; border: 1px solid var(--color-cream-200)">
                <!-- Banner -->
                <div class="h-32 sm:h-44" style="background: linear-gradient(135deg, var(--color-blush-100) 0%, var(--color-mauve-100) 50%, var(--color-cream-100) 100%)" />

                <div class="px-6 sm:px-10 pb-10">
                    <!-- Avatar -->
                    <div class="-mt-14 mb-5">
                        <div class="w-24 h-24 rounded-full overflow-hidden shadow-md" style="border: 3px solid white">
                            <img v-if="author?.photo" :src="photoUrl(author.photo)" :alt="author.name" class="w-full h-full object-cover" />
                            <div v-else class="w-full h-full flex items-center justify-center" style="background: linear-gradient(135deg, var(--color-blush-200), var(--color-mauve-200))">
                                <span style="font-family: var(--font-serif); font-size: 2rem; color: white; font-weight: 600">
                                    {{ author?.name?.charAt(0)?.toUpperCase() ?? 'S' }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Info -->
                    <div v-if="author">
                        <h1 class="text-2xl sm:text-3xl mb-1" style="font-family: var(--font-serif); color: var(--color-ink-900); font-weight: 600">{{ author.name }}</h1>
                        <p v-if="author.tagline" class="text-sm italic mb-6" style="color: var(--color-blush-600); font-family: var(--font-serif)">{{ author.tagline }}</p>

                        <!-- Divider -->
                        <div class="h-px mb-6" style="background-color: var(--color-cream-200)" />

                        <p v-if="author.bio" class="text-sm leading-relaxed mb-8 whitespace-pre-line" style="color: var(--color-ink-600); line-height: 1.8; font-family: var(--font-serif)">{{ author.bio }}</p>

                        <!-- Social links -->
                        <div class="flex flex-wrap gap-3">
                            <a
                                v-if="author.instagram"
                                :href="`https://instagram.com/${author.instagram}`"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="inline-flex items-center gap-2 px-4 py-2 rounded-full text-sm transition-all hover:opacity-80"
                                style="background-color: var(--color-blush-50); color: var(--color-blush-700); border: 1px solid var(--color-blush-200)"
                            >
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                                </svg>
                                @{{ author.instagram }}
                            </a>
                            <a
                                v-if="author.twitter"
                                :href="`https://twitter.com/${author.twitter}`"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="inline-flex items-center gap-2 px-4 py-2 rounded-full text-sm transition-all hover:opacity-80"
                                style="background-color: var(--color-mauve-50); color: var(--color-mauve-700); border: 1px solid var(--color-mauve-200)"
                            >
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-4.714-6.231-5.401 6.231H2.744l7.736-8.856L1.254 2.25H8.08l4.253 5.622zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                                </svg>
                                @{{ author.twitter }}
                            </a>
                            <a
                                v-if="author.email"
                                :href="`mailto:${author.email}`"
                                class="inline-flex items-center gap-2 px-4 py-2 rounded-full text-sm transition-all hover:opacity-80"
                                style="background-color: var(--color-cream-100); color: var(--color-ink-600); border: 1px solid var(--color-cream-300)"
                            >
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                                {{ author.email }}
                            </a>
                        </div>
                    </div>

                    <div v-else class="text-center py-10">
                        <p style="color: var(--color-ink-400)">Profil penulis belum tersedia.</p>
                    </div>
                </div>
            </div>
        </section>
    </PublicLayout>
</template>
