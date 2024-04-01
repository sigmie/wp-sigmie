<template>
  <div>
    <SelectButton
      @update:model-value="onChange"
      :modelValue="values"
      :options="sortedOptions"
      optionLabel="name"
      multiple
      aria-labelledby="multiple"
      unstyled
      :pt="{
        root: {
          class: 'sgm-grid sgm-grid-cols-3 sgm-gap-1 sgm-mt-3',
        },
        label: {
          class: 'sgm-text-gray-800 sgm-text-sm',
        },
      }"
    >
      <template #option="slotProps">
        <Button
          :outlined="!values.some((val) => val.key === slotProps.option.key)"
          severity="secondary"
          class="sgm-w-full"
        >
          <span
            v-html="slotProps.option.key"
            class="sgm-w-full sgm-text-center sgm-normal-case sgm-text-black"
          >
          </span>
        </Button>
      </template>
    </SelectButton>
  </div>
</template>

<script setup>
import { ref, computed, watch } from "vue";
import SelectButton from "primevue/selectbutton";
import Button from "primevue/button";

const props = defineProps({
  facets: Object,
  modelValue: Array,
  sorted_values: Array,
  name: String,
});

const values = ref([]);

const emit = defineEmits(["update:modelValue"]);

const sortedOptions = computed(() => {
  if (!props.sorted_values) {
    return Object.entries(props.facets).map(([key, value]) => ({ key, value }));
  }

  return props.sorted_values.reduce((acc, val) => {
    if (props.facets[val]) {
      acc.push({ key: val, value: props.facets[val] });
    }
    return acc;
  }, []);
});

const onChange = (selectedFacets) => {
  values.value = selectedFacets;

  const updatedModelValue = selectedFacets.map((option) => {
    const id = `${props.name}-${option.key}`;

    return {
      id,
      label: option.key,
      key: props.name,
      string: `${props.name}:'${option.key}'`,
      value: option.value,
    };
  });

  emit("update:modelValue", updatedModelValue);
};

watch(
  () => props.modelValue,
  (newModelValue) => {
    const newValue = newModelValue.map((value) => {
      return { key: value.label, value: value.value };
    });

    values.value = newValue;
  },
  { deep: true }
);
</script>
