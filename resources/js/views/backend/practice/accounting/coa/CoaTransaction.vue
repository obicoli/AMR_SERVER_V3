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
                                        <div class="row justify-content-center">
                                            <div class="col-md-11 col-lg-11 padding-right-0 border-bottom">

                                                <div v-if="is_initializing" class="width-100-pc float-left text-center mg-top-60">
                                                    <img class="loader" src="/assets/icons/dashboard/loader.gif">
                                                </div>

                                                <div v-if="page_ready" class="width-100-pc float-left">
                                                    <div class="width-100-pc float-left">
                                                        <div class="width-45-pc float-left mg-top-15">
                                                            <a class="fw-600 cl-444 fs-20"> Account Transactions Report</a>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div v-if="page_ready" class="width-100-pc float-left mg-top-20">
                                                    <div class="width-45-pc float-left">
                                                        <div class="width-100-pc"><a class="fs-14 fs-20">AMREF WILSON AIRPORT</a></div>
                                                        <div class="width-100-pc float-left">
                                                            <div class="width-20-pc float-left">
                                                                <label class="company-label fs-12 mg-bottom-1 fw-600 cl-444">Account:&nbsp;</label>
                                                            </div>
                                                            <div class="width-80-pc float-left">
                                                                <label class="company-label fs-12 mg-bottom-1">{{chart_of_account.name}}</label>
                                                            </div>
                                                        </div>
                                                        <div class="width-100-pc float-left">
                                                            <div class="width-20-pc float-left">
                                                                <label class="company-label fs-12 mg-bottom-1 fw-600 cl-444">Type:&nbsp;</label>
                                                            </div>
                                                            <div class="width-80-pc float-left">
                                                                <label class="company-label fs-12 mg-bottom-1">{{chart_of_account.account_type.accounts_nature.name}} <i class="fa fa-arrow-right cl-success-light"></i> {{chart_of_account.account_type.name}}</label>
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
                                                        <div class="width-100-pc float-left">
                                                            <div class="width-20-pc float-left">
                                                                <label class="company-label fs-12 text-right mg-bottom-1 fw-600 cl-444">Date Range:&nbsp;</label>
                                                            </div>
                                                            <div class="width-80-pc float-left">
                                                                <label class="company-label fs-12 text-right mg-bottom-1">{{as_at}}</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="width-25-pc float-right mg-top-27">
                                                        <button :disabled="is_initializing || processing" type="button" class="btn btn-secondary banking-process-amref float-right">More Filters</button>
                                                    </div>
                                                    <!-- =============================TABS========================= -->
                                                    <div class="width-100-pc float-left mg-top-45">
                                                        
                                                        <table class="table banking-transaction-reports table-hover mg-bottom-20">        
                                                            <thead>
                                                                <tr>
                                                                    <th style="width:9%;" class="somepad-1 fw-600">Date</th>
                                                                    <th style="width:18%" class="somepad-1 fw-600">Bank/Customer/Supplier</th>
                                                                    <th style="width:10%" class="somepad-1 fw-600">Reference</th>
                                                                    <th style="width:13%;" class="somepad-1 fw-600">Transaction Type</th>
                                                                    <th style="width:21%" class="somepad-1 fw-600">Description</th>
                                                                    <th style="width:9%;" class="text-right somepad fw-600">Debit</th>
                                                                    <th style="width:9%;" class="text-right somepad-1 fw-600">Credit</th>
                                                                    <th style="width:11%;" class="text-right somepad-1 fw-600">Balance</th>
                                                                </tr>
                                                            </thead>

                                                            <!-- <tbody v-if="page_setting">
                                                                <tr>
                                                                    <td class="somepad text-center" colspan="8">
                                                                        <img class="loader" src="/assets/icons/dashboard/loader.gif">
                                                                    </td>
                                                                </tr>
                                                            </tbody> -->

                                                            <tbody>
                                                                <tr>
                                                                    <td class="somepad cl-amref fw-600 fs-13" colspan="8">{{chart_of_account.name}}</td>
                                                                </tr>
                                                            </tbody>

                                                            <tbody v-for="(report_transact,index) in report_transactions" :key="'chart_of_accounts_'+index">
                                                                <tr v-if="check_opening_balance_transaction(chart_of_account.account_type.accounts_nature.name,chart_of_account.code,report_transact,index)">
                                                                    <td class="somepad fw-600 txt-italic" colspan="5">Opening Balance as at: {{chart_of_account.filters.today}}</td>
                                                                    <td class="somepad fw-600 text-right">
                                                                        <span v-if="report_transact.double_entry.debited===chart_of_account.code || report_transact.double_entry.debited_parent===chart_of_account.code">{{currency+' '+format_money(report_transact.double_entry.amount)}}</span>
                                                                        <span v-else></span>
                                                                    </td>
                                                                    <td class="somepad fw-600 text-right">
                                                                        <span v-if="report_transact.double_entry.credited===chart_of_account.code || report_transact.double_entry.credited_parent===chart_of_account.code">{{currency+' '+format_money(report_transact.double_entry.amount)}}</span>
                                                                        <span v-else></span>
                                                                    </td>
                                                                    <td class="somepad fw-600 text-right"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="somepad">{{report_transact.trans_date}}</td>
                                                                    <td class="somepad">{{report_transact.trans_with.name}}</td>
                                                                    <td class="somepad">{{report_transact.support_document.reference_number}}</td>
                                                                    <td class="somepad">
                                                                        <a data-toggle="collapse" :data-target="'#transaction_details_'+index" v-if="report_transact.support_document.trans_type===customer_receipt" class="cl-blue-link pointer-cursor">{{report_transact.support_document.trans_type}}</a>
                                                                        <a data-toggle="collapse" :data-target="'#transaction_details_'+index" v-else-if="report_transact.support_document.trans_type===supplier_bill" class="cl-blue-link pointer-cursor">{{report_transact.support_document.trans_type}}</a>
                                                                        <span v-else>{{report_transact.support_document.trans_type}}</span>
                                                                    </td>
                                                                    <td class="somepad">{{report_transact.notes}}</td>
                                                                    <td class="somepad text-right">
                                                                        <span v-if="report_transact.double_entry.debited===chart_of_account.code || report_transact.double_entry.debited_parent===chart_of_account.code">{{format_money(report_transact.double_entry.amount)}}</span>
                                                                        <span v-else></span>
                                                                    </td>
                                                                    <td class="somepad text-right">
                                                                        <span v-if="report_transact.double_entry.credited===chart_of_account.code  || report_transact.double_entry.credited_parent===chart_of_account.code">{{format_money(report_transact.double_entry.amount)}}</span>
                                                                        <span v-else></span>
                                                                    </td>
                                                                    <td class="somepad text-right fw-600">
                                                                        {{format_money( calculate_balance(chart_of_account.account_type.accounts_nature.name,chart_of_account.code,index).total ) }}
                                                                    </td>
                                                                </tr>
                                                                <!-- <tr>
                                                                    <td colspan="8" class="zeroPadding no-bd">
                                                                        <div class="collapse out width-100-pc bg-ced" :id="'transaction_details_'+index">
                                                                            <div class="width-100-pc float-left bg-f4 padding-top-20 padding-bottom-30">
                                                                                <div class="width-70-pc float-left bg-white mg-left-15-pc border-ccc border-radius-2 padding-top-20 padding-bottom-30 padding-left-15 padding-right-15">
                                                                                    <sales-receipt-preview :doc_title="'Receipt'" v-if="report_transact.support_document.trans_type===customer_receipt"></sales-receipt-preview>
                                                                                    <bill-preview v-else :bill="report_transact.support_document.bill" :currency="currency"></bill-preview>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                </tr> -->
                                                            </tbody>

                                                            <tbody>
                                                                <tr>
                                                                    <td class="somepad fw-600 txt-italic" colspan="5">Closing Balance as at {{chart_of_account.filters.today}}</td>
                                                                    <td class="somepad fw-600 text-right">
                                                                        <span v-if="chart_of_account.account_type.accounts_nature.name===ACCOUNT_NATURES.ASSETS || chart_of_account.account_type.accounts_nature.name===ACCOUNT_NATURES.EXPENSE">{{currency+''+format_money( calculate_balance(chart_of_account.account_type.accounts_nature.name,chart_of_account.code,-1).total_debit )}}</span>
                                                                        <span v-else></span>
                                                                    </td>
                                                                    <td class="somepad fw-600">
                                                                        <span v-if="chart_of_account.account_type.accounts_nature.name===ACCOUNT_NATURES.LIABILITY || chart_of_account.account_type.accounts_nature.name===ACCOUNT_NATURES.EQUITY || chart_of_account.account_type.accounts_nature.name===ACCOUNT_NATURES.REVENUE">{{currency+''+format_money( calculate_balance(chart_of_account.account_type.accounts_nature.name,chart_of_account.code,-1).total_credit )}}</span>
                                                                        <span v-else></span>
                                                                    </td>
                                                                    <td class="somepad fw-600"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="somepad fw-600 txt-italic" colspan="5">Movement for the period</td>
                                                                    <td class="somepad fw-600 text-right">
                                                                        <span v-if="chart_of_account.account_type.accounts_nature.name===ACCOUNT_NATURES.ASSETS || chart_of_account.account_type.accounts_nature.name===ACCOUNT_NATURES.EXPENSE">{{currency+''+format_money( calculate_balance(chart_of_account.account_type.accounts_nature.name,chart_of_account.code,-1).total )}}</span>
                                                                        <span v-else></span>
                                                                    </td>
                                                                    <td class="somepad fw-600">
                                                                        <span v-if="chart_of_account.account_type.accounts_nature.name===ACCOUNT_NATURES.LIABILITY || chart_of_account.account_type.accounts_nature.name===ACCOUNT_NATURES.EQUITY || chart_of_account.account_type.accounts_nature.name===ACCOUNT_NATURES.REVENUE">{{currency+''+format_money( calculate_balance(chart_of_account.account_type.accounts_nature.name,chart_of_account.code,-1).total )}}</span>
                                                                        <span v-else></span>
                                                                    </td>
                                                                    <td class="somepad fw-600"></td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>

                                                <div class="width-100-pc float-left text-center">
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

    import SideBar from "../../partials/sidebars/SideBar";
    import TopNavBar from "../../partials/topbars/TopNavBar";
    // import PaginateTemplate from '../../partials/pagination/PaginateTemplate';
    // import DeleteModal from "../../partials/modals/DeleteModal";
    import CopyRight from "../../partials/CopyRight";
    // import BankModal from "../../partials/modals/accounting/BankModal";
    // import TransactionAttachmentModal from "../../partials/modals/accounting/TransactionAttachmentModal";
    // import SplitTransactionModal from "../../partials/modals/accounting/SplitTransactionModal";
    // import AllocateInvoiceModal from "../../partials/modals/accounting/AllocateInvoiceModal";
    // import BankBranchModal from "../../partials/modals/accounting/BankBranchModal";
    // import BankAccountModal from "../../partials/modals/accounting/BankAccountModal";

    import SalesReceiptPreview from "../../partials/previews/supplychain/customer/SalesReceiptPreview";
    import BillPreview from "../../partials/previews/supplychain/supplier/BillPreview";

    import ProcessingOverlay from "../../../../progress/ProcessingOverlay";
    import {get, post} from "../../../../../helpers/api";
    import Auth from "../../../../../store/auth";
    // import Datepicker from 'vuejs-datepicker';
    import {check_opening_balance_transaction,formatMoney,create_bank_statement_transaction,calculate_account_bal,createHtmlErrorString,paginator} from "../../../../../helpers/functionmixin";
    import {AC_TYPES,ACCOUNTING,TRANSACTION_TYPES} from "../../../../../helpers/process_status";
    import {CHART_OF_ACCOUNTS} from '../../../../../router/api_routes';
    export default {
        name: "CoaTransaction",
        components: {TopNavBar,SideBar,SalesReceiptPreview,BillPreview,
        ProcessingOverlay,CopyRight},
        data(){
            return {
                page_setting: true,
                as_at: null,
                initialUrl: CHART_OF_ACCOUNTS,
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
                ACCOUNT_NATURES: ACCOUNTING.ACCOUNT_NATURES,
                customer_receipt: TRANSACTION_TYPES.CUSTOMER_RECEIPT,
                supplier_bill: TRANSACTION_TYPES.SUPPLIER_BILL,
            }
        },
        methods: {

            format_money(money_to){
                return formatMoney(money_to);
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

            loadCoa(state_){
                this.is_initializing = state_;
                get(CHART_OF_ACCOUNTS+'/'+this.$route.params.uuid)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        //console.info(res.data.results.data);
                        this.report_transactions = res.data.results.data.transactions;
                        this.chart_of_account = res.data.results.data;
                        this.as_at = res.data.results.filters.date_range;
                        this.is_initializing = false;
                        this.page_ready = true;
                    }
                }).catch((err) => {
                    this.is_initializing = false;
                });
            },

            // loadBankAccounts(show_progress){
            //     this.progress_overlay = "hide";
            //     if(show_progress){this.progress_overlay = "show";}
            //     get(this.bank_accounts_api)
            //     .then((res) => {
            //         if(res.data.status_code === 200) {
            //             this.bank_accounts = res.data.results;
            //             for (let index = 0; index < this.bank_accounts.length; index++) {
            //                 const element = this.bank_accounts[index];
            //                 if(element.is_default){ 
            //                     this.selected_bank_account = element;
            //                     this.showBankAccount(element.id);
            //                      break; 
            //                 }
            //             }
            //             this.progress_overlay = "hide";
            //             this.page_ready = true;
            //         }
            //     }).catch((err) => {
            //         this.progress_overlay = "hide";
            //         this.page_loaded = false;
            //         if(err.response.status === 422) {
            //             this.$awn.warning(createHtmlErrorString(err.response.data.errors));
            //         }else if (err.response.status === 500){
            //             this.$awn.warning(err.response.data.description);
            //         }
            //         else{
            //             this.processing = false;
            //             this.$awn.warning(err.response.data.description);
            //         }
            //     });
            // },

            // showBankAccount(account_id,continue_=true){
            //     this.bank_transactions = [];
            //     this.is_initializing = true;
            //     this.processing = true;
            //     get(this.bank_accounts_api+'/'+account_id)
            //     .then((res) => {
            //         if(res.data.status_code === 200) {
            //             console.info(res.data.results);
            //             this.selected_bank_account = res.data.results;
            //             this.bank_transactions = res.data.results.transaction.data;
            //             if(!this.bank_transactions.length){
            //                 let empty_transaction = create_bank_statement_transaction();
            //                 empty_transaction.transaction_date = this.selected_bank_account.current_date;
            //                 this.form.transactions.push( empty_transaction );
            //             }else{
            //                 this.form.transactions = this.bank_transactions;
            //             }
            //             if(continue_){
            //                 this.loadVAT();
            //             }
            //             // this.is_initializing = false;
            //             // this.processing = false;
                        
            //         }
            //     }).catch((err) => {
            //         this.progress_overlay = "hide";
            //         this.page_loaded = false;
            //         if(err.response.status === 422) {
            //             this.$awn.warning(createHtmlErrorString(err.response.data.errors));
            //         }else if (err.response.status === 500){
            //             this.$awn.warning(err.response.data.description);
            //         }
            //         else{
            //             this.is_initializing = false;
            //             this.processing = false;
            //             this.$awn.warning(err.response.data.description);
            //         }
            //         this.is_initializing = false;
            //         this.processing = false;
            //     });
            // },

            // loadVAT(){
            //     get(PRODUCT_TAX_URL)
            //     .then((res) => {
            //         if(res.data.status_code === 200) {
            //             this.taxations = res.data.results;
            //             //console.info(this.taxations);
            //             this.is_initializing = false;
            //             this.processing = false;
            //         }
            //     }).catch((err) => {
            //         this.progress_overlay = "hide";
            //         this.page_loaded = false;
            //         if(err.response.status === 422) {
            //             this.$awn.warning(createHtmlErrorString(err.response.data.errors));
            //         }else if (err.response.status === 500){
            //             this.$awn.warning(err.response.data.description);
            //         }
            //         else{
            //             this.processing = false;
            //             this.$awn.warning(err.response.data.description);
            //         }
            //         this.is_initializing = false;
            //     });
            // },

            // loadCoa(global_index){
            //     get(CHART_OF_ACCOUNTS)
            //     .then((res) => {
            //         if(res.data.status_code === 200) {
            //             let chart_of_accounts = res.data.results.data;
            //             for (let index = 0; index < chart_of_accounts.length; index++) {
            //                 const element = chart_of_accounts[index];
            //                 let new_obj = {
            //                     id: element.id,
            //                     name: element.name
            //                 }
            //                 this.form.transactions[global_index].selections.push(new_obj);
            //             }
            //         }
            //     }).catch((err) => {
            //     });
            // },

            // loadSuplier(global_index){

            //     get(SUPPLIER_URL)
            //     .then((res) => {
            //         if(res.data.status_code === 200) {
            //             let chart_of_accounts = res.data.results.data;
            //             for (let index = 0; index < chart_of_accounts.length; index++) {
            //                 const element = chart_of_accounts[index];
            //                 let new_obj = {
            //                     id: element.id,
            //                     name: element.display_as
            //                 }
            //                 this.form.transactions[global_index].selections.push(new_obj);
            //             }
            //         }
            //     }).catch((err) => {
            //     });
                
            // },

            // loadCustomer(global_index){
            //     get(CUSTOMERS_API)
            //     .then((res) => {
            //         if(res.data.status_code === 200) {
            //             let chart_of_accounts = res.data.results.data;
            //             for (let index = 0; index < chart_of_accounts.length; index++) {
            //                 const element = chart_of_accounts[index];
            //                 let new_obj = {
            //                     id: element.id,
            //                     name: element.display_as
            //                 }
            //                 this.form.transactions[global_index].selections.push(new_obj);
            //             }
            //         }
            //     }).catch((err) => {
            //     });
            // },

            check_permissions(perm_){
                return Auth.menuChecker(perm_);
            }
        },

        mounted() {
            this.is_initializing = true;
            this.loadCoa(true);
        }
    }
</script>

<style lang="scss">
    th {
        position: sticky;
        top: 0px;
    }
</style>