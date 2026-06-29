<script setup lang="ts">
import { Link, router } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import type { PaginatedData, Writing } from '@/types';

defineProps<{
    writings: PaginatedData<Writing>;
}>();

function thumbnailUrl(path: string | null): string {
    return path ? `/storage/${path}` : '';
}

function formatDate(date: string): string {
    return new Date(date).toLocaleDateString('id-ID', {
        day: 'numeric',
        month: 'short',
        year: 'numeric',
    });
}

function destroy(id: number) {
    if (!confirm('Yakin ingin menghapus tulisan ini?')) {
        return;
    }

    router.delete(`/admin/writings/${id}`);
}

const typeColors: Record<string, string> = {
    puisi: 'background-color: var(--color-blush-50); color: var(--color-blush-600)',
    pantun: 'background-color: var(--color-mauve-50); color: var(--color-mauve-600)',
    cerita: 'background-color: var(--color-cream-200); color: var(--color-ink-600)',
    prosa: 'background-color: #f0fdf4; color: #166534',
    sajak: 'background-color: #fef9c3; color: #854d0e',
    lainnya:
        'background-color: var(--color-cream-100); color: var(--color-ink-500)',
};
</script>

<template>
    <AdminLayout>
        <template #header>
            <h1
                class="text-lg font-semibold"
                style="
                    font-family: var(--font-serif);
                    color: var(--color-ink-800);
                "
            >
                Tulisan
            </h1>
        </template>

        <div class="mb-5 flex justify-end">
            <Link
                href="/admin/writings/create"
                class="inline-flex items-center gap-2 rounded-xl px-4 py-2.5 text-sm text-white"
                style="background-color: var(--color-blush-500)"
            >
                + Tulisan Baru
            </Link>
        </div>

        <div
            class="overflow-hidden rounded-2xl"
            style="
                background-color: white;
                border: 1px solid var(--color-cream-200);
            "
        >
            <table class="w-full text-sm">
                <thead>
                    <tr
                        style="
                            background-color: var(--color-cream-50);
                            border-bottom: 1px solid var(--color-cream-200);
                        "
                    >
                        <th
                            class="px-5 py-3 text-left font-medium"
                            style="color: var(--color-ink-500)"
                        >
                            Tulisan
                        </th>
                        <th
                            class="hidden px-5 py-3 text-left font-medium sm:table-cell"
                            style="color: var(--color-ink-500)"
                        >
                            Koleksi
                        </th>
                        <th
                            class="hidden px-5 py-3 text-left font-medium md:table-cell"
                            style="color: var(--color-ink-500)"
                        >
                            Jenis
                        </th>
                        <th
                            class="hidden px-5 py-3 text-left font-medium md:table-cell"
                            style="color: var(--color-ink-500)"
                        >
                            Status
                        </th>
                        <th
                            class="hidden px-5 py-3 text-left font-medium lg:table-cell"
                            style="color: var(--color-ink-500)"
                        >
                            Dibuat
                        </th>
                        <th class="px-5 py-3" />
                    </tr>
                </thead>
                <tbody>
                    <tr
                        v-for="w in writings.data"
                        :key="w.id"
                        class="border-b transition-colors hover:bg-[--color-cream-50]"
                        style="border-color: var(--color-cream-100)"
                    >
                        <td class="px-5 py-3">
                            <div class="flex items-center gap-3">
                                <div
                                    class="h-10 w-10 flex-shrink-0 overflow-hidden rounded-lg"
                                >
                                    <img
                                        v-if="w.thumbnail"
                                        :src="thumbnailUrl(w.thumbnail)"
                                        :alt="w.title"
                                        class="h-full w-full object-cover"
                                    />
                                    <div
                                        v-else
                                        class="flex h-full w-full items-center justify-center"
                                        style="
                                            background: linear-gradient(
                                                135deg,
                                                var(--color-blush-50),
                                                var(--color-mauve-50)
                                            );
                                        "
                                    >
                                        <span
                                            style="
                                                color: var(--color-blush-200);
                                            "
                                            >✦</span
                                        >
                                    </div>
                                </div>
                                <div class="min-w-0">
                                    <p
                                        class="max-w-[180px] truncate font-medium"
                                        style="color: var(--color-ink-800)"
                                    >
                                        {{ w.title }}
                                    </p>
                                    <p
                                        class="max-w-[180px] truncate text-xs"
                                        style="color: var(--color-ink-400)"
                                    >
                                        {{ w.slug }}
                                    </p>
                                </div>
                            </div>
                        </td>
                        <td class="hidden px-5 py-3 sm:table-cell">
                            <span
                                class="text-xs"
                                style="color: var(--color-ink-500)"
                                >{{ w.collection?.title }}</span
                            >
                        </td>
                        <td class="hidden px-5 py-3 md:table-cell">
                            <span
                                class="rounded-full px-2 py-0.5 text-xs capitalize"
                                :style="
                                    typeColors[w.type] ?? typeColors.lainnya
                                "
                                >{{ w.type }}</span
                            >
                        </td>
                        <td class="hidden px-5 py-3 md:table-cell">
                            <span
                                class="rounded-full px-2 py-0.5 text-xs"
                                :style="
                                    w.is_published
                                        ? 'background-color: #dcfce7; color: #16a34a'
                                        : 'background-color: var(--color-cream-100); color: var(--color-ink-400)'
                                "
                            >
                                {{ w.is_published ? 'Publik' : 'Draft' }}
                            </span>
                        </td>
                        <td
                            class="hidden px-5 py-3 text-xs lg:table-cell"
                            style="color: var(--color-ink-400)"
                        >
                            {{ formatDate(w.created_at) }}
                        </td>
                        <td class="px-5 py-3">
                            <div class="flex items-center justify-end gap-2">
                                <Link
                                    :href="`/admin/writings/${w.id}/edit`"
                                    class="rounded-lg px-3 py-1.5 text-xs"
                                    style="
                                        background-color: var(--color-blush-50);
                                        color: var(--color-blush-600);
                                    "
                                >
                                    Edit
                                </Link>
                                <button
                                    @click="destroy(w.id)"
                                    class="rounded-lg px-3 py-1.5 text-xs"
                                    style="
                                        background-color: #fef2f2;
                                        color: #dc2626;
                                    "
                                >
                                    Hapus
                                </button>
                            </div>
                        </td>
                    </tr>
                    <tr v-if="writings.data.length === 0">
                        <td
                            colspan="6"
                            class="px-5 py-10 text-center text-sm"
                            style="color: var(--color-ink-400)"
                        >
                            Belum ada tulisan.
                        </td>
                    </tr>
                </tbody>
            </table>

            <!-- Pagination -->
            <div
                v-if="writings.last_page > 1"
                class="flex items-center justify-between border-t px-5 py-3"
                style="border-color: var(--color-cream-200)"
            >
                <p class="text-xs" style="color: var(--color-ink-400)">
                    {{ writings.from }}–{{ writings.to }} dari
                    {{ writings.total }}
                </p>
                <div class="flex gap-1">
                    <template v-for="link in writings.links" :key="link.label">
                        <Link
                            v-if="link.url"
                            :href="link.url"
                            class="rounded-lg px-3 py-1.5 text-xs"
                            :style="
                                link.active
                                    ? 'background-color: var(--color-blush-500); color: white'
                                    : 'background-color: var(--color-cream-50); color: var(--color-ink-600)'
                            "
                            ><span v-html="link.label"
                        /></Link>
                    </template>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
