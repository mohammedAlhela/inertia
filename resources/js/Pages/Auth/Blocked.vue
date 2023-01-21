<template>

    <section class="authentication-card">

        <Head>
            <title> Sahara class - Blocked portal</title>
        </Head>

        <div v-if="type == 'blocked'">
            You are blocked by the admin
        </div>

        <div>
            You have no permissions
        </div>


    </section>
</template>

<script>

export default {

    mounted() {
        this.message ? this.helper.methods.fireMessage(this.message, "error") : 1 == 1;
    },

    props: {
        message: String,
        type: String
    },
};
</script>
