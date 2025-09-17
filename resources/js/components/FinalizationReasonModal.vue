<template>
  <div v-if="show" class="modal-overlay" @click.self="close">
    <div class="modal-content">
      <h3>Insira o motivo da finalização</h3>
      <div class="reasons">
        <div v-for="reason in reasons" :key="reason.key" class="reason">
          <input type="radio" :id="reason.key" :value="reason.key" v-model="selectedReason">
          <label :for="reason.key">{{ reason.label }}</label>
        </div>
      </div>
      <div class="modal-actions">
        <button @click="confirm" :disabled="!selectedReason">Confirmar</button>
        <button @click="close">Cancelar</button>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue';

const props = defineProps<{
  show: boolean;
}>();

const emit = defineEmits(['close', 'confirm']);

const selectedReason = ref<string | null>(null);

const reasons = [
  { key: 'SOLD_HERE', label: 'Vendido com sucesso neste chat' },
  { key: 'SOLD_ELSEWHERE', label: 'Vendido por outro meio' },
  { key: 'SALE_CANCELLED', label: 'Desisti da venda' },
  { key: 'BUYER_ISSUE', label: 'Problemas com o comprador' },
  { key: 'OTHER', label: 'Prefiro não dizer' },
];

const close = () => {
  emit('close');
};

const confirm = () => {
  if (selectedReason.value) {
    emit('confirm', selectedReason.value);
  }
};
</script>

<style scoped>
.modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: rgba(0, 0, 0, 0.5);
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 1000;
}

.modal-content {
  background-color: white;
  padding: 2rem;
  border-radius: 8px;
  width: 90%;
  max-width: 500px;
}

h3 {
  margin-top: 0;
  margin-bottom: 1.5rem;
  text-align: center;
}

.reasons {
  display: flex;
  flex-direction: column;
  gap: 1rem;
  margin-bottom: 1.5rem;
}

.reason {
  display: flex;
  align-items: center;
  gap: 0.5rem;
}

.modal-actions {
  display: flex;
  justify-content: flex-end;
  gap: 1rem;
}

.modal-actions button {
    padding: 0.5rem 1rem;
    border-radius: 4px;
    border: 1px solid #ccc;
    cursor: pointer;
}

.modal-actions button:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

</style>
