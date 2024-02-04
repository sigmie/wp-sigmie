<template>
  <SigmieSearch
    :facets="facetsString"
    :debounceMs="250"
    :apiKey="props.apiKey"
    :sort="sortBy"
    :query="query"
    :perPage="200"
    :filters="filterString"
    :search="props.index"
    :applicationId="props.application"
    v-slot="{ hits, facets, total, loading, processing_time_ms }"
  >
    <Layout title="New Arrivals">
      <template v-slot:categories>
        <div class="h-96 overflow-y-scroll">
          <h3 class="sr-only">Categories</h3>
          <ul role="list" class="px-2 py-3 font-medium text-gray-900">
            <li
              v-for="(categoryIdx, category) in facets.categories ?? []"
              :key="categoryIdx"
            >
              <a href="#" class="block px-2 py-2">{{ category }}</a>
            </li>
          </ul>
        </div>
      </template>

      <template v-slot:sort>
        <Menu as="div" class="relative inline-block text-left">
          <div>
            <MenuButton
              class="group inline-flex justify-center text-sm font-medium text-gray-700 hover:text-gray-900"
            >
              Sort
              <ChevronDownIcon
                class="-mr-1 ml-1 h-5 w-5 flex-shrink-0 text-gray-400 group-hover:text-gray-500"
                aria-hidden="true"
              />
            </MenuButton>
          </div>

          <transition
            enter-active-class="transition ease-out duration-100"
            enter-from-class="transform opacity-0 scale-95"
            enter-to-class="transform opacity-100 scale-100"
            leave-active-class="transition ease-in duration-75"
            leave-from-class="transform opacity-100 scale-100"
            leave-to-class="transform opacity-0 scale-95"
          >
            <MenuItems
              class="absolute right-0 z-10 mt-2 w-40 origin-top-right rounded-md bg-white shadow-2xl ring-1 ring-black ring-opacity-5 focus:outline-none"
            >
              <div class="py-1">
                <MenuItem v-slot="{ active }">
                  <a
                    href="#"
                    :class="[
                      true ? 'font-medium text-gray-900' : 'text-gray-500',
                      active ? 'bg-gray-100' : '',
                      'block px-4 py-2 text-sm',
                    ]"
                    >Relevance</a
                  >
                </MenuItem>
              </div>
            </MenuItems>
          </transition>
        </Menu>
      </template>

      <template v-slot:hits>
        <div class="grid grid-cols-3 gap-8">
          <FilterHit v-for="hit in hits" :hit="hit"></FilterHit>
        </div>
      </template>

      <template v-slot:filters>
        <div class="px-3 flex flex-col space-y-5">
          <template v-for="(index, key) in filterVals">
            <Facet
              v-if="key === 'categories'"
              :label="
                {
                  categories: 'Categories',
                  price_as_number: 'Price',
                }[key] ?? key
              "
              :facets="facets[key] ?? []"
              v-model="filterVals[key]"
            ></Facet>
            <PriceChart
              @rangeChanged="onRangeChange"
              :data="facets.price_as_number"
              v-if="key === 'price_as_number'"
            ></PriceChart>
          </template>
        </div>
      </template>
    </Layout>
  </SigmieSearch>
</template>

<script setup>
import { ref, onMounted, watch } from "vue";
import PriceChart from "./PriceChart.vue";
import { Menu, MenuButton, MenuItem, MenuItems } from "@headlessui/vue";
import { ChevronDownIcon } from "@heroicons/vue/20/solid";
import { SigmieSearch } from "@sigmie/vue";
import FilterHit from "./FilterHit.vue";
import Facet from "./Facet.vue";
import Layout from "./FilterLayout.vue";

const props = defineProps({
  application: String,
  apiKey: String,
  index: String,
});

const facetsString = ref("categories:20 price_as_number:5");
const filterString = ref("");
const filterVals = ref([]);
const priceRange = ref([-1, -1]);

function onRangeChange(values) {
  priceRange.value = values;

  [min, max] = priceRange.value;

  filterString.value = `price_as_number>=${min} AND price_as_number<=${max} `;
  // Object.entries(newVal)
  //   .flatMap(([key, values]) =>
  //     Array.isArray(values)
  //       ? values.map((value) => `${key}:'${value}'`)
  //       : `${key}:'${values}'`
  //   )
  //   .join(" AND ");

  // console.log(filterString.value);
}

watch(
  filterVals,
  (newVal, oldVal) => {
    // [min, max] = priceRange.value;

    filterString.value =
      `price_as_number>=${min} AND price_as_number<=${max} ` +
      Object.entries(newVal)
        .flatMap(([key, values]) =>
          Array.isArray(values)
            ? values.map((value) => `${key}:'${value}'`)
            : `${key}:'${values}'`
        )
        .join(" AND ");

    console.log(filterVals.value);
  },
  {
    deep: true,
  }
);

onMounted(() => {
  filterVals.value = facetsString.value.split(" ").reduce((acc, key) => {
    [key] = key.split(":");

    acc[key] = [];

    return acc;
  }, {});
});

const mobileFiltersOpen = ref(false);
</script>
