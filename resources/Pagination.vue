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
  <div
    class="sgm-flex sgm-flex-row sgm-w-full sgm-justify-end sgm-pb-4 sgm-max-w-7xl sgm-mx-auto"
  >
    <div
      class="sgm-flex sgm-flex-row sgm-justify-between sgm-w-full sgm-items-center sgm-bg-white"
    >
      <div
        :disabled="currentPage <= 1"
        @click="currentPage <= 1 ? null : $emit('changePage', currentPage - 1)"
        class="sgm-cursor-pointer sgm-relative sgm-inline-flex sgm-items-center sgm-px-2 sgm-py-2 sgm-text-sm sgm-font-semibold sgm-text-gray-900 sgm-hover:bg-gray-50 sgm-focus:z-20 sgm-focus:outline-offset-0 sgm-rounded-l-md"
      >
        <span class="sgm-sr-only">Previous</span>
        <ChevronLeftIcon class="sgm-h-5 sgm-w-5" aria-hidden="true" />
      </div>
      <div>
        <div
          @click="$emit('changePage', 1)"
          :class="{
            'sgm-text-primary-color': parseInt(currentPage) === 1,
            'sgm-text-gray-900': parseInt(currentPage) !== 1,
          }"
          class="sgm-cursor-pointer sgm-relative sgm-inline-flex sgm-items-center sgm-px-2 sgm-py-2 sgm-text-sm sgm-font-semibold sgm-hover:bg-gray-50 sgm-focus:z-20 sgm-focus:outline-offset-0"
        >
          1
        </div>
        <span
          v-if="currentPage > 3 && totalPages > 5"
          class="sgm-px-2 sgm-py-2 sgm-text-sm sgm-font-semibold sgm-text-gray-700"
          >...</span
        >
        <template
          v-for="page in totalPages <= 5
            ? [...Array(totalPages).keys()].slice(1).map((i) => i + 1)
            : [currentPage - 1, currentPage, currentPage + 1]"
          :key="page"
        >
          <div
            v-if="page > 1 && page < totalPages"
            @click="$emit('changePage', page)"
            :class="{
              'sgm-text-primary-color':
                parseInt(page) === parseInt(currentPage),
              'sgm-text-gray-900': parseInt(page) !== parseInt(currentPage),
            }"
            class="sgm-cursor-pointer sgm-relative sgm-inline-flex sgm-items-center sgm-px-2 sgm-py-2 sgm-text-sm sgm-font-semibold sgm-hover:bg-gray-50 sgm-focus:z-20 sgm-focus:outline-offset-0"
          >
            {{ page }}
          </div>
        </template>
        <span
          v-if="currentPage < totalPages - 2 && totalPages > 5"
          class="sgm-px-2 sgm-py-2 sgm-text-sm sgm-font-semibold sgm-text-gray-700"
          >...</span
        >
        <div
          v-if="totalPages > 1"
          @click="$emit('changePage', totalPages)"
          :class="{
            'sgm-text-primary-color':
              parseInt(currentPage) === parseInt(totalPages),
            'sgm-text-gray-900': parseInt(currentPage) !== parseInt(totalPages),
          }"
          class="sgm-cursor-pointer sgm-relative sgm-inline-flex sgm-items-center sgm-px-2 sgm-py-2 sgm-text-sm sgm-font-semibold sgm-hover:bg-gray-50 sgm-focus:z-20 sgm-focus:outline-offset-0"
        >
          {{ totalPages }}
        </div>
      </div>
      <div
        :disabled="currentPage >= totalPages"
        @click="
          currentPage >= totalPages
            ? null
            : $emit('changePage', currentPage + 1)
        "
        class="sgm-cursor-pointer sgm-relative sgm-inline-flex sgm-items-center sgm-px-2 sgm-py-2 sgm-text-sm sgm-font-semibold sgm-text-gray-900 sgm-hover:bg-gray-50 sgm-focus:z-20 sgm-focus:outline-offset-0 sgm-rounded-r-md"
      >
        <span class="sgm-sr-only">Next</span>
        <ChevronRightIcon class="sgm-h-5 sgm-w-5" aria-hidden="true" />
      </div>
    </div>
  </div>
</template>
