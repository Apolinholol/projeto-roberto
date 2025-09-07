<template>
    <div class="toast-container" style="position: fixed; top: 20px; right: 20px; z-index: 99999; pointer-events: none;">
        <div v-for="toast in toasts" :key="toast.id" 
             class="toast-item"
             style="margin-bottom: 10px; min-width: 300px; max-width: 400px; background: white; border: 2px solid #000; border-radius: 8px; box-shadow: 0 8px 24px rgba(0,0,0,0.3); overflow: hidden; pointer-events: auto; transform: translateZ(0);"
             role="alert"
             aria-live="assertive">
            
            <div class="toast-header" 
                 :style="{ backgroundColor: getToastColor(toast.type), color: 'white', padding: '12px 16px', display: 'flex', alignItems: 'center', justifyContent: 'space-between' }">
                <div style="display: flex; align-items: center;">
                    <i :class="getToastIcon(toast.type)" style="margin-right: 8px;"></i>
                    <strong>{{ getToastTitle(toast.type) }}</strong>
                </div>
                <button @click="removeToast(toast.id)" 
                        style="background: none; border: none; color: white; cursor: pointer; font-size: 18px; padding: 0; width: 20px; height: 20px; font-weight: bold;">
                    ×
                </button>
            </div>
            
            <div class="toast-body" style="padding: 12px 16px; background: #f8f9fa; color: #333;">
                <p style="margin: 0; white-space: pre-line; font-weight: bold;">{{ toast.message }}</p>
            </div>
        </div>
    </div>
</template>

<script lang="ts" setup>
import { ref, onMounted } from 'vue';

interface ToastItem {
    id: number;
    message: string;
    type: 'success' | 'error' | 'warning' | 'info';
    delay?: number;
}

const toasts = ref<ToastItem[]>([]);
let toastIdCounter = 0;

const addToast = (message: string, type: 'success' | 'error' | 'warning' | 'info' = 'info', delay: number = 5000) => {
    const id = ++toastIdCounter;
    const newToast = { id, message, type, delay };
    toasts.value.push(newToast);
    
    // Auto-remove toast após o delay
    setTimeout(() => {
        removeToast(id);
    }, delay);
};

const removeToast = (id: number) => {
    const index = toasts.value.findIndex(toast => toast.id === id);
    if (index > -1) {
        toasts.value.splice(index, 1);
    }
};

const getToastHeaderClass = (type: string) => {
    const classes = {
        success: 'bg-green-500',
        error: 'bg-red-500',
        warning: 'bg-yellow-500',
        info: 'bg-blue-500'
    };
    return classes[type as keyof typeof classes] || 'bg-blue-500';
};

const getToastColor = (type: string) => {
    const colors = {
        success: '#10b981',
        error: '#ef4444',
        warning: '#f59e0b',
        info: '#3b82f6'
    };
    return colors[type as keyof typeof colors] || '#3b82f6';
};

const getToastIcon = (type: string) => {
    const icons = {
        success: 'fas fa-check-circle',
        error: 'fas fa-exclamation-triangle',
        warning: 'fas fa-exclamation-triangle',
        info: 'fas fa-info-circle'
    };
    return icons[type as keyof typeof icons] || 'fas fa-info-circle';
};

const getToastTitle = (type: string) => {
    const titles = {
        success: 'Sucesso',
        error: 'Erro',
        warning: 'Atenção',
        info: 'Informação'
    };
    return titles[type as keyof typeof titles] || 'Informação';
};

// Expor função para uso global
defineExpose({
    addToast
});

// Tornar disponível globalmente
onMounted(() => {
    (window as any).showToast = addToast;
});
</script>

<style scoped>
.animate-fade-in {
    animation: fadeIn 0.3s ease-in-out;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateX(100%);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

.toast {
    transition: all 0.3s ease-in-out;
}
</style>
