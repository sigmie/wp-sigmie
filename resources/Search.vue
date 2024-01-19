<script setup>
import { ref, onMounted, onUnmounted, nextTick } from "vue";
import {
    TransitionRoot,
    TransitionChild,
    Dialog,
    DialogPanel,
    Combobox,
    ComboboxInput,
    ComboboxButton,
    ComboboxOptions,
    ComboboxOption,
} from "@headlessui/vue";

import { SigmieSearch } from "@sigmie/vue";
import Hit from "@/Hit.vue"

let props = defineProps({
    application: String,
    apiKey: String,
    index: String
})
let query = ref("");
let input = ref(null);
let hiddenButton = ref(null);
let isOpen = ref(false);
let isWindows = ref(navigator.userAgent.indexOf("Win") !== -1)

function visit(hit) {
    window.location.href = `product/${hit.slug}`;
}

function handleKeyDown(e) {
    // On Esc
    if (e.keyCode === 27) {
        // input?.value?.blur();
    }

    // On CMD + K or CTRL + K
    if ((e.keyCode === 75 && e.metaKey) || (e.keyCode === 75 && e.ctrlKey)) {
        e.preventDefault();
        openModal(true);
    }
}

function closeModal() {
    isOpen.value = false;
}

function openModal() {
    isOpen.value = true;

    nextTick(() => {
        hiddenButton.value.focus();
        hiddenButton.value.click();
    });
}

function addKeydownListener() {
    document.addEventListener("keydown", handleKeyDown);
}

function removeKeydownListener() {
    document.removeEventListener("keydown", handleKeyDown);
}

onMounted(() => {
    addKeydownListener();
});

onUnmounted(() => {
    removeKeydownListener();
});
</script>

<template>
    <div class="container flex flex-wrap items-center justify-between mx-auto">

        <button @click="openModal" class="fowcus:ring-0 mt-10 max-w-xl mx-auto flex flex-row justify-between text-zinc-400 w-full border backdrop-filter backdrop-blur bg-zinc-100/30 rounded-lg items-center px-2 py-1">
            <div class="text-zinc-100 text-lg tracking-wide">
                Start typing to check it out...
            </div>
            <div class="flex flex-row items-center space-x-2">
                <div class="px-2 py-1 flex flex-row items-center text-zinc-400 space-x-3 text-xs">
                    <svg width="24px" height="24px" viewBox="0 0 24 24" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                        <g stroke="currentColor" stroke-width="1.5" fill="none" fill-rule="evenodd" stroke-linecap="round" stroke-linejoin="round">
                            <g transform="translate(2.000000, 2.000000)" stroke="currentColor" stroke-width="1.5">
                                <circle id="Ellipse_739" cx="9.76659044" cy="9.76659044" r="8.9885584"></circle>
                                <line x1="16.0183067" y1="16.4851259" x2="19.5423342" y2="20.0000001" id="Line_181" opacity="0.400000006"></line>
                            </g>
                        </g>
                    </svg>
                </div>
            </div>
        </button>

        <TransitionRoot appear :show="isOpen" as="template">
            <Dialog as="div" @close="closeModal" class="relative z-50">
                <TransitionChild as="template" enter="duration-300 ease-out" enter-from="opacity-0" enter-to="opacity-100" leave="duration-200 ease-in" leave-from="opacity-100" leave-to="opacity-0">
                    <div class="fixed inset-0 bg-transparent backdrop-filter backdrop-blur" />
                </TransitionChild>

                <div class="fixed inset-x-0 top-5 overflow-y-auto">
                    <div class="flex md:min-h-full items-center justify-center pt-4 bg-white text-center">
                        <TransitionChild as="template" enter="duration-300 ease-out" enter-from="opacity-0 scale-95" enter-to="opacity-100 scale-100" leave="duration-200 ease-in" leave-from="opacity-100 scale-100" leave-to="opacity-0 scale-95">
                            <DialogPanel class="w-full transform overflow-hidden transition-all border-b border-zinc-200">
                                <div class="">
                                    <SigmieSearch :apiKey="props.apiKey" :query="query" :perPage="5" :filters="''" :search="props.index" :applicationId="props.application" v-slot="{
                                        hits,
                                        total,
                                        loading,
                                        processing_time_ms,
                                    }">
                                        <Combobox @update:modelValue="visit" v-slot="{ open }">
                                            <div :class="{
                                                'rounded-lg': open,
                                                'rounded-t-lg': !open,
                                            }" class="relative bg-white h-[400px]">
                                                <div :class="{
                                                    'rounded-lg':
                                                        !open,
                                                    'rounded-t-lg': open,
                                                }" class="relative  w-full cursor-default text-left outline-none focus:outline-none sm:text-sm">
                                                    <ComboboxButton class="hidden">
                                                        <button ref="hiddenButton"></button>
                                                    </ComboboxButton>

                                                    <div class="px-10">
                                                        <ComboboxInput autocomplete="off" ref="input" :class="{
                                                            'rounded-lg': !open,
                                                            'rounded-t-lg':
                                                                open,
                                                        }" class="focus:ring-0 bg-transparent w-full outline-none border-none focus:outline-none h-16 px-12 ml-20 md:pr-20 text-xl leading-5  text-zinc-200" @change="
    query =
    $event.target
        .value
    ">
                                                        </ComboboxInput>
                                                    </div>
                                                </div>
                                                <TransitionRoot leave="transition ease-in duration-100" leaveFrom="opacity-100" leaveTo="opacity-0" @after-leave="query = ''">
                                                    <div class="h-full pb-20 px-12">
                                                        <ComboboxOptions class="relative w-full flex flex-col space-y-5 overflow-auto text-zinc-100 py-1 text-base focus:ring-0 focus:outline-none sm:text-sm">
                                                            <ComboboxOption v-for="(
                                                                    hit, index
                                                                ) in Object.values(
                                                                    hits
                                                                )" :key="hit._id" as="div" v-slot="{
    selected,
    active,
}" :value="hit">
                                                                <Hit :hit="hit" :active="active" :selected="selected"></Hit>
                                                            </ComboboxOption>
                                                        </ComboboxOptions>
                                                    </div>
                                                </TransitionRoot>
                                            </div>
                                        </Combobox>
                                    </SigmieSearch>
                                </div>
                            </DialogPanel>
                        </TransitionChild>
                    </div>
                </div>
            </Dialog>
        </TransitionRoot>
    </div>
</template>

