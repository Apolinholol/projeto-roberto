<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import TextLink from '@/components/TextLink.vue';
import { Button } from '@/components/ui/button';
import { Checkbox } from '@/components/ui/checkbox';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AuthBase from '@/layouts/AuthLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { LoaderCircle } from 'lucide-vue-next';

defineProps<{
    status?: string;
    canResetPassword: boolean;
}>();

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <AuthBase title="Realize o login" description="Entre com seu email e senha para acessar sua conta">
        <Head title="Login" />

        <div v-if="status" class="mb-4 text-center text-sm font-medium" style="color: #cff8e4;">
            {{ status }}
        </div>

        <form @submit.prevent="submit" class="flex flex-col gap-6" >
            <div class="grid gap-6">
                <div class="grid gap-2">
                    <Label for="email" class="questrial-font" style="color: white; font-weight: bold;">Email</Label>
                    <Input
                        id="email"
                        type="email"
                        required
                        autofocus
                        :tabindex="1"
                        autocomplete="email"
                        v-model="form.email"
                        placeholder="email@example.com"
                        style="background: white; border: 2px solid #cff8e4; border-radius: 10px; padding: 12px; font-family: 'Poppins', sans-serif;"
                    />
                    <InputError :message="form.errors.email" />
                </div>

                <div class="grid gap-2">
                    <div class="flex items-center justify-between">
                        <Label for="password" class="questrial-font" style="color: white; font-weight: bold;">Senha</Label>
                        <TextLink v-if="canResetPassword" :href="route('password.request')" class="text-sm poppins-font" :tabindex="5" 
                                  style="color: #cff8e4; text-decoration: underline;">
                            Esqueceu a senha?
                        </TextLink>
                    </div>
                    <Input
                        id="password"
                        type="password"
                        required
                        :tabindex="2"
                        autocomplete="current-password"
                        v-model="form.password"
                        placeholder="Senha"
                        style="background: white; border: 2px solid #cff8e4; border-radius: 10px; padding: 12px; font-family: 'Poppins', sans-serif;"
                    />
                    <InputError :message="form.errors.password" />
                </div>

                <div class="flex items-center justify-between">
                    <Label for="remember" class="flex items-center space-x-3 poppins-font" style="color: white;">
                        <input id="remember" type="checkbox" v-model="form.remember" 
                               style="accent-color: #cff8e4; transform: scale(1.2);" />
                        <span class="ps-2">Lembrar-me</span>
                    </Label>
                </div>

                <Button type="submit" class="mt-4 w-full questrial-font" :tabindex="4" :disabled="form.processing" 
                style="background: linear-gradient(135deg, #cff8e4 0%, #e8fdf0 100%); color: #002D17; font-weight: bold; border: none; border-radius: 12px; padding: 12px; font-size: 16px; transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(207, 248, 228, 0.3);"
                onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 20px rgba(207, 248, 228, 0.4)'"
                onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 15px rgba(207, 248, 228, 0.3)'">
                    <LoaderCircle v-if="form.processing" class="h-4 w-4 animate-spin" />
                    Entrar
                </Button>
            </div>

            <div class="text-center text-sm poppins-font" style="color: #cff8e4;">
                Não possui uma conta?
                <TextLink :href="route('register')" :tabindex="5" style="color: white; font-weight: bold; text-decoration: underline;">Registre-se</TextLink>
            </div>
        </form>
    </AuthBase>
</template>
