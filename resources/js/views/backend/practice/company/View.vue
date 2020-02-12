<template>
    <div>

        <top-nav-bar :inventory="true" :bg_f7="true"></top-nav-bar>

        <side-bar></side-bar>

        <div class="wp-content mg-top-50 content-calculated-height-wc">

            <div class="row">

                <div class="col-md-12 col-lg-12 col-sm-12 padding-left-0">

                    <div class="row">
                        <div class="col-md-12 col-lg-12 col-sm-12 padding-right-0 padding-left-0 bg-ced content-calculated-height-wc">

                            <div class="box box-primary bg-ced border-top-0 border-bottom-0 no-shadowed padding-right-20 content-calculated-height-110 top-20">

                                <div class="page-content bg-ced padding-0 mg-right-0 mg-left-0 min-height-100-vh">
                                    <div class="dgrid dgrid-grid ui-widget dgrid-03 universal-grid border-ccc" role="grid">
                                        <div class="row justify-content-center">
                                            <div class="col-md-10 col-lg-10 padding-right-0 border-bottom">
                                                <div class="width-100-pc float-left">
                                                    <a class="fw-600 cl-444 fs-20">
                                                        Company Settings
                                                    </a>
                                                </div>
                                                <div v-if="page_ready" class="width-100-pc float-left">
                                                    <div class="width-100-pc float-left">
                                                        <div class="width-100-pc float-left padding-15">
                                                            <div class="width-100-pc float-right mg-top-20">
                                                                <nav>
                                                                    <div class="nav nav-tabs nav-tabs-side" id="nav-tab" role="tablist">
                                                                        <a @click="setTab(0)" v-bind:class="{'nav-item nav-link nav-link-overview-1':true,'active':curr_tab===0}" :id="'nav-transactions-tab-'+'0'" data-toggle="tab" :href="'#nav-transactions-'+'0'" role="tab" :aria-controls="'nav-transactions-'+'0'" aria-selected="true" :key="'transactions_tab'+'0'">Company Details</a>
                                                                        <a @click="setTab(1)" v-bind:class="{'nav-item nav-link nav-link-overview-1':true,'active':curr_tab===1}" :id="'nav-transactions-tab-'+'1'" data-toggle="tab" :href="'#nav-transactions-'+'1'" role="tab" :aria-controls="'nav-transactions-'+'1'" aria-selected="true" :key="'transactions_tab'+'1'">General Settings</a>
                                                                        <a @click="setTab(2)" v-bind:class="{'nav-item nav-link nav-link-overview-1':true,'active':curr_tab===2}" :id="'nav-transactions-tab-'+'2'" data-toggle="tab" :href="'#nav-transactions-'+'2'" role="tab" :aria-controls="'nav-transactions-'+'2'" aria-selected="true" :key="'transactions_tab'+'2'">VAT Settings</a>
                                                                        <a @click="setTab(3)" v-bind:class="{'nav-item nav-link nav-link-overview-1':true,'active':curr_tab===3}" :id="'nav-transactions-tab-'+'3'" data-toggle="tab" :href="'#nav-transactions-'+'3'" role="tab" :aria-controls="'nav-transactions-'+'3'" aria-selected="true" :key="'transactions_tab'+'3'">Documents and Statements</a>
                                                                        <a @click="setTab(4)" v-bind:class="{'nav-item nav-link nav-link-overview-1':true,'active':curr_tab===4}" :id="'nav-transactions-tab-'+'4'" data-toggle="tab" :href="'#nav-transactions-'+'4'" role="tab" :aria-controls="'nav-transactions-'+'4'" aria-selected="true" :key="'transactions_tab'+'4'">Branding</a>
                                                                        <a @click="setTab(5)" v-bind:class="{'nav-item nav-link nav-link-overview-1':true,'active':curr_tab===5}" :id="'nav-transactions-tab-'+'5'" data-toggle="tab" :href="'#nav-transactions-'+'5'" role="tab" :aria-controls="'nav-transactions-'+'5'" aria-selected="true" :key="'transactions_tab'+'5'">User Defined Field</a>
                                                                        <a @click="setTab(6)" v-bind:class="{'nav-item nav-link nav-link-overview-1':true,'active':curr_tab===6}" :id="'nav-transactions-tab-'+'6'" data-toggle="tab" :href="'#nav-transactions-'+'6'" role="tab" :aria-controls="'nav-transactions-'+'6'" aria-selected="true" :key="'transactions_tab'+'6'">Email Signatures</a>
                                                                        <a @click="setTab(7)" v-bind:class="{'nav-item nav-link nav-link-overview-1':true,'active':curr_tab===7}" :id="'nav-transactions-tab-'+'7'" data-toggle="tab" :href="'#nav-transactions-'+'7'" role="tab" :aria-controls="'nav-transactions-'+'7'" aria-selected="true" :key="'transactions_tab'+'7'">Multi-Currency</a>
                                                                    </div>
                                                                </nav>
                                                                <div class="tab-content tab-content-role" id="nav-tabContent">
                                                                    <div v-bind:class="{'tab-pane fade':true,'show active':curr_tab===0}" :id="'nav-transactions-'+'0'" role="tabpanel" :aria-labelledby="'nav-transactions-tab-'+'0'" :key="'tab_index_'+'0'">
                                                                        <div class="width-100-pc float-left fs-12 mg-top-20 padding-20">
                                                                            <div class="row">
                                                                                <div class="col-2 padding-right-0">
                                                                                    <div class="nav flex-column nav-pills" id="v-pills-tab-0" role="tablist" aria-orientation="vertical">
                                                                                        <a @click="setSubTab(0)" class="nav-link nav-link-side-nav active" id="v-pills-tabbed0-tab-0" data-toggle="pill" href="#v-pills-tabbed0-0" role="tab" aria-controls="v-pills-tabbed0-0" aria-selected="true">Company Details</a>
                                                                                        <a @click="setSubTab(1)" class="nav-link nav-link-side-nav" id="v-pills-tabbed1-tab-0" data-toggle="pill" href="#v-pills-tabbed1-0" role="tab" aria-controls="v-pills-tabbed1-0" aria-selected="false">Additional Info</a>
                                                                                        <a @click="setSubTab(2)" class="nav-link nav-link-side-nav" id="v-pills-tabbed2-tab-0" data-toggle="pill" href="#v-pills-tabbed2-0" role="tab" aria-controls="v-pills-tabbed2-0" aria-selected="false">Customer Zone</a>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-10 padding-left-0">
                                                                                    <div class="tab-content" id="v-pills-tabContent">
                                                                                        <div class="tab-pane fade show active" id="v-pills-tabbed0-0" role="tabpanel" aria-labelledby="v-pills-tabbed0-tab-0">
                                                                                            <div class="width-90-pc float-left">
                                                                                                <company-detail-model></company-detail-model>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="tab-pane fade" id="v-pills-tabbed1-0" role="tabpanel" aria-labelledby="v-pills-tabbed1-tab-0">
                                                                                            <div class="width-90-pc float-left">
                                                                                                <addition-info></addition-info>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="tab-pane fade" id="v-pills-tabbed2-0" role="tabpanel" aria-labelledby="v-pills-tabbed2-tab-0">
                                                                                            <div class="width-90-pc float-left">
                                                                                                <customer-zone></customer-zone>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div v-bind:class="{'tab-pane fade':true,'show active':curr_tab===1}" :id="'nav-transactions-'+'1'" role="tabpanel" :aria-labelledby="'nav-transactions-tab-'+'1'" :key="'tab_index_'+'1'">
                                                                        <div class="width-100-pc float-left fs-12 mg-top-20 padding-20">
                                                                            <div class="row">
                                                                                <div class="col-3 padding-right-0">
                                                                                    <div class="nav flex-column nav-pills" id="v-pills-tab-1" role="tablist" aria-orientation="vertical">
                                                                                        <a class="nav-link nav-link-side-nav active" id="v-pills-tabbed0-tab-1" data-toggle="pill" href="#v-pills-tabbed0-1" role="tab" aria-controls="v-pills-tabbed0-1" aria-selected="true">Financial Years</a>
                                                                                        <a class="nav-link nav-link-side-nav" id="v-pills-tabbed1-tab-1" data-toggle="pill" href="#v-pills-tabbed1-1" role="tab" aria-controls="v-pills-tabbed1-1" aria-selected="false">Rounding</a>
                                                                                        <a class="nav-link nav-link-side-nav" id="v-pills-tabbed2-tab-1" data-toggle="pill" href="#v-pills-tabbed2-1" role="tab" aria-controls="v-pills-tabbed2-1" aria-selected="false">Regional Settings</a>
                                                                                        <a class="nav-link nav-link-side-nav" id="v-pills-tabbed3-tab-1" data-toggle="pill" href="#v-pills-tabbed3-1" role="tab" aria-controls="v-pills-tabbed3-1" aria-selected="false">Customer and Supplier Settings</a>
                                                                                        <a class="nav-link nav-link-side-nav" id="v-pills-tabbed4-tab-1" data-toggle="pill" href="#v-pills-tabbed4-1" role="tab" aria-controls="v-pills-tabbed4-1" aria-selected="false">Item Settings</a>
                                                                                        <a class="nav-link nav-link-side-nav" id="v-pills-tabbed5-tab-1" data-toggle="pill" href="#v-pills-tabbed5-1" role="tab" aria-controls="v-pills-tabbed5-1" aria-selected="false">Outstanding Balances</a>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-9 padding-left-0">
                                                                                    <div class="tab-content" id="v-pills-tabContent-1">
                                                                                        <div class="tab-pane fade show active" id="v-pills-tabbed0-1" role="tabpanel" aria-labelledby="v-pills-tabbed0-tab-1">
                                                                                            <div class="width-90-pc float-left">
                                                                                                <financial-model></financial-model>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="tab-pane fade" id="v-pills-tabbed1-1" role="tabpanel" aria-labelledby="v-pills-tabbed1-tab-1">
                                                                                            <div class="width-90-pc float-left">
                                                                                                <rounding-model></rounding-model>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="tab-pane fade" id="v-pills-tabbed2-1" role="tabpanel" aria-labelledby="v-pills-tabbed2-tab-1">
                                                                                            <div class="width-90-pc float-left">
                                                                                                <regional-settings></regional-settings>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="tab-pane fade" id="v-pills-tabbed3-1" role="tabpanel" aria-labelledby="v-pills-tabbed3-tab-1">
                                                                                            <div class="width-100-pc float-left">
                                                                                                <customer-supplier-settings></customer-supplier-settings>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="tab-pane fade" id="v-pills-tabbed4-1" role="tabpanel" aria-labelledby="v-pills-tabbed4-tab-1">
                                                                                            <div class="width-100-pc float-left">
                                                                                                <item-model></item-model>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="tab-pane fade" id="v-pills-tabbed5-1" role="tabpanel" aria-labelledby="v-pills-tabbed5-tab-1">
                                                                                            <div class="width-100-pc float-left">
                                                                                                <outstanding-balance></outstanding-balance>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div v-bind:class="{'tab-pane fade':true,'show active':curr_tab===2}" :id="'nav-transactions-'+'2'" role="tabpanel" :aria-labelledby="'nav-transactions-tab-'+'2'" :key="'tab_index_'+'2'">
                                                                        <div class="width-100-pc float-left fs-12 mg-top-20 padding-20">
                                                                            <div class="row">
                                                                                <div class="col-2 padding-right-0">
                                                                                    <div class="nav flex-column nav-pills" id="v-pills-tab-2" role="tablist" aria-orientation="vertical">
                                                                                        <a class="nav-link nav-link-side-nav active" id="v-pills-tabbed0-tab-2" data-toggle="pill" href="#v-pills-tabbed0-2" role="tab" aria-controls="v-pills-tabbed0-2" aria-selected="false">VAT Settings</a>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-10 padding-left-0">
                                                                                    <div class="tab-content" id="v-pills-tabContent-2">
                                                                                        <div class="tab-pane fade show active" id="v-pills-tabbed0-2" role="tabpanel" aria-labelledby="v-pills-tabbed0-tab-2">
                                                                                            <div class="width-90-pc float-left">
                                                                                                <vat-model></vat-model>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div v-bind:class="{'tab-pane fade':true,'show active':curr_tab===3}" :id="'nav-transactions-'+'3'" role="tabpanel" :aria-labelledby="'nav-transactions-tab-'+'3'" :key="'tab_index_'+'3'">

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div v-else class="width-100-pc float-left mg-top-30 text-center">
                                                    <img class="loader" src="/assets/icons/dashboard/loader.gif">
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
            <div class="row">
                <div class="col-md-12 col-lg-12 col-sm-12 padding-left-0">
                    <copy-right></copy-right>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import SideBar from "../partials/sidebars/SideBar";
    import TopNavBar from "../partials/topbars/TopNavBar";
    import PaginateTemplate from '../partials/pagination/PaginateTemplate';
    import CopyRight from "../partials/CopyRight";
    import {INVENTORY_WEB_ROUTES} from "../../../../router/web_routes";
    import {get, post} from "../../../../helpers/api";
    import {CHANGE_PASSWORD, PRACTICE_USERS_API} from "../../../../router/api_routes";
    import Auth from "../../../../store/auth";
    import {createHtmlErrorString, reset_forms} from "../../../../helpers/functionmixin";
    import {ADMIN_PERM} from "../../../../helpers/permissions";
    import CompanyDetailModel from './partials/CompanyDetailModel';
    import AdditionInfo from './partials/AdditionInfo';
    import CustomerZone from './partials/CustomerZone';
    import CustomerSupplierSettings from './partials/CustomerSupplierSettings';
    import OutstandingBalance from './partials/OutstandingBalance';
    import ItemModel from './partials/ItemModel';
    import RegionalSettings from "./partials/RegionalSettings";
    import RoundingModel from "./partials/RoundingModel";
    import FinancialModel from "./partials/FinancialModel";
    import VatModel from './partials/VatModel';

    export default {
        name: "CompanyView",
        components: {
            RegionalSettings,
            TopNavBar,PaginateTemplate,SideBar,CopyRight,CompanyDetailModel,AdditionInfo,OutstandingBalance,
            CustomerZone,CustomerSupplierSettings,ItemModel,RoundingModel,FinancialModel,VatModel},
        data(){
            return {
                curr_tab: 0,
                sub_curr_tab: 0,
                is_initializing: false,
                page_ready: false,
                company_user: null,
                INVENTORY_WEB_ROUTES: INVENTORY_WEB_ROUTES,
                ADMIN_PERM: ADMIN_PERM,
                processing: false,
                // form: {
                //     old_password: null,
                //     password: null,
                //     password_confirmation: null,
                // },
            }
        },
        methods: {
            setTab(curr_ta){
                this.sub_curr_tab = 0;
                this.curr_tab = curr_ta;
            },
            setSubTab(sub_curr_ta){
                this.curr_tab = curr_ta;
            },
            checkPerms(perm_){
                return Auth.hasPermission(perm_)
            },
            changePassword(){
                this.processing = true;
                post(CHANGE_PASSWORD,this.form)
                    .then((res) => {
                        if(res.data.status_code === 200) {
                            this.$awn.success(res.data.description);
                            this.form = reset_forms(this.form);
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

            loadUser(){
                get(PRACTICE_USERS_API+'/'+Auth.getCurrentAccount('staff_id'))
                    .then((res) => {
                        if(res.data.status_code === 200) {
                            this.company_user = res.data.results;
                            this.page_ready = true;
                        }
                    }).catch((err) => {
                });
            },

            saveUser(){
                this.processing = true;
                post(PRACTICE_USERS_API+'/'+this.company_user.id,this.company_user)
                    .then((res) => {
                        if(res.data.status_code === 200) {
                            this.$awn.success(res.data.description);
                            this.loadUser();
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
        },
        mounted() {
            this.loadUser();
        }
    }
</script>

<style scoped>

</style>