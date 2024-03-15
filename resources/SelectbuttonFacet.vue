<template>
  <div class="">
    <SelectButton
      v-model="value"
      :options="options"
      optionLabel="name"
      multiple
      class=""
      aria-labelledby="multiple"
      unstyled
      :pt="{
        root: {
          class: 'sgm-grid sgm-grid-cols-3 sgm-gap-1 sgm-mt-3',
        },
        button: {
          class: '',
        },
        label: {
          class: 'sgm-text-gray-800 sgm-text-sm',
        },
      }"
    >
      <template #option="slotProps">
        <Button
          :outlined="!value.some((v) => v.value === slotProps.option.value)"
          :severity="
            !value.some((v) => v.value === slotProps.option.value)
              ? 'secondary'
              : 'primary'
          "
          class="sgm-w-full"
        >
          <span class="sgm-w-full sgm-text-center sgm-normal-case">
            {{ slotProps.option.name }}
          </span>
        </Button>
      </template>
    </SelectButton>
  </div>
</template>

<script setup>
import { ref } from "vue";
import SelectButton from "primevue/selectbutton";
import Button from "primevue/button";

const value = ref([]);
const options = ref([
  { name: "Option 1", value: 1 },
  { name: "Option 2", value: 2 },
  { name: "Option 4", value: 3 },
  { name: "Option 5", value: 4 },
  { name: "Option 6", value: 5 },
  { name: "Option 8", value: 6 },
  { name: "Option 2j8", value: 7 },
  { name: "Option 323", value: 8 },
  { name: "Option 302", value: 9 },
]);
</script>
