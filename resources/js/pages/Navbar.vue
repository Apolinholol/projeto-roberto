<template>
    <nav class="flex items-center p-4 bg-gray-800 text-white">
        <ul class="flex  justify-between w-full mb-0">
            <li>LOGO</li>
            <li>BARRA PESQUISA</li>
            <li style="margin-right:30px">
                <div class="d-flex gap-5">
                    <button class="bi bi-chat-dots fs-4"  type="button"></button>
                    <span class="dropdown">
                        <button class="bi bi-person-circle fs-4" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Meus anúncios e perfil</a></li>
                            <li><a class="dropdown-item" href="#">Logout</a></li>
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
</style>