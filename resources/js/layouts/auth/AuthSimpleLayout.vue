<script setup lang="ts">
import AppLogoIcon from '@/components/AppLogoIcon.vue';
import { Link } from '@inertiajs/vue3';

defineProps<{
    title?: string;
    description?: string;
}>();
</script>

<template>
    <div class="flex min-h-svh flex-col items-center justify-center gap-6 p-6 md:p-10" 
         style="background: linear-gradient(135deg, #e8fdf0 0%, #cff8e4 50%, #b8f5d2 100%);">
        <div class="w-full max-w-lg" 
        style="background: linear-gradient(135deg, #002D17 0%, #004D2A 100%);
        padding: 35px;
        border-radius: 20px;
        box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        border: 2px solid #cff8e4;">

            <div class="flex flex-col gap-8">
                <div class="flex flex-col items-center gap-4">
                    <Link :href="route('home')" class="flex flex-col items-center gap-2 font-medium">
                        <div class="mb-1 flex items-center justify-content-center rounded-md p-4"
                             style="background: #002D17; border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.2); border: 2px solid #cff8e4;">
                            <!-- <AppLogoIcon class="size-9 fill-current text-[var(--foreground)] dark:text-white" /> -->
                                    <img src="/images/logo-vendiff-sem-fundo.png" alt="Logo" class="logo"
                                    style="width: 140px; height: auto; filter: brightness(1.2) contrast(1.1);" />
                        </div>
                        <span class="sr-only">{{ title }}</span>
                    </Link>
                    <div class="space-y-2 text-center">
                        <h1 class="text-xl font-medium questrial-font" style="color: white; font-weight: bold;">{{ title }}</h1>
                        <p class="text-center text-sm poppins-font" style="color: #cff8e4;">{{ description }}</p>
                    </div>
                </div>
                <slot />
            </div>
        </div>
    </div>
</template>
