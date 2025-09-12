<template>
  <div class="p-4 border-b border-gray-200" style="background-color: #cff8e4;">
    <div class="flex items-center">
      <img :src="ad.image_path" alt="Ad Image" class="w-16 h-16 object-cover rounded-md mr-4">
      <div class="flex-1">
        <h3 class="font-semibold" style="font-size: 0.96rem;">{{ ad.name }}</h3>
        <p class="text-gray-600">R$ {{ ad.price }}</p>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { defineProps } from 'vue';

defineProps({
  ad: {
    type: Object,
    required: true,
  },
});
</script>