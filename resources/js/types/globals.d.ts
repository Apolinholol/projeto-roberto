import { AppPageProps } from '@/types/index';

// Extend ImportMeta interface for Vite...
declare module 'vite/client' {
    interface ImportMetaEnv {
        readonly VITE_APP_NAME: string;
        [key: string]: string | boolean | undefined;
    }

    interface ImportMeta {
        readonly env: ImportMetaEnv;
        readonly glob: <T>(pattern: string) => Record<string, () => Promise<T>>;
    }
}

declare module '@inertiajs/core' {
    interface PageProps extends InertiaPageProps, AppPageProps {}
}

declare module 'vue' {
    interface ComponentCustomProperties {
        $inertia: typeof Router;
        $page: Page;
        $headManager: ReturnType<typeof createHeadManager>;
    }
    
}

export interface Anuncio {
    id: number;
    name: string;
    price: number;
    cidade: string;
    uf: string;
    description?: string;
    image_path?: string | string[];
    categoria_id?: number;
    category_id?: number;
    category?: {
        id: number;
        name: string;
    };
    categoria?: {
        id: number;
        name: string;
    };
    category_name?: string;
    categoria_name?: string;
}

export interface Categoria {
    id: number;
    name: string;
}

