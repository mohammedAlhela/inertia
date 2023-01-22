<template>
    <section class="dashboard-page-container">
        <v-btn @click="message()">
            Click
        </v-btn>

        <v-form @submit.prevent="send" enctype="multipart/form-data">
            <v-row class="inputs-holder">

                <input accept="" id="account_image" type="file" @input="form.files = $event.target.files"
                    multiple />

            </v-row>
            <div class="buttons">
                <v-btn :loading="form.processing" type="submit">Send</v-btn>
            </div>
        </v-form>



    </section>
</template>

<script>
export default {
    methods: {
        send() {
            console.log(this.form.files);
            this.form.post(`/admins/send`, {
                forceFormData: true,
                onSuccess: () => {
                    this.helper.methods.fireMessage(
                        "Message sended", "success"
                    );
                },
            })
        }
    },

    data() {
        return {


            form: this.$inertia.form({
                files: ""
            }),
        }
    }
};
</script>
