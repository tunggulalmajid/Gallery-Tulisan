<script setup lang="ts">
import AdminLayout from '@/Layouts/AdminLayout.vue';
import ImageUpload from '@/Components/ImageUpload.vue';
import { useForm } from '@inertiajs/vue3';
import { watch } from 'vue';
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

function generateSlug(text: string): string {
    return text
        .toLowerCase()
        .trim()
        .replace(/[^\w\s-]/g, '')   // hapus karakter non-alphanumeric
        .replace(/[\s_]+/g, '-')    // spasi & underscore → tanda hubung
        .replace(/-+/g, '-')        // multiple tanda hubung → satu
        .replace(/^-+|-+$/g, '');   // trim tanda hubung di awal/akhir
}

// Auto-generate slug dari judul — hanya saat create, bukan edit
watch(() => form.title, (val) => {
    if (!isEdit) {
        form.slug = generateSlug(val);
    }
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
                    <label class="block text-sm font-medium mb-1.5" style="color: var(--color-ink-700)">Judul Koleksi <span style="color: #ef4444">*</span></label>
                    <input
                        v-model="form.title"
                        type="text"
                        class="w-full px-4 py-2.5 rounded-xl text-sm outline-none"
                        style="border: 1px solid var(--color-cream-300); background-color: var(--color-cream-50); color: var(--color-ink-800)"
                        placeholder="Contoh: Rindu yang Tertinggal"
                    />
                    <p v-if="form.errors.title" class="text-xs mt-1" style="color: #dc2626">{{ form.errors.title }}</p>
                </div>

                <!-- Slug (readonly, auto dari judul) -->
                <div>
                    <label class="block text-sm font-medium mb-1.5" style="color: var(--color-ink-700)">
                        Slug
                        <span class="text-xs font-normal ml-1" style="color: var(--color-ink-400)">· otomatis dari judul</span>
                    </label>
                    <div class="relative">
                        <input
                            :value="form.slug"
                            type="text"
                            readonly
                            class="w-full px-4 py-2.5 rounded-xl text-sm font-mono cursor-not-allowed"
                            style="border: 1px solid var(--color-cream-200); background-color: var(--color-cream-100); color: var(--color-ink-400)"
                            :placeholder="isEdit ? '' : 'akan terisi otomatis...'"
                        />
                        <div class="absolute right-3 top-1/2 -translate-y-1/2">
                            <svg class="w-3.5 h-3.5" style="color: var(--color-ink-300)" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                        </div>
                    </div>
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
                    <ImageUpload
                        v-model="form.thumbnail"
                        label="Thumbnail"
                        :current-image="collection?.thumbnail ?? null"
                    />
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
                                :style="form.is_published ? 'background-color: var(--color-sage-500)' : 'background-color: var(--color-ink-200)'"
                                @click="form.is_published = !form.is_published"
                            >
                                <div class="absolute top-0.5 w-4 h-4 rounded-full bg-white shadow transition-transform" :class="form.is_published ? 'translate-x-5' : 'translate-x-0.5'" />
                            </div>
                            <span class="text-sm" style="color: var(--color-ink-700)">Publikasikan</span>
                        </label>
                    </div>
                </div>

                <!-- Actions — rata kanan -->
                <div class="flex items-center justify-end gap-3 pt-2" style="border-top: 1px solid var(--color-cream-200)">
                    <a href="/admin/collections" class="px-5 py-2.5 rounded-xl text-sm font-medium transition-all hover:opacity-80" style="background-color: var(--color-cream-100); color: var(--color-ink-600)">
                        Batal
                    </a>
                    <button type="submit" :disabled="form.processing" class="px-6 py-2.5 rounded-xl text-sm font-semibold text-white transition-all hover:opacity-90 disabled:opacity-50" style="background-color: var(--color-forest-800)">
                        {{ form.processing ? 'Menyimpan...' : (isEdit ? 'Perbarui Koleksi' : 'Buat Koleksi') }}
                    </button>
                </div>
            </form>
        </div>
    </AdminLayout>
</template>
