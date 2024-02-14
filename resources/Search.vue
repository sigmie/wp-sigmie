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
    searchFieldText: String,
    showLoader: Boolean,
    searchFieldHeight: Number,
    searchFieldWidth: Number,
    cornerRadius: Number,
    showCategories: Boolean,

    nothingFoundText: String,
    sortBy: String,
    numberOfResults: Number,
    numberOfCategories: Number,

    application: String,
    apiKey: String,
    index: String,

    maxDescriptionLength: Number,
    showCategory: Boolean,
    showDescription: Boolean,
    showPrice: Boolean,
    showRating: Boolean,
    showSku: Boolean,
    showStock: Boolean,
    showOnSale: Boolean,
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

    console.log(JSON.parse(JSON.stringify(props)));
    addKeydownListener();
});

onUnmounted(() => {
    removeKeydownListener();
});
</script>

<template>
    <div class="sgm-container sgm-flex sgm-flex-wrap sgm-items-center sgm-justify-between sgm-mx-auto">

        <button :style="{
            height: searchFieldHeight + 'px',
            width: searchFieldWidth + 'px',
            borderRadius: cornerRadius + 'px',
        }" @click="openModal" class="sgm-focus:ring-0 sgm-mt-10 sgm-max-w-xl sgm-mx-auto sgm-flex sgm-flex-row sgm-justify-between sgm-text-zinc-900 sgm-w-full sgm-border sgm-backdrop-filter sgm-backdrop-blur sgm-bg-zinc-100/30 sgm-items-center sgm-px-2 sgm-py-1">
            <div class="sgm-text-zinc-500 sgm-text-lg sgm-tracking-wide sgm-font-light sgm-font-sm">
                {{ searchFieldText }}
            </div>
            <div class="sgm-flex sgm-flex-row sgm-items-center sgm-space-x-2">
                <div class="sgm-px-2 sgm-py-1 sgm-flex sgm-flex-row sgm-items-center sgm-text-zinc-400 sgm-space-x-3 sgm-text-xs">
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
            <Dialog as="div" @close="closeModal" class="sgm-relative sgm-z-50">
                <TransitionChild as="template" enter="sgm-duration-300 sgm-ease-out" enter-from="sgm-opacity-0" enter-to="sgm-opacity-100" leave="sgm-duration-200 sgm-ease-in" leave-from="sgm-opacity-100" leave-to="sgm-opacity-0">
                    <div class="sgm-fixed sgm-inset-0 sgm-bg-transparent sgm-backdrop-filter sgm-backdrop-blur" />
                </TransitionChild>

                <div class="sgm-fixed sgm-inset-x-0 sgm-top-5 sgm-overflow-y-auto">
                    <div class="sgm-flex sgm-md:min-h-full sgm-items-center sgm-justify-center sgm-pt-4 sgm-bg-white sgm-text-center">
                        <TransitionChild as="template" enter="sgm-duration-300 sgm-ease-out" enter-from="sgm-opacity-0 sgm-scale-95" enter-to="sgm-opacity-100 sgm-scale-100" leave="sgm-duration-200 sgm-ease-in" leave-from="sgm-opacity-100 sgm-scale-100" leave-to="sgm-opacity-0 sgm-scale-95">
                            <DialogPanel class="sgm-w-full sgm-transform sgm-overflow-hidden sgm-transition-all sgm-border-b sgm-border-zinc-200">
                                <div class="">
                                    <SigmieSearch :facets="`categories:${numberOfCategories}`" :debounceMs="250" :apiKey="props.apiKey" :sort="sortBy" :query="query" :perPage="numberOfResults" :filters="''" :search="props.index" :applicationId="props.application" v-slot="{
                                        hits,
                                        facets,
                                        total,
                                        loading,
                                        processing_time_ms,
                                    }">

                                        <Combobox @update:modelValue="visit" v-slot="{ open }">
                                            <div :class="{
                                                'sgm-rounded-lg': open,
                                                'sgm-rounded-t-lg': !open,
                                            }" class="sgm-relative sgm-bg-white">
                                                <div :class="{
                                                    'sgm-rounded-lg':
                                                        !open,
                                                    'sgm-rounded-t-lg': open,
                                                }" class="sgm-relative  sgm-w-full sgm-cursor-default sgm-text-left sgm-outline-none sgm-focus:outline-none sgm-sm:text-sm">
                                                    <ComboboxButton class="sgm-hidden">
                                                        <button ref="hiddenButton"></button>
                                                    </ComboboxButton>

                                                    <div class="sgm-w-full sgm-flex sgm-items-center sgm-justify-between sgm-px-10">
                                                        <a href="http://wordpress.test/" class="" rel="home">
                                                            <img class="sgm-w-16" src="http://wordpress.test/wp-content/uploads/2024/01/cropped-elevated-circle.png" alt="WordPress" decoding="async" srcset="http://wordpress.test/wp-content/uploads/2024/01/cropped-elevated-circle.png 550w, http://wordpress.test/wp-content/uploads/2024/01/cropped-elevated-circle-300x300.png 300w, http://wordpress.test/wp-content/uploads/2024/01/cropped-elevated-circle-150x150.png 150w, http://wordpress.test/wp-content/uploads/2024/01/cropped-elevated-circle-350x350.png 350w, http://wordpress.test/wp-content/uploads/2024/01/cropped-elevated-circle-100x100.png 100w" sizes="(max-width: 550px) 100vw, 550px" />
                                                        </a>
                                                        <div class="sgm-max-w-3xl sgm-mx-auto sgm-py-4 sgm-flex sgm-flex-row sgm-items-center">
                                                            <!-- <svg class="sgm-h-4 sgm-w-4" viewBox="0 0 24 24" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                                                <g stroke="currentColor" stroke-width="1.5" fill="none" fill-rule="evenodd" stroke-linecap="round" stroke-linejoin="round">
                                                                    <g transform="translate(2.000000, 2.000000)" stroke="currentColor" stroke-width="1.5">
                                                                        <circle id="Ellipse_739" cx="9.76659044" cy="9.76659044" r="8.9885584"></circle>
                                                                        <line x1="16.0183067" y1="16.4851259" x2="19.5423342" y2="20.0000001" id="Line_181" opacity="0.400000006"></line>
                                                                    </g>
                                                                </g>
                                                            </svg> -->
                                                            <ComboboxInput autocomplete="off" ref="input" :class="{
                                                                '': !open,
                                                                '':
                                                                    open,
                                                            }" class="sgm-ring-0 sgm-h-10 sgm-mx-auto sgm-p-2 sgm-w-full sgm-outline-none sgm-border-none sgm-focus:outline-none sgm-px-12 sgm-text-md sgm-leading-3 sgm-text-zinc-400" :displayValue="() => query" @change="
    query =
    $event.target
        .value
    ">
                                                            </ComboboxInput>
                                                        </div>

                                                        <div>
                                                            <svg @click="closeModal" class="sgm-h-10 sgm-w-10 sgm-text-zinc-800 sgm-cursor-pointer" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path d="M6 6L18 18" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                                                <path d="M18 6L6 18" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                                            </svg>
                                                        </div>
                                                    </div>
                                                </div>
                                                <TransitionRoot leave="sgm-transition sgm-ease-in sgm-duration-100" leaveFrom="sgm-opacity-100" leaveTo="sgm-opacity-0" @after-leave="query = ''">

                                                    <div class="sgm-mx-auto sgm-max-w-7xl sgm-w-full sgm-flex sgm-flex-col sgm-items-center sgm-h-56" v-if="total === 0 && !loading">

                                                        <svg class="sgm-h-12 sgm-w-12" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M21 12C21 16.9704 16.971 20.9995 12.0005 20.9995C7.03005 20.9995 3 16.9704 3 12C3 7.0295 7.03005 3.00049 12.0005 3.00049" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                                            <path d="M15.2832 9.05715H18.1253M15.2832 5.58887H20.9683" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                                            <path d="M17.585 19.1182L21.3446 22.879" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                                        </svg>

                                                        <div class="sgm-pb-10 sgm-pt-6">
                                                            {{ nothingFoundText }}
                                                        </div>
                                                    </div>
                                                    <div v-else class="sgm-flex sgm-flex-row sgm-pt-10">
                                                        <div v-if="showCategories" :class="{
                                                            'sgm-w-1/3': showCategories
                                                        }" class="sgm-flex sgm-flex-col  sgm-max-h-[800px] sgm-overflow-y-scroll">

                                                            <ComboboxOptions role="list" class="sgm-px-2 sgm-py-3 sgm-font-medium sgm-text-gray-900 sgm-flex sgm-flex-col sgm-space-y-2">
                                                                <ComboboxOption v-for="(count, category) in facets.categories" :key="category" class="" v-slot="{
                                                                    selected,
                                                                    active,
                                                                }" :value="`/product-category/${slugify(category)}`">
                                                                    <div class="sgm-flex sgm-flex-row sgm-justify-between sgm-items-center sgm-px-10 sgm-h-10 sgm-cursor-pointer" :class="(active || selected) ? 'sgm-bg-zinc-100' : ''">
                                                                        <span>
                                                                            {{ category }}
                                                                        </span>
                                                                        <span class="sgm-text-zinc-400">
                                                                            {{ count }}
                                                                        </span>
                                                                    </div>
                                                                </ComboboxOption>
                                                            </ComboboxOptions>


                                                        </div>
                                                        <div :class="{
                                                            'sgm-w-2/3': showCategories,
                                                            'sgm-w-full': !showCategories
                                                        }" class="sgm-h-full sgm-pb-20 sgm-px-12 sgm-max-h-[800px] sgm-overflow-y-scroll">
                                                            <div v-if="loading && showLoader">
                                                                <svg aria-hidden="true" class="sgm-md:w-10 sgm-md:h-10 sgm-h-6 sgm-w-6 sgm-text-zinc-600 sgm-animate-spin sgm-fill-zinc-200" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                    <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor" />
                                                                    <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill" />
                                                                </svg>

                                                                <span class="sgm-sr-only">Loading...</span>
                                                            </div>
                                                            <ComboboxOptions v-else :class="{
                                                                'sgm-grid-cols-1 sgm-sm:grid-cols-3 sgm-lg:grid-cols-6': !showCategories,
                                                                'sgm-grid-cols-1 sgm-sm:grid-cols-2 sgm-lg:grid-cols-4': showCategories,
                                                            }" class="sgm-mt-6 sgm-grid sgm-gap-x-6 sgm-gap-y-10 sgm-xl:gap-x-8">
                                                                <ComboboxOption v-for="(
                                                                    hit, index
                                                                ) in Object.values(
                                                                    hits
                                                                )" :key="hit._id" as="div" v-slot="{
    selected,
    active,
}" :value="`product/${hit.slug}`">
                                                                    <Hit 
                                                                    :showDescription="showDescription"
                                                                    :showRating="showRating"
                                                                    :showSku="showSku"
                                                                    :showStock="showStock"
                                                                    :showOnSale="showOnSale"
                                                                    
                                                                    :showCategory="showCategory"
                                                                    :showPrice="showPrice"
                                                                    :max-description-length="maxDescriptionLength" :hit="hit" :active="active" :selected="selected"></Hit>
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


<style>
input[type="text"] {
    border-radius: 0px !important;
    border-width: 0px 0px 0px 0px !important;
}
</style>
