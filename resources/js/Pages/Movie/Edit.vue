<script setup>
import MovieLayout from "@/Layouts/MovieLayout.vue";
import {ref} from "vue";
const props = defineProps({
    movie:Object
})
const movie = props.movie

const mainFile = ref(null)
const onMainFileChange = (event) => {

    mainFile.value = event.target.files[0];
};
const optionalFiles = ref([null, null, null, null, null]);
const onOptionalFileChange =(index) => {
    optionalFiles.value[index] = event.target.files[0];
}

const sendData = () =>{
    const formData = new FormData()
    formData.append('mainFile', mainFile.value);
    optionalFiles.value.forEach((file, index) => {
        formData.append(`optionalFile${index + 1}`, file);
    });
    axios.post(route('movie.update', movie.id),  formData, {
        headers: {
            'Content-Type': 'multipart/form-data',
        },
        }).then(res =>{
            window.location.href = `/movies/${movie.slug}`;
        });
}


</script>

<template>
    <MovieLayout>
        <p class="text-xl text-center mt-5">Загрузка превью фото и галереи для фильма</p>

        <div class="flex justify-center mt-5">
            <div class="w-1/2 rounded  border border-gray-500">
                <div class="m-5">
                    <label for="preview">Превью для фильма</label>
                    <input type="file" @change="onMainFileChange" id="preview" class="mt-2">
                </div>
                <div class="m-5">
                    <p >Галлерея</p>
                    <input @change="onOptionalFileChange(0)" type="file" class="mt-2">
                    <input @change="onOptionalFileChange(1)" type="file" class="mt-2">
                    <input @change="onOptionalFileChange(2)" type="file" class="mt-2">
                    <input @change="onOptionalFileChange(3)" type="file" class="mt-2">
                    <input @change="onOptionalFileChange(4)" type="file" class="mt-2">
                    <div class="mt-2">
                        <a @click.prevent="sendData" href="#" class="py-2 px-4 text-white bg-gray-500 text-xs rounded">Обновить</a>
                    </div>
                </div>


            </div>
        </div>
    </MovieLayout>
</template>

<style scoped>

</style>
