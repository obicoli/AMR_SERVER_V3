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
                                                <div v-if="page_ready && payments.length" class="width-100-pc float-left">
                                                    <div class="float-left width-40-pc">
                                                        <div class="btn-group" role="group" aria-label="Button group">
                                                            <div class="btn-group" role="group">
                                                                <a :id="'btnGroupDrop2_1'" class="dropdown-toggle fs-14 pointer-cursor fw-600 txt-uppercase" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                    All Payments
                                                                </a>
                                                                <div class="dropdown-menu" :aria-labelledby="'btnGroupDrop2_1'">
                                                                    <a class="dropdown-item pointer-cursor">All Payments</a>
                                                                    <a class="dropdown-item separator"></a>
                                                                    <a class="dropdown-item pointer-cursor">New Custom view</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="width-60-pc float-right">
                                                        <quick-link :active_link="'payments'"></quick-link>
                                                    </div>
                                                </div>
                                                <div class="width-100-pc float-left mg-top-45">
                                                    <div v-if="page_ready && payments.length" class="width-100-pc float-left mg-top-30 mg-bottom-50">
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
                                                                    <a data-toggle="modal" data-target="#new_bill_id" class="dropdown-item pointer-cursor">Recurring Bill</a>
                                                                    <a data-toggle="modal" data-target="#new_bill_id" class="dropdown-item pointer-cursor">Payments</a>
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
                                                                        <th style="width:22%">Supplier</th>
                                                                        <th style="width:12%">Date</th>
                                                                        <th style="width:12%;">Payment#</th>
                                                                        <th style="width:12%">Reference</th>
                                                                        <th style="width:15%;">Bill#</th>
                                                                        <th style="width:10%;">Mode</th>
                                                                        <th style="width:15%;" class="text-right">Amount</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody v-if="processing || is_initializing">
                                                                    <tr>
                                                                        <td class="somepad text-center" colspan="9">
                                                                            <img src="/assets/icons/dashboard/loader.gif">
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                                <tbody v-for="(payment,index) in payments" :key="'payment_'+index">
                                                                    <tr>
                                                                        <td class="somepad">
                                                                            <input :disabled="is_initializing || processing" v-model="selected_payments" type="checkbox" class="pointer-cursor" :value="payment.id">
                                                                        </td>
                                                                        <router-link tag="td" :to="'/suppliers/payments'+'/'+payment.id+'/view'" class="somepad pointer-cursor">
                                                                            {{payment.bill.vendor.legal_name}}
                                                                        </router-link>
                                                                        <router-link tag="td" :to="'/suppliers/payments'+'/'+payment.id+'/view'" class="somepad pointer-cursor">
                                                                            {{payment.payment_date}}
                                                                        </router-link>
                                                                        <router-link tag="td" :to="'/suppliers/payments'+'/'+payment.id+'/view'" class="somepad pointer-cursor cl-blue-link fw-600">
                                                                            {{payment.trans_number}}
                                                                        </router-link>
                                                                        <router-link tag="td" :to="'/suppliers/payments'+'/'+payment.id+'/view'" class="somepad pointer-cursor">
                                                                            {{payment.reference_number}}
                                                                        </router-link>
                                                                        <router-link tag="td" :to="'/suppliers/payments'+'/'+payment.id+'/view'" class="somepad pointer-cursor">
                                                                            {{payment.bill.trans_number}}
                                                                        </router-link>
                                                                        <router-link tag="td" :to="'/suppliers/payments'+'/'+payment.id+'/view'" class="somepad pointer-cursor">
                                                                            {{payment.payment_method}}
                                                                        </router-link>
                                                                        <router-link tag="td" :to="'/suppliers/payments'+'/'+payment.id+'/view'" class="somepad pointer-cursor text-right">
                                                                            {{currency+' '+format_money(payment.amount)}}
                                                                        </router-link>
                                                                        <!-- <router-link tag="td" :to="'/suppliers/bills'+'/'+payment.id+'/view'" class="somepad pointer-cursor">
                                                                            {{payment.vendor.legal_name}}
                                                                        </router-link>
                                                                        <router-link tag="td" :to="'/suppliers/payments'+'/'+payment.id+'/view'" class="somepad pointer-cursor">
                                                                            {{payment.payment_date}}
                                                                        </router-link>
                                                                        <router-link tag="td" :to="'/suppliers/payments'+'/'+payment.id+'/view'" class="somepad pointer-cursor cl-blue-link fw-600">
                                                                            {{payment.trans_number}}
                                                                        </router-link>
                                                                        <router-link tag="td" :to="'/suppliers/payments'+'/'+payment.id+'/view'" class="somepad pointer-cursor">
                                                                            {{payment.ref_number}}
                                                                        </router-link>
                                                                        <router-link tag="td" :to="'/suppliers/payments'+'/'+payment.id+'/view'" class="somepad pointer-cursor fw-600 fs-12 cl-444 text-right">
                                                                            {{payment.vendor.currency.currency_sympol+' '+format_money(payment.net_total)}}
                                                                        </router-link>
                                                                        <router-link tag="td" :to="'/suppliers/payments'+'/'+payment.id+'/view'" class="somepad pointer-cursor">
                                                                            <a v-if="payment.status[payment.status.length-1].status===PROCESS_STATUS.ACCEPTED" class="txt-uppercase fs-12 fw-600 cl-success-light">Accepted</a>
                                                                            <a v-else-if="payment.status[payment.status.length-1].status===PROCESS_STATUS.DRAFT" class="documentStatus draft">{{PROCESS_STATUS.DRAFT}}</a>
                                                                            <a v-else-if="payment.status[payment.status.length-1].status===PROCESS_STATUS.DECLINED" class="txt-uppercase fs-12 fw-600 cl-amref">Declined</a>
                                                                            <a v-else-if="payment.status[payment.status.length-1].status===PROCESS_STATUS.EXPIRED" class="txt-uppercase fs-12 fw-600 cl-787887">Expired</a>
                                                                            <a v-else-if="payment.status[payment.status.length-1].status===PROCESS_STATUS.INVOICED" class="txt-uppercase fs-12 fw-600 cl-success-light">Invoiced</a>
                                                                            <a v-else-if="payment.status[payment.status.length-1].status===PROCESS_STATUS.PAID" class="documentStatus paid">{{PROCESS_STATUS.PAID}}</a>
                                                                            <a v-else-if="payment.status[payment.status.length-1].status===PROCESS_STATUS.SENT" class="txt-uppercase fs-12 fw-600 cl-blue-link">Sent</a>
                                                                            <a v-else-if="payment.status[payment.status.length-1].status===PROCESS_STATUS.OPEN" class="documentStatus open">{{PROCESS_STATUS.OPEN}}</a>
                                                                            <a v-else-if="payment.status[payment.status.length-1].status===PROCESS_STATUS.CLOSED" class="documentStatus closed">{{PROCESS_STATUS.CLOSED}}</a>
                                                                            <a v-else="" class="documentStatus pending">Pending</a>
                                                                        </router-link>
                                                                        <router-link tag="td" :to="'/suppliers/payments'+'/'+payment.id+'/view'" class="somepad pointer-cursor">
                                                                            <a v-if="payment.is_overdue" class="documentStatus overdue">Overdue</a>
                                                                            <a v-else class="cl-444">{{payment.payment_due_date}}</a>
                                                                        </router-link>
                                                                        <router-link tag="td" :to="'/suppliers/payments'+'/'+payment.id+'/view'" class="somepad pointer-cursor">
                                                                            {{payment.vendor.currency.currency_sympol+' '+format_money(payment.net_total-payment.cash_paid)}}
                                                                        </router-link>
                                                                        <delete-modal :modal_title="'Delete payment'" :confirm_message="'Are you sure?'" :modal_id="'delete_transaction_'"></delete-modal> -->
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                    <div v-if="page_ready && payments.length===0 && default_filter==='All' && is_initializing===false && processing===false" class="width-100-pc float-left mg-top-10 mg-bottom-50 text-center">
                                                        <div class="width-100-pc text-center float-left">
                                                            <a class="fs-15 txt-uppercase cl-444 fw-600">Create. Set. Repeat.</a><br>
                                                            <small class="fs-13 cl-777">Do you pay bills every so often? Start paying your vendors on time by creating recurring bills.</small><br><br>
                                                            <a data-toggle="modal" data-target="#new_bill_id" class="btn btn-secondary banking-process-amref">Create a Recurring Bill</a>
                                                        </div>
                                                        <div class="width-100-pc text-center float-left mg-top-20">
                                                            <img src="/assets/icons/dashboard/recur_bills.png" class=" mg-bottom-20">
                                                        </div>
                                                    </div>
                                                    <copy-right></copy-right>
                                                    <bill-modal v-if="page_ready" :taxations="taxations" :inventories="inventories" :accounts="accounts" :bank_accounts="bank_accounts" :filters="filters" :billable="false" :payment_terms="payment_terms" :currency="currency" :bill_api="SUPPLIER_BILL_URL" :billable_type="'PO'" :suppliers="suppliers" :order="bill" :modal_id="'new_bill_id'" :modal_title="'New Recurring Bill'" @create-bill-event="loadBills"></bill-modal>
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

    import {removeElement,paginator,formatMoney, createHtmlErrorString} from "../../../../../../helpers/functionmixin";
    import {AC_TYPES, PROCESS_STATUS,ACCOUNTING,TRANSACTION_TYPES} from "../../../../../../helpers/process_status";
    import {SUPPLIER_PAYMENTS_API} from '../../../../../../router/api_routes';
    export default {
        name: "RecurIndex",
        components: {TopNavBar,PaginateTemplate,SideBar,DeleteModal,CopyRight,BillModal,
        ProcessingOverlay,PoModal,QuickLink},
        data(){
            return {
                purchase_orders: [],
                msg: 'Loading. Please wait...',
                progress_overlay: 'hide',
                page_ready: false,
                is_initializing: false,
                processing: false,
                purchase_order: {},
                //
                pagination: paginator(),
                currency: ACCOUNTING.CURRENCY,
                filters: {},
                suppliers: [],
                selected_payments: [],
                payments: [],
                default_filter: 'All',
            }
        },
        methods: {

            format_money(money_to){
                return formatMoney(money_to);
            },
            loadBills(show_progress){
                //this.progress_overlay = "show";
                this.is_initializing = show_progress;
                get(SUPPLIER_PAYMENTS_API)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        //this.payments = res.data.results.data;
                        this.filters = res.data.results.filters;
                        this.progress_overlay = "hide";
                        this.page_ready = true;
                        this.processing = false;
                        this.is_initializing = false;
                        console.info(this.payments);
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
            this.loadBills(true);
            
        }
    }
</script>

<style lang="scss">
    th {
        position: sticky;
        top: 0px;
    }
</style>