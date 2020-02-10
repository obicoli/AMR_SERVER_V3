<template>

    <div>

        <processing-overlay :message="msg" :status="progress_overlay"></processing-overlay>

        <top-nav-bar :inventory="true"></top-nav-bar>

        <side-bar></side-bar>

        <div class="wp-content">

            <div class="row">

                <div class="col-md-12 col-lg-12 col-sm-12 padding-left-0">

                    <div class="settings-header shadowed  main-heading bg-foo">
                        <div class="row">
                            <div class="col-md-12">
                                <!-- <div class="pull pull-left app-header width-40-pc">
                                    <h5>
                                        Roles:
                                    </h5>
                                </div> -->
                                <div class="pull pull-right app-header width-50-pc text-right padding-right-30">
                                    <a href="/system_users_summary" class="btn-link mg-right-10">Summary</a>
                                    <router-link to="/users/index/all" class="mg-right-50 btn-link">Go to Users</router-link>
                                    <div  class="btn-group float-right" role="group" aria-label="Button group with nested dropdown">
                                        <button :disabled="perm_form.role_id===''" @click="saveRole" type="button" class="btn combo-button primary"><i class="fa fa-save"></i> Save</button>
                                        <div class="btn-group" role="group">
                                            <button id="btnGroupDrop" type="button" class="btn combo-button primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="btnGroupDrop">
                                                <a class="dropdown-item" data-toggle="modal" data-target="#add_role_modal">+ New Role</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mg-top-35">

                        <div class="col-md-2 col-lg-2 col-sm-2 padding-right-0 bg-foo min-height-100-vh">
                            <side-bar-role v-if="page_loaded" :scrollable="false" :width="true" :transparent="true" :hr_role="hr_roles" v-on:selectedRole="selectedUserRole"></side-bar-role>
                        </div>

                        <div class="col-md-10 col-lg-10 col-sm-10 padding-right-0 padding-left-0 bg-foo min-height-100-vh">
                            
                            <div class="box box-primary bg-white border-top-0 border-bottom-0 no-shadowed">

                                <div class="width-100-pc padding-left-20 padding-right-20 padding-top-20 padding-bottom-20 mg-bottom-30">
                                    
                                    <div class="filter-block form-inline float-left">
                                        <!-- <h4>{{current_role_name}}</h4> -->
                                        <input type="text" placeholder="Search by name" class="form-control product-entry-input-field height-27">
                                    </div>

                                    <!-- <div  class="btn-group float-right" role="group" aria-label="Button group with nested dropdown">
                                        <button :disabled="perm_form.role_id===''" @click="saveRole" type="button" class="btn combo-button primary"><i class="fa fa-save"></i> Save</button>
                                        <div class="btn-group" role="group">
                                            <button id="btnGroupDrop" type="button" class="btn combo-button primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="btnGroupDrop">
                                                <a class="dropdown-item" data-toggle="modal" data-target="#add_role_modal">+ New Role</a>
                                            </div>
                                        </div>
                                    </div> -->

                                    <!-- <div class="filter-block form-inline float-right mg-right-10">
                                        <input type="text" placeholder="Search by name" class="form-control product-entry-input-field height-27">
                                    </div> -->
                                    <add-role v-if="page_loaded" :modal_title="'New User Role'" :initial_url="initialUrl" :modal_id="'add_role_modal'" :user_mode="'Create'" :practice_id="practice_id" :form_data="role_form" v-on:roleAdded="loadRoles"></add-role>
                                </div>

                                <div class="page-content bg-white min-height-100-vh padding-10">

                                    <div class="row">

                                        <div class="col-lg-11">

                                            <div class="accordion" id="accordionExample">

                                                <div v-for="(role_permissio, index) in system_permissions" :key="'role_permissio'+index" class="card">
                                                    <div class="card-header" :id="'headingOne'+index">
                                                        <h5 class="mb-0">
                                                            <label class="check-container small element-inlined fs-14 cl-888">
                                                                <input type="checkbox" @click="selectAll($event,role_permissio.data)" :value="'select_all_checkbox_'+index" :name="'select_all_checkbox_name_'+index">
                                                                <span class="checkmark"></span>
                                                            </label>
                                                            <a class="btn-link fs-13 txt-uppercase" data-toggle="collapse" :data-target="'#collapseOne'+index" aria-expanded="true" aria-controls="collapseOne">
                                                                {{index+1}}. {{role_permissio.category}}
                                                            </a>
                                                        </h5>
                                                    </div>
                                                    <div :id="'collapseOne'+index" class="collapse" :aria-labelledby="'headingOne'+index" data-parent="#accordionExample">
                                                        <div class="card-body padding-20">
                                                            <div class="row">
                                                                <section class="userTypeSection_3 col-md-12 padding-10">
                                                                    <div v-for="(sub_pammissio, sub_index) in role_permissio.data" :key="'sub_pammissio_'+sub_index" class="row">
                                                                        <div class="col-lg-12">
                                                                            <div class="panel-heading width-100-pc">
                                                                                <h3 class="panel-title">
                                                                                    {{sub_pammissio.sub_category}}
                                                                                </h3>
                                                                            </div>
                                                                            <div class="row padding-left-20 padding-right-20">
                                                                                <div class="col-lg-12 bottom-dotted right-left-bd mg-bottom-10">
                                                                                    <label v-for="(sub_sub_pammissio, sub_sub_index) in sub_pammissio.sub_category_data" :key="'sub_sub_pammissio'+sub_sub_index" class="check-container small element-inlined fs-14 cl-888 min-width-100 mg-right-10">{{sub_sub_pammissio.name}}
                                                                                        <input type="checkbox" :value="sub_sub_pammissio.id" v-model="perm_form.role_permissions">
                                                                                        <span class="checkmark"></span>
                                                                                    </label>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </section>
                                                            </div>
                                                            
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>

                                        </div>

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
    import SideBar from "../partials/sidebars/SideBar";
    import TopNavBar from "../partials/topbars/TopNavBar";
    import SideBarRole from "../partials/sidebars/SideBarRole";
    import AddRole from "../partials/modals/AddRole";
    import {get, post} from "../../../../helpers/api";
    import AppInfo from "../../../../helpers/config";
    import ProcessingOverlay from "../../../progress/ProcessingOverlay";
    import Auth from "../../../../store/auth";
    import DeleteStuffModal from '../../pharmacy/patials/DeleteStuffModal';
    import AddEmployeeModal from '../../pharmacy/hr_depart/partials/AddEmployeeModal';
    import ViewUserModal from '../../pharmacy/hr_depart/partials/ViewUserModal';
    import AssignPrivilegeModal from '../../pharmacy/hr_depart/partials/AssignPrivilegeModal';
    import AssignPlaceOfWork from '../../pharmacy/hr_depart/partials/AssignPlaceOfWork';
    import {createHtmlErrorString,removeElement,isInArray} from "../../../../helpers/functionmixin";
    import {PRACTICE_ROLES_API,PERMISSIONS_API} from '../../../../router/api_routes';
    export default {
        name: "RolesIndex",
        components: {TopNavBar, SideBar,SideBarRole,ProcessingOverlay,DeleteStuffModal,AddRole},
        data(){
            return {
                branch_id: '',
                msg: 'Loading. Please wait...',
                initialUrl: AppInfo.app_data.apis.practice_roles,
                practice_id: '',
                current_role_name: 'Available user roles',
                progress_overlay: 'hide',
                processing: false,
                page_loaded: false,
                hr_roles: [],
                current_account: {},
                system_permissions: [],
                role_form: {
                    name: '',
                    description: '',
                    practice_id: '',
                    status: '',
                },
                perm_form: {
                    role_id: '',
                    role_permissions: [],
                },
            }
        },
        methods: {

            selectedUserRole(selected_role){
                this.perm_form.role_permissions = [];
                this.current_role_name = selected_role.name;
                this.perm_form.role_id = selected_role.id;
                //console.info(selected_role.permissions);
                for( let m=0; m < selected_role.permissions.length; m++ ){
                    this.perm_form.role_permissions.push(selected_role.permissions[m].id);
                }
            },

            selectAll(event,select_role){
                //console.info(select_role);
                if(event.target.checked){
                    for( let m=0; m < select_role.length; m++ ){
                        for( let n=0; n < select_role[m].sub_category_data.length; n++ ){
                            if( !isInArray(select_role[m].sub_category_data[n].id, this.perm_form.role_permissions) ){
                                this.perm_form.role_permissions.push(select_role[m].sub_category_data[n].id);
                            }
                        }
                    }
                }else{
                    for( let m=0; m < select_role.length; m++ ){
                        for( let n=0; n < select_role[m].sub_category_data.length; n++ ){
                            removeElement(this.perm_form.role_permissions,select_role[m].sub_category_data[n].id);
                        }
                    }
                }
            },

            saveRole() {
                this.msg = 'Saving. Please wait...';
                this.progress_overlay = "show";
                post(PRACTICE_ROLES_API+'/'+this.perm_form.role_id,this.perm_form)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.loadRoles();
                    }
                }).catch((err) => {
                    this.progress_overlay = "hide";
                });
            },

            loadRoles() {
                this.progress_overlay = "show";
                get(PRACTICE_ROLES_API+'/practice/'+this.practice_id)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.hr_roles = res.data.results;
                        console.info(this.hr_roles);
                        //this.page_loaded = true;
                        //this.progress_overlay = "hide";
                        this.load_Permissions();
                    }
                }).catch((err) => {
                    this.progress_overlay = "hide";
                });
            },

            load_Permissions() {
                this.progress_overlay = "show";
                get(PERMISSIONS_API)
                    .then((res) => {
                        if(res.data.status_code === 200) {
                            this.system_permissions = res.data.results;
                            console.info(this.system_permissions)
                            this.page_loaded = true;
                            this.progress_overlay = "hide";
                        }
                    }).catch((err) => {
                    this.progress_overlay = "hide";
                });
            },

        },
        mounted() {
            this.current_account = Auth.getCurrentAccount();
            this.practice_id = Auth.getCurrentAccount('id');
            //this.branch_id = Auth.getCurrentAccount('id');
            this.loadRoles();
            //console.info(this.current_account);
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