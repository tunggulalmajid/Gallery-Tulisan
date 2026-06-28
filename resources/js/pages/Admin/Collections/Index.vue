<script setup lang="ts">
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Link, router } from '@inertiajs/vue3';
import type { Collection } from '@/types';

const props = defineProps<{
    collections: Collection[];
}>();

// Client-side pagination
import { computed, ref } from 'vue';
const PER_PAGE = 9;
const page = ref(1);
const totalPages = computed(() => Math.ceil(props.collections.length / PER_PAGE));
const paginated = computed(() => props.collections.slice((page.value - 1) * PER_PAGE, page.value * PER_PAGE));

function thumbnailUrl(path: string | null): string {
    return path ? `/storage/${path}` : '';
}

function destroy(id: number) {
    if (!confirm('Yakin ingin menghapus koleksi ini? Semua tulisan di dalamnya akan ikut terhapus.')) return;
    router.delete(`/admin/collections/${id}`);
}
</script>

<template>
    <AdminLayout>
        <template #header>
            <h1 class="text-base font-semibold" style="font-family: var(--font-serif); color: var(--color-ink-800)">Koleksi</h1>
        </template>

        <!-- Header bar -->
        <div class="flex items-center justify-between mb-6">
            <p class="text-sm" style="color: var(--color-ink-500)">{{ collections.length }} koleksi tersimpan</p>
            <Link
                href="/admin/collections/create"
                class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-medium transition-all hover:opacity-90"
                style="background-color: var(--color-forest-800); color: white"
            >
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Koleksi Baru
            </Link>
        </div>

        <!-- Empty state -->
        <div v-if="collections.length === 0" class="flex flex-col items-center justify-center py-24 rounded-2xl" style="background-color: white; border: 1px dashed var(--color-cream-300)">
            <div class="w-12 h-12 rounded-2xl flex items-center justify-center mb-4" style="background-color: var(--color-sage-50)">
                <svg class="w-5 h-5" style="color: var(--color-sage-400)" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                </svg>
            </div>
            <p class="text-sm font-medium mb-1" style="color: var(--color-ink-700)">Belum ada koleksi</p>
            <p class="text-xs mb-5" style="color: var(--color-ink-400)">Buat koleksi pertama untuk mulai mengorganisir tulisan</p>
            <Link href="/admin/collections/create" class="px-4 py-2 rounded-xl text-sm font-medium transition-all" style="background-color: var(--color-forest-800); color: white">
                Buat Koleksi
            </Link>
        </div>

        <!-- Grid cards -->
        <div v-else class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-4">
            <div
                v-for="col in paginated"
                :key="col.id"
                class="group rounded-2xl overflow-hidden flex flex-col"
                style="background-color: white; border: 1px solid var(--color-cream-200)"
            >
                <!-- Thumbnail -->
                <div class="relative h-40 flex-shrink-0 overflow-hidden" style="background: linear-gradient(135deg, var(--color-sage-100), var(--color-mint-100))">
                    <img
                        v-if="col.thumbnail"
                        :src="thumbnailUrl(col.thumbnail)"
                        :alt="col.title"
                        class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                    />
                    <div v-else class="w-full h-full flex items-center justify-center">
                        <svg class="w-8 h-8" style="color: var(--color-sage-300)" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                    </div>
                    <!-- Status badge -->
                    <div class="absolute top-3 left-3">
                        <span
                            class="text-xs px-2.5 py-1 rounded-full font-medium"
                            :style="col.is_published
                                ? 'background-color: var(--color-sage-100); color: var(--color-sage-700)'
                                : 'background-color: var(--color-cream-200); color: var(--color-ink-500)'"
                        >
                            {{ col.is_published ? 'Publik' : 'Draft' }}
                        </span>
                    </div>
                </div>

                <!-- Body -->
                <div class="flex flex-col flex-1 p-4">
                    <h3 class="font-semibold text-base mb-1 leading-snug" style="font-family: var(--font-serif); color: var(--color-ink-800)">
                        {{ col.title }}
                    </h3>
                    <p v-if="col.description" class="text-xs line-clamp-2 mb-3 flex-1" style="color: var(--color-ink-400); line-height: 1.6">
                        {{ col.description }}
                    </p>
                    <div v-else class="flex-1"/>

                    <div class="flex items-center justify-between pt-3" style="border-top: 1px solid var(--color-cream-100)">
                        <span class="text-xs font-medium" style="color: var(--color-sage-600)">
                            {{ col.writings_count ?? 0 }} tulisan
                        </span>
                        <!-- Action buttons — always visible -->
                        <div class="flex items-center gap-1">
                            <Link
                                :href="`/admin/collections/${col.id}/edit`"
                                class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-medium transition-colors"
                                style="background-color: var(--color-sage-50); color: var(--color-sage-700)"
                                title="Edit"
                            >
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                                Edit
                            </Link>
                            <button
                                class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-medium transition-colors"
                                style="background-color: #fee2e2; color: #dc2626"
                                title="Hapus"
                                @click="destroy(col.id)"
                            >
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                                Hapus
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pagination -->
        <div v-if="totalPages > 1" class="flex items-center justify-between mt-8 pt-5" style="border-top: 1px solid var(--color-cream-200)">
            <p class="text-xs" style="color: var(--color-ink-400)">
                Halaman {{ page }} dari {{ totalPages }}
            </p>
            <div class="flex items-center gap-1">
                <button
                    :disabled="page === 1"
                    class="w-8 h-8 rounded-lg flex items-center justify-center text-xs transition-all disabled:opacity-30"
                    style="border: 1px solid var(--color-cream-200); color: var(--color-ink-600)"
                    @click="page--"
                >
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </button>
                <button
                    v-for="p in totalPages"
                    :key="p"
                    class="w-8 h-8 rounded-lg flex items-center justify-center text-xs font-medium transition-all"
                    :style="p === page
                        ? 'background-color: var(--color-forest-800); color: white'
                        : 'border: 1px solid var(--color-cream-200); color: var(--color-ink-600)'"
                    @click="page = p"
                >
                    {{ p }}
                </button>
                <button
                    :disabled="page === totalPages"
                    class="w-8 h-8 rounded-lg flex items-center justify-center text-xs transition-all disabled:opacity-30"
                    style="border: 1px solid var(--color-cream-200); color: var(--color-ink-600)"
                    @click="page++"
                >
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </button>
            </div>
        </div>
    </AdminLayout>
</template>
