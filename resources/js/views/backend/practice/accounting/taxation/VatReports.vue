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
                                                                        {{report_type}}
                                                                    </a>
                                                                    <div class="dropdown-menu" :aria-labelledby="'btnGroupDrop2_1'">
                                                                        <router-link :hidden="is_initializing" :to="TAXATION.REPORTS+'?type='+VAT_REPORTS.REP1" class="dropdown-item pointer-cursor">{{VAT_REPORTS.REP1}}</router-link>
                                                                        <router-link :hidden="is_initializing" :to="TAXATION.REPORTS+'?type='+VAT_REPORTS.REP2" class="dropdown-item pointer-cursor">{{VAT_REPORTS.REP2}}</router-link>
                                                                        <router-link :hidden="is_initializing" :to="TAXATION.REPORTS+'?type='+VAT_REPORTS.REP3" class="dropdown-item pointer-cursor">{{VAT_REPORTS.REP3}}</router-link>
                                                                        <router-link :hidden="is_initializing" :to="TAXATION.REPORTS+'?type='+VAT_REPORTS.REP4" class="dropdown-item pointer-cursor">{{VAT_REPORTS.REP4}}</router-link>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div v-if="default_report_filter" class="col-md-7 col-lg-7 padding-right-0 border-bottom">
                                                <report-filter :report_opt="report_options" :reported_data="reported_data" :tax_returns="tax_returns" :vat_types="vat_types" :refresh="false" :report_type="report_type" @report-data-event="setData(reported_data)" @report-options-event="setOpt(report_options)"></report-filter>
                                            </div>
                                            <div v-else class="col-md-10 col-lg-10 padding-right-0 border-bottom">
                                                <div class="width-100-pc float-left mg-top-20">
                                                    <div class="width-45-pc float-left">
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
                                                    </div>
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
                                                                    <report-filter :report_options="report_options" :reported_data="reported_data" :tax_returns="tax_returns" :vat_types="vat_types" :refresh="true" :report_type="report_type" @report-data-event="setData(reported_data)" @report-options-event="setOpt(report_options)"></report-filter>
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
                                                            <div class="printReport icon pointer-cursor float-left" title="Print Report"></div>
                                                            <div class="emailReport icon pointer-cursor float-left" title="Email Report"></div>
                                                        </div>
                                                        <vat-transaction-report v-if="tax_return && report_type===VAT_REPORTS.REP3" :report_options="report_options" :currency="currency" :tax_return="tax_return"></vat-transaction-report>
                                                        <vat-default-report v-if="tax_return && report_type===VAT_REPORTS.REP1" :report_options="report_options" :currency="currency" :tax_return="tax_return"></vat-default-report>
                                                        <vat-summary v-if="tax_return && report_type===VAT_REPORTS.REP2" :report_options="report_options" :currency="currency" :tax_return="tax_return"></vat-summary>
                                                        <vat-payment-summary v-if="tax_return && report_type===VAT_REPORTS.REP4" :report_options="report_options" :currency="currency" :tax_return="tax_return"></vat-payment-summary>
                                                        <!-- <vat-transactions v-if="tax_return && report_type===VAT_REPORTS.REP3" :report_options="report_options" :currency="currency" :tax_return="tax_return"></vat-transactions> -->
                                                    </div>
                                                    <div v-else class="width-100-pc float-left mg-top-20 text-center">
                                                        <img class="loader" src="/assets/icons/dashboard/reports.png"><br>
                                                        <label class="cl-amref fs-14">This report does not have data!</label>
                                                    </div>
                                                    <!-- Sub Summary Block -->
                                                    <!-- ----------Summary---------- -->
                                                </div>
                                                
                                            </div>
                                        </div>
                                        <div v-else class="row justify-content-center">
                                            <div class="col-md-5 col-lg-5 padding-right-0 border-bottom">
                                                <div class="width-100-pc float-left text-center">
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

    import SideBar from "../../partials/sidebars/SideBar";
    import TopNavBar from "../../partials/topbars/TopNavBar";
    // import PaginateTemplate from '../../partials/pagination/PaginateTemplate';
    // import DeleteModal from "../../partials/modals/DeleteModal";
    import CopyRight from "../../partials/CopyRight";

    import SalesReceiptPreview from "../../partials/previews/supplychain/customer/SalesReceiptPreview";
    import BillPreview from "../../partials/previews/supplychain/supplier/BillPreview";
    import ReportFilter from "./partials/ReportFilter";
    import VatTransactions from "./partials/VatTransactions";
    import VatTransactionReport from "./partials/VatTransactionReport";
    import VatSummary from "./partials/VatSummary";
    import VatDefaultReport from "./partials/VatDefaultReport";
    import VatPaymentSummary from "./partials/VatPaymentSummary";

    import ProcessingOverlay from "../../../../progress/ProcessingOverlay";
    import {get, post} from "../../../../../helpers/api";
    import Auth from "../../../../../store/auth";
    // import Datepicker from 'vuejs-datepicker';
    import {check_opening_balance_transaction,formatMoney,create_bank_statement_transaction,calculate_account_bal,createHtmlErrorString,paginator, format_lunox_date} from "../../../../../helpers/functionmixin";
    import {AC_TYPES,ACCOUNTING,TRANSACTION_TYPES,VAT_OPTIONS} from "../../../../../helpers/process_status";
    import {ACCOUNTS_TAX_RETURNS,ACCOUNTS_TAXATIONS} from '../../../../../router/api_routes';
    import {ACCOUNTING_WEB_ROUTES} from '../../../../../router/web_routes';
    export default {
        name: "VatReports",
        components: {TopNavBar,SideBar,SalesReceiptPreview,BillPreview,VatDefaultReport,
        ProcessingOverlay,CopyRight,ReportFilter,VatTransactions,VatSummary,VatPaymentSummary,VatTransactionReport},
        data(){
            return {
                page_setting: true,
                as_at: null,
                //initialUrl: CHART_OF_ACCOUNTS,
                form: {
                    bank_account: null,
                    selected_transactions: [],
                    transactions: [],
                    action_taken: null,
                },
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
                report_options: {
                    vat_type_id: null,
                    reference_number: null,
                    period_end_date: null,
                    vat_return_id:null,
                    view_by: 'VAT Period',
                    basis: 'Cash',
                    style: 'Summary',
                    includes: [],
                    date_range: 1,
                    vat_report_name: null,
                },
                report_type: '',
                default_report_filter: true,
                VIEW_BY: VAT_OPTIONS.VIEW_BY,
                VAT_REPORTS: VAT_OPTIONS.VAT_REPORTS,
                TAXATION: ACCOUNTING_WEB_ROUTES.TAXATION,
                vat_types: [],
                vat_type: null,
                reported_data: [],
                vat_name: 'All VAT Types',
                vat_period_name: '',
                vat_reference: null,
                show_opt: true,
            }
        },
        watch: {
            "$route.query.type": function (id) {
                this.report_options.vat_report_name = id;
                this.report_type = id;
            }
        },
        methods: {

            format_money(money_to){
                return formatMoney(money_to);
            },

            setOpt(report_options){
                this.report_options = report_options;
            },

            setData(reported_data){
                console.info(reported_data);
                //this.reported_data = reported_data;
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

            loadReturns(){
                this.is_initializing = true;
                get(ACCOUNTS_TAX_RETURNS)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.tax_returns = res.data.results.data;
                        //this.vat_period_summary = res.data.results.vat_period_summary;
                        this.filters = res.data.results.filters;
                        this.report_options.period_end_date = format_lunox_date(this.filters.end);
                        this.pagination = res.data.results.pagination;
                        this.page_ready  = true;
                        this.is_initializing = false;
                        //console.info(this.tax_returns);
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
            loadVATypes(){
                this.is_initializing = true;
                get(ACCOUNTS_TAXATIONS)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.vat_types = res.data.results.data;
                        this.loadReturns();
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
            this.report_type = this.$route.query.type;
            this.report_options.vat_report_name = this.report_type;
            this.loadVATypes();
        }
    }
</script>

<style lang="scss">
    th {
        position: sticky;
        top: 0px;
    }
</style>