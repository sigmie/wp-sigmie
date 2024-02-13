<template>
  <div class="sigmie-filters">
    <SigmieSearch
      :debounce-ms="200"
      :facets="props.facets"
      :apiKey="props.apiKey"
      :sort="sortBy"
      :query="query"
      :page="currentPage"
      :perPage="perPage"
      :filters="filterString"
      :search="props.index"
      :applicationId="props.application"
      v-slot="{ hits, facets, total, loading, processing_time_ms }"
    >
      <Layout title="Filters" hits-title="WooCommerce Products" :total="total">
        <template v-slot:reset>
          <button
            v-if="filtersAreDirty"
            @click.prevent="onResetFilters"
            class="hover:bg-zinc-50 cursor-pointer transition-colors flex flex-row space-x-4 items-center px-3 text-red-800"
          >
            Reset Filters
          </button>
        </template>

        <template v-slot:active-filters>
          <div class="flex flex-row py-6 space-x-4 mt-1">
            <button
              v-if="priceRangeIsDirty"
              @click="onResetRange"
              class="hover:bg-zinc-50 cursor-pointer transition-colors flex flex-row space-x-4 items-center border border-black rounded-full px-3 py-1 text-black"
            >
              <span
                >Price Range: from {{ priceRange[0] }} to
                {{ priceRange[1] }}</span
              >
              <span>
                <XIcon class="h-4 w-4"></XIcon>
              </span>
            </button>
            <button
              @click="onRemoveActiveFilter(activeFilterkey, activeFilter)"
              class="hover:bg-zinc-50 cursor-pointer transition-colors flex flex-row space-x-4 items-center border border-black rounded-full px-3 py-1 text-black"
              v-for="[activeFilterkey, activeFilter] in activeFilters"
            >
              <span>
                {{ activeFilter }}
              </span>
              <span>
                <XIcon class="h-4 w-4"></XIcon>
              </span>
            </button>
          </div>
        </template>

        <template v-slot:pagination>
          <Pagination
            :currentPage="currentPage"
            @changePage="(page) => (currentPage = page)"
            :per-page="perPage"
            :total="total"
          ></Pagination>
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

            <Chip @click="onOffersClick" :class="onlyOffers ? '' : ''" class="">
              Offers
            </Chip>
          </div>
        </template>

        <template v-slot:hits>
          <div class="relative w-full h-full">
            <Curtain
              :is-open="loading"
              class="absolute left-0 right-0"
            ></Curtain>
            <div class="grid grid-cols-3 gap-8">
              <FilterHit v-for="hit in hits" :hit="hit"></FilterHit>
            </div>
          </div>
        </template>

        <template v-slot:no-results>
          <svg
            class="h-10 w-10"
            viewBox="0 0 25 24"
            fill="none"
            xmlns="http://www.w3.org/2000/svg"
          >
            <path
              opacity="0.4"
              fill-rule="evenodd"
              clip-rule="evenodd"
              d="M5.42237 2.59573C5.12937 2.30273 4.65437 2.30273 4.36137 2.59573C4.06837 2.88873 4.06837 3.36373 4.36137 3.65673L5.00037 4.29473C4.24437 4.87873 3.77637 5.79373 3.77637 6.79373V8.82373C3.77637 9.93173 4.22637 11.0237 5.03337 11.8417L9.34937 15.6737C9.54237 15.8667 9.64837 16.1237 9.64837 16.3987V19.5977C9.64837 20.2737 9.98337 20.9037 10.5444 21.2807C10.8824 21.5087 11.2754 21.6247 11.6704 21.6247C11.9244 21.6247 12.1804 21.5767 12.4224 21.4777L14.2814 20.7367C15.0524 20.4357 15.5704 19.6797 15.5704 18.8547V16.8847C15.5704 16.5887 15.6884 16.3187 15.9174 16.1107L16.3694 15.6637L17.6624 16.9567C17.8094 17.1037 18.0014 17.1767 18.1934 17.1767C18.3844 17.1767 18.5764 17.1037 18.7234 16.9567C19.0164 16.6637 19.0164 16.1897 18.7234 15.8967L5.42237 2.59573Z"
              fill="currentColor"
            />
            <path
              fill-rule="evenodd"
              clip-rule="evenodd"
              d="M19.0307 3.62793H10.5447C10.3417 3.62793 10.1587 3.75093 10.0817 3.93893C10.0057 4.12593 10.0497 4.34193 10.1937 4.48393L18.5277 12.6939C18.6247 12.7899 18.7517 12.8379 18.8787 12.8379C18.9977 12.8379 19.1167 12.7949 19.2127 12.7099L20.7937 11.2909C21.6777 10.4849 22.1847 9.33593 22.1847 8.13793V6.79193C22.1847 5.04693 20.7697 3.62793 19.0307 3.62793"
              fill="currentColor"
            />
          </svg>
          <h3 class="mt-2 text-sm font-semibold text-gray-900">
            No products were found
          </h3>
          <p class="mt-1 text-sm text-gray-500">
            Try removing the last filter.
          </p>
          <div class="mt-6">
            <button
              @click.prevent="onResetFilters"
              type="button"
              class="inline-flex items-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
            >
              Clear all filters
            </button>
          </div>
        </template>

        <template v-slot:filters>
          <div class="px-3 flex flex-col space-y-5">
            <PriceSlider
              :min="0"
              :max="facets.price_as_number?.max"
              :range="priceRange"
              @update:range="onRangeChange"
              @range:inited="onRangeInit"
              :histogram="facets.price_as_number?.histogram"
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
  </div>
</template>

<script setup>
import { ref, onMounted, computed, nextTick } from "vue";
import XIcon from "./XIcon.vue";
import PriceSlider from "./PriceSlider.vue";
import Pagination from "./Pagination.vue";
import Curtain from "./Curtain.vue";
import { Menu, MenuButton, MenuItem, MenuItems } from "@headlessui/vue";
import { ChevronDownIcon } from "@heroicons/vue/20/solid";
import { SigmieSearch } from "@sigmie/vue";
import FilterHit from "./FilterHit.vue";
import Facet from "./Facet.vue";
import Layout from "./FilterLayout.vue";
import Chip from "primevue/chip";

const props = defineProps({
  application: String,
  apiKey: String,
  index: String,
  facets: String,
});

const currentPage = ref(1);
const perPage = ref(8);
const sortBy = ref("_score");
const sortByLabel = ref("Relevance");
const sortOptions = ref([
  { name: "Relevance", value: "_score", current: false },
  { name: "Price High to Low", value: "price_as_number:desc", current: false },
  { name: "Price Low to High", value: "price_as_number:asc", current: false },
  { name: "Most Recent", value: "date_created:desc", current: false },
  { name: "Rating", value: "average_rating:desc", current: false },
]);

const filterLabels = {
  categories: "Categories",
  price_as_number: "Price",
  pa_color: "Color",
};

const onlyOffers = ref(false);
const activeFilters = computed(() => {
  return Object.entries(filterVals.value)
    .filter(([key, values]) => key !== "price_as_number" && values.length > 0)
    .flatMap(([key, values]) => values.map((value) => [key, value]));
});

const filtersAreDirty = computed(() => {
  return (
    onlyOffers.value ||
    Object.values(filterVals.value).some((values) => values.length > 0) ||
    priceRangeIsDirty.value
  );
});

const priceRangeIsDirty = computed(() => {
  return (
    priceRange.value[0] !== initialPriceRange.value[0] ||
    priceRange.value[1] !== initialPriceRange.value[1]
  );
});

const filterString = ref("");
const filterVals = ref([]);
const priceRange = ref([null, null]);
const initialPriceRange = ref([null, null]);

function onResetRange() {
  priceRange.value = initialPriceRange.value;

  updateFitlerString();
}

function onOffersClick() {
  onlyOffers.value = !onlyOffers.value;

  updateFitlerString();
}

function onRemoveActiveFilter(key, value) {
  if (filterVals.value[key]) {
    const index = filterVals.value[key].indexOf(value);
    if (index > -1) {
      filterVals.value[key].splice(index, 1);
    }
  }

  updateFitlerString();
}

function onTermChange(key, values) {
  filterVals.value[key] = values;

  updateFitlerString();
}

function onRangeInit(initialValue) {
  initialPriceRange.value = initialValue;
  priceRange.value = initialValue;
}

function onRangeChange(values) {
  priceRange.value = values;

  updateFitlerString();
}

async function onResetFilters(values) {
  filterVals.value = props.facets.split(" ").reduce((acc, key) => {
    [key] = key.split(":");
    acc[key] = [];
    return acc;
  }, {});

  onlyOffers.value = false;
  priceRange.value = initialPriceRange.value;

  // await nextTick();

  updateFitlerString();
}

function onSortChange(value, label) {
  sortBy.value = value;
  sortByLabel.value = label;
}

const updateFitlerString = () => {
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

  let onlyOffersFilter = onlyOffers.value ? "is:on_sale" : "";

  let result = [onlyOffersFilter, priceFilter, valueFilter]
    .filter((part) => part !== "")
    .join(" AND ");

  currentPage.value = 1;
  filterString.value = result;
};

onMounted(() => {
  filterVals.value = props.facets.split(" ").reduce((acc, key) => {
    [key] = key.split(":");
    acc[key] = [];
    return acc;
  }, {});
});
</script>

<style lang="scss">
@import "primevue/resources/themes/aura-light-amber/theme.css";
</style>
