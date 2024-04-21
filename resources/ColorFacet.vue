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
          class:
            'sgm-grid sgm-grid-cols-3 lg:sgm-grid-cols-2 sgm-gap-2 sgm-mt-3',
        },
        label: {
          class: 'sgm-text-gray-800 sgm-text-sm',
        },
      }"
    >
      <template #option="slotProps">
        <Button
          :link="!values.some((val) => val.key === slotProps.option.key)"
          severity="secondary"
          class="sgm-w-full sgm-h-16 sgm-outline-none"
        >
          <div
            class="sgm-flex sgm-flex-col sgm-items-center sgm-space-y-2 sgm-mx-auto"
          >
            <div
              class="sgm-flex sgm-items-center sgm-w-8 sgm-rounded-full sgm-overflow-hidden"
            >
              <div
                v-for="(color, index) in value_colors[slotProps.option.key].split('|')"
                :style="{ backgroundColor: color, width: `${100 / value_colors[slotProps.option.key].split('|').length}%` }"
                class="sgm-h-8 sgm-w-full"
              ></div>
            </div>
            <div
              v-html="slotProps.option.key"
              class="sgm-normal-case sgm-text-black"
            ></div>
          </div>
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
  value_colors: Object,
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
