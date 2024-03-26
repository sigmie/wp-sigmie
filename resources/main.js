import { createApp } from 'vue'
import Search from "@/Search.vue";
import Filters from "@/ProductListing.vue";

import './main.css'

import PrimeVue from "primevue/config";

import NumberFacet from "./NumberFacet.vue";
import CheckboxFacet from "./CheckboxFacet.vue";
import SelectbuttonFacet from "./SelectbuttonFacet.vue";
import ColorFacet from "./ColorFacet.vue";

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

    filters.component('number-facet', NumberFacet);
    filters.component('checkbox-facet', CheckboxFacet);
    filters.component('selectbutton-facet', SelectbuttonFacet);
    filters.component('color-facet', ColorFacet);

    if (document.getElementById('sigmie-filters')) {
        filters.mount('#sigmie-filters');
    }
});
