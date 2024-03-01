<script setup>
import EmptyStart from "./EmptyStart.vue";
import FullStart from "./FullStart.vue";
import HalfStart from "./HalfStart.vue";
let props = defineProps({
  average_rating: Number,
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
  <div class="sgm-flex sgm-flex-row">
    
    <FullStart
      v-for="n in Math.floor(average_rating || 0)"
      :key="`full-${n}`"
      class="sgm-text-orange-400 sgm-h-3 sgm-w-3 sgm-flex-shrink-0"
      aria-hidden="true"
    />
    <HalfStart
      v-if="(average_rating || 0) % 1 > 0"
      :key="`half-${Math.floor(average_rating || 0)}`"
      class="sgm-text-orange-400 sgm-h-3 sgm-w-3 sgm-flex-shrink-0"
      aria-hidden="true"
    />
    <EmptyStart
      v-for="n in 5 - Math.ceil(average_rating || 0)"
      :key="`empty-${n}`"
      class="sgm-text-orange-400 sgm-h-3 sgm-w-3 sgm-flex-shrink-0"
      aria-hidden="true"
    />
  </div>
</template>
