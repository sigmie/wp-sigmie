<template>
    <TransitionRoot appear :show="isOpen" as="template">
      <TransitionChild
        as="template"
        enter="sgm-duration-300 sgm-ease-out"
        enter-from="sgm-opacity-0"
        enter-to="sgm-opacity-100"
        leave="sgm-duration-200 sgm-ease-in"
        leave-from="sgm-opacity-100"
        leave-to="sgm-opacity-0"
      >
        <div class="sgm-bg-white/50 sgm-h-full sgm-w-full"></div>
      </TransitionChild>
    </TransitionRoot>
</template>

<script setup>
import { ref } from "vue";
import {
  TransitionRoot,
  TransitionChild,
  Dialog,
  DialogPanel,
  DialogTitle,
} from "@headlessui/vue";

const props = defineProps({
  isOpen: Boolean,
});
</script>
