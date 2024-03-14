<template>
  <div class="card flex justify-content-center">
    <SelectButton
      v-model="value"
      :options="options"
      optionLabel="name"
      multiple
      aria-labelledby="multiple"
    />
  </div>
</template>

<script setup>
import { ref } from "vue";
import SelectButton from 'primevue/selectbutton';

const value = ref(null);
const options = ref([
  { name: "Option 1", value: 1 },
  { name: "Option 2", value: 2 },
  { name: "Option 3", value: 3 },
]);
</script>
