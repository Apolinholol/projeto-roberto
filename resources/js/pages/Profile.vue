<template>
    <div class="container mt-5">
        <div class="row">
            <div class="col-12">
                <h2>
                    PERFIL DE USUÁRIO
                </h2>

                <!-- Foto do usuário -->
                <div class="user-info p-3 mb-3 mt-10 d-flex align-items-center" style="">
                    <img :src="state.usuario?.image_path" alt="Foto do usuário" class="profile-picture">

                    <!-- <svg xmlns="http://www.w3.org/2000/svg" width="200" height="200" fill="#01a656"
                        class="bi bi-person-circle" viewBox="0 0 16 16">
                        <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0" />
                        <path fill-rule="evenodd"
                            d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1" />
                    </svg> -->

                    <div class="user-details" style="border: 1px solid #022413; margin-left: 50px; width: 500px;">
                        <h3 class="d-flex align-items-center"
                            style="color: #fff; padding: 10px; background: linear-gradient(to bottom, #00ac59, #0b492a);">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor"
                                class="bi bi-info-circle" viewBox="0 0 16 16">
                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                                <path
                                    d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0" />
                            </svg>
                            <span class="ms-2">Informações</span>
                        </h3>

                        <!-- Nome do usuário -->
                        <div class="d-flex ml-4">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor"
                                class="bi bi-person-vcard" viewBox="0 0 16 16">
                                <path
                                    d="M5 8a2 2 0 1 0 0-4 2 2 0 0 0 0 4m4-2.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5M9 8a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4A.5.5 0 0 1 9 8m1 2.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 0 1h-3a.5.5 0 0 1-.5-.5" />
                                <path
                                    d="M2 2a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2zM1 4a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H8.96q.04-.245.04-.5C9 10.567 7.21 9 5 9c-2.086 0-3.8 1.398-3.984 3.181A1 1 0 0 1 1 12z" />
                            </svg>
                            <p class="user-complete-name d-flex mb-0 ml-2 align-items-center">
                                {{ state.usuario?.nomeCompleto || 'Nome não informado' }}
                            </p>
                        </div>

                        <!-- Email do usuário -->
                        <div class="d-flex ml-4 mt-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor"
                                class="bi bi-envelope" viewBox="0 0 16 16">
                                <path
                                    d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1zm13 2.383-4.708 2.825L15 11.105zm-.034 6.876-5.64-3.471L8 9.583l-1.326-.795-5.64 3.47A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741M1 11.105l4.708-2.897L1 5.383z" />
                            </svg>
                            <p class="user-email d-flex mb-0 ml-2 align-items-center">
                                {{ state.usuario?.email || 'Email não informado' }}
                            </p>
                        </div>

                        <!-- Telefone do usuário -->
                        <div class="d-flex ml-4 mt-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor"
                                class="bi bi-telephone" viewBox="0 0 16 16">
                                <path
                                    d="M3.654 1.328a.678.678 0 0 0-1.015-.063L1.605 2.3c-.483.484-.661 1.169-.45 1.77a17.6 17.6 0 0 0 4.168 6.608 17.6 17.6 0 0 0 6.608 4.168c.601.211 1.286.033 1.77-.45l1.034-1.034a.678.678 0 0 0-.063-1.015l-2.307-1.794a.68.68 0 0 0-.58-.122l-2.19.547a1.75 1.75 0 0 1-1.657-.459L5.482 8.062a1.75 1.75 0 0 1-.46-1.657l.548-2.19a.68.68 0 0 0-.122-.58zM1.884.511a1.745 1.745 0 0 1 2.612.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.68.68 0 0 0 .178.643l2.457 2.457a.68.68 0 0 0 .644.178l2.189-.547a1.75 1.75 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.6 18.6 0 0 1-7.01-4.42 18.6 18.6 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877z" />
                            </svg>
                            <p class="user-phone d-flex mb-0 ml-2 align-items-center">
                                {{state.usuario?.telefone || 'Telefone não informado' }}
                            </p>
                        </div>

                        <!-- Cidade do usuário -->
                        <div class="d-flex ml-4 mt-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor"
                                class="bi bi-geo-alt" viewBox="0 0 16 16">
                                <path
                                    d="M12.166 8.94c-.524 1.062-1.234 2.12-1.96 3.07A32 32 0 0 1 8 14.58a32 32 0 0 1-2.206-2.57c-.726-.95-1.436-2.008-1.96-3.07C3.304 7.867 3 6.862 3 6a5 5 0 0 1 10 0c0 .862-.305 1.867-.834 2.94M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10" />
                                <path d="M8 8a2 2 0 1 1 0-4 2 2 0 0 1 0 4m0 1a3 3 0 1 0 0-6 3 3 0 0 0 0 6" />
                            </svg>
                            <p class="user-city d-flex mb-0 ml-2 align-items-center">
                               {{ state.usuario.uf }} - {{ state.usuario.cidade}}
                            </p>
                        </div>

                        <div class="d-flex justify-content-end mt-2">
                            <button class="btn btn-primary mb-2 mx-2 d-flex align-items-center"
                                style="border-radius: 30px; background-color: #0b492a; font-size: 12px; font-weight: 700;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-pencil mr-1" viewBox="0 0 16 16">
                                    <path
                                        d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325" />
                                </svg>
                                Editar Perfil
                            </button>
                        </div>
                    </div>


                </div>

                <div class="user-info p-3 mb-3 mt-10 d-flex flex-column align-items-center justify-content-center"
                    style="border: 1px solid #022413;">
                    <h3 class="d-flex align-items-center justify-content-center" style="padding-top: 13px;">HISTÓRICO DE
                        ANÚNCIOS</h3>

                    <div class="w-100">
                        <p class="justify-content-center mt-1 mb-3 text-center">Veja abaixo todos os seus anúncios.
                            Edite, ative, desative ou apenas visualize cada um deles com
                            facilidade.
                        </p>

                        <!-- Mensagem quando não há anúncios -->
                        <div v-if="!anuncios || anuncios.length === 0" class="text-center"
                            style="padding-bottom: 13px;">
                            <p class="text-muted mb-0">Nenhum anúncio cadastrado.<br>
                                <a href="/AdsManager" style="color: #0b492a; font-weight: 700;">Clique aqui para criar o
                                    seu primeiro anúncio.</a>
                            </p>
                        </div>

                        <div v-else class="row g-3 justify-content-center">
                            <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-3" v-for="ad in anuncios" :key="ad.id">
                                <div class="card d-flex flex-column h-100"
                                    style="width: 220px; height: 300px; background-color:#049f55; border-radius: 18px; overflow: hidden; margin: 0 auto; position: relative;">

                                    <!-- Container da imagem com overlay -->
                                    <div style="position: relative; width: 100%; height: 170px;">
                                        <img :src="getPrimeiraImagem(ad)" class="card-img-top" :style="`object-fit:cover; object-position: center;
                                            width: 100%; height: 170px; border-radius: 0;
                                            padding-top: 15px; padding-inline: 10px;
                                            ${!ad.is_active ? 'filter: blur(2px) brightness(0.7);' : ''}`"
                                            @error="handleImageError">

                                        <!-- Badge de status desativado - apenas sobre a área da foto (com mesmo padding) -->
                                        <div v-if="!ad.is_active"
                                            class="position-absolute d-flex align-items-center justify-content-center"
                                            style="top: 15px; left: 10px; right: 10px; bottom: 0; background-color: rgba(0,0,0,0.6); z-index: 5; border-radius: 8px;">
                                            <div class="text-center">
                                                <i class="bi bi-pause-circle-fill text-warning"
                                                    style="font-size: 2.5rem;"></i>
                                                <p class="text-white mt-2 mb-0 fw-bold" style="font-size: 0.8rem;">
                                                    ANÚNCIO<br>DESATIVADO</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card-body p-2" style="flex: 0 0 auto; height: 70px;">
                                        <!-- Layout em duas colunas -->
                                        <div class="d-flex h-100 align-items-center">
                                            <!-- Coluna esquerda: Nome e Preço -->
                                            <div class="flex-fill text-center"
                                                style="border-right: 1px solid #ffffff40; padding-right: 8px;">
                                                <h6 class="card-title mb-1"
                                                    style="font-size: 0.8rem; line-height: 1.0; color: white; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; line-clamp: 2; -webkit-box-orient: vertical;">
                                                    {{ ad.name }}
                                                </h6>
                                                <p class="card-text mb-0"
                                                    style="font-size: 0.75rem; color: white; font-weight: bold;">
                                                    R$ {{ ad.price }}
                                                </p>
                                            </div>

                                            <!-- Coluna direita: Outras informações -->
                                            <div class="flex-fill text-center" style="padding-left: 8px;">
                                                <p class="mb-1"
                                                    style="color: #ccc; line-height: 1.1; font-size: 0.7rem;">
                                                    Estoque: {{ ad.stock }}
                                                </p>
                                                <p class="mb-1" :class="ad.is_active ? 'text-light' : 'text-warning'"
                                                    style="line-height: 1.1; font-size: 0.7rem; font-weight: bold;">
                                                    {{ ad.is_active ? 'Ativo' : 'Inativo' }}
                                                </p>
                                                <p class="mb-0"
                                                    style="color: #ccc; line-height: 1.1; font-size: 0.65rem;">
                                                    {{ formatarData(ad.created_at) }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card-footer d-flex justify-content-center gap-1 py-1"
                                        style="background-color: #002d17; font-size: 0.75rem;">
                                        <button class="btn btn-sm btn-warning"
                                            style="font-size: 0.7rem; padding: 2px 6px;" title="Editar"
                                            @click="editAd(ad)">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <button class="btn btn-sm"
                                            :class="ad.is_active ? 'btn-secondary' : 'btn-success'"
                                            style="font-size: 0.7rem; padding: 2px 6px;"
                                            :title="ad.is_active ? 'Desativar' : 'Ativar'" @click="toggleStatus(ad)">
                                            <i :class="ad.is_active ? 'bi bi-pause' : 'bi bi-play'"></i>
                                        </button>
                                        <button class="btn btn-sm btn-danger"
                                            style="font-size: 0.7rem; padding: 2px 6px;" title="Excluir"
                                            @click="deleteAd(ad)">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script lang="ts" setup>
import imgEntrada from '@images/VendIFF.png';
import App from '@/pages/App.vue';
import { ref, computed, onMounted, reactive } from 'vue';
import { router, usePage } from '@inertiajs/vue3';

defineOptions({ layout: App });

// Obter dados do usuário logado
const page = usePage();
const usuarioAuth = page.props.auth?.user ;

const state = reactive({
    usuario: {
        id: 0,
        nomeCompleto: '',
        email: '',
        telefone: '',
        cidade: '',
        uf: '',
        image_path: ''
    }
});
// Props vindas do backend
const props = defineProps<{
    anuncios?: Array<{
        id: number;
        name: string;
        description?: string;
        price: string;
        stock: number;
        image_path?: string | Array<string>;
        is_active: boolean;
        created_at: string;
    }>;
    anunciante: any;
}>();

onMounted(() => {
    // console.log(props.anunciante);

    if(props.anunciante?.id > 0) {
        state.usuario = props.anunciante;
    }else{
        state.usuario = usuarioAuth;
    }
}); 

// Função para obter a primeira imagem do anúncio (reutilizada da Home)
const getPrimeiraImagem = (ad: any) => {
    console.log('Processando imagem para anúncio:', ad.name, 'image_path:', ad.image_path);

    if (ad.image_path) {
        try {
            // Se image_path já é um array (cast do Laravel)
            if (Array.isArray(ad.image_path)) {
                if (ad.image_path.length > 0) {
                    const imagePath = `/storage/${ad.image_path[0]}`;
                    console.log('Imagem encontrada (array):', imagePath);
                    return imagePath;
                }
            } else if (typeof ad.image_path === 'string') {
                // Se é string JSON, fazer parse
                const imagens = JSON.parse(ad.image_path);
                if (imagens && Array.isArray(imagens) && imagens.length > 0) {
                    const imagePath = `/storage/${imagens[0]}`;
                    console.log('Imagem encontrada (string):', imagePath);
                    return imagePath;
                }
            }
        } catch (e) {
            console.error('Erro ao processar imagens:', e);
        }
    }

    console.log('Usando imagem padrão para:', ad.name);
    // Retorna imagem padrão se não houver imagem
    return imgEntrada;
};

// Função para lidar com erro de carregamento de imagem
const handleImageError = (event: Event) => {
    const target = event.target as HTMLImageElement;
    if (target) {
        target.src = imgEntrada;
    }
};

// Função para alterar status do anúncio (ativar/desativar)
const toggleStatus = async (ad: any) => {
    try {
        router.patch(`/my-ads/${ad.id}`, {
            is_active: !ad.is_active
        }, {
            onSuccess: () => {
                ad.is_active = !ad.is_active; // Atualizar localmente
                (window as any).showToast?.(`Anúncio ${ad.is_active ? 'ativado' : 'desativado'} com sucesso!`, 'success');
            },
            onError: () => {
                (window as any).showToast?.('Erro ao alterar status do anúncio.', 'error');
            }
        });
    } catch (error) {
        console.error('Erro ao alterar status:', error);
        (window as any).showToast?.('Erro ao alterar status do anúncio.', 'error');
    }
};

// Função para excluir anúncio
const deleteAd = async (ad: any) => {
    (window as any).showConfirm?.({
        title: 'Excluir Anúncio',
        message: `Tem certeza que deseja excluir o anúncio "${ad.name}"?\n\nEsta ação não pode ser desfeita.`,
        confirmText: 'Excluir',
        cancelText: 'Cancelar',
        onConfirm: async () => {
            try {
                router.delete(`/my-ads/${ad.id}`, {
                    onSuccess: () => {
                        (window as any).showToast?.('Anúncio excluído com sucesso!', 'success');
                        // Recarregar a página para atualizar a lista
                        router.reload();
                    },
                    onError: () => {
                        (window as any).showToast?.('Erro ao excluir anúncio.', 'error');
                    }
                });
            } catch (error) {
                console.error('Erro ao excluir anúncio:', error);
                (window as any).showToast?.('Erro ao excluir anúncio.', 'error');
            }
        }
    });
};

// Função para formatar data em formato brasileiro
const formatarData = (dataString: string) => {
    try {
        const data = new Date(dataString);
        return data.toLocaleDateString('pt-BR', {
            day: '2-digit',
            month: '2-digit',
            year: 'numeric'
        });
    } catch (error) {
        console.error('Erro ao formatar data:', error);
        return 'Data inválida';
    }
};

// Função para editar anúncio
const editAd = (ad: any) => {
    // Redirecionar para AdsManager com os dados do anúncio para edição
    router.visit(`/AdsManager/edit/${ad.id}`);
};
</script>

<style scoped>
/* Estilos para foto de perfil */
.profile-picture {
    width: 200px;
    height: 200px;
    border-radius: 50%;
    object-fit: cover;
    object-position: center;
    border: 4px solid #049f55;
    background-color: #f8f9fa;
}

@media (max-width: 768px) {
    .profile-picture {
        width: 150px;
        height: 150px;
    }
}

@media (max-width: 576px) {
    .profile-picture {
        width: 120px;
        height: 120px;
    }
}
</style>
