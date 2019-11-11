<template>

    <div class="modal right fade" :id="modal_id" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2">
        <div class="modal-dialog" role="document">
            <form @submit.prevent="save_user" class="modal-content">

                <div class="modal-header">
                    <h4 class="modal-title width-70-pc float-left" id="myModalLabel2">{{title}}</h4>
                    <a class="close width-20-pc float-right" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></a>
                </div>

                <div class="modal-body">

                    <section>

                        <div class="step row">

                            <section class="userTypeSection col-md-4">

                                <div>

                                    <label class="stepText">What’s their contact info?</label>

                                    <div class="row form-group">
                                        <div class="col-lg-4 col-md-4 col-sm-4 label-txt-right padding-right-0">
                                            <label class="fs-14 cl-888">First name:</label>
                                        </div>
                                        <div class="col-lg-7 col-md-7 col-sm-7">
                                            <input v-model="user_form.first_name" type="text" required v-bind:class="{'form-control product-entry-input-field':true,'attended_field':user_form.first_name}">
                                        </div>
                                    </div>

                                    <div class="row form-group">
                                        <div class="col-lg-4 col-md-4 col-sm-4 label-txt-right padding-right-0">
                                            <label class="fs-14 cl-888">Other name:</label>
                                        </div>
                                        <div class="col-lg-7 col-md-7 col-sm-7">
                                            <input v-model="user_form.other_name" type="text" required v-bind:class="{'form-control product-entry-input-field':true,'attended_field':user_form.other_name}">
                                        </div>
                                    </div>

                                    <div class="row form-group">
                                        <div class="col-lg-4 col-md-4 col-sm-4 label-txt-right padding-right-0">
                                            <label class="fs-14 cl-888">Email:</label>
                                        </div>
                                        <div class="col-lg-7 col-md-7 col-sm-7">
                                            <input v-model="user_form.email" type="email" required v-bind:class="{'form-control product-entry-input-field':true,'attended_field':user_form.email}">
                                        </div>
                                    </div>

                                    <div class="row form-group">
                                        <div class="col-lg-4 col-md-4 col-sm-4 label-txt-right padding-right-0">
                                            <label class="fs-14 cl-888"></label>
                                        </div>
                                        <div class="col-lg-7 col-md-7 col-sm-7">
                                            <label class="check-container small width-100-pc element-inlined fs-14 cl-888">Send email invitation
                                                <input type="checkbox" v-model="user_form.mail_invitation">
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="row form-group">
                                        <div class="col-lg-4 col-md-4 col-sm-4 label-txt-right padding-right-0">
                                            <label class="fs-14 cl-888">Mobile:</label>
                                        </div>
                                        <div class="col-lg-7 col-md-7 col-sm-7">
                                            <input v-model="user_form.mobile" type="number" step="any" required v-bind:class="{'form-control product-entry-input-field':true,'attended_field':user_form.mobile}">
                                        </div>
                                    </div>

                                    <div class="row form-group">
                                        <div class="col-lg-4 col-md-4 col-sm-4 label-txt-right padding-right-0">
                                            <label class="fs-14 cl-888">Role:</label>
                                        </div>
                                        <div class="col-lg-7 col-md-7 col-sm-7">
                                            <select v-model="user_form.role_id" required v-bind:class="{'form-control product-entry-input-field height-32':true,'attended_field':user_form.role_id}">
                                                <option>-select-</option>
                                                <option v-for="(hr_role, index) in hr_roles" :disabled="hr_role.slug==='master.admin'" :key="'hr_roles_'+index" :value="hr_role.id">{{hr_role.name}}</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row form-group">
                                        <div class="col-lg-4 col-md-4 col-sm-4 label-txt-right padding-right-0">
                                            <label class="fs-14 cl-888">Company/Branch:</label>
                                        </div>
                                        <div class="col-lg-7 col-md-7 col-sm-7">
                                            <select v-model="user_form.branch_id" required v-bind:class="{'form-control product-entry-input-field height-32':true,'attended_field':user_form.branch_id}">
                                                <option value="" disabled selected>-select-</option>
                                                <option value="0">None</option>
                                                <option v-for="(practic, index) in practices" :key="'hr_roles_'+index" :value="practic.id">{{practic.name}}</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row form-group">
                                        <div class="col-lg-4 col-md-4 col-sm-4 label-txt-right padding-right-0">
                                            <label class="fs-14 cl-888">Department:</label>
                                        </div>
                                        <div class="col-lg-7 col-md-7 col-sm-7">
                                            <select v-model="user_form.department_id" required v-bind:class="{'form-control product-entry-input-field height-32':true,'attended_field':user_form.branch_id}">
                                                <option value="" disabled selected>-select-</option>
                                                <option value="0">None</option>
                                                <option v-for="(department, index) in departments" :key="'department'+index" :value="department.id">{{department.name}}</option>
                                            </select>
                                        </div>
                                    </div>

                                </div>

                            </section>

                        </div>

                    </section>

                </div>

                <div class="modal-footer">

                    <button type="submit" class="btn btn-inventory primary">
                        <span v-if="user_mode==='Create'">
                            <span v-if="processing"><i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Saving...</span>
                            <span v-else><i class="fa fa-save" aria-hidden="true"></i> Save</span>
                        </span>
                            <span v-else>
                            <span v-if="processing"><i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Updating...</span>
                            <span v-else><i class="fa fa-save" aria-hidden="true"></i> Update</span>
                        </span>
                    </button>
                    <button data-dismiss="modal" class="btn btn-inventory">
                        Close
                    </button>

                </div>

            </form>
        </div>
    </div>
    
</template>

<script>
    import {get,post} from "../../../../../helpers/api";
    import AppInfo from "../../../../../helpers/config";
    import Auth from "../../../../../store/auth";
    import {createHtmlErrorString,removeElement,reset_forms} from "../../../../../helpers/functionmixin";

    export default {
        name: "NewUserModal",
        props:['practice_id','form_data','initial_url','user_mode','modal_id','title','hr_roles','practices','departments'],
        data(){
            return {
                step: 0,
                step_continue: true,
                processing: false,
                current_branch: {},
                system_permissions: [],
                sys_perm_array: [],
                sub_permissions: [],
                user_form: {
                    practice_id: '',
                    role_id: '',
                    branch_id: '',
                    first_name: '',
                    other_name: '',
                    email: '',
                    mobile: '',
                    department_id: '',
                    mail_invitation: true,
                }
            }
        },
        methods: {
            save_user(){
                this.processing = true;
                post(AppInfo.app_data.server_domain+this.initial_url,this.user_form)
                    .then((res) => {
                        if(res.data.status_code === 200) {
                            this.$awn.success(res.data.description);
                            if (this.user_mode === 'Edit') {
                                this.$emit('userEdited');
                            }else {
                                this.$emit('userAdded');
                                //this.refresh_user();
                                this.user_form = reset_forms(this.user_form);
                            }
                        }
                        this.processing = false;
                    }).catch((err) => {
                    if(err.response.status === 422) {
                        console.info(err.response.data.errors);
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

            // move_step(direction){
            //     switch (direction) {
            //         case "next":
            //             this.step = this.step + 1;
            //             if (this.step === 2){ this.step_continue = false; } else { this.step_continue = true; }
            //             break;
            //         case "back":
            //             this.step = this.step - 1;
            //             break;
            //     }
            // },

            // setStuff(message_,action_type,event){
            //     //this.sys_perm_array = [];
            //     switch (action_type) {
            //         case "text":
            //             if (event.target.value === "All access:") {
            //                 this.sys_perm_array = [];
            //                 //this.initialize_permissions();
            //             }else if(event.target.value === "Limited access:") {
            //                 this.user_form.permissions = [];
            //             }else if(event.target.value === "No feature access:"){
            //                 this.user_form.permissions = [];
            //             }
            //             this.user_form.access_right_sub_title = message_;
            //             break;
            //         case "push":
            //             this.sys_perm_array.push(message_);
            //             break;
            //         case "pull":

            //             break;
            //         case "limited":
            //             if (event.target.checked) {
            //                 //alert('ch')
            //                 this.sys_perm_array.push(message_);
            //                 //console.info(message_);
            //                 //console.info(this.sys_perm_array);
            //             }else {
            //                 //alert('un')
            //                 this.sys_perm_array = removeElement(this.sys_perm_array,message_);
            //                 //console.info(message_);
            //                 //console.info(this.sys_perm_array);
            //             }
            //             break;
            //         case "sub_permission":
            //             if (event.target.checked) {
            //                 //alert('ch')
            //                 this.sub_permissions.push(message_);
            //                 //console.info(message_);
            //                 //console.info(this.sub_permissions);
            //             }else {
            //                 //alert('un')
            //                 this.sub_permissions = removeElement(this.sub_permissions,message_);
            //                 //console.info(message_);
            //                 //console.info(this.sub_permissions);
            //             }
            //             break;
            //         case "assign_permission":
            //             if (event.target.checked) {
            //                 //alert('ch')
            //                 this.user_form.permissions.push(message_);
            //                 //console.info(message_);
            //                 console.info(this.user_form.permissions);
            //             }else {
            //                 //alert('un')
            //                 this.user_form.permissions = removeElement(this.user_form.permissions,message_);
            //                 //console.info(message_);
            //                 console.info(this.user_form.permissions);
            //             }
            //             break;
            //     }
            // },


            // load_Permissions() {
            //     this.processing = true;
            //     get(AppInfo.app_data.server_domain+'/api/permissions')
            //         .then((res) => {
            //             if(res.data.status_code === 200) {
            //                 this.system_permissions = res.data.results;
            //                 this.processing = false;
            //                 //console.info(this.system_permissions);
            //                 this.initialize_permissions();
            //             }
            //         }).catch((err) => {
            //         this.processing = false;
            //     });
            // },

            // initialize_permissions(){
            //     let new_array = [];
            //     for ( let k=0; k < this.system_permissions.length; k++){
            //         for ( let m=0; m<this.system_permissions[k].data.length; m++ ){
            //             for (let n=0; n<this.system_permissions[k].data[m].sub_category_data.length; n++){
            //                 new_array.push(this.system_permissions[k].data[m].sub_category_data[n].id);
            //             }
            //         }
            //     }
            //     this.user_form.permissions = new_array;
            // },

        },
        mounted() {
            this.user_form.practice_id = this.practice_id;
            //this.load_Permissions();
        }
    }
</script>

<style scoped>

    .modal-open .modal {
        z-index: 9999;
    }

    .modal.left .modal-dialog,
    .modal.right .modal-dialog {
        position: fixed;
        margin: auto;
        width: 100%!important;
        height: 100%;
        max-width: 100%!important;
        -webkit-transform: translate3d(0%, 0, 0);
        -ms-transform: translate3d(0%, 0, 0);
        -o-transform: translate3d(0%, 0, 0);
        transform: translate3d(0%, 0, 0);
    }

    .modal.left .modal-content,
    .modal.right .modal-content {
        height: 100%;
        overflow-y: auto;
        top: 0!important;
    }

    .modal.left .modal-body,
    .modal.right .modal-body {
        padding: 15px 15px 80px;
    }

    /*Left*/
    .modal.left.fade .modal-dialog{
        /* left: -320px; */
        -webkit-transition: opacity 0.3s linear, left 0.3s ease-out;
        -moz-transition: opacity 0.3s linear, left 0.3s ease-out;
        -o-transition: opacity 0.3s linear, left 0.3s ease-out;
        transition: opacity 0.3s linear, left 0.3s ease-out;
    }

    .modal.left.fade.in .modal-dialog{
        left: 0;
    }

    /*Right*/
    .modal.right.fade .modal-dialog {
        /* right: -320px; */
        -webkit-transition: opacity 0.3s linear, right 0.3s ease-out;
        -moz-transition: opacity 0.3s linear, right 0.3s ease-out;
        -o-transition: opacity 0.3s linear, right 0.3s ease-out;
        transition: opacity 0.3s linear, right 0.3s ease-out;
    }

    .modal.right.fade.in .modal-dialog {
        right: 0;
    }

    /* ----- MODAL STYLE ----- */
    .modal-content {
        border-radius: 0;
        border: none;
    }

    /*.modal-header {*/
    /*    border-bottom-color: #EEEEEE;*/
    /*    background-color: #FAFAFA;*/
    /*}*/

    .modal.left .modal-header,
    .modal.right .modal-header {
        height: 40px;
        line-height: 50px;
        font-weight: 600;
        color: #fff;
        background-color: #393a3d!important;
    }

    .modal-body{
        height:500px;
        overflow-y: auto;
    }

    .modal .modal-dialog .modal-body section {
        padding: 10px 0!important;
    }

</style>