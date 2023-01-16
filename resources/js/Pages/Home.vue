<template>
    <section class="home-page-container">

        <Head>
            <title>Home</title>
        </Head>
        <v-row>
            <v-col cols="12" sm="6">
                <div class="home-link" @click="routing('employee-show', 'employees')" :class="{
                    disabled_link: !helper.methods.can('employee-show'),
                }">
                    Employees
                </div>
            </v-col>

            <v-col cols="12" sm="6">
                <div class="home-link" @click="routing('user-show', 'users')" :class="{
                    disabled_link: !helper.methods.can('user-show'),
                }">
                    users
                </div>
            </v-col>
            <v-col cols="12" sm="6">
                <div class="home-link" @click="routing('expense-show', 'expenses')" :class="{
                    disabled_link: !helper.methods.can('expense-show'),
                }">
                    Expenses
                </div>
            </v-col>
            <v-col cols="12" sm="6">
                <div class="home-link" @click="routing('report-show', 'reports')" :class="{
                    disabled_link: !helper.methods.can('report-show'),
                }">
                    Reports
                </div>
            </v-col>

            <v-col cols="12" sm="6">
                <div class="home-link" @click="routing('deduction-show', 'deductions')" :class="{
                    disabled_link: !helper.methods.can('deduction-show'),
                }">
                    Deduction and Bouns
                </div>
            </v-col>

            <v-col cols="12" sm="6">
                <div class="home-link" @click="routing('report-show', 'charts')" :class="{
                    disabled_link: !helper.methods.can('report-show'),
                }">
                    Analytics and Charts
                </div>
            </v-col>
        </v-row>

        <v-row class="">
            <v-col cols="12">
                <div class="date">

                    {{
    helper.methods.formatedDate(new Date())
                    }}

                </div>
            </v-col>
        </v-row>
    </section>
</template>

<script>
import { Inertia } from "@inertiajs/inertia";
import App from "../Shared/App.vue";
export default {
    layout: App,

    methods: {
        routing(permission, link) {


            this.helper.methods.can(permission)
                ? Inertia.get(link)
                : console.log("no permissions");

        },



    },
};
</script>
