<template>
    <div class="text-black py-6">
        <h3 class="-my-3 flow-root pl-10 pr-4">
            <div class="flex w-full items-center justify-between py-3 text-sm  ">
                <span class="font-medium">{{ label }} </span>
                <span class="ml-6 flex items-center">
                    <PlusIcon v-if="!open" class="h-5 w-5" aria-hidden="true" />
                    <MinusIcon v-else class="h-5 w-5" aria-hidden="true" />
                </span>
            </div>
        </h3>
        <div class="pt-6 pl-10 pr-4">
            <div v-if="facets.avg">
                <div class="flex flex-col space-y-3">
                    <div class="flex flex-col space-y-1">
                        <label :for="`filter-min`" class="text-sm ">Min</label>
                        <input :id="`filter-min`" :name="facet" @change="($event) =>
                            onChange(facet, $event.target.checked)
                            " :checked="values.includes(facet)" type="input" class="w-full py-1 px-2 border rounded border-zinc-700  focus:ring-zinc-900" />
                    </div>

                    <div class="flex flex-col space-y-1">
                        <label :for="`filter-max`" class="text-sm ">Max</label>
                        <input :id="`filter-max`" :name="facet" @change="($event) =>
                            onChange(facet, $event.target.checked)
                            " :checked="values.includes(facet)" type="input" class="w-full py-1 px-2 border rounded border-zinc-700  focus:ring-zinc-900" />
                    </div>

                </div>
            </div>
            <div v-else class="space-y-4">
                <div v-for="(count, facet) in facets" :key="facet" class="flex items-center">
                    <input :id="`filter-${facet}`" :name="facet" @change="($event) => onChange(facet, $event.target.checked)
                        " :checked="values.includes(facet)" :value="facet" type="checkbox" class="h-5 w-5 rounded border-gray-700  bg-zinc-800 focus:ring-zinc-900" />
                    <label :for="`filter-${facet}`" class="ml-3 text-sm">{{ facet }} ({{ count }})</label>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {
    Disclosure,
    DisclosureButton,
    DisclosurePanel,
    TransitionChild,
    TransitionRoot,
} from "@headlessui/vue";
import {
    MinusIcon,
    PlusIcon,
} from "@heroicons/vue/20/solid";

export default {
    components: {
        Disclosure,
        DisclosureButton,
        DisclosurePanel,
        TransitionChild,
        TransitionRoot,
        PlusIcon,
        MinusIcon
    },
    emits: ["update:modelValue"],
    props: {
        facets: {
            type: Object,
        },
        label: {
            type: String,
            required: true,
        },
        modelValue: {
            type: Array,
            required: true,
        },
    },
    data() {
        return {
            values: [],
        };
    },
    mounted() {
        this.values = this.modelValue;
    },
    methods: {
        onChange(facet, value) {
            if (value) {
                this.values.push(facet);
            } else {
                this.values = this.values.filter((item) => item !== facet);
            }

            this.$emit("update:modelValue", this.values);
        },
    },
};
</script>
