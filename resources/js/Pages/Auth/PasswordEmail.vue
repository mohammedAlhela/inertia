<template>
    <section class="authentication-card">

        <Head>
            <title>Sahara class - Send password reset link</title>
        </Head>
        <h2>Password reset</h2>
        <v-form @submit.prevent="sendPasswordLink" ref = "form">
            <v-row class="inputs-holder">
                <v-col cols="12" class="py-1">
                    <span class="input-header">
                        Email :
                    </span>

                    <v-text-field required :rules="formErrors.email" solo dense v-model="
                        form.email
                    " class="textfield"/>
                </v-col>

                <Link href="/login" class="link mt-2">Back to login</Link>
            </v-row>
            <div class="buttons">
                <v-btn :loading="form.processing" type="submit">Send link</v-btn>
            </div>
        </v-form>
    </section>
</template>

<script>
import Auth from "../../Shared/Layout/Auth";

export default {
    layout: Auth,

    methods: {
        sendPasswordLink() {
            this.$refs.form.validate()
            this.form.post("/forgot-password", {
                onSuccess: () => { this.form.reset('email'); this.helper.methods.showSuccessMessage('A fresh reset password link has been sent to your email address.'); },
            });
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
                errors: {
                }
            }),
        };
    },
};
</script>
