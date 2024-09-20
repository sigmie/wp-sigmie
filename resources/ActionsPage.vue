<template>
  <form class="sgm-flex sgm-flex-col sgm-gap-4 sgm-divide-y">
    <div v-cloak v-if="index" class="sgm-flex sgm-flex-row sgm-justify-between">
      <div
        class="sgm-text-base sgm-leading-7 sgm-text-black sgm-flex sgm-items-center sgm-gap-2 sgm-flex-row"
      >
        <svg
          class="sgm-text-green-700"
          width="24"
          height="24"
          viewBox="0 0 24 24"
          fill="none"
          xmlns="http://www.w3.org/2000/svg"
        >
          <path
            opacity="0.4"
            fill-rule="evenodd"
            clip-rule="evenodd"
            d="M12 2.5C6.762 2.5 2.5 6.761 2.5 12C2.5 17.238 6.762 21.5 12 21.5C17.238 21.5 21.5 17.238 21.5 12C21.5 6.761 17.238 2.5 12 2.5Z"
            fill="currentColor"
          ></path>
          <path
            fill-rule="evenodd"
            clip-rule="evenodd"
            d="M15.993 10.2222L11.375 14.8402C11.228 14.9872 11.037 15.0602 10.845 15.0602C10.652 15.0602 10.461 14.9872 10.314 14.8402L8.00503 12.5312C7.71203 12.2382 7.71203 11.7632 8.00503 11.4702C8.29803 11.1772 8.77203 11.1772 9.06503 11.4702L10.845 13.2492L14.932 9.16116C15.225 8.86816 15.7 8.86816 15.993 9.16116C16.286 9.45416 16.286 9.92916 15.993 10.2222Z"
            fill="currentColor"
          ></path>
        </svg>
        <span class="sgm-text-gray-400">
          {{ index.name }}
        </span>
        <span class="sgm-text-gray-400 sgm-mx-1">/</span>
        <span class="sgm-text-gray-400">
          {{ index.doc_count }} Documents
        </span>
      </div>
    </div>
    <div v-else>
      <h2
        class="sgm-text-base sgm-leading-7 sgm-text-black sgm-flex sgm-items-center sgm-gap-2"
      >
        <svg
          class="sgm-text-gray-400"
          width="24"
          height="25"
          viewBox="0 0 24 24"
          fill="none"
          xmlns="http://www.w3.org/2000/svg"
        >
          <path
            opacity="0.4"
            fill-rule="evenodd"
            clip-rule="evenodd"
            d="M12.25 2.78467C6.874 2.78467 2.5 7.15867 2.5 12.5347C2.5 17.9107 6.874 22.2847 12.25 22.2847C17.626 22.2847 22 17.9107 22 12.5347C22 7.15867 17.626 2.78467 12.25 2.78467Z"
            fill="currentColor"
          ></path>
          <path
            d="M14.6496 15.9849L15.7106 14.9239L13.3106 12.5259L15.7106 10.1309L14.6506 9.06889L12.2496 11.4659L9.84957 9.06689L8.78857 10.1279L11.1876 12.5259L8.78857 14.9209L9.84857 15.9819L12.2486 13.5859L14.6496 15.9849Z"
            fill="currentColor"
          ></path>
        </svg>
        <span>Index not created</span>
      </h2>
    </div>

    <div
      v-for="action in indexActions"
      class="sgm-flex sgm-flex-row sgm-justify-between"
    >
      <div
        class="sgm-flex sgm-flex-row sgm-justify-between sgm-items-center sgm-w-full"
      >
        <div class="sgm-max-w-md">
          <h2
            class="sgm-text-base sgm-font-semibold sgm-leading-7 sgm-text-black"
          >
            {{ action.label }}
          </h2>
          <p class="sgm-mt-1 sgm-text-sm sgm-leading-6 sgm-text-gray-400">
            {{ action.description }}
          </p>
        </div>

        <form class="sgm-flex sgm-items-start md:sgm-col-span-2 sgm-pt-10">
          <Button
            :disabled="action.disabled || indexLoading"
            class="sgm-w-[250px]"
            :label="action.label"
            @click="callAction(action.action)"
          >
          </Button>
        </form>
      </div>
    </div>
  </form>
</template>

<script setup>
import {
  indexAction,
  loading as indexLoading,
  recentlySuccessful as indexRecentlySuccessful,
  recentlyError as indexRecentlyError,
  errorMessage as indexErrorMessage,
} from "./indexAction.js";

const { onMounted, ref, computed } = Vue;

const Button = primevue.button;

const props = defineProps([
  "application_id",
  "admin_api_key",
  "search_api_key",
  "index_prefix",
]);

const index = ref([]);

const callAction = async (action) => {
  await indexAction(action);

  await fetchIndex();
};

const indexActions = computed(() => {
  return [
    {
      label: "Create Index",
      description: "Create a new index for storing documents.",
      disabled: index.value,
      action: "create-index",
      label: "Create Index",
    },
    {
      label: "Populate Index",
      description: "Add documents to the existing index.",
      action: "populate-index",
      disabled: !index.value,
      label: "Populate Index",
    },
    {
      label: "Clear Index",
      description: "Remove all documents from the existing index.",
      disabled: !index.value,
      action: "clear-index",
      label: "Clear Index",
    },
    {
      label: "Delete Index",
      description: "Delete the existing index and all its documents.",
      disabled: !index.value,
      action: "delete-index",
      label: "Delete Index",
    },
  ];
});

const fetchIndex = async () => {
  index.value = (await indexAction("list-indices"))[0] ?? null;
};

onMounted(async () => {
  await fetchIndex();
});
</script>

<style>
.p-password-input {
  @apply sgm-w-full;
}
</style>
