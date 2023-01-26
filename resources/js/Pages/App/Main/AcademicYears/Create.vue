<template>
    <section>
        <HeaderPanels :headerData="headerData" />
        <div class="main-holder">
            <div class="full-page-card">
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


                        <v-col cols="6" class="py-1">
                            <span class="input-header">
                                Start Date
                            </span>
                            <v-icon class="important-field-icon"> mdi-star </v-icon>

                            <v-text-field type="date" required :rules="formErrors.start_date" solo dense v-model="
                                form.start_date
                            " class="textfield" />
                        </v-col>


                        <v-col cols="6" class="py-1">
                            <span class="input-header">
                                End date
                            </span>
                            <v-icon class="important-field-icon"> mdi-star </v-icon>

                            <v-text-field type="date" required :rules="formErrors.end_date" solo dense v-model="
                                form.end_date
                            " class="textfield" />
                        </v-col>


                    </v-row>
                    <div class="buttons">
                        <v-btn :loading="form.processing" type="submit">Create </v-btn>
                        <Link href="/academicYears" class="text-link"> <v-btn>Discard</v-btn> </Link>
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
                pageTitle: "Sahara School -- Create new academic year",
                title: "Create new academic year",

                links: [


                    {
                        icon: "mdi-file-multiple",
                        paragraph: "Academic years",
                        src: "/academicYears",
                    },

                    {
                        icon: "mdi-file",
                        paragraph: "Create new academic year",
                        src: `/academicYear/create`,
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
            this.form.post(`/academicYear/store`, {
                forceFormData: true,
                onSuccess: () => {
                    this.helper.methods.fireMessage(
                        "New record added", "success"
                    );
                    this.Inertia.get("/academicYears");
                },
            });

        },
    },

    data() {
        return {

            form: this.$inertia.form({
                name: "",
                end_date: "",
                start_date: "",
            }),



        };
    },
};
</script>
