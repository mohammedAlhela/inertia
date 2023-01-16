<template>
    <section class="confirm-password-container">

        <Head>
            <title>HR -- Password confirm</title>
        </Head>
        <h4> Password confirm</h4>

        <p> Before proceeding, please input your password again </p>

        <form @submit.prevent="confirmPassword">
            <div class="input-fields-holder ">


                <div class="input-holder">
                    <span class="label"> Password :</span>
                    <div class="password">
                        <input v-model="form.password" :type="form.passwordType" type="password" />
                        <span class="validation-error" v-if="form.errors.password">{{
                            form.errors.password
                        }}</span>
                        <v-icon @click="togglePasswordType()">mdi-eye</v-icon>
                    </div>
                </div>

            </div>
         
                <v-btn color="white" type="submit" :loading="form.processing"> Send
                </v-btn>
            
        </form>


        <!--         
      <Link href = "/user/reset/password">  Forget password</Link> -->


    </section>
</template>

<script>
import App from "../../Shared/App.vue";

export default {
    layout: App,

    methods: {
        confirmPassword() {
            this.form.post("/password/confirm")


        },

        togglePasswordType() {
            this.form.passwordType == "password"
                ? (this.form.passwordType = "text")
                : (this.form.passwordType = "password");
        },
    },

    data() {
        return {
            form: this.$inertia.form({
                password: "",
                passwordType: "password"
            }),
        };
    },


};
</script>
