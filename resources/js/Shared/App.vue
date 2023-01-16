<template>
    <section>
        <div class="success-message" id="success_message" />
        <v-app>
            <v-main>
                <section class="application-container">
                    <v-overlay  :value="overlay" opacity=".7">
                    <div class="content-holder">
                        <Heading />
                       
                    <slot />
                    
                    </div>
                </v-overlay>
                </section>
            </v-main>
        </v-app>
    </section>
</template>

<script>
import Heading from "./components/Heading.vue";

export default {
    components: { Heading },

    data() {
        return {
            overlay : true
        };
    },
};
</script>
