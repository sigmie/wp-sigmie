<template>
  <div class="sgm-flex sgm-flex-col sgm-border-b sgm-border-gray-300 sgm-w-4/5">
    <div class="sgm-text-base sgm-font-medium sgm-text-black sgm-no-underline">
      <span>{{ title }}</span>
    </div>
    <div
      v-if="subtitle"
      class="sgm-text-base sgm-text-gray-500 sgm-min-h-12"
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
