import './admin.css'
import PrimeVue from "primevue/config";
import Indexing from "@/Indexing.vue";

document.addEventListener("DOMContentLoaded", function () {

    const { createApp } = Vue

    const backend = createApp({});

    backend.use(PrimeVue);
    backend.component('indexing', Indexing)
    backend.mount('#sigmie-backend')
});


