<template>
  <div class="p-4 border-b border-gray-200" style="background-color: #cff8e4;">
    <div class="flex items-center">
      <img :src="ad.image_path" alt="Ad Image" class="w-16 h-16 object-cover rounded-md mr-4">
      <div class="flex-1">
        <h3 class="font-semibold" style="font-size: 0.96rem;">{{ ad.name }}</h3>
        <p class="text-gray-600">R$ {{ ad.price }}</p>
      </div>
      <button class="bg-blue-500 text-white px-4 py-2 rounded-md">Ver Anúncio</button>
    </div>
  </div>
</template>

<script setup>
import { defineProps } from 'vue';

defineProps({
  ad: {
    type: Object,
    required: true,
  },
});
</script>
