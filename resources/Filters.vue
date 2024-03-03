<template>
  <div class="">
    <div class="sgm-mx-auto sgm-max-w-7xl">
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
        <Layout
          :title="filtersTitleText"
          :hits-title="productsTitleText"
          :hits-subtitle="productsSubtitleTemplate.replace('%', total)"
          :total="total"
        >
          <template v-slot:reset>
            <a
              v-if="filtersAreDirty"
              @click.prevent="onResetFilters"
              class="sgm-hover:bg-zinc-50 sgm-text-primary-color sgm-cursor-pointer sgm-transition-colors sgm-flex sgm-flex-row sgm-space-x-4 sgm-items-center sgm-px-3"
            >
              {{ resetFiltersText }}
            </a>
          </template>

          <template v-slot:active-filters>
            <div
              class="sgm-flex sgm-flex-row sgm-py-6 sgm-space-x-4 sgm-mt-1 sgm-h-20"
            >
              <Button
                outlined
                severity="secondary"
                rounded
                v-if="onlyOffers"
                @click="onOffersClick"
                class="sgm-cursor-pointer"
              >
                <div
                  class="sgm-flex sgm-flex-row sgm-items-center sgm-space-x-3"
                >
                  <span class="sgm-text-black"> {{ offersFilterText }}</span>
                  <XIcon class="sgm-h-4 sgm-w-4"></XIcon>
                </div>
              </Button>
              <Button
                outlined
                severity="secondary"
                rounded
                @click="onRemoveActiveFilter(activeFilterkey, activeFilter)"
                class="sgm-cursor-pointer"
                v-for="[activeFilterkey, activeFilter] in activeFilters"
              >
                <div
                  class="sgm-flex sgm-flex-row sgm-items-center sgm-space-x-3"
                >
                  <span class="sgm-text-black">
                    {{ activeFilter }}
                  </span>
                  <XIcon class="sgm-h-4 sgm-w-4"></XIcon>
                </div>
              </Button>
              <Button
                outlined
                severity="secondary"
                rounded
                v-if="priceRangeIsDirty"
                @click="onResetRange"
                class="sgm-cursor-pointer"
              >
                <div
                  class="sgm-flex sgm-flex-row sgm-items-center sgm-space-x-3"
                >
                  <span class="sgm-text-black">{{
                    priceRangeFilterLabel
                      .replace("%", priceRange[0])
                      .replace("%", priceRange[1])
                  }}</span>
                  <XIcon class="sgm-h-3 sgm-w-3"></XIcon>
                </div>
              </Button>
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
            <div class="sgm-flex sgm-flex-row sgm-items-center sgm-space-x-3">
              <Menu
                as="div"
                class="sgm-relative sgm-inline-block sgm-text-left sgm-rounded-full sgm-py-1 sgm-border sgm-border-gray-950"
              >
                <div>
                  <MenuButton
                    as="div"
                    class="sgm-group sgm-inline-flex sgm-justify-center sgm-text-sm sgm-text-gray-700 sgm-hover:text-gray-900"
                  >
                    <Button severity="secondary" :label="sortByLabel" outlined>
                      <span class="sgm-text-black">{{ sortByLabel }}</span>

                      <ChevronDownIcon
                        class="sgm--mr-1 sgm-ml-1 sgm-h-4 sgm-w-4 sgm-flex-shrink-0 sgm-text-secondary-color sgm-group-hover:text-gray-500"
                        aria-hidden="true"
                      />
                    </Button>
                  </MenuButton>
                </div>

                <transition
                  enter-active-class="sgm-transition ease-out sgm-duration-100"
                  enter-from-class="sgm-transform sgm-opacity-0 sgm-scale-95"
                  enter-to-class="sgm-transform sgm-opacity-100 sgm-scale-100"
                  leave-active-class="sgm-transition ease-in sgm-duration-75"
                  leave-from-class="sgm-transform sgm-opacity-100 sgm-scale-100"
                  leave-to-class="sgm-transform sgm-opacity-0 sgm-scale-95"
                >
                  <MenuItems
                    class="sgm-absolute sgm-left-0 sgm-z-10 sgm-mt-2 sgm-w-40 sgm-origin-top-right sgm-rounded-md sgm-bg-white sgm-shadow-2xl sgm-ring-1 sgm-ring-black sgm-ring-opacity-5 sgm-focus:outline-none"
                  >
                    <PrimeMenu :model="sortOptions">
                      <template #item="{ item, props }">
                        <MenuItem v-slot="{ active }">
                          <div
                            ole="button"
                            tabindex="0"
                            class="sgm-py-2 sgm-px-3 sgm-cursor-pointer"
                            @click.prevent="onSortChange(item.value, item.name)"
                          >
                            <span class="sgm-text-black">
                              {{ item.name }}
                            </span>
                          </div>
                        </MenuItem>
                      </template>
                    </PrimeMenu>
                  </MenuItems>
                </transition>
              </Menu>

              <div
                v-if="showOffersFilter"
                :class="onlyOffers ? 'sgm-bg-hover' : null"
              >
                <Button outlined severity="secondary" @click="onOffersClick">
                  <span class="sgm-text-black"> {{ offersFilterText }}</span>
                </Button>
              </div>
            </div>
          </template>

          <template v-slot:featured>
            <SigmieSearch
              :debounce-ms="200"
              :apiKey="props.apiKey"
              :sort="'_score'"
              :query="''"
              :perPage="20"
              :filters="'is:is_featured'"
              :facets="props.facets"
              :search="props.index"
              :applicationId="props.application"
              v-slot="{ hits }"
            >
              <VerticalProducts
                id="featured-vertical-scroller"
                title="Featured products"
                :hits="hits"
              ></VerticalProducts>
            </SigmieSearch>
          </template>

          <template v-slot:hits>
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
                  <FilterHit :hit="hit"></FilterHit>

                  <template v-if="index === 2">
                    <div class="sgm-col-span-3">
                      <SigmieSearch
                        :debounce-ms="200"
                        :apiKey="props.apiKey"
                        :sort="'_score'"
                        :query="''"
                        :perPage="20"
                        :filters="'is:is_featured'"
                        :facets="props.facets"
                        :search="props.index"
                        :applicationId="props.application"
                        v-slot="{ hits }"
                      >
                        <VerticalProducts
                          id="offers-vertical-scroller"
                          title="Featured products"
                          :hits="hits"
                        ></VerticalProducts>
                      </SigmieSearch>
                    </div>
                  </template>
                </template>
              </div>
            </div>
          </template>

          <template v-slot:no-results>
            <svg
              class="sgm-h-10 sgm-w-10"
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
            <h3
              class="sgm-mt-2 sgm-text-lg sgm-font-semibold sgm-text-gray-900"
            >
              {{ noProductsText }}
            </h3>
            <p class="sgm-mt-1 sgm-text-sm sgm-text-gray-500">
              {{ noProductsAdviceText }}
            </p>
            <div class="sgm-mt-6">
              <Button
                :label="resetFiltersText"
                @click.prevent="onResetFilters"
                type="button"
                class="sgm-inline-flex sgm-items-center sgm-rounded-md sgm-bg-indigo-600 sgm-px-3 sgm-py-2 sgm-text-sm sgm-font-semibold sgm-text-white sgm-shadow-sm sgm-hover:bg-indigo-500 sgm-focus-visible:outline sgm-focus-visible:outline-2 sgm-focus-visible:outline-offset-2 sgm-focus-visible:outline-indigo-600"
              >
              </Button>
            </div>
          </template>

          <template v-slot:filters>
            <div class="sgm-flex sgm-flex-col sgm-space-y-6">
              <PriceSlider
                :show-chart="showPriceRangeChart"
                :currency="currencySymbol"
                :label="priceRangeLabel"
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
  </div>
</template>

<script setup>
import VerticalProducts from "./VerticalProducts.vue";
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
import Button from "primevue/button";
import PrimeMenu from "primevue/menu";

const props = defineProps({
  application: String,
  apiKey: String,
  index: String,
  facets: String,
  showPriceRangeChart: Boolean,
  showCategoriesFilter: Boolean,
  showOffersFilter: Boolean,
  perPage: Number,
  currencySymbol: String,
  productsTitleText: String,
  filtersTitleText: String,
  resetFiltersText: String,
  priceRangeLabel: String,
  priceRangeFilterLabel: String,
  offersFilterText: String,
  noProductsText: String,
  noProductsAdviceText: String,
  sortByRelevanceLabel: String,
  sortByPriceDescLabel: String,
  sortByPriceAscLabel: String,
  sortByMostRecentLabel: String,
  sortByRatingLabel: String,
  productsSubtitleTemplate: String,
});

const currentPage = ref(1);
const sortBy = ref("_score");
const sortByLabel = ref("");
const sortOptions = ref([]);

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

  sortByLabel.value = props.sortByRelevanceLabel;
  sortOptions.value = [
    { name: props.sortByRelevanceLabel, value: "_score", current: false },
    {
      name: props.sortByPriceDescLabel,
      value: "price_as_number:desc",
      current: false,
    },
    {
      name: props.sortByPriceAscLabel,
      value: "price_as_number:asc",
      current: false,
    },
    {
      name: props.sortByMostRecentLabel,
      value: "date_created:desc",
      current: false,
    },
    {
      name: props.sortByRatingLabel,
      value: "average_rating:desc",
      current: false,
    },
  ];
});
</script>
