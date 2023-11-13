<template>
    <div class="w-48">
        <div>
            <label for="singleOptionSelect">Режиссеры:</label>
            <select class="w-full" v-model="singleOption" id="singleOptionSelect">
                <option value="option1">Option 1</option>
            </select>

        </div>
        <div class="mt-4">
            <label for="multipleOptionSelect">Актеры:</label>
            <select class="w-full" v-model="multipleOptions" id="multipleOptionSelect" multiple>
                <option value="optionA">Option A</option>
                <option value="optionB">Option B</option>
                <option value="optionC">Option C</option>
            </select>
        </div>
    </div>
</template>

<script setup>
import { ref, watch } from 'vue';

// Define your data
const singleOption = ref('option1');
const multipleOptions = ref([]);

// Your list of items to filter
const items = ref([
    { id: 1, name: 'Item 1', category: 'option1' },
    { id: 2, name: 'Item 2', category: 'optionA' },
    { id: 3, name: 'Item 3', category: 'optionB' },
    // Add more items as needed
]);

// Computed property for filtered items
const filteredItems = ref([]);

// Watch for changes in the selected options and update the filtered items
watch([singleOption, multipleOptions], () => {
    filteredItems.value = items.value.filter(item => {
        // Adjust the filtering logic based on your requirements
        return (
            (singleOption.value === 'all' || item.category === singleOption.value) &&
            (multipleOptions.value.length === 0 || multipleOptions.value.includes(item.category))
        );
    });
});

</script>
