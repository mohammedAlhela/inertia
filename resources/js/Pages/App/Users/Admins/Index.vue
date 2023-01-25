<template>
    <section>
        <HeaderPanels :headerData="headerData" class="admins-page-panels-container" />

        <delete-confirm :deleteSnackbar="deleteSnackbar" @closing="closeDeleteSnackbar()" @deleteData="destroy()"
            :useDefault="admins" user="record" />

        <delete-confirm :deleteSnackbar="blockDeleteSnackbar" @closing="blockDeleteSnackbar = false"
            @deleteData="deleteSelected()" :useDefault="!admins"
            customParagraph="Are you sure you want to delete the selected records ?" />

        <div class="main-holder">
            <div class="admins-page">
                <div class="header row">
                    <div class="col-4">
                        <span class="records-count"> {{ this.filteredAdmins().length }} Admins </span>


                        <v-tooltip top>
                            <template v-slot:activator="{
                                on,
                                attrs,
                            }">
                                <span v-bind="attrs" v-on="on" v-if="!selectedIds.length">
                                    <v-icon class="download-all-icon" @click="exportAllExcel()">
                                        mdi-download
                                    </v-icon>

                                </span>
                            </template>
                            <span>
                                Export data in excel file
                            </span>
                        </v-tooltip>

                        <span class="selected-count" v-if="selectedIds.length">

                            {{ selectedIds.length }} Selected
                        </span>


                    </div>

                    <div class="col-4 ">



                        <div class="selected-menu">



                            <v-menu offset-y v-model="selectMenu" :disabled="!selectedIds.length"
                                v-if="selectedIds.length">
                                <template v-slot:activator="{ on, attrs }">

                                    <v-btn v-bind="attrs" v-on="on" :disabled="!selectedIds.length">
                                        <v-icon> mdi-cogs</v-icon> Actions
                                    </v-btn>
                                </template>
                                <v-list>


                                    <v-list-item-title class="selected-menu-header"> Export data </v-list-item-title>


                                    <v-list-item @click="selectAction('excel')">
                                        <v-list-item-title> <v-icon>mdi-download</v-icon> export Excel
                                        </v-list-item-title>
                                    </v-list-item>

                                    <v-list-item @click="selectAction('pdf')">
                                        <v-list-item-title> <v-icon>mdi-download</v-icon> export pdf
                                        </v-list-item-title>
                                    </v-list-item>



                                    <v-list-item-title class="selected-menu-header"> Actions </v-list-item-title>

                                    <v-list-item @click="selectAction('block')">
                                        <v-list-item-title> <v-icon>mdi-lock</v-icon> Block records </v-list-item-title>
                                    </v-list-item>


                                    <v-list-item @click="selectAction('unblock')">
                                        <v-list-item-title> <v-icon>mdi-lock-open</v-icon> Unblock records
                                        </v-list-item-title>
                                    </v-list-item>

                                    <v-list-item @click="blockDeleteSnackbar = true">
                                        <v-list-item-title> <v-icon>mdi-delete</v-icon> Delete records
                                        </v-list-item-title>
                                    </v-list-item>

                                    <v-list-item @click="sendMessage()">
                                        <v-list-item-title> <v-icon>mdi-message</v-icon> Send email message
                                        </v-list-item-title>
                                    </v-list-item>
                                </v-list>
                            </v-menu>
                        </div>

                    </div>



                    <div class="col-4 ">



                        <div class="selected-menu">



                            <Link href="/admin/create" class="text-link"> <v-btn>
                                <v-icon> mdi-plus</v-icon> Create
                            </v-btn> </Link>

                        </div>

                    </div>


                    <v-expand-transition>



                        <div class=" filters">
                            <v-form>
                                <v-row class="">
                                    <v-col cols="4">


                                        <v-text-field clearable placeholder="First name" required solo dense v-model="
                                            filter.first_name
                                        " class="textfield" />
                                    </v-col>


                                    <v-col cols="4">


                                        <v-text-field clearable placeholder="Last name" required solo dense v-model="
                                            filter.last_name
                                        " class="textfield" />
                                    </v-col>


                                    <v-col cols="4">



                                        <v-text-field clearable placeholder="Username" required solo dense v-model="
                                            filter.username
                                        " class="textfield" />
                                    </v-col>


                                    <v-col cols="4">

                                        <v-text-field clearable placeholder="Phone" required solo dense v-model="
                                            filter.phone
                                        " class="textfield" />
                                    </v-col>


                                    <v-col cols="4">


                                        <v-select clearable placeholder="Gender" :items="helper.methods.genders()"
                                            required solo dense v-model="
                                                filter.gender
                                            " class="textfield" />
                                    </v-col>

                                </v-row>
                            </v-form>




                        </div>
                    </v-expand-transition>



                </div>





                <v-data-table :headers="headers" :items="filteredAdmins()" :items-per-page="10" item-key="item.id"
                    :footer-props="{
                        showFirstLastPage: true,
                        firstIcon: 'mdi-arrow-left',
                        lastIcon: 'mdi-arrow-right',
                        prevIcon: 'mdi-minus',
                        nextIcon: 'mdi-plus',
                        itemsPerPageText: ' rows',
                    }">
                    <template v-slot:header.select>
                        <th class="py-2 ">
                            <v-icon @click="blockSelect()" color="primary" class="header-select">
                                {{
                                    selectedIds .length == filteredAdmins().length ? "mdi-close-box-multiple" :
                                        "mdi-checkbox-multiple-marked"
                                }}
                            </v-icon>
                        </th>
                    </template>

                    <template v-slot:item.select="{ item }">
                        <td class="py-2 ">
                            <v-checkbox hide-details v-model="
                                item.select
                            "></v-checkbox>


                        </td>
                    </template>


                    <template v-slot:item.image="{ item }">
                        <td class="py-2">
                            <img class="profile-image" :src="item.image || '/images/main/user.webp'" alt="" />
                        </td>
                    </template>

                    <template v-slot:item.first_name="{ item }">
                        <td class="py-1">
                            <span>
                                {{ `${item.first_name} ${item.last_name}` }}
                            </span>
                        </td>
                    </template>

                    <template v-slot:item.username="{ item }">
                        <td class="py-1">
                            <span>
                                {{ `${item.username}` }}
                            </span>

                            <span> {{ "2022/20/11" }} </span>
                        </td>
                    </template>



                    <template v-slot:item.status="{ item }">
                        <td>
                            <span class="active-status-button" v-if="item.user.status"> Active </span>
                            <span class="blocked-status-button" v-else> Blocked </span>
                        </td>
                    </template>


                    <template v-slot:item.actions="{ item }">
                        <td class="actions">


                            <v-tooltip top>
                                <template v-slot:activator="{
                                    on,
                                    attrs,
                                }">
                                    <span v-bind="attrs" v-on="on">
                                        <v-icon @click="
                                        
                                            manageCredentials(item)
                                        
                                        
                                        " class="mr-2 icon">
                                            mdi-lock
                                        </v-icon>

                                    </span>
                                </template>
                                <span>
                                    Manage user credentials
                                </span>
                            </v-tooltip>


                            <v-tooltip top>
                                <template v-slot:activator="{
                                    on,
                                    attrs,
                                }">
                                    <span v-bind="attrs" v-on="on">
                                        <v-icon @click="
                                        
                                            managePermissions(item)
                                        
                                        
                                        " class="mr-2 icon">
                                            mdi-eye
                                        </v-icon>

                                    </span>
                                </template>
                                <span>
                                    Manage record Permissions
                                </span>
                            </v-tooltip>



                            <v-tooltip top>
                                <template v-slot:activator="{
                                    on,
                                    attrs,
                                }">
                                    <span v-bind="attrs" v-on="on">
                                        <v-icon @click="
                                        
                                            editItem(item)
                                        
                                        
                                        " class="mr-2 icon">
                                            mdi-pencil
                                        </v-icon>

                                    </span>
                                </template>
                                <span>
                                    Update record
                                </span>
                            </v-tooltip>



                            <v-tooltip top>
                                <template v-slot:activator="{
                                    on,
                                    attrs,
                                }">
                                    <span v-bind="attrs" v-on="on">
                                        <v-icon @click="

    showDeleteSnackbar(item)
                                        
                                        
                                        " class="mr-2 icon">
                                            mdi-delete
                                        </v-icon>

                                    </span>
                                </template>
                                <span>
                                    Delete record
                                </span>
                            </v-tooltip>




                        </td>
                    </template>

                </v-data-table>
            </div>
        </div>
    </section>
</template>

<script>


export default {
    components: {},

    props: {
        admins: Array,
    },

    computed: {

        headerData() {
            return {
                pageTitle: "Sahara School -- Manage admins",
                title: "Manage admins",

                links: [


                    {
                        icon: "mdi-account-multiple",
                        paragraph: "admins",
                        src: "/admins",
                    }

                ]

            }
        },


        selectedIds() {

            let data = []
            this.filteredAdmins().forEach((item) => {
                item.select ? data.push(item.id) : 1 == 1

            })
            return data
        }

    },
    data: () => ({


        filter: {



            username: "",
            first_name: "",
            last_name: "",
            gender: "",

            phone: "",

        },



        headers: [
            {
                text: "Select",
                sortable: false,
                value: "select",
            },

            {
                text: "Image",
                sortable: false,
                value: "image",
            },

            {
                text: "Full name",
                sortable: true,
                value: "first_name",
            },

            {
                text: "Username",
                sortable: true,
                value: "username",
            },

            {
                text: "Phone",
                sortable: true,
                value: "phone",
            },

            {
                text: "Gender",
                sortable: true,
                value: "gender",
            },

            {
                text: "Birth date",
                sortable: true,
                value: "birth_date",
            },

            {
                text: "Status",
                sortable: true,
                value: "status",
            },

            {
                text: "Actions",
                value: "actions",
                sortable: false,
            },
        ],

        selectMenu: false,

        deleteSnackbar: false,
        deleteIndex: -1,
        blockDeleteSnackbar: false,


    }),


    methods: {



        filteredAdmins() {
            let conditions = [];

            if (this.filter.first_name) {
                conditions.push(this.filterFirstName);
            }
            if (this.filter.last_name) {
                conditions.push(this.filterLastName);
            }

            if (this.filter.username) {
                conditions.push(this.filterUsername);
            }

            if (this.filter.phone) {
                conditions.push(this.filterPhone);
            }

            if (this.filter.gender) {
                conditions.push(this.filterGender);
            }

            if (conditions.length > 0) {
                return this.admins.filter((admin) => {
                    return conditions.every((condition) => {
                        return condition(admin);
                    });
                });
            }

            return this.admins;
        },


        // filter +++++
        filterFirstName(admin) {
            if (admin.first_name) {
                return admin.first_name.toLowerCase().includes(this.filter.first_name.toLowerCase());
            }

        },

        filterLastName(admin) {
            if (admin.last_name) {
                return admin.last_name.toLowerCase().includes(this.filter.last_name.toLowerCase());
            }

        },


        filterUsername(admin) {
            if (admin.username) {
                return admin.username.toLowerCase().includes(this.filter.username.toLowerCase());
            }

        },



        filterPhone(admin) {
            if (admin.phone) {
                return admin.phone.toLowerCase().includes(this.filter.phone.toLowerCase());
            }

        },


        filterGender(admin) {
            if (admin.gender) {
                return admin.gender.toLowerCase().includes(this.filter.gender.toLowerCase());
            }

        },





        // select +++++
        blockSelect() {

            if (this.selectedIds.length == 0 || this.selectedIds.length < this.filteredAdmins.length) {
                this.selectAll()
            }

            else {
                this.unSelectAll()

            }
        },

        unSelectAll() {
            this.filteredAdmins().forEach((item) => {
                item.select = false

            })

        },

        selectAll() {
            this.filteredAdmins().forEach((item) => {
                item.select = true

            })

        },

        selectAction(key) {
            let link = ""
            if (key == 'block') {
                link = `/admins/block/${this.selectedIds}`
            } else if (key == 'unblock') {
                link = `/admins/unBlock/${this.selectedIds}`
            } else if (key == "excel") {
                link = `/admins/export/excel/${this.selectedIds}`
            } else {
                link = `/admins/export/pdf/${this.selectedIds}`
            }


            if (key == 'block' || key == 'unblock') {
                this.Inertia.get(link, {}, {
                    preserveState: true,
                    onSuccess: () => {
                        this.helper.methods.fireMessage(
                            "Data updated", "success"
                        );
                        this.Inertia.get('/admins', {}, {
                            preserveState: true
                        });
                    },
                });
            }

            else {

                location.href = link
            }


        },


        exportAllExcel() {

            let ids = []
            this.filteredAdmins().forEach((admin) => {
                ids.push(admin.id)
            })
            location.href = `/admins/export/excel/${ids}`
        },


        sendMessage() {

        },

        deleteSelected() {
            this.Inertia.delete(`/admins/${this.selectedIds}`, {
                preserveState: true,
                onSuccess: () => {
                    this.blockDeleteSnackbar = false
                    this.helper.methods.fireMessage(
                        "Records deleted", "success"
                    );
                    this.Inertia.get('/admins', {}, {
                        preserveState: true
                    });
                },
            });
        },


        showDeleteSnackbar(item) {
            this.deleteIndex = item.id;
            this.deleteSnackbar = true;
        },

        closeDeleteSnackbar() {
            this.deleteSnackbar = false;
        },


        destroy() {
            this.Inertia.delete(`/admins/${[this.deleteIndex]}`, {
                preserveState: true,
                onSuccess: () => {

                    this.closeDeleteSnackbar()
                    this.helper.methods.fireMessage(
                        "Record deleted", "success"
                    );
                    this.Inertia.get('/admins', {}, {
                        preserveState: true
                    });


                },
            });
        },


        editItem(item) {
            this.Inertia.get(`/admin/edit/${item.id}`)
        },

        managePermissions(item) {
            this.Inertia.get(`/admin/permissions/${item.id}`)
        },

        manageCredentials(item) {
            this.Inertia.get(`/admin/credentials/${item.id}`)
        },
        // select +++++


    },
};
</script>
