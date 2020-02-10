<template>

    <div>

        <processing-overlay :message="msg" :status="progress_overlay"></processing-overlay>

        <top-nav-bar :inventory="true" :bg_f7="true"></top-nav-bar>

        <side-bar></side-bar>

        <div class="wp-content mg-top-50 content-calculated-height-wc">

            <div class="row">

                <div class="col-md-12 col-lg-12 col-sm-12 padding-left-0">

                    <div class="row">
                        <div class="col-md-2 col-lg-2 col-sm-2 padding-right-0 bg-foo content-calculated-height-wc">
                            <report-config v-if="page_ready" :reports="true" :scrollable="true" :width="true" :transparent="true" :active_num="'config'" :title="'Report & Config'"></report-config>
                        </div>
                        <div class="col-md-10 col-lg-10 col-sm-10 padding-right-0 padding-left-0 bg-white content-calculated-height-wc">

                            <div class="settings-header shadowed main-heading bg-white min-height-68 bottom-border top-border">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="btn-group" role="group">
                                            <a class="dropdown-toggle fs-14 pointer-cursor fw-600 txt-uppercase">
                                                Configurations
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="box box-primary bg-white border-top-0 border-bottom-0 no-shadowed padding-right-20 content-calculated-height-110 top-68">
                                
                                <div class="page-content bg-white padding-0 mg-right-0 mg-left-0 scrollable-content">
                                    <div class="dgrid dgrid-grid ui-widget dgrid-03 mg-bottom-30 universal-grid border-ccc" role="grid">
                                        <div class="row">
                                            <div class="col-md-12 col-lg-12 col-sm-12 col-xl-12 bg-white border-bottom mg-top-30">
                                                <div class="width-100-pc mg-bottom-50 padding-left-20 padding-right-20">
                                                    <nav>
                                                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                                            <a class="nav-item nav-link nav-link-app active" id="nav-company-tab" data-toggle="tab" href="#nav-company" role="tab" aria-controls="nav-company" aria-selected="true">Company</a>
                                                            <a class="nav-item nav-link nav-link-app" id="nav-othercompanies-tab" data-toggle="tab" href="#nav-othercompanies" role="tab" aria-controls="nav-othercompanies" aria-selected="false">Other Company</a>
                                                            <a class="nav-item nav-link nav-link-app" id="nav-finance-tab" data-toggle="tab" href="#nav-finance" role="tab" aria-controls="nav-finance" aria-selected="false">Finance</a>
                                                            <a class="nav-item nav-link nav-link-app" id="nav-taxes-tab" data-toggle="tab" href="#nav-taxes" role="tab" aria-controls="nav-taxes" aria-selected="false">Taxes</a>
                                                            <a class="nav-item nav-link nav-link-app" id="nav-roles-tab" data-toggle="tab" href="#nav-roles" role="tab" aria-controls="nav-roles" aria-selected="false">Roles-Permissions</a>
                                                        </div>
                                                    </nav>
                                                    <div class="tab-content tab-content-app" id="nav-tabContent">
                                                        <div class="tab-pane fade show active" id="nav-company" role="tabpanel" aria-labelledby="nav-company-tab">
                                                            <company-form v-if="page_ready" v-on:companyChanged="loadFacility(false)" :company="company" :company_api="company_api"></company-form>
                                                            <other-settings v-if="page_ready" :company="company" :company_api="company_api+'/'+company.id" ></other-settings>
                                                        </div>
                                                        <div class="tab-pane fade" id="nav-othercompanies" role="tabpanel" aria-labelledby="nav-othercompanies-tab">
                                                            <other-company :companies="companies" v-on:newCompany="loadCompanies(false)" v-on:companyChanged="loadFacility(false)" v-on:companyDeleted="loadCompanies(false)" :company_api="company_api"></other-company>
                                                        </div>
                                                        <div class="tab-pane fade" id="nav-finance" role="tabpanel" aria-labelledby="nav-finance-tab">
                                                            <finance-form :finances="finances" :finance_api="finance_api+'/'+finances.id" v-on:financeChanged="loadFinance(false)"></finance-form>
                                                        </div>
                                                        <div class="tab-pane fade" id="nav-taxes" role="tabpanel" aria-labelledby="nav-taxes-tab">
                                                            <taxation :taxes="taxes" :tax_api="tax_api" v-on:taxChanged="loadTax(false)"></taxation>
                                                        </div>
                                                        <div class="tab-pane fade" id="nav-roles" role="tabpanel" aria-labelledby="nav-roles-tab">
                                                            <role-permission v-if="page_ready" :user_api="user_api" v-on:rolesChanged="loadRoles(false)" v-on:usersChanged="loadUsers(false)" :users="users" :companies="companies" :departments="departments" :warehouses="warehouses" :subwarehouses="subwarehouses" :role_api="role_api" :permissions="permissions" :company_roles="company_roles"></role-permission>
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
    import SideBar from "../../partials/sidebars/SideBar";
    import TopNavBar from "../../partials/topbars/TopNavBar";
    import ReportConfig from "../../partials/sidebars/supplychain/ReportConfig";
    import CompanyForm from "./partials/CompanyForm";
    import OtherSettings from "./partials/OtherSettings";
    import OtherCompany from "./partials/OtherCompany";
    import FinanceForm from "./partials/FinanceForm";
    import Taxation from "./partials/Taxation"
    import RolePermission from "./partials/RolePermission"
    import ProcessingOverlay from "../../../../progress/ProcessingOverlay";
    import {get} from "../../../../../helpers/api";
    
    import {removeElement,paginator,formatMoney} from "../../../../../helpers/functionmixin";
    import {PROCESS_STATUS} from "../../../../../helpers/process_status";
    import {PRACTICE_ROLES_API,PERMISSIONS_API,PRACTICES_API,PRACTICE_USERS_API,PRODUCT_TAX_URL,PRACTICE_FINANCE_SETTING_API} from '../../../../../router/api_routes';
    export default {
        name: "Index",
        components: {TopNavBar,SideBar,CompanyForm,OtherSettings,OtherCompany,
        ProcessingOverlay,ReportConfig,FinanceForm,Taxation,RolePermission},
        data(){
            return {
                company_roles: [],
                permissions: [],
                companies: [],
                users: [],
                departments: [],
                warehouses: [],
                subwarehouses: [],
                taxes: [],
                finances: {},
                company: {},
                msg: 'Loading. Please wait...',
                progress_overlay: 'hide',
                page_ready: false,
                pagination: paginator(),
                role_api: PRACTICE_ROLES_API,
                user_api: PRACTICE_USERS_API,
                tax_api: PRODUCT_TAX_URL,
                finance_api: PRACTICE_FINANCE_SETTING_API,
                company_api: PRACTICES_API
            }
        },
        methods: {

            loadRoles(progress_show=true) {
                if(progress_show){this.progress_overlay = "show";}
                get(PRACTICE_ROLES_API)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.company_roles = res.data.results;
                        if(progress_show){
                            //Here you call other methods
                            this.loadPermissions(true);
                        }else{
                            //Here you end
                            this.page_ready = true;
                            this.progress_overlay = "hide";
                        }
                    }
                }).catch((err) => {
                    this.progress_overlay = "hide";
                });
            },

            loadPermissions(progress_show=true) {
                if(progress_show){this.progress_overlay = "show";}
                get(PERMISSIONS_API)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.permissions = res.data.results;
                        if(progress_show){
                            // this.page_ready = true;
                            // this.progress_overlay = "hide";
                            this.loadCompanies();
                        }else{
                            //Here you end
                            this.page_ready = true;
                            this.progress_overlay = "hide";
                        }
                    }
                }).catch((err) => {
                    this.progress_overlay = "hide";
                });
            },

            loadUsers(progress_show=true) {
                if(progress_show){this.progress_overlay = "show";}
                get(PRACTICE_USERS_API)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.users = res.data.results;
                        //console.info(this.users);
                        if(progress_show){
                            // this.page_ready = true;
                            // this.progress_overlay = "hide";
                            //this.loadCompanies();
                            // this.page_ready = true;
                            // this.progress_overlay = "hide";
                            this.loadTax();
                        }else{
                            //Here you end
                            this.page_ready = true;
                            this.progress_overlay = "hide";
                        }
                    }
                }).catch((err) => {
                    this.progress_overlay = "hide";
                });
            },

            loadTax(progress_show=true) {
                if(progress_show){this.progress_overlay = "show";}
                get(PRODUCT_TAX_URL)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.taxes = res.data.results;
                        //console.info(this.taxes);
                        if(progress_show){
                            // this.page_ready = true;
                            // this.progress_overlay = "hide";
                            this.loadFinance();
                        }else{
                            this.page_ready = true;
                            this.progress_overlay = "hide";
                        }
                    }
                }).catch((err) => {
                    this.progress_overlay = "hide";
                });
            },

            loadFinance(progress_show=true) {
                if(progress_show){this.progress_overlay = "show";}
                get(PRACTICE_FINANCE_SETTING_API)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.finances = res.data.results;
                        //console.info(this.finances);
                        if(progress_show){
                            // this.page_ready = true;
                            // this.progress_overlay = "hide";
                            this.loadFacility();
                        }else{
                            this.page_ready = true;
                            this.progress_overlay = "hide";
                        }
                    }
                }).catch((err) => {
                    this.progress_overlay = "hide";
                });
            },

            loadFacility(progress_show=true) {
                if(progress_show){this.progress_overlay = "show";}
                let uuid = null;
                get(PRACTICES_API+'/'+uuid)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.company = res.data.results;
                        console.info(this.company);
                        if(progress_show){
                            this.page_ready = true;
                            this.progress_overlay = "hide";
                        }else{
                            this.page_ready = true;
                            this.progress_overlay = "hide";
                        }
                    }
                }).catch((err) => {
                    this.progress_overlay = "hide";
                });
            },

            loadCompanies(progress_show=true) {
                if(progress_show){this.progress_overlay = "show";}
                get(PRACTICES_API)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.companies = res.data.results;
                        //console.info(this.companies);
                        if(progress_show){
                            this.loadUsers();
                        }else{
                            //Here you end
                            this.page_ready = true;
                            this.progress_overlay = "hide";
                        }
                    }
                }).catch((err) => {
                    this.progress_overlay = "hide";
                });
            },

        },
        mounted() {
            this.loadRoles();
        }
    }
</script>

<style lang="scss">
    th {
        position: sticky;
        top: 0px;
    }
</style>