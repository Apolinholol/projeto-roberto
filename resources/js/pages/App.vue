<template>
  <div style="display: flex; flex-direction: column; min-height: 100vh;">
    <Navbar />
    <main style="flex: 1;">
      <slot />
    </main>
    <Footer />
    <Toast />
    <ConfirmModal />
  </div>
</template>
<script lang="ts" setup>
import Navbar from './Navbar.vue';
import Footer from './Footer.vue';
import Toast from '@/components/Toast.vue';
import ConfirmModal from '@/components/ConfirmModal.vue';
</script>
<style>
  input::placeholder,
  textarea::placeholder {
    color: #676A6D !important;
  }
</style>