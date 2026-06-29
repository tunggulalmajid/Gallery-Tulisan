<script setup lang="ts">
import { ref } from 'vue';

const props = defineProps<{
    modelValue: File | null;
    currentImage?: string | null;
    label?: string;
    hint?: string;
    accept?: string;
}>();

const emit = defineEmits<{
    'update:modelValue': [file: File | null];
}>();

const isDragging = ref(false);
const previewUrl = ref<string | null>(null);
const inputRef = ref<HTMLInputElement | null>(null);

function onFileChange(e: Event) {
    const file = (e.target as HTMLInputElement).files?.[0] ?? null;
    setFile(file);
}

function onDrop(e: DragEvent) {
    isDragging.value = false;
    const file = e.dataTransfer?.files?.[0] ?? null;

    if (file && file.type.startsWith('image/')) {
        setFile(file);
    }
}

function setFile(file: File | null) {
    emit('update:modelValue', file);

    if (file) {
        const reader = new FileReader();
        reader.onload = (e) => {
            previewUrl.value = e.target?.result as string;
        };
        reader.readAsDataURL(file);
    } else {
        previewUrl.value = null;
    }
}

function remove() {
    emit('update:modelValue', null);
    previewUrl.value = null;

    if (inputRef.value) {
        inputRef.value.value = '';
    }
}

function imageToShow(): string | null {
    if (previewUrl.value) {
        return previewUrl.value;
    }

    if (props.currentImage) {
        return `/storage/${props.currentImage}`;
    }

    return null;
}
</script>

<template>
    <div>
        <p
            v-if="label"
            class="mb-1.5 text-sm font-medium"
            style="color: var(--color-ink-700)"
        >
            {{ label }}
        </p>
        <p v-if="hint" class="mb-2 text-xs" style="color: var(--color-ink-400)">
            {{ hint }}
        </p>

        <!-- Preview state -->
        <div
            v-if="imageToShow()"
            class="group relative overflow-hidden rounded-xl"
            style="border: 1px solid var(--color-cream-200)"
        >
            <img
                :src="imageToShow()!"
                alt="Preview"
                class="h-44 w-full object-cover"
            />
            <div
                class="absolute inset-0 flex items-center justify-center gap-2 opacity-0 transition-opacity group-hover:opacity-100"
                style="background-color: rgba(0, 0, 0, 0.45)"
            >
                <button
                    type="button"
                    class="rounded-lg px-3 py-1.5 text-xs font-medium"
                    style="background-color: white; color: var(--color-ink-700)"
                    @click="inputRef?.click()"
                >
                    Ganti
                </button>
                <button
                    type="button"
                    class="rounded-lg px-3 py-1.5 text-xs font-medium"
                    style="background-color: #fee2e2; color: #dc2626"
                    @click="remove"
                >
                    Hapus
                </button>
            </div>
        </div>

        <!-- Upload zone -->
        <div
            v-else
            class="upload-zone flex cursor-pointer flex-col items-center justify-center px-6 py-10 text-center"
            :class="{ dragover: isDragging }"
            @click="inputRef?.click()"
            @dragenter.prevent="isDragging = true"
            @dragleave.prevent="isDragging = false"
            @dragover.prevent
            @drop.prevent="onDrop"
        >
            <!-- Icon -->
            <div
                class="mb-3 flex h-12 w-12 items-center justify-center rounded-2xl transition-colors"
                :style="
                    isDragging
                        ? 'background-color: var(--color-sage-200)'
                        : 'background-color: var(--color-sage-100)'
                "
            >
                <svg
                    class="h-5 w-5"
                    :style="
                        isDragging
                            ? 'color: var(--color-sage-600)'
                            : 'color: var(--color-sage-400)'
                    "
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="1.5"
                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"
                    />
                </svg>
            </div>
            <p
                class="mb-1 text-sm font-medium"
                style="color: var(--color-ink-700)"
            >
                {{
                    isDragging
                        ? 'Lepaskan gambar di sini'
                        : 'Klik atau seret gambar'
                }}
            </p>
            <p class="text-xs" style="color: var(--color-ink-400)">
                PNG, JPG, WebP — maks. 2MB
            </p>
        </div>

        <input
            ref="inputRef"
            type="file"
            :accept="accept ?? 'image/*'"
            class="hidden"
            @change="onFileChange"
        />
    </div>
</template>
