<script setup>

import EmptyStart from './EmptyStart.vue'
import FullStart from './FullStart.vue';
import HalfStart from './HalfStart.vue';

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
})
</script>

<template>
    <div class="group relative cursor-pointer p-3" :class="(active || selected) ? 'bg-zinc-100/50' : ''">
        <div class="aspect-h-1 aspect-w-1 w-full overflow-hidden rounded-md lg:aspect-none group-hover:opacity-75">
            <img :src="hit.image" class="h-full w-full object-cover object-center lg:h-full lg:w-full" />
        </div>
        <div class="mt-4 flex justify-between">
            <div>
                <div v-if="showCategory" class="mt-1 text-sm text-gray-500 text-left font-normal">{{ hit.categories.join(',') }}</div>
                <h3 class="text-sm text-gray-700 text-left mt-1">
                    <span aria-hidden="true" class="absolute inset-0" />
                    {{ hit.name }}
                </h3>
                <p v-if="showDescription" class="text-sm text-gray-500 text-left font-normal">
                    {{ hit.short_description.length > maxDescriptionLength ? hit.short_description.substring(0, maxDescriptionLength) : hit.short_description }}
                </p>
                <p v-if="showSku" class="text-sm text-gray-500 text-left font-normal h-8">
                    {{ hit.sku }}
                </p>
                <div v-if="showRating" class="flex flex-row space-x-1">
                    <FullStart v-for="n in Math.floor(hit.average_rating || 0)" :key="`full-${n}`" class="text-yellow-400 h-5 w-5 flex-shrink-0" aria-hidden="true" />
                    <HalfStart v-if="(hit.average_rating || 0) % 1 > 0" :key="`half-${Math.floor(hit.average_rating || 0)}`" class="text-yellow-400 h-5 w-5 flex-shrink-0" aria-hidden="true" />
                    <EmptyStart v-for="n in 5 - Math.ceil(hit.average_rating || 0)" :key="`empty-${n}`" class="text-gray-400 h-5 w-5 flex-shrink-0" aria-hidden="true" />
                    <div>
                        <span class="text-gray-500 font-light text-sm"> ({{ hit.review_count }})</span>
                    </div>
                </div>
                <div v-if="showOnSale" class="text-md font-medium text-gray-900 mt-2 text-left" v-html="hit.price_html"></div>
                <div v-else class="text-md font-medium text-gray-900 mt-2 text-left" v-html="hit.price"></div>
            </div>
        </div>
    </div>
</template>

