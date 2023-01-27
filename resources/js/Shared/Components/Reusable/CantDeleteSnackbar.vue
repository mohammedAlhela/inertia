<template>
    <div>
        <transition name="fade">
            <div class="delete-confirm" v-show="deleteSnackbar">
            

                <span v-html = "message"></span>
                <div class='mt-2'>
                  
                    <v-btn  class="cancel-button" text  @click="close()">
                     Close
                    </v-btn>
                </div>
            </div>
        </transition>
    </div>
</template>
  
<script>
export default {

    props: ['message' , 'deleteSnackbar'],

    methods: {
        close() {
            this.$emit("close");
        },

    },
};
</script>
  
  
  