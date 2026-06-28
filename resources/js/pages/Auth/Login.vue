<script setup lang="ts">
import { Link, router } from '@inertiajs/vue3';
import { Head, useForm } from '@inertiajs/vue3';

defineProps<{
    status?: string;
}>();

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <Head title="Masuk" />

    <div class="min-h-screen grid grid-cols-1 lg:grid-cols-2">
        <!-- Left: Branding panel -->
        <div class="hidden lg:flex flex-col justify-between p-12 relative overflow-hidden" style="background-color: var(--color-forest-900)">
            <div class="absolute inset-0 opacity-5" style="background-image: radial-gradient(circle at 1px 1px, var(--color-cream-200) 1px, transparent 0); background-size: 32px 32px"/>
            <div class="relative">
                <div class="flex items-center gap-2.5">
                    <img src="/assets/logo.png" alt="Gayatri's" class="w-8 h-8 rounded-full object-contain flex-shrink-0" />
                    <span style="font-family: var(--font-serif); color: var(--color-cream-100); font-weight: 600; font-size: 1rem">Gayatri's</span>
                </div>
            </div>
            <div class="relative">
                <p class="text-xs font-semibold tracking-[0.2em] uppercase mb-5" style="color: var(--color-sage-400)">Admin Panel</p>
                <h2 class="text-3xl font-semibold leading-tight mb-4" style="font-family: var(--font-serif); color: var(--color-cream-100)">
                    Kelola karya,<br>ceritakan dunia.
                </h2>
                <p class="text-sm leading-relaxed" style="color: var(--color-stone-400)">
                    Ruang khusus untuk mengelola tulisan, koleksi, dan profil penulis dengan mudah.
                </p>
            </div>
            <div class="relative">
                <p class="text-xs" style="color: var(--color-stone-600)">&copy; {{ new Date().getFullYear() }} Gayatri's</p>
            </div>
        </div>

        <!-- Right: Form panel -->
        <div class="flex items-center justify-center px-6 py-12" style="background-color: var(--color-cream-50)">
            <div class="w-full max-w-sm">
                <!-- Mobile logo -->
                <div class="flex items-center gap-2.5 mb-10 lg:hidden">
                    <img src="/assets/logo.png" alt="Gayatri's" class="w-7 h-7 rounded-full object-contain flex-shrink-0" />
                    <span style="font-family: var(--font-serif); color: var(--color-forest-800); font-weight: 600">Gayatri's</span>
                </div>

                <h1 class="text-2xl font-semibold mb-1" style="font-family: var(--font-serif); color: var(--color-ink-900)">Masuk</h1>
                <p class="text-sm mb-8" style="color: var(--color-ink-400)">Masukkan kredensial untuk mengakses panel admin.</p>

                <!-- Status -->
                <div v-if="status" class="mb-5 px-4 py-3 rounded-xl text-sm" style="background-color: #dcfce7; color: #15803d">
                    {{ status }}
                </div>

                <form @submit.prevent="submit" class="space-y-4">
                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium mb-1.5" style="color: var(--color-ink-700)">Email</label>
                        <input
                            id="email"
                            v-model="form.email"
                            type="email"
                            required
                            autofocus
                            autocomplete="username"
                            placeholder="admin@sucipuisi.com"
                            class="w-full px-4 py-3 rounded-xl text-sm outline-none transition-all"
                            :style="form.errors.email
                                ? 'border: 1px solid #fca5a5; background-color: #fef2f2; color: var(--color-ink-800)'
                                : 'border: 1px solid var(--color-cream-300); background-color: white; color: var(--color-ink-800)'"
                        />
                        <p v-if="form.errors.email" class="text-xs mt-1.5" style="color: #dc2626">{{ form.errors.email }}</p>
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-medium mb-1.5" style="color: var(--color-ink-700)">Password</label>
                        <input
                            id="password"
                            v-model="form.password"
                            type="password"
                            required
                            autocomplete="current-password"
                            placeholder="••••••••"
                            class="w-full px-4 py-3 rounded-xl text-sm outline-none transition-all"
                            :style="form.errors.password
                                ? 'border: 1px solid #fca5a5; background-color: #fef2f2; color: var(--color-ink-800)'
                                : 'border: 1px solid var(--color-cream-300); background-color: white; color: var(--color-ink-800)'"
                        />
                        <p v-if="form.errors.password" class="text-xs mt-1.5" style="color: #dc2626">{{ form.errors.password }}</p>
                    </div>

                    <!-- Remember -->
                    <div class="flex items-center gap-2.5">
                        <button
                            type="button"
                            :aria-checked="form.remember"
                            role="checkbox"
                            class="w-4 h-4 rounded flex items-center justify-center flex-shrink-0 transition-colors"
                            :style="form.remember
                                ? 'background-color: var(--color-sage-600); border: 1px solid var(--color-sage-600)'
                                : 'background-color: white; border: 1px solid var(--color-cream-300)'"
                            @click="form.remember = !form.remember"
                        >
                            <svg v-if="form.remember" class="w-2.5 h-2.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                            </svg>
                        </button>
                        <span class="text-sm" style="color: var(--color-ink-600)">Ingat saya</span>
                    </div>

                    <!-- Submit -->
                    <button
                        type="submit"
                        :disabled="form.processing"
                        class="w-full py-3 rounded-xl text-sm font-medium text-white transition-all mt-2"
                        :style="form.processing
                            ? 'background-color: var(--color-sage-400); cursor: not-allowed'
                            : 'background-color: var(--color-forest-800); cursor: pointer'"
                    >
                        {{ form.processing ? 'Masuk...' : 'Masuk ke Panel Admin' }}
                    </button>
                </form>

                <div class="mt-8 text-center">
                    <a href="/" class="text-xs transition-colors" style="color: var(--color-ink-400)">← Kembali ke beranda</a>
                </div>
            </div>
        </div>
    </div>
</template>
