<template>

    <div class="modal right fade" :id="modal_id" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2">

        <div class="modal-dialog" role="document">

            <form @submit.prevent="save_user" class="modal-content">

                <div class="modal-header width-100-pc">
                    <h4 class="modal-title width-100-pc text-left" id="myModalLabel2">{{title}}</h4>
                </div>

                <div class="modal-body bg-f4">
                    <section>
                        <div class="step row">

                            <section class="userTypeSection col-md-4">

                                <div>

                                    <label class="stepText">What’s user contact info?</label>

                                    <div class="row form-group">
                                        <div class="col-lg-4 col-md-4 col-sm-4 label-txt-right padding-right-0">
                                            <label class="fs-14 cl-888">First name:<small class="cl-amref">*</small></label>
                                        </div>
                                        <div class="col-lg-7 col-md-7 col-sm-7">
                                            <input v-model="user_form.first_name" type="text" required v-bind:class="{'form-control product-entry-input-field':true,'attended_field':user_form.first_name}">
                                        </div>
                                    </div>

                                    <div class="row form-group">
                                        <div class="col-lg-4 col-md-4 col-sm-4 label-txt-right padding-right-0">
                                            <label class="fs-14 cl-888">Other name:<small class="cl-amref">*</small></label>
                                        </div>
                                        <div class="col-lg-7 col-md-7 col-sm-7">
                                            <input v-model="user_form.other_name" type="text" required v-bind:class="{'form-control product-entry-input-field':true,'attended_field':user_form.other_name}">
                                        </div>
                                    </div>

                                    <div class="row form-group">
                                        <div class="col-lg-4 col-md-4 col-sm-4 label-txt-right padding-right-0">
                                            <label class="fs-14 cl-888">Email:<small class="cl-amref">*</small></label>
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
                                            <label class="fs-14 cl-888">Mobile:<small class="cl-amref">*</small></label>
                                        </div>
                                        <div class="col-lg-7 col-md-7 col-sm-7">
                                            <input v-model="user_form.mobile" type="number" step="any" required v-bind:class="{'form-control product-entry-input-field':true,'attended_field':user_form.mobile}">
                                        </div>
                                    </div>

                                    <div :hidden="role_hidden" class="row form-group">
                                        <div class="col-lg-4 col-md-4 col-sm-4 label-txt-right padding-right-0">
                                            <label class="fs-14 cl-888">Role:<small class="cl-amref">*</small></label>
                                        </div>
                                        <div class="col-lg-7 col-md-7 col-sm-7">
                                            <!-- <select v-model="user_form.role_id" required v-bind:class="{'form-control product-entry-input-field height-32':true,'attended_field':user_form.role_id}">
                                                <option>-select-</option>
                                                <option v-for="(hr_role, index) in hr_roles" :disabled="hr_role.slug==='master.admin'" :key="'hr_roles_'+index" :value="hr_role.id">{{hr_role.name}}</option>
                                            </select> -->
                                            <vue-single-select
                                                name="maybe"
                                                placeholder=""
                                                you-want-to-select-a-post="ok"
                                                v-model="user_form.role"
                                                out-of-all-these-posts="makes sense"
                                                :options="hr_roles"
                                                a-post-has-an-id="good"
                                                the-post-has-a-title="make"
                                                option-label="name"
                                            ></vue-single-select>
                                        </div>
                                    </div>

                                    <div class="row form-group">
                                        <div class="col-lg-4 col-md-4 col-sm-4 label-txt-right padding-right-0">
                                            <label class="fs-14 cl-888">Company:<small class="cl-amref">*</small></label>
                                        </div>
                                        <div class="col-lg-7 col-md-7 col-sm-7">
                                            <select @change="set_variable($event,'facility')" v-model="user_form.company_id" required v-bind:class="{'form-control product-entry-input-field height-32':true,'attended_field':user_form.company_id}">
                                                <option value="" disabled selected>-select-</option>
                                                <option v-for="(practic, index) in companies" :key="'hr_roles_'+index" :value="practic.id">{{practic.name}}</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row form-group">
                                        <div class="col-lg-4 col-md-4 col-sm-4 label-txt-right padding-right-0">
                                            <label class="fs-14 cl-888">Department: </label>
                                        </div>
                                        <div class="col-lg-7 col-md-7 col-sm-7">
                                            <select v-model="user_form.department_id" v-bind:class="{'form-control product-entry-input-field height-32':true,'attended_field':user_form.department_id}">
                                                <option value="" disabled selected>-select-</option>
                                                <option v-for="(department, index) in departments" :key="'department'+index" :value="department.id">{{department.name}}</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row form-group">
                                        <div class="col-lg-4 col-md-4 col-sm-4 label-txt-right padding-right-0">
                                            <label class="fs-14 cl-888">Warehouse: </label>
                                        </div>
                                        <div class="col-lg-7 col-md-7 col-sm-7">
                                            <select v-model="user_form.store_id" v-bind:class="{'form-control product-entry-input-field height-32':true,'attended_field':user_form.branch_id}">
                                                <option value="" disabled selected>-select-</option>
                                                <option v-for="(store, index) in warehouses" :key="'department'+index" :value="store.id">{{store.name}}</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row form-group">
                                        <div class="col-lg-4 col-md-4 col-sm-4 label-txt-right padding-right-0">
                                            <label class="fs-14 cl-888">Sub Warehouse: </label>
                                        </div>
                                        <div class="col-lg-7 col-md-7 col-sm-7">
                                            <select v-model="user_form.sub_store_id" v-bind:class="{'form-control product-entry-input-field height-32':true,'attended_field':user_form.branch_id}">
                                                <option value="" disabled selected>-select-</option>
                                                <option v-for="(sub_store, index) in subwarehouses" :key="'department'+index" :value="sub_store.id">{{sub_store.name}}</option>
                                            </select>
                                        </div>
                                    </div>

                                </div>

                            </section>

                        </div>

                    </section>

                </div>

                <div class="modal-footer bg-f4">

<!--                    <button :disabled="processing" type="submit" class="btn btn-inventory btn-amref">-->
<!--                        <span v-if="processing"><i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Saving...</span>-->
<!--                        <span v-else><i class="fa fa-save" aria-hidden="true"></i> Save</span>-->
<!--                    </button>-->
<!--                    <button :disabled="processing" data-dismiss="modal" class="btn btn-inventory btn-grey">-->
<!--                        Close-->
<!--                    </button>-->
                    <button :disabled="processing" type="submit" class="btn btn-secondary banking-process-amref">
                        <span v-if="processing"><i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Saving...</span>
                        <span v-else>Save</span>
                    </button>
                    <button :disabled="processing" type="button" data-dismiss="modal" class="btn btn-secondary banking-process">
                        Close
                    </button>

                </div>

            </form>
        </div>
    </div>
    
</template>

<script>
    import {get,post} from "../../../../../../helpers/api";
    import Auth from "../../../../../../store/auth";
    import {createHtmlErrorString,removeElement,reset_forms,location_obj_setter} from "../../../../../../helpers/functionmixin";
    //import {PRACTICE_USERS_API} from '../../../../../../router/api_routes';

    export default {
        name: "UserModal",
        props:['form_data','initial_url','user_api','user_mode','hr_roles','companies','modal_id','title','departments','warehouses','subwarehouses'],
        data(){
            return {
                role_hidden: false,
                step: 0,
                step_continue: true,
                processing: false,
                user_form: {
                    role_id: '',
                    branch_id: '',
                    first_name: '',
                    other_name: '',
                    store_id: '',
                    sub_store_id: '',
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
                if(this.user_form.role){this.user_form.role_id = this.user_form.role.id}
                post(this.user_api,this.user_form)
                    .then((res) => {
                        if(res.data.status_code === 200) {
                            this.$awn.success(res.data.description);
                            if (this.user_mode === 'Edit') {
                                this.$emit('userEdited');
                            }else {
                                this.$emit('add-user-event');
                            }
                            $('#'+this.modal_id).hide();
                        }
                        this.processing = false;
                    }).catch((err) => {
                    if(err.response.status === 422) {
                        //console.info(err.response.data.errors);
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

            set_variable(event,type_){
                switch(type_){
                    case "facility":
                        this.initialization = location_obj_setter(this.initializations,event.target.value);
                        this.selected_practice_id = event.target.value;
                        break;
                }
            },

        },
        mounted() {
            //this.current_branch = Auth.getCurrentAccount('work_place')
            //this.user_form.practice_id = this.practice_id;
            // console.info(this.current_branch);
            //this.initialization = location_obj_setter(this.initializations,null);
            //this.selected_practice_id = this.practice_id;
            if(this.user_mode === "Edit"){
                this.user_form = this.form_data;
                if (this.form_data.role.slug==='master.admin'){
                    this.role_hidden = true;
                }
            }
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