import './admin.css'

import SearchPage from "@/SearchPage.vue";
import CredentialsPage from "@/CredentialsPage.vue";

document.addEventListener("DOMContentLoaded", function () {

    const { createApp } = Vue

    const backend = createApp({});

    backend.use(primevue.config.default);

    backend.component('search-page', SearchPage);
    backend.component('credentials-page', CredentialsPage);

    backend.mount('#sigmie-admin')
});


