<script setup>
import DeferredContent from "primevue/deferredcontent";
import Stars from "./Stars.vue";
import Galleria from "primevue/galleria";
import { ref, computed } from "vue";

const autoPlay = ref(false);
const activeImage = ref(0);

const onHover = () => {
  autoPlay.value = true;
};

const galleryImages = computed(() => {
  if (autoPlay.value) {
    return [props.hit.image, ...(props.hit.gallery_images || [])].map(
      (image) => ({
        itemImageSrc: image,
      })
    );
  }
});

const onLeave = () => {
  autoPlay.value = false;
  activeImage.value = 0;
};

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
  <div class="">
    <div
      class="sgm-group sgm-relative sgm-border-b sgm-border-r sgm-border-gray-200"
    >
      <div
        class="sgm-aspect-h-1 sgm-aspect-w-1 sgm-overflow-hidden sgm-rounded-lg sgm-bg-gray-200 sgm-group-hover:opacity-75"
      >
        <DeferredContent class="" v-if="!autoPlay">
          <img
            :src="hit.image"
            :alt="hit.name"
            class="sgm-h-60 sgm-w-60 sgm-object-cover sgm-object-center"
          />
        </DeferredContent>
        <Galleria
          v-else
          :value="galleryImages"
          :circular="true"
          :showItemNavigators="false"
          :showThumbnails="false"
          :autoPlay="autoPlay"
          :transitionInterval="900"
        >
          <template #item="slotProps">
            <DeferredContent class="">
              <img
                class="sgm-h-60 sgm-w-60 sgm-object-cover sgm-object-center"
                :src="slotProps.item.itemImageSrc"
                :alt="slotProps.item.alt"
              />
            </DeferredContent>
          </template>
          <template #thumbnail="slotProps">
            <DeferredContent>
              <img
                :src="slotProps.item.thumbnailImageSrc"
                :alt="slotProps.item.alt"
                style="display: block"
              />
            </DeferredContent>
          </template>
        </Galleria>
      </div>
      <div class="sgm-pb-4 sgm-pt-5">
        <div
          class="sgm-mt-1 sgm-text-sm sgm-text-gray-500 sgm-text-left sgm-font-normal"
        >
          {{ hit.categories.join(",") }}
        </div>

        <h3 class="sgm-text-base sgm-mt-1 sgm-mb-0">
          <a @mouseover="onHover" @mouseleave="onLeave" :href="hit.link">
            <span aria-hidden="true" class="sgm-absolute sgm-inset-0"></span>
            <span class="sgm-text-black sgm-font-medium">{{ hit.name }}</span>
          </a>
        </h3>
        <div
          class="sgm-text-sm sgm-text-gray-500 sgm-text-left sgm-font-normal sgm-h-6"
        >
          {{ hit.sku }}
        </div>
        <div class="sgm-flex sgm-flex-col">
          <p class="sgm-sr-only">4 out of 5 stars</p>
          <Stars :average_rating="hit.average_rating"></Stars>
          <p class="sgm-mt-1 sgm-text-sm sgm-text-gray-500">
            {{ hit.review_count }} Reviews
          </p>
        </div>
        <div
          v-if="true"
          v-html="hit.price_html"
          class="sgm-text-base sgm-font-medium sgm-text-gray-900"
        ></div>
        <div
          v-else
          class="sgm-text-base sgm-font-medium sgm-text-gray-900 sgm-mt-2 sgm-text-left"
          v-html="hit.price"
        ></div>
      </div>
    </div>
  </div>
</template>
