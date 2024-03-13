<template>
  <div class="sgm-max-w-[1400px] sgm-w-full sgm-mx-auto">
    <div>
      <MobileFiltersDrawer
        :title="title"
        class="lg:sgm-hidden"
        :show="mobileFiltersOpen"
        @close="mobileFiltersOpen = false"
      >
        <div class="sgm-flex sgm-flex-col sgm-space-y-4">
          <slot name="mobile-sort"></slot>

          <slot name="mobile-filters"></slot>
        </div>

        <template v-slot:actions>
          <div
            class="sgm-flex sgm-flex-row sgm-items-center sgm-justify-between"
          >
            <Button
              class="sgm-w-[48%] sgm-h-full"
              outlined
              severity="secondary"
              @click="mobileFiltersOpen = false"
            >
              <span class="sgm-text-black sgm-w-full sgm-text-center"
                >View</span
              >
            </Button>
            <slot name="mobile-reset-action"></slot>
          </div>
        </template>
      </MobileFiltersDrawer>

      <main class="">
        <section
          aria-labelledby="products-heading"
          class="sgm-pb-24 sgm-pt-6 sgm-px-6"
        >
          <div
            class="sgm-flex sgm-flex-row lg:sgm-space-x-14 sgm-px-4 lg:sgm-px-0 sgm-mx-auto"
          >
            <!-- Filters -->
            <form class="sgm-hidden lg:sgm-block sgm-w-[275px]">
              <div class="sgm-flex sgm-flex-row sgm-space-x-3 sgm-items-center">
                <h2
                  class="sgm-text-md sgm-font-normal sgm-tracking-tight sgm-text-gray-900 sgm-m-0"
                >
                  {{ title }}
                </h2>
                <h3 class="text-base font-semibold leading-7 text-gray-900">
                  {{ title }}
                </h3>
              </div>
              <div class="sgm-mt-6">
                <slot name="filters"></slot>
              </div>
            </form>

            <div class="sgm-w-full">
              <div class="sgm-flex sgm-flex-col sgm-items-start sgm-w-full">
                <h2
                  class="sgm-text-xl sgm-font-normal sgm-tracking-tight sgm-text-gray-900 sgm-m-0"
                >
                  {{ hitsTitle }}
                </h2>
                <div class="sgm-text-gray-900 sgm-mt-2">
                  {{ hitsSubtitle }}
                </div>
                <div
                  class="sgm-flex sgm-flex-row sgm-flex-wrap sgm-py-6 sgm-space-x-4 sgm-items-start sgm-w-full sgm-mt-1 sgm-min-h-[2rem]"
                >
                  <slot
                    name="active-filter"
                    v-for="[activeFilterkey, activeFilter] in activeFilters"
                    v-bind="{
                      filterKey: activeFilterkey,
                      filterValue: activeFilter,
                    }"
                  ></slot>
                </div>
              </div>
              <div
                class="sgm-flex sgm-items-center sgm-justify-between sgm-w-full"
              >
                <div class="sgm-flex sgm-flex-row sgm-space-x-4">
                  <slot name="sort"></slot>

                  <slot name="offers"></slot>
                </div>
                <div class="sgm-max-w-sm">
                  <slot v-if="total > 0" name="pagination"></slot>
                </div>

                <div class="lg:sgm-hidden">
                  <Button
                    outlined
                    severity="secondary"
                    @click="mobileFiltersOpen = true"
                    class="sgm-flex sgm-flex-row sgm-space-x-3"
                  >
                    <span class="sgm-text-black">All filters</span>
                    <FilterIcon
                      class="sgm-h-[18.4px] sgm-w-[18.4px] sgm-text-black"
                      aria-hidden="true"
                    />
                  </Button>
                </div>
              </div>

              <slot name="horizontal-one"></slot>

              <div class="" v-if="total > 0">
                <div class="sgm-relative sgm-w-full sgm-h-full sgm-mt-10">
                  <Curtain
                    :is-open="loading"
                    class="sgm-absolute sgm-left-0 sgm-right-0 sgm-z-10"
                  ></Curtain>
                  <div
                    class="sgm-grid sgm-grid-cols-1 sm:sgm-grid-cols-2 md:sgm-grid-cols-3 sgm-gap-8"
                  >
                    <template
                      v-for="(hit, index) in Object.values(hits)"
                      :key="index"
                    >
                      <div>
                        <slot name="hit" v-bind="hit"></slot>
                      </div>
                      <template v-if="index === 5">
                        <div
                          class="sgm-col-span-1 sm:sgm-col-span-2 md:sgm-col-span-3"
                        >
                          <slot name="horizontal-two"></slot>
                        </div>
                      </template>
                    </template>
                  </div>
                </div>

                <div class="sgm-mt-6">
                  <slot name="pagination"></slot>
                </div>
              </div>
              <div
                class="sgm-h-80 sgm-flex sgm-justify-h sgm-justify-center sgm-flex-col sgm-items-center"
                v-else
              >
                <NoHitsIcon class="sgm-h-10 sgm-w-10"></NoHitsIcon>
                <h3
                  class="sgm-mt-2 sgm-text-lg sgm-font-semibold sgm-text-gray-900"
                >
                  {{ noHitsTitle }}
                </h3>
                <p class="sgm-mt-1 sgm-text-sm sgm-text-gray-500">
                  {{ noHitsSubtitle }}
                </p>
                <div class="sgm-mt-6">
                  <slot name="no-hits-action"></slot>
                </div>
              </div>
            </div>
          </div>
        </section>
      </main>
    </div>
  </div>
</template>

<style scoped></style>

<script setup>
import Curtain from "./Curtain.vue";
import NoHitsIcon from "./NoHitsIcon.vue";
import MobileFiltersDrawer from "./MobileFiltersDrawer.vue";
import { ref } from "vue";
import FilterIcon from "./FilterIcon.vue";
import Button from "primevue/button";

const props = defineProps({
  title: String,
  hitsTitle: String,
  hitsSubtitle: String,
  noHitsTitle: String,
  noHitsSubtitle: String,
  total: Number,
  hits: Object,
  loading: Boolean,
  activeFilters: Array,
});

const mobileFiltersOpen = ref(false);
</script>
