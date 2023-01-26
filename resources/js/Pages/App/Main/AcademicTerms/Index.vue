<template>
    <section>
        <HeaderPanels :headerData="headerData" />

        <delete-confirm :deleteSnackbar="deleteSnackbar" @closing="closeDeleteSnackbar()" @deleteData="destroy()"
            :useDefault="academicTerms" user="Academic term" />

        <delete-confirm :deleteSnackbar="blockDeleteSnackbar" @closing="blockDeleteSnackbar = false"
            @deleteData="deleteSelected()" :useDefault="!academicTerms"
            customParagraph="Are you sure you want to delete the selected records ?" />


        <div class="main-holder">
            <div class="full-page-card page-padding">
                <div class=" table-header">

                    <div class="table-actions row">
                        <div class="col-6">
                            <span class="header mr-2"> {{ this.filteredAcademicTerms().length }} Academic temrs </span>


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


                                    <v-list-item v-if="helper.methods.can('academicTerm-delete')"
                                        @click="blockDeleteSnackbar = true">
                                        <v-list-item-title> <v-icon>mdi-delete</v-icon> Delete records
                                        </v-list-item-title>
                                    </v-list-item>

                                </v-list>
                            </v-menu>

                        </div>

                 


                        <div class="col-6  create-button-holder ">






                            <Link v-if="helper.methods.can('academicTerm-store')" href="/academicTerm/create"
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



                                    <v-autocomplete clearable placeholder="Academic year" :items="academicYears" solo
                                        dense item-text="name" item-value="id" class="textfield"
                                        v-model="filter.academic_year_id" />
                                </v-col>

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

                <v-data-table :headers="headers" :items="filteredAcademicTerms()" :items-per-page="10"
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
                                selectedIds.length == filteredAcademicTerms().length ? "mdi-close-box-multiple" :
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


                    <template v-slot:item.academicYear="{ item }">
                        <td class="py-2 ">

                            <span class="record-relation-label" @click="manageAcademicYear(item)"> {{
                                item.academic_year.name
                            }} </span>

                        </td>
                    </template>


                    <template v-slot:item.actions="{ item }">
                        <td class="actions">







                            <v-tooltip top>
                                <template v-slot:activator="{
                                    on,
                                    attrs,
                                }">
                                    <span v-if="helper.methods.can('academicTerm-update')" v-bind="attrs" v-on="on">
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
                                    <span v-if="helper.methods.can('academicTerm-delete')" v-bind="attrs" v-on="on">
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
        academicTerms: Array,
        academicYears: Array
    },

    mounted() {
        this.filter.academic_year_id = parseInt(new URLSearchParams(window.location.search).get('academic_year_id'));
    },

    computed: {

        headerData() {
            return {
                pageTitle: "Sahara School -- Manage academic terms",
                title: "Manage academic terms",

                links: [

                    {
                        icon: "mdi-file-multiple",
                        paragraph: "Academic terms",
                        src: "/academicTerms",
                    }

                ]

            }
        },


        selectedIds() {

            let data = []
            this.filteredAcademicTerms().forEach((item) => {
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
            academic_year_id: ""
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
                text: "Academic Year",
                sortable: true,
                value: "academicYear",
            },




            {
                text: "Actions",
                value: "actions",
                sortable: false,
            },
        ],


        blockDeleteSnackbar: false,
        deleteSnackbar: false,
        deleteIndex: -1,



    }),


    methods: {



        filteredAcademicTerms() {
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

            if (this.filter.academic_year_id) {
                conditions.push(this.filterAcademicYear);
            }


            if (conditions.length > 0) {
                return this.academicTerms.filter((item) => {
                    return conditions.every((condition) => {
                        return condition(item);
                    });
                });
            }

            return this.academicTerms;
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


        filterAcademicYear(item) {
            if (item.academic_year_id) {
                return item.academic_year_id == this.filter.academic_year_id;
            }

        },






        // select +++++
        blockSelect() {

            if (this.selectedIds.length != this.filteredAcademicTerms().length) {
                this.selectAll()
            }

            else {
                this.unSelectAll()

            }
        },

        unSelectAll() {
            this.filteredAcademicTerms().forEach((item) => {
                item.select = false

            })

        },

        selectAll() {
            this.filteredAcademicTerms().forEach((item) => {
                item.select = true

            })

        },

        selectAction(key) {
            let link = ""
            if (key == "excel") {
                link = `/academicTerms/export/excel/${this.selectedIds}`
            } else {
                link = `/academicTerms/export/pdf/${this.selectedIds}`
            }

            location.href = link
        },


        exportAllExcel() {

            let ids = []
            this.filteredAcademicTerms().forEach((item) => {
                ids.push(item.id)
            })
            location.href = `/academicTerms/export/excel/${ids}`
        },


        deleteSelected() {
            this.Inertia.delete(`/academicTerms/${this.selectedIds}`, {
                preserveState: true,
                onSuccess: () => {
                    this.blockDeleteSnackbar = false
                    this.helper.methods.fireMessage(
                        "Records deleted", "success"
                    );
                    this.Inertia.get('/academicTerms', {}, {
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
            this.Inertia.delete(`/academicTerms/${[this.deleteIndex]}`, {
                preserveState: true,
                onSuccess: () => {

                    this.closeDeleteSnackbar()
                    this.helper.methods.fireMessage(
                        "Record deleted", "success"
                    );
                    this.Inertia.get('/academicTerms', {}, {
                        preserveState: true
                    });


                },
            });
        },


        editItem(item) {
            this.Inertia.get(`/academicTerm/edit/${item.id}`)
        },
        manageAcademicYear(item) {
            this.Inertia.get(`/academicYear/edit/${item.academic_year_id}`)
        },

        // select +++++


    },
};
</script>
