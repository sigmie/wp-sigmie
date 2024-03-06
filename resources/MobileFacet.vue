<template>
  <div class="sgm-pt-4 block xl:sgm-hidden">
    <div class="sgm-space-y-2">
      <div
        v-for="(count, facet) in options"
        :key="facet"
        class="sgm-flex sgm-flex-row sgm-justify-between sgm-items-center"
      >

        <label :for="`filter-${facet}`" class="sgm-text-sm"
          ><span class="sgm-text-black">{{ facet }}</span>
          <span class="sgm-text-gray-500 sgm-ml-1 sgm-tracking-wide">
            ({{ count }})
          </span>
        </label>

        <Checkbox
          :input-id="`filter-${facet}`"
          :name="facet"
          :binary="true"
          :modelValue="values.includes(facet)"
          @update:model-value="(newVal) => onChange(facet, newVal)"
        ></Checkbox>
      </div>
    </div>
  </div>
</template>

<style scoped></style>

<script setup>
import { ref, watch, onMounted } from "vue";
import Checkbox from "primevue/checkbox";

const emit = defineEmits(["update:modelValue"]);

const props = defineProps({
  facets: {
    type: Object,
    required: true,
  },
  label: String,
  modelValue: Array,
});

const value = ref(false);
const values = ref([]);
const options = ref([]);

onMounted(() => {});

watch(
  () => props.modelValue,
  (newVal) => {
    values.value = newVal;
  },
  { immediate: true }
);

watch(
  () => props.facets,
  (newVal) => {
    if (options.value.length === 0) {
      options.value = newVal;
    }
  },
  { immediate: true }
);

const onChange = (facet, value) => {
  if (value) {
    values.value.push(facet);
  } else {
    values.value = values.value.filter((item) => item !== facet);
  }

  emit("update:modelValue", values.value);
};
</script>
