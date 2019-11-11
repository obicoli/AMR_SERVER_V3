<template>

    <div>

        <processing-overlay :message="'Loading. Please wait...'" :status="progress_overlay"></processing-overlay>

        <top-nav-bar :inventory="true"></top-nav-bar>

        <side-bar></side-bar>

        <div class="wp-content">

            <div class="row">

                <div class="col-md-12 col-lg-12 col-sm-12 padding-left-0">

                    <div class="settings-header shadowed  main-heading bg-foo">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="pull pull-left width-40-pc">
                                    <h5 class="fs-17 fw-600">
                                        Statements
                                    </h5>
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

                                <report-filter :title="'Profit and Loss Report'"></report-filter>

                                <div class="page-content bg-white min-height-100-vh padding-10 mg-top-20">

                                    <div class="row">

                                        <div class="col-lg-8">

                                            <div class="padding-top-10 padding-bottom-10 padding-left-20 padding-right-20 reportArea">

                                                <div class="text-center">
                                                    <div class="companyNameRow">
                                                        <div class="companyName">
                                                            <span>Amref Enterprises | Amref Health Africa</span>
                                                        </div>
                                                    </div>
                                                    <div class="titleRow">
                                                        <div class="reportName">Profit & Loss</div>
                                                    </div>
                                                    <div class="dateRangeRow fs-14">1 January - 21 June, 2019</div>
                                                </div>

                                                <!-- ---------- -->
                                                <pl-view></pl-view>

                                                <div class="footer">
                                                    <div class="text-center">
                                                        <div class="footerOption"></div>
                                                        <div class="footerOption">Accrual basis Friday, 21 June 2019 05:15 PM GMT+03:00</div>
                                                        <!-- <div class="footerOption">Tuesday, 28 May 2019</div>
                                                        <div class="footerOption">12:44 AM GMT+03:00</div> -->
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
    import SideBar from "../../partials/sidebars/SideBar"
    import TopNavBar from "../../partials/topbars/TopNavBar"
    import SideBarAccounting from "../../partials/sidebars/SideBarAccounting"
    import ReportFilter from "../partials/ReportFilter";
    import PlView from "../partials/PlView";
    import {get, post} from "../../../../../helpers/api";
    import AppInfo from "../../../../../helpers/config";
    import ProcessingOverlay from "../../../../progress/ProcessingOverlay";
    import Auth from "../../../../../store/auth";
    import {createHtmlErrorString,removeElement} from "../../../../../helpers/functionmixin";
    export default {
        name: "RolesIndex",
        components: {TopNavBar, SideBar,SideBarAccounting,ProcessingOverlay,ReportFilter,PlView},
        data(){
            return {
                branch_id: '',
                initialUrl: '/api/practices/roles',
                practice_id: '',
                current_role_name: '',
                progress_overlay: 'hide',
                processing: false,
                page_loaded: false,
                hr_roles: [],
                system_permissions: [],
                role_form: {
                    name: '',
                    description: '',
                    branch_id: '',
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
                console.info(selected_role.permissions);
                for( let m=0; m < selected_role.permissions.length; m++ ){
                    this.perm_form.role_permissions.push(selected_role.permissions[m].id);
                }
            },

            selectAll(event,select_role){
                console.info(select_role);
                if(event.target.checked){
                    for( let m=0; m < select_role.length; m++ ){
                        for( let n=0; n < select_role[m].sub_category_data.length; n++ ){
                            this.perm_form.role_permissions.push(select_role[m].sub_category_data[n].id);
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
                this.progress_overlay = "show";
                post(AppInfo.app_data.server_domain+this.initialUrl+'/'+this.perm_form.role_id,this.perm_form)
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
                get(AppInfo.app_data.server_domain+'/api/practices/'+this.branch_id+'/'+'Roles')
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.hr_roles = res.data.results.resources;
                        //console.info(this.hr_roles);
                        //this.progress_overlay = "hide";
                        this.load_Permissions();
                    }
                }).catch((err) => {
                    this.progress_overlay = "hide";
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

            load_Permissions() {
                this.progress_overlay = "show";
                get(AppInfo.app_data.server_domain+'/api/permissions')
                    .then((res) => {
                        if(res.data.status_code === 200) {
                            this.system_permissions = res.data.results;
                            //console.info(this.system_permissions)
                            this.page_loaded = true;
                            this.progress_overlay = "hide";
                        }
                    }).catch((err) => {
                    this.progress_overlay = "hide";
                });
            },

        },
        mounted() {
            this.practice_id = Auth.getCurrentAccount('id');
            this.branch_id = Auth.getCurrentAccount('id');
            //this.loadRoles();
            // this.load_Permissions();
            // this.loadHrs();
        }
    }
</script>

<style scoped>

    tbody.collapse.in {
        display: table-row-group;
    }
    
    .report-filters-inputs{
        outline: none;
        height: 32px;
        border: 1px solid #BABEC5;
        padding: 0 8px;
        border-radius: 2px;
        transition-property: border;
        transition-duration: 0.35s;
        font-size: 13px;
        background-color: #FFFFFF;
        box-sizing: border-box;
        -webkit-appearance: none;
        width: 100%;
        vertical-align: middle;
    }

    .professionalreports {
        border-width: 0 0 1px;
        border-style: dotted;
        display: inline-block;
    }

    .professionalreports {
        font-size: 12px;
        font-weight: 600;
        margin-bottom: 5px;
    }

    .accordion {
        /* background-color: #eee; */
        background-color: transparent!important;
        color: #444;
        cursor: pointer;
        /* padding: 18px; */
        width: 100%;
        border: none;
        text-align: left;
        outline: none;
        font-size: 14px;
        font-weight: 600!important;
        transition: 0.4s;
    }

    .active, .accordion:hover {
        background-color: #ccc;
    }

    .accordion:after {
        content: '\002B';
        color: #777;
        font-weight: bold;
        float: right;
        margin-left: 5px;
    }

    .active:after {
        content: "\2212";
    }

    .panel {
        padding: 0 18px;
        background-color: white;
        /* max-height: 0; */
        overflow: hidden;
        transition: max-height 0.2s ease-out;
        margin-bottom: 0!important;
        -webkit-box-shadow: 0 0 0 rgba(0,0,0,0);
        box-shadow: 0 0 0 rgba(0,0,0,0);
    }

</style>