<script setup lang="ts">
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

    <div class="min-h-screen flex items-center justify-center px-4" style="background: linear-gradient(135deg, var(--color-blush-50) 0%, var(--color-mauve-50) 50%, var(--color-cream-100) 100%)">
        <!-- Decorative circles -->
        <div class="fixed -top-20 -right-20 w-80 h-80 rounded-full pointer-events-none" style="background: radial-gradient(circle, var(--color-blush-200), transparent); opacity: 0.4" />
        <div class="fixed -bottom-20 -left-20 w-96 h-96 rounded-full pointer-events-none" style="background: radial-gradient(circle, var(--color-mauve-200), transparent); opacity: 0.3" />

        <div class="w-full max-w-sm relative">
            <!-- Card -->
            <div class="rounded-3xl p-8 shadow-lg" style="background-color: white; border: 1px solid var(--color-cream-200)">
                <!-- Header -->
                <div class="text-center mb-8">
                    <div class="inline-flex items-center justify-center w-14 h-14 rounded-full mb-4" style="background: linear-gradient(135deg, var(--color-blush-100), var(--color-mauve-100))">
                        <span style="font-family: var(--font-serif); font-size: 1.5rem; color: var(--color-blush-600)">✦</span>
                    </div>
                    <h1 class="text-2xl mb-1" style="font-family: var(--font-serif); color: var(--color-ink-900); font-weight: 600">Selamat datang</h1>
                    <p class="text-sm" style="color: var(--color-ink-400)">Masuk untuk mengelola karya tulisanmu</p>
                </div>

                <!-- Status message -->
                <div v-if="status" class="mb-5 px-4 py-3 rounded-xl text-sm text-center" style="background-color: #dcfce7; color: #16a34a">
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
                            class="w-full px-4 py-3 rounded-xl text-sm outline-none transition-shadow"
                            :style="form.errors.email
                                ? 'border: 1px solid #fca5a5; background-color: #fef2f2; color: var(--color-ink-800)'
                                : 'border: 1px solid var(--color-cream-300); background-color: var(--color-cream-50); color: var(--color-ink-800)'"
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
                            class="w-full px-4 py-3 rounded-xl text-sm outline-none transition-shadow"
                            :style="form.errors.password
                                ? 'border: 1px solid #fca5a5; background-color: #fef2f2; color: var(--color-ink-800)'
                                : 'border: 1px solid var(--color-cream-300); background-color: var(--color-cream-50); color: var(--color-ink-800)'"
                        />
                        <p v-if="form.errors.password" class="text-xs mt-1.5" style="color: #dc2626">{{ form.errors.password }}</p>
                    </div>

                    <!-- Remember me -->
                    <div class="flex items-center gap-2.5">
                        <button
                            type="button"
                            role="checkbox"
                            :aria-checked="form.remember"
                            class="w-4 h-4 rounded flex items-center justify-center flex-shrink-0 transition-colors"
                            :style="form.remember
                                ? 'background-color: var(--color-blush-500); border: 1px solid var(--color-blush-500)'
                                : 'background-color: white; border: 1px solid var(--color-cream-300)'"
                            @click="form.remember = !form.remember"
                        >
                            <svg v-if="form.remember" class="w-2.5 h-2.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
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
                            ? 'background-color: var(--color-blush-300); cursor: not-allowed'
                            : 'background-color: var(--color-blush-500); cursor: pointer'"
                    >
                        {{ form.processing ? 'Masuk...' : 'Masuk' }}
                    </button>
                </form>
            </div>

            <!-- Back to home -->
            <div class="text-center mt-5">
                <a href="/" class="text-xs transition-colors" style="color: var(--color-ink-400)">
                    ← Kembali ke beranda
                </a>
            </div>
        </div>
    </div>
</template>
