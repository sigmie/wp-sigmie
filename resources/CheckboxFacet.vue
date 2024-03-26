<template>
  <div class="sgm-pt-4">
    <div class="sgm-space-y-2">
      <div
        v-for="(count, facet) in sortedOptions"
        :key="facet"
        class="sgm-flex sgm-flex-row sgm-items-center"
      >
        <Checkbox
          :input-id="`filter-${facet}`"
          :name="facet"
          :binary="true"
          :model-value="isSelected(facet)"
          @update:model-value="(value) => updateSelection(value, facet)"
        ></Checkbox>

        <label :for="`filter-${facet}`" class="sgm-ml-3 sgm-text-sm">
          <span class="sgm-text-black">{{ facet }}</span>
          <span class="sgm-text-gray-500 sgm-ml-1 sgm-tracking-wide">
            ({{ count }})
          </span>
        </label>
      </div>
    </div>
  </div>
</template>

<style scoped></style>

<script setup>
import { ref, watch, onMounted, computed } from "vue";
import Checkbox from "primevue/checkbox";

const emit = defineEmits(["update:modelValue"]);

const props = defineProps({
  name: {
    type: String,
  },
  facets: {
    type: Object,
    required: true,
  },
  label: {
    type: String,
  },
  modelValue: {
    type: Array,
  },
  sortedAttributes: {
    type: Array,
  },
  component: {
    type: String,
  },
  expanded: {
    type: Boolean,
  },
  index: {
    type: Number,
  },
});

const sortedOptions = computed(() => {
  if (!props.sortedAttributes) {
    return props.facets;
  }

  return props.sortedAttributes.reduce((acc, val) => {
    if (props.facets[val]) {
      acc[val] = props.facets[val];
    }
    return acc;
  }, {});
});

const selectedValues = ref([]);

const isSelected = (facet) =>
  selectedValues.value.some((item) => item.label === facet);

const updateSelection = (isSelected, label) => {
  if (isSelected) {
    selectedValues.value.push({
      id: `${props.name}-${label}`,
      label,
      key: props.name,
      operator: ":",
      value: `'${label}'`,
    });
  } else {
    selectedValues.value = selectedValues.value.filter(
      (item) => item.label !== label
    );
  }

  emit("update:modelValue", selectedValues.value);
};

watch(
  () => props.modelValue,
  (newValue) => {
    selectedValues.value = newValue;
  }
);
</script>
