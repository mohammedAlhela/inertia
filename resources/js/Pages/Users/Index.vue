<template>
    <section class="users-page-container">
        <Head>
            <title>Users</title>
        </Head>

        <v-row>
            <v-col cols="6 pt-5">
                <span class="items-number">
                    <v-tooltip top>
                        <template v-slot:activator="{ on, attrs }">
                            <span v-bind="attrs" v-on="on">
                                <span class="main-header">
                                    {{ filteredUsers().length }}
                                    Users
                                </span>
                            </span>
                        </template>
                        <span> Users number</span>
                    </v-tooltip>

                    <v-tooltip top>
                        <template v-slot:activator="{ on, attrs }">
                            <span v-bind="attrs" v-on="on">
                                <span class="main-header">
                                    <v-chip
                                        small
                                        class="ma-2"
                                        dark
                                        label
                                        color="#e17655"
                                    >
                                        {{
                                            helper.methods.getPermissionsNames()
                                                .length
                                        }}
                                        Permissions
                                    </v-chip>
                                </span>
                            </span>
                        </template>
                        <span style="display: inline-block">
                            <span
                                class="d-block mx-1 my-1"
                                v-for="(
                                    item, index
                                ) in helper.methods.getPermissionsNames()"
                                :key="index"
                            >
                                {{ item.replace(":", "-") }}
                            </span>
                        </span>
                    </v-tooltip>
                </span>
            </v-col>

            <v-col cols="6" class="text-right ">
                <a href="users/export/excel" class="no-underline">
                    <v-btn dark class="mx-2" small color="orange">
                        Export
                        <v-icon class="white-icon" dark> mdi-download </v-icon>
                    </v-btn></a
                >
                <Link href="user/create" class="no-underline">
                    <v-btn
                        dark
                        class="mx-2"
                        small
                        color="green"
                        v-if="helper.methods.can('user-write')"
                    >
                        Add
                        <v-icon class="white-icon" dark> mdi-plus </v-icon>
                    </v-btn></Link
                >
            </v-col>
        </v-row>

        <v-row>
            <v-col cols="12">
                <v-data-table
                    light
                    class="elevation-3"
                    :headers="headers"
                    :items="filteredUsers()"
                    :items-per-page="10"
                    item-key="item.id"
                    mobile-breakpoint="1300"
                >
                    <!-- headers -->
                    <template v-slot:header.name="{ header }">
                        {{ header.text }}
                        <v-menu offset-y :close-on-content-click="false">
                            <template v-slot:activator="{ on, attrs }">
                                <v-btn icon v-bind="attrs" v-on="on">
                                    <v-icon
                                        small
                                        :color="name ? 'primary' : ''"
                                    >
                                        mdi-filter
                                    </v-icon>
                                </v-btn>
                            </template>
                            <div style="background-color: white; width: 280px">
                                <v-text-field
                                    v-model="name"
                                    class="pa-4"
                                    type="text"
                                    label="Enter the search term"
                                ></v-text-field>
                                <v-btn
                                    @click="name = ''"
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
                    <!-- headers -->

                    <template v-slot:item.name="{ item }">
                        <td class="py-1">
                            <span>
                                {{ item.name }}
                            </span>
                        </td>
                    </template>

                    <template v-slot:item.created_at="{ item }">
                        <td class="py-1">
                            <span>
                                {{
                                    helper.methods.formatedDate(item.created_at)
                                }}
                            </span>
                        </td>
                    </template>

                    <template v-slot:item.status="{ item }">
                        <td>
                            <v-chip
                                small
                                :color="item.status ? 'success' : 'error'"
                            >
                                {{ item.status ? "Active" : "Draft" }}
                            </v-chip>
                        </td>
                    </template>

                    <template v-slot:item.image="{ item }">
                        <td class="py-2">
                            <img
                                class="thumb-image"
                                :src="item.image || '/images/users/user.webp'"
                                alt=""
                            />
                        </td>
                    </template>

                    <template v-slot:item.last_seen="{ item }">
                        <td class="py-2">
                            <span class="paragraph">
                                {{
                                    helper.methods.formatedDate(
                                        new Date(
                                            new Date() - Math.random() * 1e12
                                        )
                                    )
                                }}</span
                            >
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
                                            @click="managePermissions(item)"
                                            class="mr-2 icon"
                                        >
                                            mdi-eye
                                        </v-icon>
                                    </span>
                                </template>
                                <span> Manage user permissions </span>
                            </v-tooltip>

                            <v-tooltip top>
                                <template v-slot:activator="{ on, attrs }">
                                    <span
                                        v-bind="attrs"
                                        v-on="on"
                                        v-if="helper.methods.can('user-write')"
                                    >
                                        <v-icon
                                            @click="updateStatus(item)"
                                            class="mr-2 icon"
                                        >
                                            mdi-swap-horizontal-bold
                                        </v-icon>
                                    </span>
                                </template>
                                <span> Change status </span>
                            </v-tooltip>

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
                                <span> edit user </span>
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
                                    <span> delete user </span>
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
            user="user"
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
        users: Array,
    },

    components: {},

    data: () => ({
        // main section

        headers: [
            {
                text: "Image",
                sortable: false,
                value: "image",
            },

            {
                text: "Email",
                sortable: true,
                value: "email",
            },

            {
                text: "name",
                sortable: true,
                value: "name",
            },

            {
                text: "Created at",
                sortable: true,
                value: "created_at",
            },

            {
                text: "Last seen",
                sortable: true,
                value: "last_seen",
            },

            {
                text: "State",
                sortable: true,
                value: "status",
            },

            {
                text: "Actions",
                value: "actions",
                sortable: false,
            },
        ],

        // main section

        // delete section
        deleteSnackbar: false,
        deleteIndex: -1,
        //  delete section

        //filter section
        name: "",
        email: "",
        //filter section
    }),

    computed: {},

    methods: {
        filteredUsers() {
            let conditions = [];

            if (this.name) {
                conditions.push(this.filterName);
            }

            if (this.email) {
                conditions.push(this.filterEmail);
            }

            if (conditions.length > 0) {
                return this.users.filter((user) => {
                    return conditions.every((condition) => {
                        return condition(user);
                    });
                });
            }

            return this.users;
        },

        filterName(item) {
            return item.name.toLowerCase().includes(this.name.toLowerCase());
        },

        filterEmail(item) {
            return item.email.toLowerCase().includes(this.email.toLowerCase());
        },

        closeDeleteSnackbar() {
            this.deleteSnackbar = false;
        },

        openWriteDialog() {
            state.dialog = true;
        },

        showDeleteSnackbar(item) {
            this.deleteIndex = item.id;
            this.deleteSnackbar = true;
        },

        editItem(item) {
            Inertia.get(`/user/edit/${item.id}`);
        },

        managePermissions(item) {
            Inertia.get(`/user/permissions/${item.id}`);
        },

        destroy() {
            Inertia.delete(`user/${this.deleteIndex}`, {
                preserveState: true,
                onStart: () => {
                    this.deleteSnackbar = false;
                },
                onSuccess: () => {
                    this.helper.methods.showSuccessMessage("User deleted");
                    Inertia.get(
                        "/users",
                        {},
                        {
                            preserveState: true,
                        }
                    );
                },
            });
        },

        updateStatus(item) {
            Inertia.get(
                `user/updateStatus/${item.id}`,
                {},
                {
                    preserveState: true,
                    onSuccess: () => {
                        this.helper.methods.showSuccessMessage(
                            "User status updated"
                        );
                        Inertia.get(
                            "/users",
                            {},
                            {
                                preserveState: true,
                            }
                        );
                    },
                }
            );
        },
    },
};
</script>
