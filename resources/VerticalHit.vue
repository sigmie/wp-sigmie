<script setup>
import DeferredContent from "primevue/deferredcontent";
import Stars from "./Stars.vue";

let props = defineProps({
  hit: Object,
});
</script>

<template>
  <div
    class="sgm-w-[240px] sgm-group sgm-relative sgm-flex sgm-flex-row sgm-space-x-3"
  >
    <div
      class="sgm-w-[94px] sgm-h-[94px] sgm-overflow-hidden sgm-rounded-lg"
    >
      <DeferredContent>
        <img
          :src="hit.image"
          :alt="hit.name"
          class="sgm-object-cover sgm-object-center "
        />
      </DeferredContent>
    </div>
    <div class="sgm-h-[80px] sgm-flex sgm-flex-col sgm-justify-between">
      <a class="" :href="hit.link">
        <h3
          class="sgm-text-sm sgm-font-normal sgm-text-gray-900 sgm-mt-1 sgm-mb-0"
        >
          <span aria-hidden="true" class="sgm-absolute sgm-inset-0"></span>
          <span class="sgm-line-clamp-2">
            {{ hit.name }}
          </span>
        </h3>
      </a>
      <div class="sgm-mb-1">
        <div class="sgm-flex sgm-flex-row sgm-items-center">
          <p class="sgm-sr-only">{{ hit.average_rating }} stars</p>
          <Stars :average_rating="hit.average_rating"></Stars>
          <span class="sgm-text-xs sgm-text-gray-700 sgm-ml-2">(430)</span>
        </div>
        <div
          class="sgm-text-sm sgm-font-medium sgm-text-gray-900"
          v-html="hit.price"
        ></div>
      </div>
    </div>
  </div>
</template>
