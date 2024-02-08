<template>
  <Disclosure as="div" class="py-6" v-slot="{ open }">
    <h3 class="-my-3 flow-root">
      <DisclosureButton
        class="flex w-full items-center justify-between bg-white py-3 text-sm text-gray-400 hover:text-gray-500"
      >
        <span class="font-medium text-gray-900">{{ label }}</span>
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
    </h3>
    <DisclosurePanel class="pt-6">
      <div class="overflow-y-scroll space-y-4">
        <div
          v-for="(count, facet) in facets"
          :key="facet"
          class="flex flex-row items-center"
        >
          <input
            :id="`filter-${facet}`"
            :name="facet"
            @change="($event) => onChange(facet, $event.target.checked)"
            :checked="values.includes(facet)"
            :value="facet"
            type="checkbox"
            class="h-5 w-5 rounded-full"
          />
          <label :for="`filter-${facet}`" class="ml-3 text-sm"
            ><span class="text-black">{{ facet }}</span> ({{ count }})</label
          >
        </div>
      </div>
    </DisclosurePanel>
  </Disclosure>
</template>

<style scoped>
label {
  @apply m-0;
}
</style>

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
