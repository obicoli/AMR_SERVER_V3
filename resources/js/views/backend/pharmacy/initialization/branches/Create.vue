<template>

    <div class="hold-transition skin-yellow sidebar-collapse">

        <page-header :inventory="true"></page-header>

        <div class="content-wrapper">

            <!-- pages navigates here -->
            <section class="content-header">
                <div class="row">
                    <div class="col-md-12">
                        <div class="pull pull-left app-header">
                            <h5>
                                Initialization |
                                <small>Create Branch</small>
                            </h5>
                        </div>
                        <div class="pull pull-right">
                            <a v-bind:href="'/initialization/branches'" class="btn btn-inventory">
                                <i class="fa fa-arrow-left" aria-hidden="true"></i>
                                Back to Branches
                            </a>
                        </div>
                    </div>
                </div>
            </section>

            <section class="content bg-white">

                <div class="row justify-content-center">

                    <div class="col-xs-12 col-lg-10 col-md-10 col-sm-10">

                        <div class="box border-top-0 border-bottom-0 border-radius-0" id="print-section">
                            <div class="box-header box-header-custom">
                                <div class="pull pull-left width-50-pc">
                                    <h3 class="box-title fs-16 fw-600">Create New Branch: <small class="fs-13">All * fields are mandatory</small></h3>
                                </div>
                            </div>
                            <div class="box-body bg-white padding-top-20 padding-bottom-20 padding-left-10 padding-right-10">

                                <form @submit.prevent="add_branch">

                                    <div class="row">

                                        <div class="col-xs-12 col-md-6 col-sm-6 col-lg-6">

                                            <div class="row form-group inv-group mg-top-20">
                                                <div class="col-lg-4 col-md-4 col-sm-4 label-txt-right padding-right-0"><label class="fw-600">Branch logo:</label></div>
                                                <div class="col-lg-7 col-md-7 col-sm-6">
                                                    <div class="pull-left pull width-40-pc"><image-preview :image-data="avatar"></image-preview></div>
                                                </div>
                                            </div>

                                            <div class="row form-group inv-group mg-top-20">
                                                <div class="col-lg-4 col-md-4 col-sm-4 label-txt-right padding-right-0"><label class="fw-600">Branch Name: <span class="cl-red">*</span> </label></div>
                                                <div class="col-lg-7 col-md-7 col-sm-6"><input required type="text" v-model="form.name" placeholder="" class="form-control height-32 border-radius-2 border-ccc"></div>
                                            </div>

                                            <div class="row form-group inv-group mg-top-20">
                                                <div class="col-lg-4 col-md-4 col-sm-4 label-txt-right padding-right-0"><label class="fw-600">Type: <span class="cl-red">*</span></label></div>
                                                <div class="col-lg-7 col-md-7 col-sm-6">
                                                    <select v-model="form.type" required class="form-control bg-white height-32 border-radius-2 border-ccc" style="width: 100%;">
                                                        <option value="">--select--</option>
                                                        <option value="Hospital">Hospital</option>
                                                        <option value="Nursing Home">Nursing Home</option>
                                                        <option value="Maternity Home">Maternity Home</option>
                                                        <option value="Health Centre">Health Centre</option>
                                                        <option value="Dispensary">Dispensary</option>
                                                        <option value="Laboratory">Laboratory</option>
                                                        <option value="Pharmacy">Pharmacy</option>
                                                        <option value="Other">Chemistry</option>
                                                    </select>
                                                    <small class="cl-444 fs-12">(Select the type: Hospital, Laboratory, etc.)</small>
                                                </div>
                                            </div>

                                            <div class="row form-group inv-group mg-top-20">
                                                <div class="col-lg-4 col-md-4 col-sm-4 label-txt-right padding-right-0"><label class="fw-600">Registration number: <span class="cl-red">*</span></label></div>
                                                <div class="col-lg-7 col-md-7 col-sm-8"><input required v-model="form.registration_number" type="text" class="form-control height-32 border-radius-2 border-ccc"></div>
                                            </div>

                                            <div class="row form-group inv-group mg-top-20">
                                                <div class="col-lg-4 col-md-4 col-sm-4 label-txt-right padding-right-0"><label class="fw-600">Registration certificate: <span class="cl-red">*</span></label></div>
                                                <div class="col-lg-7 col-md-7 col-sm-8">
                                                    <input type="file" id="file_2" ref="file_2" accept="image/*" v-on:change="handleFileUpload('Verification certificate')" style="height: 15px;" class="form-control border-radius-2 height-36 border-ccc">
                                                    <small class="cl-444 fs-12">(Attach verification certificate for branch approval)</small>
                                                </div>
                                            </div>

                                            <div class="row form-group inv-group mg-top-20">
                                                <div class="col-lg-4 col-md-4 col-sm-4 label-txt-right padding-right-0"><label class="fw-600">Status: <span class="cl-red">*</span></label></div>
                                                <div class="col-lg-7 col-md-7 col-sm-6">
                                                    <select v-model="form.status" required class="form-control bg-white height-32 border-radius-2 border-ccc" style="width: 100%;">
                                                        <option value="">--select--</option>
                                                        <option value="1">Active</option>
                                                        <option value="0">Inactive</option>
                                                    </select>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="col-xs-12 col-md-6 col-sm-6 col-lg-6">

                                            <div class="row form-group inv-group mg-top-20">
                                                <div class="col-lg-4 col-md-4 col-sm-4 label-txt-right"><label class="fw-600 fs-13">Contact mobile: <span class="cl-red">*</span></label></div>
                                                <div class="col-lg-7 col-md-7 col-sm-8 padding-left-0">
                                                    <input v-model="form.mobile" required type="number" placeholder="" class="form-control border-ccc border-radius-2 height-32">
                                                    <small class="cl-444 fs-12">(OTP will be sent to this number for verification.)</small>
                                                </div>
                                            </div>
                                            <div class="row form-group inv-group mg-top-20">
                                                <div class="col-lg-4 col-md-4 col-sm-4 label-txt-right"><label class="fw-600 fs-13">Contact email: <span class="cl-red">*</span></label></div>
                                                <div class="col-lg-7 col-md-7 col-sm-8 padding-left-0">
                                                    <input v-model="form.email" required type="email" placeholder="" class="form-control border-radius-2 height-32 border-ccc">
                                                    <small class="cl-444 fs-12">(We'll send a verification link to this email)</small>
                                                </div>
                                            </div>
                                            <div class="row form-group inv-group mg-top-20">
                                                <div class="col-lg-4 col-md-4 col-sm-4 label-txt-right"><label class="fw-600 fs-13">Country: <span class="cl-red">*</span></label></div>
                                                <div class="col-lg-7 col-md-7 col-sm-8 padding-left-0">
                                                    <input type="text" required v-model="form.country" list="country_list" @change="loadCity($event)" class="form-control bg-white height-32 border-radius-2 border-ccc">
                                                    <datalist id="country_list">
                                                        <option value="">--select--</option>
                                                        <option v-for="country in countries" :value="country.name">{{country.name}}</option>
                                                    </datalist>
                                                </div>
                                            </div>
                                            <div v-if="city_loaded_show" class="row form-group inv-group mg-top-20">
                                                <div class="col-lg-4 col-md-4 col-sm-4 label-txt-right"><label class="fw-600 fs-13">City: <span class="cl-red">*</span></label></div>
                                                <div class="col-lg-7 col-md-7 col-sm-8 padding-left-0">
                                                    <input :disabled="!city_loaded" type="text" required v-model="form.city" list="city_list" class="form-control bg-white height-32 border-radius-2 border-ccc">
                                                    <datalist id="city_list">
                                                        <option value="">Type to select city</option>
                                                        <option v-for="citys in cities" :value="citys.name">{{citys.name}}</option>
                                                    </datalist>
                                                    <small v-if="!city_loaded" class="cl-red">{{alert_msg}}</small>
                                                </div>
                                            </div>
                                            <div class="row form-group inv-group mg-top-20">
                                                <div class="col-lg-4 col-md-4 col-sm-4 label-txt-right"><label class="fw-600 fs-13">Website:</label></div>
                                                <div class="col-lg-7 col-md-7 col-sm-8 padding-left-0"><input type="text" v-model="form.website" placeholder="" class="form-control height-32 border-radius-2 border-ccc"></div>
                                            </div>
                                            <div class="row form-group inv-group mg-top-20">
                                                <div class="col-lg-4 col-md-4 col-sm-4 label-txt-right"><label class="fw-600 fs-13">Address: <span class="cl-red">*</span></label></div>
                                                <div class="col-lg-7 col-md-7 col-sm-8 padding-left-0">
                                                    <textarea placeholder="2nd floor, Mara Road, Nairobi, Kenya" required v-model="form.address" class="form-control border-ccc border-radius-2"></textarea>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-12 col-md-12 col-sm-12 text-right">
                                            <hr>
                                            <div class="padding-right-20">
                                                <button type="submit" class="btn btn-inventory primary">
                                                    <i class="fa fa-save" aria-hidden="true"></i>
                                                    Save
                                                </button>
                                                <a v-bind:href="'/initialization/branches'"  class="btn btn-inventory">
                                                    <i class="fa fa-close" aria-hidden="true"></i>
                                                    Cancel
                                                </a>
                                            </div>
                                        </div>

                                    </div>

                                </form>

                            </div>
                        </div>


                    </div>

                </div>

            </section>

        </div>

        <page-footer></page-footer>

    </div>

</template>

<script>

    import PageHeader from '../../patials/Header'
    import PageFooter from '../../patials/Footer'
    import ImagePreview from '../../../../../components/images/ImagePreview'
    import Auth from "../../../../../store/auth";
    import {get,post} from "../../../../../helpers/api";
    import AppInfo from "../../../../../helpers/config";
    import {createHtmlErrorString} from "../../../../../helpers/functionmixin";

    export default {
        name: "Create",
        components: {
            PageFooter,PageHeader,ImagePreview
        },
        data(){
            return {
                avatar: Auth.getAvatar(),
                file: '',
                form: {
                    status: '',
                    user_id: Auth.getKey(),
                    name: '',
                    type: '',
                    address: '',
                    city: '',
                    country: '',
                    website: '',
                    email: '',
                    mobile: '',
                    registration_number: '',
                },
                countries: [],
                cities: [],
                city_loaded: false,
                city_loaded_show: false,
                alert_msg: '',
            }
        },
        methods: {

            add_branch: function () {
                this.processing = true;
                post(AppInfo.app_data.server_domain+'/api/branches',this.form)
                    .then((res) => {
                        if(res.data.status_code === 200) {
                            Auth.setCurrentBranch(res.data.results)
                            this.$awn.success(res.data.description);
                            //window.location.href = "/"
                        }
                        this.processing = false;
                    }).catch((err) => {
                    if(err.response.status === 422) {
                        this.$awn.warning(createHtmlErrorString(err.response.data.errors))
                    }else if (err.response.status === 500){
                        this.$awn.warning(err.response.data.description);
                    }
                    else{
                        this.processing = false;
                        this.$awn.warning(err.response.data.description)
                    }
                    this.processing = false;
                });
            },
            loadCountry: function () {
                this.processing = true;
                get(AppInfo.app_data.server_domain+'/api/localization/countries')
                    .then((res) => {
                        if(res.data.status_code === 200) {
                            this.countries = res.data.results;
                            this.processing = false;
                        }
                    }).catch((err) => {
                    if(err.response.status === 422) {
                        this.$awn.warning(createHtmlErrorString(err.response.data.errors))
                    }else if (err.response.status === 500){
                        this.$awn.warning(err.response.data.description);
                    }
                    else{
                        this.processing = false;
                        this.$awn.warning(err.response.data.description)
                    }
                    this.processing = false;
                });
            },
            loadCity: function(event){
                this.processing = true;
                get(AppInfo.app_data.server_domain+'/api/localization/cities/country/'+event.target.value)
                    .then((res) => {
                        if(res.data.status_code === 200) {
                            this.cities = res.data.results;
                            console.info(this.cities);
                            this.processing = false;
                            if (this.cities.length>0){
                                this.city_loaded = true;
                            } else {
                                this.city_loaded = false;
                                this.alert_msg = "No city found in selected country"
                            }
                            this.city_loaded_show = true;
                        }
                    }).catch((err) => {
                    if(err.response.status === 422) {
                        this.$awn.warning(createHtmlErrorString(err.response.data.errors))
                    }else if (err.response.status === 500){
                        this.$awn.warning(err.response.data.description);
                    }
                    else{
                        this.processing = false;
                        this.$awn.warning(err.response.data.description)
                    }
                    this.processing = false;
                });
            },
            handleFileUpload(target){
                /*
                  Set the local file variable to what the user has selected.
                */
                switch (target) {
                    case 'Logo':
                        this.file = this.$refs.file.files[0];
                        break;
                    case 'Verification certificate':
                        this.file_2 = this.$refs.file_2.files[0];
                        break;
                    case 'Medical Registration':
                        this.file = this.$refs.file_3.files[0];
                        break;
                    case 'Private Practice License':
                        this.file = this.$refs.file_4.files[0];
                        break;
                }

                /*
                  Initialize a File Reader object
                */
                let reader  = new FileReader();
                /*
                  Add an event listener to the reader that when the file
                  has been loaded, we flag the show preview as true and set the
                  image to be what was read from the reader.
                */
                reader.addEventListener("load", function () {
                    //this.showPreview = true;
                    //this.imagePreview = reader.result;
                    switch (target) {
                        case 'Clinic Logo':
                            this.file = this.$refs.file.files[0];
                            this.practice_avatar = reader.result;
                            break;
                        case 'Verification certificate':
                            this.file_2 = this.$refs.file_2.files[0];
                            break;
                    }
                }.bind(this), false);

                /*
                  Check to see if the file is not empty.
                */
                if( this.file ){
                    /*
                      Ensure the file is an image file.
                    */
                    if ( /\.(jpe?g|png|gif)$/i.test( this.file.name ) ) {
                        /*
                          Fire the readAsDataURL method which will read the file in and
                          upon completion fire a 'load' event which we will listen to and
                          display the image in the preview.
                        */
                        reader.readAsDataURL( this.file );
                    }
                }
            },
        },
        mounted() {
            this.loadCountry();
        }

    }
</script>

<style lang="scss">
    @import '../../../../../../../node_modules/vue-awesome-notifications/dist/styles/style';
</style>