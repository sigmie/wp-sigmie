import { createApp } from 'vue'
import Search from "@/Search.vue";
import Filters from "@/Filters.vue";
import './main.css'

document.addEventListener("DOMContentLoaded", function () {

    const search = createApp({})
    search.component('search', Search);
    search.mount('#sigmie-search')

    const filters = createApp({})
    filters.component('filters', Filters);
    filters.mount('#sigmie-filters')
});
