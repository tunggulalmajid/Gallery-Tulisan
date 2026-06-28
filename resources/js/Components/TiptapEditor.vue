<script setup lang="ts">
import { useEditor, EditorContent } from '@tiptap/vue-3';
import StarterKit from '@tiptap/starter-kit';
import Image from '@tiptap/extension-image';
import Link from '@tiptap/extension-link';
import Youtube from '@tiptap/extension-youtube';
import Placeholder from '@tiptap/extension-placeholder';
import TextAlign from '@tiptap/extension-text-align';
import Underline from '@tiptap/extension-underline';
import { ref, watch, onBeforeUnmount } from 'vue';
import axios from 'axios';

const props = defineProps<{
    modelValue: string;
    placeholder?: string;
}>();

const emit = defineEmits<{
    'update:modelValue': [value: string];
}>();

const imageInput = ref<HTMLInputElement | null>(null);
const youtubeUrl = ref('');
const showYoutubeModal = ref(false);
const uploading = ref(false);

const editor = useEditor({
    content: props.modelValue,
    extensions: [
        StarterKit,
        Underline,
        TextAlign.configure({ types: ['heading', 'paragraph'] }),
        Placeholder.configure({ placeholder: props.placeholder ?? 'Mulai menulis karya indahmu...' }),
        Image.configure({ inline: false, allowBase64: true }),
        Link.configure({ openOnClick: false, HTMLAttributes: { rel: 'noopener noreferrer', target: '_blank' } }),
        Youtube.configure({ width: 640, height: 360, nocookie: true }),
    ],
    onUpdate({ editor }) {
        emit('update:modelValue', editor.getHTML());
    },
});

watch(() => props.modelValue, (val) => {
    if (editor.value && editor.value.getHTML() !== val) {
        editor.value.commands.setContent(val, false);
    }
});

onBeforeUnmount(() => editor.value?.destroy());

async function uploadImage(e: Event) {
    const file = (e.target as HTMLInputElement).files?.[0];
    if (!file || !editor.value) return;
    uploading.value = true;
    try {
        const formData = new FormData();
        formData.append('image', file);
        const res = await axios.post('/admin/writings/upload-image', formData);
        editor.value.chain().focus().setImage({ src: res.data.url }).run();
    } finally {
        uploading.value = false;
        if (imageInput.value) imageInput.value.value = '';
    }
}

function insertYoutube() {
    if (!youtubeUrl.value || !editor.value) return;
    editor.value.chain().focus().setYoutubeVideo({ src: youtubeUrl.value }).run();
    youtubeUrl.value = '';
    showYoutubeModal.value = false;
}

function setLink() {
    if (!editor.value) return;
    const prev = editor.value.getAttributes('link').href;
    const url = window.prompt('URL Link', prev);
    if (url === null) return;
    if (url === '') {
        editor.value.chain().focus().extendMarkRange('link').unsetLink().run();
        return;
    }
    editor.value.chain().focus().extendMarkRange('link').setLink({ href: url }).run();
}

type BtnAction = () => void;
interface ToolBtn { label: string; title: string; action: BtnAction; active?: boolean; }

function toolButtons(): ToolBtn[] {
    if (!editor.value) return [];
    const e = editor.value;
    return [
        { label: 'B', title: 'Bold', action: () => e.chain().focus().toggleBold().run(), active: e.isActive('bold') },
        { label: 'I', title: 'Italic', action: () => e.chain().focus().toggleItalic().run(), active: e.isActive('italic') },
        { label: 'U', title: 'Underline', action: () => e.chain().focus().toggleUnderline().run(), active: e.isActive('underline') },
        { label: 'H2', title: 'Heading 2', action: () => e.chain().focus().toggleHeading({ level: 2 }).run(), active: e.isActive('heading', { level: 2 }) },
        { label: 'H3', title: 'Heading 3', action: () => e.chain().focus().toggleHeading({ level: 3 }).run(), active: e.isActive('heading', { level: 3 }) },
        { label: '❝', title: 'Blockquote', action: () => e.chain().focus().toggleBlockquote().run(), active: e.isActive('blockquote') },
        { label: '≡L', title: 'Rata Kiri', action: () => e.chain().focus().setTextAlign('left').run(), active: e.isActive({ textAlign: 'left' }) },
        { label: '≡C', title: 'Rata Tengah', action: () => e.chain().focus().setTextAlign('center').run(), active: e.isActive({ textAlign: 'center' }) },
        { label: '≡R', title: 'Rata Kanan', action: () => e.chain().focus().setTextAlign('right').run(), active: e.isActive({ textAlign: 'right' }) },
    ];
}
</script>

<template>
    <div class="tiptap-editor rounded-xl overflow-hidden" style="border: 1px solid var(--color-cream-300); background-color: white">
        <!-- Toolbar -->
        <div class="flex flex-wrap items-center gap-1 px-3 py-2 border-b" style="background-color: var(--color-cream-50); border-color: var(--color-cream-200)">
            <!-- Text formatting buttons -->
            <button
                v-for="btn in toolButtons()"
                :key="btn.title"
                type="button"
                :title="btn.title"
                class="px-2 py-1 rounded text-xs font-semibold transition-colors"
                :style="btn.active
                    ? 'background-color: var(--color-blush-100); color: var(--color-blush-700);'
                    : 'color: var(--color-ink-600);'"
                @click="btn.action"
            >
                {{ btn.label }}
            </button>

            <div class="w-px h-5 mx-1" style="background-color: var(--color-cream-300)" />

            <!-- Link -->
            <button
                type="button"
                title="Tambah Link"
                class="px-2 py-1 rounded text-xs transition-colors"
                :style="editor?.isActive('link')
                    ? 'background-color: var(--color-blush-100); color: var(--color-blush-700);'
                    : 'color: var(--color-ink-600);'"
                @click="setLink"
            >
                🔗
            </button>

            <!-- Image upload -->
            <button
                type="button"
                title="Upload Gambar"
                class="px-2 py-1 rounded text-xs transition-colors"
                style="color: var(--color-ink-600)"
                :disabled="uploading"
                @click="imageInput?.click()"
            >
                {{ uploading ? '⏳' : '🖼️' }}
            </button>
            <input ref="imageInput" type="file" accept="image/*" class="hidden" @change="uploadImage" />

            <!-- YouTube -->
            <button
                type="button"
                title="Embed YouTube"
                class="px-2 py-1 rounded text-xs transition-colors"
                style="color: var(--color-ink-600)"
                @click="showYoutubeModal = true"
            >
                ▶️
            </button>

            <div class="w-px h-5 mx-1" style="background-color: var(--color-cream-300)" />

            <!-- Undo / Redo -->
            <button type="button" title="Undo" class="px-2 py-1 rounded text-xs" style="color: var(--color-ink-600)" @click="editor?.chain().focus().undo().run()">↩</button>
            <button type="button" title="Redo" class="px-2 py-1 rounded text-xs" style="color: var(--color-ink-600)" @click="editor?.chain().focus().redo().run()">↪</button>
        </div>

        <!-- Editor -->
        <EditorContent :editor="editor" class="prose-writing" />
    </div>

    <!-- YouTube modal -->
    <div v-if="showYoutubeModal" class="fixed inset-0 z-50 flex items-center justify-center" style="background-color: rgba(0,0,0,0.4)">
        <div class="w-full max-w-md mx-4 rounded-2xl p-6" style="background-color: white">
            <h3 class="text-base font-semibold mb-4" style="font-family: var(--font-serif); color: var(--color-ink-800)">Embed Video YouTube</h3>
            <input
                v-model="youtubeUrl"
                type="url"
                placeholder="https://www.youtube.com/watch?v=..."
                class="w-full px-4 py-2.5 rounded-lg text-sm outline-none"
                style="border: 1px solid var(--color-cream-300); background-color: var(--color-cream-50); color: var(--color-ink-800)"
            />
            <div class="flex justify-end gap-2 mt-4">
                <button type="button" class="px-4 py-2 rounded-lg text-sm" style="color: var(--color-ink-500)" @click="showYoutubeModal = false">Batal</button>
                <button type="button" class="px-4 py-2 rounded-lg text-sm text-white" style="background-color: var(--color-blush-500)" @click="insertYoutube">Tambahkan</button>
            </div>
        </div>
    </div>
</template>
