<template>
  <div class="relative w-full">
    <div class="h-12 ct-chart ct-chart-pie ct-perfect-fourth"></div>
    <div class="px-2">
      <Slider
        :min="min"
        :max="max"
        :step="1"
        :value="range"
        @update:modelValue="onSliderChange"
        :lazy="false"
        :tooltips="false"
        class="mt-2"
        :classes="{
          target:
            'relative box-border select-none touch-none tap-highlight-transparent touch-callout-none disabled:cursor-not-allowed',
          focused: 'slider-focused',
          tooltipFocus: 'slider-tooltip-focus',
          tooltipDrag: 'slider-tooltip-drag',
          ltr: 'slider-ltr',
          rtl: 'slider-rtl',
          horizontal: 'slider-horizontal h-1.5',
          vertical: 'slider-vertical w-1.5 h-80',
          textDirectionRtl: 'slider-txt-rtl',
          textDirectionLtr: 'slider-txt-ltr',
          base: 'w-full h-full relative z-1 bg-gray-300 rounded',
          connects: 'w-full h-full relative overflow-hidden z-0 rounded',
          connect:
            'absolute z-1 top-0 right-0 transform-origin-0 transform-style-flat h-full w-full bg-gray-500 cursor-pointer tap:duration-300 tap:transition-transform disabled:bg-gray-400 disabled:cursor-not-allowed',
          origin:
            'slider-origin absolute z-1 top-0 right-0 transform-origin-0 transform-style-flat h-full w-full h:h-0 v:-top-full txt-rtl-h:left-0 txt-rtl-h:right-auto v:w-0 tap:duration-300 tap:transition-transform',
          handle:
            'absolute rounded-full bg-white border-0 shadow-slider cursor-grab focus:outline-none h:w-4 h:h-4 h:-top-1.5 h:-right-2 txt-rtl-h:-left-2 txt-rtl-h:right-auto v:w-4 v:h-4 v:-top-2 v:-right-1.25 disabled:cursor-not-allowed focus:ring focus:ring-gray-500 focus:ring-opacity-30',
          handleLower: 'slider-hande-lower',
          handleUpper: 'slider-hande-upper',
          touchArea: 'h-full w-full',
          tooltip:
            'absolute block text-sm font-semibold whitespace-nowrap py-1 px-1.5 min-w-5 text-center text-white rounded border border-gray-500 bg-gray-500 transform h:-translate-x-1/2 h:left-1/2 v:-translate-y-1/2 v:top-1/2 disabled:bg-gray-400 disabled:border-gray-400 merge-h:translate-x-1/2 merge-h:left-auto merge-v:-translate-x-4 merge-v:top-auto tt-focus:hidden tt-focused:block tt-drag:hidden tt-dragging:block',
          tooltipTop: 'bottom-6 h:arrow-bottom merge-h:bottom-3.5',
          tooltipBottom: 'top-6 h:arrow-top merge-h:top-5',
          tooltipLeft: 'right-6 v:arrow-right merge-v:right-1',
          tooltipRight: 'left-6 v:arrow-left merge-v:left-7',
          tooltipHidden: 'slider-tooltip-hidden',
          active: 'slider-active shadow-slider-active cursor-grabbing',
          draggable: 'cursor-ew-resize v:cursor-ns-resize',
          tap: 'slider-state-tap',
          drag: 'slider-state-drag',
        }"
      />
    </div>
    <div class="flex flex-row justify-between items-center mt-2 space-x-4">
      <div>
        <label
          for="min-price"
          class="block text-sm font-medium leading-6 text-gray-900"
          >Min</label
        >
        <div class="relative mt-2 rounded-md shadow-sm">
          <InputGroup>
            <InputGroupAddon>$</InputGroupAddon>
            <InputNumber input-id="min-price" v-model="range[0]" />
          </InputGroup>
        </div>
      </div>

      <div>
        <label
          for="max-price"
          class="block text-sm font-medium leading-6 text-gray-900"
          >Max</label
        >
        <div class="relative mt-2 rounded-md shadow-sm">
          <InputGroup>
            <InputGroupAddon>$</InputGroupAddon>
            <InputNumber input-id="max-price" v-model="range[1]" />
          </InputGroup>
        </div>
      </div>
    </div>
  </div>
</template>
<style lang="scss" scoped>
@import "../node_modules/@vueform/slider/themes/tailwind.scss";
</style>

<script setup>
import { onMounted, ref, defineEmits, nextTick, watch } from "vue";
import { BarChart } from "chartist";
import "chartist/dist/index.css";
import Slider from "@vueform/slider";
import InputGroup from "primevue/inputgroup";
import InputGroupAddon from "primevue/inputgroupaddon";
import InputNumber from "primevue/inputnumber";

const props = defineProps({
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
        style: `stroke: ${props.inactiveColor}`,
      });
    } else {
      drawData.element.attr({
        style: `stroke: ${props.activeColor}`,
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

<style scoped>
input[type="text"] {
  @apply pl-8;
}
</style>
