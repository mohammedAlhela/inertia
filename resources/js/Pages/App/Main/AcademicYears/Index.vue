<template>
    <section>
        <HeaderPanels :headerData="headerData" />

        <delete-confirm :deleteSnackbar="deleteSnackbar" @closing="closeDeleteSnackbar()" @deleteData="destroy()"
            :useDefault="academicYears" user="Academic year" />

            <delete-confirm :deleteSnackbar="blockDeleteSnackbar" @closing="blockDeleteSnackbar = false"
            @deleteData="deleteSelected()" :useDefault="!academicYears"
            customParagraph="Are you sure you want to delete the selected records ?" />


        <div class="main-holder">
            <div class="full-page-card page-padding">
                <div class=" table-header">

                    <div class="table-actions row">
                        <div class="col-4">
                            <span class="header mr-2"> {{ this.filteredAcademicYears().length }} Academic years </span>


                            <v-tooltip top>
                                <template v-slot:activator="{
                                    on,
                                    attrs,
                                }">
                                    <span v-bind="attrs" v-on="on" v-if="!selectedIds.length">
                                        <v-icon class="icon-button-action" @click="exportAllExcel()">
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






                            <v-menu offset-y v-if="selectedIds.length">
                                <template v-slot:activator="{ on, attrs }">


                                    <span class="icon-text-button-action" v-bind="attrs" v-on="on"> <v-icon>
                                            mdi-cogs</v-icon> Actions </span>

                                </template>
                                <v-list>


                                    <v-list-item-title class="selected-menu-header"> Export data
                                    </v-list-item-title>


                                    <v-list-item @click="selectAction('excel')">
                                        <v-list-item-title> <v-icon>mdi-download</v-icon> export Excel
                                        </v-list-item-title>
                                    </v-list-item>

                                    <v-list-item @click="selectAction('pdf')">
                                        <v-list-item-title> <v-icon>mdi-download</v-icon> export pdf
                                        </v-list-item-title>
                                    </v-list-item>



                                    <v-list-item-title class="selected-menu-header"> Actions </v-list-item-title>


                                    <v-list-item v-if="helper.methods.can('academicYear-delete')"
                                        @click="blockDeleteSnackbar = true">
                                        <v-list-item-title> <v-icon>mdi-delete</v-icon> Delete records
                                        </v-list-item-title>
                                    </v-list-item>

                                </v-list>
                            </v-menu>


                        </div>



                        <div class="col-4  create-button-holder ">






                            <Link v-if="helper.methods.can('academicYear-store')" href="/academicYear/create"
                                class="text-link">
                            <v-btn>
                                <v-icon> mdi-plus</v-icon> Create
                            </v-btn> </Link>


                        </div>


                    </div>





                    <div class=" filters">
                        <v-form>
                            <v-row class="">
                                <v-col cols="4">


                                    <v-text-field hide-details clearable placeholder="Name" required solo dense v-model="
                                        filter.name
                                    " class="textfield" />
                                </v-col>


                                <v-col cols="4">


                                    <v-text-field hide-details clearable placeholder="Start date" required solo dense
                                        v-model="
                                            filter.start_date
                                        " class="textfield" />
                                </v-col>


                                <v-col cols="4">



                                    <v-text-field hide-details clearable placeholder="End date" required solo dense
                                        v-model="
                                            filter.end_date
                                        " class="textfield" />
                                </v-col>


                            </v-row>
                        </v-form>




                    </div>




                </div>

                <v-data-table :headers="headers" :items="filteredAcademicYears()" :items-per-page="10"
                    item-key="item.id" :footer-props="{
                        showFirstLastPage: true,
                        firstIcon: 'mdi-arrow-left',
                        lastIcon: 'mdi-arrow-right',
                        prevIcon: 'mdi-minus',
                        nextIcon: 'mdi-plus',
                        itemsPerPageText: ' rows',
                    }">
                    <template v-slot:header.select>

                        <v-icon @click="blockSelect()" color="primary">
                            {{
                                selectedIds .length == filteredAcademicYears().length ? "mdi-close-box-multiple" :
                                    "mdi-checkbox-multiple-marked"
                            }}
                        </v-icon>

                    </template>


                    <template v-slot:item.select="{ item }">
                        <td class="py-2 ">
                            <v-checkbox hide-details v-model="
                                item.select
                            "></v-checkbox>


                        </td>
                    </template>


                    <template v-slot:item.academicTerms="{ item }">
                        <td class="py-2 ">
                         
                        <span @click = "manageAcademicTerms(record.id)" class = "record-relation-label" v-for = "(record , index ) in item.academic_terms" :key = "index">
                         {{ record.name }}
                        </span>
                    
                        </td>
                    </template>


                    <template v-slot:item.actions="{ item }">
                        <td class="actions">



                            <v-tooltip top>
                                <template v-slot:activator="{
                                    on,
                                    attrs,
                                }">
                                    <span v-if="helper.methods.can('academicTerm-show')" v-bind="attrs" v-on="on">
                                        <v-icon @click="
                                        
                                            manageAcademicTerms(item)
                                        
                                        
                                        " class="mr-2 icon">
                                            mdi-file-multiple
                                        </v-icon>

                                    </span>
                                </template>
                                <span>
                                    Manage record academic terms
                                </span>
                            </v-tooltip>



                            <v-tooltip top>
                                <template v-slot:activator="{
                                    on,
                                    attrs,
                                }">
                                    <span v-if="helper.methods.can('academicYear-update')" v-bind="attrs" v-on="on">
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
                                    <span v-if="helper.methods.can('academicYear-delete')" v-bind="attrs" v-on="on">
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
        academicYears: Array,
    },

    computed: {

        headerData() {
            return {
                pageTitle: "Sahara School -- Manage academic years",
                title: "Manage academic years",

                links: [

                    {
                        icon: "mdi-file-multiple",
                        paragraph: "Academic years",
                        src: "/academicYears",
                    }

                ]

            }
        },


        selectedIds() {

            let data = []
            this.filteredAcademicYears().forEach((item) => {
                item.select ? data.push(item.id) : 1 == 1

            })
            return data
        }

    },
    data: () => ({


        filter: {
            name: "",
            start_date: "",
            end_date: "",
        },



        headers: [
            {
                text: "Select",
                sortable: false,
                value: "select",
            },



            {
                text: "Name",
                sortable: true,
                value: "name",
            },

            {
                text: "Start Date",
                sortable: true,
                value: "start_date",
            },

            {
                text: "End date ",
                sortable: true,
                value: "end_date",
            },

            {
                text: "Academic terms",
                sortable: true,
                value: "academicTerms",
            },




            {
                text: "Actions",
                value: "actions",
                sortable: false,
            },
        ],


        blockDeleteSnackbar : false ,
        deleteSnackbar: false,
        deleteIndex: -1,



    }),


    methods: {



        filteredAcademicYears() {
            let conditions = [];

            if (this.filter.name) {
                conditions.push(this.filterName);
            }

            if (this.filter.start_date) {
                conditions.push(this.filterStartDate);
            }

            if (this.filter.end_date) {
                conditions.push(this.filterEndDate);
            }


            if (conditions.length > 0) {
                return this.academicYears.filter((item) => {
                    return conditions.every((condition) => {
                        return condition(item);
                    });
                });
            }

            return this.academicYears;
        },


        // filter +++++
        filterName(item) {
            if (item.name) {
                return item.name.toLowerCase().includes(this.filter.name.toLowerCase());
            }

        },

        filterStartDate(item) {
            if (item.start_date) {
                return item.start_date.toLowerCase().includes(this.filter.start_date.toLowerCase());
            }

        },


        filterEndDate(item) {
            if (item.end_date) {
                return item.end_date.toLowerCase().includes(this.filter.end_date.toLowerCase());
            }

        },


        // select +++++
        blockSelect() {

            if (this.selectedIds.length == 0 || this.selectedIds.length < this.filteredAcademicYears.length) {
                this.selectAll()
            }

            else {
                this.unSelectAll()

            }
        },

        unSelectAll() {
            this.filteredAcademicYears().forEach((item) => {
                item.select = false

            })

        },

        selectAll() {
            this.filteredAcademicYears().forEach((item) => {
                item.select = true

            })

        },

        selectAction(key) {
            let link = ""
            if (key == "excel") {
                link = `/academicYears/export/excel/${this.selectedIds}`
            } else {
                link = `/academicYears/export/pdf/${this.selectedIds}`
            }

            location.href = link
        },


        exportAllExcel() {

            let ids = []
            this.filteredAcademicYears().forEach((item) => {
                ids.push(item.id)
            })
            location.href = `/academicYears/export/excel/${ids}`
        },


        deleteSelected() {
            this.Inertia.delete(`/academicYears/${this.selectedIds}`, {
                preserveState: true,
                onSuccess: () => {
                    this.blockDeleteSnackbar = false
                    this.helper.methods.fireMessage(
                        "Records deleted", "success"
                    );
                    this.Inertia.get('/academicYears', {}, {
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
            this.Inertia.delete(`/academicYears/${[this.deleteIndex]}`, {
                preserveState: true,
                onSuccess: () => {

                    this.closeDeleteSnackbar()
                    this.helper.methods.fireMessage(
                        "Record deleted", "success"
                    );
                    this.Inertia.get('/academicYears', {}, {
                        preserveState: true
                    });


                },
            });
        },


        editItem(item) {
            this.Inertia.get(`/academicYear/edit/${item.id}`)
        },

        manageAcademicTerms(item) {
            this.Inertia.get(`/academicTerms?academic_year_id=${item.id}`)
        },
        manageAcademicTerm(id) {
            this.Inertia.get(`/academicTerm/edit/${id}`)
        },


        

        // select +++++


    },
};
</script>
