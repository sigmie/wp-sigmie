<template>
  <div>
    <div
      class="sgm-hidden sm:sgm-block sgm-bg-black sgm-text-white sgm-rounded-md sgm-my-4"
    >
      <nav class="sgm-flex sgm-space-x-4 sgm-py-2 sgm-px-3" aria-label="Tabs">
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
</template>

<script setup>
const { onMounted, ref } = Vue;

const props = defineProps(["tabs", "modelValue"]);

const emit = defineEmits(["update:modelValue"]);

const tabs = ref([]);

onMounted(() => {
  tabs.value = props.tabs.map((item) => {
    return { ...item, current: false };
  });

  tabs.value[0].current = true;
});

const selectTab = (index) => {
  tabs.value.forEach((tab, i) => {
    tab.current = i === index;
  });

  emit("update:modelValue", tabs.value[index].key);
};
</script>
