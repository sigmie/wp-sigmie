<template>
  <div class="">
    <SelectButton
      @update:model-value="onChange"
      :modelValue="values"
      :options="options"
      optionLabel="name"
      multiple
      class=""
      aria-labelledby="multiple"
      unstyled
      :pt="{
        root: {
          class: 'sgm-grid sgm-grid-cols-3 sgm-gap-1 sgm-mt-3',
        },
        button: {
          class: '',
        },
        label: {
          class: 'sgm-text-gray-800 sgm-text-sm',
        },
      }"
    >
      <template #option="slotProps">
        <Button
          :outlined="!values.some((v) => v.value === slotProps.option.value)"
          :severity="
            !values.some((v) => v.value === slotProps.option.value)
              ? 'secondary'
              : 'primary'
          "
          class="sgm-w-full"
        >
          <span class="sgm-w-full sgm-text-center sgm-normal-case">
            {{ slotProps.option.name }}
          </span>
        </Button>
      </template>
    </SelectButton>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from "vue";
import SelectButton from "primevue/selectbutton";
import Button from "primevue/button";

const props = defineProps({
  facets: {},
  modelValue: Array,
});

const emit = defineEmits(["update:modelValue"]);

const values = ref([]);
const options = ref([]);

onMounted(() => {
  options.value = props.facets.map(([facet, count]) => {
    return {
      name: `${facet} (${count})`,
      value: facet,
    };
  });
});

const onChange = (facet) => {
  values.value = facet;

  emit(
    "update:modelValue",
    facet.map((option) => option.value)
  );
};
</script>