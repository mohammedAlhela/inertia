<template>
    <section class="authentication-card">

        <Head>
            <title>Sahara class - Set user password</title>
        </Head>
        <h2>Password set</h2>
        <v-form @submit.prevent="setPassword" >
            <v-row class="inputs-holder">
                <v-col cols="12" class="py-1">

                    {{ formErrors }}
                    <span class="input-header">
                        Email :
                    </span>

                    <v-text-field disabled required :rules="formErrors.email" solo dense v-model="
                        email
                    " class="textfield" />
                </v-col>


                <v-col cols="12" class="py-1">
                    <span class="input-header">
                        Password :
                    </span>

                    <v-text-field :rules="formErrors.password" :type="passwordType ? 'text' : 'password'"
                        :append-icon="passwordType ? 'mdi-eye' : 'mdi-eye-off'"
                        @click:append="passwordType = !passwordType" required solo dense v-model="
                            form.password
                        " class="textfield" />
                </v-col>

                <v-col cols="12" class="py-1">
                    <span class="input-header">
                        Password Confirmation :
                    </span>

                    <v-text-field :type="passwordConfirmationType ? 'text' : 'password'"
                        :append-icon="passwordConfirmationType ? 'mdi-eye' : 'mdi-eye-off'"
                        @click:append="passwordConfirmationType = !passwordConfirmationType" required solo dense
                        v-model="
                            form.password_confirmation
                        " class="textfield" />
                </v-col>


                <Link href="/login" class="link mt-2">Back to login</Link>
            </v-row>
            <div class="buttons">
                <v-btn :loading="form.processing" type="submit">Set password </v-btn>
            </div>
        </v-form>
    </section>
</template>

<script>

export default {
    methods: {
        setPassword() {
            this.form.token = this.token
            this.form.email = this.email
            this.form.post("/user/password");
        },

    },

    computed: {
        formErrors() {
            return this.helper.methods.formErrors(this.form.errors)
        }
    },

    props: ['token' , 'email'],
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
