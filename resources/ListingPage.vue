<template>
  <form class="sgm-max-w-2xl">Listing</form>
</template>

<script setup>
import { saveSettings, loading } from "./saveSettings.js";

const { reactive, onMounted, toRefs } = Vue;
const Dropdown = primevue.dropdown;

const InputNumber = primevue.inputnumber;
const InputText = primevue.inputtext;
const RadioButton = primevue.radiobutton;
const SelectButton = primevue.selectbutton;
const InlineMessage = primevue.inlinemessage;
const Button = primevue.button;

const props = defineProps([]);

onMounted(() => {
  // state.language = props.language;
  // state.field_text = props.field_text;
  // state.show_loader = props.show_loader;
  // state.max_height = props.max_height;
  // state.max_width = props.max_width;
  // state.corner_radius = props.corner_radius;
});

const state = reactive({});
</script>
