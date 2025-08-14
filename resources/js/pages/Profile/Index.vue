<template>
    <div class="container mt-4">
        <div class="row">
            <!-- Card do Perfil -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">
                            <i class="bi bi-person-circle me-2"></i>
                            Meu Perfil
                        </h5>
                    </div>
                    <div class="card-body text-center">
                        <img 
                            :src="user.avatar || '/images/default-avatar.png'" 
                            alt="Avatar" 
                            class="rounded-circle mb-3"
                            style="width: 100px; height: 100px; object-fit: cover;"
                        >
                        <h5>{{ user.name }}</h5>
                        <p class="text-muted">{{ user.email }}</p>
                        <p class="text-muted">
                            <i class="bi bi-calendar3 me-1"></i>
                            Membro desde {{ formatDate(user.created_at) }}
                        </p>
                        <button class="btn btn-outline-primary btn-sm" @click="editMode = !editMode">
                            <i class="bi bi-pencil me-1"></i>
                            {{ editMode ? 'Cancelar' : 'Editar Perfil' }}
                        </button>
                    </div>
                </div>

                <!-- Estatísticas -->
                <div class="card mt-3">
                    <div class="card-header">
                        <h6 class="mb-0">Estatísticas</h6>
                    </div>
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-6">
                                <h4 class="text-primary">{{ stats.total_ads }}</h4>
                                <small class="text-muted">Anúncios</small>
                            </div>
                            <div class="col-6">
                                <h4 class="text-success">{{ stats.active_ads }}</h4>
                                <small class="text-muted">Ativos</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Formulário de Edição / Informações -->
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="bi bi-gear me-2"></i>
                            {{ editMode ? 'Editar Informações' : 'Informações Pessoais' }}
                        </h5>
                    </div>
                    <div class="card-body">
                        <form v-if="editMode" @submit.prevent="updateProfile">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Nome Completo</label>
                                    <input 
                                        type="text" 
                                        class="form-control" 
                                        v-model="form.name"
                                        required
                                    >
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Email</label>
                                    <input 
                                        type="email" 
                                        class="form-control" 
                                        v-model="form.email"
                                        required
                                    >
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Telefone</label>
                                    <input 
                                        type="tel" 
                                        class="form-control" 
                                        v-model="form.phone"
                                        placeholder="(11) 99999-9999"
                                    >
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Cidade</label>
                                    <input 
                                        type="text" 
                                        class="form-control" 
                                        v-model="form.city"
                                    >
                                </div>
                                <div class="col-12 mb-3">
                                    <label class="form-label">Sobre Mim</label>
                                    <textarea 
                                        class="form-control" 
                                        rows="3" 
                                        v-model="form.bio"
                                        placeholder="Conte um pouco sobre você..."
                                    ></textarea>
                                </div>
                            </div>
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-success">
                                    <i class="bi bi-check-lg me-1"></i>
                                    Salvar Alterações
                                </button>
                                <button type="button" class="btn btn-secondary" @click="editMode = false">
                                    Cancelar
                                </button>
                            </div>
                        </form>

                        <!-- Visualização das informações -->
                        <div v-else>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <strong>Nome:</strong> {{ user.name }}
                                </div>
                                <div class="col-md-6 mb-3">
                                    <strong>Email:</strong> {{ user.email }}
                                </div>
                                <div class="col-md-6 mb-3">
                                    <strong>Telefone:</strong> {{ user.phone || 'Não informado' }}
                                </div>
                                <div class="col-md-6 mb-3">
                                    <strong>Cidade:</strong> {{ user.city || 'Não informado' }}
                                </div>
                                <div class="col-12 mb-3">
                                    <strong>Sobre:</strong> 
                                    <p class="mt-2">{{ user.bio || 'Nenhuma informação adicional.' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Ações Rápidas -->
                <div class="card mt-3">
                    <div class="card-header">
                        <h6 class="mb-0">Ações Rápidas</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-2">
                                <a href="/ads/create" class="btn btn-primary w-100">
                                    <i class="bi bi-plus-circle me-1"></i>
                                    Criar Novo Anúncio
                                </a>
                            </div>
                            <div class="col-md-6 mb-2">
                                <a href="/ads/my-ads" class="btn btn-outline-primary w-100">
                                    <i class="bi bi-list-ul me-1"></i>
                                    Meus Anúncios
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script lang="ts" setup>
import { ref, reactive } from 'vue';
import { router } from '@inertiajs/vue3';
import App from '@/pages/App.vue';

defineOptions({ layout: App });

const props = defineProps<{
    user: {
        id: number;
        name: string;
        email: string;
        phone?: string;
        city?: string;
        bio?: string;
        avatar?: string;
        created_at: string;
    };
    stats: {
        total_ads: number;
        active_ads: number;
    };
}>();

const editMode = ref(false);

const form = reactive({
    name: props.user.name,
    email: props.user.email,
    phone: props.user.phone || '',
    city: props.user.city || '',
    bio: props.user.bio || '',
});

const updateProfile = () => {
    router.put('/profile', form, {
        onSuccess: () => {
            editMode.value = false;
        }
    });
};

const formatDate = (dateString: string) => {
    return new Date(dateString).toLocaleDateString('pt-BR');
};
</script>

<style scoped>
.card {
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.card-header {
    border-bottom: 1px solid rgba(0,0,0,0.125);
}
</style>
