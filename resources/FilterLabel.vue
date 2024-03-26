<template>
  <div class="sgm-flex sgm-flex-col sgm-border-b sgm-border-gray-300 sgm-w-4/5">
    <div
      class="sgm-text-md xl:sgm-text-sm sgm-font-medium sgm-text-black sgm-no-underline"
    >
      <span>{{ title }}</span>
    </div>
    <div
      v-if="subtitle"
      class="sgm-text-sm sgm-font-medium sgm-text-gray-600 sgm-h-6"
    >
      <span class="">
        {{ subtitle }}
      </span>
    </div>
  </div>
</template>

<script setup>
const props = defineProps(["title", "subtitle"]);
</script>
