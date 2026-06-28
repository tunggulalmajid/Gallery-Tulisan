<script setup lang="ts">
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Link, router } from '@inertiajs/vue3';
import type { Collection } from '@/types';

defineProps<{
    collections: Collection[];
}>();

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
            <h1 class="text-lg font-semibold" style="font-family: var(--font-serif); color: var(--color-ink-800)">Koleksi</h1>
        </template>

        <div class="flex justify-end mb-5">
            <Link href="/admin/collections/create" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm text-white" style="background-color: var(--color-mauve-500)">
                + Koleksi Baru
            </Link>
        </div>

        <div class="rounded-2xl overflow-hidden" style="background-color: white; border: 1px solid var(--color-cream-200)">
            <table class="w-full text-sm">
                <thead>
                    <tr style="background-color: var(--color-cream-50); border-bottom: 1px solid var(--color-cream-200)">
                        <th class="text-left px-5 py-3 font-medium" style="color: var(--color-ink-500)">Koleksi</th>
                        <th class="text-left px-5 py-3 font-medium hidden sm:table-cell" style="color: var(--color-ink-500)">Tulisan</th>
                        <th class="text-left px-5 py-3 font-medium hidden md:table-cell" style="color: var(--color-ink-500)">Status</th>
                        <th class="text-left px-5 py-3 font-medium hidden lg:table-cell" style="color: var(--color-ink-500)">Urutan</th>
                        <th class="px-5 py-3" />
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="col in collections" :key="col.id" class="border-b transition-colors" style="border-color: var(--color-cream-100)">
                        <td class="px-5 py-3">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg overflow-hidden flex-shrink-0">
                                    <img v-if="col.thumbnail" :src="thumbnailUrl(col.thumbnail)" :alt="col.title" class="w-full h-full object-cover" />
                                    <div v-else class="w-full h-full flex items-center justify-center" style="background-color: var(--color-mauve-50)">
                                        <span style="font-size: 1rem">📖</span>
                                    </div>
                                </div>
                                <div>
                                    <p class="font-medium" style="color: var(--color-ink-800)">{{ col.title }}</p>
                                    <p class="text-xs" style="color: var(--color-ink-400)">{{ col.slug }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-5 py-3 hidden sm:table-cell" style="color: var(--color-ink-500)">{{ col.writings_count ?? 0 }}</td>
                        <td class="px-5 py-3 hidden md:table-cell">
                            <span class="text-xs px-2 py-0.5 rounded-full"
                                :style="col.is_published ? 'background-color: #dcfce7; color: #16a34a' : 'background-color: var(--color-cream-100); color: var(--color-ink-400)'"
                            >
                                {{ col.is_published ? 'Publik' : 'Draft' }}
                            </span>
                        </td>
                        <td class="px-5 py-3 hidden lg:table-cell" style="color: var(--color-ink-500)">{{ col.sort_order }}</td>
                        <td class="px-5 py-3">
                            <div class="flex items-center justify-end gap-2">
                                <Link :href="`/admin/collections/${col.id}/edit`" class="text-xs px-3 py-1.5 rounded-lg transition-colors" style="background-color: var(--color-blush-50); color: var(--color-blush-600)">
                                    Edit
                                </Link>
                                <button @click="destroy(col.id)" class="text-xs px-3 py-1.5 rounded-lg transition-colors" style="background-color: #fef2f2; color: #dc2626">
                                    Hapus
                                </button>
                            </div>
                        </td>
                    </tr>
                    <tr v-if="collections.length === 0">
                        <td colspan="5" class="px-5 py-10 text-center text-sm" style="color: var(--color-ink-400)">Belum ada koleksi.</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </AdminLayout>
</template>
