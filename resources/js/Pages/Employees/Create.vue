<template>
    <section class="">

        <Head>
            <title>Employee create</title>
        </Head>

        <form @submit.prevent="create">
            <div class="input-fields-holder">
                <div class="image-file-input">
                    <div class="description">
                        recomended dimensions are 600 width and 600 height
                    </div>

                    <img :src="getImage" />

                    <div class="upload-holder">
                        <div class="file-holder">
                            <label for="employee_create_image" class="custom-file-upload">
                                <v-icon> mdi-pencil </v-icon>
                            </label>
                            <input accept="image/*" id="employee_create_image" type="file"
                                @input="form.image = $event.target.files[0]" @change="imageSelected" />
                        </div>

                        <span class="image-paragraph" v-html="getImageParagraph">
                        </span>

                        <div class="clear" @click="clearImage()" v-if="image.preview">
                            <v-btn icon color="#645e5e">
                                <v-icon>mdi-cached</v-icon> </v-btn><span> clear</span>
                        </div>
                    </div>
                </div>
                {{ form.errors }}

                <div class="row">



                    <div class="input-holder col-md-4">
                        <span class="label"> Phone numner :</span>
                        <input v-model="form.first_name" type="text" />
                        <span class="validation-error" v-if="form.errors.first_name">{{ form.errors.first_name }}</span>
                    </div>


                    <div class="input-holder col-md-4">
                        <span class="label"> First Name :</span>
                        <input v-model="form.first_name" type="text" />
                        <span class="validation-error" v-if="form.errors.first_name">{{ form.errors.first_name }}</span>
                    </div>

                    <div class="input-holder col-md-4">
                        <span class="label"> Last Name :</span>
                        <input v-model="form.last_name" type="text" />
                        <span class="validation-error" v-if="form.errors.last_name">{{ form.errors.last_name }}</span>
                    </div>

                    <div class="input-holder col-md-4">
                        <span class="label"> Email :</span>
                        <input v-model="form.email" type="email" />
                        <span class="validation-error" v-if="form.errors.email">{{ form.errors.email }}</span>
                    </div>

                    <div class="input-holder col-md-4">
                        <span class="label"> Employee type : </span>
                        <input v-model="form.employee_type" type="text" />
                        <span class="validation-error" v-if="form.errors.employee_type">{{
                            form.errors.employee_type
                        }}</span>
                    </div>

                    <div class="input-holder col-md-4">
                        <span class="label"> Local mobile number :</span>
                        <input v-model="form.local_mobile_number" type="text" />
                        <span class="validation-error" v-if="form.errors.local_mobile_number">{{
                            form.errors.local_mobile_number
                        }}</span>
                    </div>

                    <div class="input-holder col-md-4">
                        <span class="label"> Emergency Contact Name :</span>
                        <input v-model="form.emergency_contact_name" type="text" />
                        <span class="validation-error" v-if="form.errors.emergency_contact_name">{{
                            form.errors.emergency_contact_name
                        }}</span>
                    </div>



                    <div class="input-holder col-md-4">
                        <span class="label"> Local address :</span>
                        <input v-model="form.local_address" type="textarea" />
                        <span class="validation-error" v-if="form.errors.emergency_contact_name">{{
                            form.errors.local_address
                        }}</span>
                    </div>










                </div>
            </div>
            <div class="buttons">
                <v-btn color="blue" dark :loading="form.processing" type="submit">Create new employee
                </v-btn>

                <Link href="/employees">
                <v-btn color="blue-grey" class="ma-3 white--text">
                    Discard
                </v-btn></Link>
            </div>
        </form>
    </section>
</template>

<script>
import { Inertia } from "@inertiajs/inertia";
import App from "../../Shared/App.vue";
export default {
    layout: App,

    computed: {
        getImage() {
            return this.image.preview || "/images/employees/employee.webp";
        },

        getImageParagraph() {
            if (this.form.errors.hasOwnProperty("image")) {
                return `<span class = "validation-error">  ${this.form.errors.image[0]}  </span> `;
            } else if (this.image.name) {
                return `<span >  ${this.image.name}  </span> `;
            } else {
                return `<span > no image selected </span> `;
            }
        },
    },

    methods: {
        create() {
            this.form.post("/employee/write", {
                forceFormData: true,
                onSuccess: () => {
                    this.helper.methods.showSuccessMessage("employee Created");
                    Inertia.get("/employees");
                },
            });
        },

        imageSelected(element) {
            this.image.file = element.target.files[0];
            this.image.name = element.target.files[0].name;
            let reader = new FileReader();
            reader.readAsDataURL(this.image.file);
            reader.onload = (element) => {
                this.image.preview = element.target.result;
            };
        },

        clearImage() {
            this.image = Object.assign({}, this.defaultImage);
            document.getElementById("employee_create_image").value = "";
        },
    },

    data() {
        return {
            image: {
                file: "",
                name: "",
                preview: "",
            },

            defaultImage: {
                file: "",
                name: "",
                preview: "",
            },
            form: this.$inertia.form({
                email: "",
                phone_number: "",
                first_name: "",
                last_name: "",
                employee_type: "",
                nationality: "",
                gender: "",
                date_of_birth: "",
                local_mobile_number: "",
                local_address: "",
                emergency_number: "",
                emergency_contact_name: "",
                passport_number: "",
                passport_expiry_date: "",
                residency_number: "",
                residency_expiry_date: "",
                health_number: "",
                health_renewal_date: "",
                labour_contract: "",
                labour_contract_issue_date: "",
                labour_contract_expiry_date: "",
                position: "",
                position_date_of_joining: "",
                position_branch_number: "",
                based_at: "",
                based_at_started_date: "",
                based_at_current_status: "",
                basic_salary: "",
                salary_transportation: "",
                salary_accommodation: "",
                total_salary: "",
                date_of_leaving: "",
                reason_of_leaving: "",
            }),
        };
    },
};
</script>
