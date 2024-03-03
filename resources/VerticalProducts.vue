<script setup>
import VirtualScroller from "primevue/virtualscroller";
import VerticalHit from "./VerticalHit.vue";

const props = defineProps({
  title: String,
  hits: Object,
  id: String,
});

const scrollToRight = () => {
  const scroller = document.querySelector(`.${props.id}`);
  if (scroller) {
    scroller.scrollBy({ left: -480, behavior: "smooth" });
  }
};

const scrollToLeft = () => {
  const scroller = document.querySelector(`.${props.id}`);
  if (scroller) {
    scroller.scrollBy({ left: 480, behavior: "smooth" });
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
      @click="scrollToLeft"
    >
      <svg
        viewBox="0 0 24 24"
        class="sgm-h-6 sgm-w-6"
        fill="none"
        xmlns="http://www.w3.org/2000/svg"
      >
        <path
          d="M10 8L14 12L10 16"
          stroke="currentColor"
          stroke-width="1.5"
          stroke-linecap="round"
          stroke-linejoin="round"
        />
      </svg>
    </button>

    <button
      class="sgm-z-20 sgm-absolute sgm-border-0 sgm-border-gray-400 sgm-shadow-xl -sgm-left-4 sgm-top-4 sgm-rounded-full sgm-bg-white sgm-p-1 sgm-text-black hover:sgm-bg-gray-50 focus-visible:sgm-outline focus-visible:sgm-outline-2 focus-visible:sgm-outline-offset-2 focus-visible:sgm-outline-black"
      @click="scrollToRight"
    >
      <svg
        class="sgm-h-6 sgm-w-6"
        viewBox="0 0 24 24"
        fill="none"
        xmlns="http://www.w3.org/2000/svg"
      >
        <path
          fill-rule="evenodd"
          clip-rule="evenodd"
          d="M14.5303 7.46967C14.8232 7.76256 14.8232 8.23744 14.5303 8.53033L11.0607 12L14.5303 15.4697C14.8232 15.7626 14.8232 16.2374 14.5303 16.5303C14.2374 16.8232 13.7626 16.8232 13.4697 16.5303L9.46967 12.5303C9.17678 12.2374 9.17678 11.7626 9.46967 11.4697L13.4697 7.46967C13.7626 7.17678 14.2374 7.17678 14.5303 7.46967Z"
          fill="currentColor"
        />
      </svg>
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
