<script setup lang="ts">
import { Link, router } from '@inertiajs/vue3';
import { onMounted, ref, watch } from 'vue';
import PublicLayout from '@/Layouts/PublicLayout.vue';
import type { Collection, PaginatedData } from '@/types';

const props = defineProps<{
    collections: PaginatedData<Collection>;
    search: string;
}>();

const searchQuery = ref(props.search);
let debounce: ReturnType<typeof setTimeout>;
watch(searchQuery, (val) => {
    clearTimeout(debounce);
    debounce = setTimeout(() => {
        router.get(
            '/koleksi',
            { search: val },
            { preserveState: true, replace: true },
        );
    }, 400);
});

function thumbnailUrl(path: string | null): string {
    return path ? `/storage/${path}` : '';
}

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
        { threshold: 0.1 },
    );
    document.querySelectorAll('.reveal').forEach((el) => io.observe(el));
});
</script>

<template>
    <PublicLayout>
        <!-- Page header -->
        <section
            class="py-14 sm:py-20"
            style="
                background-color: white;
                border-bottom: 1px solid var(--color-cream-200);
            "
        >
            <div class="mx-auto max-w-6xl px-5 sm:px-10">
                <p
                    class="mb-3 text-xs font-semibold tracking-[0.18em] uppercase"
                    style="color: var(--color-sage-500)"
                >
                    Jelajahi
                </p>
                <div
                    class="flex flex-col justify-between gap-5 sm:flex-row sm:items-end"
                >
                    <h1
                        style="
                            font-family: var(--font-serif);
                            color: var(--color-ink-900);
                            font-size: clamp(1.8rem, 4vw, 2.6rem);
                            font-weight: 600;
                        "
                    >
                        Semua Koleksi
                    </h1>
                    <!-- Search -->
                    <div class="relative w-full sm:w-72">
                        <svg
                            class="pointer-events-none absolute top-1/2 left-3.5 h-4 w-4 -translate-y-1/2"
                            style="color: var(--color-ink-400)"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z"
                            />
                        </svg>
                        <input
                            v-model="searchQuery"
                            type="text"
                            placeholder="Cari koleksi..."
                            class="w-full rounded-xl py-2.5 pr-4 pl-10 text-sm transition-all outline-none"
                            style="
                                border: 1px solid var(--color-cream-300);
                                background-color: var(--color-cream-50);
                                color: var(--color-ink-800);
                            "
                        />
                    </div>
                </div>
            </div>
        </section>

        <!-- Collections grid -->
        <section class="mx-auto max-w-6xl px-5 py-14 sm:px-10 sm:py-20">
            <!-- Empty state -->
            <div
                v-if="collections.data.length === 0"
                class="flex flex-col items-center justify-center rounded-2xl py-24"
                style="border: 1px dashed var(--color-cream-300)"
            >
                <p class="mb-4 text-3xl" style="color: var(--color-sage-200)">
                    ✦
                </p>
                <p
                    class="mb-1 text-sm font-medium"
                    style="color: var(--color-ink-600)"
                >
                    {{
                        search ? 'Koleksi tidak ditemukan' : 'Belum ada koleksi'
                    }}
                </p>
                <p class="text-xs" style="color: var(--color-ink-400)">
                    {{
                        search
                            ? `Tidak ada hasil untuk "${search}"`
                            : 'Koleksi akan tampil di sini.'
                    }}
                </p>
            </div>

            <div
                v-else
                class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3"
            >
                <Link
                    v-for="(col, i) in collections.data"
                    :key="col.id"
                    :href="`/koleksi/${col.slug}`"
                    class="reveal group card-hover flex flex-col overflow-hidden rounded-2xl"
                    style="
                        background-color: white;
                        border: 1px solid var(--color-cream-200);
                    "
                    :style="`animation-delay: ${i * 0.06}s`"
                >
                    <!-- Thumbnail -->
                    <div
                        class="relative h-44 flex-shrink-0 overflow-hidden"
                        style="
                            background: linear-gradient(
                                135deg,
                                var(--color-sage-100),
                                var(--color-mint-100)
                            );
                        "
                    >
                        <img
                            v-if="col.thumbnail"
                            :src="thumbnailUrl(col.thumbnail)"
                            :alt="col.title"
                            class="h-full w-full object-cover transition-transform duration-600 group-hover:scale-105"
                        />
                        <div
                            v-else
                            class="flex h-full w-full items-center justify-center"
                        >
                            <svg
                                class="h-8 w-8"
                                style="color: var(--color-sage-300)"
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
                    <!-- Body -->
                    <div class="flex flex-1 flex-col p-5">
                        <h3
                            class="mb-2 text-base font-semibold transition-colors group-hover:text-[--color-sage-600]"
                            style="
                                font-family: var(--font-serif);
                                color: var(--color-ink-800);
                            "
                        >
                            {{ col.title }}
                        </h3>
                        <p
                            v-if="col.description"
                            class="mb-4 line-clamp-2 flex-1 text-sm"
                            style="
                                color: var(--color-ink-400);
                                line-height: 1.65;
                            "
                        >
                            {{ col.description }}
                        </p>
                        <div v-else class="flex-1" />
                        <div
                            class="mt-auto flex items-center justify-between pt-3"
                            style="border-top: 1px solid var(--color-cream-100)"
                        >
                            <span
                                class="rounded-full px-2.5 py-1 text-xs font-medium"
                                style="
                                    background-color: var(--color-sage-50);
                                    color: var(--color-sage-600);
                                "
                            >
                                {{
                                    col.published_writings_count ??
                                    col.writings_count ??
                                    0
                                }}
                                tulisan
                            </span>
                            <span
                                class="flex items-center gap-1 text-xs font-medium transition-all duration-200 group-hover:gap-2"
                                style="color: var(--color-sage-500)"
                            >
                                Buka
                                <svg
                                    class="h-3.5 w-3.5"
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
                            </span>
                        </div>
                    </div>
                </Link>
            </div>

            <!-- Pagination -->
            <div
                v-if="collections.last_page > 1"
                class="mt-12 flex items-center justify-center gap-2"
            >
                <Link
                    v-for="link in collections.links"
                    :key="link.label"
                    :href="link.url ?? ''"
                    :class="[
                        'rounded-lg px-3 py-1.5 text-sm transition-all',
                        !link.url ? 'pointer-events-none opacity-30' : '',
                    ]"
                    :style="
                        link.active
                            ? 'background-color: var(--color-forest-800); color: white'
                            : 'border: 1px solid var(--color-cream-200); color: var(--color-ink-600)'
                    "
                    ><span v-html="link.label"
                /></Link>
            </div>
        </section>
    </PublicLayout>
</template>

<style scoped>
.reveal {
    opacity: 0;
    transform: translateY(24px);
    transition:
        opacity 0.5s ease,
        transform 0.5s ease;
}
.reveal.revealed {
    opacity: 1;
    transform: translateY(0);
}
</style>
