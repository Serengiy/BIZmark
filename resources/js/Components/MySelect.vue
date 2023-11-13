<template>
    <div>
        <Multiselect
            v-model="selectedValue"
            :mode="mode"
            placeholder="Select"
            :options="options"
            :search="false"
            style="background: #e6e7eb"
            @select="handleSelect"
            @clear="clearSelect"
        />
    </div>
</template>

<script>
import Multiselect from '@vueform/multiselect';
import { ref, watch, onMounted, onUnmounted } from 'vue';

export default {
    components: { Multiselect },
    props: ['data', 'mode', 'value'],
    setup(props, { emit }) {
        const selectedValue = ref(props.value);
        const options = props.data;

        watch(
            () => props.value,
            (newValue) => {
                selectedValue.value = newValue;
            }
        );

        const handleSelect = () => {
            emit('selectedEvent', selectedValue.value);
        };
        const clearSelect = ()=>{
            selectedValue.value = null
            emit('selectedEvent', selectedValue.value);
        }

        return {
            selectedValue,
            options,
            handleSelect,
            clearSelect
        };
    },
};
</script>

<style src="@vueform/multiselect/themes/default.css"></style>
