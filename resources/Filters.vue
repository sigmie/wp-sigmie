<template>
  <div class="bg-white">
    <SigmieSearch :facets="facetsString" :debounceMs="250" :apiKey="props.apiKey" :sort="sortBy" :query="query" :perPage="numberOfResults" :filters="''" :search="props.index" :applicationId="props.application" v-slot="{
      hits,
      facets,
      total,
      loading,
      processing_time_ms,
    }">
      <div>
        <!-- Mobile filter dialog -->
        <TransitionRoot as="template" :show="mobileFiltersOpen">
          <Dialog as="div" class="relative z-40 lg:hidden" @close="mobileFiltersOpen = false">
            <TransitionChild as="template" enter="transition-opacity ease-linear duration-300" enter-from="opacity-0" enter-to="opacity-100" leave="transition-opacity ease-linear duration-300" leave-from="opacity-100" leave-to="opacity-0">
              <div class="fixed inset-0 bg-black bg-opacity-25" />
            </TransitionChild>

            <div class="fixed inset-0 z-40 flex">
              <TransitionChild as="template" enter="transition ease-in-out duration-300 transform" enter-from="translate-x-full" enter-to="translate-x-0" leave="transition ease-in-out duration-300 transform" leave-from="translate-x-0" leave-to="translate-x-full">
                <DialogPanel class="relative ml-auto flex h-full w-full max-w-xs flex-col overflow-y-auto bg-white py-4 pb-6 shadow-xl">
                  <div class="flex items-center justify-between px-4">
                    <h2 class="text-lg font-medium text-gray-900">Filters</h2>
                    <button type="button" class="-mr-2 flex h-10 w-10 items-center justify-center p-2 text-gray-400 hover:text-gray-500" @click="mobileFiltersOpen = false">
                      <span class="sr-only">Close menu</span>
                      <XMarkIcon class="h-6 w-6" aria-hidden="true" />
                    </button>
                  </div>

                  <!-- Filters -->
                  <form class="mt-4">
                    <Disclosure as="div" v-for="section in filters" :key="section.name" class="border-t border-gray-200 pb-4 pt-4" v-slot="{ open }">
                      <fieldset>
                        <legend class="w-full px-2">
                          <DisclosureButton class="flex w-full items-center justify-between p-2 text-gray-400 hover:text-gray-500">
                            <span class="text-sm font-medium text-gray-900">{{ section.name }}</span>
                            <span class="ml-6 flex h-7 items-center">
                              <ChevronDownIcon :class="[open ? '-rotate-180' : 'rotate-0', 'h-5 w-5 transform']" aria-hidden="true" />
                            </span>
                          </DisclosureButton>
                        </legend>
                        <DisclosurePanel class="px-4 pb-2 pt-4">
                          <div class="space-y-6">
                            <div v-for="(option, optionIdx) in section.options" :key="option.value" class="flex items-center">
                              <input :id="`${section.id}-${optionIdx}-mobile`" :name="`${section.id}[]`" :value="option.value" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" />
                              <label :for="`${section.id}-${optionIdx}-mobile`" class="ml-3 text-sm text-gray-500">{{ option.label }}</label>
                            </div>
                          </div>
                        </DisclosurePanel>
                      </fieldset>
                    </Disclosure>
                  </form>
                </DialogPanel>
              </TransitionChild>
            </div>
          </Dialog>
        </TransitionRoot>

        <main class="mx-auto max-w-2xl px-4 py-16 sm:px-6 sm:py-24 lg:max-w-7xl lg:px-8">
          <div class="border-b border-gray-200 pb-10">
            <h1 class="text-4xl font-bold tracking-tight text-gray-900">New Arrivals</h1>
            <p class="mt-4 text-base text-gray-500">Checkout out the latest release of Basic Tees, new and improved with four openings!</p>
          </div>

          <div class="pt-12 lg:grid lg:grid-cols-3 lg:gap-x-8 xl:grid-cols-4">
            <aside>
              <h2 class="sr-only">Filters</h2>

              <button type="button" class="inline-flex items-center lg:hidden" @click="mobileFiltersOpen = true">
                <span class="text-sm font-medium text-gray-700">Filters</span>
                <PlusIcon class="ml-1 h-5 w-5 flex-shrink-0 text-gray-400" aria-hidden="true" />
              </button>

              <div class="hidden lg:block">
                <div class="flex flex-col space-y-4">
                  <Facet v-for="(index, key) in filterVals" :label="{
                    category: 'Categories',
                  }[key] ?? key
                    " :facets="facets[key]" v-model="filterVals[key]"></Facet>
                </div>
              </div>
            </aside>

            <!-- Product grid -->
            <div class="w-full grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 xl:gap-x-8 col-span-3">
              <FilterHit v-for="hit in hits" :hit="hit"></FilterHit>

              <!-- Your content -->
            </div>
          </div>
        </main>
      </div>
    </SigmieSearch>
  </div>
</template>

<script setup>
import { ref, onMounted, watch } from 'vue'
import {
  Dialog,
  DialogPanel,
  Disclosure,
  DisclosureButton,
  DisclosurePanel,
  TransitionChild,
  TransitionRoot,
} from '@headlessui/vue'
import { XMarkIcon } from '@heroicons/vue/24/outline'
import { ChevronDownIcon, PlusIcon } from '@heroicons/vue/20/solid'
import { SigmieSearch } from "@sigmie/vue";
import FilterHit from "./FilterHit.vue";
import Facet from './Facet.vue'

const props = defineProps({
  application: String,
  apiKey: String,
  index: String,
})



const facetsString = ref('categories');
const filterVals = ref([]);

watch(filterVals, (newVal, oldVal) => {
  let filterString = Object.entries(newVal)
    .flatMap(([key, values]) =>
      Array.isArray(values)
        ? values.map((value) => `${key}:'${value}'`)
        : `${key}:'${values}'`
    )
    .join(" AND ");

  console.log(filterVals);
  // emit("update:filters", filterString);
}, {
  deep: true,
});

onMounted(() => {
  // console.log('da');
  console.log(JSON.parse(JSON.stringify(props)));

  filterVals.value = facetsString.value.split(" ").reduce((acc, key) => {
    acc[key] = [];
    return acc;
  }, {});

  console.log(JSON.parse(JSON.stringify(filterVals.value)));
});


const filters = [
  {
    id: 'color',
    name: 'Color',
    options: [
      { value: 'white', label: 'White' },
      { value: 'beige', label: 'Beige' },
      { value: 'blue', label: 'Blue' },
      { value: 'brown', label: 'Brown' },
      { value: 'green', label: 'Green' },
      { value: 'purple', label: 'Purple' },
    ],
  },
  {
    id: 'category',
    name: 'Category',
    options: [
      { value: 'new-arrivals', label: 'All New Arrivals' },
      { value: 'tees', label: 'Tees' },
      { value: 'crewnecks', label: 'Crewnecks' },
      { value: 'sweatshirts', label: 'Sweatshirts' },
      { value: 'pants-shorts', label: 'Pants & Shorts' },
    ],
  },
  {
    id: 'sizes',
    name: 'Sizes',
    options: [
      { value: 'xs', label: 'XS' },
      { value: 's', label: 'S' },
      { value: 'm', label: 'M' },
      { value: 'l', label: 'L' },
      { value: 'xl', label: 'XL' },
      { value: '2xl', label: '2XL' },
    ],
  },
]

const mobileFiltersOpen = ref(false)
</script>
