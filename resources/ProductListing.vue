<template>
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
    v-slot="{ hits, facets, total, loading }"
  >
    <Layout
      :loading="loading"
      :hits="hits"
      :title="filtersTitleText"
      :hits-title="productsTitleText"
      :hits-subtitle="productsSubtitleTemplate.replace('%', total)"
      :no-hits-title="noProductsText"
      :no-hits-subtitle="noProductsAdviceText"
      :active-filters="activeFilters"
      :total="total"
    >
      <template v-slot:active-filter="{ filterKey, filterValue }">
        <Button
          outlined
          severity="secondary"
          rounded
          @click="onRemoveActiveFilter(filterKey, filterValue)"
          class="mt-2"
        >
          <div class="sgm-flex sgm-flex-row sgm-items-center sgm-space-x-3">
            <span class="sgm-text-black">
              {{ filterValue }}
            </span>
            <XIcon
              v-if="filterKey !== 'reset_filters'"
              class="sgm-h-4 sgm-w-4"
            ></XIcon>
          </div>
        </Button>
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
        <SortMenu :label="sortByLabel" :options="sortOptions">
          <template v-slot:item="item">
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
          </template>
        </SortMenu>
      </template>

      <template v-slot:mobile-sort>
        <MobileSortAccordion
          :label="sortByLabel"
          :options="sortOptions"
          v-slot="item"
        >
          <div
            class="sgm-py-2 sgm-cursor-pointer sgm-flex sgm-flex-row sgm-justify-between"
            @click.prevent="onSortChange(item.value, item.name)"
          >
            <span class="sgm-text-black">
              {{ item.name }}
            </span>

            <RadioButton
              :name="item.value"
              :value="item.name"
              :modelValue="sortByLabel"
            />
          </div>
        </MobileSortAccordion>
      </template>

      <template v-slot:offers>
        <Button
          v-if="showOffersFilter"
          :class="onlyOffers ? 'sgm-bg-hover' : null"
          outlined
          severity="secondary"
          @click="onOffersClick"
        >
          <span class="sgm-text-black"> {{ offersFilterText }}</span>
        </Button>
      </template>

      <template v-slot:horizontal-one>
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
          <HorizontalProducts
            title="Featured products"
            :hits="hits"
          ></HorizontalProducts>
        </SigmieSearch>
      </template>

      <template v-slot:hit="hit">
        <ProductHit :hit="hit"></ProductHit>
      </template>

      <template v-slot:horizontal-two>
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
          <HorizontalProducts
            title="Featured products"
            :hits="hits"
          ></HorizontalProducts>
        </SigmieSearch>
      </template>

      <template v-slot:no-hits-action>
        <Button :label="resetFiltersText" @click.prevent="onResetFilters" />
      </template>

      <template v-slot:mobile-reset-action>
        <Button
          class="sgm-w-[48%] sgm-text-center"
          :label="resetFiltersText"
          @click.prevent="onResetFilters"
        />
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
          <Accordion
            :pt="{
              root: {
                class:
                  'sgm-flex sgm-flex-col sgm-space-y-6 sgm-px-4 lg:sgm-px-0',
              },
            }"
            :unstyled="true"
            :multiple="true"
            :activeIndex="accordionActiveKeys"
          >
            <template v-slot:collapseicon>
              <ChevronUpIcon
                class="sgm-h-4 sgm-w-4 sgm-text-black"
              ></ChevronUpIcon>
            </template>

            <template v-slot:expandicon>
              <ChevronDownIcon
                class="sgm-h-4 sgm-w-4 sgm-text-black"
              ></ChevronDownIcon>
            </template>
            <template v-for="(index, key) in filterVals">
              <AccordionTab
                :pt="{
                  root: { class: 'sgm-border' },
                  headeraction: {
                    class:
                      'sgm-flex sgm-flex-row-reverse sgm-items-center sgm-justify-between',
                  },
                }"
              >
                <template v-slot:header>
                  <div
                    class="sgm-flex sgm-flex-col sgm-border-b sgm-border-gray-300"
                  >
                    <div
                      class="sgm-text-md xl:sgm-text-sm sgm-font-medium sgm-text-black sgm-no-underline"
                    >
                      <span>
                        {{ filterLabels[key] ?? key }}
                      </span>
                    </div>
                    <div
                      :class="[
                        filterVals[key].length === 0 ? 'sgm-hidden' : '',
                      ]"
                      class="sgm-text-sm sgm-font-medium sgm-text-gray-600 sgm-h-6 lg:sgm-hidden"
                    >
                      <span>
                        {{ filterVals[key].join(", ") ?? "" }}
                      </span>
                    </div>
                  </div>
                </template>

                <Facet
                  v-if="key !== 'categories' && key !== 'price_as_number'"
                  :label="filterLabels[key] ?? key"
                  :facets="facets[key] ?? []"
                  :modelValue="filterVals[key]"
                  @update:model-value="(value) => onTermChange(key, value)"
                ></Facet>

                <MobileFacet
                  v-if="key !== 'categories' && key !== 'price_as_number'"
                  :label="filterLabels[key] ?? key"
                  :facets="facets[key] ?? []"
                  :modelValue="filterVals[key]"
                  @update:model-value="(value) => onTermChange(key, value)"
                ></MobileFacet>
              </AccordionTab>
            </template>
          </Accordion>
        </div>
      </template>
    </Layout>
  </SigmieSearch>
</template>

<script setup>
import { ref, onMounted, computed } from "vue";

import { SigmieSearch } from "@sigmie/vue";

import Button from "primevue/button";
import Accordion from "primevue/accordion";
import AccordionTab from "primevue/accordiontab";
import RadioButton from "primevue/radiobutton";

import XIcon from "./XIcon.vue";
import ChevronUpIcon from "./ChevronUpIcon.vue";
import ChevronDownIcon from "./ChevronDownIcon.vue";

import MobileSortAccordion from "./MobileSortAccordion.vue";
import SortMenu from "./SortMenu.vue";
import PriceSlider from "./PriceSlider.vue";
import Pagination from "./Pagination.vue";
import HorizontalProducts from "./HorizontalProducts.vue";
import ProductHit from "./ProductHit.vue";
import Facet from "./Facet.vue";
import Layout from "./ProductListingLayout.vue";
import MobileFacet from "./MobileFacet.vue";

const props = defineProps({
  application: String,
  apiKey: String,
  index: String,
  facets: String,
  filters: String,
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
  sortByProductSalesLabel: String,
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

function onOffersClick() {
  onlyOffers.value = !onlyOffers.value;

  updateFitlerString();
}

const computedPriceRangeFilterLabel = computed(() => {
  return props.priceRangeFilterLabel
    .replace("%", priceRange.value[0])
    .replace("%", priceRange.value[1]);
});

const activeFilters = computed(() => {
  let result = Object.entries(filterVals.value)
    .filter(([key, values]) => key !== "price_as_number" && values.length > 0)
    .flatMap(([key, values]) => values.map((value) => [key, value]));

  if (onlyOffers.value) {
    result.push(["offers", props.offersFilterText]);
  }

  if (priceRangeIsDirty.value) {
    result.push(["price_range", computedPriceRangeFilterLabel.value]);
  }

  if (result.length > 0) {
    result.push(["reset_filters", props.resetFiltersText]);
  }

  return result;
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

function onRemoveActiveFilter(key, value) {
  if (filterVals.value[key]) {
    const index = filterVals.value[key].indexOf(value);
    if (index > -1) {
      filterVals.value[key].splice(index, 1);
    }
  }

  if (key === "offers") {
    onlyOffers.value = !onlyOffers.value;
  }

  if (key === "price_range") {
    priceRange.value = initialPriceRange.value;
  }

  if (key === "reset_filters") {
    onResetFilters();
    return;
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

  let result = [props.filters, onlyOffersFilter, priceFilter, valueFilter]
    .filter((part) => part !== "")
    .join(" AND ");

  currentPage.value = 1;
  filterString.value = result;
};

const accordionActiveKeys = ref([]);

onMounted(() => {
  accordionActiveKeys.value = Object.keys(Object.keys(filterVals)).map((d) =>
    parseInt(d)
  );

  filterString.value = props.filters;

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
    {
      name: props.sortByProductSalesLabel,
      value: "total_sales:desc",
      current: false,
    },
  ];
});
</script>

<style></style>
