<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';
import ImageUpload from '@/Components/ImageUpload.vue';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import type { HeroSection } from '@/types';

const props = defineProps<{
    hero: HeroSection | null;
}>();

const form = useForm({
    heading: props.hero?.heading ?? '',
    subheading: props.hero?.subheading ?? '',
    body: props.hero?.body ?? '',
    cta_label: props.hero?.cta_label ?? '',
    cta_url: props.hero?.cta_url ?? '/koleksi',
    image: null as File | null,
    is_active: props.hero?.is_active ?? true,
});

function submit() {
    form.post('/admin/hero', { forceFormData: true });
}
</script>

<template>
    <AdminLayout>
        <template #header>
            <h1
                class="text-base font-semibold"
                style="
                    font-family: var(--font-serif);
                    color: var(--color-ink-800);
                "
            >
                Hero Section
            </h1>
        </template>

        <div class="max-w-3xl">
            <!-- Preview card -->
            <div
                class="relative mb-6 h-40 overflow-hidden rounded-2xl"
                style="background-color: var(--color-forest-900)"
            >
                <div v-if="hero?.image && !form.image" class="absolute inset-0">
                    <img
                        :src="`/storage/${hero.image}`"
                        alt="Hero preview"
                        class="h-full w-full object-cover opacity-30"
                    />
                    <div
                        class="absolute inset-0"
                        style="
                            background: linear-gradient(
                                to right,
                                rgba(26, 42, 26, 0.9),
                                transparent
                            );
                        "
                    />
                </div>
                <div class="absolute inset-0 flex flex-col justify-center px-8">
                    <p
                        class="mb-1 text-xs font-semibold tracking-widest uppercase"
                        style="color: var(--color-sage-400)"
                    >
                        {{ form.subheading || 'Karya pribadi' }}
                    </p>
                    <h2
                        class="text-xl font-semibold"
                        style="
                            font-family: var(--font-serif);
                            color: var(--color-cream-100);
                        "
                    >
                        {{ form.heading || 'Judul hero section...' }}
                    </h2>
                    <p
                        class="mt-1 text-xs"
                        style="color: var(--color-stone-400)"
                    >
                        {{ form.body || 'Deskripsi singkat...' }}
                    </p>
                </div>
                <div class="absolute top-3 right-3">
                    <span
                        class="rounded-full px-2 py-1 text-xs"
                        style="
                            background-color: rgba(255, 255, 255, 0.1);
                            color: var(--color-stone-400);
                        "
                        >Preview</span
                    >
                </div>
            </div>

            <form @submit.prevent="submit" class="space-y-5">
                <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                    <!-- Heading -->
                    <div class="sm:col-span-2">
                        <label
                            class="mb-1.5 block text-sm font-medium"
                            style="color: var(--color-ink-700)"
                        >
                            Judul Utama <span style="color: #ef4444">*</span>
                        </label>
                        <input
                            v-model="form.heading"
                            type="text"
                            class="w-full rounded-xl px-4 py-2.5 text-sm outline-none"
                            style="
                                border: 1px solid var(--color-cream-300);
                                background-color: white;
                                color: var(--color-ink-800);
                            "
                            placeholder="Setiap Kata adalah Jejak Rasa"
                        />
                        <p
                            v-if="form.errors.heading"
                            class="mt-1 text-xs"
                            style="color: #dc2626"
                        >
                            {{ form.errors.heading }}
                        </p>
                    </div>

                    <!-- Subheading -->
                    <div>
                        <label
                            class="mb-1.5 block text-sm font-medium"
                            style="color: var(--color-ink-700)"
                            >Sub-judul</label
                        >
                        <input
                            v-model="form.subheading"
                            type="text"
                            class="w-full rounded-xl px-4 py-2.5 text-sm outline-none"
                            style="
                                border: 1px solid var(--color-cream-300);
                                background-color: white;
                                color: var(--color-ink-800);
                            "
                            placeholder="Karya pribadi Suci"
                        />
                    </div>

                    <!-- Active toggle -->
                    <div class="flex items-end pb-1">
                        <div class="flex items-center gap-3">
                            <div
                                class="relative h-5 w-10 flex-shrink-0 cursor-pointer rounded-full transition-colors"
                                :style="
                                    form.is_active
                                        ? 'background-color: var(--color-sage-500)'
                                        : 'background-color: var(--color-cream-300)'
                                "
                                @click="form.is_active = !form.is_active"
                            >
                                <div
                                    class="absolute top-0.5 h-4 w-4 rounded-full bg-white shadow transition-transform"
                                    :class="
                                        form.is_active
                                            ? 'translate-x-5'
                                            : 'translate-x-0.5'
                                    "
                                />
                            </div>
                            <div>
                                <p
                                    class="text-sm font-medium"
                                    style="color: var(--color-ink-700)"
                                >
                                    Tampilkan Hero
                                </p>
                                <p
                                    class="text-xs"
                                    style="color: var(--color-ink-400)"
                                >
                                    {{
                                        form.is_active
                                            ? 'Aktif ditampilkan'
                                            : 'Disembunyikan'
                                    }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Body -->
                <div>
                    <label
                        class="mb-1.5 block text-sm font-medium"
                        style="color: var(--color-ink-700)"
                        >Deskripsi</label
                    >
                    <textarea
                        v-model="form.body"
                        rows="3"
                        class="w-full resize-none rounded-xl px-4 py-2.5 text-sm outline-none"
                        style="
                            border: 1px solid var(--color-cream-300);
                            background-color: white;
                            color: var(--color-ink-800);
                        "
                        placeholder="Kumpulan puisi, pantun, dan cerita yang lahir dari ruang paling sunyi..."
                    />
                </div>

                <!-- CTA -->
                <div
                    class="grid grid-cols-1 gap-5 rounded-2xl p-5 sm:grid-cols-2"
                    style="
                        background-color: var(--color-cream-50);
                        border: 1px solid var(--color-cream-200);
                    "
                >
                    <div>
                        <p
                            class="mb-3 text-xs font-semibold tracking-wider uppercase"
                            style="color: var(--color-ink-500)"
                        >
                            Tombol CTA
                        </p>
                        <label
                            class="mb-1 block text-xs"
                            style="color: var(--color-ink-600)"
                            >Label Tombol</label
                        >
                        <input
                            v-model="form.cta_label"
                            type="text"
                            class="w-full rounded-lg px-3 py-2 text-sm outline-none"
                            style="
                                border: 1px solid var(--color-cream-300);
                                background-color: white;
                                color: var(--color-ink-800);
                            "
                            placeholder="Jelajahi Karya"
                        />
                    </div>
                    <div>
                        <p
                            class="invisible mb-3 text-xs font-semibold tracking-wider uppercase"
                        >
                            x
                        </p>
                        <label
                            class="mb-1 block text-xs"
                            style="color: var(--color-ink-600)"
                            >URL Tombol</label
                        >
                        <input
                            v-model="form.cta_url"
                            type="text"
                            class="w-full rounded-lg px-3 py-2 font-mono text-sm outline-none"
                            style="
                                border: 1px solid var(--color-cream-300);
                                background-color: white;
                                color: var(--color-ink-800);
                            "
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
                    <p
                        v-if="form.errors.image"
                        class="mt-1 text-xs"
                        style="color: #dc2626"
                    >
                        {{ form.errors.image }}
                    </p>
                </div>

                <!-- Submit — rata kanan -->
                <div
                    class="flex items-center justify-end gap-3 pt-2"
                    style="border-top: 1px solid var(--color-cream-200)"
                >
                    <a
                        href="/admin"
                        class="rounded-xl px-5 py-2.5 text-sm font-medium transition-all hover:opacity-80"
                        style="
                            background-color: var(--color-cream-100);
                            color: var(--color-ink-600);
                        "
                    >
                        Batal
                    </a>
                    <button
                        type="submit"
                        :disabled="form.processing"
                        class="rounded-xl px-6 py-2.5 text-sm font-semibold text-white transition-all hover:opacity-90 disabled:opacity-50"
                        style="background-color: var(--color-forest-800)"
                    >
                        {{ form.processing ? 'Menyimpan...' : 'Simpan Hero' }}
                    </button>
                </div>
            </form>
        </div>
    </AdminLayout>
</template>
