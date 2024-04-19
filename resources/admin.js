import './admin.css'

import FilterablePage from "@/FilterablePage.vue";
import ResultsPage from "@/ResultsPage.vue";
import ListingPage from "@/ListingPage.vue";
import FiltersPage from "@/FiltersPage.vue";
import SearchPage from "@/SearchPage.vue";
import CredentialsPage from "@/CredentialsPage.vue";

document.addEventListener("DOMContentLoaded", function () {

    const { createApp } = Vue

    const backend = createApp({});

    backend.use(primevue.config.default);

    backend.component('search-page', SearchPage);
    backend.component('credentials-page', CredentialsPage);
    backend.component('filterable-page', FilterablePage);
    backend.component('results-page', ResultsPage);
    backend.component('listing-page', ListingPage);
    backend.component('filters-page', FiltersPage);

    backend.mount('#sigmie-admin')
});


