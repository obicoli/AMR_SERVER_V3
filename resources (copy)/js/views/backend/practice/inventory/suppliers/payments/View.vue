<template>

    <div>

        <processing-overlay :message="'Loading. Please wait...'" :status="progress_overlay"></processing-overlay>

        <top-nav-bar :inventory="true"></top-nav-bar>

        <side-bar></side-bar>

        <div class="wp-content content-calculated-height-wc">

            <div class="row">

                <div class="col-md-12 col-lg-12 col-sm-12 padding-left-0 content-calculated-height-50">

                    <div v-if="page_loaded" class="settings-header shadowed main-heading bg-foo">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="pull pull-left app-header width-50-pc">
                                    <search-database-form-control :field_wdth="300" :placeholder="'Search here'"></search-database-form-control>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="ui fitted divider"></div>

                    <div v-if="page_loaded" class="row mg-top-35">

                        <div class="col-md-4 col-lg-4 col-sm-4 padding-right-0 padding-left-20 bg-white content-calculated-height-50">
                            <div class="estimate-list width-100-pc content-calculated-height-50">
                                <div class="estimate-list-head">
                                    <div class="float-left width-10-pc">
                                        <input :disabled="is_initializing || processing" type="checkbox" class="pointer-cursor float-left" @click="check_all($event)">
                                    </div>
                                    <div class="float-left width-70-pc">
                                        <div  class="btn-group" role="group" aria-label="Button group">
                                            <div v-if="selected_bills.length" class="btn-group" role="group">
                                                <a :id="'btnGroupDrop2_1'" class="dropdown-toggle pointer-cursor fw-600 cl-444 fs-14" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    {{selected_bills.length}} Bills selected
                                                </a>
                                                <div class="dropdown-menu" :aria-labelledby="'btnGroupDrop2_1'">
                                                    <a data-toggle="modal" data-target="#payment_bill_id" class="dropdown-item pointer-cursor fs-12">Record Payment</a>
                                                    <a class="dropdown-item separator"></a>
                                                    <a data-toggle="modal" data-target="#" class="dropdown-item pointer-cursor fs-12">Update status</a>
                                                    <a data-toggle="modal" data-target="#" class="dropdown-item pointer-cursor fs-12">Copy Purchase Order</a>
                                                    <a class="dropdown-item separator"></a>
                                                    <a data-toggle="modal" data-target="#" class="dropdown-item pointer-cursor fs-12">Delete</a>
                                                </div>
                                            </div>
                                            <div v-else class="btn-group" role="group">
                                                <a :id="'btnGroupDrop2_1'" class="dropdown-toggle pointer-cursor fw-600 cl-444 fs-14" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    {{default_filter}} Payments({{pagination.total}})
                                                </a>
                                                <div class="dropdown-menu" :aria-labelledby="'btnGroupDrop2_1'">
                                                    <a @click="filterBills('All')" class="dropdown-item pointer-cursor">All</a>
                                                    <a class="dropdown-item separator"></a>
                                                    <a class="dropdown-item pointer-cursor">New Custom view</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="width-20-pc float-right">
                                        <button type="button" data-toggle="modal" title="New Payment" data-target="#payment_bill_id" class="float-right btn btn-secondary banking-process-amref">+</button>
                                    </div>
                                </div>
                                <div class="estimate-list-body height-scrollable-body">
                                    <table class="width-100-pc">
                                        <tbody v-if="is_initializing">
                                            <tr class="parent">
                                                <td colspan="3" class="text-center">
                                                    <img class="loader" src="/assets/icons/dashboard/loader.gif">
                                                </td>
                                            </tr>
                                        </tbody>
                                        <tbody v-if="!payments.length">
                                            <tr class="parent">
                                                <td colspan="3" class="text-center cl-amref">
                                                    No payment to display!
                                                </td>
                                            </tr>
                                        </tbody>
                                        <tbody v-for="(bil,index) in payments" v-bind:class="{'active':active_po===index}" :key="'po_list_'+index">
                                            <tr class="parent">
                                                <td style="width:10%"><input v-model="selected_bills" :value="bil.id" type="checkbox"> </td>
                                                <td style="width:55%" class="fs-12">{{bil.vendor.legal_name}}</td>
                                                <td style="width:35%" class="text-right fs-12 cl-444 fw-600">{{bil.vendor.currency.currency_sympol}}{{formatMoneys(bil.amount)}}</td>
                                            </tr>
                                            <tr class="child">
                                                <td style="width:10%" class="text-right"></td>
                                                <td style="width:55%">
                                                    <a @click="setBill(bil,index)" class="txt-uppercase fs-12 cl-blue-link fw-600">{{bil.trans_number}}</a> | <a class="fs-12 cl-787887 fw-600">{{bil.payment_date}}</a>
                                                </td>
                                                <td style="width:35%" class="text-right">
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="padding-left-0 bg-ced padding-right-0 content-calculated-height-50 col-md-8 col-lg-8 col-sm-8">
                            
                            <div class="box box-primary bg-white border-top-0 mg-bottom-0 content-calculated-height-50 border-bottom-0 no-shadowed">
                                 <div  class="width-100-pc action-header padding-left-20 padding-top-10 padding-bottom-10">
                                    <div class="float-left width-20-pc">
                                        <h3 class="fs-14 cl-777 fw-600">{{payment.trans_number}}</h3>
                                    </div>
                                    <div class="float-right width-80-pc text-right padding-right-30">
                                        <button type="button" data-toggle="modal" title="Edit Purchase Order" data-target="#edit_po_modal_00" class="btn btn-default btn-inventory btn-gray mg-left-2"><i class="fa fa-pencil"></i></button>
                                        <button type="button" @click="printDocs('po_component_id_0','Loading '+payment.trans_number)" class="btn btn-default btn-inventory btn-gray mg-left-2">
                                            <span v-if="printing"><i class="fa fa-spinner fa-spin"></i> Wait...</span>
                                            <i v-else class="fa fa-print"></i>
                                        </button>
                                        <button type="button" data-toggle="modal" data-target="#send_bill_mail_00" title="Send Mail" class="btn btn-default btn-inventory btn-gray mg-left-2"><i class="fa fa-envelope-o"></i></button>
                                        <button type="button" data-toggle="modal" data-target="#attach_files_000" title="Attach file(s)" class="btn btn-default btn-inventory btn-gray mg-left-2 mg-right-20"><i class="fa fa-paperclip"></i></button>
                                        <router-link :to="PAYMENTS_URL" tag="i" class="btn btn-default btn-inventory btn-gray"><i class="fa fa-arrow-circle-left"></i> Back to Payments</router-link>
                                    </div>
                                    <div class="width-100-pc mg-top-45 content-links">
                                    </div>
                                </div>

                                <div class="page-content bg-white padding-left-0 height-scrollable">
                                    <div class="dgrid dgrid-grid ui-widget dgrid-03 mg-bottom-30 universal-grid border-ccc" role="grid">
                                        <div class="row">
                                            <div class="col-lg-12 padding-right-0">
                                                <div class="width-100-pc float-left">
                                                    <nav>
                                                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                                            <a v-bind:class="{'nav-item nav-link nav-link-role':true,'active':curr_tab===0}" :id="'nav-transactions-tab-'+'0'" data-toggle="tab" :href="'#nav-transactions-'+'0'" role="tab" :aria-controls="'nav-transactions-'+'0'" aria-selected="true" :key="'transactions_tab'+'0'">{{payment.trans_number}}</a>
                                                            <a v-if="payment.journals.length" v-bind:class="{'nav-item nav-link nav-link-role':true,'active':curr_tab===2}" :id="'nav-transactions-tab-'+'2'" data-toggle="tab" :href="'#nav-transactions-'+'2'" role="tab" :aria-controls="'nav-transactions-'+'2'" aria-selected="true" :key="'transactions_tab'+'2'">Journal</a>
                                                            <a v-bind:class="{'nav-item nav-link nav-link-role':true,'active':curr_tab===3}" :id="'nav-transactions-tab-'+'3'" data-toggle="tab" :href="'#nav-transactions-'+'3'" role="tab" :aria-controls="'nav-transactions-'+'3'" aria-selected="true" :key="'transactions_tab'+'3'">Comment&History</a>
                                                        </div>
                                                    </nav>
                                                    <div class="tab-content tab-content-role" id="nav-tabContent">
                                                        <div v-bind:class="{'tab-pane fade':true,'show active':curr_tab===0}" :id="'nav-transactions-'+'0'" role="tabpanel" :aria-labelledby="'nav-transactions-tab-'+'0'" :key="'tab_index_'+'0'">
                                                            <div class="width-100-pc float-left padding-left-15 padding-right-10 bg-f4 padding-bottom-20">
                                                                <section v-if="page_loaded" class="padding-right-0 padding-left-0 padding-top-20" id="print_section">
                                                                    <div v-if="po_loading" class="float-left width-100-pc text-center mg-top-30">
                                                                        <img class="loader" src="/assets/icons/dashboard/loader.gif">
                                                                    </div>
                                                                    <payment-receipt-preview id="po_component_id_0" :payment_made="payment" :currency="currency" :balance="0"></payment-receipt-preview>
                                                                </section>
                                                            </div>
                                                        </div>
                                                        <div v-if="payment.journals.length" v-bind:class="{'tab-pane fade':true,'show active':curr_tab===2}" :id="'nav-transactions-'+'2'" role="tabpanel" :aria-labelledby="'nav-transactions-tab-'+'2'" :key="'tab_index_'+'2'">
                                                            <div class="width-100-pc float-left padding-left-5 padding-right-10 bg-f4 padding-bottom-20 min-height-400">
                                                                <table class="table banking-transaction-reports table statement-reports table-hover mg-bottom-20 mg-right-10 mg-top-15">        
                                                                    <thead>
                                                                        <tr>
                                                                            <th style="width:15%;" class="somepad-1 fw-600 txt-uppercase fs-12">Date</th>
                                                                            <th style="width:55%" class="somepad-1 fw-600 txt-uppercase fs-12">Account</th>
                                                                            <th style="width:15%;" class="text-right somepad fw-600 txt-uppercase fs-12">Debit</th>
                                                                            <th style="width:15%;" class="text-right somepad-1 fw-600 txt-uppercase fs-11">Credit</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody v-for="(journal,index) in payment.journals" :key="'journals'+index">
                                                                        <tr v-for="(ledger,index_l) in journal" class="body" :key="'index_l'+index_l">
                                                                            <td>
                                                                                <a v-if="ledger.balance_type===ACCOUNTING.DEBIT">{{ledger.trans_date}}</a>
                                                                            </td>
                                                                            <td>
                                                                                <a>{{ledger.custom_name}}</a>
                                                                            </td>
                                                                            <td class="text-right">
                                                                                <a v-if="ledger.balance_type===ACCOUNTING.DEBIT">Ksh{{formatMoneys(ledger.amount)}}</a>
                                                                            </td>
                                                                            <td class="text-right">
                                                                                <a v-if="ledger.balance_type===ACCOUNTING.CREDIT">Ksh{{formatMoneys(ledger.amount)}}</a>
                                                                            </td>
                                                                        </tr>
                                                                        <tr class="sub-total body">
                                                                            <td style="font-style: italic;" colspan="2" class="fw-600 fs-12">{{journal[0].trans_description}}</td>
                                                                            <td class="sub-total text-right fs-12">Ksh{{formatMoneys( sub_total(journal,ACCOUNTING.DEBIT) )}}</td>
                                                                            <td class="sub-total text-right fs-12">Ksh{{formatMoneys(sub_total(journal,ACCOUNTING.CREDIT))}}</td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                        <div v-bind:class="{'tab-pane fade':true,'show active':curr_tab===3}" :id="'nav-transactions-'+'3'" role="tabpanel" :aria-labelledby="'nav-transactions-tab-'+'3'" :key="'tab_index_'+'3'">
                                                            <div class="width-100-pc float-left padding-left-15 padding-top-20 padding-right-10 bg-f4 padding-bottom-20 min-height-427">
                                                                <audit-timeline v-if="page_loaded" :audit_trails="payment.audit_trails"></audit-timeline>
                                                                <div class="width-100-pc float-left mg-top-20">
                                                                    <form @submit.prevent="addComment" v-if="add_comment" class="width-100-pc float-left padding-20">
                                                                        <div class="width-100-pc float-left">
                                                                            <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                                                <textarea v-model="comment_form.comment" required placeholder="" v-bind:class="{'min-height-60':true,'custom-attended-field':comment_form.comment}"></textarea>
                                                                            </div>
                                                                        </div>
                                                                        <button type="submit" class="btn btn-secondary banking-process-amref mg-top-5">
                                                                            <span v-if="processing"><i class="fa fa-spinner fa-spin"></i></span>
                                                                            <span v-else>+ add</span>
                                                                        </button>
                                                                        <button type="button" class="btn btn-secondary banking-process mg-top-5">x close</button>
                                                                    </form>
                                                                    <a v-if="!add_comment" @click="toggleAddComment(true)" class="cl-blue-link fs-12 pointer-cursor float-left">+ Add comment</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                 <!-- <send-mail v-if="page_loaded" :mailing_api="mailing_api" :modal_id="'send_bill_mail_00'" :mail_content="mail_content" :modal_title="'Send Mail'" @send-mail-event="loadBills(true)"></send-mail>
                                 <bill-modal v-if="page_loaded" :taxations="taxations" :inventories="inventories" :accounts="accounts" :bank_accounts="bank_accounts" :filters="filters" :billable="false" :payment_terms="payment_terms" :currency="currency" :bill_api="SUPPLIER_BILL_URL" :billable_type="'PO'" :suppliers="suppliers" :order="bill" :modal_id="'new_bill_id'" :modal_title="'New Bill'" @create-bill-event="loadBills"></bill-modal>
                                 <file-attach-modal v-if="page_loaded" @upload-success-event="loadBills(true)" @delete-file-event="loadBill" :attachable="bill" :upload_api="SUPPLIER_BILL_ASSETS_API" :title="'File Attachment | '+bill.trans_number" :modal_id="'attach_files_000'" :info="'Individual files may not exceed 2.00 MB in size. A maximum of 5 attachments per bill can be added'"></file-attach-modal>
                                 <supplier-payment-modal v-if="page_loaded" :bill="bill" :accounts="accounts" :bank_accounts="bank_accounts" :filters="filters" :currency="currency" :payment_api="SUPPLIER_PAYMENTS_API" :suppliers="suppliers" :modal_id="'payment_bill_id'" :modal_title="'Payment for '+bill.trans_number" @create-payment-event="loadBills(true)"></supplier-payment-modal>
                                 <change-status v-if="page_loaded" @change-status-event="loadBills(true)" :modal_title="'Change Status'" :item_url="SUPPLIER_BILL_URL+'/'+bill.id" :modal_id="'change_status_modal'"></change-status> -->
                                 <send-mail v-if="page_loaded" :mailing_api="mailing_api" :modal_id="'send_bill_mail_00'" :mail_content="mail_content" :modal_title="'Send Mail'" @send-mail-event="loadPayments(true)"></send-mail>
                                 <file-attach-modal v-if="page_loaded" @upload-success-event="loadPayment(true)" @delete-file-event="loadPayment" :attachable="payment" :upload_api="SUPPLIER_PAYMENTS_ASSETS_API" :title="'File Attachment | '+payment.trans_number" :modal_id="'attach_files_000'" :info="'Individual files may not exceed 2.00 MB in size. A maximum of 5 attachments per payment can be added'"></file-attach-modal>
                                 <supplier-payment-modal v-if="page_loaded" :bill="false" :accounts="accounts" :bank_accounts="bank_accounts" :filters="filters" :currency="currency" :payment_api="SUPPLIER_PAYMENTS_API" :suppliers="suppliers" :modal_id="'payment_bill_id'" :modal_title="'New Payment'" @create-payment-event="loadPayments(true)"></supplier-payment-modal>
                            </div>
                        </div>
                    </div>

                    <div v-else class="row">
                        <div class=" col-md-12 col-lg-12 text-center bg-ced min-height-100-vh">
                            <img class="loader mg-top-170" src="/assets/icons/dashboard/loader.gif">
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
    import SideBarSupply from "../../../partials/sidebars/SideBarSupply";
    //import SideBarRequisitions from "../../partials/sidebars/SideBarRequisitions";
    //import SideBarCustomer from "../../partials/sidebars/customer/SideBarCustomer";
    import PurchasesFilters from "../../../partials/filters/PurchasesFilters";
    import PurchasesTable from "../../../partials/tables/PurchasesTable";
    import CreatePurchaseModal from "../../../partials/modals/purchase/CreatePurchaseModal";
    import SideBarInventory from "../../../partials/sidebars/inventory/SideBarInventory";
    //import SupplyModal from "../../partials/modals/supply/SupplyModal";
    import ConfirmModal from "../../../partials/modals/ConfirmModal";
    import ChangeStatus from "../../../partials/modals/ChangeStatus";
    //import EstimateModal from '../../partials/modals/customer/EstimateModal';
    import PaginateTemplate from '../../../partials/pagination/PaginateTemplate';
    //import SupplyPreview from "../../partials/modals/supply/SupplyPreview";
    //import RequistionModal from '../../partials/modals/product/RequistionModal';
    import ProcessingOverlay from '../../../../../progress/ProcessingOverlay';
    import SearchDatabaseFormControl from '../../../partials/search/SearchDatabaseFormControl';
    import CommonLinks from "../../../partials/sidebars/CommonLinks";
    import {get, post} from "../../../../../../helpers/api";
    import Auth from "../../../../../../store/auth";
    import SupplierHeader from '../partials/SupplierHeader';
    import PoModal from "../../../partials/modals/purchase/PoModal";
    import CompanyLogo from "../../../partials/CompanyLogo";
    import RibbonMaker from "../../../partials/RibbonMaker";
    import BillModal from "../../../partials/modals/vendors/BillModal";
    import SupplierPaymentModal from "../../../partials/modals/vendors/SupplierPaymentModal";
    import PaymentReceiptPreview from "../../../partials/previews/supplychain/supplier/PaymentReceiptPreview";
    import SendMail from "../../../partials/modals/mails/SendMail";
    import FileAttachModal from "../../../partials/modals/attachment/FileAttachModal";
    import AuditTimeline from "../../../partials/AuditTimeline";
    // import EstimateView from './partials/Estimates'
    // import CustomerModal from '../../partials/modals/customer/CustomerModal';
    import {SUPPLIER_BILL_URL,SUPPLIER_PAYMENTS_API,SUPPLIER_TERMS_API,BANKING_ACCOUNTS_URL,CHART_OF_ACCOUNTS,PRODUCT_ITEMS_URL,PRODUCT_TAX_URL,SUPPLIER_URL,ACCOUNTS_ACCOUNT,PRACTICES_API,SUPPLIER_PO_URL,SUPPLIER_PAYMENTS_ASSETS_API} from '../../../../../../router/api_routes';
    import {createHtmlErrorString,formatMoney,paginator,printing, format_lunox_date,create_mail_content} from '../../../../../../helpers/functionmixin';
    import {PROCESS_STATUS,ACCOUNTING, TRANSACTION_TYPES, FORM_ACTIONS} from '../../../../../../helpers/process_status';
    import {INVENTORY_WEB_ROUTES} from "../../../../../../router/web_routes";
    import print from "print-js";
    import printJS from "print-js";
    export default {
        name: "BillView",
        components: {TopNavBar,SideBar,PaginateTemplate,SupplierHeader,PoModal,BillModal,ConfirmModal,SendMail,AuditTimeline,PaymentReceiptPreview,
        SideBarInventory,ProcessingOverlay,SupplierPaymentModal,CommonLinks,SearchDatabaseFormControl,ChangeStatus,
        RibbonMaker,CompanyLogo,FileAttachModal},
        data(){
            return {
                curr_tab: 0,
                PURCHASE_ORDERS: INVENTORY_WEB_ROUTES.PURCHASES.PURCHASE_ORDERS,
                initializations: {},
                products: [],
                estimate_list: [],
                bills: [],
                payments: [],
                payment_terms: [],
                purchase_order: {},
                payment: null,

                selected_bills: [],
                suppliers: [],
                taxations: [],
                page_loaded: false,
                progress_overlay: 'hide',
                pagination: paginator(),

                comment_form: {
                    comment: null,
                },

                active_po: -1,
                PROCESS_STATUS : PROCESS_STATUS,
                SUPPLIER_BILL_URL:SUPPLIER_BILL_URL,
                initial_api: SUPPLIER_PO_URL,
                initial_payment_api: SUPPLIER_PAYMENTS_API+'/'+this.$route.params.uuid,
                SUPPLIER_PO_URL: SUPPLIER_PO_URL,
                SUPPLIER_PAYMENTS_ASSETS_API: SUPPLIER_PAYMENTS_ASSETS_API,
                SUPPLIER_PAYMENTS_API: SUPPLIER_PAYMENTS_API,

                is_initializing: false,
                processing: false,
                default_filter: 'All',
                default_api: SUPPLIER_PAYMENTS_API+'?page=1',
                po_list_ready: false,
                po_loading: false,
                mail_content: null,
                mailing_api: null,
                printing: false,
                add_comment: false,
                //
                filters: {},
                suppliers: [],
                facilities: [],
                customers: [],
                inventories: [],
                accounts: [],
                bank_accounts: [],
                currency: ACCOUNTING.CURRENCY,
                ACCOUNTING: ACCOUNTING,
                PAYMENTS_URL: INVENTORY_WEB_ROUTES.PURCHASES.BILLS,
                PAYMENTS_URL: INVENTORY_WEB_ROUTES.PURCHASES.PAYMENTS,
            }
        },

        watch: {
            default_api: function(){
                this.loadPayments(false);
            }
        },

        methods: {

            toggleAddComment(toggle_comment){
                this.add_comment = toggle_comment;
            },

            addComment(){
                this.processing = true;
                let api_ = SUPPLIER_PAYMENTS_API+'/'+this.payment.id+'?action='+FORM_ACTIONS.COMMENT;
                post(api_,this.comment_form)
                    .then((res) => {
                        if(res.data.status_code === 200) {
                            this.processing = false;
                            this.loadPayment();
                        }
                    }).catch((err) => {
                    if(err.response.status === 422) {
                        this.$awn.warning(createHtmlErrorString(err.response.data.errors));
                    }else if (err.response.status === 500){
                        this.$awn.warning(err.response.data.description);
                    }
                    else{
                        this.processing = false;
                        this.$awn.warning(err.response.data.description);
                    }
                    this.processing = false;
                });
            },

            calc_balance(net_total,payments,global_index){
                let balance = 0 + net_total;
                for (let index = 0; index < payments.length; index++) {
                    const element = payments[index];
                    balance -= element.amount;
                    if(global_index === index){
                        break;
                    }
                }
                return balance;
            },

            sub_total(journal,account_side){
                let result = 0;
                for (let index = 0; index < journal.length; index++) {
                    const element = journal[index];
                    switch (account_side) {
                        case ACCOUNTING.DEBIT:
                            if(element.balance_type === ACCOUNTING.DEBIT){
                                result+= element.amount;
                            }
                            break;
                        default: //Credit side summation
                            if(element.balance_type === ACCOUNTING.CREDIT){
                                result+= element.amount;
                            }
                            break;
                    }
                }
                return result;
            },

            total_values(journal,account_side){
                let total = 0;
                for (let index = 0; index < journal.length; index++) {
                    const element = journal[index];
                    for (let index = 0; index < element.length; index++) {
                        const element_child = element[index];
                        switch (account_side) {
                            case ACCOUNTING.DEBIT:
                                if(element_child.balance_type === ACCOUNTING.DEBIT){
                                    total+= element_child.amount;
                                }
                                break;
                            default: //Credit side
                                if(element_child.balance_type === ACCOUNTING.CREDIT){
                                    total+= element_child.amount;
                                }
                                break;
                        }
                    }
                }
                return total;
            },

            check_status(array_to,pin_to){
                let result = false;
                if( array_to[array_to.length-1].status === pin_to ){
                    result = true;
                }
                return result;
            },

            setBill(bill_obj,index=-1){
                this.active_po = index;
                this.po_loading = true;
                this.initial_payment_api = SUPPLIER_PAYMENTS_API+'/'+bill_obj.id;
                this.loadPayment();
            },

            printDocs(element_id,msg=null) {
                //printing(element_id,msg);
                this.log_print(element_id,msg);
            },

            log_print(element_id,msg){
                this.printing = true;
                let api_ = SUPPLIER_PAYMENTS_API+'/'+this.payment.id+'?action='+FORM_ACTIONS.PRINT;
                let form_ = {};
                post(api_,form_)
                    .then((res) => {
                        if(res.data.status_code === 200) {
                            this.loadPayment();
                            printing(element_id,msg);
                            this.printing = false;
                        }
                    }).catch((err) => {
                    if(err.response.status === 422) {
                        this.$awn.warning(createHtmlErrorString(err.response.data.errors));
                    }else if (err.response.status === 500){
                        this.$awn.warning(err.response.data.description);
                    }
                    else{
                        this.processing = false;
                        this.$awn.warning(err.response.data.description);
                    }
                    this.processing = false;
                    this.printing = false;
                });
            },

            check_all(event){
                this.selected_bills = [];
                if(event.target.checked){
                    for (let index = 0; index < this.bills.length; index++) {
                        const element = this.bills[index];
                        this.selected_bills.push(element.id);
                    }
                }
            },

            formatMoneys(money_to){
                return formatMoney(money_to);
            },

            loadPayments(show_progress=false){
                if(show_progress){
                    this.processing = true;
                }
                this.is_initializing = true;
                get(this.default_api)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.payments = res.data.results.data;
                        this.pagination = res.data.results.pagination;
                        this.filters = res.data.results.filters;
                        //console.info(this.filters);
                        if(show_progress){
                            this.loadPayment();
                            // this.is_initializing = false;
                            // this.page_loaded = true;
                        }else{
                            this.progress_overlay = "hide";
                            this.page_loaded = true;
                            this.processing = false;
                            this.page_ready = true;
                            this.is_initializing = false;
                        }
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

            filterBills(filter_by='All'){
                switch (filter_by) {
                    case PROCESS_STATUS.PARTIAL_PAID:
                        this.default_filter = filter_by;
                        this.default_api = SUPPLIER_PAYMENTS_API+'?page='+this.pagination.current_page+'&filter_by='+this.default_filter;
                        break;
                    case "Page":
                        if(this.default_filter==='All'){
                            this.default_api = SUPPLIER_PAYMENTS_API+'?page='+this.pagination.current_page;
                        }else{
                            this.default_api = SUPPLIER_PAYMENTS_API+'?page='+this.pagination.current_page+'&filter_by='+this.default_filter;
                        }
                        break;
                    default:
                        this.default_filter = filter_by;
                        this.default_api = SUPPLIER_PAYMENTS_API+'?page='+this.pagination.current_page;
                        break;
                }
            },

            loadPayment(){
                get(this.initial_payment_api)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.payment = res.data.results;
                        console.info(this.payment);
                        this.mail_content = create_mail_content(TRANSACTION_TYPES.SUPPLIER_PAYMENTS,this.payment,this.currency);
                        this.mailing_api = SUPPLIER_PAYMENTS_API+'/'+this.payment.id+'?action='+FORM_ACTIONS.SEND_MAIL;
                        this.progress_overlay = "hide";
                        this.page_loaded = true;
                        this.processing = false;
                        this.page_ready = true;
                        this.is_initializing = false;
                        this.po_loading = false;
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
                        this.loadTaxes(true);
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

            loadTerms(){
                get(SUPPLIER_TERMS_API)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.payment_terms = res.data.results.data;
                        // this.page_ready = true;
                        this.loadPayments(true);
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

            loadCashAccounts(){
                get(CHART_OF_ACCOUNTS+'?account_nature='+ACCOUNTING.ACCOUNT_NATURES.ASSETS)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.accounts = res.data.results.data;
                        //console.info(this.accounts);
                        //this.page_ready = true;
                        //this.loadBills();
                        this.loadTerms();
                    }
                }).catch((err) => {
                    this.progress_overlay = "hide";
                    this.page_ready = true;
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

            loadTaxes(){
                get(PRODUCT_TAX_URL)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.taxations = res.data.results.data;
                        //this.loadBills(true);
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

            loadFacilities(state_load=false){
                get(PRACTICES_API)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.facilities = res.data.results;
                        this.loadSuppliers(state_load);
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
            this.loadFacilities(true);
        }
    }
</script>

