<template>
    <section>
        <div class="success-message" id="success_message" />
        <v-app>
            <v-main>
                <section class="authentication-container">
                    <slot />
                </section>
            </v-main>
        </v-app>
    </section>
</template>
