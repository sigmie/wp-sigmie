<script setup>
import VirtualScroller from "primevue/virtualscroller";
import VerticalHit from "./VerticalHit.vue";
import { computed, ref, onBeforeMount } from "vue";
import ChevronLeftIcon from "./ChevronLeftIcon.vue";
import ChevronRightIcon from "./ChevronRightIcon.vue";

const props = defineProps({
  title: String,
  hits: Object,
});

const id = ref(null);

onBeforeMount(() => {
  id.value = `horizontal-products-${Math.random().toString(36).substr(2, 9)}`;
});

const canScrollLeft = ref(false);
const canScrollRight = ref(true);

const scrollToRight = () => {
  const scroller = document.querySelector(`.${id.value}`);

  if (scroller) {
    scroller.scrollBy({ left: 480, behavior: "smooth" });
    canScrollLeft.value = true;
    if (
      scroller.scrollWidth - scroller.scrollLeft <=
      scroller.clientWidth + 480
    ) {
      canScrollRight.value = false;
    }
  }
};

const scrollToLeft = () => {
  const scroller = document.querySelector(`.${id.value}`);

  if (scroller) {
    scroller.scrollBy({ left: -480, behavior: "smooth" });
    canScrollRight.value = true;
    if (scroller.scrollLeft <= 480) {
      canScrollLeft.value = false;
    }
  }
};
</script>

<template>
  <h3 class="sgm-text-sm sgm-font-medium sgm-text-black sgm-mt-3">
    {{ title }}
  </h3>
  <div class="sgm-relative">
    <button
      class="sgm-z-20 sgm-absolute sgm-border-0 sgm-border-gray-400 sgm-shadow-xl -sgm-right-4 sgm-top-4 sgm-rounded-full sgm-bg-white sgm-p-1 sgm-text-black hover:sgm-bg-gray-50 focus-visible:sgm-outline focus-visible:sgm-outline-2 focus-visible:sgm-outline-offset-2 focus-visible:sgm-outline-black"
      v-if="canScrollRight"
      @click="scrollToRight"
    >
      <div class="sgm-flex sgm-flex-col sgm-items-center sgm-justify-center">
        <ChevronRightIcon class="sgm-h-6 sgm-w-6"></ChevronRightIcon>
      </div>
    </button>

    <button
      class="sgm-z-20 sgm-absolute sgm-border-0 sgm-border-gray-400 sgm-shadow-xl -sgm-left-4 sgm-top-4 sgm-rounded-full sgm-bg-white sgm-p-1 sgm-text-black hover:sgm-bg-gray-50 focus-visible:sgm-outline focus-visible:sgm-outline-2 focus-visible:sgm-outline-offset-2 focus-visible:sgm-outline-black"
      v-if="canScrollLeft"
      @click="scrollToLeft"
    >
      <div class="sgm-flex sgm-flex-col sgm-items-center sgm-justify-center">
        <ChevronLeftIcon class="sgm-h-6 sgm-w-6"></ChevronLeftIcon>
      </div>
    </button>
    <div>
      <VirtualScroller
        :class="id"
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
  </div>
</template>
