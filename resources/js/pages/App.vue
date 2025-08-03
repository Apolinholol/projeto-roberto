<template>
    <Navbar></Navbar>
    <slot/>
</template>
<script lang="ts" setup>
import Navbar from './Navbar.vue';
</script>
<style>
input::placeholder {
    color: white!important;
}

</style>