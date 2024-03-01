<script setup>
import VirtualScroller from "primevue/virtualscroller";
import VerticalHit from "./VerticalHit.vue";

const props = defineProps({
  title: String,
  hits: Object,
});
</script>

<template>
  <h3 class="sgm-text-sm sgm-font-medium sgm-text-black sgm-mt-3">
    {{ title }}
  </h3>
  <VirtualScroller
    class="sgm-h-32 sgm-w-auto"
    :items="Object.values(hits ?? {})"
    :itemSize="240"
    orientation="horizontal"
    :pt="{ content: '' }"
  >
    <template v-slot:item="{ item, options }">
      <div class="">
        <VerticalHit :hit="item"></VerticalHit>
      </div>
    </template>
  </VirtualScroller>
</template>
