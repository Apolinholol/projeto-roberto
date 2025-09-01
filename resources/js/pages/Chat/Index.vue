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
            <i class="bi bi-person-circle fs-3"></i>
          </div>
          <div class="chat-info">
            <p class="chat-name">{{ chat.name }}</p>
            <p class="chat-last-message">{{ chat.lastMessage }}</p>
          </div>
        </li>
      </ul>
    </div>
    <div class="chat-content">
      <div v-if="selectedChat" class="chat-messages">
        <div class="chat-messages-header">
          <Heading :title="selectedChat.name" h2Class="text-center" />
        </div>
        <div class="chat-messages-body">
          <div
            v-for="message in messages"
            :key="message.id"
            class="message"
            :class="{ 'sent': message.user_id === user.id, 'received': message.user_id !== user.id }"
          >
            <div class="message-content">
              <p>{{ message.content }}</p>
              <span class="message-time">{{ new Date(message.created_at).toLocaleTimeString() }}</span>
            </div>
          </div>
        </div>
        <div class="chat-messages-footer">
          <input type="text" placeholder="Digite sua mensagem..." v-model="messageInput" @keyup.enter="sendMessage" />
          <button @click="sendMessage">Enviar</button>
        </div>
      </div>
      <div v-else class="no-chat-selected">
        <p>Abra um chat para exibir aqui</p>
      </div>
    </div>
  </div>
</template>

<script lang="ts" setup>
import { ref, computed, watch, nextTick } from 'vue';
import { usePage, router } from '@inertiajs/vue3';
import App from '@/pages/App.vue';
import Heading from '@/components/Heading.vue';
import axios from 'axios';

defineOptions({ layout: App });

interface Participant {
  id: number;
  nomeCompleto: string;
}

interface Chat {
  id: number;
  id_comprador: number;
  id_vendedor: number;
  buyer: Participant;
  seller: Participant;
}

interface Message {
  id: number;
  chat_id: number;
  user_id: number;
  content: string;
  created_at: string;
  updated_at: string;
  user: Participant; // Assuming user relationship is loaded
}

const page = usePage();
const user = computed(() => page.props.auth.user);

const props = defineProps<{
  chats: Chat[];
}>();

const formattedChats = computed(() => {
  if (!props.chats) return [];
  return props.chats.map(chat => {
    const otherParticipant = chat.id_comprador === user.value.id ? chat.seller : chat.buyer;
    return {
      id: chat.id,
      name: otherParticipant ? otherParticipant.nomeCompleto : 'Chat',
      lastMessage: '', // Será implementado depois
    };
  });
});

const selectedChat = ref(null);
const messageInput = ref('');
const messages = ref<Message[]>([]);

const fetchMessages = async () => {
  if (!selectedChat.value) {
    messages.value = [];
    return;
  }
  try {
    const response = await axios.get(route('chat.messages.get', selectedChat.value.id));
    messages.value = response.data;
    await nextTick();
    scrollToBottom();
  } catch (error) {
    console.error('Error fetching messages:', error);
  }
};

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
    messageInput.value = '';
    await nextTick();
    scrollToBottom();
  } catch (error) {
    console.error('Error sending message:', error);
  }
};

const scrollToBottom = () => {
  const messagesBody = document.querySelector('.chat-messages-body');
  if (messagesBody) {
    messagesBody.scrollTop = messagesBody.scrollHeight;
  }
};

watch(selectedChat, (newChat) => {
  if (newChat) {
    fetchMessages();
  }
}, { immediate: true });

const selectChat = (chat) => {
  selectedChat.value = chat;
};
</script>

<style scoped>
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

.chat-name {
  font-weight: bold;
  margin: 0;
}

.chat-last-message {
  font-size: 0.9rem;
  color: #333;
  margin: 0;
}

.chat-content {
  flex-grow: 1;
  display: flex;
  flex-direction: column;
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
}

.chat-messages-body {
  flex-grow: 1;
  padding: 1rem;
  overflow-y: auto;
  display: flex; /* Added for flexbox layout */
  flex-direction: column; /* Messages stack vertically */
  justify-content: flex-end; /* Newest messages at the bottom */
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
  padding: 0.5rem 0.75rem;
  border-radius: 0.75rem;
  word-wrap: break-word;
}

.message.sent .message-content {
  background-color: #dcf8c6; /* Light green for sent messages */
  color: #333;
}

.message.received .message-content {
  background-color: #fff; /* White for received messages */
  color: #333;
  border: 1px solid #eee;
}

.message-time {
  font-size: 0.7rem;
  color: #888;
  margin-top: 0.2rem;
  display: block;
  text-align: right;
}

.chat-messages-footer {
  padding: 1rem;
  border-top: 1px solid rgba(0, 0, 0, 0.1);
  display: flex;
}

.chat-messages-footer input {
  flex-grow: 1;
  border: 1px solid #ccc;
  border-radius: 20px;
  padding: 0.5rem 1rem;
  margin-right: 1rem;
}

.chat-messages-footer button {
  background-color: #002d17;
  color: white;
  border: none;
  border-radius: 20px;
  padding: 0.5rem 1.5rem;
  cursor: pointer;
}

.chat-messages-footer input::placeholder {
  color: rgba(0, 0, 0, 0.5); /* Black with 50% transparency */
}
</style>
