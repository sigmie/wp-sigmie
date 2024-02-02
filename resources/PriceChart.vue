<template>
  <div class="absolute top-100">
    <div class="h-52" id="sigmie-price-chart"></div>
  </div>
</template>

<script setup>
import { BarChart } from "chartist";
import { onMounted } from "vue";

const props = defineProps({
  min: Number,
  max: Number,
  histogram: Object,
});

onMounted(() => {
  new BarChart("#sigmie-price-chart", {
    labels: ["", "", "", "", ""],
    series: [[1, 2, 4, 8, 20]],
  });
});
</script>
