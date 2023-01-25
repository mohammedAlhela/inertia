<template>
    <section>
        <HeaderPanels :headerData="headerData" />
        <div class="main-holder">
            <div class="account-page">
                <v-form @submit.prevent="update" ref="form">
                    <v-row class="fields-container">
                        <div class="row permission-header">
                            <div class="col-3">
                                Modules
                            </div>

                            <div class="col-9 row">
                                <div class="col-3">
                                    Show
                                </div>
                                <div class="col-3">
                                    store
                                </div>

                                <div class="col-3">
                                    update
                                </div>

                                <div class="col-3">
                                    Delete
                                </div>
                            </div>
                        </div>

                        <div class="row" v-for="item in modules" :key="item.module">

                            <div class="col-3 ">
                                {{ item.module }}
                            </div>


                            <div class="col-9 row">
                                <div class="col-3">
                                    <v-checkbox class="" color="primary" hide-details v-model="item.show">
                                    </v-checkbox>
                                </div>

                                <div class="col-3">
                                    <v-checkbox class="" color="primary" hide-details v-model="item.store">
                                    </v-checkbox>
                                </div>

                                <div class="col-3">
                                    <v-checkbox class="" color="primary" hide-details v-model="item.update">
                                    </v-checkbox>
                                </div>


                                <div class="col-3">
                                    <v-checkbox class="" color="primary" hide-details v-model="item.delete">
                                    </v-checkbox>
                                </div>

                            </div>


                        </div>

                    </v-row>
                    <div class="buttons">
                        <v-btn :loading="form.processing" type="submit">Update</v-btn>
                        <Link href="/admins" class="text-link"> <v-btn>Discard</v-btn> </Link>
                    </div>
                </v-form>
            </div>
            <div class="clear"></div>
        </div>




    </section>
</template>


<script>


export default {




    props: {
        admin: Object,
        permissionsNames: Array

    },

    mounted() {
        const settedmodules = this.modules.map((item) => {
            this.permissionsNames.indexOf(`${item.module}-show`) > -1
                ? (item.show = true)
                : (item.show = false);

            this.permissionsNames.indexOf(`${item.module}-store`) > -1
                ? (item.store = true)
                : (item.store = false);

            this.permissionsNames.indexOf(`${item.module}-update`) > -1
                ? (item.update = true)
                : (item.update = false);

            this.permissionsNames.indexOf(`${item.module}-delete`) > -1
                ? (item.delete = true)
                : (item.delete = false);
            return settedmodules;
        });


    },

    data() {
        return {
            modules: [
                {
                    module: "admin",
                    store: false,
                    update: false,
                    show: false,
                    delete: false,
                },

                {
                    module: "company",
                    store: false,
                    update: false,
                    show: false,
                    delete: false,
                }
            ],

            form: this.$inertia.form({
                permissionsNames: []
            }),



        };
    },


    computed: {

        headerData() {
            return {
                pageTitle: "Sahara School -- Update admin permissions",
                title: "Update admin permissions",

                links: [


                    {
                        icon: "mdi-account-multiple",
                        paragraph: "admins",
                        src: "/admins",
                    },

                    {
                        icon: "mdi-eye",
                        paragraph: "Update admin permissions",
                        src: `/admin/permissions/${this.admin.id}`,
                    }




                ]

            }
        },
    },

    methods: {

        calculatePermissionsNames() {
            for (let i = 0; i < this.modules.length; i++) {
                this.modules[i].show
                    ? this.form.permissionsNames.push(
                        `${this.modules[i].module}-show`
                    )
                    : 1 == 1;
                this.modules[i].store
                    ? this.form.permissionsNames.push(
                        `${this.modules[i].module}-store`
                    )
                    : 1 == 1;
                this.modules[i].update
                    ? this.form.permissionsNames.push(
                        `${this.modules[i].module}-update`
                    )

                    : 1 == 1;
                this.modules[i].delete
                    ? this.form.permissionsNames.push(
                        `${this.modules[i].module}-delete`
                    )
                    : 1 == 1;
            }
        },

        update() {

            this.calculatePermissionsNames()

            this.form.post(`/admin/permissions/${this.admin.id}`, {

                onSuccess: () => {
                    this.Inertia.get("/admins");
                },
            });

        },

    }
}

</script>
