<script setup lang="ts">
import AdminLayout from '@/Layouts/AdminLayout.vue';
import ImageUpload from '@/Components/ImageUpload.vue';
import { useForm } from '@inertiajs/vue3';
import type { AuthorProfile } from '@/types';

const props = defineProps<{
    profile: AuthorProfile | null;
}>();

const form = useForm({
    name:      props.profile?.name ?? '',
    photo:     null as File | null,
    bio:       props.profile?.bio ?? '',
    tagline:   props.profile?.tagline ?? '',
    instagram: props.profile?.instagram ?? '',
    twitter:   props.profile?.twitter ?? '',
    email:     props.profile?.email ?? '',
});

function submit() {
    form.post('/admin/profile', { forceFormData: true });
}
</script>

<template>
    <AdminLayout>
        <template #header>
            <h1 class="text-base font-semibold" style="font-family: var(--font-serif); color: var(--color-ink-800)">Profil Penulis</h1>
        </template>

        <div class="max-w-2xl">
            <form @submit.prevent="submit" class="space-y-5">

                <!-- Foto profil -->
                <div>
                    <ImageUpload
                        v-model="form.photo"
                        label="Foto Profil"
                        hint="Gunakan foto persegi. Akan ditampilkan sebagai avatar bundar."
                        :current-image="profile?.photo ?? null"
                    />
                    <p v-if="form.errors.photo" class="text-xs mt-1" style="color: #dc2626">{{ form.errors.photo }}</p>
                </div>

                <!-- Nama -->
                <div>
                    <label class="block text-sm font-medium mb-1.5" style="color: var(--color-ink-700)">Nama <span style="color: #ef4444">*</span></label>
                    <input
                        v-model="form.name"
                        type="text"
                        class="w-full px-4 py-2.5 rounded-xl text-sm outline-none"
                        style="border: 1px solid var(--color-cream-300); background-color: var(--color-cream-50); color: var(--color-ink-800)"
                        placeholder="Nama penulis"
                    />
                    <p v-if="form.errors.name" class="text-xs mt-1" style="color: #dc2626">{{ form.errors.name }}</p>
                </div>

                <!-- Tagline -->
                <div>
                    <label class="block text-sm font-medium mb-1.5" style="color: var(--color-ink-700)">Tagline</label>
                    <input
                        v-model="form.tagline"
                        type="text"
                        class="w-full px-4 py-2.5 rounded-xl text-sm outline-none"
                        style="border: 1px solid var(--color-cream-300); background-color: var(--color-cream-50); color: var(--color-ink-800)"
                        placeholder="Menulis adalah cara saya bernafas."
                    />
                    <p v-if="form.errors.tagline" class="text-xs mt-1" style="color: #dc2626">{{ form.errors.tagline }}</p>
                </div>

                <!-- Bio -->
                <div>
                    <label class="block text-sm font-medium mb-1.5" style="color: var(--color-ink-700)">Bio</label>
                    <textarea
                        v-model="form.bio"
                        rows="5"
                        class="w-full px-4 py-2.5 rounded-xl text-sm outline-none resize-none"
                        style="border: 1px solid var(--color-cream-300); background-color: var(--color-cream-50); color: var(--color-ink-800)"
                        placeholder="Ceritakan sedikit tentang dirimu..."
                    />
                    <p v-if="form.errors.bio" class="text-xs mt-1" style="color: #dc2626">{{ form.errors.bio }}</p>
                </div>

                <!-- Media Sosial -->
                <div class="rounded-2xl p-5 space-y-4" style="background-color: var(--color-cream-50); border: 1px solid var(--color-cream-200)">
                    <h3 class="text-sm font-semibold" style="color: var(--color-ink-700)">Media Sosial</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs mb-1.5" style="color: var(--color-ink-500)">Instagram</label>
                            <div class="flex items-center rounded-xl overflow-hidden" style="border: 1px solid var(--color-cream-300); background-color: white">
                                <span class="px-3 text-sm" style="color: var(--color-ink-400)">@</span>
                                <input v-model="form.instagram" type="text" class="flex-1 py-2.5 pr-3 text-sm outline-none" style="color: var(--color-ink-800)" placeholder="username"/>
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs mb-1.5" style="color: var(--color-ink-500)">Twitter / X</label>
                            <div class="flex items-center rounded-xl overflow-hidden" style="border: 1px solid var(--color-cream-300); background-color: white">
                                <span class="px-3 text-sm" style="color: var(--color-ink-400)">@</span>
                                <input v-model="form.twitter" type="text" class="flex-1 py-2.5 pr-3 text-sm outline-none" style="color: var(--color-ink-800)" placeholder="username"/>
                            </div>
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs mb-1.5" style="color: var(--color-ink-500)">Email</label>
                        <input
                            v-model="form.email"
                            type="email"
                            class="w-full px-4 py-2.5 rounded-xl text-sm outline-none"
                            style="border: 1px solid var(--color-cream-300); background-color: white; color: var(--color-ink-800)"
                            placeholder="suci@email.com"
                        />
                        <p v-if="form.errors.email" class="text-xs mt-1" style="color: #dc2626">{{ form.errors.email }}</p>
                    </div>
                </div>

                <!-- Actions — tombol rata kanan (best practice) -->
                <div class="flex items-center justify-end gap-3 pt-2" style="border-top: 1px solid var(--color-cream-200)">
                    <a
                        href="/admin"
                        class="px-5 py-2.5 rounded-xl text-sm font-medium transition-all hover:opacity-80"
                        style="background-color: var(--color-cream-100); color: var(--color-ink-600)"
                    >
                        Batal
                    </a>
                    <button
                        type="submit"
                        :disabled="form.processing"
                        class="px-6 py-2.5 rounded-xl text-sm font-semibold text-white transition-all hover:opacity-90 disabled:opacity-50"
                        style="background-color: var(--color-forest-800)"
                    >
                        {{ form.processing ? 'Menyimpan...' : 'Simpan Profil' }}
                    </button>
                </div>
            </form>
        </div>
    </AdminLayout>
</template>
