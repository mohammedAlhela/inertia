<template>
    <section>
        <HeaderPanels :headerData="headerData" />
        <div class="main-holder">
            <div class="account-page">
                <v-form @submit.prevent="store" ref="form">
                    <v-row class="inputs-holder">

                        <div class="upload-image-container">
                            <div class="description">
                                Recomended dimensions are 250 x 250
                            </div>

                            <img :src="getImage" />

                            <div class="upload-holder">
                                <div class="file-holder">
                                    <label for="admin_create_image" class="custom-file-upload">
                                        <v-icon> mdi-pencil </v-icon>
                                    </label>
                                    <input accept="image/*" id="admin_create_image" type="file"
                                        @input="form.image = $event.target.files[0]" @change="imageSelected" />
                                </div>

                                <span class="image-paragraph" v-html="getImageParagraph">
                                </span>

                                <div class="clear" @click="clearImage()" v-if="image.preview">
                                    <v-btn icon color="#645e5e">
                                        <v-icon>mdi-cached</v-icon> </v-btn><span> clear</span>
                                </div>
                            </div>
                        </div>


                        <v-col cols="6" class="py-1">
                            <span class="input-header">
                                First name
                            </span>
                            <v-icon class="important-field-icon"> mdi-star </v-icon>

                            <v-text-field required :rules="formErrors.first_name" solo dense v-model="
                                form.first_name
                            " class="textfield" />
                        </v-col>


                        <v-col cols="6" class="py-1">
                            <span class="input-header">
                                Last name
                            </span>
                            <v-icon class="important-field-icon"> mdi-star </v-icon>

                            <v-text-field required :rules="formErrors.last_name" solo dense v-model="
                                form.last_name
                            " class="textfield" />
                        </v-col>


                        <v-col cols="6" class="py-1">
                            <span class="input-header">
                                Username
                            </span>
                            <v-icon class="important-field-icon"> mdi-star </v-icon>

                            <v-text-field required :rules="formErrors.username" solo dense v-model="
                                form.username
                            " class="textfield" />
                        </v-col>


                        <v-col cols="6" class="py-1">
                            <span class="input-header">
                                Email
                            </span>
                            <v-icon class="important-field-icon"> mdi-star </v-icon>

                            <v-text-field required :rules="formErrors.email" solo dense v-model="
                                form.email
                            " class="textfield" type="email" />
                        </v-col>


                        <v-col cols="6" class="py-1">
                            <span class="input-header">
                                Phone
                            </span>
                            <v-icon class="important-field-icon"> mdi-star </v-icon>

                            <v-text-field required :rules="formErrors.phone" solo dense v-model="
                                form.phone
                            " class="textfield" />
                        </v-col>


                        <v-col cols="6" class="py-1">
                            <span class="input-header">
                                Gender
                            </span>


                            <v-select :items="helper.methods.genders()" required solo dense v-model="
                                form.gender
                            " class="textfield" />
                        </v-col>




                        <v-col cols="6" class="py-1">
                            <span class="input-header">
                                Data of birth
                            </span>


                            <v-text-field type="date" required solo dense v-model="
                                form.birth_date
                            " class="textfield" />
                        </v-col>





                        <v-col cols="6" class="py-1">
                            <span class="input-header">
                                Address
                            </span>

                            <v-textarea required :rules="formErrors.address" solo dense v-model="
                                form.address
                            " class="textfield" />
                        </v-col>
                    </v-row>
                    <div class="buttons">
                        <v-btn :loading="form.processing" type="submit">Add new</v-btn>
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




    computed: {

        headerData() {
            return {
                pageTitle: "Sahara School -- Create new admin",
                title: "Create new admin",

                links: [


                    {
                        icon: "mdi-account-multiple",
                        paragraph: "admins",
                        src: "/admins",
                    },

                    {
                        icon: "mdi-account",
                        paragraph: "Create new admin",
                        src: "/admin/create",
                    }




                ]

            }
        },




        formErrors() {
            return this.helper.methods.formErrors(this.form.errors)
        },


        getImage() {
            return (
                this.image.preview || "/images/main/user.webp"


            );
        },

        getImageParagraph() {
            return this.helper.methods.getImageParagraph(this.form.errors, this.image.name)
        },
    },

    methods: {
        store() {
            this.$refs.form.validate()
            this.form.image = this.image.file;
            this.form.post("/admin/store", {
                forceFormData: true,
                onSuccess: () => {
                    this.helper.methods.fireMessage(
                        "New record added", "success"
                    );
                    this.Inertia.get("/admins");
                },
            });

        },



        imageSelected(element) {
            this.image.file = element.target.files[0];
            this.image.name = element.target.files[0].name;
            let reader = new FileReader();
            reader.readAsDataURL(this.image.file);
            reader.onload = (element) => {
                this.image.preview = element.target.result;
            };
        },

        clearImage() {
            this.image = Object.assign({}, this.defaultImage);
            document.getElementById("admin_create_image").value = "";
        },


    },

    data() {
        return {

            image: {
                file: "",
                name: "",
                preview: "",
            },

            defaultImage: {
                file: "",
                name: "",
                preview: "",
            },
            form: this.$inertia.form({
                id: "",
                user_id: "",
                username: "",
                first_name: "",
                last_name: "",
                gender: "",
                birth_date: "",
                image: "",
                phone: "",
                address: "",
                email: ""




            }),



        };
    },
};
</script>
