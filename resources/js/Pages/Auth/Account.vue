<template>
    <section>
        <Head>
            <title>Account update</title>
        </Head>

        <form @submit.prevent="update">
            <div class="input-fields-holder">
                <div class="image-file-input">
                    <div class="description">
                        recomended dimensions are 600 width and 600 height
                    </div>

                    <img :src="getImage" />

                    <div class="upload-holder">
                        <div class="file-holder">
                            <label
                                for="account_image"
                                class="custom-file-upload"
                            >
                                <v-icon> mdi-pencil </v-icon>
                            </label>
                            <input
                                accept="image/*"
                                id="account_image"
                                type="file"
                                @input="form.image = $event.target.files[0]"
                                @change="imageSelected"
                            />
                        </div>

                        <span
                            class="image-paragraph"
                            v-html="getImageParagraph"
                        >
                        </span>

                        <div
                            class="clear"
                            @click="clearImage()"
                            v-if="image.preview"
                        >
                            <v-btn icon color="#645e5e">
                                <v-icon>mdi-cached</v-icon> </v-btn
                            ><span> clear</span>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="input-holder col-md-6">
                        <span class="label"> Name :</span>
                        <input v-model="form.name" type="text" />
                        <span
                            class="validation-error"
                            v-if="form.errors.name"
                            >{{ form.errors.name }}</span
                        >
                    </div>

                    <div class="input-holder col-md-6">
                        <span class="label"> Email :</span>
                        <input v-model="form.email" type="email" />
                        <span
                            class="validation-error"
                            v-if="form.errors.email"
                            >{{ form.errors.email }}</span
                        >
                    </div>

                    <div class="input-holder col-md-6">
                        <span class="label"> Password :</span>
                        <div class="password">
                            <input
                                v-model="form.password"
                                :type="passwordType"
                                type="password"
                            />
                            <span
                                class="validation-error"
                                v-if="form.errors.password"
                                >{{ form.errors.password }}</span
                            >
                            <v-icon @click="togglePasswordType('password')"
                                >mdi-eye</v-icon
                            >
                        </div>
                    </div>

                    <div class="input-holder col-md-6">
                        <span class="label"> Password Confirmation :</span>
                        <div class="password">
                            <input
                                v-model="form.password_confirmation"
                                :type="passwordConfirmationType"
                                type="password"
                            />

                            <v-icon
                                @click="
                                    togglePasswordType('passwordConfirmation')
                                "
                                >mdi-eye</v-icon
                            >
                        </div>
                    </div>
                </div>
            </div>
            <div class="buttons">
                <v-btn
                    color="blue"
                    dark
                    :loading="form.processing"
                    type="submit"
                    >Update account
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
    props: {
        user: Object,
    },

    mounted() {
        this.form.email = this.user.email;
        this.form.name = this.user.name;
        this.form.image = this.user.image;
        this.form.id = this.user.id;
    },

    computed: {
        getImage() {
            return (
                this.image.preview ||
                this.user.image ||
                "/images/users/user.webp"
            );
        },

        getImageParagraph() {
            if (this.form.errors.hasOwnProperty("image")) {
                return `<span class = "validation-error">  ${this.form.errors.image[0]}  </span> `;
            } else if (this.image.name) {
                return `<span >  ${this.image.name}  </span> `;
            } else {
                return `<span > no image selected </span> `;
            }
        },
    },

    methods: {
        handleRequestData() {
            this.form.image = this.image.file;
        },
        update() {
            this.handleRequestData();
            this.form.post("/account", {
                forceFormData: true,
                onSuccess: () => {
                    this.helper.methods.showSuccessMessage(
                        "Account data updated"
                    );
                    Inertia.get("account");
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

        togglePasswordType(type) {
            if (type == "password") {
                this.passwordType == "password"
                    ? (this.passwordType = "text")
                    : (this.passwordType = "password");
            } else {
                this.passwordConfirmationType == "password"
                    ? (this.passwordConfirmationType = "text")
                    : (this.passwordConfirmationType = "password");
            }
        },
    },

    data() {
        return {
            passwordType: "password",
            passwordConfirmationType: "password",

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
                password: "",
                password_confirmation: "",
                name: "",
                image: "",
            }),
        };
    },
};
</script>
