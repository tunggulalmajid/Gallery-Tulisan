<script setup lang="ts">
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { useForm } from '@inertiajs/vue3';
import type { AuthorProfile } from '@/types';

const props = defineProps<{
    profile: AuthorProfile | null;
}>();

const form = useForm({
    name:       props.profile?.name ?? '',
    photo:      null as File | null,
    bio:        props.profile?.bio ?? '',
    tagline:    props.profile?.tagline ?? '',
    instagram:  props.profile?.instagram ?? '',
    twitter:    props.profile?.twitter ?? '',
    email:      props.profile?.email ?? '',
});

function submit() {
    form.post('/admin/profile', { forceFormData: true });
}

function onFileChange(e: Event) {
    const file = (e.target as HTMLInputElement).files?.[0] ?? null;
    form.photo = file;
}

function photoUrl(path: string | null): string {
    return path ? `/storage/${path}` : '';
}
</script>

<template>
    <AdminLayout>
        <template #header>
            <h1 class="text-lg font-semibold" style="font-family: var(--font-serif); color: var(--color-ink-800)">Profil Penulis</h1>
        </template>

        <div class="max-w-2xl">
            <form @submit.prevent="submit" class="space-y-5">
                <!-- Photo preview -->
                <div class="flex items-center gap-5">
                    <div class="w-20 h-20 rounded-full overflow-hidden flex-shrink-0" style="border: 2px solid var(--color-cream-300)">
                        <img v-if="profile?.photo && !form.photo" :src="photoUrl(profile.photo)" :alt="profile.name" class="w-full h-full object-cover" />
                        <div v-else class="w-full h-full flex items-center justify-center" style="background: linear-gradient(135deg, var(--color-blush-100), var(--color-mauve-100))">
                            <span style="font-family: var(--font-serif); font-size: 1.8rem; color: var(--color-blush-400)">
                                {{ profile?.name?.charAt(0)?.toUpperCase() ?? 'S' }}
                            </span>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1.5" style="color: var(--color-ink-700)">Foto Profil</label>
                        <input type="file" accept="image/*" class="text-sm" style="color: var(--color-ink-600)" @change="onFileChange" />
                        <p v-if="form.errors.photo" class="text-xs mt-1" style="color: #dc2626">{{ form.errors.photo }}</p>
                    </div>
                </div>

                <!-- Name -->
                <div>
                    <label class="block text-sm font-medium mb-1.5" style="color: var(--color-ink-700)">Nama <span style="color: var(--color-blush-500)">*</span></label>
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

                <!-- Social Media -->
                <div class="rounded-2xl p-5 space-y-4" style="background-color: var(--color-cream-50); border: 1px solid var(--color-cream-200)">
                    <h3 class="text-sm font-semibold" style="color: var(--color-ink-700)">Media Sosial</h3>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs mb-1.5" style="color: var(--color-ink-500)">Instagram (username)</label>
                            <div class="flex items-center rounded-xl overflow-hidden" style="border: 1px solid var(--color-cream-300); background-color: white">
                                <span class="px-3 text-sm" style="color: var(--color-ink-400)">@</span>
                                <input v-model="form.instagram" type="text" class="flex-1 py-2.5 pr-3 text-sm outline-none" style="color: var(--color-ink-800)" placeholder="username" />
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs mb-1.5" style="color: var(--color-ink-500)">Twitter / X (username)</label>
                            <div class="flex items-center rounded-xl overflow-hidden" style="border: 1px solid var(--color-cream-300); background-color: white">
                                <span class="px-3 text-sm" style="color: var(--color-ink-400)">@</span>
                                <input v-model="form.twitter" type="text" class="flex-1 py-2.5 pr-3 text-sm outline-none" style="color: var(--color-ink-800)" placeholder="username" />
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

                <!-- Submit -->
                <div class="flex gap-3 pt-2">
                    <button type="submit" :disabled="form.processing" class="px-6 py-2.5 rounded-xl text-sm text-white transition-all hover:opacity-90 disabled:opacity-50" style="background-color: var(--color-blush-500)">
                        {{ form.processing ? 'Menyimpan...' : 'Simpan Profil' }}
                    </button>
                </div>
            </form>
        </div>
    </AdminLayout>
</template>
