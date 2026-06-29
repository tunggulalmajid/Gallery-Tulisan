<script setup lang="ts">
import { Link, usePage } from '@inertiajs/vue3';
import { computed, onMounted, onUnmounted, ref } from 'vue';
import type { PageProps } from '@/types';

const page = usePage<PageProps>();
const auth = computed(() => page.props.auth);
const mobileOpen = ref(false);
const scrolled = ref(false);
const isHeroPage = ref(false);

const navLinks = [
    { label: 'Beranda', href: '/' },
    { label: 'Koleksi', href: '/koleksi' },
    { label: 'Penulis', href: '/penulis' },
];

function isActive(href: string): boolean {
    if (href === '/') {
        return page.url === '/';
    }

    return page.url.startsWith(href);
}

function onScroll() {
    scrolled.value = window.scrollY > 80;
}

onMounted(() => {
    isHeroPage.value = page.url === '/';
    window.addEventListener('scroll', onScroll, { passive: true });
    onScroll();
});

onUnmounted(() => {
    window.removeEventListener('scroll', onScroll);
});

// Semua style digabung ke satu computed — ini penting agar tidak ada konflik dual style attribute
const headerStyle = computed((): Record<string, string> => {
    const scrolledStyle: Record<string, string> = {
        'background-color': 'rgba(253,252,248,0.97)',
        'border-bottom': '1px solid var(--color-cream-200)',
        'box-shadow': '0 2px 20px rgba(0,0,0,0.07)',
        'backdrop-filter': 'blur(18px)',
        '-webkit-backdrop-filter': 'blur(18px)',
        transition:
            'background-color 0.35s ease, border-color 0.35s ease, box-shadow 0.35s ease',
    };

    const solidStyle: Record<string, string> = {
        'background-color': 'rgba(253,252,248,0.97)',
        'border-bottom': '1px solid var(--color-cream-200)',
        'box-shadow': 'none',
        'backdrop-filter': 'blur(18px)',
        '-webkit-backdrop-filter': 'blur(18px)',
        transition:
            'background-color 0.35s ease, border-color 0.35s ease, box-shadow 0.35s ease',
    };

    const transparentStyle: Record<string, string> = {
        'background-color': 'transparent',
        'border-bottom': 'none',
        'box-shadow': 'none',
        'backdrop-filter': 'none',
        '-webkit-backdrop-filter': 'none',
        transition:
            'background-color 0.35s ease, border-color 0.35s ease, box-shadow 0.35s ease',
    };

    if (!isHeroPage.value) {
        return solidStyle;
    }

    if (scrolled.value) {
        return scrolledStyle;
    }

    return transparentStyle;
});

const onHeroTransparent = computed(() => isHeroPage.value && !scrolled.value);

const logoColor = computed(() =>
    onHeroTransparent.value ? 'color: white' : 'color: var(--color-forest-800)',
);

const linkBaseStyle = computed(() =>
    onHeroTransparent.value
        ? 'color: rgba(255,255,255,0.82)'
        : 'color: var(--color-ink-600)',
);

const activeLinkStyle = computed(() =>
    onHeroTransparent.value
        ? 'background-color: rgba(255,255,255,0.12); color: white'
        : 'background-color: var(--color-sage-50); color: var(--color-sage-700)',
);
</script>

<template>
    <div
        class="flex min-h-screen flex-col"
        style="background-color: var(--color-cream-50)"
    >
        <!-- ── Navbar ─────────────────────────────────────────── -->
        <header class="fixed top-0 right-0 left-0 z-50" :style="headerStyle">
            <div class="mx-auto max-w-6xl px-5 sm:px-10">
                <div class="flex h-20 items-center justify-between">
                    <!-- Logo -->
                    <Link
                        href="/"
                        class="group flex flex-shrink-0 items-center gap-3"
                    >
                        <img
                            src="/assets/logo.png"
                            alt="Gayatri's"
                            class="h-9 w-9 flex-shrink-0 rounded-full object-contain transition-transform group-hover:scale-105"
                        />
                        <span
                            class="text-base font-semibold tracking-wide transition-colors"
                            :style="logoColor"
                            style="font-family: var(--font-serif)"
                        >
                            Gayatri's
                        </span>
                    </Link>

                    <!-- Desktop Nav -->
                    <nav class="hidden items-center gap-1 md:flex">
                        <Link
                            v-for="link in navLinks"
                            :key="link.href"
                            :href="link.href"
                            class="rounded-xl px-5 py-2.5 text-sm font-medium tracking-wide transition-all duration-200"
                            :style="
                                isActive(link.href)
                                    ? activeLinkStyle
                                    : linkBaseStyle
                            "
                        >
                            {{ link.label }}
                        </Link>
                        <Link
                            v-if="auth.user"
                            href="/admin"
                            class="ml-3 rounded-xl px-4 py-2 text-xs font-semibold tracking-wide transition-all hover:opacity-85"
                            style="
                                background-color: var(--color-forest-800);
                                color: white;
                            "
                        >
                            Admin ↗
                        </Link>
                    </nav>

                    <!-- Mobile menu button -->
                    <button
                        class="flex h-10 w-10 items-center justify-center rounded-xl transition-colors md:hidden"
                        :style="
                            onHeroTransparent
                                ? 'color: white'
                                : 'color: var(--color-ink-700)'
                        "
                        aria-label="Toggle menu"
                        @click="mobileOpen = !mobileOpen"
                    >
                        <svg
                            v-if="!mobileOpen"
                            class="h-5 w-5"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16"
                            />
                        </svg>
                        <svg
                            v-else
                            class="h-5 w-5"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"
                            />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Mobile dropdown -->
            <Transition
                enter-active-class="transition-all duration-200 ease-out"
                enter-from-class="opacity-0 -translate-y-2"
                enter-to-class="opacity-100 translate-y-0"
                leave-active-class="transition-all duration-150 ease-in"
                leave-from-class="opacity-100 translate-y-0"
                leave-to-class="opacity-0 -translate-y-2"
            >
                <div
                    v-if="mobileOpen"
                    class="flex flex-col gap-1 px-5 pt-2 pb-4 md:hidden"
                    style="
                        background-color: rgba(253, 252, 248, 0.98);
                        border-top: 1px solid var(--color-cream-200);
                        backdrop-filter: blur(18px);
                    "
                >
                    <Link
                        v-for="link in navLinks"
                        :key="link.href"
                        :href="link.href"
                        class="rounded-xl px-4 py-3 text-sm font-medium transition-all"
                        :style="
                            isActive(link.href)
                                ? 'color: var(--color-sage-700); background-color: var(--color-sage-50)'
                                : 'color: var(--color-ink-700)'
                        "
                        @click="mobileOpen = false"
                    >
                        {{ link.label }}
                    </Link>
                    <Link
                        v-if="auth.user"
                        href="/admin"
                        class="mt-1 rounded-xl px-4 py-3 text-sm font-medium"
                        style="color: var(--color-forest-700)"
                        @click="mobileOpen = false"
                    >
                        Admin Panel ↗
                    </Link>
                </div>
            </Transition>
        </header>

        <!-- Spacer hanya untuk halaman non-hero -->
        <div v-if="!isHeroPage" class="h-20" />

        <!-- ── Main ───────────────────────────────────────────── -->
        <main class="flex-1">
            <slot />
        </main>

        <!-- ── Footer ─────────────────────────────────────────── -->
        <footer style="background-color: var(--color-forest-900)">
            <div class="mx-auto max-w-6xl px-5 py-16 sm:px-10">
                <div class="mb-12 grid grid-cols-1 gap-10 sm:grid-cols-3">
                    <!-- Brand -->
                    <div>
                        <div class="mb-4 flex items-center gap-3">
                            <img
                                src="/assets/logo.png"
                                alt="Gayatri's"
                                class="h-8 w-8 flex-shrink-0 rounded-full object-contain"
                            />
                            <span
                                style="
                                    font-family: var(--font-serif);
                                    font-size: 1rem;
                                    font-weight: 600;
                                    color: var(--color-cream-100);
                                "
                                >Gayatri's</span
                            >
                        </div>
                        <p
                            class="text-sm leading-relaxed"
                            style="
                                color: rgba(255, 255, 255, 0.38);
                                line-height: 1.75;
                                max-width: 220px;
                            "
                        >
                            Karya pribadi yang lahir dari ruang paling sunyi —
                            tempat kata-kata tumbuh menjadi perasaan.
                        </p>
                    </div>

                    <!-- Nav -->
                    <div>
                        <p
                            class="mb-5 text-xs font-semibold tracking-[0.18em] uppercase"
                            style="color: var(--color-sage-400)"
                        >
                            Navigasi
                        </p>
                        <div class="flex flex-col gap-3">
                            <Link
                                v-for="link in navLinks"
                                :key="link.href"
                                :href="link.href"
                                class="w-fit text-sm transition-colors"
                                style="color: rgba(255, 255, 255, 0.45)"
                                onmouseover="
                                    this.style.color = 'var(--color-sage-300)'
                                "
                                onmouseout="
                                    this.style.color = 'rgba(255,255,255,0.45)'
                                "
                            >
                                {{ link.label }}
                            </Link>
                        </div>
                    </div>

                    <!-- Quote -->
                    <div>
                        <p
                            class="mb-5 text-xs font-semibold tracking-[0.18em] uppercase"
                            style="color: var(--color-sage-400)"
                        >
                            Karya
                        </p>
                        <p
                            class="text-sm leading-relaxed italic"
                            style="
                                color: rgba(255, 255, 255, 0.35);
                                font-family: var(--font-serif);
                                line-height: 1.8;
                            "
                        >
                            "Setiap tulisan adalah potongan waktu yang
                            diabadikan dalam kata."
                        </p>
                    </div>
                </div>

                <!-- Divider + copyright -->
                <div
                    class="flex flex-col items-center justify-between gap-3 pt-8 sm:flex-row"
                    style="border-top: 1px solid rgba(255, 255, 255, 0.06)"
                >
                    <p class="text-xs" style="color: rgba(255, 255, 255, 0.2)">
                        &copy; {{ new Date().getFullYear() }} Gayatri's. Seluruh
                        hak cipta dilindungi.
                    </p>
                    <p class="text-xs" style="color: rgba(255, 255, 255, 0.15)">
                        Dibuat dengan rasa.
                    </p>
                </div>
            </div>
        </footer>
    </div>
</template>
