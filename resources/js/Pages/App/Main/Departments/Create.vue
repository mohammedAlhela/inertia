<template>
    <section>
        <HeaderPanels :headerData="headerData" />
        <div class="main-holder">
            <div class="full-page-card  m-w-800">
                <v-form @submit.prevent="store" ref="form">
                    <v-row class="inputs-holder">


                        <v-col cols="6" class="py-1">
                            <span class="input-header">
                                Name
                            </span>
                            <v-icon class="important-field-icon"> mdi-star </v-icon>

                            <v-text-field required :rules="formErrors.name" solo dense v-model="
                                form.name
                            " class="textfield" />
                        </v-col>


                    </v-row>
                    <div class="buttons">
                        <v-btn :loading="form.processing" type="submit">Create </v-btn>
                        <Link href="/departments" class="text-link"> <v-btn>Discard</v-btn> </Link>
                    </div>
                </v-form>



            </div>
            <div class="clear"></div>
        </div>
    </section>
</template>

<script>

export default {

 


    computed: {


        headerData() {
            return {
                pageTitle: "Sahara School -- Create new department",
                title: "Create new department",

                links: [


                    {
                        icon: "mdi-file-multiple",
                        paragraph: "Departments",
                        src: "/departments",
                    },

                    {
                        icon: "mdi-file",
                        paragraph: "Create new department",
                        src: `/department/create`,
                    }




                ]

            }
        },



        formErrors() {
            return this.helper.methods.formErrors(this.form.errors)
        },

    },

    methods: {
        store() {
            this.$refs.form.validate()
            this.form.post(`/department/store`, {
                forceFormData: true,
                onSuccess: () => {
                    this.helper.methods.fireMessage(
                        "New record added", "success"
                    );
                    this.Inertia.get("/departments");
                },
            });

        },
    },

    data() {
        return {

            form: this.$inertia.form({
                name: "",
            }),



        };
    },
};
</script>
