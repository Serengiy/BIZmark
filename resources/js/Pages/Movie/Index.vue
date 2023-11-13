<script setup>
import MovieLayout from "@/Layouts/MovieLayout.vue";
import MovieComponent from "@/Components/MovieComponent.vue";
import {usePage} from "@inertiajs/vue3";
import {reactive, ref, toRefs} from "vue";
import Dropdown from "@/Components/Dropdown.vue";
import Selects from "@/Components/Selects.vue";
import IntInput from "@/Components/IntInput.vue";
import Select from "@/Components/Select.vue";
import MySelect from "@/Components/MySelect.vue";

const movies = ref(usePage().props.movies.data)
const producers = usePage().props.producers
const actors = usePage().props.actors
const selectedActors = ref([])
const selectedProducers = ref(null)
const props = usePage().props
const page = ref(1)
const isLastPage = ref(false)
const isFirstPage = ref(true)


const { auth } = defineProps(['auth']);
const isAuthenticated = ref(auth.user !== null);

const nextPage = () => {
    ++page.value
    filterData()
}

const previousPage = () => {
    --page.value
    filterData()
}


const filters = ref({
    minRating: 1,
    maxRating: 5,
    minYear: 1995,
    maxYear: new Date().getFullYear() + 10,
    selectedActors: null,
    selectedProducers: null,
    selectedGenre:null,
})
const sort =ref('')
const searchInput = ref('')

const sortHandle = (e) =>{
    sort.value = e.target.value
    filterData()
}

const search = () =>{
    axios.get(`/?search=${searchInput.value}`)
        .then( res =>{
            console.log(res)
            movies.value.splice(0, movies.value.length);
            movies.value.push(...res.data.movies)
            page.value = res.data.meta.page
            isFirstPage.value = page.value === 1
            isLastPage.value = res.data.meta.isLastPage
        })
}

const selectProducer = (el)=>{
    filters.value.selectedProducers = el
    filterData()
}

const selectActors = (el)=>{
    filters.value.selectedActors = el
    filterData()
}

const genreHandle = (el) =>{
    filters.value.selectedGenre = el
    filterData()
}
const dropFilters = () =>{
        filters.value.minRating= 1
        filters.value.maxRating= 5
        filters.value.minYear= 1995
        filters.value.maxYear= new Date().getFullYear() + 10
        filters.value.selectedActors= null
        filters.value.selectedProducers= null
        filters.value.selectedGenre=null
        sort.value = ''
        searchInput.value =''
    filterData()
}

const filterData = () =>{
    axios.get(`/?page=${page.value}&year=${[filters.value.minYear, filters.value.maxYear]}&rating=${[filters.value.minRating, filters.value.maxRating]}&actors=${filters.value.selectedActors}&producers=${filters.value.selectedProducers}&genre=${filters.value.selectedGenre}&sort=${sort.value}`)
        .then(res=>{
            movies.value.splice(0, movies.value.length);
            movies.value.push(...res.data.movies)
            page.value = res.data.meta.page
            isFirstPage.value = page.value === 1
            isLastPage.value = res.data.meta.isLastPage
            console.log(res.request)
        })
}

</script>

<template>
    <MovieLayout>
        <div class="pb-8">
            <h2 class="text-center text-3xl my-5">Каталог</h2>
            <div class="m-5 p-3 rounded-lg border border-gray-500 text-center">
                <p class="text-2xl">Фильтры</p>
                <div class="flex justify-between">
                        <div class="w-48 mt-5">
                            <p>Год выпуска</p>
                            <div class="flex justify-between">
                                <div>
                                    <label for="yearInput" class="block text-sm font-medium text-gray-700">from</label>
                                    <IntInput :min="filters.minYear"
                                              :max="filters.maxYear"
                                              id="yearInput"
                                              v-model="filters.minYear"
                                              @input="filterData"
                                    >
                                    </IntInput>
                                </div>
                                <div>
                                    <div>
                                        <label for="yearInput" class="block text-sm font-medium text-gray-700">to</label>
                                        <IntInput :min="filters.minYear"
                                                  :max="filters.maxYear"
                                                  id="yearInput"
                                                  v-model="filters.maxYear"
                                                  @input="filterData"
                                        >
                                        </IntInput>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class=" w-48 mt-5">
                            <p>Рейтинг</p>
                            <div class="flex justify-between">
                                <div>
                                    <label for="ratingInput" class="block text-sm font-medium text-gray-700">from</label>
                                    <IntInput :min="1"
                                              :max="5"
                                              id="ratingInput"
                                              v-model="filters.minRating"
                                              @input="filterData"
                                    >
                                    </IntInput>
                                </div>
                                <div>
                                    <div>
                                        <label for="ratingInput" class="block text-sm font-medium text-gray-700">to</label>
                                        <IntInput :min="1"
                                                  :max="5"
                                                  id="ratingInput"
                                                  v-model="filters.maxRating"
                                                  @input="filterData"
                                        >
                                        </IntInput>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <div class=" w-48 mt-5">
                        <div>
                            <label for="singleOptionSelect">Режиссеры:</label>
                            <div class="mt-5">
                                <MySelect @selectedEvent="selectProducer"
                                          :data="producers.map(producer=>producer.name)"
                                          :value="selectedProducers"
                                ></MySelect>
                            </div>
                        </div>
                    </div>
                    <div class=" w-48 mt-5">
                        <div class="">
                            <label for="multipleOptionSelect">Актеры:</label>
                            <div class="mt-5">
                                <MySelect @selectedEvent="selectActors"
                                          :data="actors.map(actor=>actor.name)"
                                          :mode="'tags'"
                                          :value="selectedActors"
                                ></MySelect>
                            </div>
                        </div>
                    </div>
                </div>
                <p class="text-2xl mt-5">Сортировка</p>
                <div class="flex justify-between">
                    <div>
                        <select @input="sortHandle" class="rounded border-gray-300 bg-gray-200 text-gray-800">
                            <option value="#" selected disabled>Сортировать</option>
                            <option value="released_at">Сначала новые</option>
                            <option value="-released_at">Сначала старые</option>
                            <option value="rating">Сначала с высоким рейтингом</option>
                            <option value="-rating">Сначала с низким рейтингом</option>
                        </select>
                    </div>
                </div>
                <div>
                    <p class="text-2xl mt-5">Поиск</p>
                    <input @input="search" v-model="searchInput" type="text" class="rounded border-gray-300 bg-gray-200 text-gray-800 w-96 my-4" placeholder="Search">
                </div>
                <a @click.prevent="dropFilters" href="#" class="text-sky-500 mt-5">Сбросить фильтры</a>
            </div>
            <div class="grid grid-cols-3">
                <MovieComponent
                    v-for="movie in movies"
                    :movie="movie"
                    :is-auth="isAuthenticated"
                    :key="movie.id"
                    @handleGenre="genreHandle"
                ></MovieComponent>
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
