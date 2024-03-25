<template>
  <!-- <ColorFacet></ColorFacet>

  <SelectbuttonFacet
    v-if="selectbuttonFacets.split(',').includes(key)"
    :facets="sortedFacetValues(key, facets[key])"
    :modelValue="filterVals[key]"
    @update:model-value="(value) => onTermChange(key, value)"
  >
  </SelectbuttonFacet>

  <CheckboxFacet
    v-else-if="checkboxFacets.split(',').includes(key)"
    :label="filterLabels[key] ?? key"
    :facets="sortedFacetValues(key, facets[key])"
    :modelValue="filterVals[key]"
    @update:model-value="(value) => onTermChange(key, value)"
  >
  </CheckboxFacet>
  <NumberFacet
    v-else-if="rangeFacets.split(',').includes(key)"
    :show-chart="showPriceRangeChart"
    :currency="currencySymbol"
    :label="priceRangeLabel"
    :min="0"
    :max="facets.price_as_number?.max"
    :range="priceRange"
    @update:range="onRangeChange"
    @range:inited="onRangeInit"
    :histogram="facets.price_as_number?.histogram"
  >
  </NumberFacet> -->
</template>

<style scoped></style>

<script setup>
const props = defineProps(["modelValue", "type", "options", "facets", "label"]);
const emit = defineEmits(["update:modelValue"]);

const sortedFacetValues = (key, facets) => {
  if (!props.sortedAttributes[key]) {
    return Object.entries(facets);
  }

  let res = [];

  for (let val of props.sortedAttributes[key]) {
    if (facets[val]) {
      res.push([val, facets[val]]);
    }
  }

  return res;
};
</script>
