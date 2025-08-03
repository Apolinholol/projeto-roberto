<template>
    <nav class="flex items-center p-4 text-white"
    style="background: linear-gradient(to right , #086839 0%, #049f55 100%);">
        <ul class="flex  justify-between w-full mb-0">
            <li  >
                <a class="d-flex align-items-center gap-2 link-logo">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                    <path fill-rule="evenodd" d="M7.5 6v.75H5.513c-.96 0-1.764.724-1.865 1.679l-1.263 12A1.875 1.875 0 0 0 4.25 22.5h15.5a1.875 1.875 0 0 0 1.865-2.071l-1.263-12a1.875 1.875 0 0 0-1.865-1.679H16.5V6a4.5 4.5 0 1 0-9 0ZM12 3a3 3 0 0 0-3 3v.75h6V6a3 3 0 0 0-3-3Zm-3 8.25a3 3 0 1 0 6 0v-.75a.75.75 0 0 1 1.5 0v.75a4.5 4.5 0 1 1-9 0v-.75a.75.75 0 0 1 1.5 0v.75Z" clip-rule="evenodd" />
                    </svg>
                    <h4 
                        class="mb-0"
                        style="  
                        font-family: 'Bungee', sans-serif;
                        font-weight: 400;
                        font-style: normal;"
                    >
                    Vendiff
                    </h4>
                </a>
            </li>
            <li class="w-25">
                <div class="input-group ">
                    <button class="btn bi bi-search"  type="button"></button>
                    <input type="text" 
                    class="form-control btn-pesquisar "
                    placeholder="Buscar produto..."
                    aria-label="Pesquisar">

                </div>
            </li>
            <li style="margin-right:30px">
                <div class="d-flex gap-5">
                    <button class="bi bi-chat-dots fs-4"  type="button"></button>
                    <span class="dropdown">
                        <button class="bi bi-person-circle fs-4" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        </button>
                        <ul class="dropdown-menu">
                            <li class="d-flex justify-content-center"><p>Olá ,</p></li>
                            <li><a class="dropdown-item" href="#">Meus anúncios e perfil</a></li>
                            <li class="d-flex justify-content-center " style="height:30px;">
                                <button class="btn btn-danger" style="border-radius:5px;height:30px;line-height: 10px;" >
                                    <i class="bi bi-door-open"></i>
                                    Logout
                                </button>
                            </li>
                        </ul>
                    </span>
                </div>
            </li>
        </ul>
    </nav>

</template>
<script lang="ts" setup>
</script>
<style scoped>

li {
    margin-right: 0;
}

.bi-search {
     background: linear-gradient(to right, #5fd098 0%, #4ebf84 100%);
    color: white;
    box-shadow: 2px 2px 5px rgba(0,0,0,0.2), -2px -2px 5px rgba(255,255,255,0.1);
    border: none;
    border-top-left-radius: 6px;
    border-bottom-left-radius: 6px;
}
.btn-pesquisar {
    border-top-right-radius:10px;
    border: 0;
    border-bottom-right-radius:10px;
    background-color: #042414;
    color: white;
    margin-left: 0!important;
    box-shadow: 2px 2px 5px rgba(0,0,0,0.2), -2px -2px 5px rgba(255,255,255,0.1);
    border-top-right-radius: 6px;
    border-bottom-right-radius: 6px;
}


.btn-pesquisar:focus {
    outline: none;
    box-shadow: none!important; /* Remove sombra do foco */
}
.link-logo{
    text-decoration: none;
    color: white;
    display: flex;
    align-items: center;
    cursor: pointer;
}

</style>