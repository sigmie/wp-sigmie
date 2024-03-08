<template>
  <Accordion
    :pt="{
      root: {
        class: 'sgm-flex sgm-flex-col sgm-space-y-6 sgm-px-4 lg:sgm-px-0',
      },
    }"
    :unstyled="true"
    :multiple="true"
    :activeIndex="accordionActiveKeys"
  >
    <template v-slot:collapseicon>
      <ChevronUpIcon class="sgm-h-4 sgm-w-4 sgm-text-black"></ChevronUpIcon>
    </template>

    <template v-slot:expandicon>
      <ChevronDownIcon class="sgm-h-4 sgm-w-4 sgm-text-black"></ChevronDownIcon>
    </template>
    <template v-for="(item, key) in items">
      <AccordionTab
        :pt="{
          root: { class: '' },
          headeraction: {
            class:
              'sgm-flex sgm-flex-row-reverse sgm-items-center sgm-justify-between',
          },
        }"
      >
        <template v-slot:header>
          <slot
            name="header"
            v-bind="{
              key,
              item,
            }"
          ></slot>
        </template>
        <slot
          name="tab"
          v-bind="{
            key,
            item,
          }"
        ></slot>
      </AccordionTab>
    </template>
  </Accordion>
</template>

<script setup>
import ChevronUpIcon from "./ChevronUpIcon.vue";
import ChevronDownIcon from "./ChevronDownIcon.vue";
import Accordion from "primevue/accordion";
import AccordionTab from "primevue/accordiontab";

import { onMounted, ref } from "vue";

const accordionActiveKeys = ref([]);

const props = defineProps({
  items: Object,
  open: Boolean,
});

onMounted(() => {

  if (props.open)
  {

  accordionActiveKeys.value = Object.keys(Object.keys(props.items)).map((d) =>
    parseInt(d)
  );
  }
});
</script>

<style></style>
