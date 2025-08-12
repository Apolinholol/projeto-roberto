<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue'
import { Link } from '@inertiajs/vue3'
import { Button } from '@/components/ui/button'

defineProps<{
    products: {
        id: number
        name: string
        price: number
        stock: number
        is_active: boolean
    }[]
}>()
</script>

<template>
    <AppLayout title="Product Management">
        <div class="p-4 sm:p-6 lg:p-8">
            <div class="sm:flex sm:items-center">
                <div class="sm:flex-auto">
                    <h1 class="text-base font-semibold leading-6 text-gray-900 dark:text-white">Products</h1>
                    <p class="mt-2 text-sm text-gray-700 dark:text-gray-300">A list of all the products.</p>
                </div>
                <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                    <Link :href="route('admin.products.create')">
                        <Button>Add product</Button>
                    </Link>
                </div>
            </div>
            <div class="mt-8 flow-root">
                <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                        <table class="min-w-full divide-y divide-gray-300 dark:divide-gray-700">
                            <thead>
                                <tr>
                                    <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 dark:text-white sm:pl-0">Name</th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white">Price</th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white">Stock</th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white">Status</th>
                                    <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-0">
                                        <span class="sr-only">Edit</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
                                <tr v-for="product in products" :key="product.id">
                                    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 dark:text-white sm:pl-0">{{ product.name }}</td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 dark:text-gray-400">{{ product.price }}</td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 dark:text-gray-400">{{ product.stock }}</td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 dark:text-gray-400">
                                        <span :class="[product.is_active ? 'bg-green-50 text-green-700 ring-green-600/20' : 'bg-red-50 text-red-700 ring-red-600/20', 'inline-flex items-center rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset']">
                                            {{ product.is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                    <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-0">
                                        <div class="flex items-center justify-end gap-x-2">
                                            <Link :href="route('admin.products.edit', { product: product.id })" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-200">Edit</Link>
                                            <Link :href="route('admin.products.update', { product: product.id })" method="put" :data="{ is_active: !product.is_active }" as="button" class="text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-200">
                                                {{ product.is_active ? 'Deactivate' : 'Activate' }}
                                            </Link>
                                            <Link :href="route('admin.products.destroy', { product: product.id })" method="delete" as="button" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-200">Delete</Link>
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
