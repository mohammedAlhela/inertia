<template>
    <div v-if="$store.state.dropDownLinksState" class="dropdown-container">
        <!-------------------- dropdown heading section ------------------------>
        <div class="heading-section">
            <div class="head" @click="$store.commit('navbar/dropdownLinks/firstToShow')" :class="{
                active_head:
                    $store.state.navbar.dropdownLinks.first_links_page
            }">
                Academics/Classes
            </div>


            <div class="head" @click="$store.commit('navbar/dropdownLinks/secondToShow')" :class="{
                active_head:
                    $store.state.navbar.dropdownLinks.second_links_page
            }">
                Communication
            </div>



            <div class="head" @click="$store.commit('navbar/dropdownLinks/thirdToShow')" :class="{
                active_head:
                    $store.state.navbar.dropdownLinks.third_links_page
            }">
                Administration
            </div>


        </div>
        <!-------------------- dropdown heading section ------------------------>

        <!-------------------- dropdown links groups section ------------------------>
        <div class="links-section">
            <!-- academics-links-page-->
            <div v-if="$store.state.navbar.dropdownLinks.first_links_page">
                <div class="half-width ">
                    <div class="links-block" v-for="item in $store.state.navbar.dropdownLinks
                    .academic_left_section" :key="item.message">
                        <span>
                            <v-icon class="head-icon">{{ item.head_icon }}
                            </v-icon>
                        </span>
                        <span class="header">{{ item.head_paragraph }}</span>
                        <br />
                        <div @click="$store.commit('closeDropDownLinks')" class="section-link"
                            v-for="page in item.pages" :key="page.message">
                            <router-link class="link" :to="{ name: page.src }">
                                {{ page.name }}
                            </router-link>
                        </div>
                    </div>
                    <div class="clearing"></div>
                </div>

                <div class="half-width ">
                    <div class="links-block" v-for="item in $store.state.navbar.dropdownLinks
                    .academic_right_section" :key="item.message">
                        <span>
                            <v-icon class="head-icon">{{ item.head_icon }}
                            </v-icon>
                        </span>
                        <span class="header">{{ item.head_paragraph }}</span>
                        <br />
                        <div @click="$store.commit('closeDropDownLinks')" class="section-link"
                            v-for="page in item.pages" :key="page.message">
                            <router-link class="link" :to="{ name: page.src }">
                                {{ page.name }}
                            </router-link>
                        </div>
                    </div>
                    <div class="clearing"></div>
                </div>
            </div>
            <!-- academics-links-page-->






            <!-- communication-links-page-->
            <div v-if="$store.state.navbar.dropdownLinks.second_links_page">
                <div class="half-width ">
                    <div class="links-block" v-for="item in $store.state.navbar.dropdownLinks
                    .communication_left_section" :key="item.message">
                        <span>
                            <v-icon class="head-icon">{{ item.head_icon }}
                            </v-icon>
                        </span>
                        <span class="header">{{ item.head_paragraph }}</span>
                        <br />
                        <div class="section-link" v-for="page in item.pages" :key="page.message">
                            <router-link class="link" :to="{ name: page.src }">
                                {{ page.name }}
                            </router-link>
                        </div>
                    </div>
                    <div class="clearing"></div>
                </div>

                <div class="half-width ">
                    <div class="links-block" v-for="item in $store.state.navbar.dropdownLinks
                    .communication_right_section" :key="item.message">
                        <span>
                            <v-icon class="head-icon">{{ item.head_icon }}
                            </v-icon>
                        </span>
                        <span class="header">{{ item.head_paragraph }}</span>
                        <br />
                        <div class="section-link" v-for="page in item.pages" :key="page.message">
                            <router-link class="link" :to="{ name: page.src }">
                                {{ page.name }}
                            </router-link>
                        </div>
                    </div>
                    <div class="clearing"></div>
                </div>
            </div>
            <!-- communication-links-page-->

        </div>
        <!-------------------- dropdown links groups section ------------------------>
    </div>
</template>
