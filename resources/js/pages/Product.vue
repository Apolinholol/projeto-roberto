<template>
    <div class="container mt-4 mb-5">
        <div class="row">
            <!-- Voltar -->
            <div class="col-12 mb-3">
                <button @click="$inertia.visit('/')" class="btn btn-outline-primary">
                    <i class="bi bi-arrow-left"></i> Voltar aos anúncios
                </button>
            </div>

            <!-- Carrossel de Fotos -->
            <div class="col-lg-6 mb-4">
                <div class="card h-100">
                    
                    <!-- Carrossel -->
                    <div id="productCarousel" class="carousel slide">
                        <div class="carousel-indicators" v-if="imagens.length > 1">
                            <button 
                                v-for="(imagem, index) in imagens" 
                                :key="index"
                                type="button" 
                                data-bs-target="#productCarousel" 
                                :data-bs-slide-to="index"
                                :class="{ active: index === 0 }"
                                :aria-label="`Slide ${index + 1}`">
                            </button>
                        </div>
                        
                        <div class="carousel-inner">
                            <div 
                                v-for="(imagem, index) in imagens" 
                                :key="index"
                                class="carousel-item"
                                :class="{ active: index === 0 }">
                                <img 
                                    :src="getImageUrl(imagem)" 
                                    class="d-block w-100"
                                    :alt="`Foto ${index + 1} do produto`"
                                    style="max-height: 600px; object-fit: cover;"
                                    @error="handleImageError">
                            </div>
                        </div>
                        
                        <!-- Controles do carrossel -->
                        <button v-if="imagens.length > 1" class="carousel-control-prev" type="button" data-bs-target="#productCarousel" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Anterior</span>
                        </button>
                        <button v-if="imagens.length > 1" class="carousel-control-next" type="button" data-bs-target="#productCarousel" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Próximo</span>
                        </button>
                    </div>

                    <!-- Miniatura das fotos -->
                    <div v-if="imagens.length > 1" class="card-footer">
                        <div class="row g-2">
                            <div v-for="(imagem, index) in imagens" :key="index" class="col-3">
                                <img 
                                    :src="getImageUrl(imagem)" 
                                    class="img-thumbnail cursor-pointer"
                                    style="height: auto; object-fit: cover; width: 100%;"
                                    @click="goToSlide(index)"
                                    @error="handleImageError">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Informações do Produto -->
            <div class="col-lg-6">
                <!-- Título e Preço -->
                <div class="card mb-3">
                    <div class="card-body">
                        <h1 class="card-title h3 text-primary mb-3">{{ ad.name }}</h1>
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h2 class="text-success mb-0">R$ {{ formatPrice(ad.price) }}</h2>
                            <span class="badge bg-primary fs-6">{{ ad.category?.name || 'Categoria não definida' }}</span>
                        </div>
                        <div class="d-flex justify-content-between text-muted">
                            <small>
                                <i class="bi bi-box-seam me-1"></i>
                                Estoque: {{ ad.stock }} unidades
                            </small>
                            <small>
                                <i class="bi bi-calendar3 me-1"></i>
                                {{ formatDate(ad.created_at) }}
                            </small>
                        </div>
                    </div>
                </div>

                <!-- Descrição -->
                <div class="card mb-3">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="bi bi-file-text me-2"></i>
                            Descrição do Produto
                        </h5>
                    </div>
                    <div class="card-body">
                        <p class="card-text" style="white-space: pre-line;">{{ ad.description }}</p>
                    </div>
                </div>

                <!-- Dados do Anunciante -->
                <div class="card mb-3">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0">
                            <i class="bi bi-person-circle me-2"></i>
                            Dados do Anunciante
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-2">
                                <img v-if="ad.user?.image_path" :src="ad.user.image_path" alt="Foto do Anunciante" class="rounded-circle" style="width: 60px; height: 60px; object-fit: cover;" @error="handleImageError">
                                <i v-else class="bi bi-person-circle text-info" style="font-size: 3rem;"></i>
                            </div>
                            <div class="col-10">
                                <h6 class="mb-1">{{ ad.user?.nomeCompleto || 'Nome não informado' }}</h6>
                                <p class="text-muted mb-1">
                                    <i class="bi bi-envelope me-1"></i>
                                    {{ ad.user?.email || 'Email não informado' }}
                                </p>
                                <p class="text-muted mb-1" v-if="ad.user?.telefone">
                                    <i class="bi bi-telephone me-1"></i>
                                    {{ ad.user.telefone }}
                                </p>
                                <small class="text-muted">
                                    <i class="bi bi-geo-alt me-1"></i>
                                    {{ ad.user?.cidade || 'Cidade não informada' }} - {{ ad.user?.uf || 'UF' }}
                                </small>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-12">
                                <button 
                                    @click="verPerfilUsuario" 
                                    class="btn btn-outline-info w-100">
                                    <i class="bi bi-person-lines-fill me-2"></i>
                                    Ver Perfil do Usuário
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Botão de Chat -->
                <div class="card">
                    <div class="card-body text-center">
                        <button 
                            @click="iniciarChat" 
                            class="btn btn-lg w-100"
                            :class="ad.is_active ? 'btn-success' : 'btn-secondary'"
                            :disabled="!ad.is_active"
                            style="border-radius: 30px;">
                            <i class="bi bi-chat-dots me-2"></i>
                            {{ ad.is_active ? 'Conversar com o Anunciante' : 'Anúncio Desativado' }}
                        </button>
                        <small class="text-muted d-block mt-2">
                            {{ ad.is_active ? 'Tire suas dúvidas e negocie diretamente com o vendedor' : 'Este anúncio foi desativado pelo vendedor' }}
                        </small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Anúncios Relacionados (opcional) -->
        <div class="row mt-5" v-if="relatedAds && relatedAds.length > 0">
            <div class="col-12">
                <h3 class="mb-4">Anúncios Relacionados</h3>
                <div class="row g-3">
                    <div v-for="relatedAd in relatedAds" :key="relatedAd.id" class="col-md-3">
                        <div class="card h-100">
                            <img 
                                :src="getPrimeiraImagem(relatedAd)" 
                                class="card-img-top"
                                style="height: 150px; object-fit: cover;"
                                @error="handleImageError">
                            <div class="card-body text-center">
                                <h6 class="card-title text-truncate">{{ relatedAd.name }}</h6>
                                <p class="card-text text-success fw-bold">R$ {{ formatPrice(relatedAd.price) }}</p>
                                <button @click="$inertia.visit(`/product/${relatedAd.id}`)" class="btn btn-outline-primary btn-sm">
                                    Ver Detalhes
                                </button>
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
import { computed, onMounted } from 'vue';
import { router } from '@inertiajs/vue3';
import axios from 'axios';

defineOptions({ layout: App });

// Props vindas do backend
const props = defineProps<{
    ad: {
        id: number;
        name: string;
        description: string;
        price: string;
        stock: number;
        image_path?: string | Array<string>;
        is_active: boolean;
        created_at: string;
        category?: {
            id: number;
            name: string;
        };
        user?: {
            id: number;
            nomeCompleto: string;
            email: string;
            telefone?: string;
            cidade?: string;
            uf?: string;
            image_path?: string;
        };
    };
    relatedAds?: Array<any>;
}>();

// Computed para processar as imagens
const imagens = computed(() => {
    if (!props.ad.image_path) return [imgEntrada];
    
    try {
        let imageArray: string[] = [];
        
        if (Array.isArray(props.ad.image_path)) {
            imageArray = props.ad.image_path;
        } else if (typeof props.ad.image_path === 'string') {
            imageArray = JSON.parse(props.ad.image_path);
        }
        
        return imageArray.length > 0 ? imageArray : [imgEntrada];
    } catch (e) {
        console.error('Erro ao processar imagens:', e);
        return [imgEntrada];
    }
});

// Função para obter URL da imagem
const getImageUrl = (imagePath: string) => {
    if (imagePath === imgEntrada) return imgEntrada;
    return `/storage/${imagePath}`;
};

// Função para obter primeira imagem de anúncios relacionados
const getPrimeiraImagem = (ad: any) => {
    if (ad.image_path) {
        try {
            if (Array.isArray(ad.image_path)) {
                if (ad.image_path.length > 0) {
                    return `/storage/${ad.image_path[0]}`;
                }
            } else if (typeof ad.image_path === 'string') {
                const imagens = JSON.parse(ad.image_path);
                if (imagens && Array.isArray(imagens) && imagens.length > 0) {
                    return `/storage/${imagens[0]}`;
                }
            }
        } catch (e) {
            console.error('Erro ao processar imagens:', e);
        }
    }
    return imgEntrada;
};

// Função para lidar com erro de carregamento de imagem
const handleImageError = (event: Event) => {
    const target = event.target as HTMLImageElement;
    if (target) {
        target.src = imgEntrada;
    }
};

// Função para ir para um slide específico
const goToSlide = (index: number) => {
    const carousel = document.querySelector('#productCarousel');
    if (carousel) {
        const bsCarousel = new (window as any).bootstrap.Carousel(carousel);
        bsCarousel.to(index);
    }
};

// Função para formatar preço
const formatPrice = (price: string | number) => {
    const numPrice = typeof price === 'string' ? parseFloat(price) : price;
    return numPrice.toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
};

// Função para formatar data
const formatDate = (dateString: string) => {
    try {
        const date = new Date(dateString);
        return date.toLocaleDateString('pt-BR', {
            day: '2-digit',
            month: '2-digit',
            year: 'numeric'
        });
    } catch (error) {
        console.error('Erro ao formatar data:', error);
        return 'Data inválida';
    }
};

// Função para iniciar chat
const iniciarChat = async () => {
    // Verificar se o anúncio está ativo
    if (!props.ad.is_active) {
        (window as any).showToast?.('Este anúncio foi desativado pelo vendedor.', 'error');
        return;
    }
    
    // Verificar se usuário está logado
    if (!props.ad.user?.id) {
        (window as any).showToast?.('Dados do anunciante não encontrados.', 'error');
        return;
    }
    
try {
        const response = await axios.post(route('chat.create'), {
            seller_id: props.ad.user.id,
            ad_id: props.ad.id
        });

        // Se bem-sucedido, redireciona para a página de chat
        if (response.data.redirect) {
            router.visit(response.data.redirect);
            (window as any).showToast?.(response.data.message || 'Chat iniciado com sucesso!', 'success');
        } else {
            (window as any).showToast?.('Resposta inesperada do servidor.', 'error');
        }
    } catch (error: any) {
        console.error('Erro ao criar chat:', error);
        if (error.response && error.response.data && error.response.data.message) {
            (window as any).showToast?.(error.response.data.message, 'error');
        }
        else if (error.response && error.response.data && error.response.data.errors) {
            // Handle validation errors if any
            const firstError = Object.values(error.response.data.errors)[0] as string[];
            (window as any).showToast?.(firstError[0] || 'Erro de validação.', 'error');
        }
        else {
            (window as any).showToast?.('Erro ao iniciar conversa. Tente novamente.', 'error');
        }
    }
};

// Função para ver perfil do usuário
const verPerfilUsuario = () => {
    if (props.ad.user?.id) {
        router.visit(`/profile/${props.ad.user.id}`);
    } else {
        (window as any).showToast?.('Dados do usuário não encontrados.', 'error');
    }
};

// Inicializar carrossel do Bootstrap quando o componente for montado
onMounted(() => {
    // Garantir que o Bootstrap está carregado
    setTimeout(() => {
        const carouselElement = document.querySelector('#productCarousel');
        if (carouselElement && (window as any).bootstrap) {
            new (window as any).bootstrap.Carousel(carouselElement, {
                interval: false, // Não avança automaticamente
                wrap: true
            });
        }
    }, 100);
});
</script>

<style scoped>
.cursor-pointer {
    cursor: pointer;
}

.carousel-item img {
    border-radius: 0.375rem;
}

.card-header {
    background: linear-gradient(to right, #007bff, #0056b3) !important;
}

.bg-info {
    background: linear-gradient(to right, #17a2b8, #138496) !important;
}

.btn-success {
    background: linear-gradient(to right, #28a745, #1e7e34);
    border: none;
}

.btn-success:hover {
    background: linear-gradient(to right, #218838, #1c7430);
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.2);
}

.card {
    transition: all 0.3s ease;
    border: 1px solid #dee2e6;
}

.card:hover {
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

.img-thumbnail {
    transition: all 0.2s ease;
}

.img-thumbnail:hover {
    transform: scale(1.05);
    border-color: #007bff;
}
</style>
