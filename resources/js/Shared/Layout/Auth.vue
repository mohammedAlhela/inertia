<template>
    <section>
        <div class="success-message" id="success_message" />
        <div class="error-message" id="error_message" />
        <v-app>
            <v-main>
                <section class="authentication-container">
                    <slot />
                </section>
            </v-main>
        </v-app>
    </section>
</template>
