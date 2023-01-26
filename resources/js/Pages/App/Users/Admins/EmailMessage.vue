<template>
    <section>
        <HeaderPanels :headerData="headerData" />
        <div class="main-holder">
            <div class="full-page-card">
                <v-form @submit.prevent="send" ref="form" enctype='multipart/form-data'>
                    <v-row class="inputs-holder">


                    

                        
                        <v-col cols="12" class="py-1">
                         <span class = "paragraph">Send email Message to :  </span>

                         <span class = "record-relation-label" v-for = "(email , index) in emails" :key = "index">{{ email }}</span>
                         
                        </v-col>

                        
                 

                        <v-col cols="12" class="py-1">
                            <span class="input-header">
                                Subject
                            </span> 
                            <v-icon class="important-field-icon"> mdi-star </v-icon>
                            <v-text-field :rules="formErrors.subject" required solo dense v-model="
                                form.subject
                            " class="textfield" />
                        </v-col>


                        <v-col cols="12" class="py-1">
                            <span class="input-header">
                                Message
                            </span>
                            <v-icon class="important-field-icon"> mdi-star </v-icon>
                            <v-textarea :rules="formErrors.message" required solo dense v-model="
                                form.message
                            " class="textfield" />
                        </v-col>

                        <v-col cols="12" class="py-1">
                            <span class="input-header mr-5">
                                Attachments 
                            </span>
                            <input type = "file"     multiple     @input="form.files = $event.target.files"
                             class="" />
                        </v-col>



                    </v-row>
                    <div class="buttons">
                        <v-btn :loading="form.processing" type="submit">Send </v-btn>
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
        ids: Array,
        emails: Array,
    },

    computed: {
        headerData() {
            return {
                pageTitle: "Sahara School -- Send email message",
                title: "Send email message",

                links: [


                    {
                        icon: "mdi-account-multiple",
                        paragraph: "admins",
                        src: "/admins",
                    },

                    {
                        icon: "mdi-message",
                        paragraph: "Send email message",
                        src: `/admins/emailMessage/${this.ids}`,
                    }




                ]

            }
        },

        formErrors() {
            return this.helper.methods.formErrors(this.form.errors)
        },

    },

    methods: {


        send() {
            this.$refs.form.validate()
            this.form.ids = this.ids
            this.form.post(`/admins/emailMessage/${this.ids}`, {
                forceFormData: true,
                onSuccess: () => {
                    this.helper.methods.fireMessage(
                        "Message sended successfully", "success"
                    );
                },
            });
        },


    },

    data() {
        return {
            form: this.$inertia.form({
                ids: "",
                subject: "",
                message: "",
                files : ""
            }),

        };
    },
};
</script>
