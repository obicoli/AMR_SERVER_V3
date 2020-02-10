<template>

    <div class="hold-transition skin-yellow sidebar-collapse">

        <loading :is-loading="processing"></loading>

        <page-header :initialization="true"></page-header>

        <div class="content-wrapper mg-bottom-50">

            <section class="content-header">
                <div class="row">
                    <div class="col-md-12">
                        <div class="pull pull-left app-header width-50-pc">
                            <h5>
                                Departments |
                                <small>{{pharmacy_departments.length}}</small>
                            </h5>
                        </div>
                        <div class="pull pull-right width-50-pc text-right">
                            <a data-toggle="modal" data-target="#add_department_modal2" class="btn btn-inventory">
                                <i class="fa fa-plus" aria-hidden="true"></i>
                                Create Department
                            </a>
                        </div>
                    </div>
                </div>
            </section>

            <section class="content bg-white">

                <div class="row">
                    <div class="col-xs-12 col-md-9 col-sm-12">

                        <div class="box border-top-0 border-bottom-0 border-radius-0" id="print-section">
                            <div class="box-header box-header-custom">
                                <div class="pull pull-left width-20-pc">
                                    <h3 class="box-title fs-15 fw-600">Department List :</h3>
                                </div>
                                <div class="pull pull-right width-80-pc">

                                    <div class="pull pull-left width-60-pc">
                                        <button :disabled="pharmacy_departments.length < 1" class="btn btn-inventory">
                                            <i class="fa fa-file-excel-o" aria-hidden="true"></i>
                                            Csv
                                        </button>
                                        <button :disabled="pharmacy_departments.length < 1" class="btn btn-inventory">
                                            <i class="fa fa-file-excel-o" aria-hidden="true"></i>
                                            Excel
                                        </button>
                                        <button :disabled="pharmacy_departments.length < 1" class="btn btn-inventory">
                                            <i class="fa fa-file-pdf-o" aria-hidden="true"></i>
                                            PDF
                                        </button>
                                    </div>
                                    <div class="pull-right pull width-40-pc">
                                        <select @change="" class="form-control selectpicker bg-white height-32 border-radius-2 border-ccc" style="width: 100%;">
                                            <option value="">Search Department</option>
                                            <option v-for="pstore in pharmacy_departments" :value="pstore.id">{{pstore.name}}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="box-body bg-white padding-0">
                                <table class="items table table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th style="width: 5%"><input type="checkbox" value="select_all" @click="selectAllDepts($event)"></th>
                                        <th style="width: 20%">Department</th>
                                        <th style="width: 20%">Branch</th>
                                        <th style="width: 30%">Description</th>
                                        <th style="width: 15%">Status</th>
                                        <th style="width: 10%">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody class="noprintclass">
                                    <tr v-if="pharmacy_departments.length > 0" v-for="pstore in pharmacy_departments">
                                        <td><input type="checkbox" v-model="selected_departments" :value="pstore.id" @click="setThis($event)"></td>
                                        <td>{{pstore.name}}</td>
                                        <td>{{pstore.branch}}</td>
                                        <td>{{pstore.description}}</td>
                                        <td>
                                            <span v-if="pstore.status==='1'"><i class="sub-icon-settings fa fa-circle-o cl-success"></i>&nbsp; &nbsp; Active</span>
                                            <span v-if="pstore.status==='0'"><i class="sub-icon-settings fa fa-circle-o cl-danger"></i>&nbsp;&nbsp; Inactive</span>
                                        </td>
                                        <td class="text-right">
                                            <a href="#" title="View details" class="cl-444 showOnHover"><i class="fa fa-pencil"></i></a>&nbsp;&nbsp;&nbsp;
                                            <a @click="delete_item(pstore)" data-toggle="modal" data-target="#delete_department_modal" title="Delete" class="cl-red showOnHover"><i class="fa fa-trash-o"></i></a>
                                        </td>
                                    </tr>
                                    <tr v-else>
                                        <td colspan="4" class="text-center cl-red">
                                            No store to display
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="text-center">
                            <button :disabled="pharmacy_departments.length < 1" class="btn btn-inventory">
                                <i class="fa fa-plus" aria-hidden="true"></i>
                                Add Service
                            </button>
                            <button :disabled="pharmacy_departments.length < 1" class="btn btn-inventory">
                                <i class="fa fa-print" aria-hidden="true"></i>
                                Print all departments
                            </button>
                            <button :disabled="pharmacy_departments.length < 1" class="btn btn-inventory">
                                <i class="fa fa-envelope-o" aria-hidden="true"></i>
                                Email all departments
                            </button>
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-3 col-sm-12">
                        <div class="box border-top-0 border-bottom-0 border-radius-0">
                            <div class="box-header box-header-custom">
                                <h3 class="box-title fs-15"><i class="fa fa-arrow-circle-right" aria-hidden="true"></i> Department summary :</h3>
                            </div>
                            <div class="box-body bg-white padding-0">
                                <table class="items table table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th style="width: 33.33%">Departments</th>
                                        <th style="width: 33.33%">Stores</th>
                                        <th style="width: 33.33%">Users</th>
                                    </tr>
                                    </thead>
                                    <tbody class="noprintclass">
                                    <tr>
                                        <td>{{pharmacy_departments.length}}</td>
                                        <td>{{total_stores}}</td>
                                        <td>{{total_users}}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- (Ajax Modal)-->
                <div class="modal fade" id="add_department_modal2">
                    <div class="modal-dialog modal-dialog-centered zoomInUp flipOutX" >
                        <form @submit.prevent="add_department">

                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="cl-grey"><i class="fa fa-plus-circle"></i> Add New Department:</h4>
                                    <a data-dismiss="modal"><i class="fa fa-close"></i> </a>
                                </div>
                                <div  class="modal-body">
                                    <div class="row form-group mg-bottom-10">
                                        <div class="col-lg-3 col-md-3 col-sm-3 label-txt-right padding-right-0">
                                            <label class="fs-14 cl-888">Department name:<span class="cl-red">*</span></label>
                                        </div>
                                        <div class="col-lg-7 col-md-7 col-sm-7">
                                            <input type="text" required v-model="depart_form.name" @keydown="search_department($event)" list="search_list" class="form-control product-entry-input-field">
                                            <datalist id="search_list">
                                                <option v-for="search_list in searched_list" :value="search_list.name">{{search_list.name}}</option>
                                            </datalist>
                                        </div>
                                    </div>

                                    <div class="row form-group mg-bottom-10">
                                        <div class="col-lg-3 col-md-3 col-sm-3 label-txt-right padding-right-0">
                                            <label class="fs-14 cl-888">Branch:<span class="cl-red">*</span></label>
                                        </div>
                                        <div class="col-lg-7 col-md-7 col-sm-7">
                                            <input type="text" required v-model="depart_form.branch_id" @keydown="search_branch($event)" @change="set_branch('branch')" list="branch_list" id="selected_branc" class="form-control product-entry-input-field">
                                            <datalist id="branch_list">
                                                <option v-for="pharmacy_branche in pharmacy_branches" :data-value="pharmacy_branche.id" :value="pharmacy_branche.name"></option>
                                            </datalist>
                                        </div>
                                    </div>

                                    <div class="row form-group mg-bottom-15">
                                        <div class="col-lg-3 col-md-3 col-sm-3 label-txt-right padding-right-0">
                                            <label class="fs-14 cl-888">Description:<span class="cl-red">*</span></label>
                                        </div>
                                        <div class="col-lg-7 col-md-7 col-sm-7">
                                            <textarea v-model="depart_form.description" placeholder="" style="max-height: 70px!important;" class="form-control" rows="5"></textarea>
                                        </div>
                                    </div>

                                    <div class="row form-group">
                                        <div class="col-lg-3 col-md-3 col-sm-3 label-txt-right padding-right-0">
                                            <label class="fs-14 cl-888">Status:<span class="cl-red">*</span></label>
                                        </div>
                                        <div class="col-lg-7 col-md-7 col-sm-7">
                                            <select v-model="depart_form.status" required class="form-control product-entry-input-field" data-live-search="true" style="width: 100%;">
                                                <option value="" disabled selected>-select-</option>
                                                <option value="1">Active</option>
                                                <option value="0">Inactive</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button data-dismiss="modal" class="btn btn-inventory">
                                        <i class="fa fa-close" aria-hidden="true"></i> Close
                                    </button>
                                    <button type="button" class="btn btn-inventory">
                                        <i class="fa fa-refresh" aria-hidden="true"></i> Reset
                                    </button>
                                    <button type="submit" class="btn btn-inventory primary">
                                        <span v-if="processing"><i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Saving...</span>
                                        <span v-else><i class="fa fa-save" aria-hidden="true"></i> Save</span>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div> <!-- Bootstrap model  ends-->
                <!-- /.content -->

                <!-- (Ajax Modal)-->
                <div class="modal fade" id="delete_department_modal">
                    <div class="modal-dialog modal-dialog-centered zoomInUp flipOutX" >
                        <delete-stuff-modal v-if="ready_to_delete" v-on:deletionSuccessful="loadDepartments" :item_url="delete_item_on_url" :modal_title="'Delete Department'" :confirm_message="'Are you sure you want to delete this department?'"></delete-stuff-modal>
                    </div>
                </div> <!-- Bootstrap model  ends-->
                <!-- /.content -->

            </section>

        </div>

        <page-footer></page-footer>
    </div>

</template>

<script>
    import PageHeader from '../../patials/Header'
    import PageFooter from '../../patials/Footer'
    import Loading from '../../../../../components/loads/ProgRess'
    import DeleteStuffModal from '../../../pharmacy/patials/DeleteStuffModal'
    import DepartmentModal from '../branches/partials/DepartmentModal'
    import {get,post} from "../../../../../helpers/api";
    import AppInfo from "../../../../../helpers/config";
    import Auth from "../../../../../store/auth";
    import {createHtmlErrorString} from "../../../../../helpers/functionmixin";

    export default {
        name: "Index",
        components: {
            PageFooter,PageHeader,Loading,DepartmentModal,DeleteStuffModal
        },
        data(){
            return {
                delete_item_on_url: '',
                ready_to_delete: false,
                processing: false,
                pharmacy_departments: [],
                selected_departments: [],
                pharmacy_branches: [],
                searched_list: [],
                total_stores: 0,
                total_users: 0,
                depart_form: {
                    name: '',
                    description: '',
                    branch_id: '',
                    status: '',
                }
            }
        },
        methods: {
            delete_item(item_to){
                this.delete_item_on_url = AppInfo.app_data.server_domain+'/api/branches/departments/'+item_to.id;
                this.ready_to_delete = true;
            },
            add_department: function () {
                this.processing = true;
                post(AppInfo.app_data.server_domain+'/api/branches/departments',this.depart_form)
                    .then((res) => {
                        if(res.data.status_code === 200) {
                            this.depart_form.status = "";
                            this.depart_form.name = "";
                            this.depart_form.description = "";
                            this.selected_departments = [];
                            this.$awn.success(res.data.description);
                            this.loadDepartments();
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
            loadDepartments: function () {
                this.processing = true;
                get(AppInfo.app_data.server_domain+'/api/branches/departments')
                    .then((res) => {
                        if(res.data.status_code === 200) {
                            this.pharmacy_departments = res.data.results;
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
            loadBranches: function () {
                this.processing = true;
                get(AppInfo.app_data.server_domain+'/api/branches')
                    .then((res) => {
                        if(res.data.status_code === 200) {
                            this.pharmacy_branches = res.data.results;
                            console.info(this.pharmacy_branches);
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
            search_department(event){
                post(AppInfo.app_data.server_domain+'/api/search/departments',this.depart_form)
                    .then((res) => {
                        if(res.data.status_code === 200) {
                            this.searched_list = res.data.results;
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
                });
            },
            search_branch(event){
                let main_practice_id = Auth.getMain().id;
                let formData = new FormData();
                formData.append('main_practice_id', main_practice_id);
                formData.append('name', event.target.value);
                post(AppInfo.app_data.server_domain+'/api/search/branches',formData)
                    .then((res) => {
                        if(res.data.status_code === 200) {
                            this.pharmacy_branches = res.data.results;
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
                });
            },
            selectAllDepts: function (event) {

                if (event.target.checked){
                    for ( let l = 0; l < this.pharmacy_departments.length; l++ ){
                        this.selected_departments.push(this.pharmacy_departments[l].id);
                    }
                } else {
                    this.selected_departments = [];
                }

            },
            setThis(event){
                if (event.target.checked){
                    this.selected_departments.push(event.target.value)
                }
            },
            initializers: function () {
                this.total_departments = 0;
                this.total_users = 0;
                this.total_stores = 0;
                for ( let r=0; r < this.pharmacy_departments.length; r++ ){
                    this.total_departments += this.pharmacy_departments[r].departments.length;
                    this.total_users += this.pharmacy_departments[r].users.length;
                    this.total_stores += this.pharmacy_departments[r].stores.length;
                }
            },
            set_branch(type_){

                switch (type_) {
                    case "branch":
                        let value = $('#selected_branc').val();
                        let branch_id = $('#branch_list [value="' + value + '"]').data('value');
                        if (branch_id !== "") {
                            this.depart_form.branch_id = branch_id;
                        }
                        break;
                }

            },
        },
        mounted() {
            this.loadBranches();
            this.loadDepartments();
        }
    }
</script>

<style lang="scss">
    @import '../../../../../../../node_modules/vue-awesome-notifications/dist/styles/style';
</style>