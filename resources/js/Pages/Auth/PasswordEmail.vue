<template>
    <section class="authentication-card">
        <Head>
            <title>HR -- Password email</title>
        </Head>
        <h2>Password reset</h2>
        <form @submit.prevent="sendPasswordLink">
            <div class="input-fields-holder">
                <div class="input-holder">
                    <span class="label"> Email :</span>
                    <input v-model="form.email"  type="email" autofocus autocapitalize="off" />
                    <span class="validation-error" v-if="form.errors.email">{{
                        form.errors.email
                    }}</span>
                </div>

                <Link href="/login" class="text-link">Back to login</Link>
            </div>
            <div class="buttons">
                <v-btn  color = "blue" dark :loading="form.processing" type="submit"
                    >Send link</v-btn
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
        sendPasswordLink() {
            this.form.post("forgot-password", {
                onSuccess: () => {  this.form.reset('email'); this.helper.methods.showSuccessMessage('A fresh reset password link has been sent to your email address.');}, 
            });
        },
    },

 
    data() {
        return {
            form: this.$inertia.form({
                email: "",
            }),
        };
    },
};
</script>
