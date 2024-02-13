<template>
  <Disclosure :defaultOpen="true" as="div" class="py-6" v-slot="{ open }">
    <div class="-my-3 flow-root">
      <DisclosureButton
        as="h3"
        class="flex w-full cursor-pointer items-center justify-between bg-white py-3 text-sm text-gray-400 hover:text-gray-500"
      >
        <span class="text-lg font-normal text-gray-900">{{ label }}</span>
        <span class="ml-6 flex items-center">
          <svg
            class="h-5 w-5 text-black"
            v-if="!open"
            viewBox="0 0 24 24"
            version="1.1"
            xmlns="http://www.w3.org/2000/svg"
            xmlns:xlink="http://www.w3.org/1999/xlink"
          >
            <g stroke="none" stroke-width="2" fill="none" fill-rule="evenodd">
              <g
                transform="translate(4.000000, 7.500000)"
                fill="currentColor"
                fill-rule="nonzero"
              >
                <path
                  d="M0.469669914,0.469669914 C0.735936477,0.203403352 1.15260016,0.1791973 1.44621165,0.397051761 L1.53033009,0.469669914 L8,6.939 L14.4696699,0.469669914 C14.7359365,0.203403352 15.1526002,0.1791973 15.4462117,0.397051761 L15.5303301,0.469669914 C15.7965966,0.735936477 15.8208027,1.15260016 15.6029482,1.44621165 L15.5303301,1.53033009 L8.53033009,8.53033009 C8.26406352,8.79659665 7.84739984,8.8208027 7.55378835,8.60294824 L7.46966991,8.53033009 L0.469669914,1.53033009 C0.176776695,1.23743687 0.176776695,0.762563133 0.469669914,0.469669914 Z"
                ></path>
              </g>
            </g>
          </svg>
          <svg
            v-else
            class="h-5 w-5"
            viewBox="0 0 24 24"
            version="1.1"
            xmlns="http://www.w3.org/2000/svg"
            xmlns:xlink="http://www.w3.org/1999/xlink"
          >
            <g stroke="none" stroke-width="2" fill="none" fill-rule="evenodd">
              <g
                transform="translate(12.000000, 12.000000) rotate(-180.000000) translate(-12.000000, -12.000000) translate(4.000000, 7.500000)"
                fill="currentColor"
                fill-rule="nonzero"
              >
                <path
                  d="M0.469669914,0.469669914 C0.735936477,0.203403352 1.15260016,0.1791973 1.44621165,0.397051761 L1.53033009,0.469669914 L8,6.939 L14.4696699,0.469669914 C14.7359365,0.203403352 15.1526002,0.1791973 15.4462117,0.397051761 L15.5303301,0.469669914 C15.7965966,0.735936477 15.8208027,1.15260016 15.6029482,1.44621165 L15.5303301,1.53033009 L8.53033009,8.53033009 C8.26406352,8.79659665 7.84739984,8.8208027 7.55378835,8.60294824 L7.46966991,8.53033009 L0.469669914,1.53033009 C0.176776695,1.23743687 0.176776695,0.762563133 0.469669914,0.469669914 Z"
                  id="Stroke-1"
                ></path>
              </g>
            </g>
          </svg>
        </span>
      </DisclosureButton>
    </div>
    <DisclosurePanel class="pt-6">
      <div class="overflow-y-scroll space-y-4">
        <div
          v-for="(count, facet) in options"
          :key="facet"
          class="flex flex-row items-center"
        >
          <Checkbox
            :input-id="`filter-${facet}`"
            :name="facet"
            :binary="true"
            :modelValue="values.includes(facet)"
            @update:model-value="(newVal) => onChange(facet, newVal)"
          ></Checkbox>

          <label :for="`filter-${facet}`" class="ml-3 text-base"
            ><span class="text-black">{{ facet }}</span> ({{ count }})</label
          >
        </div>
      </div>
    </DisclosurePanel>
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

// green
// import "primevue/resources/themes/aura-light-green/theme.css";

// black
// import "primevue/resources/themes/aura-light-noir/theme.css";

// blue
// import "primevue/resources/themes/aura-light-blue/theme.css";

// yellow
import "primevue/resources/themes/aura-light-amber/theme.css";
//
// lime
// import "primevue/resources/themes/aura-light-lime/theme.css";

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
