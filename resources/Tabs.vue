<template>
  <TabMenu
  class="sgm-my-4"
    :model="tabs"
    :activeIndex="activeIndex"
    @tab-change="onTabChange"
  ></TabMenu>
</template>

<script setup>
const { onMounted, ref, watch } = Vue;

const TabMenu = primevue.tabmenu;

const props = defineProps(["tabs", "modelValue"]);

const emit = defineEmits(["update:modelValue"]);

const activeIndex = ref(0);

const tabs = ref([]);

onMounted(() => {
  tabs.value = props.tabs.map((tab, index) => {
    return {
      label: tab.name,
      icon: tab.icon || "pi pi-circle-off",
      command: () => {
        activeIndex.value = index;
        emit("update:modelValue", tab.key);
      },
    };
  });
});

watch(
  () => props.modelValue,
  (newVal) => {
    const tabIndex = tabs.value.findIndex((tab) => tab.key === newVal);
    if (tabIndex !== -1) {
      activeIndex.value = tabIndex;
    }
  }
);

const onTabChange = (e) => {
  emit("update:modelValue", props.tabs[e.index].key);
};
</script>

<style>
a:focus {
  @apply sgm-shadow-none;
}
dd,
li {
  @apply sgm-mb-0;
}
</style>
