<template>
    <section>
        <HeaderPanels :headerData="headerData" />
        <div class="main-holder">
            <div class="paner-section">
                <div @click="toggleForm('account')">
                    <v-icon>mdi-pencil</v-icon> Update Profile
                </div>
                <div @click="toggleForm('password')">
                    <v-icon>mdi-lock</v-icon> Update Password
                </div>

            </div>
            <div class="main-content">





                <v-form @submit.prevent="update" v-if="accountPanel" ref="accountForm">
                    <v-row class="inputs-holder">


                        <div class="upload-image-container">
                            <div class="description">
                                Recomended dimensions are 100 x 100
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
                                Email
                            </span>
                            <v-icon class="important-field-icon"> mdi-star </v-icon>

                            <v-text-field required :rules="accountErrors.email" solo dense v-model="
                                form.email
                            " class="textfield" />
                        </v-col>

                        <v-col cols="6" class="py-1">
                            <span class="input-header">
                                username
                            </span>
                            <v-icon class="important-field-icon"> mdi-star </v-icon>

                            <v-text-field required :rules="accountErrors.username" solo dense v-model="
                                form.username
                            " class="textfield" />
                        </v-col>

                        <v-col cols="6" class="py-1">
                            <span class="input-header">
                                Name
                            </span>
                            <v-icon class="important-field-icon"> mdi-star </v-icon>

                            <v-text-field required :rules="accountErrors.name" solo dense v-model="
                                form.name
                            " class="textfield" />
                        </v-col>




                        <v-col cols="6" class="py-1">
                            <span class="input-header">
                                Mobile
                            </span>
                            <v-icon class="important-field-icon"> mdi-star </v-icon>

                            <v-text-field required :rules="accountErrors.mobile" solo dense v-model="
                                form.mobile
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


                <v-form @submit.prevent="updatePassword" v-if="passwordPanel" ref="passwordForm">
                    <v-row class="inputs-holder">


                        <v-col cols="12" class="py-1">
                            <span class="input-header">
                                Old Password
                            </span>
                            <v-icon class="important-field-icon"> mdi-star </v-icon>
                            <v-text-field :rules="passwordErrors.old_password"
                                :type="oldPasswordType ? 'text' : 'password'"
                                :append-icon="oldPasswordType ? 'mdi-eye' : 'mdi-eye-off'"
                                @click:append="oldPasswordType = !oldPasswordType" required solo dense v-model="
                                    password.old_password
                                " class="textfield" />
                        </v-col>



                        <v-col cols="12" class="py-1">
                            <span class="input-header">
                                New Password
                            </span>
                            <v-icon class="important-field-icon"> mdi-star </v-icon>
                            <v-text-field :rules="passwordErrors.password" :type="passwordType ? 'text' : 'password'"
                                :append-icon="passwordType ? 'mdi-eye' : 'mdi-eye-off'"
                                @click:append="passwordType = !passwordType" required solo dense v-model="
                                    password.password
                                " class="textfield" />
                        </v-col>




                        <v-col cols="12" class="py-1">
                            <span class="input-header">
                                New Password Confirmation
                            </span>
                            <v-icon class="important-field-icon"> mdi-star </v-icon>
                            <v-text-field :type="passwordConfirmationType ? 'text' : 'password'"
                                :append-icon="passwordConfirmationType ? 'mdi-eye' : 'mdi-eye-off'"
                                @click:append="passwordConfirmationType = !passwordConfirmationType" required solo dense
                                v-model="
                                    password.password_confirmation
                                " class="textfield" />
                        </v-col>


                        <v-col cols="12" class="py-1">
                            <v-checkbox
                                label="Logout from all active sessions (except the current login session on this device)"
                                v-model="form.logoutFromSessions" color="deep-purple lighten-1" hide-details />
                        </v-col>
                    </v-row>
                    <div class="buttons">
                        <v-btn :loading="password.processing" type="submit">Update </v-btn>
                    </div>
                </v-form>


            </div>
            <div class="clear"></div>
        </div>
    </section>
</template>

<script>

import App from "../../Shared/Layout/App";
export default {
    layout: App,
    props: {
        user: Object,
    },

    mounted() {
        this.helper.methods.handleServerData(this.form, this.user)
    },

    computed: {

        accountErrors() {
            return this.helper.methods.formErrors(this.form.errors)
        },

        passwordErrors() {
            return this.helper.methods.formErrors(this.password.errors)
        },

        getImage() {
            return (
                this.image.preview ||
                this.user.image ||
                "/images/users/user.webp"
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
                    this.helper.methods.showSuccessMessage(
                        "Account updated"
                    );
                    this.Inertia.get("/account");
                },
            });
        },

        updatePassword() {
            this.$refs.passwordForm.validate()
            this.password.post("/account/password", {
                onSuccess: () => {
                    this.helper.methods.showSuccessMessage(
                        "Password updated"
                    );
                    Inertia.get("/account");
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
                this.passwordPanel = false
            }

            else {
                this.accountPanel = false
                this.passwordPanel = true
            }
        }
    },

    data() {
        return {
            headerData: {
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
                email: "",
                username: "",
                name: "",
                image: "",
                mobile: "",
                address: "",
            }),

            password: this.$inertia.form({
                old_password: "",
                password: "",
                password_confirmation: "",
                logoutFromSessions: ""
            }),

            oldPasswordType: "password",
            passwordType: "password",
            passwordConfirmationType: "password",

            accountPanel: true,
            passwordPanel: false,

        };
    },
};
</script>
