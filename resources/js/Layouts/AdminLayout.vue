<script setup lang="ts">
import { Link, router, usePage } from '@inertiajs/vue3';
import { computed, ref } from 'vue';
import type { PageProps } from '@/types';

const page = usePage<PageProps>();
const auth = computed(() => page.props.auth);
const sidebarOpen = ref(true);

const navItems = [
    {
        label: 'Dashboard',
        href: '/admin',
        icon: `<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>`,
    },
    {
        label: 'Koleksi',
        href: '/admin/collections',
        icon: `<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>`,
    },
    {
        label: 'Tulisan',
        href: '/admin/writings',
        icon: `<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>`,
    },
    {
        label: 'Profil Penulis',
        href: '/admin/profile',
        icon: `<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>`,
    },
];

function isActive(href: string): boolean {
    if (href === '/admin') return page.url === '/admin';
    return page.url.startsWith(href);
}

function logout() {
    router.post('/logout');
}
</script>

<template>
    <div class="min-h-screen flex" style="background-color: var(--color-cream-50)">
        <!-- Sidebar -->
        <aside
            class="fixed inset-y-0 left-0 z-40 flex flex-col transition-all duration-300"
            :class="sidebarOpen ? 'w-56' : 'w-16'"
            style="background-color: var(--color-ink-900); border-right: 1px solid var(--color-ink-800)"
        >
            <!-- Logo -->
            <div class="flex items-center gap-3 px-4 h-16 border-b" style="border-color: var(--color-ink-800)">
                <div class="w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0" style="background-color: var(--color-blush-500)">
                    <span style="font-family: var(--font-serif); color: white; font-size: 0.85rem; font-weight: 600">S</span>
                </div>
                <span v-if="sidebarOpen" class="text-sm font-semibold truncate" style="font-family: var(--font-serif); color: var(--color-cream-100)">
                    Suci Puisi
                </span>
            </div>

            <!-- Nav -->
            <nav class="flex-1 px-2 py-4 flex flex-col gap-1">
                <Link
                    v-for="item in navItems"
                    :key="item.href"
                    :href="item.href"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-all duration-150"
                    :style="isActive(item.href)
                        ? 'background-color: var(--color-blush-600); color: white;'
                        : 'color: var(--color-ink-300);'"
                >
                    <span class="flex-shrink-0" v-html="item.icon" />
                    <span v-if="sidebarOpen" class="truncate">{{ item.label }}</span>
                </Link>
            </nav>

            <!-- Footer -->
            <div class="px-2 py-4 border-t" style="border-color: var(--color-ink-800)">
                <Link
                    href="/"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-colors mb-1"
                    style="color: var(--color-ink-400)"
                >
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                    </svg>
                    <span v-if="sidebarOpen">Lihat Website</span>
                </Link>
                <button
                    class="w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-colors"
                    style="color: var(--color-blush-400)"
                    @click="logout"
                >
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                    <span v-if="sidebarOpen">Keluar</span>
                </button>
            </div>

            <!-- Toggle -->
            <button
                class="absolute -right-3 top-20 w-6 h-6 rounded-full flex items-center justify-center shadow-md"
                style="background-color: var(--color-blush-500); color: white"
                @click="sidebarOpen = !sidebarOpen"
                :aria-label="sidebarOpen ? 'Tutup sidebar' : 'Buka sidebar'"
            >
                <svg class="w-3 h-3 transition-transform" :class="sidebarOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </button>
        </aside>

        <!-- Content -->
        <div class="flex-1 flex flex-col min-w-0 transition-all duration-300" :class="sidebarOpen ? 'ml-56' : 'ml-16'">
            <!-- Top bar -->
            <header class="h-16 flex items-center justify-between px-6 border-b" style="background-color: white; border-color: var(--color-cream-200)">
                <div>
                    <slot name="header">
                        <h1 class="text-lg font-semibold" style="font-family: var(--font-serif); color: var(--color-ink-800)">Dashboard</h1>
                    </slot>
                </div>
                <div class="flex items-center gap-3">
                    <span class="text-sm" style="color: var(--color-ink-500)">{{ auth.user?.name }}</span>
                    <div class="w-8 h-8 rounded-full flex items-center justify-center" style="background-color: var(--color-blush-100); color: var(--color-blush-600); font-size: 0.8rem; font-weight: 600">
                        {{ auth.user?.name?.charAt(0)?.toUpperCase() }}
                    </div>
                </div>
            </header>

            <!-- Flash messages -->
            <div v-if="$page.props.flash?.success" class="mx-6 mt-4 px-4 py-3 rounded-lg text-sm" style="background-color: var(--color-blush-50); color: var(--color-blush-700); border: 1px solid var(--color-blush-200)">
                {{ $page.props.flash.success }}
            </div>
            <div v-if="$page.props.flash?.error" class="mx-6 mt-4 px-4 py-3 rounded-lg text-sm" style="background-color: #fef2f2; color: #b91c1c; border: 1px solid #fecaca">
                {{ $page.props.flash.error }}
            </div>

            <main class="flex-1 p-6">
                <slot />
            </main>
        </div>
    </div>
</template>
