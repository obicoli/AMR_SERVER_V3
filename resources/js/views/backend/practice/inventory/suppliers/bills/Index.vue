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
                                            <div class="col-md-10 col-lg-10 padding-right-0 border-bottom">
                                                <div :hidden="bills.length===0 && default_filter==='All'" class="width-100-pc float-left">
                                                    <div class="width-40-pc float-left">
                                                        <div class="btn-group" role="group" aria-label="Button group">
                                                            <div class="btn-group" role="group">
                                                                <a :id="'btnGroupDrop2_1'" class="dropdown-toggle fs-14 pointer-cursor fw-600 txt-uppercase" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                    {{default_filter}} Bills({{pagination.total}})
                                                                </a>
                                                                <div class="dropdown-menu" :aria-labelledby="'btnGroupDrop2_1'">
                                                                    <a @click="filterBills('All')" class="dropdown-item pointer-cursor">All</a>
                                                                    <a @click="filterBills(PROCESS_STATUS.DRAFT)" class="dropdown-item pointer-cursor">{{PROCESS_STATUS.DRAFT}}</a>
                                                                    <a @click="filterBills(PROCESS_STATUS.PENDING_APPROVAL)" class="dropdown-item pointer-cursor">{{PROCESS_STATUS.PENDING_APPROVAL}}</a>
                                                                    <a @click="filterBills(PROCESS_STATUS.OPEN)" class="dropdown-item pointer-cursor">{{PROCESS_STATUS.OPEN}}</a>
                                                                    <a @click="filterBills(PROCESS_STATUS.OVERDUE)" class="dropdown-item pointer-cursor">{{PROCESS_STATUS.OVERDUE}}</a>
                                                                    <a @click="filterBills(PROCESS_STATUS.UNPAID)" class="dropdown-item pointer-cursor">{{PROCESS_STATUS.UNPAID}}</a>
                                                                    <a @click="filterBills(PROCESS_STATUS.PARTIAL_PAID)" class="dropdown-item pointer-cursor">{{PROCESS_STATUS.PARTIAL_PAID}}</a>
                                                                    <a @click="filterBills(PROCESS_STATUS.PAID)" class="dropdown-item pointer-cursor">{{PROCESS_STATUS.PAID}}</a>
                                                                    <a @click="filterBills(PROCESS_STATUS.VOID)" class="dropdown-item pointer-cursor">{{PROCESS_STATUS.VOID}}</a>
                                                                    <a class="dropdown-item separator"></a>
                                                                    <a class="dropdown-item pointer-cursor">New Custom view</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="width-60-pc float-right">
                                                        <quick-link :active_link="'bills'"></quick-link>
                                                    </div>
                                                </div>
                                                
                                                <div class="width-100-pc float-left mg-top-30 mg-bottom-50">

                                                    <div v-if="page_ready && bills.length===0 && default_filter==='All' && is_initializing===false && processing===false" class="width-100-pc float-left mg-top-10 mg-bottom-50 text-center">
                                                        <div class="width-100-pc text-center float-left">
                                                            <a class="fs-15 txt-uppercase cl-444 fw-600">Bills</a><br>
                                                            <small class="fs-13 cl-777">If you've purchased something for your business, and you don't have to repay it immediately, then you can record it as a bill.</small><br><br>
                                                            <a data-toggle="modal" data-target="#new_bill_id" class="btn btn-secondary banking-process-amref">Create a Bill</a>
                                                        </div>
                                                        <div class="width-100-pc text-center float-left mg-top-20">
                                                            <img src="/assets/icons/dashboard/bill_cycle.png" class=" mg-bottom-20">
                                                        </div>
                                                    </div>

                                                    <div v-else-if="page_ready && bills.length || bills.length===0" class="width-100-pc float-left mg-top-30 mg-bottom-50">
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
                                                                    <a data-toggle="modal" data-target="#new_po_modal" class="dropdown-item pointer-cursor">Purchase Order</a>
                                                                    <a data-toggle="modal" data-target="#new_bill_id" class="dropdown-item pointer-cursor">Bill</a>
                                                                    <a class="dropdown-item separator"></a>
                                                                    <a class="dropdown-item pointer-cursor">Print</a>
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
                                                                        <th style="width:24%">Supplier</th>
                                                                        <th style="width:10%">Date</th>
                                                                        <th style="width:10%;">Bill#</th>
                                                                        <th style="width:15%;" class="text-right">Amount</th>
                                                                        <th style="width:12%;">Status</th>
                                                                        <th style="width:12%;">Due Date</th>
                                                                        <th style="width:15%;" class="text-right">Balance Due</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody v-if="processing || is_initializing">
                                                                    <tr>
                                                                        <td class="somepad text-center" colspan="9">
                                                                            <img src="/assets/icons/dashboard/loader.gif">
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                                <tbody v-for="(bill,index) in bills" :key="'chart_of_accounts_'+index">
                                                                    <tr>
                                                                        <td class="somepad">
                                                                            <input :disabled="is_initializing || processing" v-model="selected_bills" type="checkbox" class="pointer-cursor" :value="bill.id">
                                                                        </td>
                                                                        <router-link tag="td" :to="'/suppliers/bills'+'/'+bill.id+'/view'" class="somepad pointer-cursor">
                                                                            {{bill.vendor.legal_name}}
                                                                        </router-link>
                                                                        <router-link tag="td" :to="'/suppliers/bills'+'/'+bill.id+'/view'" class="somepad pointer-cursor">
                                                                            {{bill.trans_date}}
                                                                        </router-link>
                                                                        <router-link tag="td" :to="'/suppliers/bills'+'/'+bill.id+'/view'" class="somepad pointer-cursor cl-blue-link fw-600">
                                                                            {{bill.trans_number}}
                                                                        </router-link>
                                                                        <!-- <router-link tag="td" :to="'/suppliers/bills'+'/'+bill.id+'/view'" class="somepad pointer-cursor">
                                                                            {{bill.ref_number}}
                                                                        </router-link> -->
                                                                        <router-link tag="td" :to="'/suppliers/bills'+'/'+bill.id+'/view'" class="somepad pointer-cursor fw-600 fs-12 cl-444 text-right">
                                                                            {{bill.vendor.currency.currency_sympol+' '+format_money(bill.net_total)}}
                                                                        </router-link>
                                                                        <router-link tag="td" :to="'/suppliers/bills'+'/'+bill.id+'/view'" class="somepad pointer-cursor">
                                                                            <a v-if="bill.status[bill.status.length-1].status===PROCESS_STATUS.ACCEPTED" class="txt-uppercase fs-12 fw-600 cl-success-light">Accepted</a>
                                                                            <a v-else-if="bill.status[bill.status.length-1].status===PROCESS_STATUS.DRAFT" class="documentStatus draft">{{PROCESS_STATUS.DRAFT}}</a>
                                                                            <a v-else-if="bill.status[bill.status.length-1].status===PROCESS_STATUS.DECLINED" class="txt-uppercase fs-12 fw-600 cl-amref">Declined</a>
                                                                            <a v-else-if="bill.status[bill.status.length-1].status===PROCESS_STATUS.EXPIRED" class="txt-uppercase fs-12 fw-600 cl-787887">Expired</a>
                                                                            <a v-else-if="bill.status[bill.status.length-1].status===PROCESS_STATUS.INVOICED" class="txt-uppercase fs-12 fw-600 cl-success-light">Invoiced</a>
                                                                            <a v-else-if="bill.status[bill.status.length-1].status===PROCESS_STATUS.PAID" class="documentStatus paid">{{PROCESS_STATUS.PAID}}</a>
                                                                            <a v-else-if="bill.status[bill.status.length-1].status===PROCESS_STATUS.PARTIAL_PAID" class="documentStatus paid">{{PROCESS_STATUS.PARTIAL_PAID}}</a>
                                                                            <a v-else-if="bill.status[bill.status.length-1].status===PROCESS_STATUS.SENT" class="txt-uppercase fs-12 fw-600 cl-blue-link">Sent</a>
                                                                            <a v-else-if="bill.status[bill.status.length-1].status===PROCESS_STATUS.OPEN" class="documentStatus open">{{PROCESS_STATUS.OPEN}}</a>
                                                                            <a v-else-if="bill.status[bill.status.length-1].status===PROCESS_STATUS.CLOSED" class="documentStatus closed">{{PROCESS_STATUS.CLOSED}}</a>
                                                                            <a v-else="" class="documentStatus pending">Pending</a>
                                                                        </router-link>
                                                                        <router-link tag="td" :to="'/suppliers/bills'+'/'+bill.id+'/view'" class="somepad pointer-cursor">
                                                                            <a v-if="bill.is_overdue" class="documentStatus overdue">Overdue</a>
                                                                            <a v-else class="cl-444">{{bill.due_date}}</a>
                                                                        </router-link>
                                                                        <router-link tag="td" :to="'/suppliers/bills'+'/'+bill.id+'/view'" class="somepad pointer-cursor fw-600 text-right">
                                                                            {{bill.vendor.currency.currency_sympol+' '+format_money(bill.net_total-bill.cash_paid)}}
                                                                        </router-link>
                                                                        <delete-modal :modal_title="'Delete Bill'" :confirm_message="'Are you sure?'" :modal_id="'delete_transaction_'"></delete-modal>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <div class="width-20-pc float-left">
                                                            <div class="btn-group" role="group">
                                                                <button :disabled="is_initializing || processing || selected_bills.length===0 " :id="'btnGroupDrop2_1'" class="dropdown-toggle btn btn-secondary banking-process-amref" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                    <span v-if="selected_bills.length">{{selected_bills.length}} Bills selected</span>
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
                                                            <paginate-template v-if="pagination.last_page > 1" :pagination="pagination" :offset="5" @paginate="filterBills('Page')" :custom="true"></paginate-template>
                                                        </div>
                                                    </div>
                                                    <div v-else class="width-100-pc float-left mg-top-60 text-center">
                                                        <img class="loader" src="/assets/icons/dashboard/loader.gif">
                                                    </div>
                                                    <copy-right></copy-right>
                                                    <bill-modal v-if="page_ready" :taxations="taxations" :inventories="inventories" :accounts="accounts" :bank_accounts="bank_accounts" :filters="filters" :billable="false" :payment_terms="payment_terms" :currency="currency" :bill_api="SUPPLIER_BILL_URL" :billable_type="'PO'" :suppliers="suppliers" :order="bill" :modal_id="'new_bill_id'" :modal_title="'New Bill'" @create-bill-event="loadBills"></bill-modal>
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
    import PaginateTemplate from '../../../partials/pagination/PaginateTemplate';
    import CopyRight from '../../../partials/CopyRight';
    import DeleteModal from "../../../partials/modals/DeleteModal";
    import ProcessingOverlay from "../../../../../progress/ProcessingOverlay";
    import {get, post} from "../../../../../../helpers/api";
    import Auth from "../../../../../../store/auth";
    import PoModal from "../../../partials/modals/purchase/PoModal";
    import BillModal from "../../../partials/modals/vendors/BillModal";
    import QuickLink from "../partials/QuickLink";

    import {INVENTORY_WEB_ROUTES} from "../../../../../../router/web_routes";
    import {removeElement,paginator,formatMoney, createHtmlErrorString} from "../../../../../../helpers/functionmixin";
    import {AC_TYPES, PROCESS_STATUS,ACCOUNTING,TRANSACTION_TYPES} from "../../../../../../helpers/process_status";
    import {SUPPLIER_BILL_URL,SUPPLIER_URL,SUPPLIER_TERMS_API,PRODUCT_TAX_URL,CHART_OF_ACCOUNTS,BANKING_ACCOUNTS_URL} from '../../../../../../router/api_routes';
    export default {
        name: "Index",
        components: {TopNavBar,PaginateTemplate,SideBar,DeleteModal,CopyRight,BillModal,
        ProcessingOverlay,PoModal,QuickLink},
        data(){
            return {
                bills: [],
                selected_bills: [],
                msg: 'Loading. Please wait...',
                progress_overlay: 'hide',
                page_ready: false,
                is_initializing: false,
                processing: false,
                bill: {},
                pagination: paginator(),
                currency: ACCOUNTING.CURRENCY,
                PROCESS_STATUS: PROCESS_STATUS,
                filters: {},
                suppliers: [],
                facilities: [],
                customers: [],
                taxations: [],
                bank_accounts: [],
                payment_terms: [],
                accounts: [],
                inventories: [],
                SUPPLIER_BILL_URL:SUPPLIER_BILL_URL,
                default_filter: 'All',
                default_api: SUPPLIER_BILL_URL+'?page=1',
                BILL_ROUTE: INVENTORY_WEB_ROUTES.PURCHASES.BILL_VIEW
            }
        },
        watch: {
            default_api: function(){
                this.loadBills(true);
            }
        },
        methods: {

            check_all(event){
                this.selected_bills = [];
                if(event.target.checked){
                    for (let index = 0; index < this.bills.length; index++) {
                        const element = this.bills[index];
                        this.selected_bills.push(element.id);
                    }
                }
            },

            format_money(money_to){
                return formatMoney(money_to);
            },

            filterBills(filter_by='All'){
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
                        this.default_api = SUPPLIER_BILL_URL+'?page='+this.pagination.current_page+'&filter_by='+this.default_filter;
                        break;
                    case "Page":
                        if(this.default_filter==='All'){
                            this.default_api = SUPPLIER_BILL_URL+'?page='+this.pagination.current_page;
                        }else{
                            this.default_api = SUPPLIER_BILL_URL+'?page='+this.pagination.current_page+'&filter_by='+this.default_filter;
                        }
                        break;
                    default:
                        this.default_filter = filter_by;
                        this.default_api = SUPPLIER_BILL_URL+'?page='+this.pagination.current_page;
                        break;
                }
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

            loadBankAccount(){
                get(BANKING_ACCOUNTS_URL)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.bank_accounts = res.data.results.data;
                        this.loadInventoryAccounts();
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

            loadInventoryAccounts(){
                get(CHART_OF_ACCOUNTS+'?default_code='+ACCOUNTING.COA_CODES.INVENTORY)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.inventories = res.data.results.data;
                        //console.info(this.inventories);
                        //this.page_ready = true;
                        this.loadCashAccounts();
                    }
                }).catch((err) => {
                    this.progress_overlay = "hide";
                });
            },

            loadBills(show_progress=false){
                this.is_initializing = show_progress;
                get(this.default_api)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.bills = res.data.results.data;
                        this.filters = res.data.results.filters;
                        this.pagination = res.data.results.pagination;
                        console.info(this.bills);
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

            loadCashAccounts(){
                get(CHART_OF_ACCOUNTS+'?account_nature='+ACCOUNTING.ACCOUNT_NATURES.ASSETS)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.accounts = res.data.results.data;
                        //console.info(this.accounts);
                        //this.page_ready = true;
                        this.loadBills();
                    }
                }).catch((err) => {
                    this.progress_overlay = "hide";
                    this.page_ready = true;
                });
            },

            loadTerms(){
                get(SUPPLIER_TERMS_API)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.payment_terms = res.data.results.data;
                        // this.page_ready = true;
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

            loadTaxes(){
                get(PRODUCT_TAX_URL+'?input_tax=ok')
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.taxations = res.data.results.data;
                        //this.loadPo();
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