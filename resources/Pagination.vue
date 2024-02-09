<script setup>
import { computed } from "vue";
import { ChevronLeftIcon, ChevronRightIcon } from "@heroicons/vue/20/solid";

const props = defineProps({
  total: {
    required: true,
  },
  perPage: {
    required: true,
  },
  currentPage: {
    required: true,
  },
});

const totalPages = computed(() => Math.ceil(props.total / props.perPage));
</script>

<template>
  <div class="flex flex-row w-full justify-end pb-4 max-w-7xl mx-auto">
    <div class="flex flex-row bg-white">
      <button
        :disabled="currentPage <= 1"
        @click="$emit('changePage', currentPage - 1)"
        class="relative inline-flex items-center px-2 py-2 text-sm font-semibold text-gray-900 hover:bg-gray-50 focus:z-20 focus:outline-offset-0 rounded-l-md"
      >
        <span class="sr-only">Previous</span>
        <ChevronLeftIcon class="h-5 w-5" aria-hidden="true" />
      </button>
      <button
        @click="$emit('changePage', 1)"
        :class="{
          'text-red-500': parseInt(currentPage) === 1,
          'text-gray-900': parseInt(currentPage) !== 1,
        }"
        class="relative inline-flex items-center px-2 py-2 text-sm font-semibold hover:bg-gray-50 focus:z-20 focus:outline-offset-0"
      >
        1
      </button>
      <span
        v-if="currentPage > 3 && totalPages > 5"
        class="px-2 py-2 text-sm font-semibold text-gray-700"
        >...</span
      >
      <template
        v-for="page in totalPages <= 5 ? [...Array(totalPages).keys()].slice(1).map(i => i + 1) : [currentPage - 1, currentPage, currentPage + 1]"
        :key="page"
      >
        <button
          v-if="page > 1 && page < totalPages"
          @click="$emit('changePage', page)"
          :class="{
            'text-red-500': parseInt(page) === parseInt(currentPage),
            'text-gray-900': parseInt(page) !== parseInt(currentPage),
          }"
          class="relative inline-flex items-center px-2 py-2 text-sm font-semibold hover:bg-gray-50 focus:z-20 focus:outline-offset-0"
        >
          {{ page }}
        </button>
      </template>
      <span
        v-if="currentPage < totalPages - 2 && totalPages > 5"
        class="px-4 py-2 text-sm font-semibold text-gray-700"
        >...</span
      >
      <button
        v-if="totalPages > 1"
        @click="$emit('changePage', totalPages)"
        :class="{
          'text-red-500': parseInt(currentPage) === parseInt(totalPages),
          'text-gray-900': parseInt(currentPage) !== parseInt(totalPages),
        }"
        class="relative inline-flex items-center px-2 py-2 text-sm font-semibold hover:bg-gray-50 focus:z-20 focus:outline-offset-0"
      >
        {{ totalPages }}
      </button>
      <button
        :disabled="currentPage >= totalPages"
        @click="
          $emit(
            'changePage',
            currentPage + 1
          )
        "
        class="relative inline-flex items-center px-2 py-2 text-sm font-semibold text-gray-900 hover:bg-gray-50 focus:z-20 focus:outline-offset-0 rounded-r-md"
      >
        <span class="sr-only">Next</span>
        <ChevronRightIcon class="h-5 w-5" aria-hidden="true" />
      </button>
    </div>
  </div>
