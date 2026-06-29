<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { computed, onMounted, ref } from 'vue';
import { useSeo } from '@/composables/useSeo';
import PublicLayout from '@/Layouts/PublicLayout.vue';
import type { AuthorProfile, Collection, HeroSection, Writing } from '@/types';

const props = defineProps<{
    latestWritings: Writing[];
    latestCollections: Collection[];
    author: AuthorProfile | null;
    hero: HeroSection | null;
}>();

const seoDescription = computed(() => {
    if (props.hero?.subheading) {
        return props.hero.subheading;
    }

    if (props.author?.tagline) {
        return props.author.tagline;
    }

    return undefined;
});

const { meta } = useSeo({
    title: '',
    description: seoDescription.value,
    imagePath: props.hero?.image ?? props.author?.photo ?? null,
    urlPath: '/',
    type: 'website',
});

function thumbnailUrl(path: string | null): string {
    return path ? `/storage/${path}` : '';
}

// Scroll-reveal via IntersectionObserver
const reveals = ref<HTMLElement[]>([]); // eslint-disable-line @typescript-eslint/no-unused-vars
onMounted(() => {
    const io = new IntersectionObserver(
        (entries) => {
            entries.forEach((e) => {
                if (e.isIntersecting) {
                    (e.target as HTMLElement).classList.add('revealed');
                    io.unobserve(e.target);
                }
            });
        },
        { threshold: 0.12 },
    );
    document.querySelectorAll('.reveal').forEach((el) => io.observe(el));
});
</script>

<template>
    <PublicLayout>
        <Head>
            <title>{{ meta.title }}</title>
            <meta name="description" :content="meta.description" />
            <link rel="canonical" :href="meta.url" />
            <meta property="og:title" :content="meta.title" />
            <meta property="og:description" :content="meta.description" />
            <meta property="og:url" :content="meta.url" />
            <meta property="og:type" content="website" />
            <meta v-if="meta.image" property="og:image" :content="meta.image" />
            <meta name="twitter:title" :content="meta.title" />
            <meta name="twitter:description" :content="meta.description" />
            <meta
                v-if="meta.image"
                name="twitter:image"
                :content="meta.image"
            />
        </Head>

        <!-- ── Hero ──────────────────────────────────────────── -->
        <section
            class="relative flex min-h-screen items-center overflow-hidden"
            style="background-color: var(--color-forest-900)"
        >
            <!-- BG image -->
            <div v-if="hero?.image" class="absolute inset-0">
                <img
                    :src="thumbnailUrl(hero.image)"
                    alt=""
                    class="h-full w-full object-cover"
                    style="
                        opacity: 0.32;
                        transform: scale(1.04);
                        transition: transform 8s ease;
                    "
                />
            </div>
            <!-- Overlay — tipis saja -->
            <div
                class="absolute inset-0"
                style="
                    background: linear-gradient(
                        160deg,
                        rgba(12, 35, 12, 0.62) 0%,
                        rgba(12, 35, 12, 0.38) 100%
                    );
                "
            />

            <!-- Decorative circle -->
            <div
                class="absolute -top-32 -right-32 h-96 w-96 rounded-full opacity-10"
                style="
                    background: radial-gradient(
                        circle,
                        var(--color-sage-400),
                        transparent 70%
                    );
                "
            />
            <div
                class="absolute bottom-0 -left-24 h-80 w-80 rounded-full opacity-5"
                style="
                    background: radial-gradient(
                        circle,
                        var(--color-mint-400),
                        transparent 70%
                    );
                "
            />

            <!-- Content -->
            <div
                class="relative mx-auto w-full max-w-6xl px-5 py-32 sm:px-10 sm:py-40"
            >
                <div class="max-w-2xl">
                    <p
                        class="animate-fade-up mb-6 text-xs font-semibold tracking-[0.22em] uppercase sm:text-sm"
                        style="
                            color: var(--color-sage-300);
                            animation-delay: 0.05s;
                        "
                    >
                        {{ hero?.subheading ?? 'Karya Pribadi' }}
                    </p>
                    <h1
                        class="animate-fade-up mb-6 leading-tight font-semibold"
                        style="
                            font-family: var(--font-serif);
                            color: white;
                            font-size: clamp(2.4rem, 6vw, 4rem);
                            line-height: 1.1;
                            animation-delay: 0.15s;
                        "
                    >
                        {{ hero?.heading ?? 'Setiap Kata adalah Jejak Rasa' }}
                    </h1>
                    <p
                        class="animate-fade-up mb-10 max-w-lg"
                        style="
                            color: rgba(255, 255, 255, 0.6);
                            line-height: 1.8;
                            font-size: 1.05rem;
                            animation-delay: 0.25s;
                        "
                    >
                        {{
                            hero?.body ??
                            'Kumpulan puisi, pantun, dan cerita yang lahir dari ruang paling sunyi.'
                        }}
                    </p>
                    <div
                        class="animate-fade-up flex flex-wrap gap-3"
                        style="animation-delay: 0.35s"
                    >
                        <Link
                            :href="hero?.cta_url ?? '/koleksi'"
                            class="inline-flex items-center gap-2.5 rounded-full px-7 py-3.5 text-sm font-semibold transition-all duration-200 hover:scale-105 active:scale-95"
                            style="
                                background-color: var(--color-sage-400);
                                color: white;
                                box-shadow: 0 4px 20px rgba(82, 160, 82, 0.35);
                            "
                        >
                            {{ hero?.cta_label ?? 'Jelajahi Karya' }}
                            <svg
                                class="h-4 w-4"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M17 8l4 4m0 0l-4 4m4-4H3"
                                />
                            </svg>
                        </Link>
                        <Link
                            href="/penulis"
                            class="inline-flex items-center rounded-full px-7 py-3.5 text-sm font-semibold transition-all duration-200 hover:bg-white/15"
                            style="
                                border: 1.5px solid rgba(255, 255, 255, 0.22);
                                color: rgba(255, 255, 255, 0.82);
                            "
                        >
                            Tentang Penulis
                        </Link>
                    </div>
                </div>
            </div>

            <!-- Scroll cue -->
            <div
                class="animate-fade-in absolute bottom-10 left-1/2 flex -translate-x-1/2 flex-col items-center gap-2"
                style="animation-delay: 0.6s"
            >
                <span
                    class="text-xs tracking-[0.2em] uppercase"
                    style="color: rgba(255, 255, 255, 0.3)"
                    >scroll</span
                >
                <div
                    class="h-10 w-px"
                    style="
                        background: linear-gradient(
                            to bottom,
                            rgba(255, 255, 255, 0.25),
                            transparent
                        );
                    "
                />
            </div>
        </section>

        <!-- ── Latest Writings ──────────────────────────────── -->
        <section class="mx-auto max-w-6xl px-5 py-20 sm:px-10 sm:py-28">
            <div
                class="reveal mb-12 flex flex-col justify-between gap-4 sm:flex-row sm:items-end"
            >
                <div>
                    <p
                        class="mb-2 text-xs font-semibold tracking-[0.18em] uppercase"
                        style="color: var(--color-sage-500)"
                    >
                        Terbaru
                    </p>
                    <h2
                        style="
                            font-family: var(--font-serif);
                            color: var(--color-ink-900);
                            font-size: clamp(1.6rem, 3vw, 2.2rem);
                            font-weight: 600;
                        "
                    >
                        Tulisan Terkini
                    </h2>
                </div>
                <Link
                    href="/koleksi"
                    class="inline-flex items-center gap-1.5 self-start text-sm font-medium transition-all duration-200 hover:gap-3 sm:self-auto"
                    style="color: var(--color-sage-600)"
                >
                    Semua tulisan
                    <svg
                        class="h-4 w-4"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M17 8l4 4m0 0l-4 4m4-4H3"
                        />
                    </svg>
                </Link>
            </div>

            <div
                v-if="latestWritings.length > 0"
                class="grid grid-cols-1 gap-4 lg:grid-cols-5 lg:gap-5"
            >
                <!-- Featured card -->
                <Link
                    :href="`/koleksi/${latestWritings[0].collection?.slug}/${latestWritings[0].slug}`"
                    class="reveal group relative flex-shrink-0 overflow-hidden rounded-2xl lg:col-span-3"
                    style="min-height: 380px; animation-delay: 0.05s"
                >
                    <div class="absolute inset-0">
                        <img
                            v-if="latestWritings[0].thumbnail"
                            :src="thumbnailUrl(latestWritings[0].thumbnail)"
                            :alt="latestWritings[0].title"
                            class="h-full w-full object-cover transition-transform duration-700 group-hover:scale-105"
                        />
                        <div
                            v-else
                            class="h-full w-full"
                            style="
                                background: linear-gradient(
                                    145deg,
                                    var(--color-sage-700),
                                    var(--color-forest-800)
                                );
                            "
                        />
                    </div>
                    <div
                        class="absolute inset-0"
                        style="
                            background: linear-gradient(
                                to top,
                                rgba(10, 28, 10, 0.92) 0%,
                                rgba(10, 28, 10, 0.2) 55%,
                                transparent 100%
                            );
                        "
                    />
                    <div class="absolute right-0 bottom-0 left-0 p-6 sm:p-8">
                        <span
                            class="mb-3 inline-block rounded-full px-3 py-1 text-xs font-medium capitalize"
                            style="
                                background-color: var(--color-sage-400);
                                color: white;
                            "
                        >
                            {{ latestWritings[0].type }}
                        </span>
                        <h3
                            class="mb-2 text-xl font-semibold sm:text-2xl"
                            style="
                                font-family: var(--font-serif);
                                color: white;
                                line-height: 1.2;
                            "
                        >
                            {{ latestWritings[0].title }}
                        </h3>
                        <p
                            v-if="latestWritings[0].excerpt"
                            class="mb-2 line-clamp-2 text-sm"
                            style="color: rgba(255, 255, 255, 0.55)"
                        >
                            {{ latestWritings[0].excerpt }}
                        </p>
                        <p
                            class="text-xs"
                            style="color: rgba(255, 255, 255, 0.35)"
                        >
                            {{ latestWritings[0].collection?.title }}
                        </p>
                    </div>
                </Link>

                <!-- Side list -->
                <div class="flex flex-col gap-3 lg:col-span-2">
                    <Link
                        v-for="(w, i) in latestWritings.slice(1, 5)"
                        :key="w.id"
                        :href="`/koleksi/${w.collection?.slug}/${w.slug}`"
                        class="reveal group card-hover flex items-center gap-3.5 rounded-2xl p-3.5"
                        style="
                            background-color: white;
                            border: 1px solid var(--color-cream-200);
                        "
                        :style="`animation-delay: ${0.08 * (i + 1)}s`"
                    >
                        <div
                            class="h-16 w-16 flex-shrink-0 overflow-hidden rounded-xl"
                        >
                            <img
                                v-if="w.thumbnail"
                                :src="thumbnailUrl(w.thumbnail)"
                                :alt="w.title"
                                class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-110"
                            />
                            <div
                                v-else
                                class="flex h-full w-full items-center justify-center"
                                style="
                                    background: linear-gradient(
                                        135deg,
                                        var(--color-sage-100),
                                        var(--color-mint-100)
                                    );
                                "
                            >
                                <span
                                    style="
                                        color: var(--color-sage-300);
                                        font-size: 1.1rem;
                                    "
                                    >✦</span
                                >
                            </div>
                        </div>
                        <div class="min-w-0 flex-1">
                            <span
                                class="text-xs font-medium capitalize"
                                style="color: var(--color-sage-500)"
                                >{{ w.type }}</span
                            >
                            <h3
                                class="mt-0.5 mb-1 text-sm leading-snug font-semibold transition-colors group-hover:text-[--color-sage-600]"
                                style="
                                    font-family: var(--font-serif);
                                    color: var(--color-ink-800);
                                "
                            >
                                {{ w.title }}
                            </h3>
                            <p
                                class="truncate text-xs"
                                style="color: var(--color-stone-400)"
                            >
                                {{ w.collection?.title }}
                            </p>
                        </div>
                        <svg
                            class="h-4 w-4 flex-shrink-0 transition-transform duration-200 group-hover:translate-x-1"
                            style="color: var(--color-sage-300)"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M9 5l7 7-7 7"
                            />
                        </svg>
                    </Link>
                </div>
            </div>

            <!-- Empty -->
            <div v-else class="py-20 text-center">
                <p style="color: var(--color-ink-300); font-size: 2rem">✦</p>
                <p class="mt-3 text-sm" style="color: var(--color-ink-400)">
                    Belum ada tulisan.
                </p>
            </div>
        </section>

        <!-- ── Collections ──────────────────────────────────── -->
        <section
            class="py-20 sm:py-28"
            style="background-color: var(--color-sage-50)"
        >
            <div class="mx-auto max-w-6xl px-5 sm:px-10">
                <div
                    class="reveal mb-12 flex flex-col justify-between gap-4 sm:flex-row sm:items-end"
                >
                    <div>
                        <p
                            class="mb-2 text-xs font-semibold tracking-[0.18em] uppercase"
                            style="color: var(--color-sage-500)"
                        >
                            Koleksi
                        </p>
                        <h2
                            style="
                                font-family: var(--font-serif);
                                color: var(--color-ink-900);
                                font-size: clamp(1.6rem, 3vw, 2.2rem);
                                font-weight: 600;
                            "
                        >
                            Jelajahi Koleksi
                        </h2>
                    </div>
                    <Link
                        href="/koleksi"
                        class="inline-flex items-center gap-1.5 self-start text-sm font-medium transition-all hover:gap-3 sm:self-auto"
                        style="color: var(--color-sage-600)"
                    >
                        Semua koleksi
                        <svg
                            class="h-4 w-4"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M17 8l4 4m0 0l-4 4m4-4H3"
                            />
                        </svg>
                    </Link>
                </div>

                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <Link
                        v-for="(col, i) in latestCollections"
                        :key="col.id"
                        :href="`/koleksi/${col.slug}`"
                        class="reveal group card-hover flex items-center gap-4 rounded-2xl p-4 sm:p-5"
                        style="
                            background-color: white;
                            border: 1px solid var(--color-cream-200);
                        "
                        :style="`animation-delay: ${i * 0.07}s`"
                    >
                        <div
                            class="h-14 w-14 flex-shrink-0 overflow-hidden rounded-xl sm:h-16 sm:w-16"
                        >
                            <img
                                v-if="col.thumbnail"
                                :src="thumbnailUrl(col.thumbnail)"
                                :alt="col.title"
                                class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-110"
                            />
                            <div
                                v-else
                                class="flex h-full w-full items-center justify-center"
                                style="
                                    background: linear-gradient(
                                        135deg,
                                        var(--color-sage-200),
                                        var(--color-mint-200)
                                    );
                                "
                            >
                                <svg
                                    class="h-5 w-5"
                                    style="color: var(--color-sage-500)"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="1.5"
                                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"
                                    />
                                </svg>
                            </div>
                        </div>
                        <div class="min-w-0 flex-1">
                            <h3
                                class="mb-1 text-sm font-semibold transition-colors group-hover:text-[--color-sage-600] sm:text-base"
                                style="
                                    font-family: var(--font-serif);
                                    color: var(--color-ink-800);
                                "
                            >
                                {{ col.title }}
                            </h3>
                            <p
                                v-if="col.description"
                                class="mb-1.5 line-clamp-1 text-xs"
                                style="color: var(--color-ink-400)"
                            >
                                {{ col.description }}
                            </p>
                            <span
                                class="text-xs font-medium"
                                style="color: var(--color-sage-500)"
                            >
                                {{
                                    col.published_writings_count ??
                                    col.writings_count ??
                                    0
                                }}
                                tulisan
                            </span>
                        </div>
                        <svg
                            class="h-4 w-4 flex-shrink-0 transition-transform duration-200 group-hover:translate-x-1"
                            style="color: var(--color-sage-300)"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M9 5l7 7-7 7"
                            />
                        </svg>
                    </Link>
                </div>
            </div>
        </section>

        <!-- ── Author teaser ────────────────────────────────── -->
        <section
            v-if="author"
            class="mx-auto max-w-6xl px-5 py-20 sm:px-10 sm:py-28"
        >
            <div
                class="reveal grid grid-cols-1 overflow-hidden rounded-3xl sm:grid-cols-5"
                style="
                    background-color: white;
                    border: 1px solid var(--color-cream-200);
                "
            >
                <!-- Photo side -->
                <div
                    class="relative flex items-center justify-center px-6 py-12 sm:col-span-2"
                    style="
                        background: linear-gradient(
                            160deg,
                            var(--color-sage-50) 0%,
                            var(--color-mint-50) 100%
                        );
                    "
                >
                    <div
                        class="h-28 w-28 overflow-hidden rounded-full sm:h-32 sm:w-32"
                        style="
                            border: 4px solid white;
                            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
                        "
                    >
                        <img
                            v-if="author.photo"
                            :src="thumbnailUrl(author.photo)"
                            :alt="author.name"
                            class="h-full w-full object-cover"
                        />
                        <div
                            v-else
                            class="flex h-full w-full items-center justify-center"
                            style="
                                background: linear-gradient(
                                    135deg,
                                    var(--color-sage-300),
                                    var(--color-forest-500)
                                );
                            "
                        >
                            <span
                                style="
                                    font-family: var(--font-serif);
                                    font-size: 2.5rem;
                                    color: white;
                                    font-weight: 600;
                                "
                                >{{ author.name.charAt(0) }}</span
                            >
                        </div>
                    </div>
                </div>
                <!-- Text side -->
                <div
                    class="flex flex-col justify-center p-8 sm:col-span-3 sm:p-12"
                >
                    <p
                        class="mb-3 text-xs font-semibold tracking-[0.18em] uppercase"
                        style="color: var(--color-sage-500)"
                    >
                        Penulis
                    </p>
                    <h3
                        class="mb-2 font-semibold"
                        style="
                            font-family: var(--font-serif);
                            color: var(--color-ink-900);
                            font-size: clamp(1.4rem, 3vw, 1.8rem);
                        "
                    >
                        {{ author.name }}
                    </h3>
                    <p
                        v-if="author.tagline"
                        class="mb-7 text-sm italic"
                        style="
                            color: var(--color-sage-600);
                            font-family: var(--font-serif);
                        "
                    >
                        {{ author.tagline }}
                    </p>
                    <Link
                        href="/penulis"
                        class="inline-flex w-fit items-center gap-2 text-sm font-medium transition-all duration-200 hover:gap-3"
                        style="color: var(--color-forest-700)"
                    >
                        Baca lebih lanjut
                        <svg
                            class="h-4 w-4"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M17 8l4 4m0 0l-4 4m4-4H3"
                            />
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
    transition:
        opacity 0.55s ease,
        transform 0.55s ease;
}
.reveal.revealed {
    opacity: 1;
    transform: translateY(0);
}
</style>
