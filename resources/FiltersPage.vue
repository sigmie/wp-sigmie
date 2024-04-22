<template>
  <form class="">
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
            <p
              class="sgm-mt-1 sgm-max-w-xs sgm-text-sm sgm-leading-6 sgm-text-gray-600"
            >
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
                  >
                    <template #option="slotProps">
                      <div
                        class="sgm-flex-row sgm-flex sgm-space-x-2 sgm-items-center"
                        v-if="slotProps.option.color"
                      >
                        <div
                          class="sgm-rounded-full sgm-w-4 sgm-h-4"
                          :style="{ backgroundColor: slotProps.option.color }"
                        ></div>
                        <div>
                          {{ slotProps.option.name }}
                        </div>
                      </div>
                    </template>
                  </component>
                  <span class="sgm-text-sm">{{ field.info }}</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </template>

      <div
        class="sgm-flex sgm-space-y-3 sm:sgm-space-y-0 sm:sgm-space-x-3 sgm-flex-col sm:sgm-flex-row sgm-justify-end sgm-w-full"
      >
        <div class="sgm-h-[20px]">
          <InlineMessage severity="success" v-if="recentlySuccessful"
            >Your changes have been saved!</InlineMessage
          >
          <InlineMessage severity="error" v-if="recentlyError">
            Oops! Something went wrong.
          </InlineMessage>
        </div>

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
import {
  saveSettings,
  loading,
  recentlySuccessful,
  recentlyError,
  errorMessage,
} from "./saveSettings.js";
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
    title: "General",
    subtitle: "General settings for filters section.",
    fields: [
      {
        type: Dropdown,
        name: "theme",
        label: "Theme",
        info: "",
        props: {
          slot: true,
          optionLabel: "name",
          optionValue: "code",
          options: [
            {
              name: "aura-light-amber",
              code: "aura-light-amber",
              color: "#eab308",
            },
            {
              name: "aura-light-green",
              code: "aura-light-green",
              color: "#10b981",
            },
            {
              name: "aura-light-noir",
              code: "aura-light-noir",
              color: "#020617",
            },
            {
              name: "aura-light-teal",
              code: "aura-light-teal",
              color: "#14b8a6",
            },
            {
              name: "aura-light-blue",
              code: "aura-light-blue",
              color: "#3b82f6",
            },
            {
              name: "aura-light-indigo",
              code: "aura-light-indigo",
              color: "#8b5cf6",
            },
            {
              name: "aura-light-pink",
              code: "aura-light-pink",
              color: "#ec4899",
            },
            {
              name: "aura-light-cyan",
              code: "aura-light-cyan",
              color: "#06b6d4",
            },
            {
              name: "aura-light-lime",
              code: "aura-light-lime",
              color: "#84cc16",
            },
            {
              name: "aura-light-purple",
              code: "aura-light-purple",
              color: "#6366f1",
            },
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
    title: "Sorting labels",
    subtitle: "Customize the texts for the sorting options.",
    fields: [
      {
        type: InputText,
        name: "sort_by_relevance_label",
        label: "Sort by relevance label",
        info: "",
      },
      {
        type: InputText,
        name: "sort_by_product_sales_label",
        label: "Sort by product sales label",
        info: "",
      },
      {
        type: InputText,
        name: "sort_by_price_desc_label",
        label: "Sort by price descending label",
        info: "",
      },
      {
        type: InputText,
        name: "sort_by_price_asc_label",
        label: "Sort by price ascending label",
        info: "",
      },
      {
        type: InputText,
        name: "sort_by_most_recent_label",
        label: "Sort by most recent label",
        info: "",
      },
      {
        type: InputText,
        name: "sort_by_rating_label",
        label: "Sort by rating label",
        info: "",
      },
    ],
  },
  {
    key: "empty-results",
    title: "Empty Results",
    subtitle: "Configuration for scenarios with no search results.",
    fields: [
      {
        type: InputText,
        name: "no_products_text",
        label: "No products title",
        info: "",
      },
      {
        type: InputText,
        name: "no_products_advice_text",
        label: "No products subtitle",
        info: "",
      },
    ],
  },
];

const selectedTab = ref("general-settings");
</script>
