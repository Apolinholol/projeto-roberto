<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue'
import { Link } from '@inertiajs/vue3'
import { Button } from '@/components/ui/button'

defineProps<{
    categories: {
        id: number
        name: string
    }[]
}>()
</script>

<template>
    <AppLayout title="Gerenciamento de Categorias">
        <div class="p-4 sm:p-6 lg:p-8">
            <div class="sm:flex sm:items-center">
                <div class="sm:flex-auto">
                    <h1 class="text-base font-semibold leading-6 text-gray-900 dark:text-white">Categorias</h1>
                    <p class="mt-2 text-sm text-gray-700 dark:text-gray-300">Uma lista com todas as categorias.</p>
                </div>
                <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                    <Link :href="route('admin.categories.create')">
                        <Button>Adicionar categoria</Button>
                    </Link>
                </div>
            </div>
            <div class="mt-8 flow-root">
                <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                        <table class="min-w-full divide-y divide-gray-300 dark:divide-gray-700">
                            <thead>
                                <tr>
                                    <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 dark:text-white sm:pl-0">Nome</th>
                                    <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-0">
                                        <span class="sr-only">Ações</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
                                <tr v-for="category in categories" :key="category.id">
                                    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 dark:text-white sm:pl-0">{{ category.name }}</td>
                                    <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-0">
                                        <div class="flex items-center justify-end gap-x-2">
                                            <Link :href="route('admin.categories.edit', { category: category.id })" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-200">Editar</Link>
                                            <Link :href="route('admin.categories.destroy', { category: category.id })" method="delete" as="button" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-200">Deletar</Link>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
