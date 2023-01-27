<template>
    <section>
        <HeaderPanels :headerData="headerData" />

        <delete-confirm :deleteSnackbar="deleteSnackbar" @closing="closeDeleteSnackbar()" @deleteData="destroy()"
            :useDefault="records" user="Department" />

        <delete-confirm :deleteSnackbar="blockDeleteSnackbar" @closing="blockDeleteSnackbar = false"
            @deleteData="deleteSelected()" :useDefault="!records"
            customParagraph="Are you sure you want to delete the selected records ?" />


        <delete-confirm :deleteSnackbar="cantDeleteSnackbar" @closing="cantDeleteSnackbar = false"
            :useDefault="!records" :customParagraph="cantDeleteParagraph" />



        <cant-delete-snackbar :deleteSnackbar="cantDeleteSnackbar" @close="cantDeleteSnackbar = false"
            :message="cantDeleteParagraph" />




        <div class="main-holder">
            <div class="full-page-card page-padding">
                <div class=" table-header">
                    <div class="table-actions row">
                        <div class="col-6">
                            <span class="header mr-2"> {{ records.length }} Departments </span>


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


                                    <v-list-item v-if="helper.methods.can('department-delete')"
                                        @click="blockDeleteSnackbar = true">
                                        <v-list-item-title> <v-icon>mdi-delete</v-icon> Delete records
                                        </v-list-item-title>
                                    </v-list-item>

                                </v-list>
                            </v-menu>

                        </div>



                        <div class="col-6  create-button-holder ">






                            <Link v-if="helper.methods.can('department-store')" href="/department/create"
                                class="text-link">
                            <v-btn>
                                <v-icon> mdi-plus</v-icon> Create
                            </v-btn> </Link>


                        </div>


                    </div>



                </div>




                <v-data-table class="mt-4" :headers="headers" :items="records" :items-per-page="10" item-key="item.id"
                    :footer-props="{
                        showFirstLastPage: true,
                        firstIcon: 'mdi-arrow-left',
                        lastIcon: 'mdi-arrow-right',
                        prevIcon: 'mdi-minus',
                        nextIcon: 'mdi-plus',
                        itemsPerPageText: ' rows',
                    }">
                    <template v-slot:header.select>

                        <v-icon v-if="records.length" @click="blockSelect()" color="primary">
                            {{
                                selectedIds.length == records.length ? "mdi-close-box-multiple" :
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


                    <template v-slot:item.courses="{ item }">
                        <td class="py-2 ">

                            <span @click="manageCourse(record.id)" class="record-relation-label"
                                v-for="(record, index ) in item.courses" :key="index">
                                {{ record.name }}
                            </span>

                        </td>
                    </template>


                    <template v-slot:item.subjects="{ item }">
                        <td class="py-2 ">

                            <span @click="manageSubject(record.id)" class="record-relation-label"
                                v-for="(record, index ) in item.subjects" :key="index">
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
                                    <span v-if="helper.methods.can('course-show')" v-bind="attrs" v-on="on">
                                        <v-icon @click="
                                        
                                            manageCourses(item)
                                        
                                        
                                        " class="mr-2 icon">
                                            mdi-file-multiple
                                        </v-icon>

                                    </span>
                                </template>
                                <span>
                                    Manage record courses
                                </span>
                            </v-tooltip>


                            <v-tooltip top>
                                <template v-slot:activator="{
                                    on,
                                    attrs,
                                }">
                                    <span v-if="helper.methods.can('subject-show')" v-bind="attrs" v-on="on">

                                        <v-icon @click="manageSubjects(item)
                                        " class="mr-2 icon">
                                            mdi-text-box-multiple-outline
                                        </v-icon>

                                    </span>
                                </template>
                                <span>
                                    Manage record subjects
                                </span>
                            </v-tooltip>




                            <v-tooltip top>
                                <template v-slot:activator="{
                                    on,
                                    attrs,
                                }">
                                    <span v-if="helper.methods.can('department-update')" v-bind="attrs" v-on="on">
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
                                    <span v-if="helper.methods.can('department-delete')" v-bind="attrs" v-on="on">
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

                {{ hasRelatedRecords }}
            </div>
        </div>
    </section>
</template>

<script>


export default {
    components: {},

    props: {
        records: Array,
    },

    computed: {

        headerData() {
            return {
                pageTitle: "Sahara School -- Manage departments",
                title: "Manage departments",

                links: [

                    {
                        icon: "mdi-file-multiple",
                        paragraph: "Departments",
                        src: "/departments",
                    }

                ]

            }
        },


        selectedIds() {

            let data = []
            this.records.forEach((item) => {
                item.select ? data.push(item.id) : 1 == 1

            })
            return data
        },

        cantDeleteParagraph() {
            let message = `Yoy cant delete this records because of the related records in models : <div class = 'my-4'> <span class = "record-relation-label ${!this.hasRelatedRecords.hasCourses ? 'hidden' : 1 == 1}">Course </span> <span class = "record-relation-label ${!this.hasRelatedRecords.hasSubjects ? 'hidden' : 1 == 1}">Subject</span>   </div> `
            return message
        },


        hasRelatedRecords() {




            if (this.deleteIndex == -1) {
                return false
            }
            else {
                let record = this.records.filter((record) => {
                    return record.id == this.deleteIndex
                })


                let hasSubjects = record[0].subjects.length
                let hasCourses = record[0].courses.length



                let data = {
                    hasSubjects: hasSubjects,
                    hasCourses: hasCourses,
                    block: hasSubjects || hasCourses

                }


                return data





            }




        }

    },




    data: () => ({



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
                text: "Courses",
                sortable: true,
                value: "courses",
            },

            {
                text: "Subjects",
                sortable: true,
                value: "subjects",
            },



            {
                text: "Actions",
                value: "actions",
                sortable: false,
            },
        ],

        cantDeleteSnackbar: false,
        blockDeleteSnackbar: false,
        deleteSnackbar: false,
        deleteIndex: -1,



    }),


    methods: {

        // select +++++
        blockSelect() {

            if (this.selectedIds.length != this.records.length) {
                this.selectAll()
            }

            else {
                this.unSelectAll()

            }
        },

        unSelectAll() {
            this.records.forEach((item) => {
                item.select = false

            })

        },

        selectAll() {
            this.records.forEach((item) => {
                item.select = 1

            })

        },

        selectAction(key) {
            let link = ""
            if (key == "excel") {
                link = `/departments/export/excel/${this.selectedIds}`
            } else {
                link = `/departments/export/pdf/${this.selectedIds}`
            }

            location.href = link
        },


        exportAllExcel() {

            let ids = []
            this.records.forEach((item) => {
                ids.push(item.id)
            })
            location.href = `/departments/export/excel/${ids}`
        },


        deleteSelected() {
            this.Inertia.delete(`/departments/${this.selectedIds}`, {
                preserveState: true,
                onSuccess: () => {
                    this.blockDeleteSnackbar = false
                    this.helper.methods.fireMessage(
                        "Records deleted", "success"
                    );
                    this.Inertia.get('/departments', {}, {
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
            this.deleteIndex = -1
        },


        destroy() {
            if (this.hasRelatedRecords.block) {
                this.closeDeleteSnackbar()
                this.cantDeleteSnackbar = true
            }

            else {

                this.Inertia.delete(`/departments/${[this.deleteIndex]}`, {
                    preserveState: true,
                    onSuccess: () => {
                        this.closeDeleteSnackbar()

                        this.helper.methods.fireMessage(
                            "Record deleted", "success"
                        );
                        this.Inertia.get('/departments', {}, {
                            preserveState: true
                        });


                    },
                });
            }


        },


        editItem(item) {
            this.Inertia.get(`/department/edit/${item.id}`)
        },



        manageCourses(item) {
            this.Inertia.get(`/courses?department_id=${item.id}`)
        },

        manageSubjects(item) {
            this.Inertia.get(`/subjects?department_id=${item.id}`)
        },

        manageCourse(id) {
            this.Inertia.get(`/course/edit/${id}`)
        },

        manageSubject(id) {
            this.Inertia.get(`/subject/edit/${id}`)
        },


    },
};
</script>
