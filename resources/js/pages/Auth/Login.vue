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

    <div class="grid min-h-screen grid-cols-1 lg:grid-cols-2">
        <!-- Left: Branding panel -->
        <div
            class="relative hidden flex-col justify-between overflow-hidden p-12 lg:flex"
            style="background-color: var(--color-forest-900)"
        >
            <div
                class="absolute inset-0 opacity-5"
                style="
                    background-image: radial-gradient(
                        circle at 1px 1px,
                        var(--color-cream-200) 1px,
                        transparent 0
                    );
                    background-size: 32px 32px;
                "
            />
            <div class="relative">
                <div class="flex items-center gap-2.5">
                    <img
                        src="/assets/logo.png"
                        alt="Gayatri's"
                        class="h-8 w-8 flex-shrink-0 rounded-full object-contain"
                    />
                    <span
                        style="
                            font-family: var(--font-serif);
                            color: var(--color-cream-100);
                            font-weight: 600;
                            font-size: 1rem;
                        "
                        >Gayatri's</span
                    >
                </div>
            </div>
            <div class="relative">
                <p
                    class="mb-5 text-xs font-semibold tracking-[0.2em] uppercase"
                    style="color: var(--color-sage-400)"
                >
                    Admin Panel
                </p>
                <h2
                    class="mb-4 text-3xl leading-tight font-semibold"
                    style="
                        font-family: var(--font-serif);
                        color: var(--color-cream-100);
                    "
                >
                    Kelola karya,<br />ceritakan dunia.
                </h2>
                <p
                    class="text-sm leading-relaxed"
                    style="color: var(--color-stone-400)"
                >
                    Ruang khusus untuk mengelola tulisan, koleksi, dan profil
                    penulis dengan mudah.
                </p>
            </div>
            <div class="relative">
                <p class="text-xs" style="color: var(--color-stone-600)">
                    &copy; {{ new Date().getFullYear() }} Gayatri's
                </p>
            </div>
        </div>

        <!-- Right: Form panel -->
        <div
            class="flex items-center justify-center px-6 py-12"
            style="background-color: var(--color-cream-50)"
        >
            <div class="w-full max-w-sm">
                <!-- Mobile logo -->
                <div class="mb-10 flex items-center gap-2.5 lg:hidden">
                    <img
                        src="/assets/logo.png"
                        alt="Gayatri's"
                        class="h-7 w-7 flex-shrink-0 rounded-full object-contain"
                    />
                    <span
                        style="
                            font-family: var(--font-serif);
                            color: var(--color-forest-800);
                            font-weight: 600;
                        "
                        >Gayatri's</span
                    >
                </div>

                <h1
                    class="mb-1 text-2xl font-semibold"
                    style="
                        font-family: var(--font-serif);
                        color: var(--color-ink-900);
                    "
                >
                    Masuk
                </h1>
                <p class="mb-8 text-sm" style="color: var(--color-ink-400)">
                    Masukkan kredensial untuk mengakses panel admin.
                </p>

                <!-- Status -->
                <div
                    v-if="status"
                    class="mb-5 rounded-xl px-4 py-3 text-sm"
                    style="background-color: #dcfce7; color: #15803d"
                >
                    {{ status }}
                </div>

                <form @submit.prevent="submit" class="space-y-4">
                    <!-- Email -->
                    <div>
                        <label
                            for="email"
                            class="mb-1.5 block text-sm font-medium"
                            style="color: var(--color-ink-700)"
                            >Email</label
                        >
                        <input
                            id="email"
                            v-model="form.email"
                            type="email"
                            required
                            autofocus
                            autocomplete="username"
                            placeholder="admin@sucipuisi.com"
                            class="w-full rounded-xl px-4 py-3 text-sm transition-all outline-none"
                            :style="
                                form.errors.email
                                    ? 'border: 1px solid #fca5a5; background-color: #fef2f2; color: var(--color-ink-800)'
                                    : 'border: 1px solid var(--color-cream-300); background-color: white; color: var(--color-ink-800)'
                            "
                        />
                        <p
                            v-if="form.errors.email"
                            class="mt-1.5 text-xs"
                            style="color: #dc2626"
                        >
                            {{ form.errors.email }}
                        </p>
                    </div>

                    <!-- Password -->
                    <div>
                        <label
                            for="password"
                            class="mb-1.5 block text-sm font-medium"
                            style="color: var(--color-ink-700)"
                            >Password</label
                        >
                        <input
                            id="password"
                            v-model="form.password"
                            type="password"
                            required
                            autocomplete="current-password"
                            placeholder="••••••••"
                            class="w-full rounded-xl px-4 py-3 text-sm transition-all outline-none"
                            :style="
                                form.errors.password
                                    ? 'border: 1px solid #fca5a5; background-color: #fef2f2; color: var(--color-ink-800)'
                                    : 'border: 1px solid var(--color-cream-300); background-color: white; color: var(--color-ink-800)'
                            "
                        />
                        <p
                            v-if="form.errors.password"
                            class="mt-1.5 text-xs"
                            style="color: #dc2626"
                        >
                            {{ form.errors.password }}
                        </p>
                    </div>

                    <!-- Remember -->
                    <div class="flex items-center gap-2.5">
                        <button
                            type="button"
                            :aria-checked="form.remember"
                            role="checkbox"
                            class="flex h-4 w-4 flex-shrink-0 items-center justify-center rounded transition-colors"
                            :style="
                                form.remember
                                    ? 'background-color: var(--color-sage-600); border: 1px solid var(--color-sage-600)'
                                    : 'background-color: white; border: 1px solid var(--color-cream-300)'
                            "
                            @click="form.remember = !form.remember"
                        >
                            <svg
                                v-if="form.remember"
                                class="h-2.5 w-2.5 text-white"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="3"
                                    d="M5 13l4 4L19 7"
                                />
                            </svg>
                        </button>
                        <span
                            class="text-sm"
                            style="color: var(--color-ink-600)"
                            >Ingat saya</span
                        >
                    </div>

                    <!-- Submit -->
                    <button
                        type="submit"
                        :disabled="form.processing"
                        class="mt-2 w-full rounded-xl py-3 text-sm font-medium text-white transition-all"
                        :style="
                            form.processing
                                ? 'background-color: var(--color-sage-400); cursor: not-allowed'
                                : 'background-color: var(--color-forest-800); cursor: pointer'
                        "
                    >
                        {{
                            form.processing
                                ? 'Masuk...'
                                : 'Masuk ke Panel Admin'
                        }}
                    </button>
                </form>

                <div class="mt-8 text-center">
                    <a
                        href="/"
                        class="text-xs transition-colors"
                        style="color: var(--color-ink-400)"
                        >← Kembali ke beranda</a
                    >
                </div>
            </div>
        </div>
    </div>
</template>
