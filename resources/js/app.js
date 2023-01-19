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
import { Inertia } from "@inertiajs/inertia";
import { InertiaProgress } from '@inertiajs/progress'
import helper from "../mixins/helper"
import DeleteConfirm from "./Shared/Components/Reusable/DeleteConfirm";
import HeaderPanels from "./Shared/Components/Reusable/HeaderPanels";

InertiaProgress.init({ color: "#7E57C2" });

Vue.prototype.helper = helper
Vue.prototype.Inertia = Inertia




Vue.component("Link", Link);
Vue.component("Head", Head);
Vue.component("DeleteConfirm", DeleteConfirm);
Vue.component("HeaderPanels", HeaderPanels);


Vue.use(InertiaPlugin);

const app = document.getElementById("app");

Vue.use(Vuetify);

new Vue({
    vuetify: new Vuetify({
        theme: {
          themes: {
            light: {
              primary: '#7E57C2',
  
            },
          },
        },
      }),
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
