<script setup lang="ts">
import AdminLayout from '@/Layouts/AdminLayout.vue';
import ImageUpload from '@/Components/ImageUpload.vue';
import { useForm } from '@inertiajs/vue3';
import type { HeroSection } from '@/types';

const props = defineProps<{
    hero: HeroSection | null;
}>();

const form = useForm({
    heading:    props.hero?.heading ?? '',
    subheading: props.hero?.subheading ?? '',
    body:       props.hero?.body ?? '',
    cta_label:  props.hero?.cta_label ?? '',
    cta_url:    props.hero?.cta_url ?? '/koleksi',
    image:      null as File | null,
    is_active:  props.hero?.is_active ?? true,
});

function submit() {
    form.post('/admin/hero', { forceFormData: true });
}
</script>

<template>
    <AdminLayout>
        <template #header>
            <h1 class="text-base font-semibold" style="font-family: var(--font-serif); color: var(--color-ink-800)">Hero Section</h1>
        </template>

        <div class="max-w-3xl">
            <!-- Preview card -->
            <div class="relative rounded-2xl overflow-hidden mb-6 h-40" style="background-color: var(--color-forest-900)">
                <div v-if="hero?.image && !form.image" class="absolute inset-0">
                    <img :src="`/storage/${hero.image}`" alt="Hero preview" class="w-full h-full object-cover opacity-30"/>
                    <div class="absolute inset-0" style="background: linear-gradient(to right, rgba(26,42,26,0.9), transparent)"/>
                </div>
                <div class="absolute inset-0 flex flex-col justify-center px-8">
                    <p class="text-xs font-semibold tracking-widest uppercase mb-1" style="color: var(--color-sage-400)">
                        {{ form.subheading || 'Karya pribadi' }}
                    </p>
                    <h2 class="text-xl font-semibold" style="font-family: var(--font-serif); color: var(--color-cream-100)">
                        {{ form.heading || 'Judul hero section...' }}
                    </h2>
                    <p class="text-xs mt-1" style="color: var(--color-stone-400)">{{ form.body || 'Deskripsi singkat...' }}</p>
                </div>
                <div class="absolute top-3 right-3">
                    <span class="text-xs px-2 py-1 rounded-full" style="background-color: rgba(255,255,255,0.1); color: var(--color-stone-400)">Preview</span>
                </div>
            </div>

            <form @submit.prevent="submit" class="space-y-5">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <!-- Heading -->
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium mb-1.5" style="color: var(--color-ink-700)">
                            Judul Utama <span style="color: #ef4444">*</span>
                        </label>
                        <input
                            v-model="form.heading"
                            type="text"
                            class="w-full px-4 py-2.5 rounded-xl text-sm outline-none"
                            style="border: 1px solid var(--color-cream-300); background-color: white; color: var(--color-ink-800)"
                            placeholder="Setiap Kata adalah Jejak Rasa"
                        />
                        <p v-if="form.errors.heading" class="text-xs mt-1" style="color: #dc2626">{{ form.errors.heading }}</p>
                    </div>

                    <!-- Subheading -->
                    <div>
                        <label class="block text-sm font-medium mb-1.5" style="color: var(--color-ink-700)">Sub-judul</label>
                        <input
                            v-model="form.subheading"
                            type="text"
                            class="w-full px-4 py-2.5 rounded-xl text-sm outline-none"
                            style="border: 1px solid var(--color-cream-300); background-color: white; color: var(--color-ink-800)"
                            placeholder="Karya pribadi Suci"
                        />
                    </div>

                    <!-- Active toggle -->
                    <div class="flex items-end pb-1">
                        <div class="flex items-center gap-3">
                            <div
                                class="w-10 h-5 rounded-full transition-colors relative cursor-pointer flex-shrink-0"
                                :style="form.is_active ? 'background-color: var(--color-sage-500)' : 'background-color: var(--color-cream-300)'"
                                @click="form.is_active = !form.is_active"
                            >
                                <div class="absolute top-0.5 w-4 h-4 rounded-full bg-white shadow transition-transform" :class="form.is_active ? 'translate-x-5' : 'translate-x-0.5'"/>
                            </div>
                            <div>
                                <p class="text-sm font-medium" style="color: var(--color-ink-700)">Tampilkan Hero</p>
                                <p class="text-xs" style="color: var(--color-ink-400)">{{ form.is_active ? 'Aktif ditampilkan' : 'Disembunyikan' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Body -->
                <div>
                    <label class="block text-sm font-medium mb-1.5" style="color: var(--color-ink-700)">Deskripsi</label>
                    <textarea
                        v-model="form.body"
                        rows="3"
                        class="w-full px-4 py-2.5 rounded-xl text-sm outline-none resize-none"
                        style="border: 1px solid var(--color-cream-300); background-color: white; color: var(--color-ink-800)"
                        placeholder="Kumpulan puisi, pantun, dan cerita yang lahir dari ruang paling sunyi..."
                    />
                </div>

                <!-- CTA -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 p-5 rounded-2xl" style="background-color: var(--color-cream-50); border: 1px solid var(--color-cream-200)">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider mb-3" style="color: var(--color-ink-500)">Tombol CTA</p>
                        <label class="block text-xs mb-1" style="color: var(--color-ink-600)">Label Tombol</label>
                        <input
                            v-model="form.cta_label"
                            type="text"
                            class="w-full px-3 py-2 rounded-lg text-sm outline-none"
                            style="border: 1px solid var(--color-cream-300); background-color: white; color: var(--color-ink-800)"
                            placeholder="Jelajahi Karya"
                        />
                    </div>
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider mb-3 invisible">x</p>
                        <label class="block text-xs mb-1" style="color: var(--color-ink-600)">URL Tombol</label>
                        <input
                            v-model="form.cta_url"
                            type="text"
                            class="w-full px-3 py-2 rounded-lg text-sm outline-none font-mono"
                            style="border: 1px solid var(--color-cream-300); background-color: white; color: var(--color-ink-800)"
                            placeholder="/koleksi"
                        />
                    </div>
                </div>

                <!-- Background image -->
                <div>
                    <ImageUpload
                        v-model="form.image"
                        label="Gambar Latar"
                        hint="Gambar akan ditampilkan sebagai latar hero dengan overlay gelap. Rekomendasi: landscape, min 1920×1080px."
                        :current-image="hero?.image ?? null"
                    />
                    <p v-if="form.errors.image" class="text-xs mt-1" style="color: #dc2626">{{ form.errors.image }}</p>
                </div>

                <!-- Submit — rata kanan -->
                <div class="flex items-center justify-end gap-3 pt-2" style="border-top: 1px solid var(--color-cream-200)">
                    <a href="/admin" class="px-5 py-2.5 rounded-xl text-sm font-medium transition-all hover:opacity-80" style="background-color: var(--color-cream-100); color: var(--color-ink-600)">
                        Batal
                    </a>
                    <button
                        type="submit"
                        :disabled="form.processing"
                        class="px-6 py-2.5 rounded-xl text-sm font-semibold text-white transition-all hover:opacity-90 disabled:opacity-50"
                        style="background-color: var(--color-forest-800)"
                    >
                        {{ form.processing ? 'Menyimpan...' : 'Simpan Hero' }}
                    </button>
                </div>
            </form>
        </div>
    </AdminLayout>
</template>
