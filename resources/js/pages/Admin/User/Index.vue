<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue'
import { Link } from '@inertiajs/vue3'
import { Button } from '@/components/ui/button'

defineProps<{
    users: {
        id: number
        name: string
        email: string
        is_active: boolean
        created_at: string
    }[]
}>()
</script>

<template>
    <AppLayout title="User Management">
        <div class="p-4 sm:p-6 lg:p-8">
            <div class="sm:flex sm:items-center">
                <div class="sm:flex-auto">
                    <h1 class="text-base font-semibold leading-6 text-gray-900 dark:text-white">Users</h1>
                    <p class="mt-2 text-sm text-gray-700 dark:text-gray-300">A list of all the users in your account including their name, email and status.</p>
                </div>
            </div>
            <div class="mt-8 flow-root">
                <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                        <table class="min-w-full divide-y divide-gray-300 dark:divide-gray-700">
                            <thead>
                                <tr>
                                    <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 dark:text-white sm:pl-0">Name</th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white">Email</th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white">Status</th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white">Joined</th>
                                    <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-0">
                                        <span class="sr-only">Edit</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
                                <tr v-for="user in users" :key="user.id">
                                    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 dark:text-white sm:pl-0">{{ user.name }}</td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 dark:text-gray-400">{{ user.email }}</td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 dark:text-gray-400">
                                        <span :class="[user.is_active ? 'bg-green-50 text-green-700 ring-green-600/20' : 'bg-red-50 text-red-700 ring-red-600/20', 'inline-flex items-center rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset']">
                                            {{ user.is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 dark:text-gray-400">{{ user.created_at }}</td>
                                    <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-0">
                                        <div class="flex items-center justify-end gap-x-2">
                                            <Link :href="route('admin.users.update', { user: user.id })" method="put" :data="{ is_active: !user.is_active }" as="button" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-200">
                                                {{ user.is_active ? 'Disable' : 'Enable' }}
                                            </Link>
                                            <Link :href="route('admin.users.destroy', { user: user.id })" method="delete" as="button" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-200">
                                                Delete
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
    </AppLayout>
</template>
