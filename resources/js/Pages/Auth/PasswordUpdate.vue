<template>
    <section class="authentication-card">
        <Head>
            <title>HR -- Password reset</title>
        </Head>

        <h2>Password Update</h2>
        <form @submit.prevent="updatePassword">
            <div class="input-fields-holder">
                <div class="input-holder">
                    <span class="label"> Email :</span>
                    <input v-model="form.email" type="email" autofocus />
                    <span class="validation-error" v-if="form.errors.email">{{
                        form.errors.email
                    }}</span>
                </div>

                <div class="input-holder">
                    <span class="label"> Password :</span>
                    <div class="password">
                        <input v-model="form.password" :type="form.passwordType" type="password" />
                        <span class="validation-error" v-if="form.errors.password">{{
                            form.errors.password
                        }}</span>
                        <v-icon @click="togglePasswordType('password')">mdi-eye</v-icon>
                    </div>
                </div>

                <div class="input-holder">
                    <span class="label"> Password Confirmation :</span>
                    <div class="password">
                        <input v-model="form.password_confirmation" :type="form.passwordConfirmationType"
                            type="password" />

                        <v-icon @click="togglePasswordType('passwordConfirmation')">mdi-eye</v-icon>
                    </div>
                </div>

                <Link href="/login" class="text-link">Back to login</Link>
            </div>
            <div class="buttons">
                <v-btn  color = "blue" dark :loading="form.processing" type="submit"
                    >Reset password </v-btn
                >
            </div>
        </form>
    </section>
</template>

<script>
import Auth from "../../Shared/Auth.vue";

export default {
    layout: Auth,

    methods: {
        updatePassword() {
            this.form.token = this.token
            this.form.post("/reset-password", {
                onSuccess: () => { this.form.reset('email') },
            });
        },

        togglePasswordType(key) {
            if (key == 'password') {
                this.form.passwordType == "password"
                    ? (this.form.passwordType = "text")
                    : (this.form.passwordType = "password");
            }
            this.form.passwordConfirmationType == "password"
                ? (this.form.passwordConfirmationType = "text")
                : (this.form.passwordConfirmationType = "password");
        },
    },

    props: ['token'],
    data() {
        return {
            form: this.$inertia.form({
                token: "",
                email: "",
                password: "",
                passwordType: "password",
                password_confirmation: "",
                passwordConfirmationType: "password",
            }),
        };
    },
};
</script>
