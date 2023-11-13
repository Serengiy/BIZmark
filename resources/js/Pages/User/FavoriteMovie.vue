<script setup>
import MovieLayout from "@/Layouts/MovieLayout.vue";
import MovieComponent from "@/Components/MovieComponent.vue";
import {ref} from "vue";
import {usePage} from "@inertiajs/vue3";
import FavoriteMovieComponent from "@/Components/FavoriteMovieComponent.vue";


const { auth } = defineProps(['auth']);
const isAuthenticated = ref(auth.user !== null);
const movies = ref(usePage().props.movies.data)
const page = ref(1)
const isLastPage = ref(page.value ===usePage().props.movies.meta.last_page)
const isFirstPage = ref(true)


const removeMovieFromFavs = (movieId) =>{
    const indexToRemove = movies.value.findIndex(movie => movie.id === movieId);

    if (indexToRemove !== -1) {
        movies.value.splice(indexToRemove, 1);
    }
}

const nextPage = () => {
    ++page.value
    changePage()
}

const previousPage = () => {
    --page.value
    changePage()
}

const changePage = ()=>{
    axios.get(`/favorites?page=${page.value}`)
        .then(res =>{
            movies.value.splice(0, movies.value.length);
            movies.value.push(...res.data.movies)
            page.value = res.data.meta.page
            isFirstPage.value = page.value === 1
            isLastPage.value = res.data.meta.isLastPage
        })
}

</script>

<template>
    <MovieLayout>
        <div class="pb-8">
            <h2 class="text-center text-3xl my-5">Каталог</h2>
            <div class="grid grid-cols-3">
                <FavoriteMovieComponent
                    v-for="movie in movies"
                    :movie="movie"
                    :is-auth="isAuthenticated"
                    :key="movie.id"
                    @updateMovieList="removeMovieFromFavs"
                ></FavoriteMovieComponent>
            </div>
            <div class="flex justify-center">
                <div class="w-1/2 grid grid-cols-2">
                    <div class="text-left">
                        <a @click.prevent="previousPage"  href="#" v-if="!isFirstPage" class="rounded-full bg-sky-500 text-white py-2 px-4">Previous page</a>
                    </div>
                    <div class="text-right">
                        <a @click.prevent="nextPage"  href="#" v-if="!isLastPage" class=" rounded-full bg-sky-500 text-white py-2 px-4">Next page</a>
                    </div>
                </div>
            </div>
        </div>
    </MovieLayout>
</template>

<style scoped>

</style>
