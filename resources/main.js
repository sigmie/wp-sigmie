import { createApp } from 'vue'
import Search from "@/Search.vue";
import './main.css'

document.addEventListener("DOMContentLoaded", function () {

    const app = createApp({})

    app.component('search', Search);

    app.mount('#sigmie')
});
