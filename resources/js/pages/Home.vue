<template>
    <section id="SectionCategorias" style="background-color:#cff8e4;"
        class="d-flex flex-wrap justify-content-start my-0 align-items-center  ">
        <ul class="d-flex w-100 gap-2  flex-wrap justify-content-between align-items-center mx-2 me-5">
            <strong class="ps-3 pt-2">CATEGORIAS:</strong>
            <li
                class="list-item text-center"
                v-for="(categoria, index) in state.lstCategorias"
                :key="index"
                @click="selecionarCategoria(categoria, index)"
                :class="{ 'border border-warning': state.categoriaSelecionada === categoria }"
                style="cursor: pointer;"
            >
                <a class="d-flex gap-2 justify-content-center align-items-end ">
                    <i :class="state.lstIcones[index] + ' pb-1 d-flex align-items-end'"></i>
                    <p>{{ categoria }}</p>
                </a>
            </li>
        </ul>
    </section>

    <div class="container-fluid px-3 px-sm-4 px-md-5 my-4 mt-5 mb-5">
        <div class="row justify-content-center">
            <div class="col-12 col-sm-11 col-md-10 col-lg-9 col-xl-8 col-xxl-7">
                <div
                    style="background-color: #002D17; padding: 25px 25px; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
                    <h2 class="text-center mb-4" style="color: #fff;">SEJA BEM-VINDO(A) AO VENDIFF!</h2>
                    <p class="text-center" style="color: #fff; max-width: 780px; margin: 0 auto;">
                        Aqui você compra e vende com facilidade, segurança e agilidade.
                        Navegue pelas categorias, filtre os anúncios e encontre o que precisa, de carros a eletrônicos,
                        está tudo
                        aqui!
                        <br><br>
                        Comece agora mesmo a explorar ou anunciar!
                    </p>
                </div>
            </div>
        </div>
    </div>

    <section id="SectionCards" class="d-flex  my-4 gap-4 w-100" style="overflow:hidden;">

        <div id="DivOrdenacaoFiltros" class="p-3 d-flex flex-column"
            style="min-width: 270px; border-right:1px solid rgb(0, 0, 0,0.3)">
            <div id="DivFiltros">
                <h4>Ordenar por:</h4>

                <select v-model="state.filtro" class="form-select mb-3" aria-label="Default select example">
                    <option :value="null" selected>Selecione uma opção</option>
                    <option value="preco_desc">Maior preço</option>
                    <option value="preco_asc">Menor preço</option>
                    <option value="data_desc">Data mais atual</option>
                </select>
            </div>
            <div id="DivFiltros">
                <h4>Filtro por categoria:</h4>

                <select class="form-select mb-3" v-model="state.categoriaId" aria-label="Default select example">
                    <option :value="null" selected>Selecione uma categoria</option>
                    <option v-for="categoria, index in props.categorias" :key="index" :value="categoria.id">
                        {{ categoria.name }}
                    </option>
                </select>
            </div>
        </div>

        <div id="DivCards" class="flex-grow-1">
            <div class="row g-3 mx-5 gap-4">
                <div class="col-12 col-xxl-2 col-xl-3 col-lg-4 col-md-6" v-for="ad in filteredAds" :key="ad.id">
                    <div class="card d-flex flex-column h-100 cursor-pointer"
                        style="width: 220px; height: 220px; background-color:#049f55; border-radius: 18px; overflow: hidden;"
                        @click="$inertia.visit(`/product/${ad.id}`)">

                        <img :src="getPrimeiraImagem(ad)" class="card-img-top flex-grow-1" style="object-fit:cover; object-position: center;
                        width: 100%; height: 100%;
                        min-height: 120px;padding-top: 15px;padding-inline: 10px;
                        max-height: 200px;" @error="handleImageError">



                        <div class="card-body p-2 text-center" style="flex: 0 0 auto;">
                            <h6 class="card-title mb-1 text-truncate"
                                style="font-size: 0.9rem; white-space: normal; word-wrap: break-word;">
                                {{ ad.name }}
                            </h6>
                            <p class="card-text mb-1" style="font-size: 0.8rem;">R${{ ad.price }}</p>
                        </div>


                        <div class="card-footer text-center py-1 "
                            style="background-color: #002d17; font-size: 0.75rem;">
                            <p class="m-0">{{ ad.uf }} - {{ ad.cidade }}</p>
                        </div>
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
p {
    margin-bottom: 0;
    margin-top: 4px;
}

a {
    text-decoration: none;
    color: white;
    font-size: 18px;
}

.list-item {
    height: fit-content;
    margin-top: 12px;
    padding-bottom: 4px;
    list-style: none;
    width: 140px;
    border-radius: 10px;
    background-color: #002d17;
    box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.2), -2px -2px 5px rgba(255, 255, 255, 0.1);
}

.card div {
    color: white;
    display: flex;
    flex-direction: column;
    align-items: center;
}

.cursor-pointer {
    cursor: pointer;
}

.cursor-pointer:hover {
    transform: translateY(-2px);
    transition: all 0.3s ease;
    box-shadow: 0 4px 12px rgba(0,0,0,0.2);
}
</style>