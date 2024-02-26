<template>
  <div class="sgm-relative sgm-w-full">
    <span class="sgm-block sgm-text-base sgm-font-semibold sgm-text-gray-900">
      {{ label }}
    </span>
    <div
      class="sgm-flex sgm-flex-row sgm-justify-between sgm-items-center sgm-mt-2 sgm-space-x-4"
    >
      <div>
        <div
          class="sgm-relative sgm-mt-2 sgm-rounded-md sgm-shadow-sm sgm-font-normal"
        >
          <InputGroup>
            <InputGroupAddon>{{ currency }}</InputGroupAddon>
            <InputNumber input-id="min-price" v-model="range[0]" />
          </InputGroup>
        </div>
      </div>

      <div>
        <div
          class="sgm-relative sgm-mt-2 sgm-rounded-md sgm-shadow-sm sgm-font-normal"
        >
          <InputGroup>
            <InputGroupAddon>{{ currency }}</InputGroupAddon>
            <InputNumber input-id="max-price" v-model="range[1]" />
          </InputGroup>
        </div>
      </div>
    </div>
    <div class="sgm-mt-5">
      <div
        v-if="showChart"
        class="sgm-h-12 ct-chart sgm-ct-chart-pie sgm-ct-perfect-fourth"
      ></div>
      <div class="sgm-px-2">
        <Slider
          :range="true"
          :min="min"
          :max="max"
          :step="1"
          :modelValue="range"
          @update:modelValue="onSliderChange"
          class="sgm-mt-2"
        />
      </div>
    </div>
  </div>
</template>

<script setup>
import { onMounted, ref, defineEmits, nextTick, watch } from "vue";
import { BarChart } from "chartist";
import "chartist/dist/index.css";
import InputGroup from "primevue/inputgroup";
import InputGroupAddon from "primevue/inputgroupaddon";
import InputNumber from "primevue/inputnumber";
import Slider from "primevue/slider";

const props = defineProps({
  label: {
    type: String,
    required: true,
  },
  currency: {
    type: String,
    required: true,
  },
  showChart: {
    type: Boolean,
    required: true,
  },
  currencyPosition: {
    type: String,
    required: true,
  },
  histogram: {
    type: Object,
    required: true,
  },
  min: {
    type: Number,
    required: true,
  },
  max: {
    type: Number,
    required: true,
  },
  range: {
    type: Array,
    required: true,
  },
  data: Object,
  activeColor: {
    type: String,
    default: "#8384d8",
  },
  inactiveColor: {
    type: String,
    default: "#e6eaf9",
  },
});

const emit = defineEmits(["update:range", "range:inited"]);

const min = ref(-1);
const max = ref(-1);
const chart = ref();
const chartCreated = ref(false);

const data = ref({
  labels: [],
  series: [[]],
});

watch(
  () => props.range,
  (newRange, oldRange) => {
    chart.value.update(data.value);
  }
);

async function onSliderChange(value) {
  emit("update:range", value);

  await nextTick();

  chart.value.update(data.value);
}

function createChart() {
  let options = {
    showPoint: false,
    showLine: false,
    showArea: true,
    fullWidth: true,
    showLabel: false,
    axisX: {
      showGrid: false,
      showLabel: false,
      offset: 0,
    },
    axisY: {
      showGrid: false,
      showLabel: false,
      offset: 0,
    },
    chartPadding: 0,
    low: 0,
  };

  let responsiveOptions = [
    [
      "screen and (max-width: 640px)",
      {
        seriesBarDistance: 0,
        axisX: {
          labelInterpolationFnc: function (value) {
            return value[0];
          },
        },
      },
    ],
  ];

  chart.value = new BarChart(
    ".ct-chart",
    data.value,
    options,
    responsiveOptions
  );

  chart.value.on("draw", function (drawData) {
    if (drawData.type === "bar" && !chartCreated.value) {
      drawData.element.animate({
        y2: {
          begin: 0,
          dur: 500,
          from: drawData.y1,
          to: drawData.y2,
          easing: "easeOutQuart",
        },
      });
    }

    if (drawData.index === Object.values(props.histogram).length - 1) {
      chartCreated.value = true;
    }

    const label = data.value.labels[drawData.index];

    if (parseInt(label) < props.range[0] || parseInt(label) > props.range[1]) {
      drawData.element.attr({
        style: `stroke: var(--primary-100)`,
      });
    } else {
      drawData.element.attr({
        style: `stroke: var(--primary-300)`,
      });
    }
  });
}

onMounted(() => {
  const labels = Object.keys(props.histogram);

  min.value = props.min;
  max.value = props.max;

  emit("range:inited", [props.min, props.max]);

  data.value.series[0] = Object.values(props.histogram);
  data.value.labels = labels;

  createChart();
});
</script>

<style scoped lang="scss">
input[type="text"] {
  @apply sgm-pl-8;
}
</style>
