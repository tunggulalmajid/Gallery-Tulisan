<script setup lang="ts">
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { useForm } from '@inertiajs/vue3';
import type { Collection } from '@/types';

const props = defineProps<{
    collection?: Collection;
}>();

const isEdit = !!props.collection;

const form = useForm({
    title:        props.collection?.title ?? '',
    slug:         props.collection?.slug ?? '',
    description:  props.collection?.description ?? '',
    thumbnail:    null as File | null,
    is_published: props.collection?.is_published ?? false,
    sort_order:   props.collection?.sort_order ?? 0,
});

function submit() {
    if (isEdit) {
        form.post(`/admin/collections/${props.collection!.id}?_method=PATCH`, {
            forceFormData: true,
        });
    } else {
        form.post('/admin/collections');
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
                {{ isEdit ? 'Edit Koleksi' : 'Koleksi Baru' }}
            </h1>
        </template>

        <div class="max-w-2xl">
            <form @submit.prevent="submit" class="space-y-5">
                <!-- Title -->
                <div>
                    <label class="block text-sm font-medium mb-1.5" style="color: var(--color-ink-700)">Judul Koleksi <span style="color: var(--color-blush-500)">*</span></label>
                    <input
                        v-model="form.title"
                        type="text"
                        class="w-full px-4 py-2.5 rounded-xl text-sm outline-none"
                        style="border: 1px solid var(--color-cream-300); background-color: var(--color-cream-50); color: var(--color-ink-800)"
                        placeholder="Contoh: Rindu yang Tertinggal"
                    />
                    <p v-if="form.errors.title" class="text-xs mt-1" style="color: #dc2626">{{ form.errors.title }}</p>
                </div>

                <!-- Slug -->
                <div>
                    <label class="block text-sm font-medium mb-1.5" style="color: var(--color-ink-700)">Slug <span class="text-xs font-normal" style="color: var(--color-ink-400)">(opsional, otomatis dari judul)</span></label>
                    <input
                        v-model="form.slug"
                        type="text"
                        class="w-full px-4 py-2.5 rounded-xl text-sm outline-none font-mono"
                        style="border: 1px solid var(--color-cream-300); background-color: var(--color-cream-50); color: var(--color-ink-600)"
                        placeholder="rindu-yang-tertinggal"
                    />
                    <p v-if="form.errors.slug" class="text-xs mt-1" style="color: #dc2626">{{ form.errors.slug }}</p>
                </div>

                <!-- Description -->
                <div>
                    <label class="block text-sm font-medium mb-1.5" style="color: var(--color-ink-700)">Deskripsi</label>
                    <textarea
                        v-model="form.description"
                        rows="3"
                        class="w-full px-4 py-2.5 rounded-xl text-sm outline-none resize-none"
                        style="border: 1px solid var(--color-cream-300); background-color: var(--color-cream-50); color: var(--color-ink-800)"
                        placeholder="Deskripsi singkat tentang koleksi ini..."
                    />
                    <p v-if="form.errors.description" class="text-xs mt-1" style="color: #dc2626">{{ form.errors.description }}</p>
                </div>

                <!-- Thumbnail -->
                <div>
                    <label class="block text-sm font-medium mb-1.5" style="color: var(--color-ink-700)">Thumbnail</label>
                    <div v-if="isEdit && collection?.thumbnail && !form.thumbnail" class="mb-3">
                        <img :src="thumbnailUrl(collection.thumbnail)" alt="thumbnail" class="w-32 h-20 object-cover rounded-lg" />
                    </div>
                    <input type="file" accept="image/*" class="text-sm" style="color: var(--color-ink-600)" @change="onFileChange" />
                    <p v-if="form.errors.thumbnail" class="text-xs mt-1" style="color: #dc2626">{{ form.errors.thumbnail }}</p>
                </div>

                <!-- Sort order + Published row -->
                <div class="flex flex-wrap gap-5">
                    <div class="flex-1 min-w-32">
                        <label class="block text-sm font-medium mb-1.5" style="color: var(--color-ink-700)">Urutan Tampil</label>
                        <input
                            v-model.number="form.sort_order"
                            type="number" min="0"
                            class="w-full px-4 py-2.5 rounded-xl text-sm outline-none"
                            style="border: 1px solid var(--color-cream-300); background-color: var(--color-cream-50); color: var(--color-ink-800)"
                        />
                    </div>
                    <div class="flex items-end pb-2.5">
                        <label class="flex items-center gap-2.5 cursor-pointer">
                            <div
                                class="w-10 h-5 rounded-full transition-colors relative"
                                :style="form.is_published ? 'background-color: var(--color-blush-400)' : 'background-color: var(--color-ink-200)'"
                                @click="form.is_published = !form.is_published"
                            >
                                <div class="absolute top-0.5 w-4 h-4 rounded-full bg-white shadow transition-transform" :class="form.is_published ? 'translate-x-5' : 'translate-x-0.5'" />
                            </div>
                            <span class="text-sm" style="color: var(--color-ink-700)">Publikasikan</span>
                        </label>
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex gap-3 pt-2">
                    <button type="submit" :disabled="form.processing" class="px-5 py-2.5 rounded-xl text-sm text-white transition-all hover:opacity-90 disabled:opacity-50" style="background-color: var(--color-blush-500)">
                        {{ form.processing ? 'Menyimpan...' : (isEdit ? 'Perbarui Koleksi' : 'Buat Koleksi') }}
                    </button>
                    <a href="/admin/collections" class="px-5 py-2.5 rounded-xl text-sm transition-all" style="background-color: var(--color-cream-100); color: var(--color-ink-600)">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </AdminLayout>
</template>
