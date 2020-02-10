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
                                                <div :hidden="receipts.length===0 && default_filter==='All'" class="width-100-pc float-left">
                                                    <div class="width-40-pc float-left">
                                                        <div class="btn-group" role="group" aria-label="Button group">
                                                            <div class="btn-group" role="group">
                                                                <a :id="'btnGroupDrop2_1'" class="dropdown-toggle fs-14 pointer-cursor fw-600 txt-uppercase" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                    {{default_filter}} Payment Received({{pagination.total}})
                                                                </a>
                                                                <div class="dropdown-menu" :aria-labelledby="'btnGroupDrop2_1'">
                                                                    <!-- <a @click="filterItems('All')" class="dropdown-item pointer-cursor">All</a>
                                                                    <a @click="filterItems(PROCESS_STATUS.DRAFT)" class="dropdown-item pointer-cursor">{{PROCESS_STATUS.DRAFT}}</a>
                                                                    <a @click="filterItems(PROCESS_STATUS.PENDING_APPROVAL)" class="dropdown-item pointer-cursor">{{PROCESS_STATUS.PENDING_APPROVAL}}</a>
                                                                    <a @click="filterItems(PROCESS_STATUS.OPEN)" class="dropdown-item pointer-cursor">{{PROCESS_STATUS.OPEN}}</a>
                                                                    <a @click="filterItems(PROCESS_STATUS.OVERDUE)" class="dropdown-item pointer-cursor">{{PROCESS_STATUS.OVERDUE}}</a>
                                                                    <a @click="filterItems(PROCESS_STATUS.UNPAID)" class="dropdown-item pointer-cursor">{{PROCESS_STATUS.UNPAID}}</a>
                                                                    <a @click="filterItems(PROCESS_STATUS.PARTIAL_PAID)" class="dropdown-item pointer-cursor">{{PROCESS_STATUS.PARTIAL_PAID}}</a>
                                                                    <a @click="filterItems(PROCESS_STATUS.PAID)" class="dropdown-item pointer-cursor">{{PROCESS_STATUS.PAID}}</a>
                                                                    <a @click="filterItems(PROCESS_STATUS.VOID)" class="dropdown-item pointer-cursor">{{PROCESS_STATUS.VOID}}</a>
                                                                    <a class="dropdown-item separator"></a>
                                                                    <a class="dropdown-item pointer-cursor">New Custom view</a> -->
                                                                    <a class="dropdown-item pointer-cursor">Created Time</a>
                                                                    <a class="dropdown-item pointer-cursor">Date</a>
                                                                    <a class="dropdown-item pointer-cursor">Payment#</a>
                                                                    <a class="dropdown-item pointer-cursor">Customer Name</a>
                                                                    <a class="dropdown-item pointer-cursor">Mode</a>
                                                                    <a class="dropdown-item pointer-cursor">Amount</a>
                                                                    <a class="dropdown-item pointer-cursor">Unused Amount</a>
                                                                    <a class="dropdown-item separator"></a>
                                                                    <a class="dropdown-item pointer-cursor">Import Payments</a>
                                                                    <a class="dropdown-item pointer-cursor">Import Retainer Payments</a>
                                                                    <a class="dropdown-item pointer-cursor">Export Payments</a>
                                                                    <a class="dropdown-item separator"></a>
                                                                    <a class="dropdown-item pointer-cursor">Refresh List</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="width-100-pc float-left mg-top-30 mg-bottom-50">
                                                    <div v-if="page_ready && receipts.length===0" class="width-100-pc float-left mg-top-10 mg-bottom-50 text-center">
                                                        <div class="width-100-pc text-center float-left">
                                                            <a class="fs-15 txt-uppercase cl-444 fw-600">Payment Received</a><br>
                                                            <small class="fs-13 cl-777">No payments have been made for your invoices. Payments will show up once the invoices get paid.</small><br><br>
                                                            <router-link :to="CUSTOMER_INVOICES+'?status='+PROCESS_STATUS.UNPAID" class="btn btn-secondary banking-process">Go to Unpaid Invoice</router-link>
                                                            <a data-toggle="modal" data-target="#new_customer_receipt_modal" class="btn btn-secondary banking-process-amref">New Payment</a>
                                                        </div>
                                                        <div class="width-100-pc text-center float-left mg-top-20">
                                                            <img src="/assets/icons/dashboard/payment_cycle.png" class=" mg-bottom-20">
                                                        </div>
                                                    </div>
                                                    <div v-else-if="page_ready && receipts.length>0" class="width-100-pc float-left mg-top-30 mg-bottom-50">
                                                        <div class="width-45-pc float-left mg-right-15 mg-bottom-15">
                                                            <div class="width-60-pc float-left">
                                                                <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                                    <input placeholder="Search..." :disabled="is_initializing || processing" type="text">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="width-30-pc float-right mg-bottom-15">
                                                            
                                                            <div class="btn-group float-right" role="group">
                                                                <button :disabled="is_initializing || processing" :id="'btnGroupDrop2_1'" class="dropdown-toggle btn btn-secondary banking-process-amref" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                    New Transaction
                                                                </button>
                                                                <div class="dropdown-menu" :aria-labelledby="'btnGroupDrop2_1'">
                                                                    <a data-toggle="modal" data-target="#new_estimate_modal" class="dropdown-item pointer-cursor">Estimate</a>
                                                                    <a data-toggle="modal" data-target="#new_bill_id" class="dropdown-item pointer-cursor">Retainer Invoice</a>
                                                                    <a data-toggle="modal" data-target="#new_salesorder_modal" class="dropdown-item pointer-cursor">Sales Order</a>
                                                                    <a data-toggle="modal" data-target="#new_customer_receipt_modal" class="dropdown-item pointer-cursor">Payment</a>
                                                                </div>
                                                            </div>
                                                            <button :disabled="is_initializing || processing" class="btn btn-secondary banking-process float-right mg-left-5 mg-right-5">Allocate Payments</button>
                                                        </div>
                                                        <div id="po_list_id_0" class="width-100-pc float-left">
                                                            <table class="table banking-transaction table-hover mg-bottom-5">        
                                                                <thead>
                                                                    <tr>
                                                                        <th style="width:2%;">
                                                                            <input :disabled="is_initializing || processing" type="checkbox" class="pointer-cursor" @click="check_all($event)">
                                                                        </th>
                                                                        <th style="width:26%">Customer</th>
                                                                        <th style="width:12%">Date</th>
                                                                        <th style="width:15%;">Receipt#</th>
                                                                        <th style="width:15%;">Reference#</th>
                                                                        <th style="width:15%;" class="text-right">Amount({{currency}})</th>
                                                                        <th style="width:15%;" class="text-right">Unlocated Amount({{currency}})</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody v-if="processing || is_initializing">
                                                                    <tr>
                                                                        <td class="somepad text-center" colspan="7">
                                                                            <img src="/assets/icons/dashboard/loader.gif">
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                                <tbody v-for="(receipt,index) in receipts" :key="'chart_of_accounts_'+index">
                                                                    <tr>
                                                                        <td class="somepad">
                                                                            <input :disabled="is_initializing || processing" v-model="selected_receipts" type="checkbox" class="pointer-cursor" :value="receipt.id">
                                                                        </td>
                                                                        <router-link tag="td" :to="SALES_PAYMENTS+'/'+receipt.id+'/view'" class="somepad pointer-cursor">
                                                                            {{receipt.customer.legal_name}}
                                                                        </router-link>
                                                                        <router-link tag="td" :to="SALES_PAYMENTS+'/'+receipt.id+'/view'" class="somepad pointer-cursor">
                                                                            {{receipt.trans_date}}
                                                                        </router-link>
                                                                        <router-link tag="td" :to="SALES_PAYMENTS+'/'+receipt.id+'/view'" class="somepad pointer-cursor">
                                                                            {{receipt.trans_number}}
                                                                        </router-link>
                                                                        <router-link tag="td" :to="SALES_PAYMENTS+'/'+receipt.id+'/view'" class="somepad pointer-cursor">
                                                                            {{receipt.reference_number}}
                                                                        </router-link>
                                                                        <router-link tag="td" :to="SALES_PAYMENTS+'/'+receipt.id+'/view'" class="somepad pointer-cursor text-right fw-600">
                                                                            {{format_money(receipt.amount)}}
                                                                        </router-link>
                                                                        <router-link tag="td" :to="SALES_PAYMENTS+'/'+receipt.id+'/view'" class="somepad pointer-cursor text-right fw-600">
                                                                            {{format_money(receipt.unlocated_amount)}}
                                                                        </router-link>
                                                                        <!-- <router-link tag="td" :to="SALES_PAYMENTS+'/'+estimate.id+'/view'" class="somepad pointer-cursor">
                                                                            {{estimate.customer.legal_name}}
                                                                        </router-link>
                                                                        <router-link tag="td" :to="SALES_PAYMENTS+'/'+estimate.id+'/view'" class="somepad pointer-cursor">
                                                                            {{estimate.trans_date}}
                                                                        </router-link>
                                                                        <router-link tag="td" :to="SALES_PAYMENTS+'/'+estimate.id+'/view'" class="somepad pointer-cursor">
                                                                            {{estimate.trans_number}}
                                                                        </router-link>
                                                                        <router-link tag="td" :to="SALES_PAYMENTS+'/'+estimate.id+'/view'" class="somepad pointer-cursor">
                                                                            <a v-if="estimate.status[estimate.status.length-1].status===PROCESS_STATUS.ACCEPTED" class="documentStatus accepted">{{PROCESS_STATUS.ACCEPTED}}</a>
                                                                            <a v-else-if="estimate.status[estimate.status.length-1].status===PROCESS_STATUS.DRAFT" class="documentStatus draft">{{PROCESS_STATUS.DRAFT}}</a>
                                                                            <a v-else-if="estimate.status[estimate.status.length-1].status===PROCESS_STATUS.DECLINED" class="txt-uppercase fs-12 fw-600 cl-amref">Declined</a>
                                                                            <a v-else-if="estimate.status[estimate.status.length-1].status===PROCESS_STATUS.EXPIRED" class="txt-uppercase fs-12 fw-600 cl-787887">Expired</a>
                                                                            <a v-else-if="estimate.status[estimate.status.length-1].status===PROCESS_STATUS.PAID" class="documentStatus paid">{{PROCESS_STATUS.PAID}}</a>
                                                                            <a v-else-if="estimate.status[estimate.status.length-1].status===PROCESS_STATUS.PARTIAL_PAID" class="documentStatus paid">{{PROCESS_STATUS.PARTIAL_PAID}}</a>
                                                                            <a v-else-if="estimate.status[estimate.status.length-1].status===PROCESS_STATUS.SENT" class="txt-uppercase fs-12 fw-600 cl-blue-link">Sent</a>
                                                                            <a v-else-if="estimate.status[estimate.status.length-1].status===PROCESS_STATUS.OPEN" class="documentStatus open">{{PROCESS_STATUS.OPEN}}</a>
                                                                            <a v-else-if="estimate.status[estimate.status.length-1].status===PROCESS_STATUS.CLOSED" class="documentStatus closed">{{PROCESS_STATUS.CLOSED}}</a>
                                                                            <a v-else-if="estimate.status[estimate.status.length-1].status===PROCESS_STATUS.INVOICED" class="documentStatus invoiced">{{PROCESS_STATUS.INVOICED}}</a>
                                                                            <a v-else-if="estimate.status[estimate.status.length-1].status===PROCESS_STATUS.PENDING_APPROVAL" class="documentStatus pending">{{PROCESS_STATUS.PENDING_APPROVAL}}</a>
                                                                            <a v-else="" class="documentStatus pending">Pending</a>
                                                                        </router-link>
                                                                        <router-link tag="td" :to="SALES_PAYMENTS+'/'+estimate.id+'/view'" class="somepad pointer-cursor">
                                                                            {{estimate.due_date}}
                                                                        </router-link>
                                                                        <router-link tag="td" :to="SALES_PAYMENTS+'/'+estimate.id+'/view'" class="somepad pointer-cursor text-right fw-600">
                                                                            {{currency+' '+format_money(estimate.net_total)}}
                                                                        </router-link> -->
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <div class="width-20-pc float-left">
                                                            <div class="btn-group" role="group">
                                                                <button :disabled="is_initializing || processing || selected_receipts.length===0 " :id="'btnGroupDrop2_1'" class="dropdown-toggle btn btn-secondary banking-process-amref" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                    <span v-if="selected_receipts.length">{{selected_receipts.length}} receipts selected</span>
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
                                                <customer-receipt-modal v-if="page_ready" :filters="filters" :payment_api="CUSTOMERS_PAYMENTS_API" :currency="currency" :bank_accounts="bank_accounts" :customers="customers" :modal_id="'new_customer_receipt_modal'" :modal_title="'New Payment Received'" @create-payment-event="loadReceipts(true)"></customer-receipt-modal>
                                                <!-- <sales-order-modal v-if="page_ready" :modal_title="'New Sales Order'" :customers="customers" :modal_id="'new_sales_order_modal'" :payment_terms="payment_terms" :filters="filters" :taxations="taxations" :currency="currency" :sales_order_api="CUSTOMERS_SALES_ORDERS_API"></sales-order-modal>
                                                <estimate-modal v-if="page_ready" :modal_title="'New Estimate'" :customers="customers" :modal_id="'new_estimate_modal'" :payment_terms="payment_terms" :filters="filters" :taxations="taxations" :currency="currency" :estimate_api="CUSTOMERS_PAYMENTS_API" @create-estimate-event="loadReceipts(true)"></estimate-modal> -->
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
    import CustomerReceiptModal from "../../../partials/modals/customer/CustomerReceiptModal";
    // import QuickLink from "../partials/QuickLink";

    import {INVENTORY_WEB_ROUTES} from "../../../../../../router/web_routes";
    import {removeElement,paginator,formatMoney, createHtmlErrorString} from "../../../../../../helpers/functionmixin";
    import {AC_TYPES, PROCESS_STATUS,ACCOUNTING,TRANSACTION_TYPES} from "../../../../../../helpers/process_status";
    import {CUSTOMERS_PAYMENTS_API,PRODUCT_TAX_URL,BANKING_ACCOUNTS_URL,CHART_OF_ACCOUNTS, CUSTOMERS_API,CUSTOMERS_SALES_ORDERS_API,CUSTOMERS_TERMS_API} from '../../../../../../router/api_routes';
    export default {
        name: "Index",
        components: {TopNavBar,PaginateTemplate,SideBar,DeleteModal,CopyRight,EstimateModal,
        ProcessingOverlay,SalesOrderModal,CustomerReceiptModal},
        data(){
            return {
                
                
                selected_receipts: [],
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
                //QUOTE: INVENTORY_WEB_ROUTES.SALES.QUOTE,
                receipts: [],
                receipts: [],
                default_filter: 'All',
                default_api: CUSTOMERS_PAYMENTS_API+'?page=1',
                CUSTOMERS_PAYMENTS_API:CUSTOMERS_PAYMENTS_API,
                CUSTOMERS_SALES_ORDERS_API: CUSTOMERS_SALES_ORDERS_API,
                SALES_PAYMENTS: INVENTORY_WEB_ROUTES.SALES.PAYMENTS,
                CUSTOMER_INVOICES: INVENTORY_WEB_ROUTES.SALES.INVOICES,
            }
        },
        watch: {
            default_api: function(){
                this.loadReceipts(true);
            }
        },
        methods: {

            check_all(event){
                this.selected_receipts = [];
                if(event.target.checked){
                    for (let index = 0; index < this.receipts.length; index++) {
                        const element = this.receipts[index];
                        this.selected_receipts.push(element.id);
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
                        this.default_api = CUSTOMERS_PAYMENTS_API+'?page='+this.pagination.current_page+'&filter_by='+this.default_filter;
                        break;
                    case "Page":
                        if(this.default_filter==='All'){
                            this.default_api = CUSTOMERS_PAYMENTS_API+'?page='+this.pagination.current_page;
                        }else{
                            this.default_api = CUSTOMERS_PAYMENTS_API+'?page='+this.pagination.current_page+'&filter_by='+this.default_filter;
                        }
                        break;
                    default:
                        this.default_filter = filter_by;
                        this.default_api = CUSTOMERS_PAYMENTS_API+'?page='+this.pagination.current_page;
                        break;
                }
            },

            loadBankAccount(){
                get(BANKING_ACCOUNTS_URL)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.bank_accounts = res.data.results.data;
                        this.loadReceipts();
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

            loadSuppliers(){
                get(SUPPLIER_URL)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.suppliers = res.data.results.data;
                        this.filters = res.data.results.filters;
                        //this.page_ready = true;
                        this.loadTerms();
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

            loadCustomers(){
                get(CUSTOMERS_API)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.customers = res.data.results.data;
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
            loadReceipts(show_progress=false){
                this.is_initializing = show_progress;
                get(this.default_api)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.receipts = res.data.results.data;
                        this.filters = res.data.results.filters;
                        this.pagination = res.data.results.pagination;
                        console.info(this.receipts);
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
                        this.loadReceipts();
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
                        this.loadTerms();
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