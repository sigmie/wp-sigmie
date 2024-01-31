<template>
  <SigmieSearch :facets="facetsString" :debounceMs="250" :apiKey="props.apiKey" :sort="sortBy" :query="query" :perPage="numberOfResults" :filters="filterString" :search="props.index" :applicationId="props.application" v-slot="{
    hits,
    facets,
    total,
    loading,
    processing_time_ms,
  }">
    <Layout title="New Arrivals">

      <template v-slot:categories>
        <h3 class="sr-only">Categories</h3>
        <ul role="list" class="px-2 py-3 font-medium text-gray-900">
          <li v-for="(categoryIdx, category) in facets.categories ?? []" :key="categoryIdx">
            <a href="#" class="block px-2 py-2">{{ category }}</a>
          </li>
        </ul>
      </template>

      <template v-slot:sort>
        <Menu as="div" class="relative inline-block text-left">
          <div>
            <MenuButton class="group inline-flex justify-center text-sm font-medium text-gray-700 hover:text-gray-900">
              Sort
              <ChevronDownIcon class="-mr-1 ml-1 h-5 w-5 flex-shrink-0 text-gray-400 group-hover:text-gray-500" aria-hidden="true" />
            </MenuButton>
          </div>

          <transition enter-active-class="transition ease-out duration-100" enter-from-class="transform opacity-0 scale-95" enter-to-class="transform opacity-100 scale-100" leave-active-class="transition ease-in duration-75" leave-from-class="transform opacity-100 scale-100" leave-to-class="transform opacity-0 scale-95">
            <MenuItems class="absolute right-0 z-10 mt-2 w-40 origin-top-right rounded-md bg-white shadow-2xl ring-1 ring-black ring-opacity-5 focus:outline-none">
              <div class="py-1">
                <MenuItem v-slot="{ active }">
                <a href="#" :class="[true ? 'font-medium text-gray-900' : 'text-gray-500', active ? 'bg-gray-100' : '', 'block px-4 py-2 text-sm']">Relevance</a>
                </MenuItem>
              </div>
            </MenuItems>
          </transition>
        </Menu>
      </template>

      <template v-slot:hits>
        <div class="grid grid-cols-4 gap-8">
          <FilterHit v-for="hit in hits" :hit="hit"></FilterHit>
        </div>
      </template>

      <template v-slot:filters>
        <div class="px-3">
          <Facet v-for="(index, key) in filterVals" :label="{
            categories: 'Categories',
          }[key] ?? key
            " :facets="facets[key] ?? []" v-model="filterVals[key]"></Facet>
        </div>
      </template>

    </Layout>

  </SigmieSearch>
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
  Menu,
  MenuButton,
  MenuItem,
  MenuItems,
} from '@headlessui/vue'
import { XMarkIcon } from '@heroicons/vue/24/outline'
import { ChevronDownIcon, PlusIcon } from '@heroicons/vue/20/solid'
import { SigmieSearch } from "@sigmie/vue";
import FilterHit from "./FilterHit.vue";
import Facet from './Facet.vue'
import Layout from './FilterLayout.vue'

const props = defineProps({
  application: String,
  apiKey: String,
  index: String,
})

const facetsString = ref('categories:20');
const filterString = ref('');
const filterVals = ref([]);

watch(filterVals, (newVal, oldVal) => {

  filterString.value = Object.entries(newVal)
    .flatMap(([key, values]) =>
      Array.isArray(values)
        ? values.map((value) => `${key}:'${value}'`)
        : `${key}:'${values}'`
    )
    .join(" AND ");

  console.log(filterVals.value);
}, {
  deep: true
});

onMounted(() => {

  console.log(JSON.parse(JSON.stringify(props)));

  filterVals.value = facetsString.value.split(" ").reduce((acc, key) => {

    [key,] = key.split(':');

    acc[key] = [];

    return acc;
  }, {});

  console.log(JSON.parse(JSON.stringify(filterVals.value)));
});

const mobileFiltersOpen = ref(false)
</script>
