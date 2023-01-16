<template>

    <section class="authentication-card">
        <Head>
            <title>HR -- Login page</title>
        </Head>
        <h2>Sign in</h2>
        <form @submit.prevent="login">
            <div class="input-fields-holder">
                <div class="input-holder">
                    <span class="label"> Email :</span>
                    <input
                        v-model="form.email"
                     
                        type="email"
                        autofocus
                        autocapitalize="off"
                    />
                    <span class="validation-error" v-if="form.errors.email">{{
                        form.errors.email
                    }}</span>
                </div>

                <div class="input-holder">
                    <span class="label"> Password :</span>
                    <div class="password">
                        <input
                            v-model="form.password"
                            :type="form.passwordType"
                       
                            type="password"
                        />
                        <v-icon @click="togglePasswordType()">mdi-eye</v-icon>
                    </div>
                </div>

                <div class="row">
                    <div class="col-6 remember">
                        <input
                            id="remember"
                            v-model="form.remember"
                            type="checkbox"
                            class="d-inline-block"
                        />
                        <span> Remember me </span>
                    </div>
                    <div class="col-6 text-right">
                        <Link href="forgot-password" class="text-link"
                            >Forget passord
                        </Link>
                    </div>
                </div>
            </div>
            <div class="buttons">
                <v-btn  color = "blue" dark :loading="form.processing" type="submit"
                    >Login</v-btn
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
        login() {
            this.form.post("login");
        },

        togglePasswordType() {
            this.form.passwordType == "password"
                ? (this.form.passwordType = "text")
                : (this.form.passwordType = "password");
        },
    },

    data() {
        return {
            form: this.$inertia.form({
                email: "johndoe@example.com",
                password: "secret",
                remember: false,
                passwordType: "password",
            }),
        };
    },
};
</script>
