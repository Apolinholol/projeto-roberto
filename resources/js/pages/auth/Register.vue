<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import TextLink from '@/components/TextLink.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AuthBase from '@/layouts/AuthLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { LoaderCircle } from 'lucide-vue-next';
import { ref } from 'vue';
import { watch } from 'vue';

const form = useForm({
   nomeCompleto: '',
   nomeUsuario: '',
   email: '',
   password: '',
   password_confirmation: '',
   telefone: '',
   cpf: '',
   uf:'',
   cidade:'',
   foto: null as File | null,
});

const state = ({
    lstUFdesc: [
        "Acre", "Alagoas", "Amapá", "Amazonas", "Bahia", "Ceará",
        "Distrito Federal", "Espírito Santo", "Goiás", "Maranhão",
        "Mato Grosso", "Mato Grosso do Sul", "Minas Gerais", "Pará",
        "Paraíba", "Paraná", "Pernambuco", "Piauí", "Rio de Janeiro",
        "Rio Grande do Norte", "Rio Grande do Sul", "Rondônia",
        "Roraima", "Santa Catarina", "São Paulo", "Sergipe", "Tocantins"
    ],
    lstUF: [
        "AC", "AL", "AP", "AM", "BA", "CE",
        "DF", "ES", "GO", "MA",
        "MT", "MS", "MG", "PA",
        "PB", "PR", "PE", "PI", "RJ",
        "RN", "RS", "RO",
        "RR", "SC", "SP", "SE", "TO"
    ],
})
const cpfError = ref<string | null>(null);

function validarCPF(cpf: string): boolean {
    cpf = cpf.replace(/\D/g, '');

    if (cpf.length !== 11 || /^(\d)\1{10}$/.test(cpf)) {
        return false;
    }

    let soma = 0, resto;


    for (let i = 1; i <= 9; i++) {
        soma += parseInt(cpf.substring(i - 1, i)) * (11 - i);
    }
    resto = (soma * 10) % 11;
    if (resto === 10 || resto === 11) resto = 0;
    if (resto !== parseInt(cpf.substring(9, 10))) return false;


    soma = 0;
    for (let i = 1; i <= 10; i++) {
        soma += parseInt(cpf.substring(i - 1, i)) * (12 - i);
    }
    resto = (soma * 10) % 11;
    if (resto === 10 || resto === 11) resto = 0;
    if (resto !== parseInt(cpf.substring(10, 11))) return false;

    return true;
}

function maskCPF(value: string): string {
  return value
    .replace(/\D/g, '')                 
    .replace(/(\d{3})(\d)/, '$1.$2')    
    .replace(/(\d{3})(\d)/, '$1.$2')    
    .replace(/(\d{3})(\d{1,2})$/, '$1-$2'); 
}

function maskCelular(value: string): string {
  return value
    .replace(/\D/g, '')                    
    .replace(/^(\d{2})(\d)/, '($1) $2')      
    .replace(/(\d{5})(\d{4})$/, '$1-$2')     
    .replace(/(\d{4})(\d{4})$/, '$1-$2');    
}

const previewFoto = ref<string | null>(null);
function handleFotoUpload(event: Event) {
    const file = (event.target as HTMLInputElement).files?.[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = (e) => {
            const base64 = e.target?.result as string;
            form.foto = base64;
            previewFoto.value = base64;
        };
        reader.readAsDataURL(file);
    }
}

watch(
    () => form.cpf,
    (newVal) => {
        if (newVal && newVal !== maskCPF(newVal)) {
            form.cpf = maskCPF(newVal);
        }
    }
);

watch(
    () => form.telefone,
    (newVal) => {
        if (newVal && newVal !== maskCelular(newVal)) {
            form.telefone = maskCelular(newVal);
        }
    }
);

const submit = () => {
    if (!validarCPF(form.cpf)) {
        cpfError.value = "CPF inválido";
        return;
    }
    cpfError.value = null;

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

                <div class="mb-3 d-flex align-items-center flex-column">
                    <label for="foto" class="form-label"><strong>Foto de Perfil:</strong></label>
                    <input 
                        type="file" 
                        class="form-control" 
                        id="foto"
                        accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"
                        @change="handleFotoUpload"
                    />
                
                    <div v-if="previewFoto" class="mt-2">
                        <img :src="previewFoto" alt="Preview" style="max-width: 120px; border-radius: 50%;">
                    </div>
                </div>

                <div class="grid gap-2">
                    <Label for="nomeCompleto">Nome Completo</Label>
                    <Input id="nomeCompleto" type="text" required autofocus :tabindex="1" autocomplete="name" v-model="form.nomeCompleto" placeholder="Nome completo" />
                    <InputError :message="form.errors.nomeCompleto" />
                </div>

                
                <div class="grid gap-2">
                    <Label for="nomeUsuario">Nome de Usuário</Label>
                    <Input id="nomeUsuario" type="text" required :tabindex="2" autocomplete="username" v-model="form.nomeUsuario" placeholder="Nome de Usuário" />
                    <InputError :message="form.errors.nomeUsuario" />
                </div>

                
                <div class="grid gap-2">
                    <Label for="cpf">CPF</Label>
                    <Input id="cpf" type="text" required :tabindex="3" autocomplete="off" v-model="form.cpf" placeholder="CPF"  
                    maxLength="14" />
                    <InputError :message="cpfError || form.errors.cpf" />
                </div>

                <div class="grid gap-2">
                    <Label for="cidade">Cidade</Label>
                    <Input id="cidade" type="text" required :tabindex="3" autocomplete="off" v-model="form.cidade" placeholder="Cidade" />
                    <InputError :message="form.errors.cidade" />
                </div>

                <div class="grid gap-2">
                    <Label for="UF">UF</Label>
                    <select class="form-select" v-model="form.uf" style="background-color: rgb(4, 159, 85);" placeholder="Unidade Federativa">
                        <option v-for="UFdesc,index in state.lstUFdesc" :key="'uf'+ index" :value="state.lstUF[index]">
                            {{ UFdesc }}
                        </option>
                    </select>
                    <InputError :message="form.errors.uf" />
                </div>

                
                <div class="grid gap-2">
                    <Label for="telefone">Telefone</Label>
                    <Input id="telefone" type="text" required :tabindex="4" autocomplete="tel" v-model="form.telefone" placeholder="Telefone" maxLength="15" />
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
                        placeholder="Senha"
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
                        placeholder="Confirmar senha"
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
