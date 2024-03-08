<template>
  <AccordionTab
    :pt="{
      headeraction: {
        class:
          'sgm-flex sgm-flex-row-reverse sgm-items-center sgm-justify-between',
      },
    }"
  >
    <template v-slot:header>
      <slot name="header"></slot>
    </template>

    <slot></slot>
  </AccordionTab>
</template>

<script setup>
import AccordionTab from "primevue/accordiontab";
</script>

<style></style>
