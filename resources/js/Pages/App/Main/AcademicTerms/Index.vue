<template>
    <section>
        <v-data-table :headers="$store.state.admins.headers" :items="$store.state.admins.admins" :items-per-page="10"
            item-key="item.id" mobile-breakpoint="1100" class="my-datatable-styling" no-data-text="No data "
            :footer-props="{
                showFirstLastPage: true,
                firstIcon: 'mdi-arrow-left',
                lastIcon: 'mdi-arrow-right',
                prevIcon: 'mdi-minus',
                nextIcon: 'mdi-plus',
                itemsPerPageText: ' rows'
            }">
            <!-- the select all icon -->
            <!-- <template v-slot:header.select>
                                            <th>
                                                <v-tooltip top>
                                                    <template
                                                        v-slot:activator="{
                                                            on,
                                                            attrs
                                                        }"
                                                    >
                                                        <span
                                                            v-bind="attrs"
                                                            v-on="on"
                                                        >
                                                            <v-icon
                                                                color="info"
                                                                @click="
                                                                    $store.commit(
                                                                        'admins/blockSelect'
                                                                    )
                                                                "
                                                            >
                                                                {{
                                                                    $store
                                                                        .getters[
                                                                        "admins/selectionState"
                                                                    ]
                                                                        ? "mdi-checkbox-multiple-marked"
                                                                        : " mdi-close-box-multiple"
                                                                }}
                                                            </v-icon>
                                                        </span>
                                                    </template>
                                                    <span>
                                                        Select all / unselect
                                                        all</span
                                                    >
                                                </v-tooltip>
                                            </th>
                                        </template> -->
            <!-- the select all icon -->

            <template v-slot:body="{ items }">
                <tbody>
                    <tr v-for="item in items" :key="item.id">
                        <!-- item select -->
                        <!-- <td>
                            <span class="datatable-select-position">
                                <v-checkbox color="info" hide-details @change="
                                    $store.commit(
                                        'admins/checkSelect',
                                        item
                                    )
                                " v-model="
    item.selected
"></v-checkbox>
                            </span>
                        </td> -->
                        <!-- item select -->

                        <!-- image -->
                        <td>
                            <div class="p-2">
                                <v-avatar size="70">
                                    <img :src="
                                        item.photo.image
                                    " alt="John" />
                                </v-avatar>
                            </div>
                        </td>
                        <!-- image -->

                        <!--name-->
                        <td class="paragraph">
                            {{ item.full_name }}
                            <br />
                            <span class="blue-paragraph">
                                {{
                                
                                
                                    $store.getters['admins/getRole'](item)
                                }}
                            </span>
                        </td>
                        <!--name-->

                        <!--username-->
                        <td class="paragraph">
                            {{ item.username }}
                        </td>
                        <!--username-->


                        <!--contact-->
                        <td class="paragraph">
                            {{ item.contact }}
                        </td>
                        <!--contact-->


                        <!--email-->
                        <td class="paragraph">
                            {{ item.email }}
                        </td>
                        <!--email-->

                        <!-- actions -->
                        <td class="paragraph">
                            <v-tooltip top>
                                <template v-slot:activator="{
                                    on,
                                    attrs
                                }">
                                    <span v-bind="
                                        attrs
                                    " v-on="on">
                                        <v-icon @click="
                                            $store.commit(
                                                'admins/editItem',
                                                item
                                            )
                                        " class="  mr-2 icon">
                                            mdi-pencil
                                        </v-icon>
                                    </span>
                                </template>
                                <span>
                                    edit data
                                </span>
                            </v-tooltip>

                            <v-tooltip top>
                                <template v-slot:activator="{
                                    on,
                                    attrs
                                }">
                                    <span v-bind="
                                        attrs
                                    " v-on="on">
                                        <v-icon @click="
                                            $store.commit(
                                                'admins/showCredentialsDialog',
                                                item
                                            )
                                        " class="  mr-2 icon">
                                            mdi-lock
                                        </v-icon>
                                    </span>
                                </template>
                                <span>
                                    Admin login
                                    Credentials
                                </span>
                            </v-tooltip>

                            <span>
                                <v-tooltip top>
                                    <template v-slot:activator="{
                                        on,
                                        attrs
                                    }">
                                        <span v-bind="
                                            attrs
                                        " v-on="
    on
">
                                            <v-icon @click="
                                                $store.commit(
                                                    'admins/showDeleteSnackbar',
                                                    item
                                                )
                                            " class=" mr-2 icon">
                                                mdi-delete
                                            </v-icon>
                                        </span>
                                    </template>
                                    <span>
                                        delete admin
                                    </span>
                                </v-tooltip>
                            </span>

                            <span>
                                <v-tooltip top>
                                    <template v-slot:activator="{
                                        on,
                                        attrs
                                    }">
                                        <span v-bind="
                                            attrs
                                        " v-on="
    on
">
                                            <v-icon @click="
    $store.dispatch(
        'admins/permissions/showPermissionsDialog',
        item
    )
                                            " class="icon ">
                                                mdi-clipboard
                                            </v-icon>
                                        </span>
                                    </template>
                                    <span>
                                        Manage admin
                                        permissions
                                    </span>


                                </v-tooltip>
                            </span>
                        </td>

                    </tr>
                </tbody>
            </template>
        </v-data-table>
    </section>
</template>


<script>
export default {
    components: {

    },

    data: () => ({

    }),

    created() {

    },

    mounted() {

    },

    methods: {




    }
};

</script>
