<template>
   <div style="display: flex; flex-direction: column; min-height: 100vh;">
    <Navbar />
    <main style="flex: 1;">
      <slot />
    </main>
    <Footer />
  </div>
</template>
<script lang="ts" setup>
import Navbar from './Navbar.vue';
import Footer from './Footer.vue';
</script>
<style>
input::placeholder {
    color: white!important;
}

</style>