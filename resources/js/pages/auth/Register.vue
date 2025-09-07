<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import TextLink from '@/components/TextLink.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AuthBase from '@/layouts/AuthLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { LoaderCircle } from 'lucide-vue-next';

const form = useForm({
   nomeCompleto: '',
   nomeUsuario: '',
   email: '',
   password: '',
   password_confirmation: '',
   telefone: '',
   cpf: '',
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'cpf'),
    });
};
</script>

<template>
    <AuthBase title="Crie sua conta" description="Entre com seus dados para começar" style="background-color:rgb(240, 241, 240)">
        <Head title="Register" />

        <form @submit.prevent="submit" class="flex flex-col gap-6">
            <div class="grid gap-6">
                <div class="grid gap-2">
                    <Label for="nomeCompleto">Nome Completo</Label>
                    <Input id="nomeCompleto" type="text" required autofocus :tabindex="1" autocomplete="name" v-model="form.nomeCompleto" placeholder="Full name" />
                    <InputError :message="form.errors.nomeCompleto" />
                </div>

                
                <div class="grid gap-2">
                    <Label for="nomeUsuario">Nome de Usuário</Label>
                    <Input id="nomeUsuario" type="text" required :tabindex="2" autocomplete="username" v-model="form.nomeUsuario" placeholder="Nome de Usuário" />
                    <InputError :message="form.errors.nomeUsuario" />
                </div>

                
                <div class="grid gap-2">
                    <Label for="cpf">CPF</Label>
                    <Input id="cpf" type="text" required :tabindex="3" autocomplete="off" v-model="form.cpf" placeholder="CPF" />
                    <InputError :message="form.errors.cpf" />
                </div>

                
                <div class="grid gap-2">
                    <Label for="telefone">Telefone</Label>
                    <Input id="telefone" type="text" required :tabindex="4" autocomplete="tel" v-model="form.telefone" placeholder="Telefone" />
                    <InputError :message="form.errors.telefone" />
                </div>

                <div class="grid gap-2">
                    <Label for="email">Email</Label>
                    <Input id="email" type="email" required :tabindex="5" autocomplete="email" v-model="form.email" placeholder="email@example.com" />
                    <InputError :message="form.errors.email" />
                </div>

                <div class="grid gap-2">
                    <Label for="password">Senha</Label>
                    <Input
                        id="password"
                        type="password"
                        required
                        :tabindex="6"
                        autocomplete="new-password"
                        v-model="form.password"
                        placeholder="Password"
                    />
                    <InputError :message="form.errors.password" />
                </div>

                <div class="grid gap-2">
                    <Label for="password_confirmation">Confirmar Senha</Label>
                    <Input
                        id="password_confirmation"
                        type="password"
                        required
                        :tabindex="7"
                        autocomplete="new-password"
                        v-model="form.password_confirmation"
                        placeholder="Confirm password"
                    />
                    <InputError :message="form.errors.password_confirmation" />
                </div>

                <Button type="submit" class="mt-2 w-full" tabindex="8" :disabled="form.processing"
                style="background-color: rgb(0, 45, 23)!important; color: white;">
                    <LoaderCircle v-if="form.processing" class="h-4 w-4 animate-spin" />
                    Criar conta
                </Button>
            </div>

            <div class="text-center text-sm text-muted-foreground" style="color: black;">
                Já tem uma conta?
                <TextLink :href="route('login')" class="underline underline-offset-4" :tabindex="6">Faça login</TextLink>
            </div>
        </form>
    </AuthBase>
</template>
