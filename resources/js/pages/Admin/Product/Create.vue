<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue'
import { useForm } from '@inertiajs/vue3'
import { Button } from '@/components/ui/button'
import { Input } from '@/components/ui/input'
import { Textarea } from '@/components/ui/textarea'
import { Label } from '@/components/ui/label'
import InputError from '@/components/InputError.vue'
import { Checkbox } from '@/components/ui/checkbox'

const form = useForm({
    name: '',
    description: '',
    price: 0,
    stock: 0,
    is_active: true,
})

function submit() {
    form.post(route('admin.products.store'))
}
</script>

<template>
    <AppLayout title="Create Product">
        <div class="p-4 sm:p-6 lg:p-8">
            <div class="max-w-md">
                <form @submit.prevent="submit">
                    <div class="space-y-4">
                        <div>
                            <Label for="name">Name</Label>
                            <Input id="name" v-model="form.name" type="text" class="mt-1 block w-full" />
                            <InputError :message="form.errors.name" class="mt-2" />
                        </div>

                        <div>
                            <Label for="description">Description</Label>
                            <Textarea id="description" v-model="form.description" class="mt-1 block w-full" />
                            <InputError :message="form.errors.description" class="mt-2" />
                        </div>

                        <div>
                            <Label for="price">Price</Label>
                            <Input id="price" v-model="form.price" type="number" step="0.01" class="mt-1 block w-full" />
                            <InputError :message="form.errors.price" class="mt-2" />
                        </div>

                        <div>
                            <Label for="stock">Stock</Label>
                            <Input id="stock" v-model="form.stock" type="number" class="mt-1 block w-full" />
                            <InputError :message="form.errors.stock" class="mt-2" />
                        </div>

                        <div class="flex items-center space-x-2">
                            <Checkbox id="is_active" v-model:checked="form.is_active" />
                            <Label for="is_active">Is Active</Label>
                        </div>
                    </div>

                    <div class="mt-6 flex items-center justify-end gap-x-4">
                        <Button :disabled="form.processing">Save</Button>
                    </div>
                </form>
            </div>
        </div>
    </AppLayout>
</template>
