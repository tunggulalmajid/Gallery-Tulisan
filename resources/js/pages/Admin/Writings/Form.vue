<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';
import { watch } from 'vue';
import ImageUpload from '@/Components/ImageUpload.vue';
import TiptapEditor from '@/Components/TiptapEditor.vue';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import type { Writing, WritingType } from '@/types';

const props = defineProps<{
    writing?: Writing;
    collections: { id: number; title: string }[];
    types: WritingType[];
}>();

const isEdit = !!props.writing;

const form = useForm({
    collection_id: props.writing?.collection_id ?? '',
    title: props.writing?.title ?? '',
    slug: props.writing?.slug ?? '',
    type: props.writing?.type ?? 'puisi',
    excerpt: props.writing?.excerpt ?? '',
    content: props.writing?.content ?? '',
    thumbnail: null as File | null,
    is_published: props.writing?.is_published ?? false,
    sort_order: props.writing?.sort_order ?? 0,
    written_at: props.writing?.written_at ?? '',
});

function generateSlug(text: string): string {
    return text
        .toLowerCase()
        .trim()
        .replace(/[^\w\s-]/g, '')
        .replace(/[\s_]+/g, '-')
        .replace(/-+/g, '-')
        .replace(/^-+|-+$/g, '');
}

// Auto-generate slug dari judul — hanya saat create, bukan edit
watch(
    () => form.title,
    (val) => {
        if (!isEdit) {
            form.slug = generateSlug(val);
        }
    },
);

function submit() {
    if (isEdit) {
        form.post(`/admin/writings/${props.writing!.id}?_method=PATCH`, {
            forceFormData: true,
        });
    } else {
        form.post('/admin/writings');
    }
}
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
                {{ isEdit ? 'Edit Tulisan' : 'Tulisan Baru' }}
            </h1>
        </template>

        <form
            @submit.prevent="submit"
            class="grid grid-cols-1 gap-6 lg:grid-cols-3"
        >
            <!-- Main: Content -->
            <div class="space-y-5 lg:col-span-2">
                <!-- Title -->
                <div>
                    <label
                        class="mb-1.5 block text-sm font-medium"
                        style="color: var(--color-ink-700)"
                        >Judul <span style="color: #ef4444">*</span></label
                    >
                    <input
                        v-model="form.title"
                        type="text"
                        class="w-full rounded-xl px-4 py-2.5 text-sm outline-none"
                        style="
                            border: 1px solid var(--color-cream-300);
                            background-color: var(--color-cream-50);
                            color: var(--color-ink-800);
                        "
                        placeholder="Judul tulisan..."
                    />
                    <p
                        v-if="form.errors.title"
                        class="mt-1 text-xs"
                        style="color: #dc2626"
                    >
                        {{ form.errors.title }}
                    </p>
                </div>

                <!-- Excerpt -->
                <div>
                    <label
                        class="mb-1.5 block text-sm font-medium"
                        style="color: var(--color-ink-700)"
                        >Kutipan / Excerpt</label
                    >
                    <textarea
                        v-model="form.excerpt"
                        rows="2"
                        class="w-full resize-none rounded-xl px-4 py-2.5 text-sm outline-none"
                        style="
                            border: 1px solid var(--color-cream-300);
                            background-color: var(--color-cream-50);
                            color: var(--color-ink-800);
                        "
                        placeholder="Kalimat pembuka yang menarik perhatian..."
                    />
                    <p
                        v-if="form.errors.excerpt"
                        class="mt-1 text-xs"
                        style="color: #dc2626"
                    >
                        {{ form.errors.excerpt }}
                    </p>
                </div>

                <!-- Content / TipTap -->
                <div>
                    <label
                        class="mb-1.5 block text-sm font-medium"
                        style="color: var(--color-ink-700)"
                        >Isi Tulisan
                        <span style="color: #ef4444">*</span></label
                    >
                    <TiptapEditor
                        v-model="form.content"
                        placeholder="Mulai menulis karya indahmu..."
                    />
                    <p
                        v-if="form.errors.content"
                        class="mt-1 text-xs"
                        style="color: #dc2626"
                    >
                        {{ form.errors.content }}
                    </p>
                </div>
            </div>

            <!-- Sidebar: Settings -->
            <div class="space-y-5">
                <!-- Publish + Save -->
                <div
                    class="rounded-2xl p-4"
                    style="
                        background-color: white;
                        border: 1px solid var(--color-cream-200);
                    "
                >
                    <div class="mb-4 flex items-center justify-between">
                        <h3
                            class="text-sm font-semibold"
                            style="color: var(--color-ink-700)"
                        >
                            Publikasi
                        </h3>
                        <div
                            class="relative h-5 w-10 cursor-pointer rounded-full transition-colors"
                            :style="
                                form.is_published
                                    ? 'background-color: var(--color-sage-500)'
                                    : 'background-color: var(--color-ink-200)'
                            "
                            @click="form.is_published = !form.is_published"
                        >
                            <div
                                class="absolute top-0.5 h-4 w-4 rounded-full bg-white shadow transition-transform"
                                :class="
                                    form.is_published
                                        ? 'translate-x-5'
                                        : 'translate-x-0.5'
                                "
                            />
                        </div>
                    </div>
                    <div class="flex gap-2">
                        <button
                            type="submit"
                            :disabled="form.processing"
                            class="flex-1 rounded-xl py-2.5 text-sm text-white transition-all disabled:opacity-50"
                            style="background-color: var(--color-forest-800)"
                        >
                            {{
                                form.processing
                                    ? 'Menyimpan...'
                                    : isEdit
                                      ? 'Perbarui'
                                      : 'Simpan'
                            }}
                        </button>
                        <a
                            href="/admin/writings"
                            class="rounded-xl px-4 py-2.5 text-sm"
                            style="
                                background-color: var(--color-cream-100);
                                color: var(--color-ink-600);
                            "
                        >
                            Batal
                        </a>
                    </div>
                </div>

                <!-- Settings -->
                <div
                    class="space-y-3 rounded-2xl p-4"
                    style="
                        background-color: white;
                        border: 1px solid var(--color-cream-200);
                    "
                >
                    <h3
                        class="text-sm font-semibold"
                        style="color: var(--color-ink-700)"
                    >
                        Pengaturan
                    </h3>

                    <div>
                        <label
                            class="mb-1 block text-xs"
                            style="color: var(--color-ink-500)"
                            >Koleksi *</label
                        >
                        <select
                            v-model="form.collection_id"
                            class="w-full rounded-lg px-3 py-2 text-sm outline-none"
                            style="
                                border: 1px solid var(--color-cream-300);
                                background-color: var(--color-cream-50);
                                color: var(--color-ink-800);
                            "
                        >
                            <option value="" disabled>Pilih koleksi...</option>
                            <option
                                v-for="c in collections"
                                :key="c.id"
                                :value="c.id"
                            >
                                {{ c.title }}
                            </option>
                        </select>
                        <p
                            v-if="form.errors.collection_id"
                            class="mt-1 text-xs"
                            style="color: #dc2626"
                        >
                            {{ form.errors.collection_id }}
                        </p>
                    </div>

                    <div>
                        <label
                            class="mb-1 block text-xs"
                            style="color: var(--color-ink-500)"
                            >Jenis Tulisan *</label
                        >
                        <select
                            v-model="form.type"
                            class="w-full rounded-lg px-3 py-2 text-sm capitalize outline-none"
                            style="
                                border: 1px solid var(--color-cream-300);
                                background-color: var(--color-cream-50);
                                color: var(--color-ink-800);
                            "
                        >
                            <option
                                v-for="t in types"
                                :key="t"
                                :value="t"
                                class="capitalize"
                            >
                                {{ t }}
                            </option>
                        </select>
                    </div>

                    <div>
                        <label
                            class="mb-1 block flex items-center gap-1 text-xs"
                            style="color: var(--color-ink-500)"
                        >
                            Slug
                            <svg
                                class="h-3 w-3"
                                style="color: var(--color-ink-300)"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"
                                />
                            </svg>
                        </label>
                        <input
                            :value="form.slug"
                            type="text"
                            readonly
                            class="w-full cursor-not-allowed rounded-lg px-3 py-2 font-mono text-xs"
                            style="
                                border: 1px solid var(--color-cream-200);
                                background-color: var(--color-cream-100);
                                color: var(--color-ink-400);
                            "
                            placeholder="otomatis dari judul..."
                        />
                    </div>

                    <div>
                        <label
                            class="mb-1 block text-xs"
                            style="color: var(--color-ink-500)"
                            >Tanggal Ditulis</label
                        >
                        <input
                            v-model="form.written_at"
                            type="date"
                            class="w-full rounded-lg px-3 py-2 text-sm outline-none"
                            style="
                                border: 1px solid var(--color-cream-300);
                                background-color: var(--color-cream-50);
                                color: var(--color-ink-800);
                            "
                        />
                    </div>

                    <div>
                        <label
                            class="mb-1 block text-xs"
                            style="color: var(--color-ink-500)"
                            >Urutan Tampil</label
                        >
                        <input
                            v-model.number="form.sort_order"
                            type="number"
                            min="0"
                            class="w-full rounded-lg px-3 py-2 text-sm outline-none"
                            style="
                                border: 1px solid var(--color-cream-300);
                                background-color: var(--color-cream-50);
                                color: var(--color-ink-800);
                            "
                        />
                    </div>
                </div>

                <!-- Thumbnail -->
                <div
                    class="rounded-2xl p-4"
                    style="
                        background-color: white;
                        border: 1px solid var(--color-cream-200);
                    "
                >
                    <h3
                        class="mb-3 text-sm font-semibold"
                        style="color: var(--color-ink-700)"
                    >
                        Thumbnail
                    </h3>
                    <ImageUpload
                        v-model="form.thumbnail"
                        :current-image="writing?.thumbnail ?? null"
                    />
                    <p
                        v-if="form.errors.thumbnail"
                        class="mt-1 text-xs"
                        style="color: #dc2626"
                    >
                        {{ form.errors.thumbnail }}
                    </p>
                </div>
            </div>
        </form>
    </AdminLayout>
</template>
