<template>
  <InlineMessage class="sgm-w-full sgm-mb-10" severity="info"
    >You can use it as widget, you will find inside the widgets areas or you can
    use the shortcode [sigmie_search_bar].
  </InlineMessage>
  <form class="sgm-max-w-5xl">
    <div class="sgm-space-y-12">
      <div
        class="sgm-grid sgm-grid-cols-1 sgm-gap-x-8 sgm-gap-y-10 sgm-border-b sgm-border-gray-900 sgm-pb-6 md:sgm-grid-cols-3"
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

        <div
          class="sgm-grid sgm-max-w-2xl sgm-grid-cols-1 sgm-gap-x-6 sgm-gap-y-8 sm:sgm-grid-cols-6 md:sgm-col-span-2"
        >
          <div class="sm:sgm-col-span-4">
            <div class="sgm-mt-2">
              <div class="sgm-flex sgm-flex-col sgm-gap-2">
                <label
                  class="sgm-block sgm-text-sm sgm-font-medium sgm-leading-6 sgm-text-gray-900"
                  for="sigmie_search_field_text"
                  >Language</label
                >
                <Dropdown
                  name="sigmie_language"
                  v-model="state.language"
                  optionLabel="name"
                  :options="[
                    { name: 'English', code: 'en' },
                    { name: 'German', code: 'de' },
                    { name: 'Greek', code: 'gr' },
                  ]"
                >
                </Dropdown>
                <span class="sgm-text-sm">
                  Text for search field placeholder.
                </span>
              </div>
            </div>
          </div>

          <div class="sm:sgm-col-span-4">
            <div class="sgm-mt-2">
              <div class="sgm-flex sgm-flex-col sgm-gap-2">
                <label
                  class="sgm-block sgm-text-sm sgm-font-medium sgm-leading-6 sgm-text-gray-900"
                  for="sigmie_search_field_text"
                  >Search field text</label
                >
                <InputText v-model="state.field_text" />
                <span class="sgm-text-sm">
                  Text for search field placeholder.
                </span>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div
        class="sgm-grid sgm-grid-cols-1 sgm-gap-x-8 sgm-gap-y-10 sgm-border-b sgm-border-gray-900/10 sgm-pb-12 md:sgm-grid-cols-3"
      >
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
          class="sgm-grid sgm-max-w-2xl sgm-grid-cols-1 sgm-gap-x-6 sgm-gap-y-8 sm:sgm-grid-cols-6 md:sgm-col-span-2"
        >
          <div class="sm:sgm-col-span-6">
            <div class="sgm-mt-2">
              <SelectButton
                v-model="state.show_loader"
                :options="['Show loader', 'Hide loader']"
              />
            </div>
          </div>

          <div class="sm:sgm-col-span-6">
            <div class="sgm-mt-2 sgm-max-w-xs">
              <label
                class="sgm-block sgm-text-sm sgm-font-medium sgm-leading-6 sgm-text-gray-900 sgm-mb-2"
                for="sigmie_search_field_text"
                >Max Height</label
              >

              <div class="sgm-relative">
                <span class="sgm-absolute sgm-right-20 sgm-top-3">px</span>
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
                <span class="sgm-absolute sgm-right-20 sgm-top-3">px</span>
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
                <span class="sgm-absolute sgm-right-20 sgm-top-3">px</span>
                <InputNumber v-model="state.corner_radius" />
              </div>
            </div>
          </div>
        </div>
      </div>

      <div
        class="sgm-flex sgm-flex-row sgm-items-center sgm-justify-end sgm-w-full"
      >
        <Button size="small" :loading="loading" label="Save Settings" @click="saveSettings">
        </Button>
      </div>
    </div>
  </form>
</template>

<script setup>
const { reactive, onMounted, ref } = Vue;
const Dropdown = primevue.dropdown;

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

const loading = ref(false);

const saveSettings = async () => {
  try {
    loading.value = true;
    const response = await fetch("/wp-json/v1/sigmie/save-settings", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
        "X-WP-Nonce": wpApiSettings.nonce,
      },
      body: JSON.stringify(state),
    });

    loading.value = false;

    if (!response.ok) {
      throw new Error("Network response was not ok");
    }

    const data = await response.json();

    Toastify({
      text: "Settings saved successfully",
      gravity: "bottom",
      position: "center",
    }).showToast();
  } catch (error) {
    Toastify({
      text: "Something went wrong",
      gravity: "bottom",
      position: "center",
    }).showToast();
  }
};
</script>
