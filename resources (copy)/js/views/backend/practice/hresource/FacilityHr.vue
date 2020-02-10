<template>

    <div>

        <top-nav-bar :inventory="true"></top-nav-bar>

        <side-bar></side-bar>

        <div class="wp-content">

            <div class="row">

                <div class="col-md-12 col-lg-12 col-sm-12 padding-left-0">

                    <div class="settings-header shadowed main-heading bg-foo">Employees List:</div>
                    <div class="ui fitted divider"></div>
                    <div class="row mg-top-35">
                        <div class="col-md-2 col-lg-2 col-sm-2 padding-right-0 bg-foo min-height-100-vh">
                            <side-bar-hr v-if="page_loaded" :scrollable="false" :width="true" :transparent="true" :hr_role="hr_roles" :active_num="1"></side-bar-hr>
                        </div>
                        <div class="col-md-10 col-lg-10 col-sm-10 padding-right-0 padding-left-0 bg-foo min-height-100-vh">
                            <div class="box box-primary bg-white border-top-0 border-bottom-0 no-shadowed">

                                <div class="width-100-pc padding-left-20 padding-right-20 padding-top-20 padding-bottom-20 mg-bottom-30">
                                    <div class="filter-block form-inline float-left">
                                        <input type="text" placeholder="Find by name" class="form-control product-entry-input-field">
                                    </div>
                                    <div  class="btn-group float-right" role="group" aria-label="Button group with nested dropdown">
                                        <button data-toggle="modal" data-target="#add_employee_modal" type="button" class="btn combo-button primary">Add Employee</button>
                                        <div class="btn-group" role="group">
                                            <button id="btnGroupDrop" type="button" class="btn combo-button primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            </button>
                                            <div class="dropdown-menu right-0" aria-labelledby="btnGroupDrop">
                                                <a class="dropdown-item" href="#">Import employees</a>
                                                <a class="dropdown-item" data-toggle="modal" data-target="#add_role_modal">Add job title</a>
                                            </div>
                                        </div>
                                    </div>
                                    <add-role v-if="page_loaded" :modal_id="'add_role_modal'" :user_mode="'Create'" :branch_id="branch_id" :form_data="role_form" v-on:roleAdded="loadHrs"></add-role>
                                    <employee-modal v-if="page_loaded" :modal_id="'add_employee_modal'" :hr_role="hr_roles" :user_mode="'Create'" :branch_id="branch_id" :form_data="user_form" v-on:roleAdded="loadHrsy" :title="'Employee Information'"></employee-modal>
                                </div>

                                <div class="page-content bg-white min-height-100-vh padding-10">


                                    <div class="dgrid dgrid-grid ui-widget dgrid-03 mg-bottom-30 universal-grid border-ccc padding-left-20 padding-right-20" role="grid">

                                        <table class="user-table employees" role="presentation">
                                            <thead>
                                                <tr>
                                                    <th class="no-rb">Name</th>
                                                    <th>Mobile</th>
                                                    <th>Email</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="(employee,indexss) in employees_list" :key="indexss">
                                                    <td class="" tabindex="0">
                                                        {{employee.first_name}} {{employee.other_name}}
                                                    </td>
                                                    <td class="">
                                                        {{employee.email}}
                                                    </td>
                                                    <td class="">
                                                        {{employee.email}}
                                                    </td>
                                                    <td class="">
                                                        <div  class="btn-group float-right" role="group" aria-label="Button group">
                                                            <a data-toggle="modal" data-target="#userModal" class="btn-link">Edit</a>&nbsp;&nbsp;
                                                            <div class="btn-group" role="group">
                                                                <a :id="'btnGroupDrop2_'+indexss" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                </a>
                                                                <div class="dropdown-menu right-0" :aria-labelledby="'btnGroupDrop2_'+indexss">
                                                                    <a class="dropdown-item">Make master admin</a>
                                                                </div>
                                                            </div>
                                                            <!-- <master-modal :practice_user="usery" :initial_url="initial_url+'/master'" :practice_id="practice_id" :modal_id="'master_user_modal_'+indexss"></master-modal> -->
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>

                                    </div>

                                </div>

                                <!-- <new-user-modal v-if="page_ready" :modal_id="'userModal'" :practice_id="practice_id" :initial_url="initial_url" :title="'Add a new user'" :user_mode="'Create'" v-on:userAdded="loadUsers"></new-user-modal> -->
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
</template>

<script>
    import SideBar from "../partials/sidebars/SideBar"
    import TopNavBar from "../partials/topbars/TopNavBar"
    import SideBarHr from "../partials/sidebars/SideBarHr"
    import AddRole from "../partials/modals/AddRole";
    import EmployeeModal from "../partials/modals/Employee";
    import DepartmentModal from "../../pharmacy/initialization/branches/partials/DepartmentModal"
    import {get} from "../../../../helpers/api";
    import AppInfo from "../../../../helpers/config";
    import Loading from "../../../../components/loads/ProgRess";
    import Auth from "../../../../store/auth";
    import DeleteStuffModal from '../../pharmacy/patials/DeleteStuffModal'
    import AddEmployeeModal from '../../pharmacy/hr_depart/partials/AddEmployeeModal'
    // import RoleModel from '../../pharmacy/hr_depart/partials/RoleModel'
    import ViewUserModal from '../../pharmacy/hr_depart/partials/ViewUserModal'
    import AssignPrivilegeModal from '../../pharmacy/hr_depart/partials/AssignPrivilegeModal'
    import AssignPlaceOfWork from '../../pharmacy/hr_depart/partials/AssignPlaceOfWork'
    import {createHtmlErrorString} from "../../../../helpers/functionmixin";
    export default {
        name: "FacilityHr",
        components: {TopNavBar, SideBar,SideBarHr,DepartmentModal,Loading,DeleteStuffModal,EmployeeModal,AddRole},
        data(){
            return {
                employees_list: [],
                initial_url: '/api/practices/departments',
                branch_id: '',
                practice_id: '',
                processing: false,
                page_loaded: false,
                hr_roles: [],
                system_permissions: [],
                department_form: {
                    name: '',
                    description: '',
                    branch_id: '',
                    status: '',
                },
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
            }
        },
        methods: {
            loadHrsy(){
                this.loadUsers();
                //window.location.reload();
            },
            addRole(){
            },
            loadUsers() {
                this.processing = true;
                get(AppInfo.app_data.server_domain+'/api/practices/'+this.branch_id+'/'+'Human Resource')
                    .then((res) => {
                        if(res.data.status_code === 200) {
                            this.employees_list = res.data.results.resources;
                            this.processing = false;
                            //console.info(this.employees_list )
                        }
                    }).catch((err) => {
                    this.processing = false;
                });
            },
            load_User(user_obj) {
                window.location.reload();
                // this.processing = true;
                // get(AppInfo.app_data.server_domain+'/api/practices/'+this.branch_id+'/'+'Human Resource')
                //     .then((res) => {
                //         if(res.data.status_code === 200) {
                //             this.employees_list = res.data.results.resources;
                //             this.processing = false;
                //             console.info(this.employees_list )
                //         }
                //     }).catch((err) => {
                //     this.processing = false;
                // });
            },
            loadHrs() {
                this.processing = true;
                get(AppInfo.app_data.server_domain+'/api/practices/roles/'+this.practice_id)
                    .then((res) => {
                        if(res.data.status_code === 200) {
                            this.hr_roles = res.data.results;
                            this.processing = false;
                            console.info(this.hr_roles);
                            this.page_loaded = true;
                        }
                    }).catch((err) => {
                    this.processing = false;
                });
            },
            load_Hr() {
                this.processing = true;
                get(AppInfo.app_data.server_domain+'/api/practices/roles/'+this.practice_id)
                    .then((res) => {
                        if(res.data.status_code === 200) {
                            this.hr_roles = res.data.results;
                            this.processing = false;
                        }
                    }).catch((err) => {
                    this.processing = false;
                });
            },
            load_Permissions() {
                this.processing = true;
                get(AppInfo.app_data.server_domain+'/api/permissions')
                    .then((res) => {
                        if(res.data.status_code === 200) {
                            this.system_permissions = res.data.results;
                            this.processing = false;
                            //console.info(this.system_permissions)
                        }
                    }).catch((err) => {
                    this.processing = false;
                });
            },
        },
        mounted() {
            this.practice_id = Auth.getCurrentAccount('id');
            this.branch_id = Auth.getCurrentAccount('id');
            this.user_form.branch_id = this.branch_id;
            this.loadUsers();
            this.load_Permissions();
            this.loadHrs();
        }
    }
</script>

<style scoped>
    @import "../../../../../sass/style.css";
    /*Acco*/
    .ac-container {
        max-width: 400px;
    }

    .ac-container label {
        font-family: 'Source Sans Pro', 'Helvetica Neue', Helvetica, Arial, sans-serif!important;
        padding: 0 20px;
        position: relative;
        z-index: 20;
        display: block;
        height: 35px;
        cursor: pointer;
        color: #444!important;
        text-shadow: 1px 1px 1px rgba(255,255,255,0.8);
        line-height: 33px;
        font-size: 1.5rem!important;
        background: #fff;
        margin-top: 5px!important;
        filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#fff',endColorstr='#eaeaea',GradientType=0 );
        box-shadow: 0 0 0 1px rgba(155,155,155,0.3),1px 0 0 rgba(255,255,255,0.9) inset,0 2px 2px rgba(0,0,0,0.1);
    }

    .ac-container {
        width: 100%;
        margin: 10px auto 30px auto;
        text-align: left;
    }

    .ac-container label:hover {
        background: #fff;
    }

    .ac-container input:checked + label,.ac-container input:checked + label:hover {
        background: #f1f2f3;
        color: #666;
        text-shadow: 0 1px 1px rgba(255,255,255,0.6);
        box-shadow: 0 0 0 1px rgba(155,155,155,0.3),0 2px 2px rgba(0,0,0,0.1);
        height: 30px;
        line-height: 21px;
        font-size: 13px;
    }

    .ac-container label:hover:after,.ac-container input:checked + label:hover:after {
        content: '';
        position: absolute;
        width: 24px;
        height: 24px;
        right: 13px;
        top: 7px;
        /*background: transparent url(../images/arrow_down.png) no-repeat center center;*/
    }

    .ac-container input:checked + label:hover:after {
        /*background-image: url(../images/arrow_up.png);*/
    }

    .ac-container input {
        /*display: none;*/
    }
    /*.ac-container div article div span input{ display: block!important;}*/

    .ac-container article {
        background: rgba(255,255,255,0.5);
        margin-top: -1px;
        overflow: hidden;
        height: 0;
        position: relative;
        z-index: 10;
        -webkit-transition: height 0.3s ease-in-out,box-shadow 0.6s linear;
        -moz-transition: height 0.3s ease-in-out,box-shadow 0.6s linear;
        -o-transition: height 0.3s ease-in-out,box-shadow 0.6s linear;
        -ms-transition: height 0.3s ease-in-out,box-shadow 0.6s linear;
        transition: height 0.3s ease-in-out,box-shadow 0.6s linear;
    }

    .ac-container article p {
        font-style: normal;
        color: #777;
        line-height: 23px;
        font-size: 10px;
        padding: 20px;
        text-shadow: 1px 1px 1px rgba(255,255,255,0.8);
        /*font: normal normal 12px 'Open Sans';*/
    }

    .ac-container input:checked ~ article {
        -webkit-transition: height 0.5s ease-in-out,box-shadow 0.1s linear;
        -moz-transition: height 0.5s ease-in-out,box-shadow 0.1s linear;
        -o-transition: height 0.5s ease-in-out,box-shadow 0.1s linear;
        /*-ms-transition: height 0.5s ease-in-out,box-shadow 0.1s linear;*/
        transition: height 0.5s ease-in-out,box-shadow 0.1s linear;
        box-shadow: 0 0 0 1px rgba(155,155,155,0.3);
    }

    .ac-container input:checked ~ article.ac-small {
        /*height: 140px;*/
        /*min-height: 200px!important;*/
        height: auto;
        max-height: 200px!important;
        overflow-y: scroll!important;
        margin-bottom: 20px!important;
        padding-left: 20px!important;

    }

    .ac-container input:checked ~ article.ac-medium {
        height: 180px;
    }

    .ac-container input:checked ~ article.ac-large {
        height: 230px;
    }
</style>