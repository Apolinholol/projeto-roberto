 <script setup lang="ts">
import App from '@/pages/App.vue'
import { Link } from '@inertiajs/vue3'
import { type NavItem } from '@/types';
import { ShieldCheck, Users, Package, Tag, BarChart3 } from 'lucide-vue-next';

defineOptions({ layout: App })

defineProps<{
    ads: {
        id: number
        name: string
        price: number
        stock: number
        is_active: boolean
        category: { name: string } | null
    }[]
}>()

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
                    <h1 class="text-base font-semibold leading-6 text-gray-900">Anúncios</h1>
                    <p class="mt-2 text-base text-gray-700">Uma lista de todos os anúncios no sistema.</p>
                </div>
            </div>
            <div class="mt-8 flow-root">
                <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                        <table class="min-w-full divide-y divide-gray-300">
                            <thead>
                                <tr>
                                    <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">Nome</th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Categoria</th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Preço</th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Estoque</th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Status</th>
                                    <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-0">
                                        <span class="sr-only">Ações</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                <tr v-for="ad in ads" :key="ad.id">
                                    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-0">{{ ad.name }}</td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ ad.category?.name }}</td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">R$ {{ ad.price }}</td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ ad.stock }}</td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                        <span :class="[ad.is_active ? 'bg-green-50 text-green-700 ring-green-600/20' : 'bg-red-50 text-red-700 ring-red-600/20', 'inline-flex items-center rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset']">
                                            {{ ad.is_active ? 'Ativo' : 'Inativo' }}
                                        </span>
                                    </td>
                                    <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-0">
                                        <div class="flex items-center justify-end gap-x-2">
                                            <Link :href="route('admin.ads.update', { ad: ad.id })" method="put" :data="{ is_active: !ad.is_active }" as="button" class="btn btn-warning btn-sm">
                                                {{ ad.is_active ? 'Desativar' : 'Ativar' }}
                                            </Link>
                                            <Link :href="route('admin.ads.destroy', { ad: ad.id })" method="delete" as="button" class="btn btn-danger btn-sm">
                                                Deletar
                                            </Link>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>