<template>
    <section>
        <HeaderPanels :headerData="headerData" class="admins-page-panels-container" />

        <delete-confirm :deleteSnackbar="deleteSnackbar" @closing="closeDeleteSnackbar()" @deleteData="destroy()"
            :useDefault="admins" user="record" />

            <delete-confirm :deleteSnackbar="blockDeleteSnackbar" @closing="blockDeleteSnackbar = false" @deleteData="deleteSelected()"
            :useDefault="!admins" customParagraph  = "Are you sure you want to delete the selected records ?"  />

        <div class="main-holder">
            <div class="admins-page">
                <div class="header row">
                    <div class="col-6">
                        <span class="records-count"> {{ this.filteredAdmins().length }} Admins </span>
                        <v-text-field @click:clear="clearSearch()"  clearable solo dense v-model="search" type="text" @input="unSelectAll()" />
                    </div>

                    <div class="col-6 selected-menu">

                        <v-menu offset-y v-model="selectMenu" :disabled="!selectedIds.length">
                            <template v-slot:activator="{ on, attrs }">

                                <v-btn v-bind="attrs" v-on="on">
                                    <v-icon> mdi-chevron-down-circle</v-icon> Selected {{ selectedIds.length }}
                                </v-btn>
                            </template>
                            <v-list>


                                <v-list-item-title class="selected-menu-header"> Export data </v-list-item-title>


                                <v-list-item @click="selectAction('excel')">
                                    <v-list-item-title> <v-icon>mdi-download</v-icon> export Excel </v-list-item-title>
                                </v-list-item>

                                <v-list-item @click="selectAction('pdf')">
                                    <v-list-item-title> <v-icon>mdi-download</v-icon> export pdf </v-list-item-title>
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
                                    <v-list-item-title> <v-icon>mdi-delete</v-icon> Delete records </v-list-item-title>
                                </v-list-item>

                                <v-list-item @click="sendMessage()">
                                    <v-list-item-title> <v-icon>mdi-message</v-icon> Send email message
                                    </v-list-item-title>
                                </v-list-item>
                            </v-list>
                        </v-menu>

                    </div>


                </div>





                <v-data-table light class="" :headers="headers" :items="filteredAdmins()" :items-per-page="25"
                    item-key="item.id" :footer-props="{
                        showFirstLastPage: true,
                        firstIcon: 'mdi-arrow-left',
                        lastIcon: 'mdi-arrow-right',
                        prevIcon: 'mdi-minus',
                        nextIcon: 'mdi-plus',
                        itemsPerPageText: ' rows',
                    }">
                    <template v-slot:header.select>
                        <th class="py-2">
                            <v-icon @click="blockSelect()" color="primary">
                                {{
                                    selectedIds .length == filteredAdmins().length ? "mdi-close-box-multiple" :
                                        "mdi-checkbox-multiple-marked"
                                }}
                            </v-icon>
                        </th>
                    </template>

                    <template v-slot:item.select="{ item }">
                        <td class="py-2">
                            <v-checkbox hide-details v-model="
                                item.select
                            "></v-checkbox>


                        </td>
                    </template>


                    <template v-slot:item.image="{ item }">
                        <td class="py-2">
                            <img class="profile-image" :src="item.image || 'images/admins/admin.webp'" alt="" />
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
                            <v-chip small :color="item.user.status ? 'success' : 'error'">
                                {{ item.user.status ? "Active" : "Blocked" }}
                            </v-chip>
                        </td>
                    </template>


                    <template v-slot:item.actions="{ item }">
                        <td>


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

        selectedIds() {

            let data = []
            this.filteredAdmins().forEach((item) => {
                item.select ? data.push(item.id) : 1 == 1

            })
            return data
        }

    },
    data: () => ({
        search: "",

        headerData: {
            pageTitle: "Sahara School -- Manage admins",
            title: "Manage admins",
            add: {
                src: "/admin/create",
                paragraph: "Add admin",
                visibility: true,
            },

            link: {
                icon: "mdi-account-multiple",
                paragraph: "Manage admins",
                src: "/admins",
            },
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

    created() { },

    mounted() { },

    methods: {
        // filter +++++
        filterParam(value) {
            if (value) {
                return value.toLowerCase().includes(this.search.toLowerCase());
            }
        },

        filteredAdmins() {
            let filteredAdmins = this.admins.filter((admin) => {
                return (
                    this.filterParam(admin.first_name) ||
                    this.filterParam(admin.last_name) ||
                    this.filterParam(admin.username) ||
                    this.filterParam(admin.phone) ||
                    this.filterParam(admin.gender)
                );
            });

            if (this.search) {
                return filteredAdmins;
            } else {
                return this.admins;
            }

        },

        clearSearch () { 
         this.search = ""
        }, 
        // filter +++++

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


        editItem (item) { 
            this.Inertia.get(`/admin/edit/${item.id}`)
        }
        // select +++++


    },
};
</script>
