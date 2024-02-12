<template>
  <SigmieSearch
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

          <button
            @click="onOffersClick"
            :class="onlyOffers ? 'bg-gray-100' : ''"
            class="hover:bg-zinc-50 cursor-pointer transition-colors flex flex-row space-x-4 items-center border border-black rounded-full px-3 py-1 text-black"
          >
            Offers
          </button>
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
            :min="0"
            :max="facets.price_as_number?.max"
            :range="priceRange"
            @update:range="onRangeChange"
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
</template>

<script setup>
import { ref, onMounted, watch, computed } from "vue";
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
import debounce from "debounce";

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
    Object.values(filterVals.value).some((values) => values.length > 0)
    // ||
    // priceRange[0] !== null ||
    // priceRange[1] !== null
  );
});

const filterString = ref("");
const filterVals = ref([]);
const priceRange = ref([null, null]);

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

function onRangeChange(values) {
  const oldValue = priceRange.value;

  priceRange.value = values;

  if (oldValue[0] !== null || oldValue[1] !== null) {
    updateFitlerString();
  }
}

function onResetFilters(values) {
  filterVals.value = props.facets.split(" ").reduce((acc, key) => {
    [key] = key.split(":");
    acc[key] = [];
    return acc;
  }, {});

  onlyOffers.value = false;

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

  let onlyOffersFilter = onlyOffers.value ? "is:on_sale" : "";

  let result = [onlyOffersFilter, priceFilter, valueFilter]
    .filter((part) => part !== "")
    .join(" AND ");

  currentPage.value = 1;
  filterString.value = result;
}, 100);

onMounted(() => {
  filterVals.value = props.facets.split(" ").reduce((acc, key) => {
    [key] = key.split(":");
    acc[key] = [];
    return acc;
  }, {});
});
</script>
