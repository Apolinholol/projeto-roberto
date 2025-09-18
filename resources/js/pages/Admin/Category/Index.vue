<script setup lang="ts">
import App from '@/pages/App.vue'
import { Link, router } from '@inertiajs/vue3'
import { type NavItem } from '@/types';
import { ShieldCheck, Users, Package, Tag, BarChart3 } from 'lucide-vue-next';
import { ref, watch } from 'vue';
import Pagination from '@/components/Pagination.vue';

defineOptions({ layout: App })

const props = defineProps<{
    categories: {
        data: any[];
        links: any[];
    };
    filters: {
        search: string;
    };
}>();

const search = ref(props.filters.search);

watch(search, (value) => {
    router.get(
        route('admin.categories.index'),
        { search: value },
        {
            preserveState: true,
            replace: true,
        }
    );
});

const mainNavItems: NavItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
        icon: ShieldCheck,
    },
    {
        title: 'Métricas',
        href: '/admin/metrics',
        icon: BarChart3,
    },
    {
        title: 'Usuários',
        href: '/admin/users',
        icon: Users,
    },
    {
        title: 'Anúncios',
        href: '/admin/ads',
        icon: Package,
    },
    {
        title: 'Categorias',
        href: '/admin/categories',
        icon: Tag,
    },
];
</script>

<template>
    <div class="bg-white">
        <div class="container py-4">
            <!-- Admin Navigation -->
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">Menu de navegação</h5>
                    <div class="d-flex flex-wrap gap-2">
                        <Link v-for="item in mainNavItems" :key="item.title" :href="item.href" class="btn btn-success d-flex align-items-center gap-2">
                            <component :is="item.icon" :size="20" />
                            <span>{{ item.title }}</span>
                        </Link>
                    </div>
                </div>
            </div>

            <!-- Page Content -->
            <div class="sm:flex sm:items-center">
                <div class="sm:flex-auto">
                    <h1 class="text-base font-semibold leading-6 text-gray-900">Categorias</h1>
                    <p class="mt-2 text-base text-gray-700">Uma lista com todas as categorias.</p>
                </div>
                <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                    <Link :href="route('admin.categories.create')" class="btn btn-success">
                        Adicionar categoria
                    </Link>
                </div>
            </div>
            <div class="mt-4">
                <input v-model="search" type="text" placeholder="Buscar por nome..." class="form-control" />
            </div>
            <div class="mt-8 flow-root">
                <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                        <table class="min-w-full divide-y divide-gray-300">
                            <thead>
                                <tr>
                                    <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">Nome</th>
                                    <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-0">
                                        <span class="sr-only">Ações</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                <tr v-for="category in categories.data" :key="category.id">
                                    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-0">{{ category.name }}</td>
                                    <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-0">
                                        <div class="flex items-center justify-end gap-x-2">
                                            <Link :href="route('admin.categories.edit', { category: category.id })" class="btn btn-info btn-sm">Editar</Link>
                                            <Link :href="route('admin.categories.destroy', { category: category.id })" method="delete" as="button" class="btn btn-danger btn-sm">Deletar</Link>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <Pagination :links="categories.links" class="mt-6" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
