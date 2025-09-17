<template>
  <div class="chat-container">
    <div class="chat-sidebar">
      <div class="chat-sidebar-header">
        <h2 style="text-align: center;">Negociações</h2>
      </div>
      <div v-if="formattedChats.length === 0" class="no-chats">
        <p>Inicie um chat para vê-lo aqui</p>
      </div>
      <ul v-else class="chat-list">
        <li
          v-for="chat in formattedChats"
          :key="chat.id"
          class="chat-list-item"
          :class="{ active: selectedChat && selectedChat.id === chat.id }"
          @click="selectChat(chat)"
        >
          <div class="chat-avatar">
            <img :src="chat.image_path" alt="Avatar" v-if="chat.image_path" class="avatar-image">
            <i class="bi bi-person-circle fs-3" v-else></i>
          </div>
          <div class="chat-info">
            <p class="chat-product-name">{{ chat.ad.name }}</p>
            <p class="chat-user-name">{{ chat.name }}</p>
          </div>
        </li>
      </ul>
    </div>
    <div class="chat-content">
      <div v-if="selectedChat" class="chat-messages">
        <div class="chat-messages-header">
          <Heading :title="selectedChat.name" h2Class="text-center" />
        </div>
        <div class="ad-button-container">
          <AdBanner v-if="selectedChat.ad" :ad="selectedChat.ad" class="mt-4" />
          <button
            @click="viewAd"
            class="view-ad-button"
          >
            Ver Anúncio
          </button>
          <button
            v-if="selectedChat && selectedChat.ad && user && selectedChat.ad.user_id === user.id && !selectedChat.finalizado"
            @click="finalizeNegotiation"
            class="negotiation-status-button finalize-button"
          >
            Finalizar Negociação
          </button>
        </div>
        <div class="chat-messages-body">
          <div
            v-for="message in orderedMessages"
            :key="message.id"
            class="message"
            :class="{ 'sent': message.user_id === user.id, 'received': message.user_id !== user.id, 'system-message': message.system_message }"
          >
            <div class="message-content">
              <p>{{ message.content }}</p>
              <span class="message-time">{{ new Date(message.created_at).toLocaleTimeString() }}</span>
            </div>
          </div>
        </div>
        <div class="chat-messages-footer">
          <input type="text" placeholder="Digite sua mensagem..." v-model="messageInput" @keyup.enter="sendMessage" :disabled="selectedChat && selectedChat.finalizado" />
          <button @click="sendMessage" :disabled="selectedChat && selectedChat.finalizado">Enviar</button>
        </div>
      </div>
      <div v-else class="no-chat-selected">
        <p>Abra um chat para exibir aqui</p>
      </div>
    </div>
    <FinalizationReasonModal
      :show="showReasonModal"
      @close="showReasonModal = false"
      @confirm="confirmFinalization"
    />
  </div>
</template>

<script lang="ts" setup>
import { ref, computed, watch, nextTick, onMounted, onUnmounted } from 'vue';
import { usePage, router } from '@inertiajs/vue3';
import App from '@/pages/App.vue';
import Heading from '@/components/Heading.vue';
import AdBanner from '@/components/AdBanner.vue';
import axios from 'axios';
import FinalizationReasonModal from '@/components/FinalizationReasonModal.vue';

defineOptions({ layout: App });

interface Participant {
  id: number;
  nomeCompleto: string;
}

interface Ad {
  id: number;
  user_id: number;
  name: string;
  price: number;
  image_path: string;
}

interface Chat {
  id: number;
  id_comprador: number;
  id_vendedor: number;
  buyer: Participant;
  seller: Participant;
  ad: Ad;
  finalizado: boolean;
}

interface Message {
  id: number;
  chat_id: number;
  user_id: number;
  content: string;
  created_at: string;
  updated_at: string;
  user: Participant;
  system_message: boolean;
}

const page = usePage();
const user = computed(() => page.props.auth.user);

const props = withDefaults(defineProps<{ 
  chats?: Chat[];
  systemMessage?: Message;
}>(), {
  chats: () => [],
});

const formattedChats = computed(() => {
  if (!props.chats || !user.value) return [];
  return props.chats.map(chat => {
    const otherParticipant = chat.id_comprador === user.value.id ? chat.seller : chat.buyer;
    return {
      id: chat.id,
      name: otherParticipant?.nomeCompleto || 'Chat',
      lastMessage: '', // Será implementado depois
      ad: chat.ad,
      finalizado: chat.finalizado,
      image_path: otherParticipant?.image_path,
    };
  });
});

const selectedChat = ref(null);
const messageInput = ref('');
const messages = ref<Message[]>([]);
const showReasonModal = ref(false);
const pollingIntervalId = ref<number | null>(null);
const lastMessageId = ref<number | null>(null);

const orderedMessages = computed(() => {
  return [...messages.value].reverse();
});

const scrollToBottom = () => {
  const messagesBody = document.querySelector('.chat-messages-body');
  if (messagesBody) {
    messagesBody.scrollTop = messagesBody.scrollHeight;
  }
};

const fetchMessages = async (appendOnly: boolean = false) => {
  if (!selectedChat.value) {
    messages.value = [];
    return;
  }
  try {
    let url = route('chat.messages.get', selectedChat.value.id);
    if (appendOnly && lastMessageId.value) {
      url += `?last_message_id=${lastMessageId.value}`;
    }

    const response = await axios.get(url);
    const fetchedMessages = response.data;

    if (fetchedMessages.length > 0) {
      // If not appendOnly, replace all messages (initial load)
      if (!appendOnly) {
        messages.value = fetchedMessages;
        if (props.systemMessage) {
          messages.value.unshift(props.systemMessage);
        }
      } else {
        // Append new messages, ensuring no duplicates and maintaining order
        const newMessages = fetchedMessages.filter(
          (newMessage: Message) => !messages.value.some(existingMessage => existingMessage.id === newMessage.id)
        );
        messages.value.push(...newMessages);
        messages.value.sort((a, b) => a.id - b.id); // Ensure correct order after appending
      }

      // Update lastMessageId
      lastMessageId.value = messages.value[messages.value.length - 1]?.id || null;

      await nextTick();
      scrollToBottom();
    } else if (!appendOnly && props.systemMessage) {
      // If no messages and not appendOnly, just show system message
      messages.value = [props.systemMessage];
      lastMessageId.value = null;
      await nextTick();
      scrollToBottom();
    }
  } catch (error) {
    console.error('Error fetching messages:', error);
  }
};

const POLLING_INTERVAL = 3000; // Poll every 3 seconds

const startPolling = () => {
  if (pollingIntervalId.value) {
    clearInterval(pollingIntervalId.value);
  }
  pollingIntervalId.value = setInterval(() => {
    fetchMessages(true); // Fetch only new messages
  }, POLLING_INTERVAL);
};

const stopPolling = () => {
  if (pollingIntervalId.value) {
    clearInterval(pollingIntervalId.value);
    pollingIntervalId.value = null;
  }
};

watch(selectedChat, async (newChat) => {
  stopPolling(); // Stop any existing polling
  if (newChat) {
    messages.value = []; // Clear messages when switching chats
    lastMessageId.value = null; // Reset lastMessageId
    await fetchMessages(); // Initial fetch of all messages for the new chat
    startPolling(); // Start polling for the new chat
  }
}, { immediate: true });

const sendMessage = async () => {
  if (!messageInput.value.trim() || !selectedChat.value) {
    return;
  }

  try {
    const response = await axios.post(route('chat.message.store'), {
      chat_id: selectedChat.value.id,
      content: messageInput.value,
    });
    messages.value.push(response.data);
    // Update lastMessageId with the newly sent message's ID
    lastMessageId.value = response.data.id;
    messageInput.value = '';
    await nextTick();
    scrollToBottom();
  } catch (error) {
    console.error('Error sending message:', error);
  }
};

const selectChat = (chat) => {
  const fullChatData = props.chats.find(c => c.id === chat.id);
  selectedChat.value = fullChatData;
};

onMounted(async () => {
  const urlParams = new URLSearchParams(window.location.search);
  const chatId = urlParams.get('chat_id');

  if (chatId && props.chats) {
    const chatToSelect = props.chats.find(chat => chat.id === parseInt(chatId, 10));
    if (chatToSelect) {
      selectedChat.value = chatToSelect;
      // The watch handler will take care of fetching and starting polling
    }
  }
});

onUnmounted(() => {
  stopPolling();
});

const viewAd = () => {
  if (selectedChat.value && selectedChat.value.ad) {
    router.visit(route('product.show', selectedChat.value.ad.id));
  }
};

const finalizeNegotiation = async () => {
  if (!selectedChat.value) return;

  (window as any).showConfirm?.({
    title: 'Finalizar Negociação',
    message: 'Tem certeza que deseja finalizar esta negociação e marcar o item como vendido?\n\nIsso desativará o anúncio e todos os outros chats relacionados a ele.',
    confirmText: 'Sim, Finalizar',
    cancelText: 'Cancelar',
    onConfirm: () => {
      showReasonModal.value = true;
    }
  });
};

const confirmFinalization = async (reason: string) => {
  showReasonModal.value = false;
  if (!selectedChat.value) return;

  try {
    const response = await axios.post(route('chat.finalize', selectedChat.value.id), {
      finalization_reason: reason,
    });
    if (response.data.chat) {
      selectedChat.value.finalizado = response.data.chat.finalizado;
      fetchMessages(); // Re-fetch messages to show the system message
    }
  } catch (error) {
    console.error('Error finalizing negotiation:', error);
    (window as any).showToast?.('Ocorreu um erro ao tentar finalizar a negociação.', 'error');
  }
};
</script>

<style scoped>
.avatar-image {
  width: 100%;
  height: 100%;
  object-fit: cover;
  border-radius: 50%;
}

.chat-container {
  display: flex;
  height: calc(100vh - 118px); /* Adjust based on Navbar and Footer height */
  background-color: #cff8e4;
}

.chat-sidebar {
  width: 300px;
  border-right: 1px solid rgba(0, 0, 0, 0.1);
  display: flex;
  flex-direction: column;
}

.chat-sidebar-header {
  padding: 1rem;
  border-bottom: 1px solid rgba(0, 0, 0, 0.1);
}

.chat-messages-header {
  padding: 1.25rem;
  border-bottom: 1px solid rgba(0, 0, 0, 0.1);
}

.no-chats {
  padding: 1rem;
  text-align: center;
  color: #555;
}

.chat-list {
  list-style: none;
  padding: 0;
  margin: 0;
  overflow-y: auto;
}

.chat-list-item {
  display: flex;
  align-items: center;
  padding: 0.75rem 1rem;
  cursor: pointer;
  border-bottom: 1px solid rgba(0, 0, 0, 0.05);
}

.chat-list-item:hover {
  background-color: #b8e6d1;
}

.chat-list-item.active {
  background-color: #a3d9c0;
}

.chat-avatar {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 40px;
  height: 40px;
  margin-right: 0.75rem;
}

.chat-info {
  flex-grow: 1;
}

.chat-product-name {
  font-weight: bold;
  font-size: 1rem;
  color: black;
  margin: 0;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}

.chat-user-name {
  font-size: 0.8rem;
  color: gray;
  margin: 0;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}

.chat-content {
  flex-grow: 1;
  display: flex;
  flex-direction: column;
  background-color: #fff;
}

.no-chat-selected {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100%;
  text-align: center;
  color: #555;
}

.chat-messages {
  display: flex;
  flex-direction: column;
  height: 100%;
  min-height: 0;
}

.chat-messages-body {
  flex-grow: 1;
  padding: 1rem;
  overflow-y: auto;
  display: flex;
  flex-direction: column-reverse; /* Changed from column */
  /* Removed: justify-content: flex-end; */
  min-height: 0;
  height: 0;
}

.chat-messages-footer {
  display: flex;
  padding: 1rem;
  border-top: 1px solid rgba(0, 0, 0, 0.1);
  gap: 10px; /* Space between input and button */
}

.chat-messages-footer input {
  flex-grow: 1;
  padding: 0.75rem 1rem;
  border: 1px solid #ccc;
  border-radius: 20px;
  font-size: 1rem;
}

.chat-messages-footer button {
  padding: 0.75rem 1.5rem;
  background-color: #4CAF50; /* Green */
  color: white;
  border: none;
  border-radius: 20px;
  cursor: pointer;
  font-size: 1rem;
  transition: background-color 0.3s ease;
}

.chat-messages-footer button:hover {
  background-color: #45a049;
}

.message {
  display: flex;
  margin-bottom: 0.5rem;
}

.message.sent {
  justify-content: flex-end;
}

.message.received {
  justify-content: flex-start;
}

.message-content {
  max-width: 70%;
  padding: 0.75rem 1rem;
  border-radius: 15px;
  word-wrap: break-word;
}

.message.sent .message-content {
  background-color: #dcf8c6; /* Light green for sent messages */
  color: #333;
}

.message.received .message-content {
  background-color: #e0e0e0; /* Light gray for received messages */
  color: #333;
}

.message-time {
  font-size: 0.7rem;
  color: #777;
  margin-top: 0.2rem;
  display: block;
  text-align: right; /* Align time to the right for sent messages */
}

.message.received .message-time {
  text-align: left; /* Align time to the left for received messages */
}

.system-message {
  /* A margem inferior de 0.5rem é herdada da classe .message, criando o espaçamento */
  padding-bottom: 0 !important;
}

.system-message .message-content {
  background-color: #cff8e4 !important; /* Forçar a cor de fundo */
  font-size: 0.7rem;
  text-align: center;
  margin: 0 auto;
  border-radius: 15px; /* Rounded borders for system messages */
  padding: 0.75rem 1rem; /* Adjust padding for vertical centering */
  display: flex; /* Use flexbox for vertical centering */
  align-items: center; /* Vertically center content */
  justify-content: center; /* Horizontally center content */
  min-height: 40px; /* Ensure a minimum height for centering */
}

.system-message .message-time {
  display: none;
}
.negotiation-status-button {
  width: 100%; /* Make it horizontal and same width as ad banner */
  padding: 0.75rem 1.5rem;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  font-size: 1rem;
  margin-top: 1rem; /* Space below ad banner */
  transition: background-color 0.3s ease;
}

.finalize-button {
  background-color: #dc3545; /* Red color for finalize */
  color: white;
}

.finalize-button:hover {
  background-color: #c82333;
}

.reactivate-button {
  background-color: #28a745; /* Green color for reactivate */
  color: white;
}

.reactivate-button:hover {
  background-color: #218838;
}
.chat-messages-header {
  padding: 1.25rem;
  border-bottom: 1px solid rgba(0, 0, 0, 0.1);
}

.ad-button-container {
  display: flex;
  flex-direction: row; /* Changed from column */
  align-items: center; /* Changed from stretch */
  width: 100%;
  padding: 1rem;
  border-bottom: 1px solid rgba(0, 0, 0, 0.1);
}

.ad-button-container > .mt-4 { /* Targeting AdBanner with its class */
  flex-grow: 1; /* Make AdBanner take remaining space */
  margin-top: 0; /* Remove previous margin if any */
}

.view-ad-button {
  width: 20%;
  padding: 0.75rem 1.5rem;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  font-size: 1rem;
  margin-left: 10px;
  background-color: #007bff; /* Blue color for view ad */
  color: white;
  transition: background-color 0.3s ease;
}

.view-ad-button:hover {
  background-color: #0056b3;
}

.negotiation-status-button {
  width: 20%; /* Changed from 30% */
  margin: 0; /* Removed margin: 0 auto; */
  margin-left: 10px; /* Add some space between ad and button */
}

.chat-messages-footer input:disabled,
.chat-messages-footer button:disabled {
  cursor: not-allowed;
}
</style>