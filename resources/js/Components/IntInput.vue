<template>
    <input
        :type="type"
        :id="id"
        :min="min"
        :max="max"
        :value="modelValue"
        @input="$emit('update:modelValue', $event.target.value)"
        class="mt-1 p-2 border border-gray-300 rounded-md focus:outline-none focus:border-indigo-500 focus:ring focus:ring-indigo-200"
    />
</template>

<script setup>
defineProps(['min', 'max', 'id', 'modelValue']);

const type = 'number';

// If you want to handle the input event separately
// const onInput = (event) => {
//   emit('update:modelValue', event.target.value);
// }
</script>

<style scoped>
/* Add your styles here if needed */
</style>
