<template>
  <div class="card flex justify-content-center">
    <p-dropdown
      :options="cities"
      optionLabel="name"
      placeholder="Select a City"
      class="w-full md:w-14rem"
    />
  </div>
</template>

<script setup>
const { ref } = Vue;

const selectedCity = ref();
const cities = ref([
  { name: "New York", code: "NY" },
  { name: "Rome", code: "RM" },
  { name: "London", code: "LDN" },
  { name: "Istanbul", code: "IST" },
  { name: "Paris", code: "PRS" },
]);
</script>
