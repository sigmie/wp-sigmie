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
    index: String,
    nothingFoundText: String,
    sortBy: String,
    numberOfResults: Number,
    maxDescriptionLength: Number,
    resultsDisplay: String,
    showCategory: Boolean,
    showDescription: Boolean,
    showPrice: Boolean,
    showRating: Boolean,
    showSku: Boolean,
    showStock: Boolean,
    showOnSale: Boolean
})
let query = ref("");
let input = ref(null);
let hiddenButton = ref(null);
let isOpen = ref(false);
let isWindows = ref(navigator.userAgent.indexOf("Win") !== -1)

function visit(url) {
    closeModal();
    window.location.href = url;
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

function slugify(str) {
    return String(str)
        .normalize('NFKD') // split accented characters into their base characters and diacritical marks
        .replace(/[\u0300-\u036f]/g, '') // remove all the accents, which happen to be all in the \u03xx UNICODE block.
        .trim() // trim leading or trailing whitespace
        .toLowerCase() // convert to lowercase
        .replace(/[^a-z0-9 -]/g, '') // remove non-alphanumeric characters
        .replace(/\s+/g, '-') // replace spaces with hyphens
        .replace(/-+/g, '-'); // remove consecutive hyphens
}

function addKeydownListener() {
    document.addEventListener("keydown", handleKeyDown);
}

function removeKeydownListener() {
    document.removeEventListener("keydown", handleKeyDown);
}

onMounted(() => {
    console.log(props);
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
                                    <SigmieSearch facets="categories" :debounceMs="250" :apiKey="props.apiKey" deb :query="query" :perPage="20" :filters="''" :search="props.index" :applicationId="props.application" v-slot="{
                                        hits,
                                        facets,
                                        total,
                                        loading,
                                        processing_time_ms,
                                    }">
                                        <Combobox @update:modelValue="visit" v-slot="{ open }">
                                            <div :class="{
                                                'rounded-lg': open,
                                                'rounded-t-lg': !open,
                                            }" class="relative bg-white">
                                                <div :class="{
                                                    'rounded-lg':
                                                        !open,
                                                    'rounded-t-lg': open,
                                                }" class="relative  w-full cursor-default text-left outline-none focus:outline-none sm:text-sm">
                                                    <ComboboxButton class="hidden">
                                                        <button ref="hiddenButton"></button>
                                                    </ComboboxButton>

                                                    <div class="w-full flex items-center justify-between px-10">
                                                        <a href="http://wordpress.test/" class="" rel="home">
                                                            <img class="w-16" src="http://wordpress.test/wp-content/uploads/2024/01/cropped-elevated-circle.png" alt="WordPress" decoding="async" srcset="http://wordpress.test/wp-content/uploads/2024/01/cropped-elevated-circle.png 550w, http://wordpress.test/wp-content/uploads/2024/01/cropped-elevated-circle-300x300.png 300w, http://wordpress.test/wp-content/uploads/2024/01/cropped-elevated-circle-150x150.png 150w, http://wordpress.test/wp-content/uploads/2024/01/cropped-elevated-circle-350x350.png 350w, http://wordpress.test/wp-content/uploads/2024/01/cropped-elevated-circle-100x100.png 100w" sizes="(max-width: 550px) 100vw, 550px" />
                                                        </a>
                                                        <div class="max-w-3xl mx-auto py-4">
                                                            <ComboboxInput autocomplete="off" ref="input" :class="{
                                                                '': !open,
                                                                '':
                                                                    open,
                                                            }" class="ring-0 h-10 mx-auto p-2 bg-transparent w-full outline-none border-none focus:outline-none px-12 text-md leading-3 text-zinc-400" :displayValue="() => query" @change="
    query =
    $event.target
        .value
    ">
                                                            </ComboboxInput>
                                                        </div>

                                                        <div>
                                                            <svg @click="closeModal" class="h-10 w-10 text-zinc-800 cursor-pointer" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path d="M6 6L18 18" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                                                <path d="M18 6L6 18" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                                            </svg>
                                                        </div>
                                                    </div>
                                                </div>
                                                <TransitionRoot leave="transition ease-in duration-100" leaveFrom="opacity-100" leaveTo="opacity-0" @after-leave="query = ''">
                                                    <div class="flex flex-row pt-10">
                                                        <div class="flex flex-col w-1/3 max-h-[800px] overflow-y-scroll">

                                                            <ComboboxOptions role="list" class="px-2 py-3 font-medium text-gray-900 flex flex-col space-y-2">
                                                                <li class="mb-4">
                                                                    <h4 class="px-10 text-lg font-semibold leading-7 text-zinc-900 text-left">Top Categories</h4>
                                                                </li>
                                                                <ComboboxOption v-for="(count, category) in facets.categories" :key="category" class="" v-slot="{
                                                                    selected,
                                                                    active,
                                                                }" :value="`/product-category/${slugify(category)}`">
                                                                    <div class="flex flex-row justify-between items-center px-10 h-10 cursor-pointer" :class="(active || selected) ? 'bg-zinc-100' : ''">
                                                                        <span>
                                                                            {{ category }}
                                                                        </span>
                                                                        <span class="text-zinc-400">
                                                                            {{ count }}
                                                                        </span>
                                                                    </div>
                                                                </ComboboxOption>
                                                            </ComboboxOptions>


                                                        </div>
                                                        <div class="h-full pb-20 px-12 w-2/3 max-h-[800px] overflow-y-scroll">
                                                            <div v-if="loading">
                                                                <svg aria-hidden="true" class="md:w-10 md:h-10 h-6 w-6 text-zinc-600 animate-spin fill-zinc-200" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                    <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor" />
                                                                    <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill" />
                                                                </svg>

                                                                <span class="sr-only">Loading...</span>
                                                            </div>
                                                            <ComboboxOptions v-else class="mt-6 grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-4 xl:gap-x-8">
                                                                <ComboboxOption v-for="(
                                                                    hit, index
                                                                ) in Object.values(
                                                                    hits
                                                                )" :key="hit._id" as="div" v-slot="{
    selected,
    active,
}" :value="`product/${hit.slug}`">
                                                                    <Hit :hit="hit" :active="active" :selected="selected"></Hit>
                                                                </ComboboxOption>
                                                            </ComboboxOptions>
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

