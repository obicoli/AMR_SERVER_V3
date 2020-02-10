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
                                                            <a class="fw-600 cl-444 fs-20"> VAT Report</a>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div v-if="page_ready" class="width-100-pc float-left mg-top-20">
                                                    <div class="width-45-pc float-left">
                                                        <div class="width-100-pc"><a class="fs-12 txt-uppercase">AMREF WILSON AIRPORT</a></div>
                                                        <div class="width-100-pc float-left">
                                                            <div class="width-20-pc float-left">
                                                                <label class="company-label fs-12 mg-bottom-1 fw-600 cl-444">VAT Type:&nbsp;</label>
                                                            </div>
                                                            <div class="width-80-pc float-left">
                                                                <label class="company-label fs-12 mg-bottom-1">All VAT Types</label>
                                                            </div>
                                                        </div>
                                                        <div class="width-100-pc float-left">
                                                            <div class="width-20-pc float-left">
                                                                <label class="company-label fs-12 mg-bottom-1 fw-600 cl-444">VAT Period:&nbsp;</label>
                                                            </div>
                                                            <div class="width-80-pc float-left">
                                                                <label class="company-label fs-12 mg-bottom-1"> {{tax_return.vat_period}}</label>
                                                            </div>
                                                        </div>
                                                        <div class="width-100-pc float-left">
                                                            <div class="width-20-pc float-left">
                                                                <label class="company-label fs-12 mg-bottom-1 fw-600 cl-444">Reference:&nbsp;</label>
                                                            </div>
                                                            <div class="width-80-pc float-left">
                                                                <label class="company-label fs-12 mg-bottom-1">{{tax_return.reference_number}}</label>
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
                                                        <button v-if="report_options.options" type="button" @click="toggleOptions(false)" class="btn btn-secondary banking-process float-right">Hide Report Options</button>
                                                        <button v-else type="button" @click="toggleOptions(true)" class="btn btn-secondary banking-process-amref float-right">Show Report Options</button>
                                                    </div>
                                                    <!-- =============================TABS Output========================= -->
                                                    <div class="width-100-pc float-left mg-top-45 bg-white padding-20">
                                                        <table class="table banking-transaction-vat-reports table-hover mg-bottom-20">        
                                                            <thead>
                                                                <tr>
                                                                    <th style="width:10%;" class="somepad-1 fw-600">Date</th>
                                                                    <th style="width:17%" class="somepad-1 fw-600">Bank/Customer/Supplier</th>
                                                                    <th style="width:10%" class="somepad-1 fw-600">Reference</th>
                                                                    <th style="width:15%" class="somepad-1 fw-600">Description</th>
                                                                    <th style="width:10%;" class="somepad-1 fw-600">VAT Period</th>
                                                                    <th style="width:13%;" class="text-right somepad fw-600">Exclusive({{currency}})</th>
                                                                    <th style="width:13%;" class="text-right somepad-1 fw-600">Inclusive({{currency}})</th>
                                                                    <th style="width:12%;" class="text-right somepad-1 fw-600">VAT({{currency}})</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody v-if="tax_return.total_output_transactions">
                                                                <tr>
                                                                    <td class="somepad cl-amref fw-600 no-bottom-bd fs-16" colspan="8">Output Tax</td>
                                                                </tr>
                                                            </tbody>
                                                            <tbody v-for="(transaction,index) in tax_return.transactions" :key="'transactions_output_'+index">
                                                                <tr v-if="transaction.output_tax.length && index>0">
                                                                    <td class="somepad cl-444 fw-600 tr-separator" colspan="8"></td>
                                                                </tr>
                                                                <tr v-if="transaction.output_tax.length">
                                                                    <td class="somepad cl-444 fw-600 sub-header-dark bd-right bd-left" colspan="8">{{transaction.display_as}} - Output Tax</td>
                                                                </tr>
                                                                <tr v-for="(output_transaction,index_trs) in transaction.output_tax" :key="'index_trs_'+index_trs">
                                                                    <td v-bind:class="{'somepad bd-left':true,'no-bottom-bd':index_trs!==transaction.output_tax.length-1}">{{output_transaction.trans_date}}</td>
                                                                    <td v-bind:class="{'somepad':true,'no-bottom-bd':index_trs!==transaction.output_tax.length-1}">
                                                                        <span>{{output_transaction.creditor_debtor_account.legal_name}}</span>
                                                                    </td>
                                                                    <td v-bind:class="{'somepad':true,'no-bottom-bd':index_trs!==transaction.output_tax.length-1}">{{output_transaction.trans_number}}</td>
                                                                    <td v-bind:class="{'somepad':true,'no-bottom-bd':index_trs!==transaction.output_tax.length-1}">{{output_transaction.description}}</td>
                                                                    <td v-bind:class="{'somepad bd-right':true,'no-bottom-bd':index_trs!==transaction.output_tax.length-1}">{{output_transaction.vat_period}}</td>
                                                                    <td v-bind:class="{'somepad text-right bd-right':true,'no-bottom-bd':index_trs!==transaction.output_tax.length-1}">{{format_money(output_transaction.exclusive)}}</td>
                                                                    <td v-bind:class="{'somepad text-right bd-right':true,'no-bottom-bd':index_trs!==transaction.output_tax.length-1}">{{format_money(output_transaction.inclusive)}}</td>
                                                                    <td v-bind:class="{'somepad text-right bd-right':true,'no-bottom-bd':index_trs!==transaction.output_tax.length-1}">{{format_money(output_transaction.vat_amount)}}</td>
                                                                </tr>
                                                                <tr class="notes" v-if="transaction.output_tax.length">
                                                                    <td class="somepad cl-444 fw-600 text-right bd-left bd-right" colspan="5">
                                                                        Sales and Output Tax on Sales for the period {{tax_return.vat_period+' ( '+transaction.display_as+' )'}}
                                                                    </td>
                                                                    <td class="somepad cl-444 fw-600 text-right bd-left bd-right" colspan="3"></td>
                                                                </tr>
                                                                <tr v-if="transaction.output_tax.length">
                                                                    <td class="somepad cl-444 text-right no-bottom-bd bd-right" colspan="5">Total Sales and VAT to customers registered for VAT:&nbsp;&nbsp;{{currency}}</td>
                                                                    <td class="somepad cl-444 fw-600 text-right bd-right bd-left no-bottom-bd">{{format_money(transaction.loc_customer_excl_total)}}</td>
                                                                    <td class="somepad cl-444 fw-600 text-right bd-right bd-left no-bottom-bd">{{format_money(transaction.loc_customer_incl_total)}}</td>
                                                                    <td class="somepad cl-444 fw-600 text-right bd-right bd-left no-bottom-bd">{{format_money(transaction.loc_customer_vat_total)}}</td>
                                                                </tr>
                                                                <tr v-if="transaction.output_tax.length">
                                                                    <td class="somepad cl-444 text-right no-bottom-bd" colspan="5">Total Sales and VAT to customers not registered for VAT:&nbsp;&nbsp;{{currency}}</td>
                                                                    <td class="somepad cl-444 fw-600 text-right bd-left bd-right no-bottom-bd">{{format_money(transaction.int_customer_excl_total)}}</td>
                                                                    <td class="somepad cl-444 fw-600 text-right bd-left bd-right no-bottom-bd">{{format_money(transaction.int_customer_incl_total)}}</td>
                                                                    <td class="somepad cl-444 fw-600 text-right bd-right no-bottom-bd">{{format_money(transaction.int_customer_vat_total)}}</td>
                                                                </tr>
                                                                <tr v-if="transaction.output_tax.length">
                                                                    <td class="somepad cl-444 text-right no-bottom-bd" colspan="5">Total for {{transaction.name+' '+transaction.category}}:&nbsp;&nbsp;{{currency}}</td>
                                                                    <td class="somepad cl-444 fw-600 text-right bd-left bd-right">{{format_money(transaction.excl_total)}}</td>
                                                                    <td class="somepad cl-444 fw-600 text-right bd-left bd-right">{{format_money(transaction.incl_total)}}</td>
                                                                    <td class="somepad cl-444 fw-600 text-right bd-right">{{format_money(transaction.vat_total)}}</td>
                                                                </tr>
                                                            </tbody>

                                                            <!-- Inputs Tax Block | Detailed -->
                                                            <tbody v-if="tax_return.total_input_transactions">
                                                                <tr>
                                                                    <td class="somepad cl-amref fw-600 no-bottom-bd fs-16" colspan="8">Input Tax</td>
                                                                </tr>
                                                            </tbody>
                                                            <tbody v-for="(transaction,index) in tax_return.transactions" :key="'transactions_input_'+index">
                                                                <tr v-if="transaction.input_tax.length && index>0">
                                                                    <td class="somepad cl-444 fw-600 tr-separator" colspan="8"></td>
                                                                </tr>
                                                                <tr v-if="transaction.input_tax.length">
                                                                    <td class="somepad cl-444 fw-600 sub-header-dark bd-right bd-left" colspan="8">{{transaction.display_as}} - Input Tax</td>
                                                                </tr>
                                                                <tr v-for="(input_transaction,index_trs) in transaction.input_tax" :key="'index_trs_'+index_trs">
                                                                    <td v-bind:class="{'somepad bd-left':true,'no-bottom-bd':index_trs!==transaction.input_tax.length-1}">{{input_transaction.trans_date}}</td>
                                                                    <td v-bind:class="{'somepad':true,'no-bottom-bd':index_trs!==transaction.input_tax.length-1}">{{input_transaction.creditor_debtor_account.legal_name}}</td>
                                                                    <td v-bind:class="{'somepad':true,'no-bottom-bd':index_trs!==transaction.input_tax.length-1}">{{input_transaction.trans_number}}</td>
                                                                    <td v-bind:class="{'somepad':true,'no-bottom-bd':index_trs!==transaction.input_tax.length-1}">{{input_transaction.description}}</td>
                                                                    <td v-bind:class="{'somepad bd-right':true,'no-bottom-bd':index_trs!==transaction.input_tax.length-1}">{{input_transaction.vat_period}}</td>
                                                                    <td v-bind:class="{'somepad text-right bd-right':true,'no-bottom-bd':index_trs!==transaction.input_tax.length-1}">{{format_money(input_transaction.exclusive)}}</td>
                                                                    <td v-bind:class="{'somepad text-right bd-right':true,'no-bottom-bd':index_trs!==transaction.input_tax.length-1}">{{format_money(input_transaction.inclusive)}}</td>
                                                                    <td v-bind:class="{'somepad text-right bd-right':true,'no-bottom-bd':index_trs!==transaction.input_tax.length-1}">{{format_money(input_transaction.vat_amount)}}</td>
                                                                </tr>
                                                                <tr class="notes" v-if="transaction.input_tax.length">
                                                                    <td class="somepad cl-444 fw-600 text-right bd-left bd-right" colspan="5">
                                                                        Puchase and Input Tax on Purchase for the period {{tax_return.vat_period+' ( '+transaction.display_as+' )'}}
                                                                    </td>
                                                                    <td class="somepad cl-444 fw-600 text-right bd-left bd-right" colspan="3"></td>
                                                                </tr>
                                                                <tr v-if="transaction.input_tax.length">
                                                                    <td class="somepad cl-444 text-right no-bottom-bd bd-right" colspan="5">Total purchases from Suppliers registered for VAT(Local):&nbsp;&nbsp;{{currency}}</td>
                                                                    <td class="somepad cl-444 fw-600 text-right bd-right bd-left no-bottom-bd">{{format_money(transaction.loc_supplier_excl_total)}}</td>
                                                                    <td class="somepad cl-444 fw-600 text-right bd-right bd-left no-bottom-bd">{{format_money(transaction.loc_supplier_incl_total)}}</td>
                                                                    <td class="somepad cl-444 fw-600 text-right bd-right bd-left no-bottom-bd">{{format_money(transaction.loc_supplier_vat_total)}}</td>
                                                                </tr>
                                                                <tr v-if="transaction.input_tax.length">
                                                                    <td class="somepad cl-444 text-right no-bottom-bd" colspan="5">Total purchases from Suppliers not registered for VAT(Import):&nbsp;&nbsp;{{currency}}</td>
                                                                    <td class="somepad cl-444 fw-600 text-right bd-left bd-right no-bottom-bd">{{format_money(transaction.int_supplier_excl_total)}}</td>
                                                                    <td class="somepad cl-444 fw-600 text-right bd-left bd-right no-bottom-bd">{{format_money(transaction.int_supplier_incl_total)}}</td>
                                                                    <td class="somepad cl-444 fw-600 text-right bd-right no-bottom-bd">{{format_money(transaction.int_supplier_vat_total)}}</td>
                                                                </tr>
                                                                <tr v-if="transaction.input_tax.length">
                                                                    <td class="somepad cl-444 text-right no-bottom-bd" colspan="5">Total for {{transaction.name+' '+transaction.category}}:&nbsp;&nbsp;{{currency}}</td>
                                                                    <td class="somepad cl-444 fw-600 text-right bd-left bd-right">{{format_money(transaction.excl_total)}}</td>
                                                                    <td class="somepad cl-444 fw-600 text-right bd-left bd-right">{{format_money(transaction.incl_total)}}</td>
                                                                    <td class="somepad cl-444 fw-600 text-right bd-right">{{format_money(transaction.vat_total)}}</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    
                                                    <!-- Input Sub Summary Block -->
                                                    <div v-if="tax_return.total_input_transactions || tax_return.total_output_transactions" class="width-100-pc float-left">
                                                        <table v-if="tax_return.total_output_transactions" class="table banking-transaction-vat-reports table-hover mg-bottom-20">
                                                            <thead>
                                                                <tr>
                                                                    <th colspan="4" class="somepad cl-444 fw-600 sub-header-amref text-center">Sales(Goods and Services)</th>
                                                                </tr>
                                                            </thead>
                                                            <thead>
                                                                <tr>
                                                                    <th style="width:55%;" class="somepad-1 fw-600 text-right">Details of Sales</th>
                                                                    <th style="width:15%" class="somepad-1 fw-600 text-right">Exclusive(KES)</th>
                                                                    <th style="width:15%" class="somepad-1 fw-600 text-right">Inclusive(KES)</th>
                                                                    <th style="width:15%" class="somepad-1 fw-600 text-right">Output VAT(KES)</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody v-for="(transa,indexs) in tax_return.transactions" :key="'indexs_'+indexs">
                                                                <tr v-if="transa.output_tax.length">
                                                                    <td v-bind:class="{'somepad bd-left text-right bd-right':true,'no-bottom-bd':indexs!==tax_return.transactions.length-1}">
                                                                        <span v-if="transa.sales_rate > 0">Taxable Sales ({{transa.name}})</span>
                                                                        <span v-else>Sales ({{transa.name}})</span>
                                                                    </td>
                                                                    <td v-bind:class="{'somepad text-right bd-right':true,'no-bottom-bd':indexs!==tax_return.transactions.length-1}">{{format_money(transa.excl_total)}}</td>
                                                                    <td v-bind:class="{'somepad text-right bd-right':true,'no-bottom-bd':indexs!==tax_return.transactions.length-1}">{{format_money(transa.incl_total)}}</td>
                                                                    <td v-bind:class="{'somepad text-right bd-right':true,'no-bottom-bd':indexs!==tax_return.transactions.length-1}">{{format_money(transa.vat_total)}}</td>
                                                                </tr>
                                                            </tbody>
                                                            <tbody>
                                                                <tr>
                                                                    <td class="somepad cl-444 text-right no-bottom-bd fw-600">Total Output VAT</td>
                                                                    <td class="somepad cl-444 fw-600 text-right bd-left bd-right">{{format_money(tax_return.total_sales_excl)}}</td>
                                                                    <td class="somepad cl-444 fw-600 text-right bd-left bd-right">{{format_money(tax_return.total_sales_incl)}}</td>
                                                                    <td class="somepad cl-444 fw-600 text-right bd-right">{{format_money(tax_return.total_output_tax)}}</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>

                                                        <table v-if="tax_return.total_input_transactions" class="table banking-transaction-vat-reports table-hover mg-bottom-20">
                                                            <thead>
                                                                <tr>
                                                                    <th colspan="4" class="somepad cl-444 fw-600 sub-header-amref text-center">Purchases(Goods and Services)</th>
                                                                </tr>
                                                            </thead>
                                                            <thead>
                                                                <tr>
                                                                    <th style="width:55%;" class="somepad-1 fw-600 text-right">Details of Purchases</th>
                                                                    <th style="width:15%" class="somepad-1 fw-600 text-right">Exclusive(KES)</th>
                                                                    <th style="width:15%" class="somepad-1 fw-600 text-right">Inclusive(KES)</th>
                                                                    <th style="width:15%" class="somepad-1 fw-600 text-right">Input VAT (KES)</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody v-for="(transa,indexs) in tax_return.transactions" :key="'indexs_'+indexs">
                                                                <tr v-if="transa.input_tax.length">
                                                                    <td v-bind:class="{'somepad bd-left text-right bd-right':true,'no-bottom-bd':indexs!==tax_return.transactions.length-1}">
                                                                        <span v-if="transa.purchase_rate > 0">Taxable Purchases ({{transa.name}})</span>
                                                                        <span v-else>Purchases ({{transa.name}})</span>
                                                                    </td>
                                                                    <td v-bind:class="{'somepad text-right bd-right':true,'no-bottom-bd':indexs!==tax_return.transactions.length-1}">{{format_money(transa.excl_total)}}</td>
                                                                    <td v-bind:class="{'somepad text-right bd-right':true,'no-bottom-bd':indexs!==tax_return.transactions.length-1}">{{format_money(transa.incl_total)}}</td>
                                                                    <td v-bind:class="{'somepad text-right bd-right':true,'no-bottom-bd':indexs!==tax_return.transactions.length-1}">{{format_money(transa.vat_total)}}</td>
                                                                </tr>
                                                            </tbody>
                                                            <tbody>
                                                                <tr>
                                                                    <td class="somepad cl-444 text-right no-bottom-bd fw-600">Total Input VAT</td>
                                                                    <td class="somepad cl-444 fw-600 text-right bd-left bd-right">{{format_money(tax_return.total_purchases_excl)}}</td>
                                                                    <td class="somepad cl-444 fw-600 text-right bd-left bd-right">{{format_money(tax_return.total_purchases_incl)}}</td>
                                                                    <td class="somepad cl-444 fw-600 text-right bd-right">{{format_money(tax_return.total_input_tax)}}</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>

                                                        <table v-if="tax_return.total_input_transactions" class="table banking-transaction-vat-reports table-hover mg-bottom-20">
                                                            <thead>
                                                                <tr>
                                                                    <th colspan="4" class="somepad cl-444 fw-600 sub-header-amref text-center">VAT Summary</th>
                                                                </tr>
                                                            </thead>
                                                            <thead>
                                                                <tr>
                                                                    <th style="width:55%;" class="somepad-1 fw-600 text-right">Description</th>
                                                                    <th style="width:45%" class="somepad-1 fw-600 text-right">Amount(KES)</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td class="somepad bd-right bd-left text-right">Output VAT</td>
                                                                    <td class="somepad text-right bd-right">{{format_money(tax_return.total_output_tax)}}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="somepad bd-right bd-left text-right">Input VAT</td>
                                                                    <td class="somepad text-right bd-right">{{format_money(tax_return.total_input_tax)}}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="somepad bd-right bd-left text-right">Amount Refundable</td>
                                                                    <td class="somepad text-right bd-right">{{format_money(tax_return.vat_refundable)}}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="somepad bd-right bd-left text-right">VAT Payments and Refunds for the period ({{tax_return.vat_period}})</td>
                                                                    <td class="somepad text-right bd-right">{{format_money(tax_return.payment_and_refunds)}}</td>
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
    import {ACCOUNTS_TAX_RETURNS} from '../../../../../router/api_routes';
    export default {
        name: "CoaTransaction",
        components: {TopNavBar,SideBar,SalesReceiptPreview,BillPreview,
        ProcessingOverlay,CopyRight},
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
                ACCOUNT_NATURES: ACCOUNTING.ACCOUNT_NATURES,
                customer_receipt: TRANSACTION_TYPES.CUSTOMER_RECEIPT,
                supplier_bill: TRANSACTION_TYPES.SUPPLIER_BILL,

                tax_return:{},
                tax_returns:[],
                report_options: {
                    options: false,
                    vat_period: null,
                    vat_type: null,
                    vat_style: null,
                    vat_basis: null,
                    vat_period: null,
                    vat_include: null,
                }
            }
        },
        methods: {

            format_money(money_to){
                return formatMoney(money_to);
            },

            toggleOptions(option_){
                this.report_options.options = option_;
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

            // loadCoa(state_){
            //     this.is_initializing = state_;
            //     get(CHART_OF_ACCOUNTS+'/2368f0d0-d2d1-4c56-b429-e21ab16b0646')
            //     .then((res) => {
            //         if(res.data.status_code === 200) {
            //             //console.info(res.data.results.data);
            //             this.report_transactions = res.data.results.data.transactions;
            //             this.chart_of_account = res.data.results.data;
            //             this.as_at = res.data.results.filters.date_range;
            //             this.is_initializing = false;
            //             this.page_ready = true;
            //         }
            //     }).catch((err) => {
            //         this.is_initializing = false;
            //     });
            // },

            loadReturns(){
                this.is_initializing = true;
                get(ACCOUNTS_TAX_RETURNS)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.tax_returns = res.data.results.data;
                        this.vat_period_summary = res.data.results.vat_period_summary;
                        this.filters = res.data.results.filters;
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

            loadReturn(){
                this.is_initializing = true;
                get(ACCOUNTS_TAX_RETURNS+'/'+this.$route.params.uuid)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.tax_return = res.data.results;
                        this.page_ready  = true;
                        this.is_initializing = false;
                        console.info(this.tax_return);
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
            this.is_initializing = true;
            this.loadReturn(true);
        }
    }
</script>

<style lang="scss">
    th {
        position: sticky;
        top: 0px;
    }
</style>