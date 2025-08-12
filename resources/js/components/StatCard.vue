<script setup lang="ts">
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card'
import Icon from '@/components/Icon.vue'

defineProps<{ 
    title: string
    value: number | string
    icon: string
}>()
</script>

<template>
    <Card>
        <CardHeader class="flex flex-row items-center justify-between space-y-0 pb-2">
            <CardTitle class="text-sm font-medium">
                {{ title }}
            </CardTitle>
            <Icon :name="icon" class="h-4 w-4 text-muted-foreground" />
        </CardHeader>
        <CardContent>
            <div class="text-2xl font-bold">
                {{ value }}
            </div>
        </CardContent>
    </Card>
</template>
