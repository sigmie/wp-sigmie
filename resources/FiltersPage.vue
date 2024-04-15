<template>
  <form class="sgm-max-w-2xl">
    <div>
      <Tabs v-model="selectedTab" :tabs="tabs"></Tabs>
    </div>
    <div class="sgm-space-y-20 sgm-divide-y">
      <template v-for="tab in settings">
        <div
          v-if="tab.key === selectedTab"
          class="sgm-flex sgm-flex-row sgm-justify-between"
        >
          <div>
            <h2
              class="sgm-text-base sgm-font-semibold sgm-leading-7 sgm-text-gray-900"
            >
              {{ tab.title }}
            </h2>
            <p class="sgm-mt-1 sgm-text-sm sgm-leading-6 sgm-text-gray-600">
              {{ tab.subtitle }}
            </p>
          </div>

          <div class="sgm-grid sgm-grid-cols-1 sgm-gap-x-6 sgm-gap-y-3">
            <div v-for="field in tab.fields" class="sgm-max-w-xs">
              <div class="sgm-mt-2">
                <div class="sgm-flex sgm-flex-col sgm-gap-2">
                  <label
                    class="sgm-block sgm-text-sm sgm-font-medium sgm-leading-6 sgm-text-gray-900"
                    for="sigmie_theme"
                    >{{ field.label }}</label
                  >
                  <component
                    :is="field.type"
                    v-bind="field.props"
                    v-model="state[field.name]"
                  />
                  <span class="sgm-text-sm">{{ field.info }}</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </template>

      <div
        class="sgm-flex sgm-flex-row sgm-items-center sgm-justify-end sgm-w-full"
      >
        <Button
          size="small"
          :loading="loading"
          label="Save Settings"
          @click="saveSettings(state)"
        >
        </Button>
      </div>
    </div>
  </form>
</template>

<script setup>
import { saveSettings, loading } from "./saveSettings.js";
import Tabs from "./Tabs.vue";

const { reactive, onMounted, toRefs, onBeforeMount } = Vue;
const Dropdown = primevue.dropdown;

const { ref } = Vue;

const InputNumber = primevue.inputnumber;
const InputText = primevue.inputtext;
const RadioButton = primevue.radiobutton;
const SelectButton = primevue.selectbutton;
const InlineMessage = primevue.inlinemessage;
const Button = primevue.button;

const tabs = ref([]);

const props = defineProps([
  "theme",
  "products_per_page",
  "filters_title_text",
  "products_title_text",
  "products_subtitle_template",

  "sort_by_product_sales_label",
  "sort_by_relevance_label",
  "sort_by_price_desc_label",
  "sort_by_price_asc_label",
  "sort_by_most_recent_label",
  "sort_by_rating_label",

  "show_offers_filter",
  "offers_filter_text",

  "price_range_label",
  "price_range_filter_label",
  "show_price_range_chart",

  "no_products_text",
  "no_products_advice_text",
  "show_categories_filter",
  "reset_filters_text",
]);

onBeforeMount(() => {
  tabs.value = settings.map((tab) => {
    return {
      key: tab.key,
      name: tab.title,
    };
  });
});

onMounted(() => {
  state.theme = props.theme;
  state.products_per_page = props.products_per_page;
  state.filters_title_text = props.filters_title_text;
  state.products_title_text = props.products_title_text;
  state.products_subtitle_template = props.products_subtitle_template;

  state.sort_by_product_sales_label = props.sort_by_product_sales_label;
  state.sort_by_relevance_label = props.sort_by_relevance_label;
  state.sort_by_price_desc_label = props.sort_by_price_desc_label;
  state.sort_by_price_asc_label = props.sort_by_price_asc_label;
  state.sort_by_most_recent_label = props.sort_by_most_recent_label;
  state.sort_by_rating_label = props.sort_by_rating_label;

  state.show_offers_filter = props.show_offers_filter;
  state.offers_filter_text = props.offers_filter_text;

  state.price_range_label = props.price_range_label;
  state.price_range_filter_label = props.price_range_filter_label;
  state.show_price_range_chart = props.show_price_range_chart;

  state.no_products_text = props.no_products_text;
  state.no_products_advice_text = props.no_products_advice_text;
  state.show_categories_filter = props.show_categories_filter;
  state.reset_filters_text = props.reset_filters_text;
});

const state = reactive({
  theme: props.theme,
  products_per_page: props.products_per_page,
  filters_title_text: props.filters_title_text,
  products_title_text: props.products_title_text,
  products_subtitle_template: props.products_subtitle_template,

  sort_by_product_sales_label: props.sort_by_product_sales_label,
  sort_by_relevance_label: props.sort_by_relevance_label,
  sort_by_price_desc_label: props.sort_by_price_desc_label,
  sort_by_price_asc_label: props.sort_by_price_asc_label,
  sort_by_most_recent_label: props.sort_by_most_recent_label,
  sort_by_rating_label: props.sort_by_rating_label,

  show_offers_filter: props.show_offers_filter,
  offers_filter_text: props.offers_filter_text,

  price_range_label: props.price_range_label,
  price_range_filter_label: props.price_range_filter_label,
  show_price_range_chart: props.show_price_range_chart,

  no_products_text: props.no_products_text,
  no_products_advice_text: props.no_products_advice_text,
  show_categories_filter: props.show_categories_filter,
  reset_filters_text: props.reset_filters_text,
});

const settings = [
  {
    key: "general-settings",
    title: "General Texts",
    subtitle: "General settings",
    fields: [
      {
        type: Dropdown,
        name: "theme",
        label: "Theme",
        info: "",
        props: {
          optionLabel: "name",
          optionValue: "code",
          options: [
            { name: "aura-light-amber", code: "aura-light-amber" },
            { name: "aura-light-green", code: "aura-light-green" },
            { name: "aura-light-noir", code: "aura-light-noir" },
            { name: "aura-light-teal", code: "aura-light-teal" },
            { name: "aura-light-blue", code: "aura-light-blue" },
            { name: "aura-light-indigo", code: "aura-light-indigo" },
            { name: "aura-light-pink", code: "aura-light-pink" },
            { name: "aura-light-cyan", code: "aura-light-cyan" },
            { name: "aura-light-lime", code: "aura-light-lime" },
            { name: "aura-light-purple", code: "aura-light-purple" },
          ],
        },
      },
      {
        type: InputText,
        name: "products_per_page",
        label: "Products per page",
        info: "Products per page info text",
      },
      {
        type: InputText,
        name: "price_range_label",
        label: "Price range label",
        info: "Price range info text",
      },
      {
        type: InputText,
        name: "price_range_filter_label",
        label: "Price range filter label template",
        info: "Price range filter info text",
      },
      {
        type: InputText,
        name: "reset_filters_text",
        label: "Reset filters text",
        info: "Reset filters info text",
      },
      {
        type: InputText,
        name: "filters_title_text",
        label: "Filters title text",
        info: "Filters title info text",
      },
      {
        type: InputText,
        name: "products_title_text",
        label: "Products title text",
        info: "Products title info text",
      },
      {
        type: InputText,
        name: "products_subtitle_template",
        label: "Products subtitle template",
        info: "Products subtitle info text",
      },
    ],
  },
  {
    key: "sorting-options",
    title: "Sorting Options",
    subtitle: "Sorting settings",
    fields: [
      {
        type: InputText,
        name: "sort_by_product_sales_label",
        label: "Sort by product sales label",
        info: "Sort by product sales info text",
      },
      {
        type: InputText,
        name: "sort_by_relevance_label",
        label: "Sort by relevance label",
        info: "Sort by relevance info text",
      },
      {
        type: InputText,
        name: "sort_by_price_desc_label",
        label: "Sort by price descending label",
        info: "Sort by price descending info text",
      },
      {
        type: InputText,
        name: "sort_by_price_asc_label",
        label: "Sort by price ascending label",
        info: "Sort by price ascending info text",
      },
      {
        type: InputText,
        name: "sort_by_most_recent_label",
        label: "Sort by most recent label",
        info: "Sort by most recent info text",
      },
      {
        type: InputText,
        name: "sort_by_rating_label",
        label: "Sort by rating label",
        info: "Sort by rating info text",
      },
    ],
  },
  {
    key: "empty-results-options",
    title: "Empty Results Options",
    subtitle: "Empty results settings",
    fields: [
      {
        type: InputText,
        name: "no_products_text",
        label: "No products text",
        info: "No products info text",
      },
      {
        type: InputText,
        name: "no_products_advice_text",
        label: "No products advice text",
        info: "No products advice info text",
      },
    ],
  },
];

const selectedTab = ref("general-settings");
</script>
