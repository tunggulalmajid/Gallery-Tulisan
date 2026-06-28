<script setup lang="ts">
import PublicLayout from '@/Layouts/PublicLayout.vue';
import { Link } from '@inertiajs/vue3';
import { onMounted, ref } from 'vue';
import type { AuthorProfile, Collection, HeroSection, Writing } from '@/types';

defineProps<{
    latestWritings: Writing[];
    latestCollections: Collection[];
    author: AuthorProfile | null;
    hero: HeroSection | null;
}>();

function thumbnailUrl(path: string | null): string {
    return path ? `/storage/${path}` : '';
}

// Scroll-reveal via IntersectionObserver
const reveals = ref<HTMLElement[]>([]);
onMounted(() => {
    const io = new IntersectionObserver((entries) => {
        entries.forEach(e => {
            if (e.isIntersecting) {
                (e.target as HTMLElement).classList.add('revealed');
                io.unobserve(e.target);
            }
        });
    }, { threshold: 0.12 });
    document.querySelectorAll('.reveal').forEach(el => io.observe(el));
});
</script>

<template>
    <PublicLayout>

        <!-- ── Hero ──────────────────────────────────────────── -->
        <section class="relative min-h-screen flex items-center overflow-hidden" style="background-color: var(--color-forest-900)">
            <!-- BG image -->
            <div v-if="hero?.image" class="absolute inset-0">
                <img
                    :src="thumbnailUrl(hero.image)"
                    alt=""
                    class="w-full h-full object-cover"
                    style="opacity:0.32; transform:scale(1.04); transition:transform 8s ease"
                />
            </div>
            <!-- Overlay — tipis saja -->
            <div class="absolute inset-0" style="background: linear-gradient(160deg, rgba(12,35,12,0.62) 0%, rgba(12,35,12,0.38) 100%)"/>

            <!-- Decorative circle -->
            <div class="absolute -right-32 -top-32 w-96 h-96 rounded-full opacity-10" style="background: radial-gradient(circle, var(--color-sage-400), transparent 70%)"/>
            <div class="absolute -left-24 bottom-0 w-80 h-80 rounded-full opacity-5" style="background: radial-gradient(circle, var(--color-mint-400), transparent 70%)"/>

            <!-- Content -->
            <div class="relative w-full max-w-6xl mx-auto px-5 sm:px-10 py-32 sm:py-40">
                <div class="max-w-2xl">
                    <p class="animate-fade-up text-xs sm:text-sm font-semibold tracking-[0.22em] uppercase mb-6" style="color: var(--color-sage-300); animation-delay: 0.05s">
                        {{ hero?.subheading ?? 'Karya Pribadi' }}
                    </p>
                    <h1
                        class="animate-fade-up font-semibold mb-6 leading-tight"
                        style="font-family: var(--font-serif); color: white; font-size: clamp(2.4rem, 6vw, 4rem); line-height: 1.1; animation-delay: 0.15s"
                    >
                        {{ hero?.heading ?? 'Setiap Kata adalah Jejak Rasa' }}
                    </h1>
                    <p
                        class="animate-fade-up mb-10 max-w-lg"
                        style="color: rgba(255,255,255,0.6); line-height: 1.8; font-size: 1.05rem; animation-delay: 0.25s"
                    >
                        {{ hero?.body ?? 'Kumpulan puisi, pantun, dan cerita yang lahir dari ruang paling sunyi.' }}
                    </p>
                    <div class="animate-fade-up flex flex-wrap gap-3" style="animation-delay: 0.35s">
                        <Link
                            :href="hero?.cta_url ?? '/koleksi'"
                            class="inline-flex items-center gap-2.5 px-7 py-3.5 rounded-full text-sm font-semibold transition-all duration-200 hover:scale-105 active:scale-95"
                            style="background-color: var(--color-sage-400); color: white; box-shadow: 0 4px 20px rgba(82,160,82,0.35)"
                        >
                            {{ hero?.cta_label ?? 'Jelajahi Karya' }}
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                            </svg>
                        </Link>
                        <Link
                            href="/penulis"
                            class="inline-flex items-center px-7 py-3.5 rounded-full text-sm font-semibold transition-all duration-200 hover:bg-white/15"
                            style="border: 1.5px solid rgba(255,255,255,0.22); color: rgba(255,255,255,0.82)"
                        >
                            Tentang Penulis
                        </Link>
                    </div>
                </div>
            </div>

            <!-- Scroll cue -->
            <div class="absolute bottom-10 left-1/2 -translate-x-1/2 flex flex-col items-center gap-2 animate-fade-in" style="animation-delay: 0.6s">
                <span class="text-xs tracking-[0.2em] uppercase" style="color: rgba(255,255,255,0.3)">scroll</span>
                <div class="w-px h-10" style="background: linear-gradient(to bottom, rgba(255,255,255,0.25), transparent)"/>
            </div>
        </section>

        <!-- ── Latest Writings ──────────────────────────────── -->
        <section class="max-w-6xl mx-auto px-5 sm:px-10 py-20 sm:py-28">
            <div class="reveal flex flex-col sm:flex-row sm:items-end justify-between gap-4 mb-12">
                <div>
                    <p class="text-xs font-semibold tracking-[0.18em] uppercase mb-2" style="color: var(--color-sage-500)">Terbaru</p>
                    <h2 style="font-family: var(--font-serif); color: var(--color-ink-900); font-size: clamp(1.6rem, 3vw, 2.2rem); font-weight: 600">
                        Tulisan Terkini
                    </h2>
                </div>
                <Link
                    href="/koleksi"
                    class="inline-flex items-center gap-1.5 text-sm font-medium transition-all duration-200 hover:gap-3 self-start sm:self-auto"
                    style="color: var(--color-sage-600)"
                >
                    Semua tulisan
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </Link>
            </div>

            <div v-if="latestWritings.length > 0" class="grid grid-cols-1 lg:grid-cols-5 gap-4 lg:gap-5">
                <!-- Featured card -->
                <Link
                    :href="`/koleksi/${latestWritings[0].collection?.slug}/${latestWritings[0].slug}`"
                    class="reveal group relative rounded-2xl overflow-hidden lg:col-span-3 flex-shrink-0"
                    style="min-height: 380px; animation-delay: 0.05s"
                >
                    <div class="absolute inset-0">
                        <img
                            v-if="latestWritings[0].thumbnail"
                            :src="thumbnailUrl(latestWritings[0].thumbnail)"
                            :alt="latestWritings[0].title"
                            class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"
                        />
                        <div v-else class="w-full h-full" style="background: linear-gradient(145deg, var(--color-sage-700), var(--color-forest-800))"/>
                    </div>
                    <div class="absolute inset-0" style="background: linear-gradient(to top, rgba(10,28,10,0.92) 0%, rgba(10,28,10,0.2) 55%, transparent 100%)"/>
                    <div class="absolute bottom-0 left-0 right-0 p-6 sm:p-8">
                        <span class="inline-block text-xs px-3 py-1 rounded-full mb-3 capitalize font-medium" style="background-color: var(--color-sage-400); color: white">
                            {{ latestWritings[0].type }}
                        </span>
                        <h3 class="text-xl sm:text-2xl font-semibold mb-2" style="font-family: var(--font-serif); color: white; line-height: 1.2">
                            {{ latestWritings[0].title }}
                        </h3>
                        <p v-if="latestWritings[0].excerpt" class="text-sm line-clamp-2 mb-2" style="color: rgba(255,255,255,0.55)">
                            {{ latestWritings[0].excerpt }}
                        </p>
                        <p class="text-xs" style="color: rgba(255,255,255,0.35)">{{ latestWritings[0].collection?.title }}</p>
                    </div>
                </Link>

                <!-- Side list -->
                <div class="lg:col-span-2 flex flex-col gap-3">
                    <Link
                        v-for="(w, i) in latestWritings.slice(1, 5)"
                        :key="w.id"
                        :href="`/koleksi/${w.collection?.slug}/${w.slug}`"
                        class="reveal group flex items-center gap-3.5 p-3.5 rounded-2xl card-hover"
                        style="background-color: white; border: 1px solid var(--color-cream-200)"
                        :style="`animation-delay: ${0.08 * (i + 1)}s`"
                    >
                        <div class="w-16 h-16 rounded-xl overflow-hidden flex-shrink-0">
                            <img
                                v-if="w.thumbnail"
                                :src="thumbnailUrl(w.thumbnail)"
                                :alt="w.title"
                                class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
                            />
                            <div v-else class="w-full h-full flex items-center justify-center" style="background: linear-gradient(135deg, var(--color-sage-100), var(--color-mint-100))">
                                <span style="color: var(--color-sage-300); font-size: 1.1rem">✦</span>
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <span class="text-xs capitalize font-medium" style="color: var(--color-sage-500)">{{ w.type }}</span>
                            <h3 class="text-sm font-semibold leading-snug mt-0.5 mb-1 transition-colors group-hover:text-[--color-sage-600]" style="font-family: var(--font-serif); color: var(--color-ink-800)">
                                {{ w.title }}
                            </h3>
                            <p class="text-xs truncate" style="color: var(--color-stone-400)">{{ w.collection?.title }}</p>
                        </div>
                        <svg class="w-4 h-4 flex-shrink-0 transition-transform duration-200 group-hover:translate-x-1" style="color: var(--color-sage-300)" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </Link>
                </div>
            </div>

            <!-- Empty -->
            <div v-else class="py-20 text-center">
                <p style="color: var(--color-ink-300); font-size: 2rem">✦</p>
                <p class="mt-3 text-sm" style="color: var(--color-ink-400)">Belum ada tulisan.</p>
            </div>
        </section>

        <!-- ── Collections ──────────────────────────────────── -->
        <section class="py-20 sm:py-28" style="background-color: var(--color-sage-50)">
            <div class="max-w-6xl mx-auto px-5 sm:px-10">
                <div class="reveal flex flex-col sm:flex-row sm:items-end justify-between gap-4 mb-12">
                    <div>
                        <p class="text-xs font-semibold tracking-[0.18em] uppercase mb-2" style="color: var(--color-sage-500)">Koleksi</p>
                        <h2 style="font-family: var(--font-serif); color: var(--color-ink-900); font-size: clamp(1.6rem, 3vw, 2.2rem); font-weight: 600">
                            Jelajahi Koleksi
                        </h2>
                    </div>
                    <Link href="/koleksi" class="inline-flex items-center gap-1.5 text-sm font-medium transition-all hover:gap-3 self-start sm:self-auto" style="color: var(--color-sage-600)">
                        Semua koleksi
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </Link>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <Link
                        v-for="(col, i) in latestCollections"
                        :key="col.id"
                        :href="`/koleksi/${col.slug}`"
                        class="reveal group flex items-center gap-4 p-4 sm:p-5 rounded-2xl card-hover"
                        style="background-color: white; border: 1px solid var(--color-cream-200)"
                        :style="`animation-delay: ${i * 0.07}s`"
                    >
                        <div class="w-14 h-14 sm:w-16 sm:h-16 rounded-xl overflow-hidden flex-shrink-0">
                            <img
                                v-if="col.thumbnail"
                                :src="thumbnailUrl(col.thumbnail)"
                                :alt="col.title"
                                class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
                            />
                            <div v-else class="w-full h-full flex items-center justify-center" style="background: linear-gradient(135deg, var(--color-sage-200), var(--color-mint-200))">
                                <svg class="w-5 h-5" style="color: var(--color-sage-500)" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                </svg>
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h3 class="font-semibold text-sm sm:text-base mb-1 transition-colors group-hover:text-[--color-sage-600]" style="font-family: var(--font-serif); color: var(--color-ink-800)">
                                {{ col.title }}
                            </h3>
                            <p v-if="col.description" class="text-xs line-clamp-1 mb-1.5" style="color: var(--color-ink-400)">{{ col.description }}</p>
                            <span class="text-xs font-medium" style="color: var(--color-sage-500)">
                                {{ col.published_writings_count ?? col.writings_count ?? 0 }} tulisan
                            </span>
                        </div>
                        <svg class="w-4 h-4 flex-shrink-0 transition-transform duration-200 group-hover:translate-x-1" style="color: var(--color-sage-300)" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </Link>
                </div>
            </div>
        </section>

        <!-- ── Author teaser ────────────────────────────────── -->
        <section v-if="author" class="max-w-6xl mx-auto px-5 sm:px-10 py-20 sm:py-28">
            <div class="reveal rounded-3xl overflow-hidden grid grid-cols-1 sm:grid-cols-5" style="background-color: white; border: 1px solid var(--color-cream-200)">
                <!-- Photo side -->
                <div
                    class="sm:col-span-2 relative flex items-center justify-center py-12 px-6"
                    style="background: linear-gradient(160deg, var(--color-sage-50) 0%, var(--color-mint-50) 100%)"
                >
                    <div class="w-28 h-28 sm:w-32 sm:h-32 rounded-full overflow-hidden" style="border: 4px solid white; box-shadow: 0 8px 30px rgba(0,0,0,0.10)">
                        <img v-if="author.photo" :src="thumbnailUrl(author.photo)" :alt="author.name" class="w-full h-full object-cover"/>
                        <div v-else class="w-full h-full flex items-center justify-center" style="background: linear-gradient(135deg, var(--color-sage-300), var(--color-forest-500))">
                            <span style="font-family: var(--font-serif); font-size: 2.5rem; color: white; font-weight: 600">{{ author.name.charAt(0) }}</span>
                        </div>
                    </div>
                </div>
                <!-- Text side -->
                <div class="sm:col-span-3 flex flex-col justify-center p-8 sm:p-12">
                    <p class="text-xs font-semibold tracking-[0.18em] uppercase mb-3" style="color: var(--color-sage-500)">Penulis</p>
                    <h3 class="font-semibold mb-2" style="font-family: var(--font-serif); color: var(--color-ink-900); font-size: clamp(1.4rem, 3vw, 1.8rem)">
                        {{ author.name }}
                    </h3>
                    <p v-if="author.tagline" class="text-sm italic mb-7" style="color: var(--color-sage-600); font-family: var(--font-serif)">
                        {{ author.tagline }}
                    </p>
                    <Link
                        href="/penulis"
                        class="inline-flex items-center gap-2 text-sm font-medium transition-all duration-200 hover:gap-3 w-fit"
                        style="color: var(--color-forest-700)"
                    >
                        Baca lebih lanjut
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </Link>
                </div>
            </div>
        </section>

    </PublicLayout>
</template>

<style scoped>
/* Scroll-reveal */
.reveal {
    opacity: 0;
    transform: translateY(28px);
    transition: opacity 0.55s ease, transform 0.55s ease;
}
.reveal.revealed {
    opacity: 1;
    transform: translateY(0);
}
</style>
