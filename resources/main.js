import { createApp } from 'vue'
// import Search from "@/Search.vue";
import Filters from "@/ProductListing.vue";

import './main.css'

import PrimeVue from "primevue/config";

document.addEventListener("DOMContentLoaded", function () {

    const search = createApp({})
    search.use(PrimeVue);
    search.component('search', Search);
    search.mount('#sigmie-search')

    const filters = createApp({})
    filters.use(PrimeVue);
    filters.component('product-listing', Filters);
    filters.mount('#sigmie-filters')
});
