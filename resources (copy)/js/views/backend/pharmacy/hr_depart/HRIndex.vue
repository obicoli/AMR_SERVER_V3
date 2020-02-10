<template>

    <div class="hold-transition skin-yellow sidebar-collapse">

        <loading :is-loading="processing"></loading>

        <page-header :initialization="true"></page-header>

        <div class="content-wrapper">

            <!-- pages navigates here -->
            <section class="content-header">
                <div class="row">
                    <div class="col-md-12">
                        <div class="pull pull-left app-header width-40-pc">
                            <h5>
                                Human Resource |
                                <small>Users</small>&nbsp;&nbsp;&nbsp;
                            </h5>
                        </div>
                        <div class="pull pull-right app-header text-right width-60-pc">
                            <button data-toggle="modal" data-target="#add_employee_modal" class="btn btn-inventory primary">
                                <i class="fa fa-plus" aria-hidden="true"></i>
                                Add User
                            </button>
                        </div>
                    </div>
                </div>
            </section>

            <section class="content bg-white">

                <div class="row">
                    <div class="col-xs-12 col-md-8 col-lg-8 col-sm-12">

                        <div class="box border-top-0 border-bottom-0 border-radius-0" id="print-section">
                            <div class="box-header box-header-custom">
                                <div class="pull pull-left width-20-pc">
                                    <h3 class="box-title fs-15 fw-600 txt-uppercase">Users:</h3>
                                </div>
                                <div class="pull pull-right width-80-pc">

                                    <div class="pull pull-right text-right width-40-pc">
                                        <select class="form-control selectpicker bg-white height-32 border-radius-2 border-ccc" data-live-search="true" style="width: 100%;">
                                            <option value="">Search employee</option>
                                        </select>
                                    </div>

                                </div>
                            </div>
                            <div class="box-body bg-white padding-0">
                                <table class="items table table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th style="width: 10%">#ID</th>
                                        <th style="width: 22%">Full Name</th>
                                        <th style="width: 20%">Email</th>
                                        <th style="width: 20%">Role</th>
                                        <th style="width: 12%">Status</th>
                                        <th style="width: 16%">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody class="noprintclass">
                                    <tr v-if="practice_users.length > 0" v-for="puser in practice_users">
                                        <td>#</td>
                                        <td>{{puser.first_name}} {{puser.other_name}}</td>
                                        <td>{{puser.email}}</td>
                                        <td>{{puser.role}}</td>
                                        <td>
                                            <span v-if="puser.status==='1'"><i v-bind:class="{'sub-icon-settings fa fa-circle-o cl-success':true}"></i> Active</span>
                                            <span v-else ><i v-bind:class="{'sub-icon-settings fa fa-circle-o cl-danger':true}"></i> Inactive</span>
                                        </td>
                                        <td class="text-right">
                                            <a @click="view_user(puser)" data-toggle="modal" data-target="#assign_branch_modal" title="Assign to a Branch" class="cl-444 showOnHover"><i class="fa fa-hospital-o"></i></a>&nbsp;&nbsp;&nbsp;
                                            <a @click="view_user(puser)" data-toggle="modal" data-target="#assign_privilege_modal" title="Assign Privilege" class="cl-444 showOnHover"><i class="fa fa-plus"></i></a>&nbsp;&nbsp;&nbsp;
                                            <a @click="view_user(puser)" data-toggle="modal" data-target="#view_employee_modal" title="View details" class="cl-444 showOnHover"><i class="fa fa-pencil"></i></a>&nbsp;&nbsp;&nbsp;
                                            <a title="Delete" class="cl-red showOnHover"><i class="fa fa-trash-o"></i></a>
                                        </td>
                                    </tr>
                                    <tr v-else>
                                        <td colspan="8" class="text-center cl-red">
                                            No data to display
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>

                        </div>

                        <div class="text-center">
                            <button class="btn btn-inventory">
                                <i class="fa fa-file-excel-o" aria-hidden="true"></i>
                                Export to Csv
                            </button>
                            <button class="btn btn-inventory">
                                <i class="fa fa-file-excel-o" aria-hidden="true"></i>
                                Import users
                            </button>
                            <button class="btn btn-inventory">
                                <i class="fa fa-print" aria-hidden="true"></i>
                                Print Report with all users
                            </button>
                            <button class="btn btn-inventory">
                                <i class="fa fa-envelope-o" aria-hidden="true"></i>
                                Email Report with all users
                            </button>
                        </div>
                    </div>

                    <div class="col-xs-12 col-md-4 col-lg-4 col-sm-12 hidden-xs">
                        <div class="box border-top-0 border-bottom-0 border-radius-0" id="-section">
                            <div class="box-header box-header-custom">
                                <div class="pull pull-left">
                                    <h3 class="box-title fs-15 fw-600">HR Roles:</h3>
                                </div>
                                <div class="pull-right pull">
                                    <button data-toggle="modal" data-target="#add_role_modal" class="btn btn-inventory">
                                        <i class="fa fa-plus" aria-hidden="true"></i>
                                        Add Role
                                    </button>
                                </div>
                            </div>
                            <div class="box-body bg-white padding-0">
                                <table class="items table table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th style="width: 70%">Role</th>
                                        <th style="width: 30%">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody class="noprintclass">
                                        <tr v-if="hr_roles.length > 0" v-for="hr_role in hr_roles">
                                            <td>{{hr_role.name}}</td>
                                            <td class="text-right">
                                                <a title="View details" class="cl-444 showOnHover"><i class="fa fa-pencil"></i></a>&nbsp;&nbsp;&nbsp;
                                                <a title="Delete" class="cl-red showOnHover"><i class="fa fa-trash-o"></i></a>
                                            </td>
                                        </tr>
                                        <tr v-else>
                                            <td colspan="2" class="text-center cl-red">
                                                No data to display
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- (Ajax Modal)-->
                <div class="modal fade" id="add_employee_modal">
                    <div class="modal-dialog modal-dialog-centered zoomInUp flipOutX" >
                        <add-employee-modal v-if="page_ready" v-on:userAdded="loadUsers" :form_data="user_form" :user_mode="'Create'" :hr_roles="hr_roles" :branch_id="branch_id"></add-employee-modal>
                    </div>
                </div> <!-- Bootstrap model  ends-->
                <!-- /.content -->

                <!-- (Ajax Modal)-->
                <div class="modal fade" id="assign_privilege_modal">
                    <div class="modal-dialog modal-lg modal-dialog-centered zoomInUp flipOutX">
                        <assign-privilege-modal v-if="view_user_checker && page_ready" :user_data="viewed_user_data"></assign-privilege-modal>
                    </div>
                </div> <!-- Bootstrap model  ends-->
                <!-- /.content -->

                <!-- (Ajax Modal)-->
                <div class="modal fade" id="assign_branch_modal">
                    <div class="modal-dialog modal-dialog-centered zoomInUp flipOutX">
                        <assign-place-of-work v-if="view_user_checker" :practice_id="branch_id" :user_data="viewed_user_data" v-on:userAssigned="loadUsers"></assign-place-of-work>
                    </div>
                </div> <!-- Bootstrap model  ends-->
                <!-- /.content -->

                <!-- (Ajax Modal)-->
                <div class="modal fade" id="view_employee_modal">
                    <div class="modal-dialog modal-lg modal-dialog-centered zoomInUp flipOutX">
                        <view-user-modal v-if="view_user_checker" :user_data="viewed_user_data"></view-user-modal>
                    </div>
                </div> <!-- Bootstrap model  ends-->
                <!-- /.content -->

                <!-- (Ajax Modal)-->
                <div class="modal fade" id="add_store_modal">
                    <div class="modal-dialog modal-dialog-centered zoomInUp flipOutX">

                    </div>
                </div> <!-- Bootstrap model  ends-->
                <!-- /.content -->
                <!-- (Ajax Modal)-->
                <div class="modal fade" id="add_new_branch_modal">
                    <div class="modal-dialog modal-lg modal-lg-custom modal-dialog-centered zoomInUp flipOutX">

                    </div>
                </div> <!-- Bootstrap model  ends-->
                <!-- /.content -->
                <!-- (Ajax Modal)-->
                <div class="modal fade" id="add_role_modal">
                    <div class="modal-dialog modal-dialog-centered zoomInUp flipOutX" >
                        <role-model v-if="page_ready" :user_mode="'Create'" :branch_id="branch_id" :form_data="role_form" v-on:roleAdded="loadHr"></role-model>
                    </div>
                </div> <!-- Bootstrap model  ends-->
                <!-- /.content -->

            </section>

        </div>

        <page-footer></page-footer>

    </div>

</template>

<script>
    import PageHeader from '../patials/AdminHeader'
    import PageFooter from '../patials/Footer'
    import AddEmployeeModal from './partials/AddEmployeeModal'
    import ViewUserModal from './partials/ViewUserModal'
    import AssignPrivilegeModal from './partials/AssignPrivilegeModal'
    import AssignPlaceOfWork from './partials/AssignPlaceOfWork'
    import RoleModel from './partials/RoleModel'
    import Loading from '../../../../components/loads/ProgRess'
    import {get} from "../../../../helpers/api";
    import Auth from "../../../../store/auth";
    import AppInfo from "../../../../helpers/config";

    export default {
        name: "HRIndex",
        components: {
            RoleModel,
            PageFooter,PageHeader,Loading,AddEmployeeModal,ViewUserModal,AssignPrivilegeModal,AssignPlaceOfWork
        },
        data(){
            return {
                processing: false,
                branch_id: '',
                user_form: {
                    role_name: '',
                    first_name: '',
                    other_name: '',
                    email: '',
                    mobile: '',
                    gender: '',
                    password: '',
                    status: '',
                    address: '',
                    branch_id: ''
                },
                role_form: {
                    name: '',
                    description: '',
                    branch_id: '',
                    status: '',
                },
                hr_roles: [],
                practice_users: [],
                viewed_user_data: {},
                view_user_checker: false,
                page_ready: false,
            }
        },
        created(){
            //console.info(Auth.getHr())
        },
        methods: {
            loadHr() {
                this.processing = true;
                get(AppInfo.app_data.server_domain+'/api/practices/roles/'+this.branch_id)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.hr_roles = res.data.results;
                        this.processing = false;
                    }
                }).catch((err) => {
                    this.processing = false;
                });
            },
            loadUsers() {
                this.processing = true;
                get(AppInfo.app_data.server_domain+'/api/practices/'+this.branch_id+'/'+'Human Resource')
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.practice_users = res.data.results.users;
                        console.info(this.practice_users);
                        this.processing = false;
                    }
                }).catch((err) => {
                    this.processing = false;
                });
            },
            view_user(puser){
                this.viewed_user_data = puser;
                this.view_user_checker = true;
            }
        },
        mounted(){
            this.branch_id = Auth.getCurrentAccount('id');
            this.role_form.branch_id = this.branch_id;
            this.user_form.branch_id = this.branch_id;
            this.page_ready = true;
            console.info(this.role_form.branch_id);
            this.loadHr();
            this.loadUsers();
        }
    }
</script>

<style scoped>

</style>