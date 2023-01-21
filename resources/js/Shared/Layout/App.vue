<template>
    <section>
        <div class="success-message" id="success_message" />
        <div class="error-message" id="error_message" />
        <v-app>
            <v-main>
                <section class="application-container">

                    <Heading />

                    <Confirmation />

                    <slot />

                    <Footing />

                </section>
            </v-main>
        </v-app>
    </section>
</template>

<script>
import Heading from "../Components/Include/Heading";
import Confirmation from "../Components/Include/Confirmation";
import Footing from "../Components/Include/Footing";

export default {
    components: { Heading, Footing, Confirmation },
};
</script>
