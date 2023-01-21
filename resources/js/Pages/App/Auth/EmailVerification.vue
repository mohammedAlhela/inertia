<template>
    <section class="verify-email-container">

        <Head>
            <title>HR -- Email verify</title>
        </Head>

        <h4> Verify Your Email Address</h4>

        <p> Before proceeding, please check your email for a verification link
            If you did not receive the email </p>

        <div class="buttons">
            <v-btn color="white" @click="sendVerificationLink"  :loading="loading" > request
                another</v-btn>
        </div>

    </section>
</template>

<script>


export default {

    methods: {
        sendVerificationLink() {
            Inertia.post("/email/verification-notification", {}, {
                onStart: () => { this.loading = true },
                onSuccess: () => { this.helper.methods.fireMessage('A fresh verification link has been sent to your email address.' ,  "success"); this.loading = false },
                onError: () => { this.loading = false },
            });
        },
    },



    data() {
        return {
            loading: false
        };
    },
};
</script>
