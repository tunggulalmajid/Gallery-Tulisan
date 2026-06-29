import type { User } from './auth';

export interface Collection {
    id: number;
    title: string;
    slug: string;
    description: string | null;
    thumbnail: string | null;
    is_published: boolean;
    sort_order: number;
    writings_count?: number;
    published_writings_count?: number;
    writings?: Writing[];
    published_writings?: Writing[];
    created_at: string;
    updated_at: string;
}

export interface Writing {
    id: number;
    collection_id: number;
    title: string;
    slug: string;
    type: WritingType;
    excerpt: string | null;
    content: string;
    thumbnail: string | null;
    is_published: boolean;
    sort_order: number;
    written_at: string | null;
    collection?: Collection;
    created_at: string;
    updated_at: string;
}

export type WritingType =
    'puisi' | 'pantun' | 'cerita' | 'prosa' | 'sajak' | 'lainnya';

export interface AuthorProfile {
    id: number;
    name: string;
    photo: string | null;
    bio: string | null;
    tagline: string | null;
    instagram: string | null;
    twitter: string | null;
    email: string | null;
    created_at: string;
    updated_at: string;
}

export interface HeroSection {
    id: number;
    heading: string;
    subheading: string | null;
    body: string | null;
    cta_label: string | null;
    cta_url: string | null;
    image: string | null;
    is_active: boolean;
    created_at: string;
    updated_at: string;
}

export interface PaginatedData<T> {
    data: T[];
    current_page: number;
    last_page: number;
    per_page: number;
    total: number;
    from: number | null;
    to: number | null;
    links: { url: string | null; label: string; active: boolean }[];
}

export interface PageProps {
    auth: {
        user: User | null;
    };
    flash?: {
        success?: string;
        error?: string;
    };
    appUrl: string;
    appName: string;
    [key: string]: unknown;
}
