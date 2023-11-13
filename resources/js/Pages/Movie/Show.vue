<script setup>
import {usePage} from "@inertiajs/vue3";
import MovieLayout from "@/Layouts/MovieLayout.vue";
import TextInput from "@/Components/TextInput.vue";
import {ref} from "vue";
import InputLabel from "@/Components/InputLabel.vue";
import IntInput from "@/Components/IntInput.vue";
const props = defineProps({
    movie:Object
})

const isAuth = ref(usePage().props.auth.user !== null)

const movie = props.movie
const comment = ref('comment')
const rating = ref(1)

const commentStore = ()=>{
    axios.post(route('commentStore', movie.id), {
        comment: comment.value,
        rating: rating.value,
    }).then(res =>{
        movie.reviews.unshift(res.data.review)
    })
}

</script>

<template>
    <MovieLayout>
    <div class="m-5 p-3 rounded-lg border border-gray-500">
        <p class="text-xl">{{movie.title}}</p>
        <div class="h-56 mt-4 overflow-hidden flex  justify-between">
            <div class="pr-4 flex items-center ">
                <p class="line-clamp-6 lg:line-clamp-8 px-2 text-gray-800">{{movie.description}}</p>
                <div>
                    <p></p>
                </div>
            </div>
            <div>
                <img height="240" :src="movie.preview" alt="" class="rounded">
            </div>
        </div>
        <div >
            <p class="text-xl text-center">Фотогаллерея фильма</p>
            <div class="flex justify-center mt-4">
                <div class="w-10/12 grid grid-cols-4 justify-between border rounded-xl border-gray-500 p-8">
                    <div v-for="imgUrl in movie.gallery" class="">
                        <img :src="imgUrl.url" alt="" class="rounded w-40">
                    </div>
                </div>
            </div>
            <div class="text-center my-4">
                <a :href="route('movie.edit', movie.slug)" class="text-sky-600">Загрузка превью фото и галереи для фильма</a>
            </div>
        </div>
        <div class="flex gap-4">
            <span class="text-sm text-gray-900 text-right mt-4 italic">Дата выхода: {{movie.released_at}}</span>
            <span class="text-sm text-gray-900 text-right mt-4 italic">Режисер: {{movie.producer.name}}</span>
        </div>
        <div class="mt-5">
            <span class="text-sm text-gray-900 text-right mt-4 italic">Актеры: {{movie.actors.map(actor=>actor.name).join(', ')}}</span>
        </div>
        <div class="mt-5">
            <span class="text-sm text-gray-900 text-right mt-4 italic">Рейтинг: {{movie.rating}}</span>
        </div>
    </div>
        <div class="p-4 border border-gray-500 rounded-xl m-4">
            <div v-if="isAuth" class="mt-4 w-1/2">
                <p class="text-center text-xl">Новый комментарий</p>
                <form class="mb-6 mt-5">
                    <div class="py-2 px-4 mb-4 bg-white rounded-lg rounded-t-lg border border-gray-200">
                        <textarea v-model="comment" id="comment" rows="6"
                                  class="px-0 w-full text-sm text-gray-900 border-0 focus:ring-0 focus:outline-none "
                                  placeholder="Write a comment..." required></textarea>
                    </div>
                    <div class="mb-4">
                        <label for="rating" class="sr-only">Оценка</label>
                        <IntInput v-model="rating" id="rating" required placeholder="rating" min="1" max="5" class="w-20"></IntInput>
                    </div>
                    <button
                        @click.prevent="commentStore"
                        type="submit"
                        class="rounded px-4 py-2 bg-sky-500 text-white text-sm">
                        Post comment
                    </button>
                </form>
            </div>
            <h3 class="text-2xl text-center">Комментарии: </h3>
            <div class="flex gap-4 flex-col mt-4">
                <div class="border border-gray-300 p-4 rounded" v-for="review in movie.reviews">
                    <div class="mt-4 flex flex-col gap-2">
                        <p>User  <span class="italic">{{ review.user.name }}:</span> </p>
                        <p class="px-4 italic">{{review.comment}}</p>
                        <div class="flex justify-between text-sm">
                            <p>Оценка: {{review.rating}}</p>
                            <p class="italic">Отправлено: {{review.created_at}}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </MovieLayout>
</template>

<style scoped>

</style>
