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
let isOpen = ref(false);
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
        <button
            @click="openModal"
            class="border-transparent focus:border-transparent focus:ring-0 mt-10 max-w-xl mx-auto flex flex-row justify-between text-zinc-400 w-full border border-zinc-900 backdrop-filter backdrop-blur bg-zinc-900/30 rounded-lg items-center px-4 py-3 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-zinc-400 shadow-lg shadow-orange-500/20"
        >
            <div class="text-zinc-600 text-lg tracking-wide">
                Start typing to check it out...
            </div>
            <div class="flex flex-row items-center space-x-2">
                <div
                    class="px-2 py-1 flex flex-row items-center space-x-3 rounded-md text-zinc-200 border-zinc-700 font-semibold text-xs shadow bg-zinc-900"
                >
                    <svg
                    v-if="!isWindows"
                        fill="currentColor"
                        class="h-4 w-auto"
                        version="1.1"
                        xmlns="http://www.w3.org/2000/svg"
                        xmlns:xlink="http://www.w3.org/1999/xlink"
                        viewBox="0 0 80 80"
                        xml:space="preserve"
                    >
                        <g>
                            <path
                                d="M64,48L64,48h-8V32h8c8.836,0,16-7.164,16-16S72.836,0,64,0c-8.837,0-16,7.164-16,16v8H32v-8c0-8.836-7.164-16-16-16   S0,7.164,0,16s7.164,16,16,16h8v16h-8l0,0l0,0C7.164,48,0,55.164,0,64s7.164,16,16,16c8.837,0,16-7.164,16-16l0,0v-8h16v7.98   c0,0.008-0.001,0.014-0.001,0.02c0,8.836,7.164,16,16,16s16-7.164,16-16S72.836,48.002,64,48z M64,8c4.418,0,8,3.582,8,8   s-3.582,8-8,8h-8v-8C56,11.582,59.582,8,64,8z M8,16c0-4.418,3.582-8,8-8s8,3.582,8,8v8h-8C11.582,24,8,20.417,8,16z M16,72   c-4.418,0-8-3.582-8-8s3.582-8,8-8l0,0h8v8C24,68.418,20.418,72,16,72z M32,48V32h16v16H32z M64,72c-4.418,0-8-3.582-8-8l0,0v-8   h7.999c4.418,0,8,3.582,8,8S68.418,72,64,72z"
                            />
                        </g>
                    </svg>
                    <span class="text-xl text-zinc-400 font-normal" v-else>
                        Ctrl
                    </span>
                    <span class="text-xl"> K </span>
                </div>
            </div>
        </button>

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
                        class="flex md:min-h-full items-center justify-center py-4 md:p-4 text-center"
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
                                class="w-full max-w-7xl transform overflow-hidden shadow-xl transition-all"
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
                                                class="relative bg-zinc-950/95"
                                            >
                                                <div
                                                    :class="{
                                                        'rounded-lg border':
                                                            !open,
                                                        'rounded-t-lg': open,
                                                    }"
                                                    class="relative border-zinc-700 w-full cursor-default text-left outline-none focus:outline-none sm:text-sm"
                                                >
                                                    <ComboboxButton
                                                        class="hidden"
                                                    >
                                                        <button
                                                            ref="hiddenButton"
                                                        ></button>
                                                    </ComboboxButton>

                                                    <ComboboxInput
                                                        autocomplete="off"
                                                        ref="input"
                                                        :class="{
                                                            'rounded-lg': !open,
                                                            'rounded-t-lg':
                                                                open,
                                                        }"
                                                        class="focus:ring-0 bg-transparent w-full outline-none border-none focus:outline-none h-16 py-3 px-12 md:pl-20 md:pr-20 text-xl leading-5 text-zinc-200"
                                                        @change="
                                                            query =
                                                                $event.target
                                                                    .value
                                                        "
                                                    >
                                                    </ComboboxInput>

                                                    <ComboboxButton
                                                        class="absolute inset-y-0 left-0 flex flex-row items-center pl-3 text-zinc-800 text-sm"
                                                    >
                                                        <div v-if="loading">
                                                            <svg
                                                                aria-hidden="true"
                                                                class="md:w-10 md:h-10 h-6 w-6 text-zinc-800 animate-spin fill-zinc-200"
                                                                viewBox="0 0 100 101"
                                                                fill="none"
                                                                xmlns="http://www.w3.org/2000/svg"
                                                            >
                                                                <path
                                                                    d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                                                                    fill="currentColor"
                                                                />
                                                                <path
                                                                    d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                                                                    fill="currentFill"
                                                                />
                                                            </svg>

                                                            <span
                                                                class="sr-only"
                                                                >Loading...</span
                                                            >
                                                        </div>
                                                        <div v-else>
                                                            <MagnifyingGlassIcon
                                                                class="md:w-10 md:h-10 h-6 w-6 text-zinc-300"
                                                            ></MagnifyingGlassIcon>
                                                        </div>
                                                    </ComboboxButton>
                                                    <ComboboxButton
                                                        class="absolute inset-y-0 right-0 flex items-center pr-4 text-zinc-300 text-sm"
                                                    >
                                                        <div v-if="open">
                                                            <div
                                                                class="px-3 py-2 hidden md:block rounded-md text-zinc-100 border-zinc-700 font-semibold text-xs shadow bg-black"
                                                            >
                                                                <span
                                                                    class="text-lg"
                                                                >
                                                                    ESC
                                                                </span>
                                                            </div>
                                                            <div
                                                                class="px-3 py-2 md:hidden rounded-md text-zinc-100 border-zinc-700 font-semibold text-xs shadow bg-black"
                                                            >
                                                                <span
                                                                    class="text-lg"
                                                                >
                                                                    CLOSE
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <div
                                                            v-else
                                                            class="flex flex-row items-center space-x-2"
                                                        >
                                                            <div
                                                                class="bg-black md:flex hidden px-2 py-1 flex-row items-center space-x-3 rounded-md text-zinc-200 border-zinc-700 font-semibold text-xs shadow"
                                                            >
                                                                <svg
                                                                    fill="currentColor"
                                                                    class="h-4 w-auto"
                                                                    version="1.1"
                                                                    xmlns="http://www.w3.org/2000/svg"
                                                                    xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                    viewBox="0 0 80 80"
                                                                    xml:space="preserve"
                                                                >
                                                                    <g>
                                                                        <path
                                                                            d="M64,48L64,48h-8V32h8c8.836,0,16-7.164,16-16S72.836,0,64,0c-8.837,0-16,7.164-16,16v8H32v-8c0-8.836-7.164-16-16-16   S0,7.164,0,16s7.164,16,16,16h8v16h-8l0,0l0,0C7.164,48,0,55.164,0,64s7.164,16,16,16c8.837,0,16-7.164,16-16l0,0v-8h16v7.98   c0,0.008-0.001,0.014-0.001,0.02c0,8.836,7.164,16,16,16s16-7.164,16-16S72.836,48.002,64,48z M64,8c4.418,0,8,3.582,8,8   s-3.582,8-8,8h-8v-8C56,11.582,59.582,8,64,8z M8,16c0-4.418,3.582-8,8-8s8,3.582,8,8v8h-8C11.582,24,8,20.417,8,16z M16,72   c-4.418,0-8-3.582-8-8s3.582-8,8-8l0,0h8v8C24,68.418,20.418,72,16,72z M32,48V32h16v16H32z M64,72c-4.418,0-8-3.582-8-8l0,0v-8   h7.999c4.418,0,8,3.582,8,8S68.418,72,64,72z"
                                                                        />
                                                                    </g>
                                                                </svg>
                                                                <span
                                                                    class="text-lg"
                                                                >
                                                                    K
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </ComboboxButton>
                                                </div>
                                                <div
                                                    v-if="open"
                                                    class="flex flex-row space-x-2 bg-zinc-800 w-full py-2 px-4"
                                                >
                                                    <div
                                                        class="text-white hidden md:block rounded-full bg-black px-4 py-2"
                                                    >
                                                        Processing time
                                                        {{ processing_time_ms }}
                                                        milliseconds
                                                    </div>
                                                    <div
                                                        class="text-white md:hidden rounded-full bg-black px-4 py-2"
                                                    >
                                                        {{
                                                            processing_time_ms
                                                        }}ms
                                                    </div>
                                                    <div
                                                        class="text-white hidden md:block rounded-full bg-black px-4 py-2"
                                                    >
                                                        Total
                                                        {{
                                                            total.toLocaleString()
                                                        }}
                                                        records found
                                                    </div>

                                                    <div
                                                        class="text-white md:hidden rounded-full bg-black px-4 py-2"
                                                    >
                                                        {{
                                                            total.toLocaleString()
                                                        }}
                                                        Records
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
                                                            class="relative max-h-[700px] w-full overflow-auto text-zinc-100 py-1 text-base shadow-lg focus:ring-0 focus:outline-none sm:text-sm"
                                                        >
                                                            <div
                                                                v-if="
                                                                    query !==
                                                                        '' &&
                                                                    total === 0
                                                                "
                                                                class="border-t border-zinc-700 relative cursor-default select-none py-2 px-4 text-zinc-400 h-72 space-y-10 flex flex-col justify-center items-center text-lg"
                                                            >
                                                                <div
                                                                    class="mx-auto"
                                                                >
                                                                    <svg
                                                                        class="h-20"
                                                                        viewBox="0 0 20 20"
                                                                        fill="none"
                                                                        fill-rule="evenodd"
                                                                        stroke="currentColor"
                                                                        stroke-linecap="round"
                                                                        stroke-linejoin="round"
                                                                    >
                                                                        <path
                                                                            d="M15.5 4.8c2 3 1.7 7-1 9.7h0l4.3 4.3-4.3-4.3a7.8 7.8 0 01-9.8 1m-2.2-2.2A7.8 7.8 0 0113.2 2.4M2 18L18 2"
                                                                        ></path>
                                                                    </svg>
                                                                </div>

                                                                <div
                                                                    class="mx-auto"
                                                                >
                                                                    <div
                                                                        class="w-56 text-center text-xl"
                                                                    >
                                                                        No
                                                                        results
                                                                        for
                                                                        "<span
                                                                            class="text-zinc-400 font-medium"
                                                                            >{{
                                                                                query
                                                                            }}</span
                                                                        >"
                                                                    </div>
                                                                </div>
                                                            </div>

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
                                                                        'bg-zinc-800/30 text-zinc-100':
                                                                            active,
                                                                        'text-zinc-400':
                                                                            !active,
                                                                        'border-b border-zinc-700':
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

                                                        <div
                                                            class="absolute rounded-b-lg bottom-0 h-21 w-full px-4 py-2 flex flex-row justify-between items-center border-t border-zinc-700"
                                                        >
                                                            <div
                                                                class="flex flex-col md:flex-row items-center md:space-x-2"
                                                            >
                                                                <div
                                                                    class="flex flex-row space-x-2"
                                                                >
                                                                    <div
                                                                        class="p-1 md:px-3 md:py-2 rounded-md text-zinc-700 border-zinc-700 font-semibold text-xs shadow bg-black"
                                                                    >
                                                                        <ArrowUpIcon
                                                                            class="text-zinc-100 md:w-10 md:h-10 h-6 w-6"
                                                                        ></ArrowUpIcon>
                                                                    </div>
                                                                    <div
                                                                        class="p-1 md:px-3 md:py-2 rounded-md text-zinc-100 border-zinc-700 font-semibold text-xs shadow bg-black"
                                                                    >
                                                                        <ArrowDownIcon
                                                                            class="text-zinc-100 md:w-10 md:h-10 h-6 w-6"
                                                                        ></ArrowDownIcon>
                                                                    </div>
                                                                </div>
                                                                <div
                                                                    className="text-zinc-500 pl-1 text-xl"
                                                                >
                                                                    to navigate
                                                                </div>
                                                            </div>

                                                            <div
                                                                class="flex flex-col md:flex-row items-center md:space-x-2"
                                                            >
                                                                <div
                                                                    class="p-1 md:px-3 md:py-2 text-md md:text-xl rounded-md text-zinc-100 border-zinc-700 font-semibold shadow bg-black"
                                                                >
                                                                    ESC
                                                                </div>
                                                                <div
                                                                    className="text-zinc-500 pl-1 text-xl"
                                                                >
                                                                    to close
                                                                </div>
                                                            </div>

                                                            <div
                                                                class="flex flex-col md:flex-row items-center md:space-x-2"
                                                            >
                                                                <div
                                                                    class="p-1 md:px-3 md:py-2 rounded-md text-zinc-100 border-zinc-700 font-semibold text-md md:text-xl shadow bg-black"
                                                                >
                                                                    ENTER
                                                                </div>

                                                                <div
                                                                    className="text-zinc-500 pl-1 text-xl"
                                                                >
                                                                    to visit
                                                                </div>
                                                            </div>
                                                        </div>
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

