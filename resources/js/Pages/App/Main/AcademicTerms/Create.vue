<template>
    <section>
        <HeaderPanels :headerData="headerData" />
        <div class="main-holder">
            <div class="full-page-card">
                <v-form @submit.prevent="store" ref="form">
                    <v-row class="inputs-holder">

                        <v-col cols="6" class="py-1">
                            <span class="input-header">
                                Academic year
                            </span>
                            <v-icon class="important-field-icon"> mdi-star </v-icon>


                            <v-autocomplete required :rules="formErrors.academic_year_id" :items="academicYears" solo
                                dense item-text="name" item-value="id" class="textfield"
                                v-model="form.academic_year_id" />
                        </v-col>

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
                        <Link href="/academicTerms" class="text-link"> <v-btn>Discard</v-btn> </Link>
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
        academicYears: Array
    },


    computed: {


        headerData() {
            return {
                pageTitle: "Sahara School -- Create new academic term",
                title: "Create new academic term",

                links: [


                    {
                        icon: "mdi-file-multiple",
                        paragraph: "Academic terms",
                        src: "/academicTerms",
                    },

                    {
                        icon: "mdi-file",
                        paragraph: "Create new academic term",
                        src: `/academicTerm/create`,
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
            this.form.post(`/academicTerm/store`, {
                forceFormData: true,
                onSuccess: () => {
                    this.helper.methods.fireMessage(
                        "New record added", "success"
                    );
                    this.Inertia.get("/academicTerms");
                },
            });

        },
    },

    data() {
        return {

            form: this.$inertia.form({
                academic_year_id: "",
                name: "",
                end_date: "",
                start_date: "",
            }),



        };
    },
};
</script>
