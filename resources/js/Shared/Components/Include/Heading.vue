<template>
    <div class="heading row">


        <div class="col-6">



            <Link href="/" class="brand">
            <img src="/images/main/company.webp" alt="">
            <span>{{ 'Sahara' }}</span>
            </Link>

            <div class="modules">
                <span @click="showModules = !showModules">Modules </span>



                <div class="modules-popup" v-if="showModules">
                    <v-card>
                        <v-tabs vertical hide-slider>
                            <v-tab>

                                Academics
                            </v-tab>
                            <v-tab>

                                Scheduling and events
                            </v-tab>
                            <v-tab>

                                Administration
                            </v-tab>


                            <v-tab-item>
                                <v-card flat>
                                    <v-card-text>
                                        <v-row>
                                            <v-col cols="6">
                                                <div v-for="item, index in modules.academic_left_section" :key="index"
                                                    class="holder">

                                                    <v-icon> {{ item.head_icon }}</v-icon>
                                                    {{ item.head_paragraph }}
                                                    <div class="links">
                                                        <Link class="text-link" :href="link.src"
                                                            v-for="link, key in item.pages" :key="key">
                                                        {{ link.name }}
                                                        </Link>
                                                    </div>
                                                </div>
                                            </v-col>

                                            <v-col cols="6">

                                                <div v-for="item, index in modules.academic_right_section" :key="index"
                                                    class="holder">

                                                    <v-icon> {{ item.head_icon }}</v-icon>
                                                    {{ item.head_paragraph }}
                                                    <div class="links">
                                                        <Link class="text-link" :href="link.src"
                                                            v-for="link, key in item.pages" :key="key">
                                                        {{ link.name }}
                                                        </Link>
                                                    </div>
                                                </div>

                                            </v-col>
                                        </v-row>
                                    </v-card-text>
                                </v-card>
                            </v-tab-item>

                        </v-tabs>
                    </v-card>
                </div>
            </div>


        </div>


        <div class="col-6  actions">




            <v-menu offset-y open-on-hover>
                <template v-slot:activator="{ on, attrs }">

                    <v-btn icon v-bind="attrs" v-on="on">
                        <v-icon> mdi-magnify</v-icon>
                    </v-btn>
                </template>
                <v-list>
                    <v-list-item>
                        <v-list-item-title> </v-list-item-title>
                    </v-list-item>
                </v-list>
            </v-menu>




            <v-menu offset-y open-on-hover>
                <template v-slot:activator="{ on, attrs }">
                    <v-btn icon v-bind="attrs" v-on="on">
                        <v-icon> mdi-cogs</v-icon>
                    </v-btn>
                </template>
                <v-list>
                    <Link href='/billing' class="text-link"> <v-list-item> Billing </v-list-item></Link>
                    <Link href='/company' class="text-link"> <v-list-item> Company Data</v-list-item> </Link>


                </v-list>
            </v-menu>


            <v-menu open-on-hover offset-y>
                <template v-slot:activator="{ on, attrs }">
                    <v-btn icon v-bind="attrs" v-on="on">
                        <v-icon> mdi-account</v-icon>
                    </v-btn>
                </template>

                <v-card class="w-300">
                    <v-list>
                        <v-list-item>
                            <v-list-item-content>
                                <v-list-item-title>{{ $page.props.auth.role }}</v-list-item-title>
                                <v-list-item-subtitle>{{ $page.props.auth.username }}</v-list-item-subtitle>
                            </v-list-item-content>
                        </v-list-item>
                    </v-list>

                    <v-divider></v-divider>

                    <v-list>

                        <Link href='/account' class="text-link"> <v-list-item> Personal Setting </v-list-item></Link>
                        <Link method="post" class="text-link" href='/logout' as="button"> <v-list-item> Logout
                        </v-list-item></Link>
                    </v-list>


                </v-card>
            </v-menu>







        </div>



    </div>
</template>

<script>
import { Inertia } from "@inertiajs/inertia";
export default {

    methods: {
        logout() {
            Inertia.post("/logout");
        },
    },

    data() {
        return {


            showModules: false,
            settings: true,
            // ++++++++++++++++++++ academics ++++++++++++++++++++++++
            modules: {
                // ++++++++++++++++++++ academics ++++++++++++++++++++++++
                academic_left_section: [
                    // admins teachers alocation
                    {
                        head_icon: "mdi-teach",
                        head_paragraph: "Teachers/Admins",
                        pages: [
                            { name: "Manage Admins", src: "/admins" },
                            {
                                name: "Manage Teachers",
                                src: "/teachers"
                            },
                            {
                                name: "Subjects Allocation",
                                src: "/subjects-allocations"
                            }
                        ]
                    },


                    {
                        head_icon: "mdi-account-multiple",
                        head_paragraph: "Students",
                        pages: [
                            { name: "Manage Students", src: "/students" },
                            { name: "Manage Alumni", src: "/alumnies" },

                        ]
                    },

                    {
                        head_icon: "mdi-file-multiple",
                        head_paragraph: "Classes/Sections",
                        pages: [{ name: "Manage Classes", src: "/classes" }]
                    },

                    {
                        head_icon: "mdi-vector-triangle ",
                        head_paragraph: "Learning management system",
                        pages: [
                            { name: "Manage Subjects content", src: "/lms" }
                        ]
                    },


                    // admins teachers alocation
                ],


                academic_right_section: [
                    {
                        head_icon: "mdi-human-male-boy",
                        head_paragraph: "Parents",
                        pages: [
                            { name: "Manage Parents", src: "parents" },

                        ]
                    },


                    {
                        head_icon: "mdi-calendar-text-outline",
                        head_paragraph: "Assessments and grading",
                        pages: [
                            { name: "Manage assessments", src: "assessments" },
                            { name: "Manage grades", src: "grades" },

                        ]
                    },

                    {
                        head_icon: "mdi-plus-box",
                        head_paragraph: "Manage Health Data",
                        pages: [
                            { name: "Teachers helath", src: "/teachers/health" },
                            { name: "Students helath", src: "/students/health" },

                        ]
                    },


                ],
                // ++++++++++++++++++++ academics ++++++++++++++++++++++++
            },


        }
    }
};
</script>
