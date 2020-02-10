<template>
    <form @submit.prevent="save_company" class="width-100-pc float-left">
        <div class="width-50-pc float-left">
            <div class="row fullName mg-bottom-15 mg-left-30">
                <div class="inlineBlock width-30-pc">
                    <label class="company-label">Company Name: </label>
                </div>
                <div class="inlineBlock width-70-pc">
                    <div class="dijitInline firstName dijitTextBox width-100-pc">
                        <input v-model="form.name" v-bind:class="{'height-32':true,'ctm-attended-field':form.name}" type="text">
                    </div>
                </div>
            </div>
            <div class="row fullName mg-bottom-15 mg-left-30">
                <div class="inlineBlock width-30-pc">
                    <label class="company-label">Propriator Name: </label>
                </div>
                <div class="inlineBlock width-70-pc">
                    <div class="dijitInline firstName dijitTextBox width-100-pc">
                        <input v-model="form.propriator_name" v-bind:class="{'height-32':true,'ctm-attended-field':form.propriator_name}" type="text">
                    </div>
                </div>
            </div>
            <div class="row fullName mg-bottom-15 mg-left-30">
                <div class="inlineBlock width-30-pc">
                    <label class="company-label">Propriator Title: </label>
                </div>
                <div class="inlineBlock width-70-pc">
                    <div class="dijitInline firstName dijitTextBox width-100-pc">
                        <input v-model="form.propriator_title" placeholder="Pty Ltd" v-bind:class="{'height-32':true,'ctm-attended-field':form.propriator_title}" type="text">
                    </div>
                </div>
            </div>
            <div class="row fullName mg-bottom-15 mg-left-30">
                <div class="inlineBlock width-30-pc">
                    <label class="company-label">Address Line 1: </label>
                </div>
                <div class="inlineBlock width-70-pc">
                    <div class="dijitInline firstName dijitTextBox width-100-pc">
                        <input v-model="form.address" placeholder="Address" v-bind:class="{'height-32':true,'ctm-attended-field':form.address}" type="text">
                    </div>
                </div>
            </div>
            <div class="row fullName mg-bottom-15 mg-left-30">
                <div class="inlineBlock width-30-pc">
                    <label class="company-label">Address Line 2: </label>
                </div>
                <div class="inlineBlock width-70-pc">
                    <div class="dijitInline firstName dijitTextBox width-30-pc float-left mg-right-5">
                        <input v-model="form.city" placeholder="City/Town" v-bind:class="{'height-32':true,'ctm-attended-field':form.city}" type="text">
                    </div>
                    <div class="dijitInline firstName dijitTextBox width-30-pc float-left mg-right-5">
                        <input v-model="form.region" placeholder="Region/Province" v-bind:class="{'height-32':true,'ctm-attended-field':form.region}" type="text">
                    </div>
                    <div class="dijitInline firstName dijitTextBox width-35-pc float-right">
                        <input v-model="form.country" placeholder="Country" v-bind:class="{'height-32':true,'ctm-attended-field':form.country}" type="text">
                    </div>
                </div>
            </div>
            <div class="row fullName mg-bottom-15 mg-left-30">
                <div class="inlineBlock width-30-pc">
                    <label class="company-label">Postal: </label>
                </div>
                <div class="inlineBlock width-70-pc">
                    <div class="dijitInline firstName dijitTextBox width-50-pc float-left">
                        <input v-model="form.postal_code" placeholder="Postal code" v-bind:class="{'height-32':true,'ctm-attended-field':form.postal_code}" type="text">
                    </div>
                    <div class="dijitInline firstName dijitTextBox width-45-pc float-right">
                        <input v-model="form.fax" placeholder="Fax" v-bind:class="{'height-32':true,'ctm-attended-field':form.fax}" type="text">
                    </div>
                </div>
            </div>
            <div class="row fullName mg-bottom-15 mg-left-30">
                <div class="inlineBlock width-30-pc">
                    <label class="company-label">Website: </label>
                </div>
                <div class="inlineBlock width-70-pc">
                    <div class="dijitInline firstName dijitTextBox width-100-pc">
                        <input v-model="form.website" placeholder="Website (will be displayed on the invoice)" v-bind:class="{'height-32':true,'ctm-attended-field':form.website}" type="text">
                    </div>
                </div>
            </div>
            <div class="row fullName mg-bottom-15 mg-left-30">
                <div class="inlineBlock width-30-pc">
                    <label class="company-label">Business: </label>
                </div>
                <div class="inlineBlock width-70-pc">
                    <div class="dijitInline firstName dijitTextBox width-45-pc float-left">
                        <select class="" v-model="form.business_type" v-bind:class="{'height-32':true,'ctm-attended-field':form.business_type}">
                            <option value="" disabled selected>--select type--</option>
                            <option value="Wholesale">Wholesale</option>
                            <option value="Service">Service</option>
                        </select>
                    </div>
                    <div class="dijitInline firstName dijitTextBox width-50-pc float-right">
                        <select class="" v-model="form.industry" v-bind:class="{'height-32':true,'ctm-attended-field':form.industry}">
                            <option value="" disabled selected>--select industry--</option>
                            <option value="Health and Life Sciences">Health and Life Sciences</option>
                            <option value="Pharmaceuticals">Pharmaceuticals</option>
                            <option value="Retail & Wholesale">Retail & Wholesale</option>
                        </select>
                        <!-- <input v-model="form.industry" placeholder="Industry" v-bind:class="{'height-32':true,'ctm-attended-field':form.industry}" type="text"> -->
                    </div>
                </div>
            </div>
            <div class="row fullName mg-bottom-15 mg-left-30">
                <div class="inlineBlock width-30-pc">
                    <label class="company-label">Date Format: </label>
                </div>
                <div class="inlineBlock width-70-pc">
                    <div class="dijitInline firstName dijitTextBox width-100-pc">
                        <select class="" v-model="form.date_format" v-bind:class="{'height-32':true,'ctm-attended-field':form.date_format}">
                            <option value="" disabled selected>--select format--</option>
                            <option value="d/M/Y">d/M/Y</option>
                            <option value="d-M-Y">d-M-Y</option>
                            <option value="d/F/Y">d/F/Y</option>
                            <option value="d-F-Y">d-F-Y</option>
                            <option value="M d,Y">M d,Y</option>
                            <option value="F d,Y">F d,Y</option>
                            <option value="D M jS, Y">D M jS, Y</option>
                            <option value="Y-m-d">Y-m-d</option>
                            <option value="d-m-Y">d-m-Y</option>
                            <option value="d/m/Y">d/m/Y</option>
                            <option value="m/d/Y">m/d/Y</option>
                            <option value="d.m.Y">d.m.Y</option>
                            <option value="d.M.Y">d.M.Y</option>
                            <option value="d.F.Y">d.F.Y</option>
                            <option value="Y-m-d H:i:s">Y-m-d H:i:s</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="width-50-pc float-left padding-left-25 padding-right-20">
            <div class="row fullName mg-bottom-15 mg-left-30">
                <div class="inlineBlock width-100-pc">
                    <image-preview v-if="user_mode==='Edit'" :image_data="form.logo" :initiate_upload_method="initiate_upload_method" :user_mode="user_mode" :company_api="company_api" v-on:uploadedFile="setFile"></image-preview>
                    <div v-else class="width-100-pc">
                        <div v-if="!is_file_uploaded" class="image-preview float-left">
                            <input type="file" ref="temp_file" id="temp_file" v-on:change="handleFileUploader('Logo')" class="height-32">
                        </div>
                        <div v-else class="image-preview float-left">
                            <img v-if="imagePrev.length > 0" class="preview" :src="imagePrev">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row fullName mg-bottom-15 mg-left-30">
                <div class="inlineBlock width-100-pc">
                    <label class="company-label fw-600">Phone Numbers:</label>
                    <small class="txt-italic fs-12 cl-787887">Will be displayed on Estimate, Invoice & PO</small>
                    <div class="dijitInline firstName dijitTextBox width-100-pc">
                        <input v-model="form.phone" placeholder="Separated by commas(,) e.g 254700000000,254700000001" v-bind:class="{'height-32':true,'ctm-attended-field':form.phone}" type="text">
                    </div>
                </div>
            </div>
            <div class="row fullName mg-bottom-15 mg-left-30">
                <div class="inlineBlock width-100-pc">
                    <label class="company-label fw-600">Emails:</label>
                    <small class="txt-italic fs-12 cl-787887">Will be displayed on Estimate, Invoice & PO</small>
                    <div class="dijitInline firstName dijitTextBox width-100-pc">
                        <input v-model="form.email" placeholder="Separated by commas(,)" v-bind:class="{'height-32':true,'ctm-attended-field':form.email}" type="text">
                    </div>
                </div>
            </div>
            <div class="row fullName mg-bottom-15 mg-left-30">
                <div class="inlineBlock width-100-pc">
                    <label class="company-label fw-600">Registration Numbers:</label>
                    <small class="txt-italic fs-12 cl-787887">Will be displayed on Estimate, Invoice & PO</small>
                    <div class="dijitInline firstName dijitTextBox width-100-pc">
                        <input v-model="form.registration_number" placeholder="GST NO 1232434 or PAN ABC3443" v-bind:class="{'height-32':true,'ctm-attended-field':form.registration_number}" type="text">
                    </div>
                </div>
            </div>
        </div>
        <div class="width-100-pc float-left padding-left-25">
            <hr>
            <button v-if="show_dismiss_btn" :disabled="processing" type="button" data-dismiss="modal" class="btn btn-inventory float-left btn-grey cl-444">
                Cancel
            </button>
            <button :disabled="processing" type="submit" class="btn btn-inventory btn-amref cl-white float-right">
                <span v-if="processing"><i class="fa fa-spinner fa-spin"></i> Saving...</span>
                <span v-else>Save Changes</span>
            </button>
        </div>
    </form>
</template>

<script>
    import ImagePreview from "../../../../../../components/images/ImagePreview";
    import { post, postFile } from '../../../../../../helpers/api';
    import { createHtmlErrorString,reset_forms } from '../../../../../../helpers/functionmixin';

    export default {
        name: "NewCompanyForm",
        props:['form_data','user_mode','company_api','show_dismiss_btn'],
        components: {ImagePreview},
        data(){
            return{
                temp_file: '',
                processing: false,
                is_file_uploaded: false,
                imagePrev: [],
                initiate_upload_method: {
                    api: this.company_api
                },
                form: {
                    name: null,
                    propriator_title: null,
                    propriator_name: null,
                    uploaded_logo: null,
                    registration_number: null,
                    email: null,
                    phone: null,
                    industry: null,
                    date_format: null,
                    website: null,
                    postal_code: null,
                    fax: null,
                    city: null,
                    region: null,
                    country: null,
                    address: null,
                    propriator_name: null,
                    propriator_title: null,
                },
            }
        },
        methods: {
            toggleBtn(state_){
                this.input_disabled = state_;
            },
            save_company(){
                //This function is user for both creating new company and updating existing company
                this.processing = true; //this variable changes to true when user has fired a process
                //let final_form = null;
                if(this.user_mode==="Edit"){
                    // alert(this.user_mode);
                    // let final_form = this.form;
                    post(this.company_api, this.form)
                    .then((res) => {
                        if(res.data.status_code === 200) {
                            this.processing = false;
                            this.$awn.success(res.data.description);
                            this.$emit("companyChanged");
                        }
                    }).catch((err) => {
                        if(err.response.status === 422) {
                            this.$awn.warning(createHtmlErrorString(err.response.data.errors))
                        }else if (err.response.status === 500){
                            this.$awn.warning(err.response.data.description);
                        }
                        else{
                            this.processing = false;
                            this.$awn.warning(err.response.data.description);
                        }
                        this.processing = false;
                    });
                }else{
                    // alert(this.user_mode);
                    // console.info(this.temp_file);
                    let final_form = new FormData();
                    final_form.append('file',this.temp_file);
                    for( let key in this.form){
                        final_form.append(key,this.form[key]);
                    }
                    // console.info(final_form);
                    post(this.company_api, final_form)
                        .then((res) => {
                            if(res.data.status_code === 200) {
                                this.processing = false;
                                this.$awn.success(res.data.description);
                                this.$emit("newCompany");
                            }
                        }).catch((err) => {
                            if(err.response.status === 422) {
                                this.$awn.warning(createHtmlErrorString(err.response.data.errors))
                            }else if (err.response.status === 500){
                                this.$awn.warning(err.response.data.description);
                            }
                            else{
                                this.processing = false;
                                this.$awn.warning(err.response.data.description);
                            }
                            this.processing = false;
                        });
                }

            },

            setFile(file_data){
                // this.form.uploaded_logo = file_data;
                // console.info(this.form.uploaded_logo);
                // if(user_mode==="Edit"){
                //     this.$emit("companyChanged");
                // }else{
                //     this.temp_file = file_data;
                // }
                this.$emit("companyChanged");
            },
            handleFileUploader(target){
                switch (target) {
                    case 'Logo':
                        this.temp_file = this.$refs.temp_file.files[0];
                        //this.$emit("uploadedFile",this.file);
                        // this.is_file_uploaded = true;
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
                    this.imagePrev = reader.result;
                    this.is_file_uploaded = true;
                    //this.$emit("uploadedFile",this.file);
                    //this.show_save = true;
                }.bind(this), false);

                /*
                  Check to see if the file is not empty.
                */
                if( this.temp_file ){
                    /*
                      Ensure the file is an image file.
                    */
                    if ( /\.(jpe?g|png|gif)$/i.test( this.temp_file.name ) ) {
                        /*
                          Fire the readAsDataURL method which will read the file in and
                          upon completion fire a 'load' event which we will listen to and
                          display the image in the preview.
                        */
                        reader.readAsDataURL( this.temp_file );
                    }
                }
            },
        },
        mounted(){
            if(this.user_mode==="Edit"){
                this.form = this.form_data;
            }
        }
    }
</script>