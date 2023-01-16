<template>
    <section class="users-page-container">
        <Head>
            <title>Employees</title>
        </Head>

        <v-row>
            <v-col cols="6 pt-5">
                <span class="items-number">
                    <v-tooltip top>
                        <template v-slot:activator="{ on, attrs }">
                            <span v-bind="attrs" v-on="on">
                                <span class="main-header">
                                    {{ employees.length }}
                                    Employees
                                </span>
                            </span>
                        </template>
                        <span> Employees number</span>
                    </v-tooltip>
                </span>
            </v-col>

            <v-col cols="6" class="text-right index-buttons">
                <a href="employees/export/excel" class="no-underline">
                    <v-btn dark class="mx-2" small color="orange">
                        Export
                        <v-icon class="white-icon" dark> mdi-download </v-icon>
                    </v-btn></a
                >
                <Link href="/employee/create" class="no-underline">
                    <v-btn
                        dark
                        class="mx-2"
                        small
                        color="green"
                        v-if="helper.methods.can('employee-write')"
                    >
                        Add
                        <v-icon class="white-icon" dark> mdi-plus </v-icon>
                    </v-btn></Link
                >
            </v-col>
            <v-app>
                <v-main>
                    <v-select
                        class="textfield mt-5"
                        :items="allHeaders"
                        return-object
                        item-value="value"
                        item-text="text"
                        v-model="headers"
                        dense
                        multiple
                        label="Choose Fields To Show In Table"
                    >
                    </v-select>
                </v-main>
            </v-app>
        </v-row>

        <v-row>
            <v-col cols="12">
                <v-data-table
                    light
                    class="elevation-3"
                    :headers="headers"
                    :items="filteredEmployees()"
                    :items-per-page="10"
                    item-key="item.id"
                    mobile-breakpoint="1300"
                >
                    <!-- headers -->
                    <template v-slot:header.first_name="{ header }">
                        {{ header.text }}
                        <v-menu offset-y :close-on-content-click="false">
                            <template v-slot:activator="{ on, attrs }">
                                <v-btn icon v-bind="attrs" v-on="on">
                                    <v-icon
                                        small
                                        :color="first_name ? 'primary' : ''"
                                    >
                                        mdi-filter
                                    </v-icon>
                                </v-btn>
                            </template>
                            <div style="background-color: white; width: 280px">
                                <v-text-field
                                    v-model="first_name"
                                    class="pa-4"
                                    type="text"
                                    label="Enter the search term"
                                ></v-text-field>
                                <v-btn
                                    @click="first_name = ''"
                                    small
                                    text
                                    color="primary"
                                    class="ml-2 mb-2"
                                    >Clean</v-btn
                                >
                            </div>
                        </v-menu>
                    </template>

                    <template v-slot:header.email="{ header }">
                        {{ header.text }}
                        <v-menu offset-y :close-on-content-click="false">
                            <template v-slot:activator="{ on, attrs }">
                                <v-btn icon v-bind="attrs" v-on="on">
                                    <v-icon
                                        small
                                        :color="email ? 'primary' : ''"
                                    >
                                        mdi-filter
                                    </v-icon>
                                </v-btn>
                            </template>
                            <div style="background-color: white; width: 280px">
                                <v-text-field
                                    v-model="email"
                                    class="pa-4"
                                    type="text"
                                    label="Enter the search term"
                                ></v-text-field>
                                <v-btn
                                    @click="email = ''"
                                    small
                                    text
                                    color="primary"
                                    class="ml-2 mb-2"
                                    >Clean</v-btn
                                >
                            </div>
                        </v-menu>
                    </template>

                    <template v-slot:header.phone_number="{ header }">
                        {{ header.text }}
                        <v-menu offset-y :close-on-content-click="false">
                            <template v-slot:activator="{ on, attrs }">
                                <v-btn icon v-bind="attrs" v-on="on">
                                    <v-icon
                                        small
                                        :color="phone_number ? 'primary' : ''"
                                    >
                                        mdi-filter
                                    </v-icon>
                                </v-btn>
                            </template>
                            <div style="background-color: white; width: 280px">
                                <v-text-field
                                    v-model="phone_number"
                                    class="pa-4"
                                    type="text"
                                    label="Enter the search term"
                                ></v-text-field>
                                <v-btn
                                    @click="phone_number = ''"
                                    small
                                    text
                                    color="primary"
                                    class="ml-2 mb-2"
                                    >Clean</v-btn
                                >
                            </div>
                        </v-menu>
                    </template>

                    <template v-slot:header.based_at="{ header }">
                        {{ header.text }}
                        <v-menu offset-y :close-on-content-click="false">
                            <template v-slot:activator="{ on, attrs }">
                                <v-btn icon v-bind="attrs" v-on="on">
                                    <v-icon
                                        small
                                        :color="based_at ? 'primary' : ''"
                                    >
                                        mdi-filter
                                    </v-icon>
                                </v-btn>
                            </template>
                            <div style="background-color: white; width: 280px">
                                <v-text-field
                                    v-model="based_at"
                                    class="pa-4"
                                    type="text"
                                    label="Enter the search term"
                                ></v-text-field>
                                <v-btn
                                    @click="based_at = ''"
                                    small
                                    text
                                    color="primary"
                                    class="ml-2 mb-2"
                                    >Clean</v-btn
                                >
                            </div>
                        </v-menu>
                    </template>

                    <template v-slot:header.employee_type="{ header }">
                        {{ header.text }}
                        <v-menu offset-y :close-on-content-click="false">
                            <template v-slot:activator="{ on, attrs }">
                                <v-btn icon v-bind="attrs" v-on="on">
                                    <v-icon
                                        small
                                        :color="employee_type ? 'primary' : ''"
                                    >
                                        mdi-filter
                                    </v-icon>
                                </v-btn>
                            </template>
                            <div style="background-color: white; width: 280px">
                                <v-text-field
                                    v-model="employee_type"
                                    class="pa-4"
                                    type="text"
                                    label="Enter the search term"
                                ></v-text-field>
                                <v-btn
                                    @click="employee_type = ''"
                                    small
                                    text
                                    color="primary"
                                    class="ml-2 mb-2"
                                    >Clean</v-btn
                                >
                            </div>
                        </v-menu>
                    </template>
                    <!-- headers -->

                    <template v-slot:item.first_name="{ item }">
                        <td class="py-1">
                            <span>
                                {{ `${item.first_name} ${item.last_name}` }}
                            </span>
                        </td>
                    </template>

                    <template v-slot:item.total_salary="{ item }">
                        <td class="pt-2 pb-2">
                            <div>
                                <v-tooltip top>
                                    <template v-slot:activator="{ on, attrs }">
                                        <span v-bind="attrs" v-on="on">
                                            {{ item.total_salary }}
                                        </span>
                                    </template>
                                    <span> Salary </span>
                                </v-tooltip>
                                +

                                <v-tooltip top>
                                    <template v-slot:activator="{ on, attrs }">
                                        <span v-bind="attrs" v-on="on">
                                            {{ expensesTotal(item) }}
                                        </span>
                                    </template>
                                    <span> Expenses </span>
                                </v-tooltip>
                                +

                                <v-tooltip top>
                                    <template v-slot:activator="{ on, attrs }">
                                        <span v-bind="attrs" v-on="on">
                                            {{ deductionsTotal(item) }}
                                        </span>
                                    </template>
                                    <span> Deductions </span>
                                </v-tooltip>
                                =>
                                <v-tooltip top>
                                    <template v-slot:activator="{ on, attrs }">
                                        <span v-bind="attrs" v-on="on">
                                            {{ total(item) }}
                                        </span>
                                    </template>
                                    <span> Total </span>
                                </v-tooltip>
                            </div>
                        </td>
                    </template>

                    <template v-slot:item.image="{ item }">
                        <td class="py-2">
                            <img
                                class="thumb-image"
                                :src="
                                    item.image ||
                                    '/images/employees/employee.webp'
                                "
                                alt=""
                            />
                        </td>
                    </template>

                    <template v-slot:item.actions="{ item }">
                        <!-- actions -->
                        <td class="paragraph">
                            <v-tooltip top>
                                <template v-slot:activator="{ on, attrs }">
                                    <span
                                        v-bind="attrs"
                                        v-on="on"
                                        v-if="helper.methods.can('user-write')"
                                    >
                                        <v-icon
                                            @click="editItem(item)"
                                            class="mr-2 edit-icon"
                                        >
                                            mdi-pencil
                                        </v-icon>
                                    </span>
                                </template>
                                <span> edit employee </span>
                            </v-tooltip>
                            <span>
                                <v-tooltip top>
                                    <template v-slot:activator="{ on, attrs }">
                                        <span
                                            v-bind="attrs"
                                            v-on="on"
                                            v-if="
                                                helper.methods.can(
                                                    'user-delete'
                                                )
                                            "
                                        >
                                            <v-icon
                                                @click="
                                                    showDeleteSnackbar(item)
                                                "
                                                class="delete-icon"
                                            >
                                                mdi-delete
                                            </v-icon>
                                        </span>
                                    </template>
                                    <span> delete employee </span>
                                </v-tooltip>
                            </span>

                            <!-- actions -->
                        </td>
                    </template>
                </v-data-table>
            </v-col>
        </v-row>

        <delete-confirm
            :deleteSnackbar="deleteSnackbar"
            @closing="closeDeleteSnackbar()"
            @deleteData="destroy()"
            useDefault="12"
            user="employee"
        >
        </delete-confirm>
    </section>
</template>

<script>
import { Inertia } from "@inertiajs/inertia";
import App from "../../Shared/App.vue";
export default {
    name: "Users",
    layout: App,
    props: {
        employees: Array,
    },

    components: {},

    data: () => ({
        // main section
        allHeaders: [
            {
                text: "Image",
                sortable: true,
                value: "image",
                id: 0,
                disabled: true,
            },

            {
                text: "Full name",
                sortable: true,
                value: "first_name",
                id: 1,
                disabled: true,
            },

            {
                text: "Email",
                sortable: true,
                value: "email",
                id: 2,
                disabled: true,
            },

            {
                text: "Phone Number",
                sortable: true,
                value: "phone_number",
                id: 3,
                disabled: true,
            },

            {
                text: "Employee type",
                sortable: true,
                value: "employee_type",
                id: 4,
            },

            {
                text: "Based At",
                sortable: true,
                value: "based_at",
                id: 5,
            },

            {
                text: "Actions",
                value: "actions",
                sortable: false,
                id: 50,
                disabled: true,
            },

            {
                text: "Based At Current Status",
                sortable: true,
                value: "based_at_current_status",
                id: 6,
            },

            {
                text: "Position Branch",
                sortable: true,
                value: "position_branch_number",
                id: 7,
            },

            {
                text: "Nationality",
                sortable: true,
                value: "nationality",
                id: 8,
            },

            {
                text: "Gender",
                sortable: true,
                value: "gender",
                id: 9,
            },

            {
                text: "Local Mobile Number",
                sortable: true,
                value: "local_mobile_number",
                id: 10,
            },

            {
                text: "Emergency Number",
                sortable: true,
                value: "emergency_number",
                id: 11,
            },

            {
                text: "Emergency Contact Name",
                sortable: true,
                value: "emergency_contact_name",
                id: 12,
            },

            {
                text: "Position",
                sortable: true,
                value: "position",
                id: 13,
            },

            {
                text: "Position",
                sortable: true,
                value: "position",
                id: 14,
            },

            {
                text: "Passport Number",
                sortable: true,
                value: "passport_number",
                id: 15,
            },

            {
                text: "Residency Number",
                sortable: true,
                value: "residency_number",
                id: 16,
            },

            {
                text: "Health Number ",
                sortable: true,
                value: "health_number",
                id: 17,
            },

            {
                text: "Labour Contact ",
                sortable: true,
                value: "labour_contract",
                id: 18,
            },

            {
                text: "Salary && Deductions && expenses",
                sortable: true,
                value: "total_salary",
                id: 19,
            },
        ],

        headers: [
            {
                text: "Image",
                sortable: true,
                value: "image",
                id: 0,
                disabled: true,
            },

            {
                text: "Full name",
                sortable: true,
                value: "first_name",
                id: 1,
                disabled: true,
            },

            {
                text: "Email",
                sortable: true,
                value: "email",
                id: 2,
                disabled: true,
            },

            {
                text: "Phone Number",
                sortable: true,
                value: "phone_number",
                id: 3,
                disabled: true,
            },

            {
                text: "Employee type",
                sortable: true,
                value: "employee_type",
                id: 4,
            },

            {
                text: "Actions",
                value: "actions",
                sortable: false,
                id: 50,
                disabled: true,
            },
        ],

        // main section

        // delete section
        deleteSnackbar: false,
        deleteIndex: -1,
        //  delete section

        //filter section
        first_name: "",
        email: "",
        phone_number: "",
        based_at: "",
        employee_type: "",
        //filter section
    }),

    computed: {},

    watch: {
        headers: function (newValue, oldValue) {
            console.log(
                `headers changed from${oldValue.length} to ${newValue.length}`
            );
            if (oldValue.length < newValue.length) {
                this.sortHeaders();
            }
        },
    },

    methods: {
        total(item) {
            return (
                parseInt(item.total_salary) +
                this.expensesTotal(item) +
                this.deductionsTotal(item)
            );
        },

        deductionsTotal(item) {
            if (this.employees.length) {
                let total = 0;
                let deductions = item.deductions;
                deductions.forEach((deduction) => {
                    total += parseInt(deduction.total);
                });

                return total;
            } else {
                return 0;
            }
        },

        expensesTotal(item) {
            if (this.employees.length) {
                let total = 0;
                let expenses = item.expenses;
                expenses.forEach((expense) => {
                    total += parseInt(expense.total);
                });

                return total;
            } else {
                return 0;
            }
        },

        filteredEmployees() {
            let conditions = [];

            if (this.first_name) {
                conditions.push(this.filterName);
            }

            if (this.email) {
                conditions.push(this.filterEmail);
            }

            if (this.phone_number) {
                conditions.push(this.filterPhoneNumber);
            }

            if (this.based_at) {
                conditions.push(this.filterBasedAt);
            }

            if (this.employee_type) {
                conditions.push(this.filterEmployeeType);
            }

            if (conditions.length > 0) {
                return this.employees.filter((employee) => {
                    return conditions.every((condition) => {
                        return condition(employee);
                    });
                });
            }

            return this.employees;
        },

        filterName(item) {
            return item.first_name
                .toLowerCase()
                .includes(this.first_name.toLowerCase());
        },

        filterEmail(item) {
            return item.email.toLowerCase().includes(this.email.toLowerCase());
        },

        filterPhoneNumber(item) {
            return item.phone_number
                .toLowerCase()
                .includes(this.phone_number.toLowerCase());
        },

        filterBasedAt(item) {
            return item.based_at
                .toLowerCase()
                .includes(this.based_at.toLowerCase());
        },
        filterEmployeeType(item) {
            return item.employee_type
                .toLowerCase()
                .includes(this.employee_type.toLowerCase());
        },

        closeDeleteSnackbar() {
            this.deleteSnackbar = false;
        },

        showDeleteSnackbar(item) {
            this.deleteIndex = item.id;
            this.deleteSnackbar = true;
        },

        sortHeaders() {
            let headers = this.headers;

            let actionsNumber = headers.findIndex(function (item) {
                return item.id == 50;
            });

            if (actionsNumber) {
                let actionsObject = {};
                actionsObject = Object.assign({}, headers[actionsNumber]);
                headers.splice(actionsNumber, 1);
                headers.push(actionsObject);
            }
        },

        editItem(item) {
            Inertia.get(`/employee/edit/${item.id}`);
        },

        destroy() {
            Inertia.delete(`employee/${this.deleteIndex}`, {
                preserveState: true,
                onStart: () => {
                    this.deleteSnackbar = false;
                },
                onSuccess: () => {
                    this.helper.methods.showSuccessMessage("Employee deleted");
                    Inertia.get(
                        "/employees",
                        {},
                        {
                            preserveState: true,
                        }
                    );
                },
            });
        },
    },
};
</script>
