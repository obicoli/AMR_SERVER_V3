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
                                                                        <a @click="setTab(5)" v-bind:class="{'nav-item nav-link nav-link-overview-1':true,'active':curr_tab===5}" :id="'nav-transactions-tab-'+'5'" data-toggle="tab" :href="'#nav-transactions-'+'5'" role="tab" :aria-controls="'nav-transactions-'+'5'" aria-selected="true" :key="'transactions_tab'+'5'">Email Signatures</a>
                                                                    </div>
                                                                </nav>
                                                                <div class="tab-content tab-content-role" id="nav-tabContent">
                                                                    <div v-bind:class="{'tab-pane fade':true,'show active':curr_tab===0}" :id="'nav-transactions-'+'0'" role="tabpanel" :aria-labelledby="'nav-transactions-tab-'+'0'" :key="'tab_index_'+'0'">
                                                                        <div class="width-100-pc float-left fs-12 mg-top-20 padding-20">
                                                                            <div class="row">
                                                                                <div class="col-2 padding-right-0">
                                                                                    <div class="nav flex-column nav-pills" id="v-pills-tab-0" role="tablist" aria-orientation="vertical">
                                                                                        <a class="nav-link nav-link-side-nav active" id="v-pills-tabbed0-tab-0" data-toggle="pill" href="#v-pills-tabbed0-0" role="tab" aria-controls="v-pills-tabbed0-0" aria-selected="true">Company Details</a>
                                                                                        <a class="nav-link nav-link-side-nav" id="v-pills-tabbed1-tab-0" data-toggle="pill" href="#v-pills-tabbed1-0" role="tab" aria-controls="v-pills-tabbed1-0" aria-selected="false">Additional Info</a>
                                                                                        <a class="nav-link nav-link-side-nav" id="v-pills-tabbed2-tab-0" data-toggle="pill" href="#v-pills-tabbed2-0" role="tab" aria-controls="v-pills-tabbed2-0" aria-selected="false">Customer Zone</a>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-10 padding-left-0">
                                                                                    <div class="tab-content" id="v-pills-tabContent">
                                                                                        <div class="tab-pane fade show active" id="v-pills-tabbed0-0" role="tabpanel" aria-labelledby="v-pills-tabbed0-tab-0">
                                                                                            <div class="width-90-pc float-left">
                                                                                                <company-detail-model :company="company" :api="PRACTICES_API+'/'+company.id+'?section=Company Details'" :countries="countries" @company-detail-event="loadCompany()"></company-detail-model>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="tab-pane fade" id="v-pills-tabbed1-0" role="tabpanel" aria-labelledby="v-pills-tabbed1-tab-0">
                                                                                            <div class="width-90-pc float-left">
                                                                                                <addition-info :statutory="company.statutory" :api="PRACTICES_API+'/'+company.id+'?section=Statutory Information'" :countries="countries"></addition-info>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="tab-pane fade" id="v-pills-tabbed2-0" role="tabpanel" aria-labelledby="v-pills-tabbed2-tab-0">
                                                                                            <div class="width-90-pc float-left">
                                                                                                <customer-zone :company="company.customer_zone" :api="PRACTICES_API+'/'+company.id+'?section=Customer Zone Settings'" @addition-info-event="loadCompany()"></customer-zone>
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
                                                                                                <financial-model :api="PRACTICES_API+'/'+company.id+'?section=Financial Years'" :financial_years="company.financial_years" @financial-year-event="loadCompany()"></financial-model>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="tab-pane fade" id="v-pills-tabbed1-1" role="tabpanel" aria-labelledby="v-pills-tabbed1-tab-1">
                                                                                            <div class="width-90-pc float-left">
                                                                                                <rounding-model :api="PRACTICES_API+'/'+company.id+'?section=Rounding'" :general_settings="company.general_settings" @rounding-event="loadCompany()"></rounding-model>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="tab-pane fade" id="v-pills-tabbed2-1" role="tabpanel" aria-labelledby="v-pills-tabbed2-tab-1">
                                                                                            <div class="width-90-pc float-left">
                                                                                                <regional-settings :api="PRACTICES_API+'/'+company.id+'?section=Regional Settings'" :general_settings="company.general_settings" @regional-settings-event="loadCompany()"></regional-settings>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="tab-pane fade" id="v-pills-tabbed3-1" role="tabpanel" aria-labelledby="v-pills-tabbed3-tab-1">
                                                                                            <div class="width-100-pc float-left">
                                                                                                <customer-supplier-settings :api="PRACTICES_API+'/'+company.id+'?section=Customer and Supplier Settings'" :customer_supplier_setting="company.customer_supplier_setting" @customer-supplier-event="loadCompany()"></customer-supplier-settings>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="tab-pane fade" id="v-pills-tabbed4-1" role="tabpanel" aria-labelledby="v-pills-tabbed4-tab-1">
                                                                                            <div class="width-100-pc float-left">
                                                                                                <item-model :api="PRACTICES_API+'/'+company.id+'?section=Item Settings'" :inventory_settings="company.inventory_settings" @inventory-settings-event="loadCompany()"></item-model>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="tab-pane fade" id="v-pills-tabbed5-1" role="tabpanel" aria-labelledby="v-pills-tabbed5-tab-1">
                                                                                            <div class="width-100-pc float-left">
                                                                                                <outstanding-balance :api="PRACTICES_API+'/'+company.id+'?section=Outstanding Balances'" :general_settings="company.general_settings" @outstanding-balance-event="loadCompany()"></outstanding-balance>
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
                                                                                                <vat-model :api="PRACTICES_API+'/'+company.id+'?section=VAT Settings'" :vat="company.vat" @vat-settings-event="loadCompany()"></vat-model>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div v-bind:class="{'tab-pane fade':true,'show active':curr_tab===3}" :id="'nav-transactions-'+'3'" role="tabpanel" :aria-labelledby="'nav-transactions-tab-'+'3'" :key="'tab_index_'+'3'">
                                                                        <div class="width-100-pc float-left fs-12 mg-top-20 padding-20">
                                                                            <div class="row">
                                                                                <div class="col-2 padding-right-0">
                                                                                    <div class="nav flex-column nav-pills" id="v-pills-tab-3" role="tablist" aria-orientation="vertical">
                                                                                        <a class="nav-link nav-link-side-nav active" id="v-pills-tabbed0-tab-3" data-toggle="pill" href="#v-pills-tabbed0-3" role="tab" aria-controls="v-pills-tabbed0-3" aria-selected="false">Document Prefix</a>
                                                                                        <a class="nav-link nav-link-side-nav" id="v-pills-tabbed1-tab-3" data-toggle="pill" href="#v-pills-tabbed1-3" role="tab" aria-controls="v-pills-tabbed1-3" aria-selected="false">Document Title</a>
                                                                                        <a class="nav-link nav-link-side-nav" id="v-pills-tabbed2-tab-3" data-toggle="pill" href="#v-pills-tabbed2-3" role="tab" aria-controls="v-pills-tabbed2-3" aria-selected="false">Document Message</a>
                                                                                        <a class="nav-link nav-link-side-nav" id="v-pills-tabbed3-tab-3" data-toggle="pill" href="#v-pills-tabbed3-3" role="tab" aria-controls="v-pills-tabbed3-3" aria-selected="false">Statement Message</a>
                                                                                        <a class="nav-link nav-link-side-nav" id="v-pills-tabbed4-tab-3" data-toggle="pill" href="#v-pills-tabbed4-3" role="tab" aria-controls="v-pills-tabbed4-3" aria-selected="false">Email Signatures</a>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-10 padding-left-0">
                                                                                    <div class="tab-content" id="v-pills-tabContent-3">
                                                                                        <div class="tab-pane fade show active" id="v-pills-tabbed0-3" role="tabpanel" aria-labelledby="v-pills-tabbed0-tab-3">
                                                                                            <div class="width-90-pc float-left">
                                                                                                <doc-num-model :api="PRACTICES_API+'/'+company.id+'?section=VAT Settings'" :vat="company.transaction_documents" @transaction-document-event="loadCompany()"></doc-num-model>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="tab-pane fade" id="v-pills-tabbed1-3" role="tabpanel" aria-labelledby="v-pills-tabbed1-tab-3">
                                                                                            <div class="width-90-pc float-left">
                                                                                                <doc-title-model :api="PRACTICES_API+'/'+company.id+'?section=VAT Settings'" :vat="company.transaction_documents" @transaction-document-event="loadCompany()"></doc-title-model>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="tab-pane fade" id="v-pills-tabbed2-3" role="tabpanel" aria-labelledby="v-pills-tabbed2-tab-3">
                                                                                            <div class="width-90-pc float-left">
                                                                                                <doc-message-model :api="PRACTICES_API+'/'+company.id+'?section=VAT Settings'" :vat="company.transaction_documents" @transaction-document-event="loadCompany()"></doc-message-model>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="tab-pane fade" id="v-pills-tabbed3-3" role="tabpanel" aria-labelledby="v-pills-tabbed3-tab-3">
                                                                                            <div class="width-90-pc float-left">
                                                                                                <statement-message-model :api="PRACTICES_API+'/'+company.id+'?section=VAT Settings'" :vat="company.transaction_documents" @transaction-document-event="loadCompany()"></statement-message-model>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="tab-pane fade" id="v-pills-tabbed4-3" role="tabpanel" aria-labelledby="v-pills-tabbed4-tab-3">
                                                                                            <div class="width-90-pc float-left">
                                                                                                <statement-message-model :api="PRACTICES_API+'/'+company.id+'?section=VAT Settings'" :vat="company.transaction_documents" @transaction-document-event="loadCompany()"></statement-message-model>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div v-bind:class="{'tab-pane fade':true,'show active':curr_tab===4}" :id="'nav-transactions-'+'4'" role="tabpanel" :aria-labelledby="'nav-transactions-tab-'+'4'" :key="'tab_index_'+'4'">
                                                                        <div class="width-100-pc float-left fs-12 mg-top-20 padding-20">
                                                                            <div class="row">
                                                                                <div class="col-2 padding-right-0">
                                                                                    <div class="nav flex-column nav-pills" id="v-pills-tab-4" role="tablist" aria-orientation="vertical">
                                                                                        <a class="nav-link nav-link-side-nav active" id="v-pills-tabbed0-tab-4" data-toggle="pill" href="#v-pills-tabbed0-4" role="tab" aria-controls="v-pills-tabbed0-4" aria-selected="false">Branding</a>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-10 padding-left-0">
                                                                                    <div class="tab-content" id="v-pills-tabContent-4">
                                                                                        <div class="tab-pane fade show active" id="v-pills-tabbed0-4" role="tabpanel" aria-labelledby="v-pills-tabbed0-tab-4">
                                                                                            <div class="width-90-pc float-left">
                                                                                                <branding-model></branding-model>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div v-bind:class="{'tab-pane fade':true,'show active':curr_tab===5}" :id="'nav-transactions-'+'5'" role="tabpanel" :aria-labelledby="'nav-transactions-tab-'+'5'" :key="'tab_index_'+'5'">
                                                                        <div class="width-100-pc float-left fs-12 mg-top-20 padding-20">
                                                                            <div class="row">
                                                                                <div class="col-2 padding-right-0">
                                                                                    <div class="nav flex-column nav-pills" id="v-pills-tab-5" role="tablist" aria-orientation="vertical">
                                                                                        <a class="nav-link nav-link-side-nav active" id="v-pills-tabbed0-tab-5" data-toggle="pill" href="#v-pills-tabbed0-5" role="tab" aria-controls="v-pills-tabbed0-5" aria-selected="false">Email Signatures</a>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-10 padding-left-0">
                                                                                    <div class="tab-content" id="v-pills-tabContent-5">
                                                                                        <div class="tab-pane fade show active" id="v-pills-tabbed0-5" role="tabpanel" aria-labelledby="v-pills-tabbed0-tab-5">
                                                                                            <div class="width-90-pc float-left">
                                                                                                <mail-signature-model></mail-signature-model>
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
    import {COUNTRIES_URL, PRACTICE_USERS_API, PRACTICES_API} from "../../../../router/api_routes";
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
    import DocNumModel from './partials/DocNumModel';
    import DocTitleModel from './partials/DocTitleModel';
    import DocMessageModel from './partials/DocMessageModel';
    import StatementMessageModel from './partials/StatementMessageModel';
    import BrandingModel from './partials/BrandingModel';
    import MailSignatureModel from './partials/MailSignatureModel';

    export default {
        name: "CompanyView",
        components: {
            RegionalSettings,DocTitleModel,BrandingModel,MailSignatureModel,
            TopNavBar,PaginateTemplate,SideBar,CopyRight,CompanyDetailModel,AdditionInfo,OutstandingBalance,DocMessageModel,
            CustomerZone,CustomerSupplierSettings,ItemModel,RoundingModel,FinancialModel,VatModel,DocNumModel,StatementMessageModel},
        data(){
            return {
                curr_tab: 0,
                sub_curr_tab: 0,
                is_initializing: false,
                page_ready: false,
                INVENTORY_WEB_ROUTES: INVENTORY_WEB_ROUTES,
                ADMIN_PERM: ADMIN_PERM,
                PRACTICES_API: PRACTICES_API,
                processing: false,
                company: null,
                countries: [],
            }
        },
        methods: {
            setTab(curr_ta){
                this.sub_curr_tab = 0;
                this.curr_tab = curr_ta;
            },
            setSubTab(sub_curr_ta){
                this.curr_tab = sub_curr_ta;
            },
            checkPerms(perm_){
                return Auth.hasPermission(perm_)
            },

            loadCompany(){
                get(PRACTICES_API+'/'+Auth.getCurrentAccount('id'))
                    .then((res) => {
                        if(res.data.status_code === 200) {
                            this.company = res.data.results;
                            console.info(this.company);
                            this.page_ready = true;
                            this.is_initializing = false;
                            this.processing = false;
                        }
                    }).catch((err) => {
                });
            },
            loadCountry(){
                this.is_initializing = true;
                get(COUNTRIES_URL)
                    .then((res) => {
                        if(res.data.status_code === 200) {
                            this.countries = res.data.results;
                            console.info(this.countries);
                            this.loadCompany();
                        }
                    }).catch((err) => {
                });
            },
        },
        mounted() {
            this.loadCountry()
        }
    }
</script>

<style scoped>

</style>