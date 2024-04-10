import './admin.css'

import Indexing from "@/Indexing.vue";
import SearchSettings from "@/SearchSettings.vue";

document.addEventListener("DOMContentLoaded", function () {

    const { createApp } = Vue

    const backend = createApp({});

    backend.use(primevue.config.default);

    backend.component('indexing', Indexing)
    backend.component('search-settings', SearchSettings)
    backend.mount('#sigmie-backend')
});


