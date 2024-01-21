<script setup>

let props = defineProps({
    hit: Object,
    active: Boolean,
    selected: Boolean
})
</script>

<template>
    <div class="group relative cursor-pointer p-3" :class="(active || selected) ? 'bg-zinc-100/50' : ''">
        <div class="aspect-h-1 aspect-w-1 w-full overflow-hidden rounded-md lg:aspect-none group-hover:opacity-75">
            <img :src="hit.image" class="h-full w-full object-cover object-center lg:h-full lg:w-full" />
        </div>
        <div class="mt-4 flex justify-between">
            <div>
                <h3 class="text-sm text-gray-700 text-left">
                    <div>
                        <span aria-hidden="true" class="absolute inset-0" />
                        {{ hit.name }}
                    </div>
                </h3>
                <p class="text-sm text-gray-500 text-left">{{ hit.short_description }}</p>
                <p class="mt-1 text-sm text-gray-500 text-left">{{ hit.categories.join(',') }}</p>
                <!-- <StarIcon v-for="rating in [0, 1, 2, 3, 4]" :key="rating" :class="[true ? 'text-yellow-400' : 'text-gray-200', 'h-5 w-5 flex-shrink-0']" aria-hidden="true" /> -->
            </div>
            <p class="text-sm font-medium text-gray-900">
                <span v-html="hit.price"></span>
            </p>
        </div>
    </div>
</template>

