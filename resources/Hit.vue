<script setup>

let props = defineProps({
    hit: Object,
    active: Boolean,
    selected: Boolean
})
</script>

<template>
    <div :class="{
        'bg-zinc-100': props.active,
        'bg-zinc-200': props.selected,
    }" class="flex flex-row items-start space-x-6 p-2 rounded-md">
        <div class="h-20 w-20 rounded-md overflow-hidden" v-html="props.hit.thumbnail_html">
        </div>
        <div class="flex flex-col justify-between h-full">
            <div class="flex flex-col justify-start items-start">
                <div class="font-bold text-zinc-900 text-left">
                    {{ hit.name }}
                </div>
                <div class="text-zinc-600">
                    {{ hit.short_description }}
                </div>
            </div>
            <div class="font-bold text-zinc-950 text-left mt-2">
                {{ hit.price }}$
            </div>
        </div>
    </div>
</template>

