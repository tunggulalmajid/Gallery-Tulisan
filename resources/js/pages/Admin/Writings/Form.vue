<script setup lang="ts">
import AdminLayout from '@/Layouts/AdminLayout.vue';
import TiptapEditor from '@/Components/TiptapEditor.vue';
import { useForm } from '@inertiajs/vue3';
import type { Collection, Writing, WritingType } from '@/types';

const props = defineProps<{
    writing?: Writing;
    collections: { id: number; title: string }[];
    types: WritingType[];
}>();

const isEdit = !!props.writing;

const form = useForm({
    collection_id: props.writing?.collection_id ?? '',
    title:         props.writing?.title ?? '',
    slug:          props.writing?.slug ?? '',
    type:          props.writing?.type ?? 'puisi',
    excerpt:       props.writing?.excerpt ?? '',
    content:       props.writing?.content ?? '',
    thumbnail:     null as File | null,
    is_published:  props.writing?.is_published ?? false,
    sort_order:    props.writing?.sort_order ?? 0,
    written_at:    props.writing?.written_at ?? '',
});

function submit() {
    if (isEdit) {
        form.post(`/admin/writings/${props.writing!.id}?_method=PATCH`, {
            forceFormData: true,
        });
    } else {
        form.post('/admin/writings');
    }
}

function onFileChange(e: Event) {
    const file = (e.target as HTMLInputElement).files?.[0] ?? null;
    form.thumbnail = file;
}

function thumbnailUrl(path: string | null): string {
    return path ? `/storage/${path}` : '';
}
</script>

<template>
    <AdminLayout>
        <template #header>
            <h1 class="text-lg font-semibold" style="font-family: var(--font-serif); color: var(--color-ink-800)">
                {{ isEdit ? 'Edit Tulisan' : 'Tulisan Baru' }}
            </h1>
        </template>

        <form @submit.prevent="submit" class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main: Content -->
            <div class="lg:col-span-2 space-y-5">
                <!-- Title -->
                <div>
                    <label class="block text-sm font-medium mb-1.5" style="color: var(--color-ink-700)">Judul <span style="color: var(--color-blush-500)">*</span></label>
                    <input
                        v-model="form.title"
                        type="text"
                        class="w-full px-4 py-2.5 rounded-xl text-sm outline-none"
                        style="border: 1px solid var(--color-cream-300); background-color: var(--color-cream-50); color: var(--color-ink-800)"
                        placeholder="Judul tulisan..."
                    />
                    <p v-if="form.errors.title" class="text-xs mt-1" style="color: #dc2626">{{ form.errors.title }}</p>
                </div>

                <!-- Excerpt -->
                <div>
                    <label class="block text-sm font-medium mb-1.5" style="color: var(--color-ink-700)">Kutipan / Excerpt</label>
                    <textarea
                        v-model="form.excerpt"
                        rows="2"
                        class="w-full px-4 py-2.5 rounded-xl text-sm outline-none resize-none"
                        style="border: 1px solid var(--color-cream-300); background-color: var(--color-cream-50); color: var(--color-ink-800)"
                        placeholder="Kalimat pembuka yang menarik perhatian..."
                    />
                    <p v-if="form.errors.excerpt" class="text-xs mt-1" style="color: #dc2626">{{ form.errors.excerpt }}</p>
                </div>

                <!-- Content / TipTap -->
                <div>
                    <label class="block text-sm font-medium mb-1.5" style="color: var(--color-ink-700)">Isi Tulisan <span style="color: var(--color-blush-500)">*</span></label>
                    <TiptapEditor
                        v-model="form.content"
                        placeholder="Mulai menulis karya indahmu..."
                    />
                    <p v-if="form.errors.content" class="text-xs mt-1" style="color: #dc2626">{{ form.errors.content }}</p>
                </div>
            </div>

            <!-- Sidebar: Settings -->
            <div class="space-y-5">
                <!-- Publish toggle -->
                <div class="rounded-2xl p-4" style="background-color: white; border: 1px solid var(--color-cream-200)">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-sm font-semibold" style="color: var(--color-ink-700)">Publikasi</h3>
                        <div
                            class="w-10 h-5 rounded-full transition-colors relative cursor-pointer"
                            :style="form.is_published ? 'background-color: var(--color-blush-400)' : 'background-color: var(--color-ink-200)'"
                            @click="form.is_published = !form.is_published"
                        >
                            <div class="absolute top-0.5 w-4 h-4 rounded-full bg-white shadow transition-transform" :class="form.is_published ? 'translate-x-5' : 'translate-x-0.5'" />
                        </div>
                    </div>
                    <div class="flex gap-2">
                        <button type="submit" :disabled="form.processing" class="flex-1 py-2.5 rounded-xl text-sm text-white transition-all disabled:opacity-50" style="background-color: var(--color-blush-500)">
                            {{ form.processing ? 'Menyimpan...' : (isEdit ? 'Perbarui' : 'Simpan') }}
                        </button>
                        <a href="/admin/writings" class="px-4 py-2.5 rounded-xl text-sm" style="background-color: var(--color-cream-100); color: var(--color-ink-600)">
                            Batal
                        </a>
                    </div>
                </div>

                <!-- Collection -->
                <div class="rounded-2xl p-4 space-y-3" style="background-color: white; border: 1px solid var(--color-cream-200)">
                    <h3 class="text-sm font-semibold" style="color: var(--color-ink-700)">Pengaturan</h3>

                    <div>
                        <label class="block text-xs mb-1" style="color: var(--color-ink-500)">Koleksi *</label>
                        <select
                            v-model="form.collection_id"
                            class="w-full px-3 py-2 rounded-lg text-sm outline-none"
                            style="border: 1px solid var(--color-cream-300); background-color: var(--color-cream-50); color: var(--color-ink-800)"
                        >
                            <option value="" disabled>Pilih koleksi...</option>
                            <option v-for="c in collections" :key="c.id" :value="c.id">{{ c.title }}</option>
                        </select>
                        <p v-if="form.errors.collection_id" class="text-xs mt-1" style="color: #dc2626">{{ form.errors.collection_id }}</p>
                    </div>

                    <div>
                        <label class="block text-xs mb-1" style="color: var(--color-ink-500)">Jenis Tulisan *</label>
                        <select
                            v-model="form.type"
                            class="w-full px-3 py-2 rounded-lg text-sm outline-none capitalize"
                            style="border: 1px solid var(--color-cream-300); background-color: var(--color-cream-50); color: var(--color-ink-800)"
                        >
                            <option v-for="t in types" :key="t" :value="t" class="capitalize">{{ t }}</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs mb-1" style="color: var(--color-ink-500)">Slug</label>
                        <input
                            v-model="form.slug"
                            type="text"
                            class="w-full px-3 py-2 rounded-lg text-xs font-mono outline-none"
                            style="border: 1px solid var(--color-cream-300); background-color: var(--color-cream-50); color: var(--color-ink-600)"
                            placeholder="otomatis dari judul"
                        />
                    </div>

                    <div>
                        <label class="block text-xs mb-1" style="color: var(--color-ink-500)">Tanggal Ditulis</label>
                        <input
                            v-model="form.written_at"
                            type="date"
                            class="w-full px-3 py-2 rounded-lg text-sm outline-none"
                            style="border: 1px solid var(--color-cream-300); background-color: var(--color-cream-50); color: var(--color-ink-800)"
                        />
                    </div>

                    <div>
                        <label class="block text-xs mb-1" style="color: var(--color-ink-500)">Urutan Tampil</label>
                        <input
                            v-model.number="form.sort_order"
                            type="number" min="0"
                            class="w-full px-3 py-2 rounded-lg text-sm outline-none"
                            style="border: 1px solid var(--color-cream-300); background-color: var(--color-cream-50); color: var(--color-ink-800)"
                        />
                    </div>
                </div>

                <!-- Thumbnail -->
                <div class="rounded-2xl p-4" style="background-color: white; border: 1px solid var(--color-cream-200)">
                    <h3 class="text-sm font-semibold mb-3" style="color: var(--color-ink-700)">Thumbnail</h3>
                    <div v-if="isEdit && writing?.thumbnail && !form.thumbnail" class="mb-3">
                        <img :src="thumbnailUrl(writing.thumbnail)" alt="thumbnail" class="w-full h-32 object-cover rounded-lg" />
                    </div>
                    <input type="file" accept="image/*" class="text-xs w-full" style="color: var(--color-ink-600)" @change="onFileChange" />
                    <p v-if="form.errors.thumbnail" class="text-xs mt-1" style="color: #dc2626">{{ form.errors.thumbnail }}</p>
                </div>
            </div>
        </form>
    </AdminLayout>
</template>
