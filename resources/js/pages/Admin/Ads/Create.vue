<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue'
import { useForm } from '@inertiajs/vue3'
import { Button } from '@/components/ui/button'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import InputError from '@/components/InputError.vue'
import { Checkbox } from '@/components/ui/checkbox'

defineProps<{
    categories: { id: number; name: string }[]
}>()


const form = useForm({
    name: '',
    description: '',
    price: 0,
    stock: 0,
    is_active: true,
    category_id: null,
})

function submit() {
    form.post(route('admin.ads.store'))
}
</script>

<template>
    <AppLayout title="Criar Anúncio">
        <div class="p-4 sm:p-6 lg:p-8">
            <div class="max-w-md">
                <form @submit.prevent="submit">
                    <div class="space-y-4">
                        <div>
                            <Label for="name">Nome</Label>
                            <Input id="name" v-model="form.name" type="text" class="mt-1 block w-full" />
                            <InputError :message="form.errors.name" class="mt-2" />
                        </div>

                        <div>
                            <Label for="description">Descrição</Label>
                            <textarea id="description" v-model="form.description" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-3 py-2" rows="3"></textarea>
                            <InputError :message="form.errors.description" class="mt-2" />
                        </div>

                        <div>
                            <Label for="price">Preço</Label>
                            <Input id="price" v-model="form.price" type="number" step="0.01" class="mt-1 block w-full" />
                            <InputError :message="form.errors.price" class="mt-2" />
                        </div>

                        <div>
                            <Label for="stock">Estoque</Label>
                            <Input id="stock" v-model="form.stock" type="number" class="mt-1 block w-full" />
                            <InputError :message="form.errors.stock" class="mt-2" />
                        </div>

                        <div>
                            <Label for="category">Categoria</Label>
                            <Select v-model="form.category_id">
                                <SelectTrigger>
                                    <SelectValue placeholder="Selecione uma categoria" />
                                </SelectTrigger>
                                <SelectContent>
                                    <SelectItem v-for="category in categories" :key="category.id" :value="category.id">
                                        {{ category.name }}
                                    </SelectItem>
                                </SelectContent>
                            </Select>
                            <InputError :message="form.errors.category_id" class="mt-2" />
                        </div>

                        <div class="flex items-center space-x-2">
                            <Checkbox id="is_active" v-model:checked="form.is_active" />
                            <Label for="is_active">Ativo</Label>
                        </div>
                    </div>

                    <div class="mt-6 flex items-center justify-end gap-x-4">
                        <Button :disabled="form.processing">Salvar</Button>
                    </div>
                </form>
            </div>
        </div>
    </AppLayout>
</template>