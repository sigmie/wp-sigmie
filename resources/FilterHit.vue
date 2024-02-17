<script setup>
import EmptyStart from "./EmptyStart.vue";
import FullStart from "./FullStart.vue";
import HalfStart from "./HalfStart.vue";

let props = defineProps({
  hit: Object,
  // active: Boolean,
  // selected: Boolean,
  // maxDescriptionLength: Number,
  // showCategory: Boolean,
  // showDescription: Boolean,
  // showPrice: Boolean,
  // showRating: Boolean,
  // showSku: Boolean,
  // showStock: Boolean,
  // showOnSale: Boolean,
});
</script>

<template>
  <div class="sgm-py-4 sgm-pr-4">
    <div class="sgm-group sgm-relative sgm-border-b sgm-border-r sgm-border-gray-200 ">
      <div
        class="sgm-aspect-h-1 sgm-aspect-w-1 sgm-overflow-hidden sgm-rounded-lg sgm-bg-gray-200 sgm-group-hover:opacity-75"
      >
        <img
          src="https://tailwindui.com/img/ecommerce-images/category-page-05-image-card-04.jpg"
          alt="TODO"
          class="sgm-h-full sgm-w-full sgm-object-cover sgm-object-center"
        />
      </div>
      <div class="sgm-pb-4 sgm-pt-10 sgm-text-center">
        <h3 class="sgm-text-sm sgm-font-medium sgm-text-gray-900">
          <a href="#">
            <span aria-hidden="true" class="sgm-absolute sgm-inset-0"></span>
            Organize Phone Holder
          </a>
        </h3>
        <div class="sgm-mt-3 sgm-flex sgm-flex-col sgm-items-center">
          <p class="sgm-sr-only">4 out of 5 stars</p>
          <div class="sgm-flex sgm-items-center"></div>
          <p class="sgm-mt-1 sgm-text-sm sgm-text-gray-500">21 reviews</p>
        </div>
        <p class="sgm-mt-4 sgm-text-base sgm-font-medium sgm-text-gray-900">$15</p>
      </div>
    </div>
  </div>
</template>
