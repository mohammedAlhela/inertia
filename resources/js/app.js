
require("./bootstrap");

// Import modules...
import Vue from "vue";
import { App as InertiaApp } from "@inertiajs/inertia-vue";

// Vue.use(Vuetify);

const app = document.getElementById("app");

new Vue({
    render: (h) =>
        h(InertiaApp, {
            props: {
                initialPage: JSON.parse(app.dataset.page),
                resolveComponent: (name) => {
                    let page = require(`./Pages/${name}`).default;

                    return page;
                },
            },
        }),
}).$mount(app);
