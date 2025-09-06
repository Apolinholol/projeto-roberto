<template>
    <div class="container mt-5 mb-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white" style="background: linear-gradient(to left, #5fd098 0%, #4ebf84 100%) !important;">
                        <h2 class="mb-0">
                            <i class="bi bi-megaphone me-2"></i>
                            CRIAR NOVO ANÚNCIO
                        </h2>
                    </div>
                    <div class="card-body">
                        <form @submit.prevent="salvarAnuncio">
                            <!-- Título do Anúncio -->
                            <div class="mb-3">
                                <label for="titulo" class="form-label">
                                    <strong>Título do Anúncio:</strong>
                                </label>
                                <input 
                                    type="text" 
                                    class="form-control" 
                                    id="titulo"
                                    v-model="form.titulo"
                                    :class="{ 'is-invalid': errors.titulo }"
                                    placeholder="Ex: iPhone 13 Pro Max 256GB - Estado de Novo"
                                    required
                                >
                                <div v-if="errors.titulo" class="invalid-feedback">
                                    {{ errors.titulo }}
                                </div>
                            </div>

                            <!-- Descrição do Produto -->
                            <div class="mb-3">
                                <label for="descricao" class="form-label">
                                    <strong>Descrição do Produto:</strong>
                                </label>
                                <textarea 
                                    class="form-control" 
                                    id="descricao"
                                    v-model="form.descricao"
                                    :class="{ 'is-invalid': errors.descricao }"
                                    rows="4"
                                    placeholder="Descreva detalhadamente seu produto: estado, características, motivo da venda, etc."
                                    required
                                ></textarea>
                                <div v-if="errors.descricao" class="invalid-feedback">
                                    {{ errors.descricao }}
                                </div>
                                <div class="form-text">
                                    {{ form.descricao.length }}/500 caracteres
                                </div>
                            </div>

                            <!-- Categoria -->
                            <div class="mb-3">
                                <label for="categoria" class="form-label">
                                    <strong>Categoria:</strong>
                                </label>
                                <div class="input-group">
                                    <select 
                                        class="form-select" 
                                        id="categoria"
                                        v-model="form.categoria_id"
                                        :class="{ 'is-invalid': errors.categoria_id }"
                                        required
                                    >
                                        <option value="">Selecione uma categoria</option>
                                        <option v-for="categoria in categorias" :key="categoria.id" :value="categoria.id">
                                            {{ categoria.name }}
                                        </option>
                                    </select>
                                    <button 
                                        type="button" 
                                        class="btn btn-outline-secondary"
                                        @click="mostrarModalCategoria = true"
                                        title="Adicionar nova categoria"
                                    >
                                        <i class="bi bi-plus-circle"></i>
                                    </button>
                                </div>
                                <div v-if="errors.categoria_id" class="invalid-feedback">
                                    {{ errors.categoria_id }}
                                </div>
                            </div>

                            <!-- Preço -->
                            <div class="mb-3">
                                <label for="preco" class="form-label">
                                    <strong>Preço (R$):</strong>
                                </label>
                                <input 
                                    type="number" 
                                    step="0.01"
                                    class="form-control" 
                                    id="preco"
                                    v-model="form.preco"
                                    :class="{ 'is-invalid': errors.preco }"
                                    placeholder="0,00"
                                    required
                                >
                                <div v-if="errors.preco" class="invalid-feedback">
                                    {{ errors.preco }}
                                </div>
                            </div>

                            <!-- Estoque -->
                            <div class="mb-3">
                                <label for="estoque" class="form-label">
                                    <strong>Quantidade em Estoque:</strong>
                                </label>
                                <input 
                                    type="number" 
                                    class="form-control" 
                                    id="estoque"
                                    v-model="form.estoque"
                                    :class="{ 'is-invalid': errors.estoque }"
                                    placeholder="Ex: 1"
                                    min="1"
                                    required
                                >
                                <div v-if="errors.estoque" class="invalid-feedback">
                                    {{ errors.estoque }}
                                </div>
                            </div>

                            <!-- Upload de Foto -->
                            <div class="mb-3">
                                <label for="fotos" class="form-label">
                                    <strong>Fotos do Produto:</strong>
                                </label>
                                <input 
                                    type="file" 
                                    class="form-control" 
                                    id="fotos"
                                    @change="handleFileUpload"
                                    accept="image/*"
                                    :class="{ 'is-invalid': errors.fotos }"
                                    multiple
                                    
                                >
                                
                                <div class="form-text">
                                    Formatos aceitos: JPG, PNG, WebP. Tamanho máximo: 5MB por arquivo. Máximo: 10 fotos
                                </div>
                                
                                <!-- Preview das fotos -->
                                <div v-if="previewFotos.length > 0" class="mt-3">
                                    <h6>Preview das Fotos ({{ previewFotos.length }}/10):</h6>
                                    <div class="row">
                                        <div 
                                            v-for="(preview, index) in previewFotos" 
                                            :key="index"
                                            class="col-6 col-md-4 col-lg-3 mb-3"
                                        >
                                            <div class="position-relative">
                                                <img 
                                                    :src="preview.url" 
                                                    :alt="'Preview ' + (index + 1)" 
                                                    class="img-thumbnail w-100" 
                                                    style="height: 150px; object-fit: cover;"
                                                >
                                                <button 
                                                    type="button" 
                                                    class="btn btn-danger btn-sm position-absolute top-0 end-0 m-1"
                                                    @click="removerFoto(index)"
                                                    style="border-radius: 50%; width: 30px; height: 30px; padding: 0;"
                                                >
                                                    <i class="bi bi-x"></i>
                                                </button>
                                                <div class="text-center mt-1">
                                                    <small class="text-muted">{{ preview.name }}</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center mt-2">
                                        <button 
                                            type="button" 
                                            class="btn btn-outline-danger btn-sm"
                                            @click="removerTodasFotos"
                                        >
                                            <i class="bi bi-trash"></i> Remover Todas
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Botões -->
                            <div class="d-flex gap-2 justify-content-end">
                                <button 
                                    type="button" 
                                    class="btn btn-secondary"
                                    @click="limparFormulario"
                                >
                                    <i class="bi bi-arrow-clockwise me-1"></i>
                                    Limpar
                                </button>
                                <button 
                                    type="submit" 
                                    class="btn btn-success"
                                    :disabled="salvando"
                                >
                                    <i class="bi bi-check-lg me-1" v-if="!salvando"></i>
                                    <div class="spinner-border spinner-border-sm me-1" v-if="salvando" role="status">
                                        <span class="visually-hidden">Salvando...</span>
                                    </div>
                                    {{ salvando ? 'Salvando...' : 'Salvar Anúncio' }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para adicionar nova categoria -->
    <div class="modal fade" :class="{ show: mostrarModalCategoria }" :style="{ display: mostrarModalCategoria ? 'block' : 'none' }" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="bi bi-plus-circle me-2"></i>
                        Adicionar Nova Categoria
                    </h5>
                    <button type="button" class="btn-close" @click="mostrarModalCategoria = false"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nomeCategoria" class="form-label">Nome da Categoria</label>
                        <input 
                            type="text" 
                            class="form-control" 
                            id="nomeCategoria"
                            v-model="novaCategoria.nome"
                            placeholder="Ex: Esportes"
                        >
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" @click="mostrarModalCategoria = false">
                        Cancelar
                    </button>
                    <button type="button" class="btn btn-primary" @click="adicionarCategoria">
                        <i class="bi bi-plus-lg me-1"></i>
                        Adicionar
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-backdrop fade" :class="{ show: mostrarModalCategoria }" v-if="mostrarModalCategoria"></div>
</template>

<script lang="ts" setup>
import App from '@/pages/App.vue';
import { ref, reactive, onMounted } from 'vue';
import { router } from '@inertiajs/vue3';

defineOptions({ layout: App });

// Props para receber categorias do backend
const props = defineProps<{
    categorias?: Array<{
        id: number;
        name: string;
    }>;
    errors?: Record<string, string>;
}>();

// Estados reativos
const salvando = ref(false);
const previewFotos = ref<Array<{url: string, name: string, file: File}>>([]);
const mostrarModalCategoria = ref(false);

// Formulário principal
const form = reactive({
    titulo: '',
    descricao: '',
    categoria_id: '',
    preco: '',
    estoque: 1,
    fotos: [] as File[],
});

// Formulário nova categoria
const novaCategoria = reactive({
    nome: ''
});

// Lista de categorias (com dados padrão se não vier do backend)
const categorias = ref(props.categorias || [
    { id: 1, name: 'Literatura' },
    { id: 2, name: 'Automotivos' },
    { id: 3, name: 'Eletrônicos' },
    { id: 4, name: 'Decoração' },
    { id: 5, name: 'Moda' }
]);

// Erros de validação
const errors = ref(props.errors || {});

// Função para upload de múltiplos arquivos
const handleFileUpload = (event: Event) => {
    const target = event.target as HTMLInputElement;
    const files = target.files;
    
    if (!files || files.length === 0) return;

    // Verificar se não excede o limite de 5 fotos
    if (previewFotos.value.length + files.length > 5) {
        alert(`Você pode adicionar no máximo 5 fotos. Atualmente você tem ${previewFotos.value.length} foto(s).`);
        return;
    }
    
    Array.from(files).forEach(file => {
        // Validar tipo de arquivo
        if (!file.type.startsWith('image/')) {
            alert(`O arquivo ${file.name} não é uma imagem válida.`);
            return;
        }
        
        // Validar tamanho (5MB)
        if (file.size > 5 * 1024 * 1024) {
            alert(`O arquivo ${file.name} deve ter no máximo 5MB.`);
            return;
        }
        
        // Verificar se a foto já não foi adicionado
        const jaExiste = previewFotos.value.some(preview => preview.name === file.name);
        if (jaExiste) {
            alert(`O arquivo ${file.name} já foi adicionado.`);
            return;
        }
        
        // Adicionar à lista de arquivos - CORREÇÃO AQUI
        form.fotos.push(file);
        
        // Criar preview
        const reader = new FileReader();
        reader.onload = (e) => {
            previewFotos.value.push({
                url: e.target?.result as string,
                name: file.name,
                file: file
            });
        };
        reader.readAsDataURL(file);
    });
    
    // Limpar o input para permitir selecionar os mesmos arquivos novamente
    target.value = '';
};

// Função para remover uma foto específica
const removerFoto = (index: number) => {
    previewFotos.value.splice(index, 1);
    form.fotos.splice(index, 1);
};

// Função para remover todas as fotos
const removerTodasFotos = () => {
    previewFotos.value = [];
    form.fotos = [];
    const input = document.getElementById('fotos') as HTMLInputElement;
    if (input) {
        input.value = '';
    }
};

// Função para adicionar nova categoria
const adicionarCategoria = async () => {
    if (!novaCategoria.nome.trim()) {
        alert('Por favor, digite o nome da categoria.');
        return;
    }
    
    try {
        // Aqui você pode fazer uma requisição para o backend para salvar a categoria
        const novaId = categorias.value.length + 1;
        categorias.value.push({
            id: novaId,
            name: novaCategoria.nome.trim()
        });
        
        // Selecionar a nova categoria
        form.categoria_id = novaId.toString();
        
        // Limpar e fechar modal
        novaCategoria.nome = '';
        mostrarModalCategoria.value = false;
        
        alert('Categoria adicionada com sucesso!');
    } catch (error) {
        alert('Erro ao adicionar categoria. Tente novamente.');
    }
};

// Função para validar formulário
const validarFormulario = () => {
    const novosErros: Record<string, string> = {};
    
    if (!form.titulo.trim()) {
        novosErros.titulo = 'O título é obrigatório.';
    }
    
    if (!form.descricao.trim()) {
        novosErros.descricao = 'A descrição é obrigatória.';
    } else if (form.descricao.length > 500) {
        novosErros.descricao = 'A descrição deve ter no máximo 500 caracteres.';
    }
    
    if (!form.categoria_id) {
        novosErros.categoria_id = 'A categoria é obrigatória.';
    }
    
    if (!form.preco || parseFloat(form.preco) <= 0) {
        novosErros.preco = 'O preço deve ser maior que zero.';
    }
    
    if (form.estoque < 1) {
        novosErros.estoque = 'O estoque deve ser pelo menos 1.';
    }
    
    if (form.fotos.length === 0) {
        novosErros.fotos = 'Pelo menos uma foto do produto é obrigatória.';
    }
    
    if (form.fotos.length > 10) {
        novosErros.fotos = 'Máximo de 10 fotos permitidas.';
    }
    
    errors.value = novosErros;
    return Object.keys(novosErros).length === 0;
};

// Função para salvar anúncio
const salvarAnuncio = async () => {
    if (!validarFormulario()) {
        return;
    }
    
    salvando.value = true;
    
    try {
        // Enviar para o backend usando Inertia
        router.post('/ad', form, {
            onSuccess: () => {
                alert('Anúncio criado com sucesso!');
                limparFormulario();
            },
            onError: (erros) => {
                errors.value = erros;
                alert('Erro ao salvar anúncio. Verifique os campos.');
            }
        });
        
    } catch (error) {
        alert('Erro ao salvar anúncio. Tente novamente.');
    } finally {
        salvando.value = false;
    }
};

// Função para limpar formulário
const limparFormulario = () => {
    form.titulo = '';
    form.descricao = '';
    form.categoria_id = '';
    form.preco = '';
    form.estoque = 1;
    form.fotos = [];
    previewFotos.value = [];
    errors.value = {};
    
    const input = document.getElementById('fotos') as HTMLInputElement;
    if (input) {
        input.value = '';
    }
};

// Carregar categorias ao montar o componente
onMounted(() => {
    // Aqui você pode fazer uma requisição para buscar categorias do backend
    // if (!props.categorias) {
    //     buscarCategorias();
    // }
});
</script>

<style scoped>
    
</style>