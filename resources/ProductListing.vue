<template>
  <SigmieSearch
    :debounce-ms="200"
    :facets="props.sigmie.facets"
    :api-key="props.sigmie.api_key"
    :sort="state.sort.value"
    :query="''"
    :page="state.currentPage"
    :per-page="props.options.per_page"
    :filters="state.filter_string"
    :search="props.sigmie.index"
    :application-id="props.sigmie.application"
    v-slot="{ hits, facets, total, loading }"
  >
    <Layout
      :loading="loading"
      :hits="hits"
      :title="props.texts.products_title_text"
      :hits-title="props.texts.filters_title_text"
      :hits-subtitle="
        props.texts.products_subtitle_template.replace('%', total)
      "
      :no-hits-title="props.texts.no_products_text"
      :no-hits-subtitle="props.texts.no_products_advice_text"
      :active-filters="activeFilters"
      :total="total"
    >
      <template v-slot:active-filter="{ id, label }">
        <Button
          outlined
          severity="secondary"
          rounded
          @click="onRemoveActiveFilter(id)"
          class="sgm-mt-3"
        >
          <div class="sgm-flex sgm-flex-row sgm-items-center sgm-space-x-3">
            <span class="sgm-text-black">
              {{ label }}
            </span>
            <XIcon class="sgm-h-4 sgm-w-4"></XIcon>
          </div>
        </Button>
      </template>

      <template v-slot:pagination>
        <Pagination
          :currentPage="state.currentPage"
          @changePage="(page) => (state.currentPage = page)"
          :per-page="props.options.per_page"
          :total="total"
        ></Pagination>
      </template>

      <template v-slot:sort>
        <SortMenu :label="state.sort.label" :options="props.sort.options">
          <template v-slot:item="item">
            <div
              ole="button"
              tabindex="0"
              class="sgm-py-2 sgm-px-3 sgm-cursor-pointer"
              @click.prevent="state.sort = item"
            >
              <span class="sgm-text-black">
                {{ item.label }}
              </span>
            </div>
          </template>
        </SortMenu>
      </template>

      <template v-slot:offers>
        <Button
          v-if="props.options.show_offers_filter"
          outlined
          severity="secondary"
          @click="onOffersClick"
        >
          <span class="sgm-text-black">
            {{ props.options.offers_filter_text }}</span
          >
        </Button>
      </template>

      <template v-slot:horizontal-one>
        <SigmieSearch
          :debounce-ms="200"
          :api-key="props.sigmie.api_key"
          :sort="'_score'"
          :query="''"
          :per-page="10"
          :filters="'is:is_featured'"
          :facets="props.sigmie.facets"
          :search="props.sigmie.index"
          :application-id="props.sigmie.application"
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
          :api-key="props.sigmie.api_key"
          :sort="'_score'"
          :query="''"
          :per-page="10"
          :filters="'is:is_featured'"
          :facets="props.sigmie.facets"
          :search="props.sigmie.index"
          :application-id="props.sigmie.application"
          v-slot="{ hits }"
        >
          <HorizontalProducts
            title="Featured products"
            :hits="hits"
          ></HorizontalProducts>
        </SigmieSearch>
      </template>

      <template v-slot:no-hits-action>
        <Button
          :label="props.texts.reset_filters_text"
          @click.prevent="onResetFilters"
        />
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
              {{ item.label }}
            </span>

            <RadioButton
              :name="item.value"
              :value="item"
              :modelValue="state.sort"
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

          <template v-for="(item, name) in props.facets">
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
                  :title="item.label"
                  :subtitle="
                    state.filters[name].map((item) => item.label).join(', ')
                  "
                >
                </FilterLabel>
              </template>

              <component
                v-bind="item"
                :is="item.component"
                v-model="state.filters[name]"
                :facets="facets[name]"
              ></component>
            </AccordionTab>
          </template>
        </Accordion>
      </template>

      <template v-slot:mobile-reset-action>
        <Button
          class="sgm-w-[48%] sgm-text-center"
          :label="props.texts.reset_filters_text"
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
            v-for="(item, name) in existingFacets(facets)"
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
                :title="item.label"
                :subtitle="
                  state.filters[name].map((item) => item.label).join(', ')
                "
              >
              </FilterLabel>
            </template>

            <component
              v-bind="item"
              :is="item.component"
              v-model="state.filters[name]"
              :facets="facets[name]"
            ></component>
          </AccordionTab>
        </Accordion>
      </template>
    </Layout>
  </SigmieSearch>
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
import Pagination from "./Pagination.vue";
import HorizontalProducts from "./HorizontalProducts.vue";
import ProductHit from "./ProductHit.vue";

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
  filter_string: "",
  expanded_filter_keys: [],
  currentPage: 1,
  onlyOffers: false,
  sort: {
    name: "",
    value: "_score",
  },
});

const existingFacets = (facets) => {
  const result = Object.keys(props.facets).reduce((acc, facet) => {
    if (facets.hasOwnProperty(facet)) {
      acc[facet] = props.facets[facet];
    }
    return acc;
  }, {});
  return result;
};

const activeFilters = computed(() => {
  return Object.entries(state.filters)
    .filter(([attribute, values]) => values.length > 0)
    .flatMap(([attribute, values]) =>
      values.map((filter) => [filter.id, filter.label])
    );
});

const onOffersClick = () => {
  state.filters["on_sale"] = [
    {
      id: "on-sale",
      label: "Only offers",
      key: "on_sale",
      string: "is:'on_sale'",
    },
  ];
};

function onRemoveActiveFilter(id) {
  Object.keys(state.filters).forEach((filterKey) => {
    const index = state.filters[filterKey].findIndex(
      (filter) => filter.id === id
    );
    if (index > -1) {
      state.filters[filterKey].splice(index, 1);
    }
  });
}

watch(
  () => state.filters,
  () => updateFilterString(),
  { deep: true }
);

async function onResetFilters(values) {
  state.filters = createEmptyFilters();
  state.onlyOffers = false;
}

const updateFilterString = () => {
  state.currentPage = 1;
  state.filter_string = createFilterString();
};

const createFilterString = () => {
  // filterVals = {
  // color: [
  //     {
  // .      id: 'color-Red'
  //        label: 'Red'
  //        string: 'color:"red"'
  //      }
  // ]
  // }
  let pageFilters = Object.entries(state.filters)
    .filter(([attribute, values]) => values.length > 0)
    .map(
      ([attribute, values]) =>
        `(${values
          .map((filter) => filter.string)
          .join(` ${props.facets[attribute].operator} `)})`
    )
    .join(" AND ");

  let preselectedFilters = props.sigmie.filters;

  let result = [pageFilters, preselectedFilters]
    .filter((value) => value.trim() !== "")
    .join(" AND ");

  console.log(result);

  return result;
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
