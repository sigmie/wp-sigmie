<template>
  <Accordion
    :pt="{
      root: {
        class: 'sgm-flex sgm-flex-col sgm-space-y-6 sgm-px-4 lg:sgm-px-0',
      },
    }"
    :unstyled="true"
    :multiple="true"
  >
    <template v-slot:collapseicon>
      <ChevronUpIcon class="sgm-h-4 sgm-w-4 sgm-text-black"></ChevronUpIcon>
    </template>

    <template v-slot:expandicon>
      <ChevronDownIcon class="sgm-h-4 sgm-w-4 sgm-text-black"></ChevronDownIcon>
    </template>

    <template>
      <AccordionTab
        :pt="{
          root: { class: 'sgm-border' },
          headeraction: {
            class:
              'sgm-flex sgm-flex-row-reverse sgm-items-center sgm-justify-between',
          },
        }"
      >
        <template v-slot:header>
          <FilterLabel title="Sorting" :subtitle="label"> </FilterLabel>
        </template>
        <div class="sgm-pt-2 sgm-w-full">
          <template v-for="option in options">
            <slot v-bind="option"></slot>
          </template>
        </div>
      </AccordionTab>
    </template>
  </Accordion>
</template>

<style scoped></style>

<script setup>
import { Menu, MenuButton, MenuItem, MenuItems } from "@headlessui/vue";
import PrimeMenu from "primevue/menu";
import Button from "primevue/button";
import ChevronDownIcon from "./ChevronDownIcon.vue";
import ChevronUpIcon from "./ChevronUpIcon.vue";
import Accordion from "primevue/accordion";
import AccordionTab from "primevue/accordiontab";
import FilterLabel from "./FilterLabel.vue";

const props = defineProps({
  label: String,
  options: Array,
});
</script>
