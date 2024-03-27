<template>
  <div class="sgm-relative sgm-w-full">
    <div
      class="sgm-flex sgm-flex-row sgm-justify-between sgm-items-center sgm-mt-3 sgm-space-x-3"
    >
      <InputGroup>
        <InputNumber
          :input-id="`${name}-min`"
          v-model="range[0]"
          @update:model-value="(newMin) => onSliderChange([newMin, range[1]])"
          :max="props.facets.max"
          :min="props.facets.min"
        />
        <InputGroupAddon>
          <span v-html="symbol" class="sgm-text-black sgm-leading-3"> </span>
        </InputGroupAddon>
      </InputGroup>

      <InputGroup>
        <InputNumber
          :input-id="`${name}-max`"
          v-model="range[1]"
          @update:model-value="(newMax) => onSliderChange([range[0], newMax])"
          :max="props.facets.max"
          :min="props.facets.min"
        />
        <InputGroupAddon>
          <span v-html="symbol" class="sgm-text-black sgm-leading-3"> </span>
        </InputGroupAddon>
      </InputGroup>
    </div>
    <div class="sgm-mt-5">
      <div class="sgm-px-2">
        <Slider
          :range="true"
          :min="props.facets.min"
          :max="props.facets.max"
          :step="props.step"
          :modelValue="range"
          @update:modelValue="onSliderChange"
          class="sgm-mt-2"
        />
      </div>
    </div>
  </div>
</template>

<script setup>
import { onMounted, ref, defineEmits, watch } from "vue";
import InputGroup from "primevue/inputgroup";
import InputGroupAddon from "primevue/inputgroupaddon";
import InputNumber from "primevue/inputnumber";
import Slider from "primevue/slider";

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
  symbol: {
    type: String,
  },
  modelValue: {
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
  from_label: {
    type: String,
  },
  to_label: {
    type: String,
  },
});

const emit = defineEmits(["update:modelValue"]);

const range = ref([]);

async function onSliderChange(value) {
  let [minValue, maxValue] = value;

  // Ensure values do not exceed defined min and max
  minValue = Math.max(minValue, props.facets.min);
  maxValue = Math.min(maxValue, props.facets.max);

  range.value = [minValue, maxValue];

  const values = [];

  if (minValue !== props.facets.min) {
    const min = {
      id: `${props.name}-min`,
      label: props.from_label.replace("%", minValue),
      key: props.name,
      string: `${props.name}>='${minValue}'`,
      value: minValue,
    };

    values.push(min);
  }

  if (maxValue !== props.facets.max) {
    const max = {
      id: `${props.name}-max`,
      label: props.to_label.replace("%", maxValue),
      key: props.name,
      string: `${props.name}<='${maxValue}'`,
      value: maxValue,
    };

    values.push(max);
  }

  emit("update:modelValue", values);
}

watch(
  () => props.modelValue,
  (newValue) => {
    const minValueObject = newValue.find(
      (value) => value.id === `${props.name}-min`
    );

    const maxValueObject = newValue.find(
      (value) => value.id === `${props.name}-max`
    );

    if (minValueObject) {
      range.value[0] = Math.max(minValueObject.value, props.facets.min);
    } else {
      range.value[0] = props.facets.min;
    }

    if (maxValueObject) {
      range.value[1] = Math.min(maxValueObject.value, props.facets.max);
    } else {
      range.value[1] = props.facets.max;
    }
  },
  { deep: true }
);

onMounted(() => {
  range.value = [props.facets.min, props.facets.max];
});
</script>

<style lang="postcss">
.p-inputtext {
  @apply sgm-leading-3;
}
</style>
