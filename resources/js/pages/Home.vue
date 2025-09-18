<template>
    <!-- Hero Section -->
    <div class="hero-section" style="background: linear-gradient(135deg, #002D17 0%, #004D2A 50%, #006B3C 100%); position: relative; overflow: hidden;">
        <div class="hero-overlay" style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0, 0, 0, 0.1);"></div>
        <div class="container-fluid py-5 position-relative" style="z-index: 2;">
            <div class="row justify-content-center text-center">
                <div class="col-12 col-lg-10 col-xl-8">
                    <h1 class="display-4 fw-bold text-white mb-4 questrial-font" style="text-shadow: 2px 2px 4px rgba(0,0,0,0.3);">
                        SEJA BEM-VINDO(A) AO VENDIFF!
                    </h1>
                    <p class="lead text-white mb-4 poppins-font" style="font-size: 1.2rem; opacity: 0.95;">
                        Aqui você compra e vende com facilidade, segurança e agilidade.
                    </p>
                    <p class="text-white mb-5 poppins-font" style="opacity: 0.9;">
                        Navegue pelas categorias, filtre os anúncios e encontre o que precisa, de carros a eletrônicos, está tudo aqui!
                        <br>Comece agora mesmo a explorar ou anunciar!
                    </p>
                    
                    <!-- Botões de ação -->
                    <div class="d-flex flex-column flex-sm-row gap-3 justify-content-center">
                        <a href="/AdsManager" class="btn btn-lg px-4 py-3 questrial-font fw-bold" 
                           style="background-color: #cff8e4; color: #002D17; border: none; border-radius: 50px; box-shadow: 0 4px 15px rgba(207, 248, 228, 0.3); transition: all 0.3s ease;"
                           onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 20px rgba(207, 248, 228, 0.4)'"
                           onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 15px rgba(207, 248, 228, 0.3)'">
                            <i class="bi bi-plus-circle me-2"></i>
                            Anunciar Agora
                        </a>
                        <a href="#SectionCards" class="btn btn-outline-light btn-lg px-4 py-3 questrial-font fw-bold" 
                           style="border: 2px solid #cff8e4; border-radius: 50px; transition: all 0.3s ease;"
                           onmouseover="this.style.backgroundColor='#cff8e4'; this.style.color='#002D17'"
                           onmouseout="this.style.backgroundColor='transparent'; this.style.color='white'">
                            <i class="bi bi-search me-2"></i>
                            Explorar Produtos
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Elementos decorativos -->
        <div class="position-absolute" style="top: 10%; right: 10%; opacity: 0.1; font-size: 8rem;">
            <i class="bi bi-shop"></i>
        </div>
        <div class="position-absolute" style="bottom: 10%; left: 10%; opacity: 0.1; font-size: 6rem;">
            <i class="bi bi-bag-check"></i>
        </div>
    </div>

    <!-- Seção de Categorias Modernizada -->
    <section id="SectionCategorias" class="py-4" style="background: linear-gradient(45deg, #cff8e4 0%, #e8fdf0 100%); box-shadow: inset 0 3px 10px rgba(0,0,0,0.1);">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-12 col-lg-2 mb-3 mb-lg-0">
                    <h4 class="questrial-font fw-bold text-center text-lg-start mb-0" style="color: #002D17;">
                        <i class="bi bi-grid-3x3-gap-fill me-2"></i>
                        CATEGORIAS
                    </h4>
                </div>
                <div class="col-12 col-lg-10">
                    <div class="d-flex flex-wrap justify-content-center justify-content-lg-start gap-3">
                        <div
                            class="category-item"
                            v-for="(categoria, index) in state.lstCategorias"
                            :key="index"
                            @click="selecionarCategoria(categoria, index)"
                            :class="{ 'category-active': state.categoriaSelecionada === categoria }"
                        >
                            <div class="d-flex align-items-center gap-2">
                                <i :class="state.lstIcones[index]" style="font-size: 1.1rem;"></i>
                                <span class="poppins-font fw-medium">{{ categoria }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Seção de Produtos -->
    <section id="SectionCards" class="py-5" style="background-color: #f8f9fa;">
        <div class="container-fluid">
            <div class="row">
                <!-- Sidebar de Filtros -->
                <div class="col-lg-3 col-xl-2 mb-4 mb-lg-0">
                    <div class="filter-sidebar p-4 h-100" style="background: white; border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); border: 1px solid #e9ecef;">
                        <h4 class="questrial-font fw-bold mb-4" style="color: #002D17; border-bottom: 2px solid #cff8e4; padding-bottom: 10px;">
                            <i class="bi bi-funnel me-2"></i>
                            Filtros
                        </h4>

                        <!-- Ordenação -->
                        <div class="mb-4">
                            <label class="form-label questrial-font fw-semibold" style="color: #002D17;">
                                <i class="bi bi-sort-down me-2"></i>
                                Ordenar por:
                            </label>
                            <select v-model="state.filtro" class="form-select poppins-font" 
                                    style="border: 2px solid #e9ecef; border-radius: 10px; transition: all 0.3s ease;"
                                    onfocus="this.style.borderColor='#cff8e4'; this.style.boxShadow='0 0 0 0.2rem rgba(207, 248, 228, 0.25)'"
                                    onblur="this.style.borderColor='#e9ecef'; this.style.boxShadow='none'">
                                <option :value="null">Selecione uma opção</option>
                                <option value="preco_desc">Maior preço</option>
                                <option value="preco_asc">Menor preço</option>
                                <option value="data_desc">Data mais atual</option>
                            </select>
                        </div>

                        <!-- Filtro por Categoria -->
                        <div class="mb-4">
                            <label class="form-label questrial-font fw-semibold" style="color: #002D17;">
                                <i class="bi bi-tags me-2"></i>
                                Categoria:
                            </label>
                            <select class="form-select poppins-font" v-model="state.categoriaId" 
                                    style="border: 2px solid #e9ecef; border-radius: 10px; transition: all 0.3s ease;"
                                    onfocus="this.style.borderColor='#cff8e4'; this.style.boxShadow='0 0 0 0.2rem rgba(207, 248, 228, 0.25)'"
                                    onblur="this.style.borderColor='#e9ecef'; this.style.boxShadow='none'">
                                <option :value="null">Todas as categorias</option>
                                <option v-for="categoria, index in props.categorias" :key="index" :value="categoria.id">
                                    {{ categoria.name }}
                                </option>
                            </select>
                        </div>

                        <!-- Estatísticas -->
                        <div class="stats-card p-3 mt-4" style="background: linear-gradient(135deg, #cff8e4 0%, #e8fdf0 100%); border-radius: 10px; border: 1px solid #b8e6cc;">
                            <h6 class="questrial-font fw-bold mb-2" style="color: #002D17;">
                                <i class="bi bi-graph-up me-2"></i>
                                Estatísticas
                            </h6>
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="poppins-font" style="color: #004D2A;">Total de produtos:</small>
                                <span class="badge" style="background-color: #002D17; font-size: 0.8rem;">{{ filteredAds.length }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Grid de Produtos -->
                <div class="col-lg-9 col-xl-10">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h3 class="questrial-font fw-bold mb-0" style="color: #002D17;">
                            <i class="bi bi-grid-3x3-gap me-2"></i>
                            Produtos Disponíveis
                        </h3>
                        <span class="badge badge-lg poppins-font" style="background-color: #cff8e4; color: #002D17; font-size: 0.9rem; padding: 8px 15px; border-radius: 20px;">
                            {{ filteredAds.length }} produto{{ filteredAds.length !== 1 ? 's' : '' }} encontrado{{ filteredAds.length !== 1 ? 's' : '' }}
                        </span>
                    </div>

                    <!-- Mensagem quando não há produtos -->
                    <div v-if="!filteredAds || filteredAds.length === 0" class="text-center py-5">
                        <div class="empty-state" style="background: white; border-radius: 15px; padding: 3rem; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
                            <i class="bi bi-search" style="font-size: 4rem; color: #cff8e4; margin-bottom: 1rem;"></i>
                            <h4 class="questrial-font fw-bold" style="color: #002D17;">Nenhum produto encontrado</h4>
                            <p class="poppins-font text-muted">Tente ajustar os filtros ou explore outras categorias.</p>
                            <a href="/AdsManager" class="btn btn-lg px-4 py-2 mt-3 questrial-font fw-bold" 
                               style="background-color: #002D17; color: white; border: none; border-radius: 25px;">
                                <i class="bi bi-plus-circle me-2"></i>
                                Seja o primeiro a anunciar
                            </a>
                        </div>
                    </div>

                    <!-- Grid de Cards -->
                    <div v-else class="row g-4">
                        <div class="col-12 col-sm-6 col-md-4 col-lg-3 col-xl-3 col-xxl-2" v-for="ad in filteredAds" :key="ad.id">
                            <div class="card d-flex flex-column h-100 cursor-pointer"
                                style="width: 220px; height: 220px; background-color:#049f55; border-radius: 18px; overflow: hidden;"
                                @click="$inertia.visit(`/product/${ad.id}`)">

                                <img :src="getPrimeiraImagem(ad)" class="card-img-top flex-grow-1" style="object-fit:cover; object-position: center;
                                width: 100%; height: 100%;
                                min-height: 120px;padding-top: 15px;padding-inline: 10px;
                                max-height: 200px;" @error="handleImageError">

                                <div class="card-body p-2 text-center" style="flex: 0 0 auto;">
                                    <h6 class="card-title mb-1 text-truncate"
                                        style="font-size: 0.9rem; white-space: normal; word-wrap: break-word; color: white !important;">
                                        {{ ad.name }}
                                    </h6>
                                    <p class="card-text mb-1" style="font-size: 0.8rem; color: white !important;">R${{ ad.price }}</p>
                                </div>

                                <div class="card-footer text-center py-1 "
                                    style="background-color: #002d17; font-size: 0.75rem;">
                                    <p class="m-0" style="color: white !important;">{{ ad.cidade }} - {{ ad.uf }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Seção de Destaques/Recursos -->
    <section class="py-5" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);">
        <div class="container">
            <div class="row text-center mb-5">
                <div class="col-12">
                    <h2 class="questrial-font fw-bold" style="color: #002D17;">
                        Por que escolher o VendIFF?
                    </h2>
                    <p class="lead poppins-font text-muted">
                        A plataforma ideal para suas transações
                    </p>
                </div>
            </div>
            
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="feature-card text-center p-4 h-100" style="background: white; border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); transition: all 0.3s ease;"
                         onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 8px 25px rgba(0,0,0,0.15)'"
                         onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 15px rgba(0,0,0,0.1)'">
                        <div class="feature-icon mb-3" style="width: 80px; height: 80px; background: linear-gradient(135deg, #cff8e4 0%, #e8fdf0 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto;">
                            <i class="bi bi-shield-check" style="font-size: 2rem; color: #002D17;"></i>
                        </div>
                        <h4 class="questrial-font fw-bold mb-3" style="color: #002D17;">Segurança</h4>
                        <p class="poppins-font text-muted">
                            Transações seguras com verificação de usuários e sistema de avaliações.
                        </p>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="feature-card text-center p-4 h-100" style="background: white; border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); transition: all 0.3s ease;"
                         onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 8px 25px rgba(0,0,0,0.15)'"
                         onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 15px rgba(0,0,0,0.1)'">
                        <div class="feature-icon mb-3" style="width: 80px; height: 80px; background: linear-gradient(135deg, #cff8e4 0%, #e8fdf0 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto;">
                            <i class="bi bi-lightning" style="font-size: 2rem; color: #002D17;"></i>
                        </div>
                        <h4 class="questrial-font fw-bold mb-3" style="color: #002D17;">Agilidade</h4>
                        <p class="poppins-font text-muted">
                            Anuncie e encontre produtos rapidamente com nossa interface intuitiva.
                        </p>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="feature-card text-center p-4 h-100" style="background: white; border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); transition: all 0.3s ease;"
                         onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 8px 25px rgba(0,0,0,0.15)'"
                         onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 15px rgba(0,0,0,0.1)'">
                        <div class="feature-icon mb-3" style="width: 80px; height: 80px; background: linear-gradient(135deg, #cff8e4 0%, #e8fdf0 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto;">
                            <i class="bi bi-people" style="font-size: 2rem; color: #002D17;"></i>
                        </div>
                        <h4 class="questrial-font fw-bold mb-3" style="color: #002D17;">Comunidade</h4>
                        <p class="poppins-font text-muted">
                            Faça parte de uma comunidade ativa de compradores e vendedores.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script lang="ts" setup>
import imgEntrada from '@images/VendIFF.png';
import App from '@/pages/App.vue';
import { onMounted, reactive, watch, computed } from 'vue';
import { Anuncio, Categoria } from '@/types/globals';
import { router } from "@inertiajs/vue3";

const props = defineProps<{
    ads: Anuncio[];
    filtro: {
        pesquisar?: string;
        orderBy?: string;

    };
    categorias: Categoria[];
}>();

onMounted(() => {
});
defineOptions({ layout: App });



const state = reactive({
    filtro: props.filtro?.orderBy || null,
    categoriaId: 0 || null,
    categoriaSelecionada: null as string | null,
    lstCategorias: ['Automotivos', 'Literatura', 'Eletrônicos', 'Decoração', 'Moda'],
    lstIcones: ['fa-solid fa-car', 'bi bi-book', 'bi bi-phone', 'bi bi-house', 'fa-solid fa-shirt'],
});

const selecionarCategoria = (categoria: string, index?: number) => {
    state.categoriaSelecionada = state.categoriaSelecionada === categoria ? null : categoria;
    if (state.categoriaSelecionada) {
        state.categoriaId = null;
    }
};

const getAdCategoriaName = (ad: any): string | null => {
    if (!ad) return null;
    if (ad.category && typeof ad.category === 'string') return ad.category;
    if (ad.category && typeof ad.category === 'object' && ad.category.name) return ad.category.name;
    if (ad.categoria && typeof ad.categoria === 'string') return ad.categoria;
    if (ad.categoria && typeof ad.categoria === 'object' && ad.categoria.name) return ad.categoria.name;
    if (ad.category_name) return ad.category_name;
    if (ad.categoria_name) return ad.categoria_name;
    const cid = ad.categoria_id ?? ad.category_id;
    if (cid && props.categorias) {
        const c = props.categorias.find((x: any) => x.id === cid);
        if (c) return c.name;
    }
    return null;
};

const filteredAds = computed(() => {
    if (!props.ads) return [];

    if (state.categoriaId) {
        return props.ads.filter(ad => {
            if (ad.categoria_id && Number(ad.categoria_id) === Number(state.categoriaId)) return true;
            if (ad.category_id && Number(ad.category_id) === Number(state.categoriaId)) return true;
            if (ad.category && typeof ad.category === 'object' && ad.category.id && Number(ad.category.id) === Number(state.categoriaId)) return true;
            if (ad.categoria && typeof ad.categoria === 'object' && ad.categoria.id && Number(ad.categoria.id) === Number(state.categoriaId)) return true;
            const adCatName = getAdCategoriaName(ad);
            const mapped = props.categorias?.find((c: any) => c.id === state.categoriaId);
            if (mapped && adCatName && mapped.name && adCatName.toLowerCase() === mapped.name.toLowerCase()) return true;
            return false;
        });
    }

    if (state.categoriaSelecionada) {
        return props.ads.filter(ad => {
            const nome = getAdCategoriaName(ad);
            return nome && nome.toLowerCase() === state.categoriaSelecionada!.toLowerCase();
        });
    }

    return props.ads;
});

const testToasts = () => {
    console.log('Testando toasts...');
    if ((window as any).showToast) {
        (window as any).showToast('Toast de sucesso teste!', 'success');
        setTimeout(() => (window as any).showToast('Toast de erro teste!', 'error'), 1000);
        setTimeout(() => (window as any).showToast('Toast de warning teste!', 'warning'), 2000);
        setTimeout(() => (window as any).showToast('Toast de info teste!', 'info'), 3000);
    } else {
        console.error('showToast não está disponível!');
        alert('showToast function not available');
    }
};

const testConfirm = () => {
    (window as any).showConfirm?.({
        title: 'Teste de Confirmação',
        message: 'Esta é uma mensagem de teste do modal de confirmação.\n\nVocê gostaria de continuar?',
        confirmText: 'Sim, continuar',
        cancelText: 'Cancelar',
        onConfirm: () => {
            (window as any).showToast?.('Você confirmou a ação!', 'success');
        },
        onCancel: () => {
            (window as any).showToast?.('Ação cancelada.', 'info');
        }
    });
};

const verDetalhesAnuncio = (ad: any) => {
    const detalhes = `Anúncio: ${ad.name}\nPreço: R$ ${ad.price}\nDescrição: ${ad.description || 'Sem descrição'}`;
    (window as any).showToast?.(detalhes, 'info', 8000);
};

// Função para obter a primeira imagem do anúncio
const getPrimeiraImagem = (ad: any) => {
    if (ad.image_path) {
        try {
            // Se image_path já é um array (cast do Laravel)
            if (Array.isArray(ad.image_path)) {
                if (ad.image_path.length > 0) {
                    const imagePath = `/storage/${ad.image_path[0]}`;
                    return imagePath;
                }
            } else if (typeof ad.image_path === 'string') {
                // Se é string JSON, fazer parse
                const imagens = JSON.parse(ad.image_path);
                if (imagens && Array.isArray(imagens) && imagens.length > 0) {
                    const imagePath = `/storage/${imagens[0]}`;
                    return imagePath;
                }
            }
        } catch (e) {
            console.error('Erro ao processar imagens:', e);
        }
    }

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


watch(() => [state.filtro, state.categoriaId], ([newFiltro, newCategoriaId], [oldFiltro, oldCategoriaId]) => {
    router.get("/", {
        inpProcurar: props.filtro?.pesquisar,
        orderBy: newFiltro,
        inpCategoriaId: state.categoriaId
    }, {
        preserveState: true,
        replace: true
    });
});


</script>

<style scoped>
/* Hero Section Animations */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.hero-section {
    animation: fadeInUp 0.8s ease-out;
}

/* Category Items */
.category-item {
    padding: 12px 20px;
    background: white;
    border: 2px solid transparent;
    border-radius: 25px;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    color: #002D17;
    font-weight: 500;
}

.category-item:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(0, 45, 23, 0.2);
    border-color: #002D17;
    background: linear-gradient(135deg, #cff8e4 0%, #e8fdf0 100%);
}

.category-item.category-active {
    background: #002D17;
    color: white;
    border-color: #002D17;
    box-shadow: 0 4px 15px rgba(0, 45, 23, 0.3);
}

.category-item.category-active:hover {
    background: #004D2A;
    transform: translateY(-2px);
}

/* Filter Sidebar */
.filter-sidebar {
    position: sticky;
    top: 20px;
    height: fit-content;
    max-height: calc(100vh - 40px);
    overflow-y: auto;
}

.filter-sidebar::-webkit-scrollbar {
    width: 6px;
}

.filter-sidebar::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 3px;
}

.filter-sidebar::-webkit-scrollbar-thumb {
    background: #cff8e4;
    border-radius: 3px;
}

.filter-sidebar::-webkit-scrollbar-thumb:hover {
    background: #b8e6cc;
}

/* Stats Card */
.stats-card {
    transition: all 0.3s ease;
}

.stats-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(207, 248, 228, 0.3);
}

/* Empty State */
.empty-state {
    transition: all 0.3s ease;
}

.empty-state:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
}

/* Card Animations */
.cursor-pointer {
    cursor: pointer;
    transition: all 0.3s ease;
}

.cursor-pointer:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,45,23,0.3);
}

/* Form Controls */
.form-select:focus,
.form-control:focus {
    border-color: #cff8e4 !important;
    box-shadow: 0 0 0 0.2rem rgba(207, 248, 228, 0.25) !important;
}

/* Badge Animations */
.badge {
    transition: all 0.3s ease;
}

.badge:hover {
    transform: scale(1.05);
}

/* Responsive adjustments */
@media (max-width: 991.98px) {
    .filter-sidebar {
        position: relative;
        top: 0;
        max-height: none;
    }
    
    .hero-section .display-4 {
        font-size: 2.5rem;
    }
    
    .category-item {
        padding: 10px 16px;
        font-size: 0.9rem;
    }
}

@media (max-width: 767.98px) {
    .hero-section .display-4 {
        font-size: 2rem;
    }
    
    .hero-section .lead {
        font-size: 1.1rem;
    }
    
    .category-item {
        padding: 8px 12px;
        font-size: 0.85rem;
    }
}

@media (max-width: 575.98px) {
    .hero-section .display-4 {
        font-size: 1.75rem;
    }
    
    .hero-section .lead {
        font-size: 1rem;
    }
    
    .filter-sidebar {
        margin-bottom: 1rem;
    }
}

/* Loading animation */
@keyframes pulse {
    0% {
        opacity: 1;
    }
    50% {
        opacity: 0.5;
    }
    100% {
        opacity: 1;
    }
}

.loading {
    animation: pulse 1.5s ease-in-out infinite;
}

/* Custom scrollbar for webkit browsers */
::-webkit-scrollbar {
    width: 8px;
}

::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 4px;
}

::-webkit-scrollbar-thumb {
    background: #cff8e4;
    border-radius: 4px;
}

::-webkit-scrollbar-thumb:hover {
    background: #b8e6cc;
}

/* Forçar cor branca nos cards */
.card .card-title,
.card .card-text,
.card .card-footer p {
    color: white !important;
}
</style>