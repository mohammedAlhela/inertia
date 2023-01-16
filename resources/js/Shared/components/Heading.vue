<template>
    <div class="heading row">
        <div class="col-6">
            <Link href="/account" class="account-link">
                <!-- <img v-if = "$page.component !=   'Auth/Account' "
                    :src="$page.props.auth.image || '/images/users/user.webp'"
                    alt="Account image"
                /> -->

                <span>
                    {{ $page.props.auth.email }}
                </span>
              

                <div class =  "blue-paragraph">
                    {{      helper.methods.formatedDate(
                                        new Date(
                                            new Date() - Math.random() * 1e12
                                        )
                                    )}}
                </div>
            </Link>
        </div>

        <div class="col-6">
            <v-tooltip top>
                <template v-slot:activator="{ on, attrs }">
                    <span v-bind="attrs" v-on="on">
                      
                            <Link v-if = "$page.component != 'Home'" href="/" class = " no-underline d-inline-block mt-2"
                                ><v-icon light class="icon mr-3">
                                    mdi-home
                                </v-icon></Link
                            >
                      
                    </span>
                </template>
                <span> Go to home page </span>
            </v-tooltip>

            <v-tooltip top>
                <template v-slot:activator="{ on, attrs }">
                    <span v-bind="attrs" v-on="on">
                        <span class="main-header">
                            <v-icon light class="icon mr-3" @click="logout">
                                mdi-logout
                            </v-icon>
                        </span>
                    </span>
                </template>
                <span> Logout </span>
            </v-tooltip>

            <v-tooltip top>
                <template v-slot:activator="{ on, attrs }">
                    <span v-bind="attrs" v-on="on">
                        <span class="main-header">
                            <v-icon light class="icon"> mdi-eye </v-icon>
                        </span>
                    </span>
                </template>
                <span style="display: inline-block">
                    <span v-if="!helper.methods.getPermissionsNames().length">
                        No Permissions Added yet
                    </span>

                    <span v-else>
                        <span
                            class="d-block mx-1 my-1"
                            v-for="(item, index) in helper.methods.getPermissionsNames()"
                            :key="index"
                        >
                            {{ item.replace(":", "-") }}
                        </span>
                    </span>
                </span>
            </v-tooltip>
        </div>
    </div>
</template>

<script>
import { Inertia } from "@inertiajs/inertia";
export default {
    props: {},

    methods: {
        logout() {
            Inertia.post("/logout");
        },
    },
};
</script>
