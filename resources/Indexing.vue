<template>
  <div>This is Vue mounted!</div>
</template>

<script setup>
const { onMounted } = Vue;

onMounted(() => {
  console.log("demo32");
});
</script>

<style></style>
