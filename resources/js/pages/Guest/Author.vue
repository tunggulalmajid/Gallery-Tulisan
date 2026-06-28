<script setup lang="ts">
import PublicLayout from '@/Layouts/PublicLayout.vue';
import { onMounted } from 'vue';
import type { AuthorProfile } from '@/types';

defineProps<{
    author: AuthorProfile | null;
}>();

function photoUrl(path: string | null): string {
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
                <p class="text-xs font-semibold tracking-[0.18em] uppercase mb-3" style="color: var(--color-sage-500)">Tentang</p>
                <h1 style="font-family: var(--font-serif); color: var(--color-ink-900); font-size: clamp(1.8rem, 4vw, 2.6rem); font-weight: 600">
                    Penulis
                </h1>
            </div>
        </section>

        <div v-if="author" class="max-w-3xl mx-auto px-5 sm:px-10 py-14 sm:py-20">
            <!-- Profile card -->
            <div class="reveal rounded-3xl overflow-hidden mb-12" style="background-color: white; border: 1px solid var(--color-cream-200)">
                <div class="flex flex-col sm:flex-row">
                    <!-- Photo -->
                    <div
                        class="sm:w-64 flex items-center justify-center py-10 px-8 flex-shrink-0"
                        style="background: linear-gradient(160deg, var(--color-sage-50), var(--color-mint-50))"
                    >
                        <div class="w-28 h-28 sm:w-36 sm:h-36 rounded-full overflow-hidden" style="border: 4px solid white; box-shadow: 0 8px 30px rgba(0,0,0,0.1)">
                            <img v-if="author.photo" :src="photoUrl(author.photo)" :alt="author.name" class="w-full h-full object-cover"/>
                            <div v-else class="w-full h-full flex items-center justify-center" style="background: linear-gradient(135deg, var(--color-sage-300), var(--color-forest-500))">
                                <span style="font-family: var(--font-serif); font-size: 3rem; color: white; font-weight: 600">{{ author.name.charAt(0) }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Info -->
                    <div class="flex-1 p-7 sm:p-8 flex flex-col justify-center">
                        <p class="text-xs font-semibold tracking-[0.18em] uppercase mb-2" style="color: var(--color-sage-500)">Penulis</p>
                        <h2 class="font-semibold mb-2" style="font-family: var(--font-serif); color: var(--color-ink-900); font-size: clamp(1.5rem, 4vw, 2rem)">
                            {{ author.name }}
                        </h2>
                        <p v-if="author.tagline" class="text-sm italic mb-5" style="color: var(--color-sage-600); font-family: var(--font-serif); line-height: 1.7">
                            {{ author.tagline }}
                        </p>

                        <!-- Social links -->
                        <div class="flex flex-wrap gap-2">
                            <a
                                v-if="author.instagram"
                                :href="`https://instagram.com/${author.instagram}`"
                                target="_blank" rel="noopener noreferrer"
                                class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-full text-xs font-medium transition-all hover:opacity-75"
                                style="background-color: var(--color-cream-100); color: var(--color-ink-600); border: 1px solid var(--color-cream-200)"
                            >
                                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                                </svg>
                                @{{ author.instagram }}
                            </a>
                            <a
                                v-if="author.twitter"
                                :href="`https://twitter.com/${author.twitter}`"
                                target="_blank" rel="noopener noreferrer"
                                class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-full text-xs font-medium transition-all hover:opacity-75"
                                style="background-color: var(--color-cream-100); color: var(--color-ink-600); border: 1px solid var(--color-cream-200)"
                            >
                                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-4.714-6.231-5.401 6.231H2.746l7.73-8.835L1.254 2.25H8.08l4.259 5.63L18.244 2.25zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                                </svg>
                                @{{ author.twitter }}
                            </a>
                            <a
                                v-if="author.website"
                                :href="author.website"
                                target="_blank" rel="noopener noreferrer"
                                class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-full text-xs font-medium transition-all hover:opacity-75"
                                style="background-color: var(--color-cream-100); color: var(--color-ink-600); border: 1px solid var(--color-cream-200)"
                            >
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                </svg>
                                Website
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bio -->
            <div v-if="author.bio" class="reveal" style="animation-delay: 0.1s">
                <p class="text-xs font-semibold tracking-[0.18em] uppercase mb-6" style="color: var(--color-sage-500)">Tentang</p>
                <div class="p-7 sm:p-8 rounded-2xl" style="background-color: white; border: 1px solid var(--color-cream-200)">
                    <p
                        class="whitespace-pre-line"
                        style="font-family: var(--font-serif); color: var(--color-ink-700); line-height: 1.95; font-size: 1.05rem"
                    >{{ author.bio }}</p>
                </div>
            </div>
        </div>

        <!-- Empty state -->
        <div v-else class="flex flex-col items-center justify-center py-32">
            <p class="text-4xl mb-4" style="color: var(--color-sage-200)">✦</p>
            <p class="text-sm" style="color: var(--color-ink-400)">Profil penulis belum tersedia.</p>
        </div>
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
