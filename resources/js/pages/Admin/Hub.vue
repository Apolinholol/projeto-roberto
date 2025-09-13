<script setup lang="ts">
import App from '@/pages/App.vue'
import StatCard from '@/components/StatCard.vue'
import { type NavItem } from '@/types';
import { Link } from '@inertiajs/vue3';
import { ShieldCheck, Users, Package, Tag } from 'lucide-vue-next';

defineOptions({ layout: App })

defineProps<{ 
    stats: {
        users: number
        ads: number
        categories: number
    }
}>()

const mainNavItems: NavItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
        icon: ShieldCheck,
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
            <h1 class="mb-4">Painel informativo</h1>
            <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-4">
                <StatCard title="Total de Usuários" :value="stats.users" icon="Users" />
                <StatCard title="Total de Anúncios" :value="stats.ads" icon="Package" />
                <StatCard title="Total de Categorias" :value="stats.categories" icon="Folder" />
            </div>
        </div>
    </div>
</template>
