<script setup>
import EmptyStart from "./EmptyStart.vue";
import FullStart from "./FullStart.vue";
import HalfStart from "./HalfStart.vue";
import DeferredContent from "primevue/deferredcontent";

let props = defineProps({
  hit: Object,
  active: Boolean,
  selected: Boolean,
  maxDescriptionLength: Number,
  showCategory: Boolean,
  showDescription: Boolean,
  showPrice: Boolean,
  showRating: Boolean,
  showSku: Boolean,
  showStock: Boolean,
  showOnSale: Boolean,
});
</script>

<template>
  <div
    class="sgm-group sgm-relative sgm-cursor-pointer sgm-p-3"
    :class="active || selected ? 'sgm-bg-zinc-100/50' : ''"
  >
    <div
      class="sgm-aspect-h-1 sgm-aspect-w-1 sgm-w-full sgm-overflow-hidden sgm-rounded-md lg:sgm-aspect-none sgm-group-hover:sgm-opacity-75"
    >
      <DeferredContent>
        <img
          :src="hit.image"
          class="sgm-h-full sgm-w-full sgm-object-cover sgm-object-center lg:sgm-h-full lg:sgm-w-full"
        />
      </DeferredContent>
    </div>
    <div class="sgm-mt-4 sgm-flex sgm-justify-between">
      <div>
        <div
          v-if="showCategory"
          class="sgm-mt-1 sgm-text-sm sgm-text-gray-500 sgm-text-left sgm-font-normal"
        >
          {{ hit.categories.join(",") }}
        </div>
        <h3 class="sgm-text-sm sgm-text-gray-700 sgm-text-left sgm-mt-1">
          <span aria-hidden="true" class="sgm-absolute sgm-inset-0" />
          {{ hit.name }}
        </h3>
        <p
          v-if="showDescription"
          class="sgm-text-sm sgm-text-gray-500 sgm-text-left sgm-font-normal"
        >
          {{
            hit.short_description.length > maxDescriptionLength
              ? hit.short_description.substring(0, maxDescriptionLength)
              : hit.short_description
          }}
        </p>
        <p
          v-if="showSku"
          class="sgm-text-sm sgm-text-gray-500 sgm-text-left sgm-font-normal sgm-h-8"
        >
          {{ hit.sku }}
        </p>
        <div v-if="showRating" class="sgm-flex sgm-flex-row sgm-space-x-1">
          <FullStart
            v-for="n in Math.floor(hit.average_rating || 0)"
            :key="`full-${n}`"
            class="sgm-text-yellow-400 sgm-h-5 sgm-w-5 sgm-flex-shrink-0"
            aria-hidden="true"
          />
          <HalfStart
            v-if="(hit.average_rating || 0) % 1 > 0"
            :key="`half-${Math.floor(hit.average_rating || 0)}`"
            class="sgm-text-yellow-400 sgm-h-5 sgm-w-5 sgm-flex-shrink-0"
            aria-hidden="true"
          />
          <EmptyStart
            v-for="n in 5 - Math.ceil(hit.average_rating || 0)"
            :key="`empty-${n}`"
            class="sgm-text-gray-400 sgm-h-5 sgm-w-5 sgm-flex-shrink-0"
            aria-hidden="true"
          />
          <div>
            <span class="sgm-text-gray-500 sgm-font-light sgm-text-sm">
              ({{ hit.review_count }})</span
            >
          </div>
        </div>
        <div
          v-if="showOnSale"
          class="sgm-text-base sgm-font-medium sgm-text-gray-900 sgm-mt-2 sgm-text-left"
          v-html="hit.price_html"
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
