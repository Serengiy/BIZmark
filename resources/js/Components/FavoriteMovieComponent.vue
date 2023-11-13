<script setup>
import {ref} from "vue";
import {usePage} from "@inertiajs/vue3";

const props = defineProps(['movie', 'is-auth'])
const emits = defineEmits()
const movie = ref(props.movie)


const deleteFromFavs = () =>{
    axios.post(route('toggleFav', movie.value.id))
        .then(res =>{
            emits('updateMovieList', movie.value.id)
        })
}

// const updateMovieList = (movie) =>{
//     console.log(movie)
// }
</script>

<template>
    <div class="m-5 p-3 rounded-lg border border-gray-500">
        <div>
            <p class="text-xl">{{movie.title}}</p>
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
            <span class="text-sm text-gray-900 text-right mt-4 italic">Рейтинг: {{movie.rating}}</span>
        </div>
        <div class="text-right">
            <a :href="route('movies.show', movie.slug)" class="text-sm text-sky-900 text-right mt-4 italic">Подробнее</a>
        </div>
        <div class="mt-3 text-center">
            <a @click.prevent="deleteFromFavs" href="#" class="text-red-600 text-sm">Удалить из избранного</a>
        </div>
    </div>
</template>

<style scoped>

</style>
