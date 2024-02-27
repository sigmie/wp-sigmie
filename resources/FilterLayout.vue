<template>
  <div class="sgm-max-w-[1500px] sgm-mx-auto">
    <div>
      <TransitionRoot as="template" :show="mobileFiltersOpen">
        <Dialog
          as="div"
          class="sgm-relative sgm-z-40 lg:sgm-hidden"
          @close="mobileFiltersOpen = false"
        >
          <TransitionChild
            as="template"
            enter="sgm-transition-opacity sgm-ease-linear sgm-duration-300"
            enter-from="sgm-opacity-0"
            enter-to="sgm-opacity-100"
            leave="sgm-transition-opacity sgm-ease-linear sgm-duration-300"
            leave-from="sgm-opacity-100"
            leave-to="sgm-opacity-0"
          >
            <div class="sgm-fixed sgm-inset-0 sgm-bg-black sgm-bg-opacity-25" />
          </TransitionChild>

          <div class="sgm-fixed sgm-inset-0 sgm-z-40 sgm-flex">
            <TransitionChild
              as="template"
              enter="sgm-transition sgm-ease-in-out sgm-duration-300 sgm-transform"
              enter-from="sgm-translate-x-full"
              enter-to="sgm-translate-x-0"
              leave="sgm-transition sgm-ease-in-out sgm-duration-300 sgm-transform"
              leave-from="sgm-translate-x-0"
              leave-to="sgm-translate-x-full"
            >
              <DialogPanel
                class="sgm-px-4 sgm-relative sgm-ml-auto sgm-flex sgm-h-full sgm-w-full sgm-max-w-xs sgm-flex-col sgm-overflow-y-auto sgm-bg-white sgm-py-4 sgm-pb-12 sgm-shadow-xl"
              >
                <div
                  class="sgm-flex sgm-items-center sgm-justify-between sgm-px-4"
                >
                  <h2 class="sgm-text-lg sgm-font-medium sgm-text-gray-900">
                    Filters
                  </h2>
                  <button
                    type="button"
                    class="sgm--mr-2 sgm-flex sgm-h-10 sgm-w-10 sgm-items-center sgm-justify-center sgm-rounded-md sgm-bg-white sgm-p-2 sgm-text-gray-400"
                    @click="mobileFiltersOpen = false"
                  >
                    <span class="sgm-sr-only">Close menu</span>
                    <XMarkIcon class="sgm-h-6 sgm-w-6" aria-hidden="true" />
                  </button>
                </div>

                <!-- Filters -->
                <form class="sgm-mt-4 sgm-border-t sgm-border-gray-200 px-4">
                  <slot name="filters"></slot>
                </form>
              </DialogPanel>
            </TransitionChild>
          </div>
        </Dialog>
      </TransitionRoot>

      <main class="">
        <section
          aria-labelledby="products-heading"
          class="sgm-pb-24 sgm-pt-6 sgm-px-6"
        >
          <div
            class="sgm-flex sgm-flex-row lg:sgm-space-x-14 sgm-px-4 lg:sgm-px-0 sgm-mx-auto"
          >
            <!-- Filters -->
            <form class="sgm-hidden lg:sgm-block sgm-max-w-[350px]">
              <div class="sgm-flex sgm-flex-row sgm-space-x-3 sgm-items-center">
                <h2
                  class="sgm-text-xl sgm-font-normal sgm-tracking-tight sgm-text-gray-900 sgm-m-0"
                >
                  {{ title }}
                </h2>
                <div>
                  <slot name="reset"></slot>
                </div>
              </div>
              <div class="sgm-mt-6">
                <slot name="filters"></slot>
              </div>
            </form>

            <div class="sgm-w-full">
              <div class="sgm-flex sgm-flex-col sgm-items-start sgm-w-full">
                <h2
                  class="sgm-text-xl sgm-font-normal sgm-tracking-tight sgm-text-gray-900"
                >
                  {{ hitsTitle }}
                </h2>
                <div class="sgm-text-gray-900 sgm-mt-2">
                  {{ hitsSubtitle }}
                </div>
                <slot name="active-filters"></slot>
              </div>
              <div
                class="sgm-flex sgm-items-baseline sgm-justify-between sgm-w-full"
              >
                <slot name="sort"></slot>

                <div class="sgm-max-w-sm">
                  <slot v-if="total > 0" name="pagination"></slot>
                </div>
                <div class="lg:sgm-hidden">
                  <Button
                    class=""
                    outlined
                    severity="secondary"
                    @click="mobileFiltersOpen = true"
                  >
                    <span class="sgm-sr-only">Filters</span>
                    <FunnelIcon
                      class="sgm-h-5 sgm-w-5 sgm-fill-secondary-color"
                      aria-hidden="true"
                    />
                  </Button>
                </div>
              </div>

              <div class="" v-if="total > 0">
                <slot name="hits"></slot>

                <div class="sgm-mt-6">
                  <slot name="pagination"></slot>
                </div>
              </div>
              <div
                class="sgm-h-80 sgm-flex sgm-justify-h sgm-justify-center sgm-flex-col sgm-items-center"
                v-else
              >
                <slot name="no-results"></slot>
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
import { ref } from "vue";
import {
  Dialog,
  DialogPanel,
  TransitionChild,
  TransitionRoot,
} from "@headlessui/vue";
import { XMarkIcon } from "@heroicons/vue/24/outline";
import { FunnelIcon } from "@heroicons/vue/20/solid";
import Button from "primevue/button";

const props = defineProps({
  title: String,
  hitsTitle: String,
  hitsSubtitle: String,
  total: Number,
});

const mobileFiltersOpen = ref(false);
</script>
