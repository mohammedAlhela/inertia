require("./bootstrap");

// Import modules...
import Vue from "vue";
import {
    App as InertiaApp,
    plugin as InertiaPlugin,
} from "@inertiajs/inertia-vue";
import Vuetify from "vuetify";
import "vuetify/dist/vuetify.min.css";
import "@mdi/font/css/materialdesignicons.css";
import { Link  , Head } from "@inertiajs/inertia-vue";
import App from "../js/Shared/App.vue";
import { InertiaProgress } from '@inertiajs/progress'
import helper from "../mixins/helper"
import DeleteConfirm from "./Shared/components/DeleteConfirm";
InertiaProgress.init()

Vue.prototype.helper = helper
Vue.helper = helper

Vue.component("Link", Link);
Vue.component("Head", Head);
Vue.component("App", App);
Vue.component("DeleteConfirm", DeleteConfirm);

Vue.use(InertiaPlugin);

const app = document.getElementById("app");

Vue.use(Vuetify);

new Vue({
    vuetify: new Vuetify(),
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
