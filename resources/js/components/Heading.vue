<script setup lang="ts">
interface Props {
    title: string;
    description?: string;
    h2Class?: string; // New prop
}

withDefaults(defineProps<Props>(), {
    h2Class: '', // Default value for h2Class
});
</script>

<template>
    <div class="space-y-0.5">
        <h2 :class="[h2Class, 'w-100', 'm-0']">{{ title }}</h2>
        <p v-if="description" class="text-sm text-muted-foreground">
            {{ description }}
        </p>
    </div>
</template>
