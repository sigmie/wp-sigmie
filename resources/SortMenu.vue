<template>
  <div class="sgm-flex sgm-flex-row sgm-items-center sgm-space-x-3">
    <Menu
      as="div"
      class="sgm-relative sgm-inline-block sgm-text-left sgm-rounded-full sgm-border sgm-border-gray-950"
    >
      <div>
        <MenuButton
          as="div"
          class="sgm-group sgm-inline-flex sgm-justify-center sgm-text-sm sgm-text-gray-700 sgm-hover:text-gray-900"
        >
          <Button severity="secondary" outlined>
            <span class="sgm-text-black">{{ label }}</span>

            <ChevronDownIcon
              class="sgm--mr-1 sgm-ml-1 sgm-h-4 sgm-w-4 sgm-flex-shrink-0 sgm-text-secondary-color sgm-group-hover:text-gray-500"
              aria-hidden="true"
            />
          </Button>
        </MenuButton>
      </div>

      <transition
        enter-active-class="sgm-transition ease-out sgm-duration-100"
        enter-from-class="sgm-transform sgm-opacity-0 sgm-scale-95"
        enter-to-class="sgm-transform sgm-opacity-100 sgm-scale-100"
        leave-active-class="sgm-transition ease-in sgm-duration-75"
        leave-from-class="sgm-transform sgm-opacity-100 sgm-scale-100"
        leave-to-class="sgm-transform sgm-opacity-0 sgm-scale-95"
      >
        <MenuItems
          class="sgm-absolute sgm-left-0 sgm-z-10 sgm-mt-2 sgm-w-40 sgm-origin-top-right sgm-rounded-md sgm-bg-white sgm-shadow-2xl sgm-ring-1 sgm-ring-black sgm-ring-opacity-5 sgm-focus:outline-none"
        >
          <PrimeMenu :model="options">
            <template #item="{ item, props }">
              <MenuItem v-slot="{ active }">
                <slot name="item" v-bind="item"></slot>
              </MenuItem>
            </template>
          </PrimeMenu>
        </MenuItems>
      </transition>
    </Menu>
  </div>
</template>

<style scoped></style>

<script setup>
import { Menu, MenuButton, MenuItem, MenuItems } from "@headlessui/vue";
import PrimeMenu from "primevue/menu";
import Button from "primevue/button";
import ChevronDownIcon from "./ChevronDownIcon.vue";

const props = defineProps({
  label: String,
  options: Array,
});
</script>
