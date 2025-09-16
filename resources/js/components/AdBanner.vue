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

const imageUrl = computed(() => {
  if (props.ad && Array.isArray(props.ad.image_path) && props.ad.image_path.length > 0) {
    return `/storage/${props.ad.image_path[0]}`;
  }
  return imgEntrada; // Imagem padrão caso não haja imagem
});
</script>