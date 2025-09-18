<script setup lang="ts">
import AppContent from '@/components/AppContent.vue';
import AppShell from '@/components/AppShell.vue';
import AppSidebar from '@/components/AppSidebar.vue';
import AppSidebarHeader from '@/components/AppSidebarHeader.vue';
import { Button } from '@/components/ui/button';
import { SidebarTrigger } from '@/components/ui/sidebar';
import type { BreadcrumbItemType } from '@/types';

interface Props {
    breadcrumbs?: BreadcrumbItemType[];
}

withDefaults(defineProps<Props>(), {
    breadcrumbs: () => [],
});

import { LayoutGrid } from 'lucide-vue-next';
</script>

<template>
    <AppShell variant="sidebar">
        <AppSidebar />
        <div class="flex flex-col sm:gap-4 sm:py-4 sm:pl-14">
            <header class="sticky top-0 z-30 flex h-14 items-center gap-4 border-b bg-background px-4 sm:static sm:h-auto sm:border-0 sm:bg-transparent sm:px-6">
                <SidebarTrigger as-child><Button size="icon" variant="outline" class="sm:hidden"><LayoutGrid class="h-5 w-5" /></Button></SidebarTrigger>
                <AppSidebarHeader :breadcrumbs="breadcrumbs" />
            </header>
            <main class="grid flex-1 items-start gap-4 p-4 sm:px-6 sm:py-0 md:gap-8">
                <slot />
            </main>
        </div>
    </AppShell>
</template>
