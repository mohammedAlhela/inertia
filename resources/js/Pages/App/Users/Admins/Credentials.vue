<template>
    <section>

        <HeaderPanels :headerData="headerData" />
        <div class="main-holder">
            <div class="account-page">
                <v-form @submit.prevent="update" ref="form">
            <v-row class="inputs-holder">

                <v-col cols="12" class="py-1">
                    <span class="input-header">
                        email
                    </span>
                    <v-icon class="important-field-icon"> mdi-star </v-icon>
                    <v-text-field :rules="formErrors.email" required solo dense v-model="
                        form.email
                    " class="textfield" type="email" />
                </v-col>

                <v-col cols="12" class="py-5">
                    <v-checkbox label="Change password" v-model="form.updatePassword" color="deep-purple lighten-1"
                        hide-details @click="resetformValidation()" />
                </v-col>



             

                

                <div v-if="form.updatePassword">


                    <v-col cols="12" class="py-1">
                        <span class="input-header">
                             Password
                        </span>
                        <v-icon class="important-field-icon"> mdi-star </v-icon>
                        <v-text-field :rules="formErrors.password" :type="passwordType ? 'text' : 'password'"
                            :append-icon="passwordType ? 'mdi-eye' : 'mdi-eye-off'"
                            @click:append="passwordType = !passwordType" required solo dense v-model="
                                form.password
                            " class="textfield" />
                    </v-col>

                    <v-col cols="12" class="py-1">
                        <span class="input-header">
                             Password Confirmation
                        </span>
                        <v-icon class="important-field-icon">
                            mdi-star </v-icon>
                        <v-text-field :rules="formErrors.password_confirmation"
                            :type="passwordConfirmationType ? 'text' : 'password'"
                            :append-icon="passwordConfirmationType ? 'mdi-eye' : 'mdi-eye-off'"
                            @click:append="passwordConfirmationType = !passwordConfirmationType" required solo dense
                            v-model="
                                form.password_confirmation
                            " class="textfield" />
                    </v-col>

                </div>


                
                <v-col cols="12" class="py-1" v-if = "form.updatePassword">
                    <v-checkbox
                        label="Send email notification"
                        v-model="form.sendUpdateNotification" color="deep-purple lighten-1" hide-details />
                </v-col>


                <v-col cols="12" class="py-1">
                    <v-checkbox
                        label="Logout this user from all active sessions"
                        v-model="form.logoutFromSessions" color="deep-purple lighten-1" hide-details />
                </v-col>



            </v-row>
            <div class="buttons">
                <v-btn :loading="form.processing" type="submit">Update </v-btn>
                <Link href="/admins" class="text-link"> <v-btn>Discard</v-btn> </Link>
            </div>
        </v-form>
            </div>
            <div class="clear"></div>
        </div>

  

    </section>
</template>
<script>

export default {
    props: {
        email: String,
        admin: Object
    },

    mounted() {
        this.form.email = this.email
    },

    computed: {
        headerData() {
            return {
                pageTitle: "Sahara School -- Update admin credentials",
                title: "Update admin credentials",

                links: [


                    {
                        icon: "mdi-account-multiple",
                        paragraph: "admins",
                        src: "/admins",
                    },

                    {
                        icon: "mdi-lock",
                        paragraph: "Update admin credentials",
                        src: `/admin/credentials/${this.admin.id}`,
                    }




                ]

            }
        },

        formErrors() {
            return this.helper.methods.formErrors(this.form.errors)
        },

    },

    methods: {

        resetformValidation() {
            if (this.form.updatePassword == true) {
                this.form.reset('password', 'password_confirmation')
            }
        },
        update() {
            this.$refs.form.validate()
            this.form.user_id = this.admin.user_id;
            this.form.id = this.admin.id;
            this.form.post(`/admin/credentials/${this.admin.id}`, {
                onSuccess: () => {
                    this.helper.methods.fireMessage(
                        "credentials updated and we send emails message with the new credentials to the user", "success"
                    );

                    this.form.reset('password', 'password_confirmation')
                },
            });
        },


    },

    data() {
        return {
            form: this.$inertia.form({
                password: "",
                password_confirmation: "",
                logoutFromSessions: "",
                sendUpdateNotification : "",
                updatePassword: "",
                email: "",
                user_id: "",
                id: ""
            }),
            passwordType: "password",
            passwordConfirmationType: "password",


        };
    },
};
</script>
