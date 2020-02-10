<template>

    <div>

        <top-nav-bar :inventory="true"></top-nav-bar>

        <side-bar></side-bar>

        <div class="wp-content">

            <div class="row">

                <div class="col-md-12 col-lg-12 col-sm-12 padding-left-0">
                    <div class="settings-header shadowed main-heading bg-foo">Branches:</div>
                    <div class="ui fitted divider"></div>
                    <div class="row mg-top-35">
                        <div class="col-md-2 col-lg-2 col-sm-2 padding-right-0 bg-foo min-height-100-vh">
                            <side-bar-settings :scrollable="false" :width="true" :transparent="true" :active_link="'branches'"></side-bar-settings>
                        </div>
                        <div class="col-md-10 col-lg-10 col-sm-10 padding-right-0 padding-left-0 bg-foo min-height-100-vh">
                            <div class="box box-primary bg-white border-top-0 border-bottom-0 no-shadowed">

                                <div class="width-100-pc padding-left-20 padding-right-20 padding-top-20 padding-bottom-20 mg-bottom-30">
                                    <div class="filter-block form-inline float-left">
                                        <input type="text" placeholder="Find by name" class="form-control product-entry-input-field">
                                    </div>
                                    <div  class="btn-group float-right" role="group" aria-label="Button group with nested dropdown">
                                        <button data-toggle="modal" data-target="#add_bill_modal" type="button" class="btn combo-button primary">+ New Branch</button>
                                        <div class="btn-group" role="group">
                                            <button id="btnGroupDrop" type="button" class="btn combo-button primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="btnGroupDrop">
                                                <a class="dropdown-item" href="#">Import Branches</a>
                                                <a class="dropdown-item"> + New Branch type</a>
                                            </div>
                                        </div>
                                    </div>
                                    <bill-modal v-if="page_loaded" :modal_id="'add_bill_modal'" :hr_role="hr_roles" :user_mode="'Create'" :branch_id="branch_id" :form_data="user_form" :title="'Add Bill'"></bill-modal>
                                </div>

                                <div class="page-content bg-white min-height-100-vh padding-10">


                                    <div class="dgrid dgrid-grid ui-widget dgrid-03 mg-bottom-30 universal-grid border-ccc padding-left-20 padding-right-20" role="grid">

                                        <table class="user-table employees" role="presentation">
                                            <thead>
                                                <tr>
                                                    <th class="no-rb" style="width:5%">#ID</th>
                                                    <th style="width:30%">Name</th>
                                                    <th style="width:20%">Email</th>
                                                    <th style="width:15%">Mobile</th>
                                                    <th style="width:10%">Created At</th>
                                                    <th style="width:10%">Created By</th>
                                                    <th style="width:10%">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr class="tb-1" v-for="(employee,indexss) in 5" :key="indexss">
                                                    <td class="no-rb" tabindex="0">
                                                        {{indexss+1}}
                                                    </td>
                                                    <td class="">
                                                        BL4DUIOIM
                                                    </td>
                                                    <td class="">
                                                        2017-12-11
                                                    </td>
                                                    <td class="">
                                                        Kes {{formatMoneys(12000000)}}
                                                    </td>
                                                    <td class="">
                                                        16
                                                    </td>
                                                    <td class="">
                                                        8
                                                    </td>
                                                    <td class="">
                                                        <div  class="btn-group float-right" role="group" aria-label="Button group">
                                                            <a data-toggle="modal" data-target="#userModal" class="btn-link">Edit</a>&nbsp;&nbsp;
                                                            <div class="btn-group" role="group">
                                                                <a :id="'btnGroupDrop2_'+indexss" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                </a>
                                                                <div class="dropdown-menu" :aria-labelledby="'btnGroupDrop2_'+indexss">
                                                                    <a class="dropdown-item">Delete</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>

                                    </div>

                                </div>

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
    import SideBarSettings from "../partials/sidebars/SideBarSettings"
    import BillModal from "../partials/modals/BillModal";
    import {get} from "../../../../helpers/api";
    import AppInfo from "../../../../helpers/config";
    import Loading from "../../../../components/loads/ProgRess";
    import Auth from "../../../../store/auth";
    import DeleteStuffModal from '../../pharmacy/patials/DeleteStuffModal'
    import {formatMoney} from "../../../../helpers/functionmixin";
    export default {
        name: "Index",
        components: {TopNavBar, SideBar,SideBarSettings,Loading,DeleteStuffModal,BillModal},
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
            formatMoneys(money_to){
                return formatMoney(money_to)
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
        },
        mounted() {
            this.practice_id = Auth.getCurrentAccount('id');
            this.branch_id = Auth.getCurrentAccount('id');
            this.user_form.branch_id = this.branch_id;
            this.page_loaded = true;
        }
    }
</script>

