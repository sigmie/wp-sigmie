<script setup>
import VirtualScroller from "primevue/virtualscroller";
import VerticalHit from "./VerticalHit.vue";

const props = defineProps({
  title: String,
  hits: Object,
});

let interval;

const startScroll = () => {
  const scroller = document.querySelector(".sgm-h-32");
  interval = setInterval(() => {
    scroller.scrollLeft += 10;
  }, 20);
};

const stopScroll = () => {
  clearInterval(interval);
};

</script>

<template>
  <h3 class="sgm-text-sm sgm-font-medium sgm-text-black sgm-mt-3">
    {{ title }}
  </h3>
  <div class="relative">
    <div
      @mousedown="startScroll"
      @mouseup="stopScroll"
      @mouseleave="stopScroll"
      class="absolute left-0"
    >
      Right
    </div>
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
  </div>
</template>
