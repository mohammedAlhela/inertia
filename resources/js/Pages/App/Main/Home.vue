<template>
    <section class="dashboard-page-container">
        Home

        {{ form.errors }}

        <v-btn @click="excel()"> EX </v-btn>

        <v-form @submit.prevent="update" enctype="multipart/form-data">
            <input
                id="mail_files"
                type="file"
                multiple
                @input="form.files = $event.target.files"
            />

            <div class="buttons">
                <v-btn :loading="form.processing" type="submit">Update</v-btn>
            </div>
        </v-form>
    </section>
</template>

<script>
export default {
    methods: {
        update() {
            this.form.post(`/admins/emailMessage/${[1, 2]}`, {
                forceFormData: true,
                onSuccess: () => {
                    this.helper.methods.fireMessage(
                        "Message sended",
                        "success"
                    );
                },
            });

            console.log(this.form.files);
        },

        excel() {
            window.location.href = `/admins/export/pdf/${[
                1
            ]}`;
        },
    },

    data() {
        return {
            form: this.$inertia.form({
                subject: " Test mass message",
                message: " Message sended successfully",
                files: [],
            }),
        };
    },
};
</script>
