<template>

    <div>

        <processing-overlay :message="msg" :status="progress_overlay"></processing-overlay>

        <top-nav-bar :inventory="true" :bg_f7="true"></top-nav-bar>

        <side-bar></side-bar>

        <div class="wp-content mg-top-50 content-calculated-height-wc">

            <div class="row">

                <div class="col-md-12 col-lg-12 col-sm-12 padding-left-0">

                    <div class="row">
                        <div class="col-md-12 col-lg-12 col-sm-12 padding-right-0 padding-left-0 bg-ced content-calculated-height-wc">
                            
                            <div class="box box-primary bg-ced border-top-0 border-bottom-0 no-shadowed padding-right-20 content-calculated-height-110 top-20">
                                
                                <div class="page-content bg-ced padding-0 mg-right-0 mg-left-0 min-height-100-vh">
                                    <div class="dgrid dgrid-grid ui-widget dgrid-03 mg-bottom-30 universal-grid border-ccc" role="grid">
                                        <div v-if="page_ready" class="row justify-content-center">
                                            <div class="col-md-10 col-lg-10 padding-right-0 border-bottom">
                                                <div class="width-100-pc float-left">
                                                    <div class="width-100-pc float-left">
                                                        <div class="width-45-pc float-left mg-top-15">
                                                            <div class="btn-group" role="group" aria-label="Button group">
                                                                <div class="btn-group" role="group">
                                                                    <a :id="'btnGroupDrop2_1'" class="dropdown-toggle fs-14 pointer-cursor fw-600 txt-uppercase" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                        {{report_options.report_name}}
                                                                    </a>
                                                                    <div class="dropdown-menu" :aria-labelledby="'btnGroupDrop2_1'">
                                                                        <router-link v-for="(key,item) in REPORTS" :hidden="is_initializing" :to="REPORT_WEB_URL+'?type='+key" class="dropdown-item pointer-cursor" :key="'REPORTS'+item">{{key}}</router-link>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div v-if="default_report_filter" class="col-md-8 col-lg-8 padding-right-0 border-bottom">
                                                <report-filter :report_options="report_options" :refresh="false" :suppliers="suppliers" :is_initializing="is_initializing" @report-options-event="loadReport(report_options)"></report-filter>
                                            </div>
                                            <div v-else class="col-md-10 col-lg-10 padding-right-0 border-bottom">
                                                <div class="width-100-pc float-left mg-top-20">
                                                    <!-- <div class="width-45-pc float-left">
                                                        <div class="width-100-pc"><a class="fs-12 txt-uppercase">AMREF WILSON AIRPORT</a></div>
                                                        <div class="width-100-pc float-left">
                                                            <div class="width-20-pc float-left">
                                                                <label class="company-label fs-12 mg-bottom-1 fw-600 cl-444">VAT Type:&nbsp;</label>
                                                            </div>
                                                            <div class="width-80-pc float-left">
                                                                <label class="company-label fs-12 mg-bottom-1">{{vat_name}}</label>
                                                            </div>
                                                        </div>
                                                        <div class="width-100-pc float-left">
                                                            <div class="width-20-pc float-left">
                                                                <label class="company-label fs-12 mg-bottom-1 fw-600 cl-444">VAT Period:&nbsp;</label>
                                                            </div>
                                                            <div class="width-80-pc float-left">
                                                                <label class="company-label fs-12 mg-bottom-1"> {{vat_period_name}}</label>
                                                            </div>
                                                        </div>
                                                        <div class="width-100-pc float-left">
                                                            <div class="width-20-pc float-left">
                                                                <label class="company-label fs-12 mg-bottom-1 fw-600 cl-444">Reference:&nbsp;</label>
                                                            </div>
                                                            <div class="width-80-pc float-left">
                                                                <label class="company-label fs-12 mg-bottom-1">{{vat_reference}}</label>
                                                            </div>
                                                        </div>
                                                        <div class="width-100-pc float-left">
                                                            <div class="width-20-pc float-left">
                                                                <label class="company-label fs-12 mg-bottom-1 fw-600 cl-444">Method:&nbsp;</label>
                                                            </div>
                                                            <div class="width-80-pc float-left">
                                                                <label class="company-label fs-12 mg-bottom-1">Accrual Basis</label>
                                                            </div>
                                                        </div>
                                                    </div> -->
                                                    <div class="width-25-pc float-right mg-top-27">
                                                        <button type="button" @click="toggleOptions()" data-toggle="collapse" data-target="#multiCollapseExample2" aria-expanded="false" aria-controls="multiCollapseExample2" :class="{'btn btn-secondary float-right':true,'banking-process-amref':show_opt,'banking-process':!show_opt}">
                                                            <span v-if="show_opt">Show Report Options</span>
                                                            <span v-else>Hide Report Options</span>
                                                        </button>
                                                    </div>
                                                    <div class="width-100-pc float-left mg-top-20">
                                                        <div class="width-100-pc float-left collapse multi-collapse bg-f4 padding-10" id="multiCollapseExample2">
                                                            <div class="row justify-content-center">
                                                                <div class="col-md-9 col-lg-9 padding-right-0 border-bottom">
                                                                    <report-filter :report_options="report_options" :refresh="true" :suppliers="suppliers" :is_initializing="is_initializing" @report-options-event="loadReport(report_options)"></report-filter>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- =============================TABS========================= -->
                                                    <div v-if="reported_data.length" class="width-100-pc float-left mg-top-10">
                                                        <!-- ----------Transactions---------- -->
                                                        <div class="width-100-pc float-left action-icons mg-bottom-5">
                                                            <div class="exportPDF icon pointer-cursor float-left" title="Export report to PDF"></div>
                                                            <div class="exportXLS icon pointer-cursor float-left" title="Export report to XLS"></div>
                                                            <div class="exportCSV icon pointer-cursor float-left" title="Export report to CSV"></div>
                                                            <div @click="printReport('reported_data_id')" class="printReport icon pointer-cursor float-left" title="Print Report"></div>
                                                            <div class="emailReport icon pointer-cursor float-left" title="Email Report"></div>
                                                        </div>
                                                        <supplier-listing id="reported_data_id" :currency="currency" :reported_data="reported_data" :filters="filters" :pagination="pagination"></supplier-listing>
                                                    </div>
                                                    <div v-else class="width-100-pc float-left mg-top-20 text-center">
                                                        <img class="loader" src="/assets/icons/dashboard/reports.png"><br>
                                                        <label class="cl-amref fs-14">This report does not have data!</label>
                                                    </div>
                                                    <!-- Sub Summary Block -->
                                                    <!-- ----------Summary---------- -->
                                                </div>
                                            </div>
                                            <div class="col-md-10 col-lg-10">
                                                <div class="width-100-pc float-left text-center">
                                                    <copy-right></copy-right>
                                                </div>
                                            </div>
                                        </div>
                                        <div v-else class="row justify-content-center">
                                            <div class="col-md-5 col-lg-5 padding-right-0 border-bottom">
                                                <div class="width-100-pc float-left text-center">
                                                    <img class="loader" src="/assets/icons/dashboard/loader.gif">
                                                    <copy-right></copy-right>
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

    import SideBar from "../../../partials/sidebars/SideBar";
    import TopNavBar from "../../../partials/topbars/TopNavBar";
    // import PaginateTemplate from '../../partials/pagination/PaginateTemplate';
    // import DeleteModal from "../../partials/modals/DeleteModal";
    import CopyRight from "../../../partials/CopyRight";

    import SalesReceiptPreview from "../../../partials/previews/supplychain/customer/SalesReceiptPreview";
    import BillPreview from "../../../partials/previews/supplychain/supplier/BillPreview";
    import ReportFilter from "./partials/ReportFilter";
    import SupplierListing from "./partials/SupplierListing";
    // import VatTransactions from "./partials/VatTransactions";
    // import VatSummary from "./partials/VatSummary";

    import ProcessingOverlay from "../../../../../progress/ProcessingOverlay";
    import {get, post} from "../../../../../../helpers/api";
    import Auth from "../../../../../../store/auth";
    // import Datepicker from 'vuejs-datepicker';
    import {check_opening_balance_transaction,formatMoney,create_bank_statement_transaction,calculate_account_bal,createHtmlErrorString,paginator, format_lunox_date, printing} from "../../../../../../helpers/functionmixin";
    import {AC_TYPES,ACCOUNTING,TRANSACTION_TYPES,VAT_OPTIONS} from "../../../../../../helpers/process_status";
    import {SUPPLIER_URL,SUPPLIER_REPORTS_API} from '../../../../../../router/api_routes';
    import {ACCOUNTING_WEB_ROUTES,INVENTORY_WEB_ROUTES} from '../../../../../../router/web_routes';
    export default {
        name: "VatReports",
        components: {TopNavBar,SideBar,SalesReceiptPreview,BillPreview,
        ProcessingOverlay,CopyRight,ReportFilter,SupplierListing},
        data(){
            return {

                page_setting: true,
                as_at: null,
                // form: {
                //     bank_account: null,
                //     selected_transactions: [],
                //     transactions: [],
                //     action_taken: null,
                // },
                report_transactions: [],
                //banks: [],
                //bank_branches: [],
                //bank_account_types: [],
                selected_chart_of_account: [],
                AC_TYPES: AC_TYPES,
                //bank_accounts: [],
                //bank_transactions: [],
                chart_of_account: {},
                //
                msg: 'Loading. Please wait...',
                progress_overlay: 'hide',
                page_ready: false,
                is_initializing: false,
                processing: false,
                pagination: paginator(),
                currency: ACCOUNTING.CURRENCY,
                //ACCOUNT_NATURES: ACCOUNTING.ACCOUNT_NATURES,
                //customer_receipt: TRANSACTION_TYPES.CUSTOMER_RECEIPT,
                //supplier_bill: TRANSACTION_TYPES.SUPPLIER_BILL,

                tax_return:null,
                tax_returns:[],
                
                //report_type: '',
                
                VIEW_BY: VAT_OPTIONS.VIEW_BY,
                VAT_REPORTS: VAT_OPTIONS.VAT_REPORTS,
                TAXATION: ACCOUNTING_WEB_ROUTES.TAXATION,
                vat_types: [],
                vat_type: null,
                
                vat_name: 'All VAT Types',
                vat_period_name: '',
                vat_reference: null,
                show_opt: true,

                REPORTS: TRANSACTION_TYPES.SUPPLIER_REPORTS,
                REPORT_WEB_URL: INVENTORY_WEB_ROUTES.PURCHASES.REPORTS,
                report_options: {
                    status: '',
                    report_name: null,
                    category: '',
                    date_frequency: 1,
                    trans_month: '',
                    incl_supplier_return: false,
                    run_at_date: null,
                    balance_brought_forward: false,
                    zero_balance_supplier: false,
                    incl_supplier_return_and_ajustment: false,
                    trx_type: null,
                    document_status: '',
                    minimun_balance: ''
                },
                suppliers: [],
                reported_data: [],
                default_report_filter: true,
                filters: null,
            }
        },

        watch: {
            "$route.query.type": function (id) {
                this.report_options.report_name = id;
            }
        },

        methods: {

            format_money(money_to){
                return formatMoney(money_to);
            },

            printReport(report_id){
                printing(report_id);
            },

            setOpt(report_options){
                this.report_options = report_options;
            },

            setData(reported_data){
                if(reported_data.length){
                    this.tax_return = reported_data[reported_data.length-1];
                }
                this.default_report_filter = false;
            },

            toggleOptions(){
                if(this.show_opt){
                    this.show_opt = false;
                }else{
                    this.show_opt = true;
                }
            },

            calculate_balance(account_nature,account_code,stop_at_index){
                const sub_total = calculate_account_bal(account_nature,account_code,stop_at_index,this.report_transactions);
                if(sub_total.calculate_done){ this.page_setting = false }
                return sub_total;
            },

            check_opening_balance_transaction(account_nature,account_code,report_transact,stop_at_index){
                return check_opening_balance_transaction(account_nature,account_code,report_transact,stop_at_index);
            },

            check_all(event){
                this.form.selected_transactions = [];
                if(event.target.checked){
                    for (let index = 0; index < this.form.transactions.length; index++) {
                        this.form.selected_transactions.push(index);
                    }
                }else{
                    this.selected_banks = [];
                }
            },

            loadReport(report_options){
                this.is_initializing = true;
                this.report_options = report_options;
                get(SUPPLIER_REPORTS_API+'?filters='+JSON.stringify(report_options))
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.reported_data = res.data.results.data;
                        this.default_report_filter = false;
                        this.is_initializing = false;

                    }
                }).catch((err) => {
                    this.progress_overlay = "hide";
                    this.page_loaded = false;
                    if(err.response.status === 422) {
                        this.$awn.warning(createHtmlErrorString(err.response.data.errors));
                    }else if (err.response.status === 500){
                        this.$awn.warning(err.response.data.description);
                    }
                    else{
                        this.processing = false;
                        this.$awn.warning(err.response.data.description);
                    }
                    this.is_initializing = false;
                });
            },

            loadSuppliers(){
                this.is_initializing = true;
                get(SUPPLIER_URL)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.suppliers = res.data.results.data;
                        this.filters = res.data.results.filters;
                        this.pagination = res.data.results.pagination;
                        //console.info(this.suppliers);
                        this.page_ready  = true;
                        this.is_initializing = false;
                    }
                }).catch((err) => {
                    this.progress_overlay = "hide";
                    this.page_loaded = false;
                    if(err.response.status === 422) {
                        this.$awn.warning(createHtmlErrorString(err.response.data.errors));
                    }else if (err.response.status === 500){
                        this.$awn.warning(err.response.data.description);
                    }
                    else{
                        this.processing = false;
                        this.$awn.warning(err.response.data.description);
                    }
                    this.is_initializing = false;
                });
            },

            check_permissions(perm_){
                return Auth.menuChecker(perm_);
            }
        },

        mounted() {
            this.report_options.report_name = this.$route.query.type;
            this.loadSuppliers();
        }
    }
</script>

<style lang="scss">
    th {
        position: sticky;
        top: 0px;
    }
</style>