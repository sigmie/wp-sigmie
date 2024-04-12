<template>
  <div>Listing {{ state }}</div>
</template>

<script setup>
import { saveSettings, loading } from "./saveSettings.js";

const { reactive, onMounted, ref } = Vue;
const Dropdown = primevue.dropdown;

const InputNumber = primevue.inputnumber;
const InputText = primevue.inputtext;
const RadioButton = primevue.radiobutton;
const SelectButton = primevue.selectbutton;
const InlineMessage = primevue.inlinemessage;
const Button = primevue.button;

const props = defineProps([]);

onMounted(() => {});

const state = reactive({});
</script>
