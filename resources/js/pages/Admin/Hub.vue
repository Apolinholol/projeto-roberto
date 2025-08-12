<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue'
import StatCard from '@/components/StatCard.vue'

defineProps<{ 
    stats: {
        users: number
        products: number
    }
}>()
</script>

<template>
    <AppLayout title="Admin Hub">
        <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-4">
            <StatCard title="Total Users" :value="stats.users" icon="Users" />
            <StatCard title="Total Products" :value="stats.products" icon="Package" />
        </div>
    </AppLayout>
</template>
