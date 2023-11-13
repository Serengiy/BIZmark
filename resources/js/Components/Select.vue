<script setup>

defineProps(['options']);
</script>

<template>
    <select name="" id="">
        <option v-for="option in options" :value="option.name">{{option.name}}</option>
    </select>
</template>

<style scoped>

</style>
