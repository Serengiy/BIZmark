<script setup>
import {ref} from "vue";
import {usePage} from "@inertiajs/vue3";

const props = defineProps(['movie', 'is-auth'])
const isAuth = ref(usePage().props.auth.user !== null)
const emits = defineEmits()
const movie = ref(props.movie)

const toggleFav = () =>{
    axios.post(route('toggleFav', movie.value.id))
        .then(res =>{
            movie.value = res.data.movie

        })
}
</script>

<template>
    <div class="m-5 p-3 rounded-lg border border-gray-500">
        <div class="flex justify-between items-center">
            <p class="text-xl">{{movie.title}}</p>
            <a @click.prevent="toggleFav" v-if="isAuth" href="#">
                <svg class="w-[14px] h-[14px] text-gray-800 dark:text-sky-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" :fill="movie.isFav ? 'currentColor' : 'none' " viewBox="0 0 21 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m11.479 1.712 2.367 4.8a.532.532 0 0 0 .4.292l5.294.769a.534.534 0 0 1 .3.91l-3.83 3.735a.534.534 0 0 0-.154.473l.9 5.272a.535.535 0 0 1-.775.563l-4.734-2.49a.536.536 0 0 0-.5 0l-4.73 2.487a.534.534 0 0 1-.775-.563l.9-5.272a.534.534 0 0 0-.154-.473L2.158 8.48a.534.534 0 0 1 .3-.911l5.294-.77a.532.532 0 0 0 .4-.292l2.367-4.8a.534.534 0 0 1 .96.004Z"/>
                </svg>
            </a>

        </div>
        <div class="h-56 mt-4 overflow-hidden flex  justify-between">
<!--            <div class="pr-4 flex items-center ">-->
<!--                <p class="line-clamp-6 lg:line-clamp-8 px-2 text-gray-800">{{movie.description}}</p>-->
<!--            </div>-->
            <img height="240" :src="movie.preview" alt="" class="rounded">
        </div>
        <div class="mt-5">
            <span class="text-sm text-gray-900 text-right mt-4 italic">Id: {{movie.id}}</span>
        </div>
        <div class="mt-5">
                <span class="text-sm text-gray-900 text-right mt-4 italic">Режисер: {{movie.producer.name}}</span>
        </div>
        <div class="mt-5">
            <span class="text-sm text-gray-900 text-right mt-4 italic">Дата выхода: {{movie.released_at}}</span>
        </div>
        <div class="mt-5">
            <span class="text-sm text-gray-900 text-right mt-4 italic">Актеры: {{movie.actors.map(actor=>actor.name).join(', ')}}</span>
        </div>
        <div class="mt-5">
            <p>Жанр:
                <a href="#" @click.prevent="emits('handleGenre', genre.title)" v-for="genre in movie.genres" class="text-sm text-sky-500 text-right mt-4 italic mr-2">{{genre.title}} </a>
            </p>

        </div>
        <div class="mt-5">
            <span class="text-sm text-gray-900 text-right mt-4 italic">Рейтинг: {{movie.rating}}</span>
        </div>
        <div class="text-right">
            <a :href="route('movies.show', movie.slug)" class="text-sm text-sky-900 text-right mt-4 italic">Подробнее</a>
        </div>
    </div>
</template>

<style scoped>

</style>
