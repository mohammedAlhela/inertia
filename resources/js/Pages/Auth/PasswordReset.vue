<template>
    <section class="authentication-card">
        <Head>
            <title>Sahara class - Password reset</title>
        </Head>
        <h2>Password reset</h2>
        <v-form @submit.prevent="updatePassword" ref = "form">
            <v-row class="inputs-holder">
                <v-col cols="12" class="py-1">
                    <span class="input-header">
                        Email :
                    </span>

                    <v-text-field required :rules="formErrors.email" solo dense v-model="
                        form.email
                    " class="textfield"></v-text-field>
                </v-col>


                <v-col cols="12" class="py-1">
                    <span class="input-header">
                        Password :
                    </span>

                    <v-text-field :rules="formErrors.password" type="password"
                        :type="passwordType ? 'text' : 'password'"
                        :append-icon="passwordType ? 'mdi-eye' : 'mdi-eye-off'"
                        @click:append="passwordType = !passwordType" required solo dense v-model="
                            form.password
                        " class="textfield"></v-text-field>
                </v-col>




                <v-col cols="12" class="py-1">
                    <span class="input-header">
                        Password Confirmation :
                    </span>

                    <v-text-field type="password" :type="passwordConfirmationType ? 'text' : 'password'"
                        :append-icon="passwordConfirmationType ? 'mdi-eye' : 'mdi-eye-off'"
                        @click:append="passwordConfirmationType = !passwordConfirmationType" required solo dense
                        v-model="
                            form.password_confirmation
                        " class="textfield" />
                </v-col>


                <Link href="/login" class="link mt-2">Back to login</Link>
            </v-row>
            <div class="buttons">
                <v-btn :loading="form.processing" type="submit">Reset password </v-btn>
            </div>
        </v-form>
    </section>
</template>

<script>
import Auth from "../../Shared/Auth.vue";

export default {
    layout: Auth,

    methods: {
        updatePassword() {
            this.$refs.form.validate();
            this.form.token = this.token
            this.form.post("/reset-password");
        },

    },

    computed: {
        formErrors() {
            let keys = Object.keys(this.form.errors)
            keys.forEach(key => {
                this.form.errors[key] = [this.form.errors[key]]
            });

            return this.form.errors
        }
    },

    props: ['token'],
    data() {
        return {
            form: this.$inertia.form({
                token: "",
                email: "",
                password: "",
                password_confirmation: "",
                errors: {
                }
            }),
            passwordType: "password",
            passwordConfirmationType: "password",
        };
    },
};
</script>
