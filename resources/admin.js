import 'primevue/resources/themes/aura-light-blue/theme.css'
import './admin.css'

import PrimeVue from "primevue/config";
import Indexing from "@/Indexing.vue";
import SearchSettings from "@/SearchSettings.vue";

document.addEventListener("DOMContentLoaded", function () {

    const { createApp } = Vue

    const backend = createApp({});

    backend.use(PrimeVue);
    backend.component('indexing', Indexing)
    backend.component('search-settings', SearchSettings)
    backend.mount('#sigmie-backend')
});


