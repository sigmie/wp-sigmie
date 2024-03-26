import { createApp } from 'vue'
import Search from "@/Search.vue";
import Filters from "@/ProductListing.vue";

import './main.css'

import PrimeVue from "primevue/config";

document.addEventListener("DOMContentLoaded", function () {

    //todo check if element exists

    const search = createApp({})
    search.use(PrimeVue);
    search.component('search', Search);
    if (document.getElementById('sigmie-search')) {
        search.mount('#sigmie-search');
    }

    const filters = createApp({})
    filters.use(PrimeVue);
    filters.component('product-listing', Filters);
    if (document.getElementById('sigmie-filters')) {
        filters.mount('#sigmie-filters');
    }
});
