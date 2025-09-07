<template>
    <nav class="flex items-center p-4 text-white"
        style="background: linear-gradient(to right , #086839 0%, #049f55 100%);height: 80px;">
        <ul class="flex  justify-between w-full mb-0">
            <li>
                <a href="/" class="d-flex align-items-center gap-2 link-logo">
                    <img src="/images/logo-vendiff-sem-fundo.png" alt="Logo" class="logo"
                        style="width: 150px; height: auto" />
                </a>
            </li>
            <li class="w-25">
                <div class="input-group " style="margin-top: 10px; ">
                    <button class="btn bi bi-search" type="button" @click="pesquisar"></button>
                    <input @keyup.enter="pesquisar" v-model="state.inpProcurar" type="text"
                        class="form-control btn-pesquisar " placeholder="Buscar produto..." aria-label="Pesquisar">
                </div>
            </li>
            <li style="margin-right:30px">
                <div class="d-flex gap-5" style="margin-top: 10px;">
                    <!-- Botão adicionar anúncio -->
                    <a href="/AdsManager" class="bi bi-plus-circle text-white" style="font-size: 22.7px; margin-top: 1px; text-decoration: none;"></a>

                    <!-- Botão chat -->
                    <a href="/chat" class="bi bi-chat-dots fs-4 text-white" style="font-size: 22.7px; margin-top: 1px; text-decoration: none;"></a>
                    <span class="dropdown">
                        <!-- Botão perfil -->
                        <button class="bi bi-person-circle fs-4" type="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                        </button>
                        <ul class="dropdown-menu">
                            <li class="d-flex justify-content-center">
                                    <p v-if="usuario">Olá, {{ usuario?.nomeCompleto }}</p>
                                    <p v-else>Bem-vindo, visitante!</p>
                            </li>
                            <li><a class="dropdown-item" href="/profile" v-if="usuario" >Meus anúncios e perfil</a></li>
                            <li class="d-flex justify-content-center " style="height:30px;" @click="logout" v-if="usuario">
                                <button class="btn btn-danger" style="border-radius:5px;height:30px;line-height: 10px;">
                                    <i class="bi bi-door-open"></i>
                                    Logout
                                </button>
                            </li>
                        </ul>
                    </span>
                </div>
            </li>
        </ul>
    </nav>

</template>
<script lang="ts" setup>
import { router, usePage } from '@inertiajs/vue3';
import { reactive, computed } from 'vue';

const state = reactive({
    inpProcurar: '',
});

// Usar dados globais do Inertia
const page = usePage();
const usuario = computed(() => page.props.auth?.user);

console.log('Usuario do auth:', usuario.value);

function pesquisar() {
    router.get("/", { inpProcurar: state.inpProcurar }, {
        preserveState: true,
        replace: true
    });
}

const logout = () => {
    router.post(route('logout'));
};

</script>
<style scoped>
li {
    margin-right: 0;
}

.bi-search {
    background: linear-gradient(to right, #5fd098 0%, #4ebf84 100%);
    color: white;
    box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.2), -2px -2px 5px rgba(255, 255, 255, 0.1);
    border: none;
    border-top-left-radius: 6px;
    border-bottom-left-radius: 6px;
}

.btn-pesquisar {
    border-top-right-radius: 10px;
    border: 0;
    border-bottom-right-radius: 10px;
    background-color: #042414;
    color: white;
    margin-left: 0 !important;
    box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.2), -2px -2px 5px rgba(255, 255, 255, 0.1);
    border-top-right-radius: 6px;
    border-bottom-right-radius: 6px;
}
p{
    margin:0;
}

.btn-pesquisar:focus {
    outline: none;
    box-shadow: none !important;
    /* Remove sombra do foco */
}

.link-logo {
    text-decoration: none;
    color: white;
    display: flex;
    align-items: center;
    cursor: pointer;
}
</style>