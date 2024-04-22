<template>
  <div class="">
    <div class="sgm-flex sgm-flex-col sgm-space-y-2 lg:sgm-space-y-1">
      <div
        v-for="[count, facet] in sortedOptions"
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

        <label :for="`filter-${facet}`" class="sgm-ml-3">
          <span
            v-html="facet"
            class="sgm-text-black sgm-text-lg lg:sgm-text-base"
          ></span>
          <span
            class="sgm-text-gray-500 sgm-ml-1 sgm-tracking-wide sgm-text-lg lg:sgm-text-base"
          >
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
  sorted_values: {
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
  let res = [];

  props.sorted_values.forEach((item) => {
    if (props.facets[item]) {
      res.push([props.facets[item], item]);
    }
  });

  return res;
});

const selectedValues = ref([]);

const isSelected = (facet) =>
  selectedValues.value.some((item) => item.id === `${props.name}-${facet}`);

const updateSelection = (isSelected, label) => {

  const id = `${props.name}-${label}`;
  if (isSelected) {
    selectedValues.value.push({
      id,
      label,
      key: props.name,
      string: `${props.name}:'${label}'`,
      value: label,
    });
  } else {
    selectedValues.value = selectedValues.value.filter(
      (item) => item.id !== id
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
