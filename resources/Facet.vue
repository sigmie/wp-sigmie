<template>
  <Disclosure :defaultOpen="true" as="div" class="" v-slot="{ open }">
    <div class="sgm--my-3 sgm-flow-root">
      <DisclosureButton
        as="h3"
        class="sgm-flex sgm-flex-row sgm-w-full sgm-cursor-pointer sgm-items-center sgm-justify-between sgm-bg-white sgm-py-3 sgm-text-sm sgm-text-gray-400 sgm-hover:text-gray-500 sgm-m-0"
      >
        <span class="sgm-text-sm sgm-font-medium sgm-text-black">{{
          label
        }}</span>
        <span class="sgm-ml-6 sgm-flex sgm-items-center">
          <ChevronDownIcon
            v-if="!open"
            class="sgm-h-4 sgm-w-4 sgm-text-black"
          ></ChevronDownIcon>
          <ChevronUpIcon
            v-else
            class="sgm-h-4 sgm-w-4 sgm-text-black"
          ></ChevronUpIcon>
        </span>
      </DisclosureButton>
    </div>
    <transition
      enter-active-class="sgm-transition sgm-duration-150 sgm-ease-out"
      enter-from-class="sgm-transform sgm-scale-95 sgm-opacity-0"
      enter-to-class="sgm-transform sgm-scale-100 sgm-opacity-100"
      leave-active-class="sgm-transition sgm-duration-150 sgm-ease-out"
      leave-from-class="sgm-transform sgm-scale-100 sgm-opacity-100"
      leave-to-class="sgm-transform sgm-scale-95 sgm-opacity-0"
    >
      <DisclosurePanel class="sgm-pt-4">
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
      </DisclosurePanel>
    </transition>
  </Disclosure>
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
import ChevronDownIcon from './ChevronDownIcon.vue'
import ChevronUpIcon from './ChevronUpIcon.vue'

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
