<template>

    <form @submit.prevent="add_employee">

        <div class="modal-content">

            <div  class="modal-header">
                <h4 v-if="user_mode==='Create'" class="cl-grey"><i class="fa fa-plus-circle"></i> Add New Employee:</h4>
                <h4 v-if="user_mode==='Edit'" class="cl-grey"><i class="fa fa-edit"></i> Edit User:</h4>
                <a data-dismiss="modal"><i class="fa fa-close"></i> </a>
            </div>
            <div  class="modal-body">

                <div class="row">

                    <div class="col-xs-12 col-md-12 col-sm-12 col-lg-12">

                        <div class="row form-group mg-bottom-10">
                            <div class="col-lg-3 col-md-3 col-sm-3 label-txt-right padding-right-0">
                                <label class="fs-14 cl-888">HR Type:<span class="cl-red">*</span></label>
                            </div>
                            <div class="col-lg-7 col-md-7 col-sm-7">
                                <input type="text" required v-model="form.role_name" list="role_list" v-bind:class="{'form-control product-entry-input-field':true,'attended_field':form.role_name}">
                                <datalist id="role_list">
                                    <option v-for="role in hr_roles" :value="role.name">{{role.name}}</option>
                                </datalist>
                            </div>
                        </div>

                        <div class="row form-group mg-bottom-10">
                            <div class="col-lg-3 col-md-3 col-sm-3 label-txt-right padding-right-0">
                                <label class="fs-14 cl-888">First name:<span class="cl-red">*</span></label>
                            </div>
                            <div class="col-lg-7 col-md-7 col-sm-7">
                                <input type="text" required v-model="form.first_name" v-bind:class="{'form-control product-entry-input-field':true,'attended_field':form.first_name}">
                            </div>
                        </div>

                        <div class="row form-group mg-bottom-10">
                            <div class="col-lg-3 col-md-3 col-sm-3 label-txt-right padding-right-0">
                                <label class="fs-14 cl-888">Other name:<span class="cl-red">*</span></label>
                            </div>
                            <div class="col-lg-7 col-md-7 col-sm-7">
                                <input type="text" required v-model="form.other_name" v-bind:class="{'form-control product-entry-input-field':true,'attended_field':form.other_name}">
                            </div>
                        </div>

                        <div class="row form-group mg-bottom-10">
                            <div class="col-lg-3 col-md-3 col-sm-3 label-txt-right padding-right-0">
                                <label class="fs-14 cl-888">Email address:<span class="cl-red">*</span></label>
                            </div>
                            <div class="col-lg-7 col-md-7 col-sm-7">
                                <input type="email" required v-model="form.email" v-bind:class="{'form-control product-entry-input-field':true,'attended_field':form.email}">
                            </div>
                        </div>

                        <div class="row form-group mg-bottom-10">
                            <div class="col-lg-3 col-md-3 col-sm-3 label-txt-right padding-right-0">
                                <label class="fs-14 cl-888">Password:<span class="cl-red">*</span></label>
                            </div>
                            <div class="col-lg-7 col-md-7 col-sm-7">
                                <input type="password" required v-model="form.password" v-bind:class="{'form-control product-entry-input-field':true,'attended_field':form.password}">
                            </div>
                        </div>

                        <div class="row form-group mg-bottom-10">
                            <div class="col-lg-3 col-md-3 col-sm-3 label-txt-right padding-right-0">
                                <label class="fs-14 cl-888">Mobile:<span class="cl-red">*</span></label>
                            </div>
                            <div class="col-lg-7 col-md-7 col-sm-7">
                                <input type="text" required v-model="form.mobile" v-bind:class="{'form-control product-entry-input-field':true,'attended_field':form.mobile}">
                            </div>
                        </div>

                        <div class="row form-group mg-bottom-10">
                            <div class="col-lg-3 col-md-3 col-sm-3 label-txt-right padding-right-0">
                                <label class="fs-14 cl-888">Gender:<span class="cl-red">*</span></label>
                            </div>
                            <div class="col-lg-7 col-md-7 col-sm-7">
                                <input type="radio" v-model="form.gender" value="Male"> Male &nbsp;&nbsp;&nbsp;&nbsp;
                                <input type="radio" v-model="form.gender" value="Female"> Female&nbsp;&nbsp;&nbsp;&nbsp;
                                <input type="radio" v-model="form.gender" value="Other"> Other
                            </div>
                        </div>

                        <div class="row form-group mg-bottom-15">
                            <div class="col-lg-3 col-md-3 col-sm-3 label-txt-right padding-right-0">
                                <label class="fs-14 cl-888">Address:<span class="cl-red">*</span></label>
                            </div>
                            <div class="col-lg-7 col-md-7 col-sm-7">
                                <textarea v-model="form.address" placeholder="" style="max-height: 70px!important;" v-bind:class="{'form-control product-entry-input-field':true,'attended_field':form.address}" rows="5"></textarea>
                            </div>
                        </div>

                        <div class="row form-group mg-bottom-10">
                            <div class="col-lg-3 col-md-3 col-sm-3 label-txt-right padding-right-0">
                                <label class="fs-14 cl-888">Picture:<span class="cl-red">*</span></label>
                            </div>
                            <div class="col-lg-7 col-md-7 col-sm-7">
                                <input type="file" class="form-control product-entry-input-field">
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-lg-3 col-md-3 col-sm-3 label-txt-right padding-right-0">
                                <label class="fs-14 cl-888">Status:<span class="cl-red">*</span></label>
                            </div>
                            <div class="col-lg-7 col-md-7 col-sm-7">
                                <select v-model="form.status" required v-bind:class="{'form-control product-entry-input-field height-32':true,'attended_field':form.status}" style="width: 100%;">
                                    <option value="" disabled selected>-select-</option>
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                        </div>

                    </div>


                </div>

            </div>

            <div class="modal-footer">
                <button v-if="user_mode==='Create'" type="submit" class="btn btn-inventory primary">
                    <span v-if="processing"><i class="fa fa-spinner fa-spin" aria-hidden="true"></i>Saving...</span>
                    <span v-else><i class="fa fa-save" aria-hidden="true"></i> Save</span>
                </button>
                <button v-if="user_mode==='Edit'" type="submit" class="btn btn-inventory primary">
                    <span v-if="processing"><i class="fa fa-spinner fa-spin" aria-hidden="true"></i>Saving...</span>
                    <span v-else><i class="fa fa-save" aria-hidden="true"></i> Save Changes</span>
                </button>
                <button data-dismiss="modal" class="btn btn-inventory">
                    <i class="fa fa-refresh" aria-hidden="true"></i> Reset
                </button>
                <button data-dismiss="modal" class="btn btn-inventory">
                    <i class="fa fa-close" aria-hidden="true"></i> Close
                </button>
            </div>

        </div>
    </form>
    
</template>

<script>
    import {createHtmlErrorString} from "../../../../../helpers/functionmixin";
    import {get,post} from "../../../../../helpers/api";
    import Auth from "../../../../../store/auth";
    import AppInfo from "../../../../../helpers/config";

    export default {
        name: "AddEmployeeModal",
        props: ['form_data','user_mode','hr_role','branch_id'],
        components: {},
        data(){
            return {
                processing: false,
                form: {
                    role_name: '',
                    first_name: '',
                    other_name: '',
                    email: '',
                    mobile: '',
                    gender: '',
                    password: '',
                    status: '',
                    address: '',
                    branch_id: this.branch_id,
                },
                hr_roles: [],
            }
        },
        methods: {
            add_employee: function () {

                this.processing = true;
                let url_ = "";
                if ( this.user_mode === 'Create' ) {
                    url_ = AppInfo.app_data.server_domain+'/api/practices/users';
                }else {
                    url_ = AppInfo.app_data.server_domain+'/api/practices/users/';
                }
                post(url_,this.form)
                    .then((res) => {
                        if(res.data.status_code === 200) {

                            this.$awn.success(res.data.description);
                            if ( this.user_mode === 'Create' ) {
                                this.refresh_page();
                                this.$emit('userAdded');
                                this.processing = false;
                            }else {
                                this.$emit('userEdited');
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
                this.form.status = "";
                this.form.role_name = "";
                this.form.address = "";
                this.form.first_name = "";
                this.form.other_name = "";
                this.form.email = "";
                this.form.mobile = "";
                this.form.gender = "";
                this.form.password = "";
                this.$emit('userAdded')
            },
        },
        mounted() {
            
            this.form.mobile = this.form_data.mobile;
            this.form.email = this.form_data.email;
            this.form.password = this.form_data.password;
            this.form.role_name = this.form_data.role_name;
            this.form.first_name = this.form_data.first_name;
            this.form.other_name = this.form_data.other_name;
            this.form.gender = this.form_data.gender;
            this.form.password = this.form_data.password;
            this.form.status = this.form_data.status;
            this.form.address = this.form_data.address;
            this.form.branch_id = this.branch_id;
        }
    }
</script>

<style scoped>

</style>