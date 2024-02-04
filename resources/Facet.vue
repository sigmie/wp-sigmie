<template>
  <Disclosure as="div" class="border-b border-gray-200 py-6" v-slot="{ open }">
    <h3 class="-my-3 flow-root">
      <DisclosureButton
        class="flex w-full items-center justify-between bg-white py-3 text-sm text-gray-400 hover:text-gray-500"
      >
        <span class="font-medium text-gray-900">{{ label }}</span>
        <span class="ml-6 flex items-center">
          <PlusIcon v-if="!open" class="h-5 w-5" aria-hidden="true" />
          <MinusIcon v-else class="h-5 w-5" aria-hidden="true" />
        </span>
      </DisclosureButton>
    </h3>
    <DisclosurePanel class="pt-6">
      <div class="h-96 overflow-y-scroll space-y-4">
        <div
          v-for="(count, facet) in facets"
          :key="facet"
          class="flex items-center"
        >
          <input
            :id="`filter-${facet}`"
            :name="facet"
            @change="($event) => onChange(facet, $event.target.checked)"
            :checked="values.includes(facet)"
            :value="facet"
            type="checkbox"
            class="h-5 w-5 rounded border-gray-700 bg-zinc-800 focus:ring-zinc-900"
          />
          <label :for="`filter-${facet}`" class="ml-3 text-sm"
            >{{ facet }} ({{ count }})</label
          >
        </div>
      </div>
    </DisclosurePanel>
  </Disclosure>
</template>

<script>
import {
  Disclosure,
  DisclosureButton,
  DisclosurePanel,
  TransitionChild,
  TransitionRoot,
} from "@headlessui/vue";
import { MinusIcon, PlusIcon } from "@heroicons/vue/20/solid";

export default {
  components: {
    Disclosure,
    DisclosureButton,
    DisclosurePanel,
    TransitionChild,
    TransitionRoot,
    PlusIcon,
    MinusIcon,
  },
  emits: ["update:modelValue"],
  props: {
    facets: {
      type: Object,
    },
    label: {
      type: String,
      required: true,
    },
    modelValue: {
      type: Array,
      required: true,
    },
  },
  data() {
    return {
      values: [],
    };
  },
  mounted() {
    this.values = this.modelValue;
  },
  methods: {
    onChange(facet, value) {
      if (value) {
        this.values.push(facet);
      } else {
        this.values = this.values.filter((item) => item !== facet);
      }

      this.$emit("update:modelValue", this.values);
    },
  },
};
</script>
