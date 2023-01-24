<template>
    <section>
        <HeaderPanels :headerData="headerData" />
        <div class="main-holder">
            <div class="account-panesl-page">
                <div @click="toggleForm('account')" :class = "{active_link:accountPanel}">
                    <v-icon>mdi-pencil</v-icon> Update Profile
                </div>
                <div @click="toggleForm('password')" :class = "{active_link:!accountPanel}">
                    <v-icon>mdi-lock</v-icon> Update Credentials
                </div>

            </div>
            <div class="account-page">
                <v-form @submit.prevent="update" v-if="accountPanel" ref="accountForm">
                    <v-row class="inputs-holder">

                        <div class="upload-image-container">
                            <div class="description">
                                Recomended dimensions are 250 x 250
                            </div>

                            <img :src="getImage" />

                            <div class="upload-holder">
                                <div class="file-holder">
                                    <label for="account_image" class="custom-file-upload">
                                        <v-icon> mdi-pencil </v-icon>
                                    </label>
                                    <input accept="image/*" id="account_image" type="file"
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

                            <v-text-field required :rules="accountErrors.first_name" solo dense v-model="
                                form.first_name
                            " class="textfield" />
                        </v-col>


                        <v-col cols="6" class="py-1">
                            <span class="input-header">
                                Last name
                            </span>
                            <v-icon class="important-field-icon"> mdi-star </v-icon>

                            <v-text-field required :rules="accountErrors.last_name" solo dense v-model="
                                form.last_name
                            " class="textfield" />
                        </v-col>


                        <v-col cols="6" class="py-1">
                            <span class="input-header">
                                Username
                            </span>
                            <v-icon class="important-field-icon"> mdi-star </v-icon>

                            <v-text-field required :rules="accountErrors.username" solo dense v-model="
                                form.username
                            " class="textfield" />
                        </v-col>


                        <v-col cols="6" class="py-1">
                            <span class="input-header">
                                Phone
                            </span>
                            <v-icon class="important-field-icon"> mdi-star </v-icon>

                            <v-text-field required :rules="accountErrors.phone" solo dense v-model="
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

                            <v-textarea required :rules="accountErrors.address" solo dense v-model="
                                form.address
                            " class="textfield" />
                        </v-col>
                    </v-row>
                    <div class="buttons">
                        <v-btn :loading="form.processing" type="submit">Update</v-btn>
                    </div>
                </v-form>


                <v-form @submit.prevent="updateCredentials" v-if="credentialsPanel" ref="credentialsForm">
                    <v-row class="inputs-holder">

                        <v-col cols="12" class="py-1">
                            <span class="input-header">
                                email
                            </span>
                            <v-icon class="important-field-icon"> mdi-star </v-icon>
                            <v-text-field :rules="credentialsErrors.email" required solo dense v-model="
                                credentials.email
                            " class="textfield" type="email" />
                        </v-col>

                        <v-col cols="12" class="py-1">
                            <v-checkbox
                                label="Logout from all active sessions (except the current login session on this device)"
                                v-model="credentials.logoutFromSessions" color="deep-purple lighten-1" hide-details />
                        </v-col>

                        <v-col cols="12" class="py-5">
                            <v-checkbox label="Change password" v-model="credentials.updatePassword"
                                color="deep-purple lighten-1" hide-details @click="resetCredentialsValidation()" />
                        </v-col>

                        <div v-if="credentials.updatePassword">


                            <v-col cols="12" class="py-1">
                                <span class="input-header">
                                    Old Password
                                </span>
                                <v-icon class="important-field-icon"> mdi-star </v-icon>
                                <v-text-field :rules="credentialsErrors.old_password"
                                    :type="oldPasswordType ? 'text' : 'password'"
                                    :append-icon="oldPasswordType ? 'mdi-eye' : 'mdi-eye-off'"
                                    @click:append="oldPasswordType = !oldPasswordType" required solo dense v-model="
                                        credentials.old_password
                                    " class="textfield" />
                            </v-col>

                            <v-col cols="12" class="py-1">
                                <span class="input-header">
                                    New Password
                                </span>
                                <v-icon class="important-field-icon"> mdi-star </v-icon>
                                <v-text-field :rules="credentialsErrors.password"
                                    :type="passwordType ? 'text' : 'password'"
                                    :append-icon="passwordType ? 'mdi-eye' : 'mdi-eye-off'"
                                    @click:append="passwordType = !passwordType" required solo dense v-model="
                                        credentials.password
                                    " class="textfield" />
                            </v-col>

                            <v-col cols="12" class="py-1">
                                <span class="input-header">
                                    New Password Confirmation
                                </span>
                                <v-icon class="important-field-icon">
                                    mdi-star </v-icon>
                                <v-text-field :rules="credentialsErrors.password_confirmation"
                                    :type="passwordConfirmationType ? 'text' : 'password'"
                                    :append-icon="passwordConfirmationType ? 'mdi-eye' : 'mdi-eye-off'"
                                    @click:append="passwordConfirmationType = !passwordConfirmationType" required solo
                                    dense v-model="
                                        credentials.password_confirmation
                                    " class="textfield" />
                            </v-col>

                        </div>


                    </v-row>
                    <div class="buttons">
                        <v-btn :loading="credentials.processing" type="submit">Update </v-btn>
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
        user: Object,
        email: String,
    },

    mounted() {
        this.helper.methods.handleServerData(this.form, this.user)
        this.credentials.email = this.email
    },

    computed: {

        accountErrors() {
            return this.helper.methods.formErrors(this.form.errors)
        },

        credentialsErrors() {
            return this.helper.methods.formErrors(this.credentials.errors)
        },

        getImage() {
            return (
                this.image.preview ||
                this.user.image ||
                "images/admins/admin.webp"
            );
        },

        getImageParagraph() {
            return this.helper.methods.getImageParagraph(this.form.errors, this.image.name)
        },
    },

    methods: {
        update() {
            this.$refs.accountForm.validate()
            this.form.image = this.image.file;
            this.form.post("/account", {
                forceFormData: true,
                onSuccess: () => {
                    this.helper.methods.fireMessage(
                        "Account updated", "success"
                    );
                    this.Inertia.get("/account");
                },
            });

        },


        resetCredentialsValidation() {
            if (this.credentials.updatePassword == true) {
                this.credentials.reset('old_password', 'password', 'password_confirmation')
            }
        },
        updateCredentials() {
            this.$refs.credentialsForm.validate()
            this.credentials.user_id = this.user.user_id;


            console.log(this.user.user_id)
            this.credentials.post("/account/credentials", {
                onSuccess: () => {
                    this.helper.methods.fireMessage(
                        "Credentials updated", "success"
                    );

                    this.credentials.reset('old_password', 'password', 'password_confirmation')
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
            document.getElementById("account_image").value = "";
        },

        toggleForm(key) {
            if (key == 'account') {
                this.accountPanel = true
                this.credentialsPanel = false
            }

            else {
                this.accountPanel = false
                this.credentialsPanel = true
            }
        }
    },

    data() {
        return {
            headerData: {
                pageTitle: "Sahara School -- Manage Account",
                title: "Manage Account",
                add: {
                    src: "",
                    paragraph: "",
                    visibility: false
                },

                link: {
                    icon: "mdi-account",
                    paragraph: "manage Account",
                    src: "/account"
                }

            },

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




            }),

            credentials: this.$inertia.form({
                old_password: "",
                password: "",
                password_confirmation: "",
                logoutFromSessions: "",
                updatePassword: "",
                email: ""
            }),

            oldPasswordType: "password",
            passwordType: "password",
            passwordConfirmationType: "password",

            accountPanel: true,
            credentialsPanel: false,



        };
    },
};
</script>
