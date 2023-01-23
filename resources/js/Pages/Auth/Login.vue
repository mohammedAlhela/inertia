<template>

    <section class="authentication-card">

        <Head>
            <title> Sahara class - Login page</title>
        </Head>
        <h2>Sign in</h2>

        <v-form @submit.prevent="login" ref="form">
            <v-row class="inputs-holder">
                <v-col cols="12" class="py-1">
                    <span class="input-header">
                        Email :
                    </span>

                    <v-text-field type = "email" required :rules="formErrors.email" solo dense v-model="
                        form.email
                    " class="textfield" />
                </v-col>


                <v-col cols="12" class="py-1">
                    <span class="input-header">
                        Password :
                    </span>

                    <v-text-field :type="passwordType ? 'text' : 'password'"
                        :append-icon="passwordType ? 'mdi-eye' : 'mdi-eye-off'"
                        @click:append="passwordType = !passwordType" required :rules="formErrors.password" solo dense
                        v-model="
                            form.password
                        " class="textfield" autocomplete="new-password" />
                </v-col>


                <v-col cols="6" class="py-1">
                    <v-checkbox label="Remember me" v-model="form.remember" color="deep-purple lighten-1"
                        hide-details />
                </v-col>
                <v-col cols="6" class="py-1 text-right">
                    <Link href="/forgot-password" class="text-link">Forget passord?
                    </Link>
                </v-col>

            </v-row>
            <div class="buttons">
                <v-btn :loading="form.processing" type="submit">Login</v-btn>
            </div>
        </v-form>

    </section>
</template>

<script>

export default {

    methods: {
        login() {
            this.$refs.form.validate()
            this.form.post("/login")
        },

    },

    computed: {
        formErrors() {
            return this.helper.methods.formErrors(this.form.errors)
        }
    },

    data() {
        return {
            form: this.$inertia.form({
                email: "",
                password: "",
                remember: false,
                errors: {

                }
            }),
            passwordType: false,
        };
    },
};
</script>
