<template>
  <form class="">
    <Tabs v-model="selectedTab" :tabs="tabs"></Tabs>
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
                    :for="field.name"
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
        class="sgm-flex sgm-space-x-3 sgm-flex-row sgm-items-center sgm-justify-end sgm-w-full"
      >
        <div class="sgm-h-[30px]">
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

const { reactive, onMounted, onBeforeMount } = Vue;
const Dropdown = primevue.dropdown;

const { ref } = Vue;

const InputNumber = primevue.inputnumber;
const InputText = primevue.inputtext;
const RadioButton = primevue.radiobutton;
const SelectButton = primevue.selectbutton;
const InlineMessage = primevue.inlinemessage;
const Button = primevue.button;
const TabMenu = primevue.tabmenu;

const tabs = ref([]);

const props = defineProps([
  "nothing_found_text",
  "sort_by",
  "number_of_results",
  "show_categories",
  "number_of_categories",
  "max_description_length",
  "show_category",
  "show_description",
  "show_price",
  "show_rating",
  "show_sku",
  "show_on_sale",
]);

onBeforeMount(() => {
  tabs.value = settings.map((tab) => {
    return {
      key: tab.key,
      name: tab.title,
    };
  });
});

onMounted(() => {});

const state = reactive({
  nothing_found_text: props.nothing_found_text,
  sort_by: props.sort_by,
  number_of_results: props.number_of_results,
  show_categories: props.show_categories,
  number_of_categories: props.number_of_categories,
  max_description_length: props.max_description_length,
  show_category: props.show_category,
  show_description: props.show_description,
  show_price: props.show_price,
  show_rating: props.show_rating,
  show_sku: props.show_sku,
  show_on_sale: props.show_on_sale,
});

const settings = [
  {
    key: "general-settings",
    title: "General",
    subtitle: "General settings for the search results.",
    fields: [
      {
        type: Dropdown,
        name: "sort_by",
        label: "Sort results by",
        info: "",
        props: {
          optionLabel: "name",
          optionValue: "code",
          options: [
            { name: "Relevance", code: "relevance" },
            { name: "Price: Low to High", code: "price-low-to-high" },
            { name: "Price: High to Low", code: "price-high-to-low" },
            { name: "Newest", code: "newest" },
            { name: "Oldest", code: "oldest" },
          ],
        },
      },
      {
        type: InputNumber,
        name: "number_of_results",
        label: "Number of search results",
        info: "How many search results should be displayed.",
      },
      {
        type: SelectButton,
        name: "show_categories",
        label: "Show categories",
        info: "Display the matching categories list.",
        props: {
          options: ["Show", "Hide"],
        },
      },
      {
        type: InputNumber,
        name: "number_of_categories",
        label: "Number of categories",
        info: "How many categories should be shown next to the results list.",
      },
    ],
  },

  {
    key: "product-attributes",
    title: "Product Attributes",
    subtitle:
      "Define the product attributes to be displayed on the product card here.",
    fields: [
      {
        type: InputNumber,
        name: "max_description_length",
        label: "Max description length",
        info: "Maximum length of the description.",
      },
      {
        type: SelectButton,
        name: "show_category",
        label: "Categories",
        info: "",
        props: {
          options: ["Show", "Hide"],
        },
      },
      {
        type: SelectButton,
        name: "show_description",
        label: "Description",
        info: "",
        props: {
          options: ["Show", "Hide"],
        },
      },
      {
        type: SelectButton,
        name: "show_price",
        label: "Show price",
        info: "",
        props: {
          options: ["Show", "Hide"],
        },
      },
      {
        type: SelectButton,
        name: "show_rating",
        label: "Rating",
        info: "",
        props: {
          options: ["Show", "Hide"],
        },
      },
      {
        type: SelectButton,
        name: "show_sku",
        label: "SKU",
        info: "",
        props: {
          options: ["Show", "Hide"],
        },
      },
      {
        type: SelectButton,
        name: "show_on_sale",
        label: "On sale",
        info: "",
        props: {
          options: ["Show", "Hide"],
        },
      },
    ],
  },

  {
    key: "empty-results-options",
    title: "Empty Results",
    subtitle: "Configuration for scenarios with no search results.",
    fields: [
      {
        type: InputText,
        name: "nothing_found_text",
        label: "Nothing found text",
        info: "",
      },
    ],
  },
];

const selectedTab = ref("general-settings");
</script>
