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

import {
    ArrowUpIcon,
    ArrowDownIcon,
    MagnifyingGlassIcon,
} from "@heroicons/vue/20/solid";
import { SigmieSearch } from "@sigmie/vue";

let query = ref("");
let input = ref(null);
let hiddenButton = ref(null);
let isOpen = ref(true);
let isWindows = ref(navigator.userAgent.indexOf("Win") !== -1)

function visit(value) {
    console.log(value);
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

        <TransitionRoot appear :show="isOpen" as="template">
            <Dialog as="div" @close="closeModal" class="relative z-50">
                <TransitionChild
                    as="template"
                    enter="duration-300 ease-out"
                    enter-from="opacity-0"
                    enter-to="opacity-100"
                    leave="duration-200 ease-in"
                    leave-from="opacity-100"
                    leave-to="opacity-0"
                >
                    <div
                        class="fixed inset-0 bg-transparent backdrop-filter backdrop-blur"
                    />
                </TransitionChild>

                <div class="fixed inset-x-0 top-5 overflow-y-auto">
                    <div
                        class="flex md:min-h-full items-center justify-center pt-4 bg-white text-center"
                    >
                        <TransitionChild
                            as="template"
                            enter="duration-300 ease-out"
                            enter-from="opacity-0 scale-95"
                            enter-to="opacity-100 scale-100"
                            leave="duration-200 ease-in"
                            leave-from="opacity-100 scale-100"
                            leave-to="opacity-0 scale-95"
                        >
                            <DialogPanel
                                class="w-full transform overflow-hidden transition-all border-b border-zinc-200"
                            >
                                <div class="">
                                    <SigmieSearch
                                        apiKey="cCAsFWccQyyGyCT2hfPILbU0jzAhUEd7AgTw0fkK"
                                        :query="query"
                                        :perPage="5"
                                        :filters="''"
                                        search="nba_players_en"
                                        applicationId="svvhug7c38lsrznsn"
                                        v-slot="{
                                            hits,
                                            total,
                                            loading,
                                            processing_time_ms,
                                        }"
                                    >
                                        <Combobox
                                            @update:modelValue="visit"
                                            v-slot="{ open }"
                                        >
                                            <div
                                                :class="{
                                                    'rounded-lg': open,
                                                    'rounded-t-lg': !open,
                                                }"
                                                class="relative bg-white h-[400px]"
                                            >
                                                <div
                                                    :class="{
                                                        'rounded-lg':
                                                            !open,
                                                        'rounded-t-lg': open,
                                                    }"
                                                    class="relative  w-full cursor-default text-left outline-none focus:outline-none sm:text-sm"
                                                >
                                                    <ComboboxButton
                                                        class="hidden"
                                                    >
                                                        <button
                                                            ref="hiddenButton"
                                                        ></button>
                                                    </ComboboxButton>

                                                    <div class="px-10">
                                                    <ComboboxInput
                                                        autocomplete="off"
                                                        ref="input"
                                                        :class="{
                                                            'rounded-lg': !open,
                                                            'rounded-t-lg':
                                                                open,
                                                        }"
                                                        class="focus:ring-0 bg-transparent w-full outline-none border-none focus:outline-none h-16 px-12 ml-20 md:pr-20 text-xl leading-5  text-zinc-200"
                                                        @change="
                                                            query =
                                                                $event.target
                                                                    .value
                                                        "
                                                    >
                                                    </ComboboxInput>
                                                    </div>
                                                </div>
                                                <TransitionRoot
                                                    leave="transition ease-in duration-100"
                                                    leaveFrom="opacity-100"
                                                    leaveTo="opacity-0"
                                                    @after-leave="query = ''"
                                                >
                                                    <div class="h-full pb-20">
                                                        <ComboboxOptions
                                                            class="relative w-full overflow-auto text-zinc-100 py-1 text-base focus:ring-0 focus:outline-none sm:text-sm"
                                                        >
                                                            <ComboboxOption
                                                                v-for="(
                                                                    hit, index
                                                                ) in Object.values(
                                                                    hits
                                                                )"
                                                                :key="hit._id"
                                                                as="div"
                                                                v-slot="{
                                                                    selected,
                                                                    active,
                                                                }"
                                                                :value="hit"
                                                            >
                                                                <li
                                                                    class="relative cursor-default select-none py-3 px-4 flex flex-col items-center"
                                                                    :class="{
                                                                        'text-zinc-700':
                                                                            active,
                                                                        'text-zinc-400':
                                                                            !active,
                                                                        '':
                                                                            index !==
                                                                            hits.length -
                                                                                1,
                                                                    }"
                                                                >
                                                                    <div
                                                                        class="flex flex-row space-x-4 py-2 items-center w-full"
                                                                        :class="{
                                                                            'font-medium':
                                                                                selected,
                                                                            'font-bold':
                                                                                !selected,
                                                                        }"
                                                                    >
                                                                        <search-box-hit
                                                                            :hit="
                                                                                hit
                                                                            "
                                                                        ></search-box-hit>
                                                                    </div>
                                                                </li>
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

