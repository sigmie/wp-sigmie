<template>
  <form class="sgm-max-w-2xl">
    <InlineMessage class="sgm-w-full sgm-mb-10" severity="contrast">
      Search results are the output of a search query.
    </InlineMessage>
    <div v-if="tabs.length > 1">
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
    title: "General Texts",
    subtitle: "General settings",
    fields: [
      {
        type: InputText,
        name: "nothing_found_text",
        label: "Nothing found text",
        info: "",
      },
      {
        type: Dropdown,
        name: "sort_by",
        label: "Sort by",
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
        label: "Number of results",
        info: "Number of results info text",
      },
      {
        type: SelectButton,
        name: "show_categories",
        label: "Show categories",
        info: "Show categories info text",
        props: {
          options: ["Show", "Hide"],
        },
      },
      {
        type: InputNumber,
        name: "number_of_categories",
        label: "Number of categories",
        info: "Number of categories info text",
      },
      {
        type: InputNumber,
        name: "max_description_length",
        label: "Max description length",
        info: "Max description length info text",
      },
      {
        type: SelectButton,
        name: "show_category",
        label: "Show category",
        info: "Show category info text",
        props: {
          options: ["Show", "Hide"],
        },
      },
      {
        type: SelectButton,
        name: "show_description",
        label: "Show description",
        info: "Show description info text",
        props: {
          options: ["Show", "Hide"],
        },
      },
      {
        type: SelectButton,
        name: "show_price",
        label: "Show price",
        info: "Show price info text",
        props: {
          options: ["Show", "Hide"],
        },
      },
      {
        type: SelectButton,
        name: "show_rating",
        label: "Show rating",
        info: "Show rating info text",
        props: {
          options: ["Show", "Hide"],
        },
      },
      {
        type: SelectButton,
        name: "show_sku",
        label: "Show SKU",
        info: "Show SKU info text",
        props: {
          options: ["Show", "Hide"],
        },
      },
      {
        type: SelectButton,
        name: "show_on_sale",
        label: "Show on sale",
        info: "Show on sale info text",
        props: {
          options: ["Show", "Hide"],
        },
      },
    ],
  },
];

const selectedTab = ref("general-settings");
</script>
