<script setup lang="ts">
import { Link, router, usePage } from '@inertiajs/vue3';
import { computed, ref } from 'vue';
import type { PageProps } from '@/types';

const page = usePage<PageProps>();
const auth = computed(() => page.props.auth);
const mobileSidebarOpen = ref(false);

const navItems = [
    {
        label: 'Dashboard',
        href: '/admin',
        icon: `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>`,
    },
    {
        label: 'Hero',
        href: '/admin/hero',
        icon: `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>`,
    },
    {
        label: 'Koleksi',
        href: '/admin/collections',
        icon: `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>`,
    },
    {
        label: 'Tulisan',
        href: '/admin/writings',
        icon: `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>`,
    },
    {
        label: 'Profil Penulis',
        href: '/admin/profile',
        icon: `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>`,
    },
];

function isActive(href: string): boolean {
    if (href === '/admin') return page.url === '/admin';
    return page.url.startsWith(href);
}

function logout() {
    router.post('/logout');
}

function closeMobile() {
    mobileSidebarOpen.value = false;
}
</script>

<template>
    <div class="min-h-screen flex" style="background-color: var(--color-cream-50)">

        <!-- ── Mobile overlay ───────────────────────────────── -->
        <Transition
            enter-active-class="transition-opacity duration-200"
            enter-from-class="opacity-0"
            enter-to-class="opacity-100"
            leave-active-class="transition-opacity duration-200"
            leave-from-class="opacity-100"
            leave-to-class="opacity-0"
        >
            <div
                v-if="mobileSidebarOpen"
                class="fixed inset-0 z-40 lg:hidden"
                style="background-color: rgba(0,0,0,0.45)"
                @click="closeMobile"
            />
        </Transition>

        <!-- ── Sidebar ──────────────────────────────────────── -->
        <!-- mobile: fixed drawer | desktop: sticky kolom kiri (tidak ikut scroll) -->
        <aside
            class="fixed top-0 left-0 z-50 flex flex-col transition-transform duration-300
                   lg:sticky lg:top-0 lg:translate-x-0 lg:z-auto lg:h-screen lg:flex-shrink-0"
            :class="mobileSidebarOpen ? 'translate-x-0 h-full' : '-translate-x-full h-full'"
            style="width: 260px; background-color: var(--color-forest-900);"
        >
            <!-- Brand -->
            <div class="flex items-center gap-3 px-6 h-20 flex-shrink-0" style="border-bottom: 1px solid rgba(255,255,255,0.07)">
                <!-- Logo dari public/assets -->
                <img src="/assets/logo.png" alt="Gayatri's" class="w-9 h-9 rounded-xl object-contain flex-shrink-0" />
                <div class="flex flex-col min-w-0">
                    <span style="font-family: var(--font-serif); font-size: 1rem; font-weight: 700; color: var(--color-cream-100); letter-spacing: 0.01em">Gayatri's</span>
                    <span style="font-size: 0.65rem; color: rgba(255,255,255,0.35); letter-spacing: 0.06em; text-transform: uppercase">Admin Panel</span>
                </div>
                <!-- Close button mobile -->
                <button
                    class="ml-auto lg:hidden flex items-center justify-center w-8 h-8 rounded-lg transition-colors hover:bg-white/10"
                    style="color: rgba(255,255,255,0.5)"
                    @click="closeMobile"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <!-- Nav items -->
            <nav class="flex-1 overflow-y-auto py-5 px-3 space-y-0.5">
                <Link
                    v-for="item in navItems"
                    :key="item.href"
                    :href="item.href"
                    class="flex items-center gap-3.5 px-4 py-3.5 rounded-xl text-sm font-medium transition-all duration-150"
                    :style="isActive(item.href)
                        ? 'background-color: var(--color-sage-500); color: white; box-shadow: 0 2px 12px rgba(82,160,82,0.25)'
                        : 'color: rgba(255,255,255,0.5)'"
                    @click="closeMobile"
                >
                    <span
                        v-html="item.icon"
                        class="flex-shrink-0"
                        :style="isActive(item.href) ? 'color:white' : 'color:rgba(255,255,255,0.4)'"
                    />
                    {{ item.label }}
                </Link>
            </nav>

            <!-- User info + logout -->
            <div class="flex-shrink-0 px-3 pb-5 pt-3" style="border-top: 1px solid rgba(255,255,255,0.07)">
                <div class="flex items-center gap-3 px-4 py-3 mb-1 rounded-xl" style="background-color: rgba(255,255,255,0.06)">
                    <div class="w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0" style="background-color: var(--color-sage-600)">
                        <span style="color:white; font-size:0.7rem; font-weight:700">{{ auth.user?.name?.charAt(0) ?? 'A' }}</span>
                    </div>
                    <span class="text-sm truncate flex-1" style="color: rgba(255,255,255,0.65)">{{ auth.user?.name ?? 'Admin' }}</span>
                </div>
                <button
                    class="w-full flex items-center gap-3.5 px-4 py-3 rounded-xl text-sm transition-all hover:bg-white/5"
                    style="color: rgba(255,255,255,0.38)"
                    @click="logout"
                >
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                    Keluar
                </button>
            </div>
        </aside>

        <!-- ── Main content ─────────────────────────────────── -->
        <div class="flex-1 flex flex-col min-w-0">

            <!-- Top bar -->
            <header
                class="h-16 flex items-center justify-between px-4 sm:px-6 flex-shrink-0 sticky top-0 z-30"
                style="background-color: rgba(253,252,248,0.96); border-bottom: 1px solid var(--color-cream-200); backdrop-filter: blur(12px)"
            >
                <div class="flex items-center gap-3">
                    <!-- Mobile hamburger -->
                    <button
                        class="lg:hidden flex items-center justify-center w-9 h-9 rounded-xl transition-colors hover:bg-cream-100"
                        style="color: var(--color-ink-700)"
                        @click="mobileSidebarOpen = true"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                    <slot name="header"/>
                </div>

                <div class="flex items-center gap-2">
                    <Link
                        href="/"
                        target="_blank"
                        class="hidden sm:inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-lg text-xs font-medium transition-all hover:opacity-80"
                        style="background-color: var(--color-cream-100); color: var(--color-ink-600); border: 1px solid var(--color-cream-200)"
                    >
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                        </svg>
                        Lihat Site
                    </Link>
                    <Link
                        href="/admin/writings/create"
                        class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-lg text-xs font-semibold transition-all hover:opacity-90"
                        style="background-color: var(--color-forest-800); color: white"
                    >
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        <span class="hidden sm:inline">Tulisan Baru</span>
                        <span class="sm:hidden">Baru</span>
                    </Link>
                </div>
            </header>

            <!-- Flash messages -->
            <Transition
                enter-active-class="transition-all duration-300 ease-out"
                enter-from-class="opacity-0 -translate-y-2"
                enter-to-class="opacity-100 translate-y-0"
            >
                <div
                    v-if="$page.props.flash?.success"
                    class="mx-4 sm:mx-6 mt-4 px-4 py-3 rounded-xl text-sm flex items-center gap-2"
                    style="background-color: #f0fdf4; color: #15803d; border: 1px solid #bbf7d0"
                >
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    {{ $page.props.flash.success }}
                </div>
            </Transition>
            <div
                v-if="$page.props.flash?.error"
                class="mx-4 sm:mx-6 mt-4 px-4 py-3 rounded-xl text-sm"
                style="background-color: #fef2f2; color: #dc2626; border: 1px solid #fecaca"
            >
                {{ $page.props.flash.error }}
            </div>

            <!-- Page content -->
            <main class="flex-1 p-4 sm:p-6 lg:p-8 min-w-0">
                <slot/>
            </main>
        </div>
    </div>
</template>
