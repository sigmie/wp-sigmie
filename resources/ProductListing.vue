<template>
  <!-- <SigmieSearch
    :debounce-ms="200"
    :facets="props.facets"
    :apiKey="props.apiKey"
    :sort="sortBy"
    :query="''"
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
          class="sgm-mt-3"
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
        <SortMenu :label="state.sort.label" :options="sort.options">
          <template v-slot:item="item">
            <div
              ole="button"
              tabindex="0"
              class="sgm-py-2 sgm-px-3 sgm-cursor-pointer"
              @click.prevent="state.sort = item"
            >
              <span class="sgm-text-black">
                {{ item.name }}
              </span>
            </div>
          </template>
        </SortMenu>
      </template>

      <template v-slot:offers>
        <Button
          v-if="showOffersFilter"
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

      <template v-slot:mobile-sort>
        <MobileSortAccordion
          :label="state.sort.label"
          :options="sort.options"
          v-slot="item"
        >
          <div
            class="sgm-py-2 sgm-cursor-pointer sgm-flex sgm-flex-row sgm-justify-between"
            @click.prevent="state.sort = item"
          >
            <span class="sgm-text-black">
              {{ item.name }}
            </span>

            <RadioButton
              :name="item.value"
              :value="item.value"
              :modelValue="sortBy"
            />
          </div>
        </MobileSortAccordion>
      </template>

      <template v-slot:mobile-filters>
        <Accordion
          :active-index="state.expanded_filter_keys"
          :pt="{
            root: {
              class: 'sgm-flex sgm-flex-col sgm-space-y-4 sgm-px-4 lg:sgm-px-0',
            },
          }"
          :unstyled="true"
          :multiple="true"
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

          <template v-for="(item, key) in filterVals">
            <AccordionTab
              :pt="{
                headeraction: {
                  class:
                    'sgm-flex sgm-flex-row-reverse sgm-items-center sgm-justify-between',
                },
              }"
            >
              <template v-slot:header>
                <FilterLabel
                  :title="facetProps[key].label"
                  :subtitle="filterVals[key].join(', ') ?? null"
                >
                </FilterLabel>
              </template>

            </AccordionTab>
          </template>
        </Accordion>
      </template>

      <template v-slot:mobile-reset-action>
        <Button
          class="sgm-w-[48%] sgm-text-center"
          :label="resetFiltersText"
          @click.prevent="onResetFilters"
        />
      </template>

      <template v-slot:filters>
        <Accordion
          :active-index="state.expanded_filter_keys"
          :pt="{
            root: {
              class: 'sgm-flex sgm-flex-col sgm-space-y-6 sgm-px-4 lg:sgm-px-0',
            },
          }"
          :unstyled="true"
          :multiple="true"
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
          <AccordionTab
            v-for="(item, key) in filterVals"
            :pt="{
              root: { class: '' },
              headeraction: {
                class:
                  'sgm-flex sgm-flex-row-reverse sgm-items-center sgm-justify-between',
              },
            }"
          >
            <template v-slot:header>
              <FilterLabel
                :title="facetProps[key].label"
                :subtitle="filterVals[key].join(', ') ?? null"
              >
              </FilterLabel>
            </template>

            <component
              :v-bind="facetProps[key]"
              :is="facetProps[key].component"
              v-model="filterVals[key]"
            ></component>

            <NumberFacet
              :show-chart="showPriceRangeChart"
              :currency="currencySymbol"
              :label="priceRangeLabel"
              :min="facets.price_as_number?.min"
              :max="facets.price_as_number?.max"
              :range="priceRange"
              @update:range="onRangeChange"
              @range:inited="onRangeInit"
              :histogram="facets.price_as_number?.histogram"
            >
            </NumberFacet>

          </AccordionTab>
        </Accordion>
      </template>
    </Layout>
  </SigmieSearch> -->
</template>

<script setup>
import { ref, onMounted, computed, watch, reactive } from "vue";

import { SigmieSearch } from "@sigmie/vue";

import Button from "primevue/button";
import RadioButton from "primevue/radiobutton";

import XIcon from "./XIcon.vue";
import ChevronUpIcon from "./ChevronUpIcon.vue";
import ChevronDownIcon from "./ChevronDownIcon.vue";

import Accordion from "primevue/accordion";
import AccordionTab from "primevue/accordiontab";

import FilterLabel from "./FilterLabel.vue";
import MobileSortAccordion from "./MobileSortAccordion.vue";
import SortMenu from "./SortMenu.vue";
import NumberFacet from "./NumberFacet.vue";
import Pagination from "./Pagination.vue";
import HorizontalProducts from "./HorizontalProducts.vue";
import ProductHit from "./ProductHit.vue";

import CheckboxFacet from "./CheckboxFacet.vue";
import MobileCheckbox from "./MobileCheckbox.vue";
import SelectbuttonFacet from "./SelectbuttonFacet.vue";
import ColorFacet from "./ColorFacet.vue";

import Layout from "./ProductListingLayout.vue";

const props = defineProps({
  sort: Object,
  sigmie: Object,
  options: Object,
  texts: Object,
  facets: Object,
});

const state = reactive({
  initial_filter_string: null,
  filters: {},
  filterString: null,
  expanded_filter_keys: [],
  currentPage: 1,
  onlyOffers: false,
  sort: {
    name: "",
    value: "_score",
  },
});

const initialPriceRange = ref([null, null]);

const activeFilters = computed(() => {
  return Object.entries(state.filters)
    .filter(([attribute, values]) => values.length > 0)
    .map(([attribute, values]) => values.map((filter) => filter.label));
});

const filtersAreDirty = computed(() => {
  return createFilterString() !== state.initial_filter_string;
});

const onOffersClick = () => {
  state.filters['on_sale'] = {
         label: 'Only offers',
         key: 'is',
         operator: ':',
         value: 'on_sale'
  }
};

function onRemoveActiveFilter(key, value) {
  // if (filterVals.value[key]) {
  //   const index = filterVals.value[key].indexOf(value);
  //   if (index > -1) {
  //     filterVals.value[key].splice(index, 1);
  //   }
  // }
  // if (key === "offers") {
  //   onlyOffers.value = !onlyOffers.value;
  // }
  // sigmie_price_range_label;
  // if (key === "price_range") {
  //   priceRange.value = initialPriceRange.value;
  // }
  // if (key === "reset_filters") {
  //   onResetFilters();
  //   return;
  // }
  // updateFilterString();
}

watch(state.filters, updateFilterString, { deep: true });

function onRangeInit(initialValue) {
  // initialPriceRange.value = initialValue;
  // priceRange.value = initialValue;
}

function onRangeChange(values) {
  // priceRange.value = values;
  // updateFilterString();
}

async function onResetFilters(values) {
  state.filters = createEmptyFilters();
  state.onlyOffers = false;

  // priceRange.value = initialPriceRange.value;
  // updateFilterString();
}

const updateFilterString = () => {
  state.currentPage = 1;
  state.filterString = createFilterString();
};

const createFilterString = () => {
  // filterVals = {
  // color: [
  //     {
  //        label: 'Red'
  //        key: 'color',
  //        operator: ':'
  //        value: 'red'
  //      }
  // ]
  // }
  let pageFilters = Object.entries(state.filters)
    .filter(([attribute, values]) => values.length > 0)
    .map(
      ([attribute, values]) =>
        `(${values
          .map((filter) => `${filter.key}${filter.operator}${filter.value}`)
          .join(" OR ")})`
    )
    .join(" AND ");

  let preselectedFilters = props.sigmie.filters;

  return [pageFilters, preselectedFilters]
    .filter((value) => value.trim() !== "")
    .join(" AND ");
};

const createEmptyFilters = () => {
  let result = props.sigmie.facets
    .split(" ")
    .filter((value) => value.trim() !== "")
    .reduce((acc, key) => {
      [key] = key.split(":");
      acc[key] = [];
      return acc;
    }, {});

  result["on_sale"] = [];

  return result;
};

onMounted(() => {
  // by default sort by relevance
  state.sort = props.sort.default_option;

  state.expanded_filter_keys = Object.entries(props.facets)
    .filter(([key, values]) => values.expanded)
    .map(([key, values]) => values.index);

  state.filters = createEmptyFilters();
  state.initial_filter_string = createFilterString();
});
</script>

<style></style>
