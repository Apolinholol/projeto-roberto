<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue'
import { Link, useForm } from '@inertiajs/vue3'
import { Button } from '@/components/ui/button'

const props = defineProps<{
    category: {
        id: number
        name: string
    }
}>()

const form = useForm({
    name: props.category.name
})

const submit = () => {
    form.put(route('admin.categories.update', props.category.id))
}
</script>

<template>
    <AppLayout title="Editar Categoria">
        <div class="p-4 sm:p-6 lg:p-8">
            <form @submit.prevent="submit" class="max-w-xl">
                <div class="space-y-12">
                    <div class="border-b border-gray-900/10 pb-12">
                        <h2 class="text-base font-semibold leading-7 text-gray-900 dark:text-white">Editar Categoria</h2>
                        <p class="mt-1 text-sm leading-6 text-gray-600 dark:text-gray-400">
                            Edite as informações da categoria.
                        </p>

                        <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                            <div class="sm:col-span-4">
                                <label for="name" class="block text-sm font-medium leading-6 text-gray-900 dark:text-white">
                                    Nome
                                </label>
                                <div class="mt-2">
                                    <input
                                        type="text"
                                        id="name"
                                        v-model="form.name"
                                        class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 dark:bg-gray-800 dark:text-white"
                                    />
                                </div>
                                <p v-if="form.errors.name" class="mt-2 text-sm text-red-600">{{ form.errors.name }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-6 flex items-center justify-end gap-x-6">
                    <Link :href="route('admin.categories.index')" class="text-sm font-semibold leading-6 text-gray-900 dark:text-white">
                        Cancelar
                    </Link>
                    <Button type="submit" :disabled="form.processing">
                        Salvar
                    </Button>
                </div>
            </form>
        </div>
    </AppLayout>
</template>