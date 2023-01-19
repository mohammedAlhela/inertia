<template>
  <section>
    <HeaderPanels :headerData="headerData" />
    <div class="main-holder">

      <div class="main-content">





        <v-form @submit.prevent="update"  ref="form">
          <v-row class="inputs-holder">


            <div class="upload-image-container">
              <div class="description">
                Recomended dimensions are 100 x 100
              </div>

              <img :src="getImage" />

              <div class="upload-holder">
                <div class="file-holder">
                  <label for="company_image" class="custom-file-upload">
                    <v-icon> mdi-pencil </v-icon>
                  </label>
                  <input accept="image/*" id="company_image" type="file" @input="form.image = $event.target.files[0]"
                    @change="imageSelected" />
                </div>

                <span class="image-paragraph" v-html="getImageParagraph">
                </span>

                <div class="clear" @click="clearImage()" v-if="image.preview">
                  <v-btn icon color="#445e5e">
                    <v-icon>mdi-cached</v-icon> </v-btn><span> clear</span>
                </div>
              </div>
            </div>

            <v-col cols="4" class="py-1">
              <span class="input-header">
                Email
              </span>
              <v-icon class="important-field-icon"> mdi-star </v-icon>

              <v-text-field required :rules="formErrors.email" solo dense v-model="
                form.email
              " class="textfield" />
            </v-col>

          
            <v-col cols="4" class="py-1">
              <span class="input-header">
                Name
              </span>
              <v-icon class="important-field-icon"> mdi-star </v-icon>

              <v-text-field required :rules="formErrors.name" solo dense v-model="
                form.name
              " class="textfield" />
            </v-col>




            <v-col cols="4" class="py-1">
              <span class="input-header">
                Contact Phone
              </span>
              <v-icon class="important-field-icon"> mdi-star </v-icon>

              <v-text-field required :rules="formErrors.mobile" solo dense v-model="
                form.mobile
              " class="textfield" />
            </v-col>


            <v-col cols="4" class="py-1">
              <span class="input-header">
                Company register
              </span>

              <v-text-field required :rules="formErrors.company_register" solo dense v-model="
                form.company_register
              " class="textfield" />
            </v-col>


            <v-col cols="4" class="py-1">
              <span class="input-header">
               Country phone code
              </span>
              <v-text-field required :rules="formErrors.country_phone_code" solo dense v-model="
                form.country_phone_code
              " class="textfield" />
            </v-col>


            <v-col cols="4" class="py-1">
              <span class="input-header">
              Country
              </span>
              <v-autocomplete required  solo dense v-model="
                form.country
              " :items = "countries"  class="textfield" />
            </v-col>


            <v-col cols="4" class="py-1">
              <span class="input-header">
           Timezone
              </span>
              <v-autocomplete required  solo dense v-model="
                form.timezone
                
              " :items = "timezones"  class="textfield" />
            </v-col>


            <v-col cols="4" class="py-1">
              <span class="input-header">
              Currency
              </span>
              <v-autocomplete required  solo dense v-model="
                form.currencies
                
              " :items = "currencies" class="textfield" />
            </v-col>





            <v-col cols="4" class="py-1">
              <span class="input-header">
                Address
              </span>

              <v-textarea required :rules="formErrors.address" solo dense v-model="
                form.address
              " class="textfield" />
            </v-col>
          </v-row>
          <div class="buttons">
            <v-btn :loading="form.processing" type="submit">Update</v-btn>
          </div>
        </v-form>

      </div>
      <div class="clear"></div>
    </div>
  </section>
</template>

<script>
import App from "../../Shared/Layout/App";

export default {
  layout: App,
  props: {
    company: Object,
  },

  mounted() {

    this.helper.methods.handleServerData(this.form, this.company)

  },

  computed: {
    getImage() {
      return (
        this.image.preview || this.company.image
      );
    },


    formErrors() {
      return this.helper.methods.formErrors(this.form.errors)
    },



    getImageParagraph() {
      return this.helper.methods.getImageParagraph(this.form.errors, this.image.name)
    },


  },

  methods: {
    update() {
      this.$refs.form.validate()
      this.form.image = this.image.file;
      this.form.post(`/company/${this.form.id}`, {
        forceFormData: true,
        onSuccess: () => {
          this.helper.methods.showSuccessMessage(
            "Company Data updated"
          );
          // window.location.reload();
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
      document.getElementById("company_image").value = "";
    },


  },

  data() {
    return {
      headerData: {
        title: "Company Data",
        add: {
          src: "",
          paragraph: "",
          visibility: false
        },

        link: {
          icon: "mdi-pencil-box-multiple-outline",
          paragraph: "manage Company Data ",
          src: "/company"
        }

      },
      form: this.$inertia.form({
        address: "",
        company_register: "",
        country: "",
        country_phone_code: "",
        created_at: "",
        currencies: "",
        email: "",
        id: "",
        image: "",
        mobile: "",
        name: "",
        timezone: "",
        updated_at: ""

      }),

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
      timezones: [                         //edited
            "-12:00=-720=Eniwelok, Kwajalein",
            "-11:00=-660=Midway Island, Samoa",
            "-10:30=-630=Cook Islands",
            "-10:00=-600=Hawaii; Western Aleutian Islands=was Alaska/Hawaii timezone",
            "-09:30=-570=Marquesas Islands",
            "-09:00=-540=Alaska; Eastern Aleutian Islands=was Yukon timezone",
            "-08:30=-510=Pitcairn Island",
            "-08:00=-480=Pacific Time (US & Canada); Yukon; Tijuana",
            "-07:00=-420=Mountain Time (US & Canada)",
            "-06:00=-360=Central Time (US & Canada); Mexico City, Tegucigalpa",
            "-05:00=-300=Eastern Time (US & Canada); Bogota; Lima; Quito",
            "-04:30=-270=Caracas",
            "-04:00=-240=Atlantic Time (Canada); Caracas, La Paz; Santiago",
            "-03:45=-225=Guyana, South America",
            "-03:30=-210=Newfoundland; Suriname, South America",
            "-03:00=-180=Greenland; Brasilia; Buernos Aires; Puerto Rico",
            "-02:00=-120=Mid-Atlantic",
            "-01:00=-60=Azores, Cape Verde Is.",
            "00:00=0=Greenwich Mean Time",
            "01:00=60=Amsterdam; Berlin; Bern; Rome; Stockholm; Vienna",
            "02:00=120=Athens; Istanbul; Minsk; Jerusalem",
            "03:00=180=Baghdad; Kuwait; Moscow",
            "03:30=210=Tehran, Iran",
            "04:00=240=Abu Dhabi; Muscat",
            "04:30=270=Kabul, Afghanistan",
            "05:00=300=Ekaterinburg",
            "05:30=330=India; Bombay; Calcutta; New Delhi; Sri Lanka",
            "05:45=345=Kathmandu, Nepal",
            "06:00=360=Astana; Dhaka",
            "06:30=390=Cocos Islands; Yangon; Myanmar",
            "07:00=420=Bangkok; Hanoi",
            "08:00=480=Perth; Singapore; China",
            "08:45=525=South Australia",
            "09:00=540=Osaka; Tokyo; Seoul",
            "09:30=570=Northern Australia",
            "10:00=600=Brisbane; Canberra; Sydney; Guam",
            "11:00=660=Magadan; Solomon Is.; New Caledonia",
            "11:30=690=New Zealand?; Norfold Island, Australia",
            "12:00=720=Auckland; Wellington; Fiji; Marshall Is.; Tuvalu",
            "12:45=765=Chatham Island, New Zealand",
            "13:00=780=Nukulalofa; Phoenix Islands=1 hour EAST of the dateline",
            "14:00=840=Line Islands; Christmas Islands=2 hours EAST of the dateline"
        ],
        currencies: ["dirham", "dollar", "robie"],
        countries: ["UAE", "SaudiArebia", "syria", "india"],

    };
  },

};
</script>
