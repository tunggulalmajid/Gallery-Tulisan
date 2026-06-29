import { usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import type { PageProps } from '@/types';

interface SeoOptions {
    title: string;
    description?: string;
    /** Path relatif dari storage, mis. "thumbnails/foo.jpg" */
    imagePath?: string | null;
    /** Path URL, mis. "/koleksi/puisi-hujan" */
    urlPath?: string;
    type?: 'website' | 'article';
    publishedAt?: string | null;
    author?: string | null;
}

interface SeoMeta {
    title: string;
    description: string;
    image: string | null;
    url: string;
    type: 'website' | 'article';
    publishedAt: string | null;
    author: string | null;
}

export function useSeo(options: SeoOptions) {
    const page = usePage<PageProps>();

    const appName = computed(() => {
        const name = page.props.appName;

        return typeof name === 'string'
            ? name
            : (import.meta.env.VITE_APP_NAME ?? 'SuciPuisi');
    });

    const appUrl = computed(() => {
        const url = page.props.appUrl;

        return typeof url === 'string' ? url.replace(/\/$/, '') : '';
    });

    const meta = computed<SeoMeta>(() => {
        const title = options.title
            ? `${options.title} - ${appName.value}`
            : appName.value;
        const description =
            options.description ??
            `${appName.value} — kumpulan puisi, pantun, dan tulisan sastra.`;
        const image = options.imagePath
            ? `${appUrl.value}/storage/${options.imagePath}`
            : null;
        const url = options.urlPath
            ? `${appUrl.value}${options.urlPath}`
            : appUrl.value;

        return {
            title,
            description,
            image,
            url,
            type: options.type ?? 'website',
            publishedAt: options.publishedAt ?? null,
            author: options.author ?? null,
        };
    });

    return { meta, appName };
}
