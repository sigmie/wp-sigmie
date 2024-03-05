<template>
  <div class="sgm-pt-4">
    <div class="sgm-space-y-2">
      <div
        v-for="(count, facet) in options"
        :key="facet"
        class="sgm-flex sgm-flex-row sgm-items-center"
      >
        <Checkbox
          :input-id="`filter-${facet}`"
          :name="facet"
          :binary="true"
          :modelValue="values.includes(facet)"
          @update:model-value="(newVal) => onChange(facet, newVal)"
        ></Checkbox>

        <label :for="`filter-${facet}`" class="sgm-ml-3 sgm-text-sm"
          ><span class="sgm-text-black">{{ facet }}</span>
          <span class="sgm-text-gray-500 sgm-ml-1 sgm-tracking-wide">
            ({{ count }})
          </span>
        </label>
      </div>
    </div>
  </div>
</template>

<style scoped>
/* Order */
@layer reset, primevue;

/* Reset CSS */
@layer reset {
  button,
  input {
    /* CSS to Reset */
  }
}
</style>

<script setup>
import { ref, watch, onMounted } from "vue";
import { Disclosure, DisclosureButton, DisclosurePanel } from "@headlessui/vue";
import Checkbox from "primevue/checkbox";
import ChevronDownIcon from "./ChevronDownIcon.vue";
import ChevronUpIcon from "./ChevronUpIcon.vue";

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
