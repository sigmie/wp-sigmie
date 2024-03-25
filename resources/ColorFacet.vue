<template>
  <div class="">
    <SelectButton
      @update:model-value="onChange"
      :modelValue="values"
      :options="options"
      optionLabel="name"
      multiple
      class=""
      aria-labelledby="multiple"
      unstyled
      :pt="{
        root: {
          class: 'sgm-grid sgm-grid-cols-2 sgm-gap-1 sgm-mt-3',
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
          :outlined="true"
          severity="secondary"
          class="sgm-w-full sgm-h-20"
        >
          <div
            class="sgm-flex sgm-flex-col sgm-items-center sgm-space-y-2 sgm-mx-auto"
          >
            <div
              class="sgm-rounded-full sgm-border sgm-h-4 sgm-w-4 sgm-bg-red-600"
            ></div>
            <div>
              {{ slotProps.option.name }}
            </div>
          </div>
        </Button>
      </template>
    </SelectButton>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from "vue";
import SelectButton from "primevue/selectbutton";
import Button from "primevue/button";

const props = defineProps({
  facets: {},
  modelValue: Array,
});

const emit = defineEmits(["update:modelValue"]);

const values = ref([]);
const options = ref([]);

onMounted(() => {
  options.value = [
    { name: "Foo re", value: "bar" },
    { name: "Kokkino", value: "red" },
  ];
});

const onChange = (facet) => {
  values.value = facet;

  emit(
    "update:modelValue",
    facet.map((option) => option.value)
  );
};
</script>
