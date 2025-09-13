<script setup lang="ts">
import App from '@/pages/App.vue'
import { Link, useForm } from '@inertiajs/vue3'
import { type NavItem } from '@/types';
import { ShieldCheck, Users, Package, Tag } from 'lucide-vue-next';

defineOptions({ layout: App })

const form = useForm({
    name: ''
})

const submit = () => {
    form.post(route('admin.categories.store'))
}

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
        href: '/',
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
                    <h5 class="card-title">Admin Navigation</h5>
                    <div class="d-flex flex-wrap gap-2">
                        <Link v-for="item in mainNavItems" :key="item.title" :href="item.href" class="btn btn-success d-flex align-items-center gap-2">
                            <component :is="item.icon" :size="20" />
                            <span>{{ item.title }}</span>
                        </Link>
                    </div>
                </div>
            </div>

            <!-- Page Content -->
            <h1 class="mb-4">Nova Categoria</h1>
            <div class="card">
                <div class="card-body">
                    <form @submit.prevent="submit" class="needs-validation">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nome</label>
                            <input
                                type="text"
                                id="name"
                                v-model="form.name"
                                class="form-control"
                                :class="{ 'is-invalid': form.errors.name }"
                            />
                            <div v-if="form.errors.name" class="invalid-feedback">{{ form.errors.name }}</div>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <Link :href="route('admin.categories.index')" class="btn btn-secondary">
                                Cancelar
                            </Link>
                            <button type="submit" class="btn btn-primary" :disabled="form.processing">
                                Salvar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>