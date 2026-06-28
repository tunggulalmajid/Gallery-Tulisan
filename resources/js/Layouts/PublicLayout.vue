<script setup lang="ts">
import { Link, usePage } from '@inertiajs/vue3';
import { computed, ref } from 'vue';
import type { PageProps } from '@/types';

const page = usePage<PageProps>();
const auth = computed(() => page.props.auth);
const mobileOpen = ref(false);

const navLinks = [
    { label: 'Beranda', href: '/', name: 'home' },
    { label: 'Koleksi', href: '/koleksi', name: 'collections.index' },
    { label: 'Penulis', href: '/penulis', name: 'author' },
];
</script>

<template>
    <div class="min-h-screen flex flex-col" style="background-color: var(--color-cream-50)">
        <!-- Navbar -->
        <header class="sticky top-0 z-50 border-b" style="background-color: rgba(253,252,250,0.95); border-color: var(--color-cream-300); backdrop-filter: blur(8px)">
            <div class="max-w-5xl mx-auto px-4 sm:px-6">
                <div class="flex items-center justify-between h-16">
                    <!-- Logo -->
                    <Link href="/" class="flex items-center gap-2">
                        <span class="text-xl" style="font-family: var(--font-serif); color: var(--color-blush-700); font-weight: 600; letter-spacing: 0.01em;">
                            Suci Puisi
                        </span>
                    </Link>

                    <!-- Desktop Nav -->
                    <nav class="hidden sm:flex items-center gap-8">
                        <Link
                            v-for="link in navLinks"
                            :key="link.name"
                            :href="link.href"
                            class="text-sm font-medium transition-colors duration-200"
                            :style="$page.url === link.href
                                ? 'color: var(--color-blush-600); border-bottom: 2px solid var(--color-blush-400); padding-bottom: 2px;'
                                : 'color: var(--color-ink-600);'"
                        >
                            {{ link.label }}
                        </Link>
                        <Link
                            v-if="auth.user"
                            href="/admin"
                            class="text-xs px-3 py-1.5 rounded-full transition-colors"
                            style="background-color: var(--color-blush-100); color: var(--color-blush-700); border: 1px solid var(--color-blush-200);"
                        >
                            Admin
                        </Link>
                    </nav>

                    <!-- Mobile menu button -->
                    <button
                        class="sm:hidden p-2 rounded-lg"
                        style="color: var(--color-ink-600)"
                        @click="mobileOpen = !mobileOpen"
                        aria-label="Toggle menu"
                    >
                        <svg v-if="!mobileOpen" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                        <svg v-else class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Mobile Nav -->
            <div v-if="mobileOpen" class="sm:hidden border-t" style="background-color: var(--color-cream-50); border-color: var(--color-cream-200)">
                <div class="px-4 py-3 flex flex-col gap-1">
                    <Link
                        v-for="link in navLinks"
                        :key="link.name"
                        :href="link.href"
                        class="py-2.5 px-3 rounded-lg text-sm font-medium transition-colors"
                        :style="$page.url === link.href
                            ? 'background-color: var(--color-blush-50); color: var(--color-blush-700);'
                            : 'color: var(--color-ink-700);'"
                        @click="mobileOpen = false"
                    >
                        {{ link.label }}
                    </Link>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="flex-1">
            <slot />
        </main>

        <!-- Footer -->
        <footer class="border-t mt-16" style="border-color: var(--color-cream-200); background-color: var(--color-cream-100)">
            <div class="max-w-5xl mx-auto px-4 sm:px-6 py-10">
                <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                    <span style="font-family: var(--font-serif); color: var(--color-blush-700); font-size: 1.1rem; font-weight: 600;">
                        Suci Puisi
                    </span>
                    <p class="text-sm" style="color: var(--color-ink-400)">
                        Setiap kata adalah jejak rasa.
                    </p>
                    <div class="flex items-center gap-4">
                        <Link href="/" class="text-xs transition-colors" style="color: var(--color-ink-400)">Beranda</Link>
                        <Link href="/koleksi" class="text-xs transition-colors" style="color: var(--color-ink-400)">Koleksi</Link>
                        <Link href="/penulis" class="text-xs transition-colors" style="color: var(--color-ink-400)">Penulis</Link>
                    </div>
                </div>
                <div class="mt-6 pt-6 border-t text-center" style="border-color: var(--color-cream-200)">
                    <p class="text-xs" style="color: var(--color-ink-300)">
                        &copy; {{ new Date().getFullYear() }} Suci Puisi. Karya pribadi.
                    </p>
                </div>
            </div>
        </footer>
    </div>
</template>
