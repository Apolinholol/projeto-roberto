<template>
    <section id="SectionCategorias" 
    style="background-color:#cff8e4;"
    class="d-flex flex-wrap justify-content-start my-0 align-items-center  ">
    <ul class="d-flex w-100 gap-2  flex-wrap justify-content-between align-items-center mx-2 me-5">
            <strong class="ps-3 pt-2">CATEGORIAS:</strong>
            <li class="list-item text-center" v-for="(categoria,index) in state.lstCategorias"
            :key="index">
            <a class="d-flex gap-2 justify-content-center align-items-end ">
              <i :class="state.lstIcones[index] + ' pb-1 d-flex align-items-end'"></i> <p>{{categoria}}</p>
            </a>
            </li>
        </ul>
    </section>
    <section id="SectionCarrousel"
    class="w-50 mx-auto mt-10"
    style="max-height: 400px;max-width:800px;">
        <div class="d-flex justify-content-center align-items-center">
            <img src="@images/VendIFF.png" alt="VendIFF Logo"  style="width: 100%;">
        </div>
    </section>
    <h2 class="questrial-regular text-center pt-3 mb-4">Os melhores produtos para negociar, você encontra aqui!</h2>
    <section id="SectionCards" class="d-flex  my-4 gap-4 w-100" style="overflow:hidden;">

        <div id="DivOrdenacaoFiltros" class="p-3 d-flex flex-column" style="min-width: 270px; border-right:1px solid rgb(0, 0, 0,0.3)">
            <div id="DivFiltros" >
               <h4>Ordenar por:</h4>
               
                <select v-model="state.filtro" class="form-select mb-3" aria-label="Default select example">
                    <option value="preco_desc">Maior preço</option>
                    <option value="preco_asc" >Menor preço</option>
                    <option value="data_desc">Data mais atual</option>
                </select>
           </div>
            <div id="DivFiltros"  >
               <h4>Filtro por categoria:</h4>
               
               <select class="form-select mb-3">
                <option disabled selected hidden>Selecione uma categoria</option>
                   <option v-for="categoria,index in state.lstCategorias" :key="index">
                          {{categoria}}
                    </option>
               </select>
           </div>
        </div>
      <div id="DivCards" class="flex-grow-1">
            <div class="row g-3 mx-5 gap-4">
                <div class="col-12 col-xxl-2 col-xl-3 col-lg-4 col-md-6" v-for="product in products" :key="product.id">
                
                <div class="card d-flex flex-column h-100" 
                    style="width: 220px; height: 220px; background-color:#049f55; border-radius: 18px; overflow: hidden;">

                        <img :src="imgEntrada" 
                        class="card-img-top flex-grow-1" 
                        style="object-fit:cover; object-position: center;
                        width: 100%; height: 100%; border-radius: 0;
                        min-height: 120px;padding-top: 15px;padding-inline: 10px;">


      
                    <div class="card-body p-2 text-center" style="flex: 0 0 auto;">
                    <h6 class="card-title mb-1 text-truncate" style="font-size: 0.9rem; white-space: normal; word-wrap: break-word;">
                        {{ product.name }}
                    </h6>
                    <p class="card-text mb-1" style="font-size: 0.8rem;">R${{ product.price }}</p>
                    </div>

              
                    <div class="card-footer text-center py-1 " style="background-color: #002d17; font-size: 0.75rem;">
                        <p class="m-0">Cidade - RJ</p>
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
import { reactive, watch } from 'vue';
import { Anuncio } from '@/types/globals';
import { router } from "@inertiajs/vue3";


const props = defineProps<{
  products: Anuncio[];
  filtro: {
    pesquisar?: string;
    orderBy?: string;
  };
}>();

defineOptions({ layout: App });

const state = reactive({
  filtro: props.filtro?.orderBy || 'preco_asc',
  categoria: '',
  lstCategorias: ['Automotivos', 'Literatura', 'Eletrônicos', 'Decoração', 'Moda'],
  lstIcones: ['fa-solid fa-car', 'bi bi-book', 'bi bi-phone', 'bi bi-house', 'fa-solid fa-shirt'],
});


watch(() => state.filtro, (val) => {
  router.get("/", { 
    inpProcurar: props.filtro?.pesquisar, 
    orderBy: val 
  }, {
    preserveState: true,
    replace: true
  });
});


// watch(() => state.categoria, (val) => {
//   router.get("/", { 
//     inpProcurar: props.filtro?.pesquisar, 
//     orderBy: state.filtro,
//     categoria: val
//   }, {
//     preserveState: true,
//     replace: true
//   });
// });
</script>

<style scoped>
p{
    margin-bottom: 0;
    margin-top: 4px;
}
a{
    text-decoration: none;
    color: white;
    font-size: 18px;
}
.list-item{
    height: fit-content;
    margin-top: 12px;
    padding-bottom: 4px;
    list-style: none;
    width: 140px;
    border-radius: 10px;
    background-color: #002d17;
    box-shadow: 2px 2px 5px rgba(0,0,0,0.2), -2px -2px 5px rgba(255,255,255,0.1);
}

.card div{
    color: white;
    display: flex;
    flex-direction: column;
    align-items: center;
}

</style>