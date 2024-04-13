<template>
  <form class="sgm-max-w-2xl">
    <div>
      <div
        class="sgm-hidden sm:sgm-block sgm-bg-black sgm-text-white sgm-rounded-md sgm-my-4"
      >
        <nav class="sgm-flex sgm-space-x-4 sgm-py-2 sgm-px-1" aria-label="Tabs">
          <button
            v-for="(tab, index) in tabs"
            @click.prevent="selectTab(index)"
            :key="tab.name"
            :class="[
              tab.current
                ? 'sgm-bg-gray-700 sgm-text-gray-100'
                : 'sgm-text-white sgm-hover:text-gray-800',
              'sgm-rounded-md sgm-bg-transparent sgm-px-2 sgm-py-1 sgm-text-sm sgm-font-medium sgm-no-underline sgm-ring-0 sgm-border-0 sgm-cursor-pointer',
            ]"
            :aria-current="tab.current ? 'page' : undefined"
          >
            {{ tab.name }}
          </button>
        </nav>
      </div>
    </div>
    <!-- <InlineMessage class="sgm-w-full sgm-mb-10" severity="contrast">
      You can use it as widget, you will find inside the widgets areas or you
      can use the shortcode [sigmie_search_bar].
    </InlineMessage> -->
    <div class="sgm-space-y-20 sgm-divide-y">
      <div class="sgm-flex sgm-flex-row sgm-justify-between">
        <div>
          <h2
            class="sgm-text-base sgm-font-semibold sgm-leading-7 sgm-text-gray-900"
          >
            General Texts
          </h2>
          <p class="sgm-mt-1 sgm-text-sm sgm-leading-6 sgm-text-gray-600">
            General settings
          </p>
        </div>

        <div class="sgm-grid sgm-grid-cols-1 sgm-gap-x-6 sgm-gap-y-3">
          <div class="sgm-max-w-xs">
            <div class="sgm-mt-2">
              <div class="sgm-flex sgm-flex-col sgm-gap-2">
                <label
                  class="sgm-block sgm-text-sm sgm-font-medium sgm-leading-6 sgm-text-gray-900"
                  for="sigmie_theme"
                  >Theme</label
                >
                <InputText v-model="state.theme" />
                <span class="sgm-text-sm"> Theme settings </span>
              </div>
            </div>
          </div>
          <div class="sgm-max-w-xs">
            <div class="sgm-mt-2">
              <div class="sgm-flex sgm-flex-col sgm-gap-2">
                <label
                  class="sgm-block sgm-text-sm sgm-font-medium sgm-leading-6 sgm-text-gray-900"
                  for="sigmie_products_per_page"
                  >Products per page</label
                >
                <InputNumber v-model="state.products_per_page" />
                <span class="sgm-text-sm">
                  Number of products to display per page.
                </span>
              </div>
            </div>
          </div>
          <div class="sgm-max-w-xs">
            <div class="sgm-mt-2">
              <div class="sgm-flex sgm-flex-col sgm-gap-2">
                <label
                  class="sgm-block sgm-text-sm sgm-font-medium sgm-leading-6 sgm-text-gray-900"
                  for="sigmie_filters_title_text"
                  >Filters title text</label
                >
                <InputText v-model="state.filters_title_text" />
                <span class="sgm-text-sm"> Text for filters title. </span>
              </div>
            </div>
          </div>
          <div class="sgm-max-w-xs">
            <div class="sgm-mt-2">
              <div class="sgm-flex sgm-flex-col sgm-gap-2">
                <label
                  class="sgm-block sgm-text-sm sgm-font-medium sgm-leading-6 sgm-text-gray-900"
                  for="sigmie_products_title_text"
                  >Products title text</label
                >
                <InputText v-model="state.products_title_text" />
                <span class="sgm-text-sm"> Text for products title. </span>
              </div>
            </div>
          </div>
          <div class="sgm-max-w-xs">
            <div class="sgm-mt-2">
              <div class="sgm-flex sgm-flex-col sgm-gap-2">
                <label
                  class="sgm-block sgm-text-sm sgm-font-medium sgm-leading-6 sgm-text-gray-900"
                  for="sigmie_products_subtitle_template"
                  >Products subtitle template</label
                >
                <InputText v-model="state.products_subtitle_template" />
                <span class="sgm-text-sm">
                  Template for products subtitle.
                </span>
              </div>
            </div>
          </div>
          <div class="sgm-max-w-xs">
            <div class="sgm-mt-2">
              <div class="sgm-flex sgm-flex-col sgm-gap-2">
                <label
                  class="sgm-block sgm-text-sm sgm-font-medium sgm-leading-6 sgm-text-gray-900"
                  for="sigmie_sort_by_product_sales_label"
                  >Sort by product sales label</label
                >
                <InputText v-model="state.sort_by_product_sales_label" />
                <span class="sgm-text-sm">
                  Text for sort by product sales label.
                </span>
              </div>
            </div>
          </div>
          <div class="sgm-max-w-xs">
            <div class="sgm-mt-2">
              <div class="sgm-flex sgm-flex-col sgm-gap-2">
                <label
                  class="sgm-block sgm-text-sm sgm-font-medium sgm-leading-6 sgm-text-gray-900"
                  for="sigmie_sort_by_relevance_label"
                  >Sort by relevance label</label
                >
                <InputText v-model="state.sort_by_relevance_label" />
                <span class="sgm-text-sm">
                  Text for sort by relevance label.
                </span>
              </div>
            </div>
          </div>
          <div class="sgm-max-w-xs">
            <div class="sgm-mt-2">
              <div class="sgm-flex sgm-flex-col sgm-gap-2">
                <label
                  class="sgm-block sgm-text-sm sgm-font-medium sgm-leading-6 sgm-text-gray-900"
                  for="sigmie_sort_by_price_desc_label"
                  >Sort by price descending label</label
                >
                <InputText v-model="state.sort_by_price_desc_label" />
                <span class="sgm-text-sm">
                  Text for sort by price descending label.
                </span>
              </div>
            </div>
          </div>
          <div class="sgm-max-w-xs">
            <div class="sgm-mt-2">
              <div class="sgm-flex sgm-flex-col sgm-gap-2">
                <label
                  class="sgm-block sgm-text-sm sgm-font-medium sgm-leading-6 sgm-text-gray-900"
                  for="sigmie_sort_by_price_asc_label"
                  >Sort by price ascending label</label
                >
                <InputText v-model="state.sort_by_price_asc_label" />
                <span class="sgm-text-sm">
                  Text for sort by price ascending label.
                </span>
              </div>
            </div>
          </div>
          <div class="sgm-max-w-xs">
            <div class="sgm-mt-2">
              <div class="sgm-flex sgm-flex-col sgm-gap-2">
                <label
                  class="sgm-block sgm-text-sm sgm-font-medium sgm-leading-6 sgm-text-gray-900"
                  for="sigmie_sort_by_most_recent_label"
                  >Sort by most recent label</label
                >
                <InputText v-model="state.sort_by_most_recent_label" />
                <span class="sgm-text-sm">
                  Text for sort by most recent label.
                </span>
              </div>
            </div>
          </div>
          <div class="sgm-max-w-xs">
            <div class="sgm-mt-2">
              <div class="sgm-flex sgm-flex-col sgm-gap-2">
                <label
                  class="sgm-block sgm-text-sm sgm-font-medium sgm-leading-6 sgm-text-gray-900"
                  for="sigmie_sort_by_rating_label"
                  >Sort by rating label</label
                >
                <InputText v-model="state.sort_by_rating_label" />
                <span class="sgm-text-sm">
                  Text for sort by rating label.
                </span>
              </div>
            </div>
          </div>
          <div class="sgm-max-w-xs">
            <div class="sgm-mt-2">
              <div class="sgm-flex sgm-flex-col sgm-gap-2">
                <label
                  class="sgm-block sgm-text-sm sgm-font-medium sgm-leading-6 sgm-text-gray-900"
                  for="sigmie_show_offers_filter"
                  >Show offers filter</label
                >
                <SelectButton
                  v-model="state.show_offers_filter"
                  :options="['Yes', 'No']"
                />
                <span class="sgm-text-sm"> Show offers filter or not. </span>
              </div>
            </div>
          </div>
          <div class="sgm-max-w-xs">
            <div class="sgm-mt-2">
              <div class="sgm-flex sgm-flex-col sgm-gap-2">
                <label
                  class="sgm-block sgm-text-sm sgm-font-medium sgm-leading-6 sgm-text-gray-900"
                  for="sigmie_offers_filter_text"
                  >Offers filter text</label
                >
                <InputText v-model="state.offers_filter_text" />
                <span class="sgm-text-sm"> Text for offers filter. </span>
              </div>
            </div>
          </div>
          <div class="sgm-max-w-xs">
            <div class="sgm-mt-2">
              <div class="sgm-flex sgm-flex-col sgm-gap-2">
                <label
                  class="sgm-block sgm-text-sm sgm-font-medium sgm-leading-6 sgm-text-gray-900"
                  for="sigmie_price_range_label"
                  >Price range label</label
                >
                <InputText v-model="state.price_range_label" />
                <span class="sgm-text-sm"> Text for price range label. </span>
              </div>
            </div>
          </div>
          <div class="sgm-max-w-xs">
            <div class="sgm-mt-2">
              <div class="sgm-flex sgm-flex-col sgm-gap-2">
                <label
                  class="sgm-block sgm-text-sm sgm-font-medium sgm-leading-6 sgm-text-gray-900"
                  for="sigmie_price_range_filter_label"
                  >Price range filter label template</label
                >
                <InputText v-model="state.price_range_filter_label" />
                <span class="sgm-text-sm">
                  Template for price range filter label.
                </span>
              </div>
            </div>
          </div>
          <div class="sgm-max-w-xs">
            <div class="sgm-mt-2">
              <div class="sgm-flex sgm-flex-col sgm-gap-2">
                <label
                  class="sgm-block sgm-text-sm sgm-font-medium sgm-leading-6 sgm-text-gray-900"
                  for="sigmie_show_price_range_chart"
                  >Show price chart</label
                >
                <SelectButton
                  v-model="state.show_price_range_chart"
                  :options="['Yes', 'No']"
                />
                <span class="sgm-text-sm"> Show price chart or not. </span>
              </div>
            </div>
          </div>
          <div class="sgm-max-w-xs">
            <div class="sgm-mt-2">
              <div class="sgm-flex sgm-flex-col sgm-gap-2">
                <label
                  class="sgm-block sgm-text-sm sgm-font-medium sgm-leading-6 sgm-text-gray-900"
                  for="sigmie_no_products_text"
                  >No products text</label
                >
                <InputText v-model="state.no_products_text" />
                <span class="sgm-text-sm"> Text for no products. </span>
              </div>
            </div>
          </div>
          <div class="sgm-max-w-xs">
            <div class="sgm-mt-2">
              <div class="sgm-flex sgm-flex-col sgm-gap-2">
                <label
                  class="sgm-block sgm-text-sm sgm-font-medium sgm-leading-6 sgm-text-gray-900"
                  for="sigmie_no_products_advice_text"
                  >No products advice text</label
                >
                <InputText v-model="state.no_products_advice_text" />
                <span class="sgm-text-sm"> Advice text for no products. </span>
              </div>
            </div>
          </div>
          <div class="sgm-max-w-xs">
            <div class="sgm-mt-2">
              <div class="sgm-flex sgm-flex-col sgm-gap-2">
                <label
                  class="sgm-block sgm-text-sm sgm-font-medium sgm-leading-6 sgm-text-gray-900"
                  for="sigmie_show_categories_filter"
                  >Show categories</label
                >
                <SelectButton
                  v-model="state.show_categories_filter"
                  :options="['Yes', 'No']"
                />
                <span class="sgm-text-sm"> Show categories or not. </span>
              </div>
            </div>
          </div>
          <div class="sgm-max-w-xs">
            <div class="sgm-mt-2">
              <div class="sgm-flex sgm-flex-col sgm-gap-2">
                <label
                  class="sgm-block sgm-text-sm sgm-font-medium sgm-leading-6 sgm-text-gray-900"
                  for="sigmie_reset_filters_text"
                  >Reset filters text</label
                >
                <InputText v-model="state.reset_filters_text" />
                <span class="sgm-text-sm"> Text for reset filters. </span>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="sgm-flex sgm-flex-row sgm-justify-between">
        <div>
          <h2
            class="sgm-text-base sgm-font-semibold sgm-leading-7 sgm-text-gray-900"
          >
            Sorting
          </h2>
          <p class="sgm-mt-1 sgm-text-sm sgm-leading-6 sgm-text-gray-600">
            Sort settings
          </p>
        </div>

        <div class="sgm-grid sgm-grid-cols-1 sgm-gap-x-6 sgm-gap-y-3">
          <div class="sgm-max-w-xs">
            <div class="sgm-mt-2">
              <div class="sgm-flex sgm-flex-col sgm-gap-2">
                <label
                  class="sgm-block sgm-text-sm sgm-font-medium sgm-leading-6 sgm-text-gray-900"
                  for="sigmie_sort_by_product_sales_label"
                  >Sort by product sales label</label
                >
                <InputText v-model="state.sort_by_product_sales_label" />
                <span class="sgm-text-sm">
                  Text for sort by product sales label.
                </span>
              </div>
            </div>
          </div>
          <div class="sgm-max-w-xs">
            <div class="sgm-mt-2">
              <div class="sgm-flex sgm-flex-col sgm-gap-2">
                <label
                  class="sgm-block sgm-text-sm sgm-font-medium sgm-leading-6 sgm-text-gray-900"
                  for="sigmie_sort_by_relevance_label"
                  >Sort by relevance label</label
                >
                <InputText v-model="state.sort_by_relevance_label" />
                <span class="sgm-text-sm">
                  Text for sort by relevance label.
                </span>
              </div>
            </div>
          </div>
          <div class="sgm-max-w-xs">
            <div class="sgm-mt-2">
              <div class="sgm-flex sgm-flex-col sgm-gap-2">
                <label
                  class="sgm-block sgm-text-sm sgm-font-medium sgm-leading-6 sgm-text-gray-900"
                  for="sigmie_sort_by_price_desc_label"
                  >Sort by price descending label</label
                >
                <InputText v-model="state.sort_by_price_desc_label" />
                <span class="sgm-text-sm">
                  Text for sort by price descending label.
                </span>
              </div>
            </div>
          </div>
          <div class="sgm-max-w-xs">
            <div class="sgm-mt-2">
              <div class="sgm-flex sgm-flex-col sgm-gap-2">
                <label
                  class="sgm-block sgm-text-sm sgm-font-medium sgm-leading-6 sgm-text-gray-900"
                  for="sigmie_sort_by_price_asc_label"
                  >Sort by price ascending label</label
                >
                <InputText v-model="state.sort_by_price_asc_label" />
                <span class="sgm-text-sm">
                  Text for sort by price ascending label.
                </span>
              </div>
            </div>
          </div>
          <div class="sgm-max-w-xs">
            <div class="sgm-mt-2">
              <div class="sgm-flex sgm-flex-col sgm-gap-2">
                <label
                  class="sgm-block sgm-text-sm sgm-font-medium sgm-leading-6 sgm-text-gray-900"
                  for="sigmie_sort_by_most_recent_label"
                  >Sort by most recent label</label
                >
                <InputText v-model="state.sort_by_most_recent_label" />
                <span class="sgm-text-sm">
                  Text for sort by most recent label.
                </span>
              </div>
            </div>
          </div>
          <div class="sgm-max-w-xs">
            <div class="sgm-mt-2">
              <div class="sgm-flex sgm-flex-col sgm-gap-2">
                <label
                  class="sgm-block sgm-text-sm sgm-font-medium sgm-leading-6 sgm-text-gray-900"
                  for="sigmie_sort_by_rating_label"
                  >Sort by rating label</label
                >
                <InputText v-model="state.sort_by_rating_label" />
                <span class="sgm-text-sm">
                  Text for sort by rating label.
                </span>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="sgm-flex sgm-flex-row sgm-justify-between">
        <div>
          <h2
            class="sgm-text-base sgm-font-semibold sgm-leading-7 sgm-text-gray-900"
          >
            Visual
          </h2>
          <p class="sgm-mt-1 sgm-text-sm sgm-leading-6 sgm-text-gray-600">
            Visual search settings
          </p>
        </div>

        <div
          class="sgm-grid sgm-max-w-2xl sgm-grid-cols-1 sgm-gap-x-6 sgm-gap-y-8"
        >
          <div class="sm:sgm-col-span-6">
            <div class="sgm-mt-2">
              <SelectButton
                v-model="state.show_loader"
                :options="['Show loader', 'Hide loader']"
              />
            </div>
          </div>

          <div
            class="sm:sgm-col-span-6 sgm-flex sgm-flex-col sgm-space-y-5 sgm-max-w-xs"
          >
            <div class="sgm-mt-2">
              <label
                class="sgm-block sgm-text-sm sgm-font-medium sgm-leading-6 sgm-text-gray-900 sgm-mb-2"
                for="sigmie_search_field_text"
                >Max Height</label
              >

              <div class="sgm-relative sgm-w-full">
                <span class="sgm-absolute sgm-right-10 sgm-top-3">px</span>
                <InputNumber v-model="state.max_height" />
              </div>
            </div>
            <div class="sgm-mt-2 sgm-max-w-xs">
              <label
                class="sgm-block sgm-text-sm sgm-font-medium sgm-leading-6 sgm-text-gray-900 sgm-mb-2"
                for="sigmie_search_field_text"
                >Max Width</label
              >
              <div class="sgm-relative">
                <span class="sgm-absolute sgm-right-10 sgm-top-3">px</span>
                <InputNumber v-model="state.max_width" />
              </div>
            </div>
            <div class="sgm-mt-2 sgm-max-w-xs">
              <label
                class="sgm-block sgm-text-sm sgm-font-medium sgm-leading-6 sgm-text-gray-900 sgm-mb-2"
                for="sigmie_search_field_text"
                >Corner radius</label
              >
              <div class="sgm-relative">
                <span class="sgm-absolute sgm-right-10 sgm-top-3">px</span>
                <InputNumber v-model="state.corner_radius" />
              </div>
            </div>
          </div>
        </div>
      </div>

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

const { reactive, onMounted, toRefs } = Vue;
const Dropdown = primevue.dropdown;

const { ref } = Vue;

const InputNumber = primevue.inputnumber;
const InputText = primevue.inputtext;
const RadioButton = primevue.radiobutton;
const SelectButton = primevue.selectbutton;
const InlineMessage = primevue.inlinemessage;
const Button = primevue.button;

const props = defineProps([
  "language",
  "field_text",
  "show_loader",
  "max_height",
  "max_width",
  "corner_radius",
]);

onMounted(() => {
  state.language = props.language;
  state.field_text = props.field_text;
  state.show_loader = props.show_loader;
  state.max_height = props.max_height;
  state.max_width = props.max_width;
  state.corner_radius = props.corner_radius;
});

const state = reactive({
  language: {},
  field_text: "",
  show_loader: "",
  max_height: "",
  max_width: "",
  corner_radius: "",
});

const tabs = ref([
  { name: "General Settings", current: false },
  { name: "Sorting Options", current: false },
  { name: "Filter Settings", current: true },
  { name: "No Results Handling", current: false },
]);

const selectTab = (index) => {
  tabs.value.forEach((tab, i) => {
    tab.current = i === index;
  });
};
</script>
