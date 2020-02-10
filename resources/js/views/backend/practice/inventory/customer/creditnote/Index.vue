<template>

    <div>

        <!-- <processing-overlay :message="msg" :status="progress_overlay"></processing-overlay> -->

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
                                            <div class="col-md-10 col-lg-10 padding-right-0 border-bottom">
                                                <div :hidden="credit_notes.length===0 && default_filter==='All'" class="width-100-pc float-left">
                                                    <div class="width-40-pc float-left">
                                                        <div class="btn-group" role="group" aria-label="Button group">
                                                            <div class="btn-group" role="group">
                                                                <a :id="'btnGroupDrop2_1'" class="dropdown-toggle fs-14 pointer-cursor fw-600 txt-uppercase" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                    {{default_filter}} Credit Notes ({{pagination.total}})
                                                                </a>
                                                                <div class="dropdown-menu" :aria-labelledby="'btnGroupDrop2_1'">
                                                                    <a class="dropdown-item pointer-cursor">Created Time</a>
                                                                    <a class="dropdown-item pointer-cursor">Date</a>
                                                                    <a class="dropdown-item pointer-cursor">Invoives#</a>
                                                                    <a class="dropdown-item pointer-cursor">Customer Name</a>
                                                                    <a class="dropdown-item pointer-cursor">Due Date</a>
                                                                    <a class="dropdown-item pointer-cursor">Amount</a>
                                                                    <a class="dropdown-item pointer-cursor">Balance Due</a>
                                                                    <a class="dropdown-item separator"></a>
                                                                    <a class="dropdown-item pointer-cursor">Import Invoives</a>
                                                                    <a class="dropdown-item pointer-cursor">Export Invoives</a>
                                                                    <a class="dropdown-item separator"></a>
                                                                    <a class="dropdown-item pointer-cursor">Refresh List</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="width-100-pc float-left mg-top-30 mg-bottom-50">
                                                    
                                                    <div v-if="page_ready && credit_notes.length===0" class="width-100-pc float-left mg-top-10 mg-bottom-50 text-center">
                                                        <div class="width-100-pc text-center float-left">
                                                            <a class="fs-15 txt-uppercase cl-444 fw-600">Credit Notes</a><br>
                                                            <a class="fs-14 cl-444">Refunds and Credits.</a><br>
                                                            <small class="fs-13 cl-777">Issue refunds and credits to your customers and apply them to invoices</small><br><br>
                                                            <a data-toggle="modal" data-target="#new_credit_note_modal" class="btn btn-secondary banking-process-amref">New Credit Note</a>
                                                        </div>
                                                        <div class="width-100-pc text-center float-left mg-top-20">
                                                            <img src="/assets/icons/dashboard/credit_note_cycle.png" class=" mg-bottom-20">
                                                        </div>
                                                    </div>
                                                    <div v-else-if="page_ready && credit_notes.length>0" class="width-100-pc float-left mg-top-30 mg-bottom-50">
                                                        <div class="width-45-pc float-left mg-right-15 mg-bottom-15">
                                                            <div class="width-60-pc float-left">
                                                                <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                                    <input placeholder="Search..." :disabled="is_initializing || processing" type="text">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="width-25-pc float-right mg-bottom-15">
                                                            <div class="btn-group float-right" role="group">
                                                                <button :disabled="is_initializing || processing" :id="'btnGroupDrop2_1'" class="dropdown-toggle btn btn-secondary banking-process-amref" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                    New Transaction
                                                                </button>
                                                                <div class="dropdown-menu" :aria-labelledby="'btnGroupDrop2_1'">
                                                                    <a data-toggle="modal" data-target="#new_estimate_modal" class="dropdown-item pointer-cursor">Estimate</a>
                                                                    <a data-toggle="modal" data-target="#new_bill_id" class="dropdown-item pointer-cursor">Retainer Invoice</a>
                                                                    <a data-toggle="modal" data-target="#new_sales_order_modal" class="dropdown-item pointer-cursor">Sales Order</a>
                                                                    <a data-toggle="modal" data-target="#new_sales_receipt_modal" class="dropdown-item pointer-cursor">Sales Receipt</a>
                                                                    <a data-toggle="modal" data-target="#create_invoice_modal" class="dropdown-item pointer-cursor">Tax Invoice</a>
                                                                    <a data-toggle="modal" data-target="#new_credit_note_modal" class="dropdown-item pointer-cursor">Credit Note</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div id="po_list_id_0" class="width-100-pc float-left">
                                                            <table class="table banking-transaction table-hover mg-bottom-5">        
                                                                <thead>
                                                                    <tr>
                                                                        <th style="width:2%;">
                                                                            <input :disabled="is_initializing || processing" type="checkbox" class="pointer-cursor" @click="check_all($event)">
                                                                        </th>
                                                                        <th style="width:23%">Customer</th>
                                                                        <th style="width:15%">Date</th>
                                                                        <th style="width:15%;">Credit Note#</th>
                                                                        <th style="width:15%;">Status</th>
                                                                        <th style="width:15%;" class="text-right">Amount({{currency}})</th>
                                                                        <th style="width:15%;" class="text-right">Balance({{currency}})</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody v-if="processing || is_initializing">
                                                                    <tr>
                                                                        <td class="somepad text-center" colspan="7">
                                                                            <img src="/assets/icons/dashboard/loader.gif">
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                                <tbody v-for="(salesr,index) in credit_notes" :key="'chart_of_accounts_'+index">
                                                                    <tr>
                                                                        <td class="somepad">
                                                                            <input :disabled="is_initializing || processing" v-model="selected_sales_receipts" type="checkbox" class="pointer-cursor" :value="salesr.id">
                                                                        </td>
                                                                        <router-link tag="td" :to="CREDIT_NOTES+'/'+salesr.id+'/view'" class="somepad pointer-cursor">
                                                                            <span v-if="salesr.customer">{{salesr.customer.legal_name}}</span>
                                                                        </router-link>
                                                                        <router-link tag="td" :to="CREDIT_NOTES+'/'+salesr.id+'/view'" class="somepad pointer-cursor">
                                                                            {{salesr.trans_date}}
                                                                        </router-link>
                                                                        <router-link tag="td" :to="CREDIT_NOTES+'/'+salesr.id+'/view'" class="somepad pointer-cursor">
                                                                            {{salesr.trans_number}}
                                                                        </router-link>
                                                                        <router-link tag="td" :to="CREDIT_NOTES+'/'+salesr.id+'/view'" class="somepad pointer-cursor">
                                                                            <a v-if="salesr.status[salesr.status.length-1].status===PROCESS_STATUS.ACCEPTED" class="txt-uppercase fs-12 fw-600 cl-success-light">Accepted</a>
                                                                            <a v-else-if="salesr.status[salesr.status.length-1].status===PROCESS_STATUS.DRAFT" class="documentStatus draft">{{PROCESS_STATUS.DRAFT}}</a>
                                                                            <a v-else-if="salesr.status[salesr.status.length-1].status===PROCESS_STATUS.UNPAID" class="documentStatus unpaid">{{PROCESS_STATUS.UNPAID}}</a>
                                                                            <a v-else-if="salesr.status[salesr.status.length-1].status===PROCESS_STATUS.DECLINED" class="txt-uppercase fs-12 fw-600 cl-amref">Declined</a>
                                                                            <a v-else-if="salesr.status[salesr.status.length-1].status===PROCESS_STATUS.EXPIRED" class="txt-uppercase fs-12 fw-600 cl-787887">Expired</a>
                                                                            <a v-else-if="salesr.status[salesr.status.length-1].status===PROCESS_STATUS.INVOICED" class="txt-uppercase fs-12 fw-600 cl-success-light">Invoiced</a>
                                                                            <a v-else-if="salesr.status[salesr.status.length-1].status===PROCESS_STATUS.PAID" class="documentStatus paid">{{PROCESS_STATUS.PAID}}</a>
                                                                            <a v-else-if="salesr.status[salesr.status.length-1].status===PROCESS_STATUS.PARTIAL_PAID" class="documentStatus paid">{{PROCESS_STATUS.PARTIAL_PAID}}</a>
                                                                            <a v-else-if="salesr.status[salesr.status.length-1].status===PROCESS_STATUS.SENT" class="txt-uppercase fs-12 fw-600 cl-blue-link">Sent</a>
                                                                            <a v-else-if="salesr.status[salesr.status.length-1].status===PROCESS_STATUS.OPEN" class="documentStatus open">{{PROCESS_STATUS.OPEN}}</a>
                                                                            <a v-else-if="salesr.status[salesr.status.length-1].status===PROCESS_STATUS.CLOSED" class="documentStatus closed">{{PROCESS_STATUS.CLOSED}}</a>
                                                                            <a v-else-if="salesr.status[salesr.status.length-1].status===PROCESS_STATUS.PENDING_APPROVAL" class="documentStatus pending">{{PROCESS_STATUS.PENDING_APPROVAL}}</a>
                                                                            <a v-else="" class="documentStatus pending">Pending</a>
                                                                        </router-link>
                                                                        <router-link tag="td" :to="CREDIT_NOTES+'/'+salesr.id+'/view'" class="somepad pointer-cursor text-right fw-600">
                                                                            {{format_money(salesr.net_total)}}
                                                                        </router-link>
                                                                        <router-link tag="td" :to="CREDIT_NOTES+'/'+salesr.id+'/view'" class="somepad pointer-cursor text-right fw-600">
                                                                            {{format_money(salesr.due_balance)}}
                                                                        </router-link>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <div class="width-20-pc float-left">
                                                            <div class="btn-group" role="group">
                                                                <button :disabled="is_initializing || processing || selected_sales_receipts.length===0 " :id="'btnGroupDrop2_1'" class="dropdown-toggle btn btn-secondary banking-process-amref" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                    <span v-if="selected_sales_receipts.length">{{selected_sales_receipts.length}} salesorders selected</span>
                                                                    <span v-else>Batch Action</span>
                                                                </button>
                                                                <div class="dropdown-menu" :aria-labelledby="'btnGroupDrop2_1'">
                                                                    <!-- <a data-toggle="modal" data-target="#" class="dropdown-item pointer-cursor fs-12">Add Bill</a>
                                                                    <a class="dropdown-item separator"></a>
                                                                    <a data-toggle="modal" data-target="#" class="dropdown-item pointer-cursor fs-12">Update status</a>
                                                                    <a data-toggle="modal" data-target="#" class="dropdown-item pointer-cursor fs-12">Copy Purchase Order</a>
                                                                    <a class="dropdown-item separator"></a>
                                                                    <a data-toggle="modal" data-target="#" class="dropdown-item pointer-cursor fs-12">Delete</a> -->
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="width-80-pc float-right text-right">
                                                            <paginate-template v-if="pagination.last_page > 1" :pagination="pagination" :offset="5" @paginate="filterItems('Page')" :custom="true"></paginate-template>
                                                        </div>
                                                    </div>
                                                    <div v-else class="width-100-pc float-left mg-top-60 text-center">
                                                        <img class="loader" src="/assets/icons/dashboard/loader.gif">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row justify-content-center">
                                            <div class="col-md-12 col-lg-12 padding-right-0 border-bottom">
                                                <invoice-modal v-if="page_ready" :modal_title="'New Customer Invoice'" :invoice_type="'Non-Recurring'" :customers="customers" :modal_id="'create_invoice_modal'" :bank_accounts="bank_accounts" :payment_terms="payment_terms" :filters="filters" :taxations="taxations" :currency="currency" :customer_invoice_api="CUSTOMERS_CREDIT_NOTES_API" @create-salesorder-event="goTo(SALES_RECEIPTS)"></invoice-modal>
                                                <sales-order-modal v-if="page_ready" :modal_title="'New Sales Order'" :customers="customers" :modal_id="'new_sales_order_modal'" :payment_terms="payment_terms" :filters="filters" :taxations="taxations" :currency="currency" :sales_order_api="CUSTOMERS_CREDIT_NOTES_API" @create-salesorder-event="loadSalesorders(true)"></sales-order-modal>
                                                <sales-receipt-modal v-if="page_ready" :modal_title="'Sales Receipt'" :customers="customers" :bank_accounts="bank_accounts" :modal_id="'new_sales_receipt_modal'" :payment_terms="payment_terms" :filters="filters" :taxations="taxations" :currency="currency" :sales_receipt_api="CUSTOMERS_CREDIT_NOTES_API" @create-sales-receipt-event="loadCreditNotes(true)"></sales-receipt-modal>
                                                <credit-note-modal v-if="page_ready" :modal_title="'New Credit Note'" :customers="customers" :bank_accounts="bank_accounts" :modal_id="'new_credit_note_modal'" :payment_terms="payment_terms" :filters="filters" :taxations="taxations" :currency="currency" :credit_note_api="CUSTOMERS_CREDIT_NOTES_API" @create-sales-receipt-event="loadCreditNotes(true)"></credit-note-modal>
                                                <estimate-modal v-if="page_ready" :modal_title="'New Estimate'" :customers="customers" :modal_id="'new_estimate_modal'" :payment_terms="payment_terms" :filters="filters" :taxations="taxations" :currency="currency" :estimate_api="CUSTOMERS_ESTIMATES_API" @create-estimate-event="loadEstimates(true)"></estimate-modal>
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
</template>

<script>
    import SideBar from "../../../partials/sidebars/SideBar";
    import TopNavBar from "../../../partials/topbars/TopNavBar";
    import PaginateTemplate from '../../../partials/pagination/PaginateTemplate';
    import CopyRight from '../../../partials/CopyRight';
    import DeleteModal from "../../../partials/modals/DeleteModal";
    import ProcessingOverlay from "../../../../../progress/ProcessingOverlay";
    import {get, post} from "../../../../../../helpers/api";
    import Auth from "../../../../../../store/auth";
    //import PoModal from "../../../partials/modals/purchase/PoModal";
    import EstimateModal from "../../../partials/modals/customer/EstimateModal";
    import SalesOrderModal from "../../../partials/modals/customer/SalesOrderModal";
    import InvoiceModal from "../../../partials/modals/customer/InvoiceModal";
    import SalesReceiptModal from "../../../partials/modals/customer/SalesReceiptModal";
    import CreditNoteModal from "../../../partials/modals/customer/CreditNoteModal"
    // import QuickLink from "../partials/QuickLink";

    import {INVENTORY_WEB_ROUTES} from "../../../../../../router/web_routes";
    import {removeElement,paginator,formatMoney, createHtmlErrorString} from "../../../../../../helpers/functionmixin";
    import {AC_TYPES, PROCESS_STATUS,ACCOUNTING,TRANSACTION_TYPES} from "../../../../../../helpers/process_status";
    import {CUSTOMERS_CREDIT_NOTES_API,CUSTOMERS_INVOICES_API,PRODUCT_TAX_URL,CHART_OF_ACCOUNTS, CUSTOMERS_API,CUSTOMERS_TERMS_API,CUSTOMERS_ESTIMATES_API, BANKING_ACCOUNTS_URL} from '../../../../../../router/api_routes';
    export default {
        name: "Index",
        components: {TopNavBar,PaginateTemplate,SideBar,DeleteModal,CopyRight,EstimateModal,SalesOrderModal,
        ProcessingOverlay,InvoiceModal,SalesReceiptModal,CreditNoteModal},
        data(){
            return {
                
                selected_sales_receipts: [],
                pagination: paginator(),
                currency: ACCOUNTING.CURRENCY,
                PROCESS_STATUS: PROCESS_STATUS,
                filters: {},
                customers: [],
                taxations: [],
                bank_accounts: [],
                payment_terms: [],
                page_ready: false,
                is_initializing: false,
                processing: false,
                QUOTE_URL: INVENTORY_WEB_ROUTES.SALES.QUOTE,
                SALES_ORDER_URL: INVENTORY_WEB_ROUTES.SALES.SALES_ORDERS,
                SALES_RECEIPTS: INVENTORY_WEB_ROUTES.SALES.SALES_RECEIPTS,
                salesorders: [],
                //bank_accounts: [],
                credit_notes: [],
                default_filter: 'All',
                default_api: CUSTOMERS_CREDIT_NOTES_API+'?page=1',
                CUSTOMERS_CREDIT_NOTES_API:CUSTOMERS_CREDIT_NOTES_API,
                CUSTOMERS_ESTIMATES_API: CUSTOMERS_ESTIMATES_API,
                CREDIT_NOTES: INVENTORY_WEB_ROUTES.SALES.CREDIT_NOTES,
            }
        },
        watch: {
            default_api: function(){
                this.loadEstimates(true);
            }
        },
        methods: {

            check_all(event){
                this.selected_sales_receipts = [];
                if(event.target.checked){
                    for (let index = 0; index < this.salesorders.length; index++) {
                        const element = this.salesorders[index];
                        this.selected_sales_receipts.push(element.id);
                    }
                }
            },

            format_money(money_to){
                return formatMoney(money_to);
            },

            filterItems(filter_by='All'){
                switch (filter_by) {
                    case PROCESS_STATUS.CANCELLED:
                    case PROCESS_STATUS.CLOSED:
                    case PROCESS_STATUS.PARTIAL_BILLED:
                    case PROCESS_STATUS.BILLED:
                    case PROCESS_STATUS.OPEN:
                    case PROCESS_STATUS.DRAFT:
                    case PROCESS_STATUS.PENDING_APPROVAL:
                    case PROCESS_STATUS.APPROVED:
                    case PROCESS_STATUS.PAID:
                    case PROCESS_STATUS.UNPAID:
                    case PROCESS_STATUS.UNPAID:
                    case PROCESS_STATUS.VOID:
                    case PROCESS_STATUS.OVERDUE:
                    case PROCESS_STATUS.PARTIAL_PAID:
                        this.default_filter = filter_by;
                        this.default_api = CUSTOMERS_CREDIT_NOTES_API+'?page='+this.pagination.current_page+'&filter_by='+this.default_filter+'';
                        break;
                    case "Page":
                        if(this.default_filter==='All'){
                            this.default_api = CUSTOMERS_CREDIT_NOTES_API+'?page='+this.pagination.current_page+'';
                        }else{
                            this.default_api = CUSTOMERS_CREDIT_NOTES_API+'?page='+this.pagination.current_page+'&filter_by='+this.default_filter+'';
                        }
                        break;
                    default:
                        this.default_filter = filter_by;
                        this.default_api = CUSTOMERS_CREDIT_NOTES_API+'?page='+this.pagination.current_page+'';
                        break;
                }
            },

            loadCustomers(){
                get(CUSTOMERS_API)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.customers = res.data.results.data;
                        this.loadTaxes();
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
                });
            },

            loadBankAccount(){
                get(BANKING_ACCOUNTS_URL)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.bank_accounts = res.data.results.data;
                        this.loadCreditNotes();
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
                });
            },

            loadCreditNotes(show_progress=false){
                this.is_initializing = show_progress;
                get(this.default_api)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.credit_notes = res.data.results.data;
                        this.filters = res.data.results.filters;
                        this.pagination = res.data.results.pagination;
                        console.info(this.credit_notes);
                        this.page_ready = true;
                        this.progress_overlay = "hide";
                        this.page_ready = true;
                        this.is_initializing = false;
                        this.processing = false;
                    }
                }).catch((err) => {
                    this.progress_overlay = "hide";
                    this.page_ready = true;
                });
            },

            loadTerms(){
                get(CUSTOMERS_TERMS_API)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.payment_terms = res.data.results.data;
                        this.loadBankAccount();
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
                });
            },

            loadTaxes(){
                get(PRODUCT_TAX_URL+'?output_tax=ok')
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.taxations = res.data.results.data;
                        //this.loadTerms();
                        this.loadBankAccount();
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
                });
            },

        },

        mounted() {
            this.is_initializing = true;
            this.loadCustomers();
        }
    }
</script>

<style lang="scss">
    th {
        position: sticky;
        top: 0px;
    }
</style>