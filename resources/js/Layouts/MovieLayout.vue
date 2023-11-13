<script setup>
import {usePage} from "@inertiajs/vue3";
import {ref} from "vue";

const isAuth = ref(usePage().props.auth.user !== null)


const logout = () =>{
    axios.post(route('logout'))
        .then(res =>{
            window.location.href = '/';
        })
}
</script>

<template>
    <div class="mx-auto max-w-5xl w-3/4">
        <div class="min-h-screen bg-gray-100">
            <div>
                <nav class="bg-white border-b  flex justify-center">
                    <ul class="flex w-5/6 justify-between ">
                        <li class="px-4 py-2">
                            <a :href="route('home')">Home</a>
                        </li>
                        <li v-if="!isAuth" class="px-4 py-2">
                            <a :href="route('login')">Войти</a>
                        </li>
                        <li v-if="!isAuth" class="px-4 py-2">
                            <a :href="route('register')">Регистрация</a>
                        </li>
                        <li v-if="isAuth" class="px-4 py-2">
                            <a :href="route('favorites')">Избранные</a>
                        </li>
                        <li v-if="isAuth" class="px-4 py-2">
                            <a @click.prevent="logout" href="#">Выйти</a>
                        </li>

                    </ul>
                </nav>
            </div>
            <slot/>
        </div>
    </div>
</template>

<style scoped>
</style>
