<template>
  <div class="p-4 border-b border-gray-200" style="background-color: #cff8e4;">
    <div class="flex items-center">
      <img :src="imageUrl" alt="Ad Image" class="w-16 h-16 object-cover rounded-md mr-4">
      <div class="flex-1">
        <h3 class="font-semibold" style="font-size: 0.96rem;">{{ ad.name }}</h3>
        <p class="text-gray-600">R$ {{ ad.price }}</p>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { defineProps, computed } from 'vue';
import imgEntrada from '@images/VendIFF.png';

const props = defineProps({
  ad: {
    type: Object,
    required: true,
  },
});

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

const getImageUrl = (imagePath: string) => {
    if (imagePath === imgEntrada) return imgEntrada;
    return `/storage/${imagePath}`;
};

const imageUrl = computed(() => {
    return getImageUrl(imagens.value[0]);
});

</script>