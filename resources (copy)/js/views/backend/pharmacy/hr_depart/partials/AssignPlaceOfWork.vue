<template>

    <form @submit.prevent="assign_place">

        <div class="modal-content">

            <div  class="modal-header">
                <h4 class="cl-grey"><i class="fa fa-hospital-o"></i> Assign to a Branch</h4>
                <a data-dismiss="modal"><i class="fa fa-close"></i> </a>
            </div>
            <div  class="modal-body">

                <div class="row">

                    <div class="col-xs-12 col-md-12 col-sm-12 col-lg-12">

                        <div class="row form-group mg-bottom-10">
                            <div class="col-lg-3 col-md-3 col-sm-3 label-txt-right padding-right-0">
                                <label class="fs-14 cl-888">Branch:<span class="cl-red">*</span></label>
                            </div>
                            <div class="col-lg-7 col-md-7 col-sm-7">
                                <input type="text" v-model="assign_form.branch_id" required list="branch_list" @change="set_condition('branch')" class="form-control product-entry-input-field" id="selected_branch">
                                <datalist id="branch_list">
                                    <option v-for="practice_branch in practice_branches" :data-value="practice_branch.id" :value="practice_branch.name+' ('+practice_branch.category+')'"></option>
                                </datalist>
                            </div>
                        </div>

                        <div class="row form-group mg-bottom-10">
                            <div class="col-lg-3 col-md-3 col-sm-3 label-txt-right padding-right-0">
                                <label class="fs-14 cl-888">Department:<span class="cl-red">*</span></label>
                            </div>
                            <div class="col-lg-7 col-md-7 col-sm-7">
<!--                                <input type="text" required list="department_list" class="form-control product-entry-input-field">-->
<!--                                <datalist id="department_list">-->
<!--                                    <option v-for="role in hr_roles" :value="role.name">{{role.name}}</option>-->
<!--                                </datalist>-->
                                <input type="text" v-model="assign_form.practice_department_id" required list="department_list"
                                       @change="set_condition('department')" class="form-control product-entry-input-field" id="selected_department">
                                <datalist id="department_list">
                                    <option v-for="practice_department in practice_departments" :data-value="practice_department.id" :value="practice_department.name"></option>
                                </datalist>
                            </div>
                        </div>

                    </div>


                </div>

            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-inventory primary">
                    <span v-if="processing"><i class="fa fa-spinner fa-spin" aria-hidden="true"></i>Saving...</span>
                    <span v-else><i class="fa fa-save" aria-hidden="true"></i> Save</span>
                </button>
                <button data-dismiss="modal" class="btn btn-inventory">
                    <i class="fa fa-close" aria-hidden="true"></i> Close
                </button>
            </div>

        </div>

    </form>
    
</template>

<script>
    import {get,post} from "../../../../../helpers/api";
    import AppInfo from "../../../../../helpers/config";
    import {createHtmlErrorString} from "../../../../../helpers/functionmixin";
    export default {
        name: "AssignPlaceOfWork",
        props: ['user_data','practice_id'],
        data(){
            return {
                new_user_data: {},
                processing: false,
                assign_form: {
                    branch_id: '',
                    practice_department_id: '',
                    practice_user_id: this.user_data.id,
                },
                practice_branches: [],
                practice_departments: []
            }
        },
        methods: {

            loadPracts(){
                this.processing = true;
                get(AppInfo.app_data.server_domain+'/api/practices/branches/'+this.practice_id)
                    .then((res) => {
                        if(res.data.status_code === 200) {
                            this.practice_branches = res.data.results;
                            this.processing = false;
                        }
                    }).catch((err) => {
                    this.processing = false;
                });
            },

            assign_place(){
                this.processing = true;
                this.assign_form.practice_user_id = this.user_data.id;
                post(AppInfo.app_data.server_domain+'/api/practices/users/work_places',this.assign_form)
                    .then((res) => {
                        if(res.data.status_code === 200) {
                            this.processing = false;
                            this.$awn.success(res.data.description);
                            this.$emit("userAssigned");
                            this.assign_form.practice_department_id = '';
                            this.assign_form.practice_user_id = ''; //assign_form
                            this.assign_form.branch_id = ''; //assign_form
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

            set_condition(type_){

                switch (type_) {
                    case "branch":
                        let value = $('#selected_branch').val();
                        let branch_id = $('#branch_list [value="' + value + '"]').data('value');
                        if (branch_id !== "") {
                            this.assign_form.branch_id = branch_id;
                            this.loadBranch(branch_id);
                        }
                        break;
                    case "department":
                        let value1 = $('#selected_department').val();
                        let department_id = $('#department_list [value="' + value1 + '"]').data('value');
                        if (department_id !== "") {
                            this.assign_form.practice_department_id = department_id;
                        }
                        break;
                }
            },

            loadBranch: function (branch_id) {
                this.processing = true;
                get(AppInfo.app_data.server_domain+'/api/practices/'+branch_id)
                    .then((res) => {
                        if(res.data.status_code === 200) {
                            this.pharmacy = res.data.results;
                            this.pharmacy_branch = res.data.results;
                            console.info(res.data.results);
                            //this.initializers();
                            this.practice_departments = this.pharmacy_branch.departments,
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

            checkIf(event){
                if (event.target.checked){
                    this.permission_form.permissions.push(event.target.value)
                }else {
                    let index = this.permission_form.permissions.indexOf(event.target.value);
                    if (index > -1) {
                        this.permission_form.permissions.splice(index, 1);
                    }
                }
            }
        },
        mounted(){
            this.loadPracts();
        }
    }
</script>

<style scoped>

</style>