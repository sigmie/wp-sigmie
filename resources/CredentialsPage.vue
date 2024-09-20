<template>
  <form class="">
    <InlineMessage class="sgm-w-full sgm-my-3" severity="info">
      No Sigmie credentials yet?
      <a
        target="_blank"
        href="https://app.sigmie.com/sign-up"
        class="sgm-text-blue-800"
        >Follow this link</a
      >
      to create one for free in a couple of minutes!
    </InlineMessage>
    <InlineMessage icon="false" class="sgm-w-full sgm-my-3" severity="info">
      <a
        target="_blank"
        href="https://store.sigmie.com/subscriptions"
        class="sgm-text-blue-800"
        >Manage your subscription</a
      >
    </InlineMessage>
    <div class="sgm-space-y-20 sgm-divide-y">
      <div
        class="sgm-flex sgm-flex-col sgm-space-x-10 sm:sgm-flex-row sgm-justify-between"
      >
        <div class="sgm-max-w-xs">
          <h2
            class="sgm-text-base sgm-font-semibold sgm-leading-7 sgm-text-gray-900"
          >
            General
          </h2>
          <p class="sgm-mt-1 sgm-text-sm sgm-leading-6 sgm-text-gray-600">
            Configure your Sigmie credentials. You can find them in the
            <a href="https://app.sigmie.com/api-keys" target="_blank"
              >API Keys</a
            >
            section of your Sigmie dashboard.
          </p>
          <p class="sgm-mt-1 sgm-text-sm sgm-leading-6 sgm-text-gray-600">
            Once you provide your Sigmie Application ID and API key, this plugin
            will be able to securely communicate with Sigmie servers.
          </p>
        </div>

        <div class="sgm-grid sgm-grid-cols-1 sgm-gap-x-6 sgm-gap-y-8">
          <div class="sgm-flex sgm-flex-col sgm-space-y-2">
            <div class="sgm-max-w-xs">
              <div class="sgm-mt-2">
                <div class="sgm-flex sgm-flex-col sgm-gap-2">
                  <label
                    class="sgm-block sgm-text-sm sgm-font-medium sgm-leading-6 sgm-text-gray-900"
                    for="sigmie_application_id"
                    >Application Id</label
                  >
                  <InputText
                    id="sigmie_application_id"
                    v-model="state.application_id"
                  />
                </div>
              </div>
            </div>

            <div class="sgm-max-w-xs">
              <div class="sgm-mt-2">
                <div class="sgm-flex sgm-flex-col sgm-gap-2">
                  <label
                    class="sgm-block sgm-text-sm sgm-font-medium sgm-leading-6 sgm-text-gray-900"
                    for="sigmie_index_prefix"
                    >Index</label
                  >
                  <InputText
                    id="sigmie_index_prefix"
                    v-model="state.index_prefix"
                  />
                </div>
              </div>
            </div>

            <div class="sgm-max-w-xs">
              <div class="sgm-mt-2">
                <div class="sgm-flex sgm-flex-col sgm-gap-2">
                  <label
                    class="sgm-block sgm-text-sm sgm-font-medium sgm-leading-6 sgm-text-gray-900"
                    for="sigmie_search_field_text"
                    >Admin API key</label
                  >
                  <Password
                    toggleMask
                    id="sigmie_admin_api_key"
                    v-model="state.admin_api_key"
                    :feedback="false"
                  />
                  <span class="sgm-text-sm"
                    >Your Sigmie Admin API key (kept private).
                  </span>
                </div>
              </div>
            </div>

            <div class="sgm-max-w-xs">
              <div class="sgm-mt-2">
                <div class="sgm-flex sgm-flex-col sgm-gap-2">
                  <label
                    class="sgm-block sgm-text-sm sgm-font-medium sgm-leading-6 sgm-text-gray-900"
                    for="sigmie_search_api_key"
                    >Search-only API key</label
                  >
                  <InputText
                    id="sigmie_search_api_key"
                    v-model="state.search_api_key"
                  />
                  <span class="sgm-text-sm"
                    >Your Sigmie Search-only API key (public).
                  </span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div
        class="sgm-flex sgm-space-y-3 sm:sgm-space-y-0 sm:sgm-space-x-3 sgm-flex-col sm:sgm-flex-row sgm-justify-end sgm-w-full"
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
          :label="recentlySuccessful ? 'Settings Saved' : 'Save Settings'"
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

const { reactive, onMounted, ref } = Vue;
const Dropdown = primevue.dropdown;

const Password = primevue.password;
const InputNumber = primevue.inputnumber;
const InputText = primevue.inputtext;
const RadioButton = primevue.radiobutton;
const SelectButton = primevue.selectbutton;
const InlineMessage = primevue.inlinemessage;
const Button = primevue.button;

const props = defineProps([
  "application_id",
  "admin_api_key",
  "search_api_key",
  "index_prefix",
]);

onMounted(() => {});

const state = reactive({
  application_id: props.application_id,
  admin_api_key: props.admin_api_key,
  search_api_key: props.search_api_key,
  index_prefix: props.index_prefix,
});
</script>

<style>
.p-password-input {
  @apply sgm-w-full;
}
</style>
