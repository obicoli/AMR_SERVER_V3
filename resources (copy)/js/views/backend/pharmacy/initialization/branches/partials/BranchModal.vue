<template>

    <form @submit.prevent="add_branch">

        <div class="modal-content">

            <mobile-otp-overlay v-if="create_branch" :message="alert_msg" :mobile="current_branch.mobile" v-on:otpVerificationSuccess="refresh_page"></mobile-otp-overlay>

            <div class="modal-header">
                <h4 v-if="user_mode==='Create'" class="cl-grey"><i class="fa fa-plus-circle"></i> Add New Branch:</h4>
                <h4 v-if="user_mode==='Edit'" class="cl-grey"><i class="fa fa-edit"></i> Edit Branch:</h4>
                <a data-dismiss="modal"><i class="fa fa-close"></i> </a>
            </div>

            <div  class="modal-body">

                <div class="row form-group mg-bottom-10">
                    <div class="col-lg-3 col-md-3 col-sm-3 label-txt-right padding-right-0">
                        <label class="fs-14 cl-888">Branch Name:<span class="cl-red">*</span></label>
                    </div>
                    <div class="col-lg-7 col-md-7 col-sm-7">
                        <input type="text" required v-model="form.name" v-bind:class="{'form-control product-entry-input-field':true,'attended_field':form.name!==''}">
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col-lg-3 col-md-3 col-sm-3 label-txt-right padding-right-0">
                        <label class="fs-14 cl-888">Type:<span class="cl-red">*</span></label>
                    </div>
                    <div class="col-lg-7 col-md-7 col-sm-7">
                        <select v-model="form.type" required v-bind:class="{'form-control selectpicker bg-white height-36 border-radius-2 border-ccc':true,'attended_field':form.type!==''}" data-live-search="true" style="width: 100%;">
                            <option value="">select</option>
                            <option value="Hospital">Hospital</option>
                            <option value="Nursing Home">Nursing Home</option>
                            <option value="Maternity Home">Maternity Home</option>
                            <option value="Health Centre">Health Centre</option>
                            <option value="Dispensary">Dispensary</option>
                            <option value="Laboratory">Laboratory</option>
                            <option value="Pharmacy">Pharmacy</option>
                            <option value="Chemistry">Chemistry</option>
                            <option value="Other">Other</option>
                        </select>
                        <small class="cl-444 fs-12">(Select the type: Hospital, Laboratory, etc.)</small>
                    </div>
                </div>

                <div class="row form-group mg-bottom-10">
                    <div class="col-lg-3 col-md-3 col-sm-3 label-txt-right padding-right-0">
                        <label class="fs-14 cl-888">Registration number:<span class="cl-red">*</span></label>
                    </div>
                    <div class="col-lg-7 col-md-7 col-sm-7">
                        <input type="text" required v-model="form.registration_number" v-bind:class="{'form-control product-entry-input-field':true,'attended_field':form.registration_number!==''}">
                    </div>
                </div>

                <div class="row form-group mg-bottom-10">
                    <div class="col-lg-3 col-md-3 col-sm-3 label-txt-right padding-right-0">
                        <label class="fs-14 cl-888">Contact Mobile:<span class="cl-red">*</span></label>
                    </div>
                    <div class="col-lg-7 col-md-7 col-sm-7">
                        <input type="number" required v-model="form.mobile" placeholder="+254" v-bind:class="{'form-control product-entry-input-field':true,'attended_field':form.mobile!==''}">
                        <small class="cl-444 fs-12">(OTP will be sent to this number for verification.)</small>
                    </div>
                </div>

                <div class="row form-group mg-bottom-10">
                    <div class="col-lg-3 col-md-3 col-sm-3 label-txt-right padding-right-0">
                        <label class="fs-14 cl-888">Contact Email:<span class="cl-red">*</span></label>
                    </div>
                    <div class="col-lg-7 col-md-7 col-sm-7">
                        <input type="email" required v-model="form.email" placeholder="" v-bind:class="{'form-control product-entry-input-field':true,'attended_field':form.email!==''}">
                        <small class="cl-444 fs-12">(We'll send a verification link to this email)</small>
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col-lg-3 col-md-3 col-sm-3 label-txt-right padding-right-0">
                        <label class="fs-14 cl-888">Country:<span class="cl-red">*</span></label>
                    </div>
                    <div class="col-lg-7 col-md-7 col-sm-7">
                        <input type="text" required v-model="form.country" @change="loadCity($event)" list="country_list" v-bind:class="{'form-control product-entry-input-field':true,'attended_field':form.country!==''}">
                        <datalist id="country_list">
                            <option value="">Type to select country</option>
                            <option v-for="country in countries" :value="country.name">{{country.name}}</option>
                        </datalist>
                    </div>
                </div>

                <div class="row form-group mg-bottom-10">
                    <div class="col-lg-3 col-md-3 col-sm-3 label-txt-right padding-right-0">
                        <label class="fs-14 cl-888">City:<span class="cl-red">*</span></label>
                    </div>
                    <div class="col-lg-7 col-md-7 col-sm-7">
                        <input :disabled="!city_loaded" type="text" required v-model="form.city" list="city_list" v-bind:class="{'form-control product-entry-input-field':true}">
                        <datalist id="city_list">
                            <option value="">Type to select city</option>
                            <option v-for="citys in cities" :value="citys.name">{{citys.name}}</option>
                        </datalist>
                        <small v-if="!city_loaded" class="cl-red">{{alert_msg}}</small>
                    </div>
                </div>

                <div class="row form-group mg-bottom-10">
                    <div class="col-lg-3 col-md-3 col-sm-3 label-txt-right padding-right-0">
                        <label class="fs-14 cl-888">Website:</label>
                    </div>
                    <div class="col-lg-7 col-md-7 col-sm-7">
                        <input type="text" v-model="form.website" placeholder="" v-bind:class="{'form-control product-entry-input-field':true,'attended_field':form.website !==''}">
                    </div>
                </div>

                <div class="row form-group mg-bottom-15">
                    <div class="col-lg-3 col-md-3 col-sm-3 label-txt-right padding-right-0">
                        <label class="fs-14 cl-888">Address:<span class="cl-red">*</span></label>
                    </div>
                    <div class="col-lg-7 col-md-7 col-sm-7">
                        <textarea v-model="form.address" placeholder="2nd floor, Mara Road, Nairobi, Kenya" style="max-height: 70px!important;" v-bind:class="{'form-control':true,'attended_field':form.address!==''}" rows="5"></textarea>
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col-lg-3 col-md-3 col-sm-3 label-txt-right padding-right-0">
                        <label class="fs-14 cl-888">Status:<span class="cl-red">*</span></label>
                    </div>
                    <div class="col-lg-7 col-md-7 col-sm-7">
                        <select v-model="form.status" required v-bind:class="{'form-control product-entry-input-field height-32':true,'attended_field':form.status!==''}">
                            <option value="" disabled selected>-select-</option>
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                </div>

            </div>

            <div class="modal-footer">

                <button data-dismiss="modal" class="btn btn-inventory">
                    <i class="fa fa-close" aria-hidden="true"></i>
                    Close
                </button>
                <button v-if="user_mode==='Create'" type="button" class="btn btn-inventory">
                    <i class="fa fa-refresh" aria-hidden="true"></i>
                    Reset
                </button>
                <button v-if="user_mode==='Edit'" type="submit" class="btn btn-inventory primary">
                    <span v-if="processing"><i class="fa fa-spinner fa-spin" aria-hidden="true"></i>Saving...</span>
                    <span v-else><i class="fa fa-save" aria-hidden="true"></i>Save Changes</span>
                </button>
                <button v-if="user_mode==='Create'" type="submit" class="btn btn-inventory primary">
                    <span v-if="processing"><i class="fa fa-spinner fa-spin" aria-hidden="true"></i>Saving...</span>
                    <span v-else><i class="fa fa-save" aria-hidden="true"></i>Save</span>
                </button>

            </div>

        </div>
    </form>
    
</template>

<script>
    import {post,get} from "../../../../../../helpers/api";
    import AppInfo from "../../../../../../helpers/config";
    import Auth from "../../../../../../store/auth";
    import MobileOtpOverlay from "../../../../pharmacy/patials/MobileOtpOverlay";
    import {createHtmlErrorString, reset_form_inputs} from "../../../../../../helpers/functionmixin";

    export default {
        name: "BranchModal",
        props: ['form_data','user_mode','practice_id','initial_ur','item_id'],
        components: {MobileOtpOverlay},
        data(){
            return {
                //avatar: Auth.getAvatar(),
                initial_url: '',
                file: '',
                form: {
                    status: '',
                    name: '',
                    type: '',
                    address: '',
                    city: '',
                    country: '',
                    website: '',
                    email: '',
                    mobile: '',
                    registration_number: '',
                    practice_id: '',
                },
                current_branch: Auth.getCurrentBranch(),
                countries: [],
                cities: [],
                city_loaded: false,
                processing: false,
                city_loaded_show: false,
                create_branch: false,
                alert_msg: '',
            }
        },
        methods: {
            add_branch: function () {
                this.processing = true;
                // let url_ = "";
                // if ( this.user_mode === 'Create' ) {
                //     url_ = AppInfo.app_data.server_domain+'/api/practices';
                // }else {
                //     url_ = AppInfo.app_data.server_domain+'/api/practices/'+this.practice_id;
                // }
                post(AppInfo.app_data.server_domain+this.initial_url,this.form)
                    .then((res) => {
                        if(res.data.status_code === 200) {
                            this.processing = false;
                            this.$awn.success(res.data.description);
                            this.current_branch = res.data.results;
                            //Auth.deleteCurrentBranch();
                            //Auth.setCurrentBranch(this.current_branch);
                            if ( this.user_mode === 'Create' ) {
                                this.$emit('branchAdded');
                                //this.alert_msg = "OTP was sent to "+this.current_branch.mobile+". Please key in to continue";
                                //this.create_branch = true;
                                this.processing = false;
                            }else {
                                Auth.setCurrentBranch(this.form_data);
                                this.$emit('branchEdited');
                                this.processing = false;
                            }
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
            refresh_page(){
                this.create_branch = false;
                this.form.status = "";
                this.form.mobile = "";
                this.form.email = "";
                this.form.registration_number = "";
                this.form.website = "";
                this.form.country = "";
                this.form.city = "";
                this.form.address = "";
                this.form.type = "";
                this.form.name = "";
                this.$emit('branchAdded')
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
                                this.alert_msg = "No city found in selected country";
                                this.form.city = "";
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
                        this.file = this.$refs.file.files[0];
                        break;
                    case 'Medical Registration':
                        //this.file = this.$refs.file_3.files[0];
                        break;
                    case 'Private Practice License':
                        //this.file = this.$refs.file_4.files[0];
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
                            //this.file = this.$refs.file.files[0];
                            //this.practice_avatar = reader.result;
                            break;
                        case 'Verification certificate':
                            //this.file_2 = this.$refs.file_2.files[0];
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
            this.form.status = this.form_data.status;
            this.form.mobile = this.form_data.mobile;
            this.form.email = this.form_data.email;
            this.form.website = this.form_data.website;
            this.form.country = this.form_data.country;
            this.form.city = this.form_data.city;
            this.form.name = this.form_data.name;
            this.form.type = this.form_data.type;
            this.form.address = this.form_data.address;
            this.form.registration_number = this.form_data.registration_number;
            this.form.practice_id = this.form_data.practice_id;
            this.form.phone_verified = this.form_data.phone_verified;
            this.form.mail_verified = this.form_data.mail_verified;
            this.form.approval_status = this.form_data.approval_status;
            if (this.user_mode === "Create"){
                this.initial_url = this.initial_ur;
            } else {
                this.initial_url = this.initial_ur+'/'+this.item_id;
            }
            this.loadCountry();
        }
    }
</script>

<style scoped>

</style>