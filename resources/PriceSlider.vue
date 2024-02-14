<template>
  <div class="sgm-relative sgm-w-full">
    <div
      class="sgm-h-12 sgm-ct-chart sgm-ct-chart-pie sgm-ct-perfect-fourth"
    ></div>
    <div class="sgm-px-2">
      <Slider
        :min="min"
        :max="max"
        :step="1"
        :value="range"
        @update:modelValue="onSliderChange"
        :lazy="false"
        :tooltips="false"
        class="sgm-mt-2"
        :classes="{
          target:
            'sgm-relative sgm-box-border sgm-select-none sgm-touch-none sgm-tap-highlight-transparent sgm-touch-callout-none sgm-disabled:cursor-not-allowed',
          focused: 'sgm-slider-focused',
          tooltipFocus: 'sgm-slider-tooltip-focus',
          tooltipDrag: 'sgm-slider-tooltip-drag',
          ltr: 'sgm-slider-ltr',
          rtl: 'sgm-slider-rtl',
          horizontal: 'sgm-slider-horizontal sgm-h-1.5',
          vertical: 'sgm-slider-vertical sgm-w-1.5 sgm-h-80',
          textDirectionRtl: 'sgm-slider-txt-rtl',
          textDirectionLtr: 'sgm-slider-txt-ltr',
          base: 'sgm-w-full sgm-h-full sgm-relative sgm-z-1 sgm-bg-gray-300 sgm-rounded',
          connects:
            'sgm-w-full sgm-h-full sgm-relative sgm-overflow-hidden sgm-z-0 sgm-rounded',
          connect:
            'sgm-absolute sgm-z-1 sgm-top-0 sgm-right-0 sgm-transform-origin-0 sgm-transform-style-flat sgm-h-full sgm-w-full sgm-bg-gray-500 sgm-cursor-pointer sgm-tap:duration-300 sgm-tap:transition-transform sgm-disabled:bg-gray-400 sgm-disabled:cursor-not-allowed',
          origin:
            'sgm-slider-origin sgm-absolute sgm-z-1 sgm-top-0 sgm-right-0 sgm-transform-origin-0 sgm-transform-style-flat sgm-h-full sgm-w-full sgm-h:h-0 sgm-v:-top-full sgm-txt-rtl-h:left-0 sgm-txt-rtl-h:right-auto sgm-v:w-0 sgm-tap:duration-300 sgm-tap:transition-transform',
          handle:
            'sgm-absolute sgm-rounded-full sgm-bg-white sgm-border-0 sgm-shadow-slider sgm-cursor-grab sgm-focus:outline-none sgm-h:w-4 sgm-h:h-4 sgm-h:-top-1.5 sgm-h:-right-2 sgm-txt-rtl-h:-left-2 sgm-txt-rtl-h:right-auto sgm-v:w-4 sgm-v:h-4 sgm-v:-top-2 sgm-v:-right-1.25 sgm-disabled:cursor-not-allowed sgm-focus:ring sgm-focus:ring-gray-500 sgm-focus:ring-opacity-30',
          handleLower: 'sgm-slider-hande-lower',
          handleUpper: 'sgm-slider-hande-upper',
          touchArea: 'sgm-h-full sgm-w-full',
          tooltip:
            'sgm-absolute sgm-block sgm-text-sm sgm-font-semibold sgm-whitespace-nowrap sgm-py-1 sgm-px-1.5 sgm-min-w-5 sgm-text-center sgm-text-white sgm-rounded sgm-border sgm-border-gray-500 sgm-bg-gray-500 sgm-transform sgm-h:-translate-x-1/2 sgm-h:left-1/2 sgm-v:-translate-y-1/2 sgm-v:top-1/2 sgm-disabled:bg-gray-400 sgm-disabled:border-gray-400 sgm-merge-h:translate-x-1/2 sgm-merge-h:left-auto sgm-merge-v:-translate-x-4 sgm-merge-v:top-auto sgm-tt-focus:hidden sgm-tt-focused:block sgm-tt-drag:hidden sgm-tt-dragging:block',
          tooltipTop: 'sgm-bottom-6 sgm-h:arrow-bottom sgm-merge-h:bottom-3.5',
          tooltipBottom: 'sgm-top-6 sgm-h:arrow-top sgm-merge-h:top-5',
          tooltipLeft: 'sgm-right-6 sgm-v:arrow-right sgm-merge-v:right-1',
          tooltipRight: 'sgm-left-6 sgm-v:arrow-left sgm-merge-v:left-7',
          tooltipHidden: 'sgm-slider-tooltip-hidden',
          active:
            'sgm-slider-active sgm-shadow-slider-active sgm-cursor-grabbing',
          draggable: 'sgm-cursor-ew-resize sgm-v:cursor-ns-resize',
          tap: 'sgm-slider-state-tap',
          drag: 'sgm-slider-state-drag',
        }"
      />
    </div>
    <div
      class="sgm-flex sgm-flex-row sgm-justify-between sgm-items-center sgm-mt-2 sgm-space-x-4"
    >
      <div>
        <label
          for="min-price"
          class="sgm-block sgm-text-sm sgm-font-medium sgm-leading-6 sgm-text-gray-900"
          >Min</label
        >
        <div class="sgm-relative sgm-mt-2 sgm-rounded-md sgm-shadow-sm">
          <InputGroup>
            <InputGroupAddon>$</InputGroupAddon>
            <InputNumber input-id="min-price" v-model="range[0]" />
          </InputGroup>
        </div>
      </div>

      <div>
        <label
          for="max-price"
          class="sgm-block sgm-text-sm sgm-font-medium sgm-leading-6 sgm-text-gray-900"
          >Max</label
        >
        <div class="sgm-relative sgm-mt-2 sgm-rounded-md sgm-shadow-sm">
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
// @import "../node_modules/@vueform/slider/themes/tailwind.scss";
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
  @apply sgm-pl-8;
}
</style>
