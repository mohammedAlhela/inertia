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
                                                        <Link v-if="helper.methods.can(link.permission)"
                                                            @click="showModules = false" class="text-link"
                                                            :href="link.src" v-for="link, key in item.pages" :key="key">
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
                                                        <Link v-if="helper.methods.can(link.permission)"
                                                            @click="showModules = false" class="text-link"
                                                            :href="link.src" v-for="link, key in item.pages" :key="key">
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
                    <Link v-if="helper.methods.can('billing-show')" href='/billing' class="text-link"> <v-list-item>
                        Billing </v-list-item></Link>
                    <Link v-if="helper.methods.can('company-show')" href='/company' class="text-link"> <v-list-item>
                        Company Data</v-list-item> </Link>


                </v-list>
            </v-menu>


            <v-menu offset-y open-on-hover class="profile-menu">
                <template v-slot:activator="{ on, attrs }">
                    <v-btn icon v-bind="attrs" v-on="on">
                        <v-icon> mdi-account</v-icon>
                    </v-btn>
                </template>

                <v-card class="w-300">
                    <v-list class="profile-menu">


                        <v-list-item class="no-background-hover">
                            <v-list-item-avatar>
                                <img :src="$page.props.auth.image" alt="User iamge">
                            </v-list-item-avatar>

                            <v-list-item-content>
                                <v-list-item-title>{{ $page.props.auth.role }}</v-list-item-title>
                                <v-list-item-subtitle>{{ $page.props.auth.username }}</v-list-item-subtitle>
                            </v-list-item-content>

                        </v-list-item>


                    </v-list>

                    <v-divider></v-divider>

                    <v-list>

                        <Link href='/account' class="text-link"> <v-list-item> Personal Setting </v-list-item></Link>


                        <Link method="post" class="text-link logout-link" href='/logout' as="button"> <v-list-item>
                            Logout </v-list-item></Link>



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
                            { name: "Manage Admins", src: "/admins", permission: "admin-show" },
                            {
                                name: "Manage Teachers",
                                src: "/teachers", permission: "teacher-show"
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
                        head_paragraph: "Courses/Subjects",
                        pages: [

                            { name: " Departments", src: "/departments", permission: "department-show" },
                            { name: " Classes", src: "/courses" , permission: "course-show" },
                            { name: " Sections", src: "/sections", permission: "section-show" },
                            { name: " Subjects", src: "/subjects", permission: "subject-show" }]
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
                        head_icon: "mdi-calendar-range",
                        head_paragraph: "Academic years and terms",
                        pages: [
                            { name: "Academic years", src: "/academicYears", permission: "academicYear-show" },
                            { name: "Academic terms", src: "/academicTerms", permission: "academicTerm-show" },

                        ]
                    },


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
