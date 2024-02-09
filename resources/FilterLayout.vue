<template>
  <div class="bg-white">
    <div>
      <TransitionRoot as="template" :show="mobileFiltersOpen">
        <Dialog
          as="div"
          class="relative z-40 lg:hidden"
          @close="mobileFiltersOpen = false"
        >
          <TransitionChild
            as="template"
            enter="transition-opacity ease-linear duration-300"
            enter-from="opacity-0"
            enter-to="opacity-100"
            leave="transition-opacity ease-linear duration-300"
            leave-from="opacity-100"
            leave-to="opacity-0"
          >
            <div class="fixed inset-0 bg-black bg-opacity-25" />
          </TransitionChild>

          <div class="fixed inset-0 z-40 flex">
            <TransitionChild
              as="template"
              enter="transition ease-in-out duration-300 transform"
              enter-from="translate-x-full"
              enter-to="translate-x-0"
              leave="transition ease-in-out duration-300 transform"
              leave-from="translate-x-0"
              leave-to="translate-x-full"
            >
              <DialogPanel
                class="relative ml-auto flex h-full w-full max-w-xs flex-col overflow-y-auto bg-white py-4 pb-12 shadow-xl"
              >
                <div class="flex items-center justify-between px-4">
                  <h2 class="text-lg font-medium text-gray-900">Filters</h2>
                  <button
                    type="button"
                    class="-mr-2 flex h-10 w-10 items-center justify-center rounded-md bg-white p-2 text-gray-400"
                    @click="mobileFiltersOpen = false"
                  >
                    <span class="sr-only">Close menu</span>
                    <XMarkIcon class="h-6 w-6" aria-hidden="true" />
                  </button>
                </div>

                <!-- Filters -->
                <form class="mt-4 border-t border-gray-200">
                  <slot name="filters"></slot>
                </form>
              </DialogPanel>
            </TransitionChild>
          </div>
        </Dialog>
      </TransitionRoot>

      <main class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <section aria-labelledby="products-heading" class="pb-24 pt-6">
          <div class="grid grid-cols-1 gap-x-8 gap-y-10 lg:grid-cols-6">
            <!-- Filters -->
            <form class="hidden lg:block col-span-2">
              <h2
                class="text-xl mb-10 font-normal tracking-tight text-gray-900"
              >
                {{ title }}
              </h2>
              <slot name="filters"></slot>
            </form>

            <div class="lg:col-span-4">
              <div class="flex flex-col items-start w-full">
                <h2 class="text-xl font-normal tracking-tight text-gray-900">
                  {{ hitsTitle }}
                </h2>
                <div class="text-gray-900 mt-2">{{ total }} Products</div>
                <slot name="active-filters"></slot>
              </div>
              <div class="flex items-baseline justify-between w-full">
                <slot name="sort"></slot>

                <div class="max-w-sm">
                  <slot v-if="total > 0" name="pagination"></slot>
                </div>
                <button
                  type="button"
                  class="-m-2 ml-4 p-2 text-gray-400 hover:text-gray-500 sm:ml-6 lg:hidden"
                  @click="mobileFiltersOpen = true"
                >
                  <span class="sr-only">Filters</span>
                  <FunnelIcon class="h-5 w-5" aria-hidden="true" />
                </button>
              </div>

              <div>
                <slot name="hits"></slot>

                <div class="mt-6">
                  <slot v-if="total > 0" name="pagination"></slot>
                </div>
              </div>
            </div>
          </div>
        </section>
      </main>
    </div>
  </div>
</template>

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

defineProps({
  title: String,
  hitsTitle: String,
  total: String,
});

const mobileFiltersOpen = ref(false);
</script>
