<template>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-12">
                <h2 class="text-center mb-4 questrial-font fw-bold" style="color: #002D17; font-size: 2.5rem;">
                    {{ isOwnProfile ? 'PERFIL DE USUÁRIO' : 'PERFIL DO VENDEDOR' }}
                </h2>

                <!-- Foto do usuário - Centralizada -->
                <div class="d-flex justify-content-center mb-5">
                    <div class="user-info p-4 d-flex align-items-center" style="max-width: 1200px; min-width: 300px; width: 100%; border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); border: 1px solid #e9ecef; background: white;">
                        <div class="text-center me-4" style="flex-shrink: 0;">
                            <img :src="state.usuario?.image_path" alt="Foto do usuário" class="profile-picture">
                        </div>

                        <div class="user-details flex-grow-1" style="border: 1px solid #cff8e4; border-radius: 15px;">
                            <h3 class="d-flex align-items-center questrial-font fw-bold"
                                style="color: #fff; padding: 15px; background: linear-gradient(135deg, #002D17 0%, #004D2A 100%); border-radius: 15px 15px 0 0; margin: 0;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor"
                                    class="bi bi-info-circle" viewBox="0 0 16 16">
                                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                                    <path
                                        d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0" />
                                </svg>
                                <span class="ms-2">{{ isOwnProfile ? 'Informações' : 'Dados do Vendedor' }}</span>
                            </h3>

                            <!-- Nome Completo -->
                            <div class="d-flex ml-4" style="padding: 10px;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor"
                                    class="bi bi-person-vcard" viewBox="0 0 16 16" style="color: #002D17;">
                                    <path
                                        d="M5 8a2 2 0 1 0 0-4 2 2 0 0 0 0 4m4-2.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5M9 8a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4A.5.5 0 0 1 9 8m1 2.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 0 1h-3a.5.5 0 0 1-.5-.5" />
                                    <path
                                        d="M2 2a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2zM1 4a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H8.96q.04-.245.04-.5C9 10.567 7.21 9 5 9c-2.086 0-3.8 1.398-3.984 3.181A1 1 0 0 1 1 12z" />
                                </svg>
                                <p class="user-complete-name d-flex mb-0 ml-2 align-items-center poppins-font fw-semibold" style="color: #333;">
                                    {{ state.usuario?.nomeCompleto || 'Nome não informado' }}
                                </p>
                            </div>

                            <!-- Nome de Usuário -->
                            <div class="d-flex ml-4" style="padding: 10px;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor"
                                    class="bi bi-at" viewBox="0 0 16 16" style="color: #002D17;">
                                    <path d="M13.106 7.222c0-2.967-2.249-5.032-5.482-5.032-3.35 0-5.646 2.318-5.646 5.702 0 3.493 2.235 5.708 5.762 5.708.862 0 1.689-.123 2.304-.335v-.862c-.43.199-1.354.328-2.29.328-2.926 0-4.813-1.88-4.813-4.798 0-2.844 1.921-4.881 4.594-4.881 2.735 0 4.608 1.688 4.608 4.156 0 1.682-.554 2.769-1.416 2.769-.492 0-.772-.28-.772-.76V5.206H8.923v.834h-.11c-.266-.595-.881-.964-1.6-.964-1.4 0-2.378 1.162-2.378 2.823 0 1.737.957 2.906 2.379 2.906.8 0 1.415-.39 1.709-1.087h.11c.081.67.703 1.148 1.503 1.148 1.572 0 2.57-1.415 2.57-3.643zm-7.177.704c0-1.197.54-1.907 1.456-1.907.93 0 1.524.738 1.524 1.907S8.308 9.84 7.371 9.84c-.895 0-1.442-.725-1.442-1.914z"/>
                                </svg>
                                <p class="user-username d-flex mb-0 ml-2 align-items-center poppins-font fw-semibold" style="color: #333;">
                                    {{ state.usuario?.nomeUsuario || 'Nome de usuário não informado' }}
                                </p>
                            </div>

                            <!-- Email - Mostrar apenas se for o próprio perfil -->
                            <div v-if="isOwnProfile" class="d-flex ml-4" style="padding: 10px;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor"
                                    class="bi bi-envelope" viewBox="0 0 16 16" style="color: #002D17;">
                                    <path
                                        d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1zm13 2.383-4.708 2.825L15 11.105zm-.034 6.876-5.64-3.471L8 9.583l-1.326-.795-5.64 3.47A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741M1 11.105l4.708-2.897L1 5.383z" />
                                </svg>
                                <p class="user-email d-flex mb-0 ml-2 align-items-center poppins-font fw-semibold" style="color: #333;">
                                    {{ state.usuario?.email || 'Email não informado' }}
                                </p>
                            </div>

                            <!-- CPF - Mostrar apenas se for o próprio perfil -->
                            <div v-if="isOwnProfile" class="d-flex ml-4" style="padding: 10px;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor"
                                    class="bi bi-card-text" viewBox="0 0 16 16" style="color: #002D17;">
                                    <path d="M14.5 3a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-13a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5zm-13-1A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2z"/>
                                    <path d="M3 5.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5M3 8a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9A.5.5 0 0 1 3 8m0 2.5a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5"/>
                                </svg>
                                <p class="user-cpf d-flex mb-0 ml-2 align-items-center poppins-font fw-semibold" style="color: #333;">
                                    {{ state.usuario?.cpf || 'CPF não informado' }}
                                </p>
                            </div>

                            <!-- Telefone - Mostrar apenas se for o próprio perfil -->
                            <div v-if="isOwnProfile" class="d-flex ml-4" style="padding: 10px;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor"
                                    class="bi bi-telephone" viewBox="0 0 16 16" style="color: #002D17;">
                                    <path
                                        d="M3.654 1.328a.678.678 0 0 0-1.015-.063L1.605 2.3c-.483.484-.661 1.169-.45 1.77a17.6 17.6 0 0 0 4.168 6.608 17.6 17.6 0 0 0 6.608 4.168c.601.211 1.286.033 1.77-.45l1.034-1.034a.678.678 0 0 0-.063-1.015l-2.307-1.794a.68.68 0 0 0-.58-.122l-2.19.547a1.75 1.75 0 0 1-1.657-.459L5.482 8.062a1.75 1.75 0 0 1-.46-1.657l.548-2.19a.68.68 0 0 0-.122-.58zM1.884.511a1.745 1.745 0 0 1 2.612.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.68.68 0 0 0 .178.643l2.457 2.457a.68.68 0 0 0 .644.178l2.189-.547a1.75 1.75 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.6 18.6 0 0 1-7.01-4.42 18.6 18.6 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877z" />
                                </svg>
                                <p class="user-phone d-flex mb-0 ml-2 align-items-center poppins-font fw-semibold" style="color: #333;">
                                    {{ state.usuario?.telefone || 'Telefone não informado' }}
                                </p>
                            </div>

                            <!-- Localização -->
                            <div class="d-flex ml-4" style="padding: 10px;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor"
                                    class="bi bi-geo-alt" viewBox="0 0 16 16" style="color: #002D17;">
                                    <path
                                        d="M12.166 8.94c-.524 1.062-1.234 2.12-1.96 3.07A32 32 0 0 1 8 14.58a32 32 0 0 1-2.206-2.57c-.726-.95-1.436-2.008-1.96-3.07C3.304 7.867 3 6.862 3 6a5 5 0 0 1 10 0c0 .862-.305 1.867-.834 2.94M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10" />
                                    <path d="M8 8a2 2 0 1 1 0-4 2 2 0 0 1 0 4m0 1a3 3 0 1 0 0-6 3 3 0 0 0 0 6" />
                                </svg>
                                <p class="user-city d-flex mb-0 ml-2 align-items-center poppins-font fw-semibold" style="color: #333;">
                                   {{ state.usuario.cidade}} - {{ state.usuario.uf }}
                                </p>
                            </div>

                            <!-- Membro desde -->
                            <div v-if="!isOwnProfile" class="d-flex ml-4" style="padding: 10px;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor"
                                    class="bi bi-calendar-check" viewBox="0 0 16 16" style="color: #002D17;">
                                    <path d="M10.854 7.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 9.793l2.646-2.647a.5.5 0 0 1 .708 0"/>
                                    <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5M1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4z"/>
                                </svg>
                                <p class="d-flex mb-0 ml-2 align-items-center poppins-font" style="color: #666;">
                                    <small>Membro desde {{ formatarDataEntrada(state.usuario?.created_at) }}</small>
                                </p>
                            </div>

                            <!-- Botão de editar - apenas se for próprio perfil -->
                            <div v-if="isOwnProfile" class="d-flex justify-content-end" style="padding: 15px;">
                                <button class="btn d-flex align-items-center questrial-font fw-bold"
                                    style="border-radius: 25px; background: linear-gradient(135deg, #002D17 0%, #004D2A 100%); color: white; border: none; padding: 10px 20px; transition: all 0.3s ease;"
                                    @click="abrirModalEdicao"
                                    onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 20px rgba(0, 45, 23, 0.3)'"
                                    onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                        class="bi bi-pencil mr-1" viewBox="0 0 16 16">
                                        <path
                                            d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325" />
                                    </svg>
                                    <span class="ms-2">Editar Perfil</span>
                                </button>
                            </div>

                            <!-- Estatísticas do vendedor - apenas se não for próprio perfil -->
                            <div v-if="!isOwnProfile" class="d-flex justify-content-around mt-3 p-3" style="background: linear-gradient(45deg, #cff8e4 0%, #e8fdf0 100%); border-radius: 12px; margin: 15px;">
                                <div class="text-center">
                                    <h6 class="mb-1 questrial-font fw-bold" style="color: #006B3C; font-size: 1.2rem;">{{ anunciosAtivos }}</h6>
                                    <small class="poppins-font fw-semibold" style="color: #002D17;">Anúncios Ativos</small>
                                </div>
                                <div class="text-center">
                                    <h6 class="mb-1 questrial-font fw-bold" style="color: #004D2A; font-size: 1.2rem;">{{ totalAnuncios }}</h6>
                                    <small class="poppins-font fw-semibold" style="color: #002D17;">Total de Anúncios</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="user-info p-4 mb-3 mt-5 d-flex flex-column align-items-center justify-content-center"
                    style="border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); border: 1px solid #e9ecef; background: white;">
                    <h3 class="d-flex align-items-center justify-content-center questrial-font fw-bold" 
                        style="padding-top: 15px; color: #002D17; font-size: 2rem;">
                        {{ isOwnProfile ? 'HISTÓRICO DE ANÚNCIOS' : 'ANÚNCIOS DO VENDEDOR' }}
                    </h3>

                    <div class="w-100">
                        <p class="justify-content-center mt-3 mb-4 text-center poppins-font" style="color: #666; line-height: 1.6;">
                            {{ isOwnProfile 
                                ? 'Veja abaixo todos os seus anúncios. Edite, ative, desative ou apenas visualize cada um deles com facilidade.' 
                                : `Confira os anúncios de ${state.usuario?.nomeCompleto || 'este vendedor'}. Clique em qualquer anúncio para ver os detalhes.`
                            }}
                        </p>

                        <!-- Mensagem quando não há anúncios -->
                        <div v-if="!anuncios || anuncios.length === 0" class="text-center"
                            style="padding-bottom: 20px;">
                            <p class="poppins-font mb-0" style="color: #666;">
                                {{ isOwnProfile 
                                    ? 'Nenhum anúncio cadastrado.' 
                                    : 'Este vendedor ainda não possui anúncios cadastrados.'
                                }}
                                <br v-if="isOwnProfile">
                                <a v-if="isOwnProfile" href="/AdsManager" 
                                   class="questrial-font fw-bold"
                                   style="color: #002D17; text-decoration: none; transition: all 0.3s ease;"
                                   onmouseover="this.style.color='#004D2A'"
                                   onmouseout="this.style.color='#002D17'">
                                    Clique aqui para criar o seu primeiro anúncio.
                                </a>
                            </p>
                        </div>

                        <div v-else class="row g-3 justify-content-center">
                            <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-3" v-for="ad in anunciosVisiveis" :key="ad.id">
                                <div class="card d-flex flex-column h-100"
                                    :class="!isOwnProfile ? 'cursor-pointer' : ''"
                                    @click="!isOwnProfile ? verDetalhesAnuncio(ad) : null"
                                    style="width: 220px; height: 300px; background-color:#049f55; border-radius: 18px; overflow: hidden; margin: 0 auto; position: relative;">

                                    <!-- Container da imagem com overlay -->
                                    <div style="position: relative; width: 100%; height: 170px;">
                                        <img :src="getPrimeiraImagem(ad)" class="card-img-top" :style="`object-fit:cover; object-position: center;
                                            width: 100%; height: 170px; border-radius: 0;
                                            padding-top: 15px; padding-inline: 10px;
                                            ${!ad.is_active ? 'filter: blur(2px) brightness(0.7);' : ''}`"
                                            @error="handleImageError">

                                        <!-- Badge de status desativado - apenas sobre a área da foto (com mesmo padding) -->
                                        <div v-if="!ad.is_active"
                                            class="position-absolute d-flex align-items-center justify-content-center"
                                            style="top: 15px; left: 10px; right: 10px; bottom: 0; background-color: rgba(0,0,0,0.6); z-index: 5; border-radius: 8px;">
                                            <div class="text-center">
                                                <i class="bi bi-pause-circle-fill text-warning"
                                                    style="font-size: 2.5rem;"></i>
                                                <p class="text-white mt-2 mb-0 fw-bold" style="font-size: 0.8rem;">
                                                    ANÚNCIO<br>DESATIVADO</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card-body p-2" style="flex: 0 0 auto; height: 70px;">
                                        <!-- Layout em duas colunas -->
                                        <div class="d-flex h-100 align-items-center">
                                            <!-- Coluna esquerda: Nome e Preço -->
                                            <div class="flex-fill text-center"
                                                style="border-right: 1px solid #ffffff40; padding-right: 8px;">
                                                <h6 class="card-title mb-1"
                                                    style="font-size: 0.8rem; line-height: 1.0; color: white; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; line-clamp: 2; -webkit-box-orient: vertical;">
                                                    {{ ad.name }}
                                                </h6>
                                                <p class="card-text mb-0"
                                                    style="font-size: 0.75rem; color: white; font-weight: bold;">
                                                    R$ {{ ad.price }}
                                                </p>
                                            </div>

                                            <!-- Coluna direita: Outras informações -->
                                            <div class="flex-fill text-center" style="padding-left: 8px;">
                                                <p class="mb-1"
                                                    style="color: #ccc; line-height: 1.1; font-size: 0.7rem;">
                                                    Estoque: {{ ad.stock }}
                                                </p>
                                                <p class="mb-1" :class="ad.is_active ? 'text-light' : 'text-warning'"
                                                    style="line-height: 1.1; font-size: 0.7rem; font-weight: bold;">
                                                    {{ ad.is_active ? 'Ativo' : 'Inativo' }}
                                                </p>
                                                <p class="mb-0"
                                                    style="color: #ccc; line-height: 1.1; font-size: 0.65rem;">
                                                    {{ formatarData(ad.created_at) }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Footer com botões - apenas se for o próprio perfil -->
                                    <div class="card-footer d-flex justify-content-center gap-1 py-1" v-if="isOwnProfile"
                                        style="background-color: #002d17; font-size: 0.75rem;">
                                        <button class="btn btn-sm btn-warning"
                                            style="font-size: 0.7rem; padding: 2px 6px;" title="Editar"
                                            @click="editAd(ad)">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <button class="btn btn-sm"
                                            :class="ad.is_active ? 'btn-secondary' : 'btn-success'"
                                            style="font-size: 0.7rem; padding: 2px 6px;"
                                            :title="ad.is_active ? 'Desativar' : 'Ativar'" @click="toggleStatus(ad)">
                                            <i :class="ad.is_active ? 'bi bi-pause' : 'bi bi-play'"></i>
                                        </button>
                                        <button class="btn btn-sm btn-danger"
                                            style="font-size: 0.7rem; padding: 2px 6px;" title="Excluir"
                                            @click="deleteAd(ad)">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Modal de Edição de Perfil -->
    <div class="modal fade" :class="{ 'show d-block': state.modalEdicao }" tabindex="-1" 
         style="background-color: rgba(0,0,0,0.5);" 
         v-if="state.modalEdicao">
        <div class="modal-dialog modal-lg modal-dialog-centered" style="max-width: 90%; width: 600px;">
            <div class="modal-content" style="border-radius: 15px; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.3);">
                <div class="modal-header" style="background: linear-gradient(135deg, #002D17 0%, #004D2A 100%); color: white; border-radius: 15px 15px 0 0; border: none;">
                    <h5 class="modal-title questrial-font fw-bold">
                        <i class="bi bi-pencil me-2"></i>
                        Editar Perfil
                    </h5>
                    <button type="button" class="btn-close btn-close-white" @click="fecharModalEdicao"></button>
                </div>
                <div class="modal-body" style="background: white; padding: 30px;">
                    <form @submit.prevent="salvarPerfil">
                        <div class="row">
                            <!-- Nome Completo -->
                            <div class="col-md-6 mb-3">
                                <label for="nomeCompleto" class="form-label poppins-font fw-semibold" style="color: #002D17;">
                                    <i class="bi bi-person me-1"></i>
                                    Nome Completo
                                </label>
                                <input 
                                    type="text" 
                                    class="form-control" 
                                    id="nomeCompleto"
                                    v-model="state.formEdicao.nomeCompleto"
                                    style="border: 2px solid #e9ecef; border-radius: 10px; transition: all 0.3s ease;"
                                    onfocus="this.style.borderColor='#cff8e4'; this.style.boxShadow='0 0 0 0.2rem rgba(207, 248, 228, 0.25)'"
                                    onblur="this.style.borderColor='#e9ecef'; this.style.boxShadow='none'"
                                    required
                                >
                            </div>
                            
                            <!-- Nome de Usuário -->
                            <div class="col-md-6 mb-3">
                                <label for="nomeUsuario" class="form-label poppins-font fw-semibold" style="color: #002D17;">
                                    <i class="bi bi-at me-1"></i>
                                    Nome de Usuário
                                </label>
                                <input 
                                    type="text" 
                                    class="form-control" 
                                    id="nomeUsuario"
                                    v-model="state.formEdicao.nomeUsuario"
                                    style="border: 2px solid #e9ecef; border-radius: 10px; transition: all 0.3s ease;"
                                    onfocus="this.style.borderColor='#cff8e4'; this.style.boxShadow='0 0 0 0.2rem rgba(207, 248, 228, 0.25)'"
                                    onblur="this.style.borderColor='#e9ecef'; this.style.boxShadow='none'"
                                    required
                                >
                            </div>
                            
                            <!-- Email -->
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label poppins-font fw-semibold" style="color: #002D17;">
                                    <i class="bi bi-envelope me-1"></i>
                                    Email
                                </label>
                                <input 
                                    type="email" 
                                    class="form-control" 
                                    id="email"
                                    v-model="state.formEdicao.email"
                                    style="border: 2px solid #e9ecef; border-radius: 10px; transition: all 0.3s ease;"
                                    onfocus="this.style.borderColor='#cff8e4'; this.style.boxShadow='0 0 0 0.2rem rgba(207, 248, 228, 0.25)'"
                                    onblur="this.style.borderColor='#e9ecef'; this.style.boxShadow='none'"
                                    required
                                >
                            </div>
                            
                            <!-- CPF -->
                            <div class="col-md-6 mb-3">
                                <label for="cpf" class="form-label poppins-font fw-semibold" style="color: #002D17;">
                                    <i class="bi bi-card-text me-1"></i>
                                    CPF
                                </label>
                                <input 
                                    type="text" 
                                    class="form-control" 
                                    id="cpf"
                                    v-model="state.formEdicao.cpf"
                                    placeholder="000.000.000-00"
                                    style="border: 2px solid #e9ecef; border-radius: 10px; transition: all 0.3s ease;"
                                    onfocus="this.style.borderColor='#cff8e4'; this.style.boxShadow='0 0 0 0.2rem rgba(207, 248, 228, 0.25)'"
                                    onblur="this.style.borderColor='#e9ecef'; this.style.boxShadow='none'"
                                    required
                                >
                            </div>
                            
                            <!-- Telefone -->
                            <div class="col-md-6 mb-3">
                                <label for="telefone" class="form-label poppins-font fw-semibold" style="color: #002D17;">
                                    <i class="bi bi-telephone me-1"></i>
                                    Telefone
                                </label>
                                <input 
                                    type="text" 
                                    class="form-control" 
                                    id="telefone"
                                    v-model="state.formEdicao.telefone"
                                    placeholder="(00) 00000-0000"
                                    style="border: 2px solid #e9ecef; border-radius: 10px; transition: all 0.3s ease;"
                                    onfocus="this.style.borderColor='#cff8e4'; this.style.boxShadow='0 0 0 0.2rem rgba(207, 248, 228, 0.25)'"
                                    onblur="this.style.borderColor='#e9ecef'; this.style.boxShadow='none'"
                                    required
                                >
                            </div>
                            
                            <!-- Cidade -->
                            <div class="col-md-6 mb-3">
                                <label for="cidade" class="form-label poppins-font fw-semibold" style="color: #002D17;">
                                    <i class="bi bi-geo-alt me-1"></i>
                                    Cidade
                                </label>
                                <input 
                                    type="text" 
                                    class="form-control" 
                                    id="cidade"
                                    v-model="state.formEdicao.cidade"
                                    style="border: 2px solid #e9ecef; border-radius: 10px; transition: all 0.3s ease;"
                                    onfocus="this.style.borderColor='#cff8e4'; this.style.boxShadow='0 0 0 0.2rem rgba(207, 248, 228, 0.25)'"
                                    onblur="this.style.borderColor='#e9ecef'; this.style.boxShadow='none'"
                                    required
                                >
                            </div>
                            
                            <!-- UF -->
                            <div class="col-md-6 mb-3">
                                <label for="uf" class="form-label poppins-font fw-semibold" style="color: #002D17;">
                                    <i class="bi bi-geo me-1"></i>
                                    Estado (UF)
                                </label>
                                <select class="form-select" id="uf" v-model="state.formEdicao.uf" 
                                        style="border: 2px solid #e9ecef; border-radius: 10px; transition: all 0.3s ease;"
                                        onfocus="this.style.borderColor='#cff8e4'; this.style.boxShadow='0 0 0 0.2rem rgba(207, 248, 228, 0.25)'"
                                        onblur="this.style.borderColor='#e9ecef'; this.style.boxShadow='none'"
                                        required>
                                    <option value="">Selecione um estado</option>
                                    <option value="AC">Acre</option>
                                    <option value="AL">Alagoas</option>
                                    <option value="AP">Amapá</option>
                                    <option value="AM">Amazonas</option>
                                    <option value="BA">Bahia</option>
                                    <option value="CE">Ceará</option>
                                    <option value="DF">Distrito Federal</option>
                                    <option value="ES">Espírito Santo</option>
                                    <option value="GO">Goiás</option>
                                    <option value="MA">Maranhão</option>
                                    <option value="MT">Mato Grosso</option>
                                    <option value="MS">Mato Grosso do Sul</option>
                                    <option value="MG">Minas Gerais</option>
                                    <option value="PA">Pará</option>
                                    <option value="PB">Paraíba</option>
                                    <option value="PR">Paraná</option>
                                    <option value="PE">Pernambuco</option>
                                    <option value="PI">Piauí</option>
                                    <option value="RJ">Rio de Janeiro</option>
                                    <option value="RN">Rio Grande do Norte</option>
                                    <option value="RS">Rio Grande do Sul</option>
                                    <option value="RO">Rondônia</option>
                                    <option value="RR">Roraima</option>
                                    <option value="SC">Santa Catarina</option>
                                    <option value="SP">São Paulo</option>
                                    <option value="SE">Sergipe</option>
                                    <option value="TO">Tocantins</option>
                                </select>
                            </div>
                            
                            <!-- Foto de Perfil -->
                            <div class="col-12 mb-3">
                                <label for="fotoPerfil" class="form-label poppins-font fw-semibold" style="color: #002D17;">
                                    <i class="bi bi-camera me-1"></i>
                                    Foto de Perfil
                                </label>
                                
                                <!-- Preview da foto atual -->
                                <div class="mb-3" v-if="state.usuario?.image_path">
                                    <p class="small poppins-font mb-2" style="color: #666;">Foto atual:</p>
                                    <img :src="state.usuario.image_path" 
                                         alt="Foto atual" 
                                         style="width: 100px; height: 100px; border-radius: 50%; object-fit: cover; border: 3px solid #cff8e4;">
                                </div>
                                
                                <!-- Preview da nova foto -->
                                <div class="mb-3" v-if="state.previewNovaFoto">
                                    <p class="small poppins-font mb-2" style="color: #006B3C;">Nova foto:</p>
                                    <img :src="state.previewNovaFoto" 
                                         alt="Nova foto" 
                                         style="width: 100px; height: 100px; border-radius: 50%; object-fit: cover; border: 3px solid #006B3C;">
                                </div>
                                
                                <input 
                                    type="file" 
                                    class="form-control" 
                                    id="fotoPerfil"
                                    @change="handleFileUpload"
                                    accept="image/*"
                                    style="border: 2px solid #e9ecef; border-radius: 10px; transition: all 0.3s ease;"
                                    onfocus="this.style.borderColor='#cff8e4'; this.style.boxShadow='0 0 0 0.2rem rgba(207, 248, 228, 0.25)'"
                                    onblur="this.style.borderColor='#e9ecef'; this.style.boxShadow='none'"
                                >
                                <small class="poppins-font" style="color: #666;">Formatos aceitos: JPG, PNG, WebP. Tamanho máximo: 2MB</small>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer" style="background: linear-gradient(45deg, #cff8e4 0%, #e8fdf0 100%); border-radius: 0 0 15px 15px; border: none; padding: 20px;">
                    <button type="button" class="btn poppins-font fw-semibold" 
                            @click="fecharModalEdicao"
                            style="background: #6c757d; color: white; border: none; border-radius: 25px; padding: 10px 20px; transition: all 0.3s ease;"
                            onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(108, 117, 125, 0.3)'"
                            onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                        <i class="bi bi-x-lg me-1"></i>
                        Cancelar
                    </button>
                    <button type="button" class="btn questrial-font fw-bold" 
                            @click="salvarPerfil" 
                            :disabled="state.salvandoPerfil"
                            style="background: linear-gradient(135deg, #002D17 0%, #004D2A 100%); color: white; border: none; border-radius: 25px; padding: 10px 20px; transition: all 0.3s ease;"
                            onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 20px rgba(0, 45, 23, 0.3)'"
                            onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                        <div class="spinner-border spinner-border-sm me-1" v-if="state.salvandoPerfil" role="status">
                            <span class="visually-hidden">Salvando...</span>
                        </div>
                        <i class="bi bi-check-lg me-1" v-if="!state.salvandoPerfil"></i>
                        {{ state.salvandoPerfil ? 'Salvando...' : 'Salvar Alterações' }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script lang="ts" setup>
import imgEntrada from '@images/VendIFF.png';
import App from '@/pages/App.vue';
import { ref, computed, onMounted, reactive } from 'vue';
import { router, usePage } from '@inertiajs/vue3';

defineOptions({ layout: App });

// Obter dados do usuário logado
const page = usePage();
const usuarioAuth = page.props.auth?.user ;

const state = reactive({
    usuario: {
        id: 0,
        nomeCompleto: '',
        nomeUsuario: '',
        email: '',
        cpf: '',
        telefone: '',
        cidade: '',
        uf: '',
        image_path: '',
        created_at: ''
    },
    modalEdicao: false,
    previewNovaFoto: null as string | null,
    formEdicao: {
        nomeCompleto: '',
        nomeUsuario: '',
        email: '',
        cpf: '',
        telefone: '',
        cidade: '',
        uf: '',
        image_path: null as File | null
    },
    salvandoPerfil: false
});
// Props vindas do backend
const props = defineProps<{
    anuncios?: Array<{
        id: number;
        name: string;
        description?: string;
        price: string;
        stock: number;
        image_path?: string | Array<string>;
        is_active: boolean;
        created_at: string;
    }>;
    anunciante: any;
}>();

// Computed para verificar se é o próprio perfil
const isOwnProfile = computed(() => {
    return !props.anunciante || props.anunciante.id === undefined || props.anunciante.id === usuarioAuth?.id;
});

// Computed para anúncios visíveis (apenas ativos se for perfil de outro usuário)
const anunciosVisiveis = computed(() => {
    if (!props.anuncios) return [];
    return isOwnProfile.value ? props.anuncios : props.anuncios.filter(ad => ad.is_active);
});

// Computed para estatísticas do vendedor
const anunciosAtivos = computed(() => {
    return props.anuncios?.filter(ad => ad.is_active).length || 0;
});

const totalAnuncios = computed(() => {
    return props.anuncios?.length || 0;
});

onMounted(() => {
    console.log(props.anunciante);

    if(props.anunciante?.id > 0) {
        // Carregar dados do anunciante (quando visualizando perfil de outro usuário)
        state.usuario = {
            id: props.anunciante.id || 0,
            nomeCompleto: props.anunciante.nomeCompleto || '',
            nomeUsuario: props.anunciante.nomeUsuario || '',
            email: props.anunciante.email || '',
            cpf: props.anunciante.cpf || '',
            telefone: props.anunciante.telefone || '',
            cidade: props.anunciante.cidade || '',
            uf: props.anunciante.uf || '',
            image_path: props.anunciante.image_path || '',
            created_at: props.anunciante.created_at || ''
        };
    } else {
        // Carregar dados do usuário logado
        const user = usuarioAuth as any;
        state.usuario = {
            id: user?.id || 0,
            nomeCompleto: user?.nomeCompleto || '',
            nomeUsuario: user?.nomeUsuario || '',
            email: user?.email || '',
            cpf: user?.cpf || '',
            telefone: user?.telefone || '',
            cidade: user?.cidade || '',
            uf: user?.uf || '',
            image_path: user?.image_path || '',
            created_at: user?.created_at || ''
        };
    }
}); 

// Função para obter a primeira imagem do anúncio (reutilizada da Home)
const getPrimeiraImagem = (ad: any) => {
    console.log('Processando imagem para anúncio:', ad.name, 'image_path:', ad.image_path);

    if (ad.image_path) {
        try {
            // Se image_path já é um array (cast do Laravel)
            if (Array.isArray(ad.image_path)) {
                if (ad.image_path.length > 0) {
                    const imagePath = `/storage/${ad.image_path[0]}`;
                    console.log('Imagem encontrada (array):', imagePath);
                    return imagePath;
                }
            } else if (typeof ad.image_path === 'string') {
                // Se é string JSON, fazer parse
                const imagens = JSON.parse(ad.image_path);
                if (imagens && Array.isArray(imagens) && imagens.length > 0) {
                    const imagePath = `/storage/${imagens[0]}`;
                    console.log('Imagem encontrada (string):', imagePath);
                    return imagePath;
                }
            }
        } catch (e) {
            console.error('Erro ao processar imagens:', e);
        }
    }

    console.log('Usando imagem padrão para:', ad.name);
    // Retorna imagem padrão se não houver imagem
    return imgEntrada;
};

// Função para lidar com erro de carregamento de imagem
const handleImageError = (event: Event) => {
    const target = event.target as HTMLImageElement;
    if (target) {
        target.src = imgEntrada;
    }
};

// Função para alterar status do anúncio (ativar/desativar)
const toggleStatus = async (ad: any) => {
    try {
        router.patch(`/my-ads/${ad.id}`, {
            is_active: !ad.is_active
        }, {
            onSuccess: () => {
                const novoStatus = !ad.is_active;
                ad.is_active = novoStatus; // Atualizar localmente
                const statusText = novoStatus ? 'ativado' : 'desativado';
                const statusIcon = novoStatus ? '✅' : '⏸️';
                (window as any).showToast?.(`${statusIcon} Anúncio ${statusText} com sucesso!`, 'success');
            },
            onError: () => {
                (window as any).showToast?.('Erro ao alterar status do anúncio.', 'error');
            }
        });
    } catch (error) {
        console.error('Erro ao alterar status:', error);
        (window as any).showToast?.('Erro ao alterar status do anúncio.', 'error');
    }
};

// Função para excluir anúncio
const deleteAd = async (ad: any) => {
    (window as any).showConfirm?.({
        title: 'Excluir Anúncio',
        message: `Tem certeza que deseja excluir o anúncio "${ad.name}"?\n\nEsta ação não pode ser desfeita.`,
        confirmText: 'Excluir',
        cancelText: 'Cancelar',
        onConfirm: async () => {
            try {
                router.delete(`/my-ads/${ad.id}`, {
                    onSuccess: () => {
                        (window as any).showToast?.('Anúncio excluído com sucesso!', 'success');
                        // Recarregar a página para atualizar a lista
                        router.reload();
                    },
                    onError: () => {
                        (window as any).showToast?.('Erro ao excluir anúncio.', 'error');
                    }
                });
            } catch (error) {
                console.error('Erro ao excluir anúncio:', error);
                (window as any).showToast?.('Erro ao excluir anúncio.', 'error');
            }
        }
    });
};

// Função para formatar data em formato brasileiro
const formatarData = (dataString: string) => {
    try {
        const data = new Date(dataString);
        return data.toLocaleDateString('pt-BR', {
            day: '2-digit',
            month: '2-digit',
            year: 'numeric'
        });
    } catch (error) {
        console.error('Erro ao formatar data:', error);
        return 'Data inválida';
    }
};

// Função para formatar data de entrada no site
const formatarDataEntrada = (dataString: string) => {
    try {
        const data = new Date(dataString);
        return data.toLocaleDateString('pt-BR', {
            month: 'long',
            year: 'numeric'
        });
    } catch (error) {
        console.error('Erro ao formatar data:', error);
        return 'Data inválida';
    }
};

// Função para ver detalhes do anúncio
const verDetalhesAnuncio = (ad: any) => {
    router.visit(`/product/${ad.id}`);
};

// Função para editar anúncio
const editAd = (ad: any) => {
    // Verificar se o anúncio está ativo
    if (!ad.is_active) {
        (window as any).showToast?.('Só é possível editar anúncios ativos. Este anúncio está desativado.', 'warning');
        return;
    }
    
    // Redirecionar para AdsManager com os dados do anúncio para edição
    router.visit(`/AdsManager/edit/${ad.id}`);
};

// Função para abrir modal de edição
const abrirModalEdicao = () => {
    // Preencher formulário com dados atuais
    state.formEdicao = {
        nomeCompleto: state.usuario.nomeCompleto || '',
        nomeUsuario: state.usuario.nomeUsuario || '',
        email: state.usuario.email || '',
        cpf: state.usuario.cpf || '',
        telefone: state.usuario.telefone || '',
        cidade: state.usuario.cidade || '',
        uf: state.usuario.uf || '',
        image_path: null
    };
    state.modalEdicao = true;
};

// Função para fechar modal de edição
const fecharModalEdicao = () => {
    state.modalEdicao = false;
    state.previewNovaFoto = null;
    state.formEdicao = {
        nomeCompleto: '',
        nomeUsuario: '',
        email: '',
        cpf: '',
        telefone: '',
        cidade: '',
        uf: '',
        image_path: null
    };
};

// Função para lidar com upload de arquivo
const handleFileUpload = (event: Event) => {
    const target = event.target as HTMLInputElement;
    const file = target.files?.[0];
    
    if (!file) {
        state.previewNovaFoto = null;
        return;
    }
    
    // Validar tipo de arquivo
    if (!file.type.startsWith('image/')) {
        (window as any).showToast?.('Por favor, selecione apenas arquivos de imagem.', 'error');
        target.value = '';
        state.previewNovaFoto = null;
        return;
    }
    
    // Validar tamanho (2MB)
    if (file.size > 2 * 1024 * 1024) {
        (window as any).showToast?.('A imagem deve ter no máximo 2MB.', 'error');
        target.value = '';
        state.previewNovaFoto = null;
        return;
    }
    
    state.formEdicao.image_path = file;
    
    // Criar preview da nova foto
    const reader = new FileReader();
    reader.onload = (e) => {
        state.previewNovaFoto = e.target?.result as string;
    };
    reader.readAsDataURL(file);
};

// Função para validar CPF
const validarCPF = (cpf: string): boolean => {
    cpf = cpf.replace(/\D/g, '');
    
    if (cpf.length !== 11 || /^(\d)\1{10}$/.test(cpf)) {
        return false;
    }
    
    let soma = 0;
    for (let i = 1; i <= 9; i++) {
        soma += parseInt(cpf.substring(i - 1, i)) * (11 - i);
    }
    
    let resto = soma % 11;
    resto = resto < 2 ? 0 : 11 - resto;
    
    if (resto !== parseInt(cpf.substring(9, 10))) return false;
    
    soma = 0;
    for (let i = 1; i <= 10; i++) {
        soma += parseInt(cpf.substring(i - 1, i)) * (12 - i);
    }
    
    resto = soma % 11;
    resto = resto < 2 ? 0 : 11 - resto;
    
    if (resto !== parseInt(cpf.substring(10, 11))) return false;
    
    return true;
};

// Função para salvar perfil
const salvarPerfil = async () => {
    // Validar CPF se fornecido
    if (state.formEdicao.cpf && !validarCPF(state.formEdicao.cpf)) {
        (window as any).showToast?.('CPF inválido.', 'error');
        return;
    }
    
    state.salvandoPerfil = true;
    
    try {
        // Criar FormData para envio de arquivos
        const formData = new FormData();
        formData.append('nomeCompleto', state.formEdicao.nomeCompleto);
        formData.append('nomeUsuario', state.formEdicao.nomeUsuario);
        formData.append('email', state.formEdicao.email);
        formData.append('cpf', state.formEdicao.cpf);
        formData.append('telefone', state.formEdicao.telefone);
        formData.append('cidade', state.formEdicao.cidade);
        formData.append('uf', state.formEdicao.uf);
        
        if (state.formEdicao.image_path) {
            formData.append('image_path', state.formEdicao.image_path);
        }
        
        formData.append('_method', 'PUT');
        
        router.post('/profile/update', formData, {
            forceFormData: true,
            onSuccess: () => {
                (window as any).showToast?.('Perfil atualizado com sucesso! Atualize a página para ver os resultados.', 'success');
                fecharModalEdicao();
                // Recarregar página para ver as mudanças
                router.reload();
            },
            onError: (errors) => {
                console.error('Erros de validação:', errors);
                if (errors.email) {
                    (window as any).showToast?.(errors.email, 'error');
                } else if (errors.nomeUsuario) {
                    (window as any).showToast?.(errors.nomeUsuario, 'error');
                } else {
                    (window as any).showToast?.('Erro ao atualizar perfil. Verifique os campos.', 'error');
                }
            }
        });
        
    } catch (error) {
        console.error('Erro ao salvar perfil:', error);
        (window as any).showToast?.('Erro ao salvar perfil. Tente novamente.', 'error');
    } finally {
        state.salvandoPerfil = false;
    }
};
</script>

<style scoped>
/* Estilos para foto de perfil */
.profile-picture {
    width: 200px;
    height: 200px;
    border-radius: 50%;
    object-fit: cover;
    object-position: center;
    border: 4px solid #cff8e4;
    background-color: #f8f9fa;
    flex-shrink: 0; /* Evita que a imagem seja comprimida */
    min-width: 200px; /* Garante largura mínima */
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(207, 248, 228, 0.3);
}

.profile-picture:hover {
    transform: scale(1.05);
    border-color: #002D17;
    box-shadow: 0 6px 20px rgba(0, 45, 23, 0.2);
}

/* Animação dos cards - igual à Home */
.cursor-pointer {
    cursor: pointer;
}

.cursor-pointer:hover {
    transform: translateY(-5px);
    transition: all 0.3s ease;
    box-shadow: 0 8px 25px rgba(0,0,0,0.2);
}

/* Cards dos anúncios */
.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.2);
}

/* Adicionar classes de fonte globais */
.questrial-font {
    font-family: 'Questrial', sans-serif;
}

.poppins-font {
    font-family: 'Poppins', sans-serif;
}

/* Efeitos hover para formulários */
.form-control:focus {
    border-color: #cff8e4 !important;
    box-shadow: 0 0 0 0.2rem rgba(207, 248, 228, 0.25) !important;
}

.form-select:focus {
    border-color: #cff8e4 !important;
    box-shadow: 0 0 0 0.2rem rgba(207, 248, 228, 0.25) !important;
}

/* Responsividade */
@media (max-width: 768px) {
    .profile-picture {
        width: 150px;
        height: 150px;
        min-width: 150px;
    }
}

@media (max-width: 576px) {
    .profile-picture {
        width: 120px;
        height: 120px;
        min-width: 120px;
    }
}
</style>
