<template>
    <div class="navbar-container">
        <v-app-bar height="50">
            <!-- the brand img -->
            <v-avatar width="35px" height="35px" class="mr-3">
                <img :src="$store.getters['institute/informations/navbarImage']" />
            </v-avatar>
            <!-- the brand img -->


            <!-- the brand  name -->
            <p class="brand-name">
                {{ $store.state.institute.informations.institute.name }}
            </p>
            <!-- the brand name -->

            <!-- the dashboard link  -->
            <span @click="$store.commit('closeDropDownLinks')">
                <span
                    class="dashboard-link"
                    :class="{ active_menu_link: $route.name === 'users' }"
                >
                    Dashboard
                </span>
            </span>
            <!-- the dashboard link  -->
            <!-- the moduels -->
            <div class="moduels-arrow-holder">
                <span
                    class="modules"
                    :class="{ active_menu_link: $route.name != 'users' }"
                    @click="$store.commit('toggleDropDownLinks')"
                >
                    <p>Moduels</p>
                </span>
                <v-slide-y-transition hide-on-leave>
                    <span
                        class="arrow-down"
                        v-if="$store.state.dropDownLinksState"
                    >
                    </span>
                </v-slide-y-transition>
            </div>
            <!-- the moduels-->

            <v-spacer></v-spacer>


                 <search-dialog />


            <!-- the user account menu   -->
            <v-menu
                v-model="$store.state.authentication.user.menu"
                :close-on-content-click="false"
                offset-x
            >
                <template v-slot:activator="{ on, attrs }">
                    <v-btn icon class="no-focus">
                        <v-icon
                            v-bind="attrs"
                            v-on="on"
                            @click="$store.commit('closeDropDownLinks')"
                            >mdi-account</v-icon
                        >
                    </v-btn>
                </template>

                <v-card>
                    <v-list>
                        <v-list-item
                            v-if="
                                $store.getters[
                                    'authentication/specialParentCheck'
                                ]
                            "
                        >
                            <v-list-item-avatar size="70px">
                                <img
                                    :src="
                                        $store.getters[
                                            'authentication/user/getImage'
                                        ]
                                    "
                                    alt="John"
                                />
                            </v-list-item-avatar>

                            <v-list-item-content>
                                <v-list-item-title>
                                    {{
                                        $store.getters["authentication/user/getRole"]
                                    }}
                                </v-list-item-title>

                                <v-list-item-subtitle>
                                    {{
                                        $store.state.authentication.user.user
                                            .full_name
                                    }}
                                </v-list-item-subtitle>
                            </v-list-item-content>
                        </v-list-item>

                        <v-list-item v-else>
                            <v-list-item-content>
                                <v-list-item-subtitle class="p-1">
                                    <span class="header"> Role </span>
                                    {{
                                        $store.getters["authentication/user/getRole"]
                                    }}
                                </v-list-item-subtitle>

                                <v-list-item-subtitle class="p-1">
                                    <span class="header"> Father name </span>
                                    {{
                                        $store.state.authentication.user.parent
                                            .father_name
                                    }}
                                </v-list-item-subtitle>

                                <v-list-item-subtitle class="p-1">
                                    <span class="header"> Mother name </span>
                                    {{
                                        $store.state.authentication.user.parent
                                            .mother_name
                                    }}
                                </v-list-item-subtitle>
                            </v-list-item-content>
                        </v-list-item>
                    </v-list>

                    <v-divider></v-divider>

                    <v-list>
                        <v-list-item
                            @click="
                                $store.commit(
                                    'authentication/user/goToUserAccount'
                                )
                            "
                        >
                            <v-list-item-action>
                                <v-icon>
                                    mdi-account
                                </v-icon>
                            </v-list-item-action>
                            <v-list-item-title
                                >Personal setting</v-list-item-title
                            >
                        </v-list-item>

                        <v-list-item
                            @click="$store.dispatch('authentication/user/logout')"
                        >
                            <v-list-item-action>
                                <v-icon>
                                    mdi-logout-variant
                                </v-icon>
                            </v-list-item-action>
                            <v-list-item-title>Logout</v-list-item-title>
                        </v-list-item>
                    </v-list>

                    <v-card-actions>
                        <v-spacer></v-spacer>

                        <v-btn
                            block
                            text
                            @click="
                                $store.state.authentication.user.menu = false
                            "
                            class="menu-cancel-button"
                        >
                            Cancel
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </v-menu>
            <!-- the user account menu   -->

            <!-- the setting menu   -->
            <v-menu
                v-model="$store.state.institute.informations.menu"
                :close-on-content-click="false"
                offset-x
            >
                <template v-slot:activator="{ on, attrs }">
                    <v-btn icon class="no-focus ">
                        <v-icon
                            v-bind="attrs"
                            v-on="on"
                            @click="$store.commit('closeDropDownLinks')"
                            >mdi-cogs</v-icon
                        >
                    </v-btn>
                </template>

                <v-card>
                    <v-list>
                        <v-list-item>
                            <v-list-item-avatar size="70px">
                                <img
                                    :src="
                                        $store.getters[
                                            'institute/informations/navbarImage'
                                        ]
                                    "
                                    alt="John"
                                />
                            </v-list-item-avatar>

                            <v-list-item-content>
                                <v-list-item-title>

                                    {{
                                        $store.state.institute.informations.institute.name
                                            ? $store.state.institute.informations.institute
                                                  .name
                                            : "Institute name"
                                    }}
                                </v-list-item-title>

                                <v-list-item-subtitle>
                                    {{
                                        $store.state.institute.informations.institute.email
                                            ? $store.state.institute.informations.institute
                                                  .email
                                            : "Institute email"
                                    }}
                                </v-list-item-subtitle>
                            </v-list-item-content>
                        </v-list-item>
                    </v-list>

                    <v-divider></v-divider>

                    <v-list>
                        <v-list-item
                            @click="
                                $store.commit('institute/informations/goToInstituteSetting')
                            "
                        >
                            <v-list-item-action>
                                <v-icon>
                                    mdi-home-city
                                </v-icon>
                            </v-list-item-action>
                            <v-list-item-title
                                >Institute setting</v-list-item-title
                            >
                        </v-list-item>

                        <v-list-item>
                            <v-list-item-action>
                                <v-icon>
                                    mdi-cash-usd
                                </v-icon>
                            </v-list-item-action>
                            <v-list-item-title>Billing </v-list-item-title>
                        </v-list-item>
                    </v-list>

                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn
                            block
                            text
                            @click="
                                $store.state.institute.informations.menu = false
                            "
                            class="menu-cancel-button"
                        >
                            Cancel
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </v-menu>
            <!-- the setting menu   -->
        </v-app-bar>

        <div class="expired-register">
            your program register will expired after 6 days
            <span class="register-now "> <strong> Register-now </strong> </span>
        </div>

        <v-slide-y-transition>
            <dropdown-links />
        </v-slide-y-transition>
        
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
