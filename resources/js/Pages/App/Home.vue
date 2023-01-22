<template>
    <section class="dashboard-page-container">
        <v-btn @click="message()">
            Click
        </v-btn>


        {{ form.errors }}
    </section>
</template>

<script>
export default {
    methods: {
        message() {
            this.form.post(`admin/store`)
        }
    },

    data() {
        return {
            form: this.$inertia.form({
              email : "jackij290@gmail.com" , 
              phone : '0595959595' , 
              name : 'jackichan'


            }),
        }
    }
};
</script>
