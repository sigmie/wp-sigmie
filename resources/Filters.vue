<template>
  <SigmieSearch
    :facets="props.facets"
    :apiKey="props.apiKey"
    :sort="sortBy"
    :query="query"
    :perPage="200"
    :filters="filterString"
    :search="props.index"
    :applicationId="props.application"
    v-slot="{ hits, facets, total, loading, processing_time_ms }"
  >
    <Layout
      title="Filters"
      hits-title="WooCommerce Products"
      :total="total"
      :active-filters="activeFilters"
    >
      <template v-slot:pagination>
        <div
          class="flex items-center justify-between bg-white px-4 py-3 sm:px-6"
        >
          <div
            class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between"
          >
            <div>
              <nav
                class="isolate inline-flex -space-x-px rounded-md shadow-sm"
                aria-label="Pagination"
              >
                <a
                  href="#"
                  class="relative inline-flex items-center rounded-l-md px-2 py-2 text-gray-400 hover:bg-gray-50 focus:z-20 focus:outline-offset-0"
                >
                  <span class="sr-only">Previous</span>
                  <svg
                    class="h-5 w-5"
                    viewBox="0 0 20 20"
                    fill="currentColor"
                    aria-hidden="true"
                  >
                    <path
                      fill-rule="evenodd"
                      d="M12.79 5.23a.75.75 0 01-.02 1.06L8.832 10l3.938 3.71a.75.75 0 11-1.04 1.08l-4.5-4.25a.75.75 0 010-1.08l4.5-4.25a.75.75 0 011.06.02z"
                      clip-rule="evenodd"
                    />
                  </svg>
                </a>
                <a
                  href="#"
                  aria-current="page"
                  class="relative inline-flex items-center px-2 py-2 text-sm text-gray-900 hover:bg-gray-50 focus:z-20 focus:outline-offset-0"
                  >1</a
                >
                <a
                  href="#"
                  aria-current="page"
                  class="relative inline-flex items-center px-2 py-2 text-sm text-gray-900 hover:bg-gray-50 focus:z-20 focus:outline-offset-0"
                  >2</a
                >
                <span
                  class="relative inline-flex items-center px-2 py-2 text-sm text-gray-700 focus:outline-offset-0"
                  >...</span
                >
                <a
                  href="#"
                  class="relative inline-flex items-center px-2 py-2 text-sm text-gray-900 hover:bg-gray-50 focus:z-20 focus:outline-offset-0"
                  >12</a
                >
                <a
                  href="#"
                  class="relative inline-flex items-center rounded-r-md px-2 py-2 text-gray-400 hover:bg-gray-50 focus:z-20 focus:outline-offset-0"
                >
                  <span class="sr-only">Next</span>
                  <svg
                    class="h-5 w-5"
                    viewBox="0 0 20 20"
                    fill="currentColor"
                    aria-hidden="true"
                  >
                    <path
                      fill-rule="evenodd"
                      d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z"
                      clip-rule="evenodd"
                    />
                  </svg>
                </a>
              </nav>
            </div>
          </div>
        </div>
      </template>

      <template v-slot:sort>
        <div class="flex flex-row items-center space-x-3">
          <Menu
            as="div"
            class="relative inline-block text-left rounded-full px-3 py-1 border border-gray-950"
          >
            <div>
              <MenuButton
                class="group inline-flex justify-center text-sm font-medium text-gray-700 hover:text-gray-900"
              >
                {{ sortByLabel }}

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
                  <MenuItem
                    :key="sortOptionIdx"
                    v-for="(sortOption, sortOptionIdx) in sortOptions"
                    v-slot="{ active }"
                  >
                    <button
                      :class="[
                        true ? 'font-medium text-gray-900' : 'text-gray-500',
                        active ? 'bg-gray-100' : '',
                        'block px-4 py-2 text-sm w-full text-left',
                      ]"
                      @click="onSortChange(sortOption.value, sortOption.name)"
                    >
                      {{ sortOption.name }}
                    </button>
                  </MenuItem>
                </div>
              </MenuItems>
            </transition>
          </Menu>

          <div
            class="hover:bg-zinc-50 cursor-pointer transition-colors flex flex-row space-x-4 items-center border border-black rounded-full px-3 py-1 text-black"
          >
            Offers
          </div>
        </div>
      </template>

      <template v-slot:hits>
        <div class="relative w-full h-full">
          <Curtain :is-open="loading" class="absolute left-0 right-0"></Curtain>
          <div class="grid grid-cols-3 gap-8">
            <FilterHit v-for="hit in hits" :hit="hit"></FilterHit>
          </div>
        </div>
      </template>

      <template v-slot:filters>
        <div class="px-3 flex flex-col space-y-5">
          <PriceSlider
            @rangeChanged="onRangeChange"
            :data="facets.price_as_number"
          ></PriceSlider>
          <template v-for="(index, key) in filterVals">
            <Facet
              v-if="key !== 'categories' && key !== 'price_as_number'"
              :label="filterLabels[key] ?? key"
              :facets="facets[key] ?? []"
              :modelValue="filterVals[key]"
              @update:model-value="(value) => onTermChange(key, value)"
            ></Facet>
          </template>
        </div>
      </template>
    </Layout>
  </SigmieSearch>
</template>

<script setup>
import { ref, onMounted, watch, computed } from "vue";
import PriceSlider from "./PriceSlider.vue";
import Curtain from "./Curtain.vue";
import { Menu, MenuButton, MenuItem, MenuItems } from "@headlessui/vue";
import { ChevronDownIcon } from "@heroicons/vue/20/solid";
import { SigmieSearch } from "@sigmie/vue";
import FilterHit from "./FilterHit.vue";
import Facet from "./Facet.vue";
import Layout from "./FilterLayout.vue";
import debounce from "debounce";

const props = defineProps({
  application: String,
  apiKey: String,
  index: String,
  facets: String,
});

const sortBy = ref("_score");
const sortByLabel = ref("Relevance");
const sortOptions = ref([
  { name: "Relevance", value: "_score", current: false },
  { name: "Price High to Low", value: "price_as_number:desc", current: false },
  { name: "Price Low to High", value: "price_as_number:asc", current: false },
  { name: "Most Recent", value: "titles:desc", current: false },
  { name: "Rating", value: "titles:desc", current: false },
]);

const filterLabels = {
  categories: "Categories",
  price_as_number: "Price",
  pa_color: "Color",
};

const activeFilters = computed(() => {
  return Object.entries(filterVals.value)
    .filter(([key, values]) => key !== "price_as_number" && values.length > 0)
    .flatMap(([key, values]) => values);
});

const filterString = ref("");
const filterVals = ref([]);
const priceRange = ref([-1, -1]);

function onTermChange(key, values) {
  filterVals.value[key] = values;

  updateFitlerString();
}

function onRangeChange(values) {
  priceRange.value = values;

  updateFitlerString();
}

function onSortChange(value, label) {
  sortBy.value = value;
  sortByLabel.value = label;
}

const updateFitlerString = debounce(() => {
  let priceFilter = "";

  const [min, max] = priceRange.value;

  if (min !== -1 && max !== -1) {
    priceFilter = `price_as_number>=${min} AND price_as_number<=${max}`;
  }

  let valueFilter = Object.entries(filterVals.value)
    .filter(([key, values]) => key !== "price_as_number" && values.length > 0)
    .map(
      ([key, values]) =>
        `(${key}:[${values.map((value) => `'${value}'`).join(",")}])`
    )
    .join(" AND ");

  let result = [priceFilter, valueFilter]
    .filter((part) => part !== "")
    .join(" AND ");

  filterString.value = result;
}, 100);

onMounted(() => {
  filterVals.value = props.facets.split(" ").reduce((acc, key) => {
    [key] = key.split(":");
    acc[key] = [];
    return acc;
  }, {});

  console.log(filterVals);
});
</script>
