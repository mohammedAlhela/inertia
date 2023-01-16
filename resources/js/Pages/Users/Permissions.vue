<template>
    <section class="">
        <Head>
            <title>Update permissions</title>
        </Head>

        <form @submit.prevent="update">
            <div class="input-fields-holder">
                <div class="row">
                    <div class="col-3">Modules</div>
                    <div class="col-3">Show</div>
                    <div class="col-3">Write</div>

                    <div class="col-3">Delete</div>
                </div>

                <div class="row" v-for="item in modules" :key="item.module">
                    <div class="col-3">
                        {{ item.module }}
                    </div>

                    <div class="col-3">
                        <input type="checkbox" v-model="item.show" />
                    </div>

                    <div class="col-3" v-if="!item.onlyShow">
                        <input type="checkbox" v-model="item.write" />
                    </div>

                    <div class="col-3" v-if="!item.onlyShow">
                        <input type="checkbox" v-model="item.delete" />
                    </div>
                </div>
            </div>
            <div class="buttons">
                <v-btn
                    color="blue"
                    dark
                    :loading="form.processing"
                    type="submit"
                    >Create new user
                </v-btn>

                <Link href="/users">
                    <v-btn color="blue-grey" class="ma-3 white--text">
                        Discard
                    </v-btn></Link
                >
            </div>
        </form>
    </section>
</template>

<script>
import { Inertia } from "@inertiajs/inertia";
import App from "../../Shared/App.vue";
export default {
    layout: App,
    props: ["user", "permissions"],

    computed: {},

    mounted() {
        const settedmodules = this.modules.map((item) => {
            this.permissions.indexOf(`${item.module}-show`) > -1
                ? (item.show = true)
                : (item.show = false);
            this.permissions.indexOf(`${item.module}-write`) > -1
                ? (item.write = true)
                : (item.write = false);
            this.permissions.indexOf(`${item.module}-delete`) > -1
                ? (item.delete = true)
                : (item.delete = false);
            console.log(settedmodules);
            return settedmodules;
        });
    },

    methods: {
        update() {
            this.handleRequestData();
            this.form.post(`/user/permissions/${this.user.id}`, {
                onSuccess: () => {
                    this.helper.methods.showSuccessMessage(
                        "Permissions Updated"
                    );
                    Inertia.get("/users");
                },
            });
        },

        handleRequestData() {
            for (let i = 0; i < this.modules.length; i++) {
                this.modules[i].show
                    ? this.form.permissionsNames.push(
                          `${this.modules[i].module}-show`
                      )
                    : 1 == 1;
                this.modules[i].write
                    ? this.form.permissionsNames.push(`${this.modules[i].module}-write`)
                    : 1 == 1;
                this.modules[i].delete
                    ? this.form.permissionsNames.push(`${this.modules[i].module}-delete`)
                    : 1 == 1;
            }

            console.log(this.form.permissionsNames);
        },
    },

    data() {
        return {
            modules: [
                {
                    module: "user",
                    write: false,
                    show: false,
                    delete: false,
                },

                {
                    module: "employee",
                    write: false,
                    show: false,
                    delete: false,
                },

                {
                    module: "expense",
                    write: false,
                    show: false,
                    delete: false,
                },

                {
                    module: "deduction",
                    write: false,
                    show: false,
                    delete: false,
                },

                {
                    module: "report",
                    write: false,
                    show: false,
                    delete: false,
                    onlyShow: true,
                },
            ],

            form: this.$inertia.form({
                permissionsNames: [],
            }),
        };
    },
};
</script>
