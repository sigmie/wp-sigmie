<template>
  <form class="">
    <InlineMessage class="sgm-w-full sgm-mb-10" severity="contrast">
      You can use the Search as widget, that you will find inside the widgets
      areas or you can use the shortcode
      <span class="sgm-text-red-300">[sigmie_search_bar]</span>.
    </InlineMessage>
    <div class="sgm-space-y-5 sm:sgm-space-y-20 sgm-divide-y">
      <div
        class="sgm-flex sgm-flex-col sgm-space-x-10 sm:sgm-flex-row sgm-justify-between"
      >
        <div>
          <h2
            class="sgm-text-base sgm-font-semibold sgm-leading-7 sgm-text-gray-900"
          >
            General
          </h2>
          <p class="sgm-mt-1 sgm-text-sm sgm-leading-6 sgm-text-gray-600">
            General search settings
          </p>
        </div>

        <div class="sgm-grid sgm-grid-cols-1 sgm-gap-x-6 sgm-gap-y-8">
          <div class="sgm-max-w-xs">
            <div class="sgm-mt-2">
              <div class="sgm-flex sgm-flex-col sgm-gap-2">
                <label
                  class="sgm-block sgm-text-sm sgm-font-medium sgm-leading-6 sgm-text-gray-900"
                  for="sigmie_search_field_text"
                  >Search field text</label
                >
                <InputText v-model="state.field_text" />
                <span class="sgm-text-sm">
                  Placeholder for the Search field.
                </span>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div
        class="sgm-flex sgm-flex-col sgm-space-x-10 sm:sgm-flex-row sgm-justify-between"
      >
        <div>
          <h2
            class="sgm-text-base sgm-font-semibold sgm-leading-7 sgm-text-gray-900"
          >
            Appearance
          </h2>
          <p class="sgm-mt-1 sgm-text-sm sgm-leading-6 sgm-text-gray-600">
            Visual settings for the Search input.
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
        class="sgm-flex sgm-space-y-3 sm:sgm-space-y-0 sm:sgm-space-x-3 sgm-flex-col sm:sgm-flex-row sgm-justify-end sgm-w-full"
      >
        <div class="sgm-h-12 sm:sgm-h-auto">
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

const { reactive, onMounted, toRefs } = Vue;
const Dropdown = primevue.dropdown;

const InputNumber = primevue.inputnumber;
const InputText = primevue.inputtext;
const RadioButton = primevue.radiobutton;
const SelectButton = primevue.selectbutton;
const InlineMessage = primevue.inlinemessage;
const Button = primevue.button;

const props = defineProps({
  field_text: {
    type: String,
    default: "Search",
  },
  show_loader: {
    type: Boolean,
    default: true,
  },
  max_height: {
    type: Number,
    default: 100,
  },
  max_width: {
    type: Number,
    default: 100,
  },
  corner_radius: {
    type: Number,
    default: 0,
  },
});

const state = reactive({
  field_text: props.field_text,
  show_loader: props.show_loader,
  max_height: props.max_height,
  max_width: props.max_width,
  corner_radius: props.corner_radius,
});
</script>
