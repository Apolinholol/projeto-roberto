<template>
    <div v-if="isVisible" class="modal-overlay" 
         style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 99999; display: flex; align-items: center; justify-content: center;"
         @click="handleOverlayClick">
        
        <div class="modal-content" 
             style="background: white; border-radius: 12px; box-shadow: 0 10px 30px rgba(0,0,0,0.3); max-width: 450px; width: 90%; margin: 20px; overflow: hidden; transform: translateZ(0);"
             @click.stop>
            
            <!-- Header -->
            <div class="modal-header" 
                 style="padding: 20px 24px 16px; border-bottom: 1px solid #e5e7eb; display: flex; align-items: center;">
                <div style="display: flex; align-items: center;">
                    <i class="fas fa-question-circle" 
                       style="color: #f59e0b; font-size: 24px; margin-right: 12px;"></i>
                    <h3 style="margin: 0; font-size: 18px; font-weight: 600; color: #374151;">
                        {{ title }}
                    </h3>
                </div>
            </div>
            
            <!-- Body -->
            <div class="modal-body" 
                 style="padding: 20px 24px; color: #6b7280; line-height: 1.6;">
                <p style="margin: 0; white-space: pre-line;">{{ message }}</p>
            </div>
            
            <!-- Footer -->
            <div class="modal-footer" 
                 style="padding: 16px 24px 20px; display: flex; justify-content: flex-end; gap: 12px; background: #f9fafb;">
                <button @click="handleCancel" 
                        style="padding: 8px 16px; border: 1px solid #d1d5db; background: white; color: #374151; border-radius: 6px; cursor: pointer; font-weight: 500; transition: all 0.2s;"
                        onmouseover="this.style.background='#f3f4f6'"
                        onmouseout="this.style.background='white'">
                    {{ cancelText }}
                </button>
                <button @click="handleConfirm" 
                        style="padding: 8px 16px; border: none; background: #dc2626; color: white; border-radius: 6px; cursor: pointer; font-weight: 500; transition: all 0.2s;"
                        onmouseover="this.style.background='#b91c1c'"
                        onmouseout="this.style.background='#dc2626'">
                    {{ confirmText }}
                </button>
            </div>
        </div>
    </div>
</template>

<script lang="ts" setup>
import { ref, onMounted } from 'vue';

interface ConfirmOptions {
    title?: string;
    message: string;
    confirmText?: string;
    cancelText?: string;
    onConfirm?: () => void;
    onCancel?: () => void;
}

const isVisible = ref(false);
const title = ref('Confirmação');
const message = ref('');
const confirmText = ref('Confirmar');
const cancelText = ref('Cancelar');
let onConfirmCallback: (() => void) | null = null;
let onCancelCallback: (() => void) | null = null;

const showConfirm = (options: ConfirmOptions) => {
    title.value = options.title || 'Confirmação';
    message.value = options.message;
    confirmText.value = options.confirmText || 'Confirmar';
    cancelText.value = options.cancelText || 'Cancelar';
    onConfirmCallback = options.onConfirm || null;
    onCancelCallback = options.onCancel || null;
    isVisible.value = true;
};

const hideModal = () => {
    isVisible.value = false;
    onConfirmCallback = null;
    onCancelCallback = null;
};

const handleConfirm = () => {
    if (onConfirmCallback) {
        onConfirmCallback();
    }
    hideModal();
};

const handleCancel = () => {
    if (onCancelCallback) {
        onCancelCallback();
    }
    hideModal();
};

const handleOverlayClick = () => {
    handleCancel();
};

// Expor função para uso global
defineExpose({
    showConfirm
});

// Tornar disponível globalmente
onMounted(() => {
    (window as any).showConfirm = showConfirm;
});
</script>

<style scoped>
.modal-overlay {
    animation: fadeIn 0.2s ease-out;
}

.modal-content {
    animation: slideIn 0.3s ease-out;
}

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

@keyframes slideIn {
    from { 
        opacity: 0; 
        transform: translateY(-20px) scale(0.95); 
    }
    to { 
        opacity: 1; 
        transform: translateY(0) scale(1); 
    }
}
</style>
