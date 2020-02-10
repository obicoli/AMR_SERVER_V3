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
                                                <div :hidden="purchase_orders.length===0 && default_filter==='All'" class="width-100-pc float-left">
                                                    <div class="btn-group" role="group">
                                                        <a :id="'btnGroupDrop2_1'" class="dropdown-toggle pointer-cursor fw-600 cl-444 fs-16" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            {{default_filter}} Purchase Orders({{pagination.total}})
                                                        </a>
                                                        <div class="dropdown-menu" :aria-labelledby="'btnGroupDrop2_1'">
                                                            <a @click="filterPo('All')" class="dropdown-item pointer-cursor">All</a>
                                                            <a @click="filterPo(PROCESS_STATUS.DRAFT)" class="dropdown-item pointer-cursor">{{PROCESS_STATUS.DRAFT}}</a>
                                                            <a @click="filterPo(PROCESS_STATUS.PENDING_APPROVAL)" class="dropdown-item pointer-cursor">{{PROCESS_STATUS.PENDING_APPROVAL}}</a>
                                                            <a @click="filterPo(PROCESS_STATUS.APPROVED)" class="dropdown-item pointer-cursor">{{PROCESS_STATUS.APPROVED}}</a>
                                                            <a @click="filterPo(PROCESS_STATUS.OPEN)" class="dropdown-item pointer-cursor">{{PROCESS_STATUS.OPEN}}</a>
                                                            <a @click="filterPo(PROCESS_STATUS.BILLED)" class="dropdown-item pointer-cursor">{{PROCESS_STATUS.BILLED}}</a>
                                                            <a @click="filterPo(PROCESS_STATUS.PARTIAL_BILLED)" class="dropdown-item pointer-cursor">{{PROCESS_STATUS.PARTIAL_BILLED}}</a>
                                                            <a @click="filterPo(PROCESS_STATUS.CLOSED)" class="dropdown-item pointer-cursor">{{PROCESS_STATUS.CLOSED}}</a>
                                                            <a @click="filterPo(PROCESS_STATUS.CANCELLED)" class="dropdown-item pointer-cursor">{{PROCESS_STATUS.CANCELLED}}</a>
                                                            <a class="dropdown-item separator"></a>
                                                            <a class="dropdown-item pointer-cursor">New Custom view</a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="width-100-pc float-left mg-top-10">

                                                    <div v-if="page_ready && purchase_orders.length===0 && default_filter==='All' && is_initializing===false && processing===false" class="width-100-pc float-left mg-top-20 mg-bottom-50 text-center">
                                                        <a class="fw-600 cl-444 fs-17">Purchase Orders</a>
                                                        <div class="width-100-pc text-center float-left">
                                                            <p class="fs-14">Start Managing your Purchasing Activities!</p><br>
                                                            <small class="fs-12 cl-777">Create, customize and send proffessional Purchase Orders to your supplier.</small><br><br>
                                                            <a data-toggle="modal" data-target="#new_po_modal" class="btn btn-secondary banking-process-amref">Create New Purchase Order</a>
                                                        </div>
                                                        <div class="width-100-pc text-center float-left mg-top-20">
                                                            <img src="/assets/icons/dashboard/po_cycle.png" class=" mg-bottom-20">
                                                        </div>
                                                    </div>

                                                    <div v-else-if="page_ready && purchase_orders.length || purchase_orders.length===0" class="width-100-pc float-left mg-top-30 mg-bottom-50">

                                                        <div class="width-45-pc float-left mg-right-15 mg-bottom-15">
                                                            <div class="width-60-pc float-left">
                                                                <div class="dijitInline firstName dijitTextBox width-100-pc">
                                                                    <input placeholder="Search by PO Number" :disabled="is_initializing || processing" type="text">
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
                                                                    <a class="dropdown-item separator"></a>
                                                                    <a @click="printDocs('po_list_id_0')" class="dropdown-item pointer-cursor">Print</a>
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
                                                                        <th style="width:23%">Supplier</th>
                                                                        <th style="width:10%">Date</th>
                                                                        <th style="width:10%;">PO Number</th>
                                                                        <th style="width:10%">Reference</th>
                                                                        <th style="width:15%;">Amount</th>
                                                                        <th style="width:10%;">Billed Status</th>
                                                                        <th style="width:10%;">Due Date</th>
                                                                        <th style="width:10%;">Status</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody v-if="processing || is_initializing">
                                                                    <tr>
                                                                        <td class="somepad text-center" colspan="9">
                                                                            <img src="/assets/icons/dashboard/loader.gif">
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                                <tbody v-if="purchase_orders.length===0 && processing===false && is_initializing===false">
                                                                    <tr>
                                                                        <td class="somepad text-center cl-amref" colspan="9">
                                                                            No data to display!
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                                <tbody v-for="(purchase_order,index) in purchase_orders" :key="'chart_of_accounts_'+index">
                                                                    <tr>
                                                                        <td class="somepad">
                                                                            <input :disabled="is_initializing || processing" v-model="selected_po" type="checkbox" class="pointer-cursor" :value="purchase_order.id">
                                                                        </td>
                                                                        <router-link tag="td" :to="'/purchases/purchase_orders/'+purchase_order.id+'/view'" class="somepad pointer-cursor">
                                                                            {{purchase_order.vendor.legal_name}}
                                                                        </router-link>
                                                                        <router-link tag="td" :to="'/purchases/purchase_orders/'+purchase_order.id+'/view'" class="somepad pointer-cursor">
                                                                            {{purchase_order.po_date}}
                                                                        </router-link>
                                                                        <router-link tag="td" :to="'/purchases/purchase_orders/'+purchase_order.id+'/view'" class="somepad pointer-cursor cl-amref fw-600">
                                                                            {{purchase_order.trans_number}}
                                                                        </router-link>
                                                                        <router-link tag="td" :to="'/purchases/purchase_orders/'+purchase_order.id+'/view'" class="somepad pointer-cursor">
                                                                            {{purchase_order.ref_number}}
                                                                        </router-link>
                                                                        
                                                                        <router-link tag="td" :to="'/purchases/purchase_orders/'+purchase_order.id+'/view'" class="somepad pointer-cursor fw-600 fs-12 cl-444 text-right">
                                                                            {{purchase_order.vendor.currency.currency_sympol+' '+format_money(purchase_order.total_bill)}}
                                                                        </router-link>
                                                                        <router-link tag="td" :to="'/purchases/purchase_orders/'+purchase_order.id+'/view'" class="somepad pointer-cursor">
                                                                            
                                                                        </router-link>
                                                                        <router-link tag="td" :to="'/purchases/purchase_orders/'+purchase_order.id+'/view'" class="somepad pointer-cursor">
                                                                            {{purchase_order.po_due_date}}
                                                                        </router-link>
                                                                        <router-link tag="td" :to="'/purchases/purchase_orders/'+purchase_order.id+'/view'" class="somepad pointer-cursor">
                                                                            <a v-if="purchase_order.status[purchase_order.status.length-1].status===PROCESS_STATUS.ACCEPTED" class="txt-uppercase fs-12 fw-600 cl-success-light">Accepted</a>
                                                                            <a v-else-if="purchase_order.status[purchase_order.status.length-1].status===PROCESS_STATUS.DRAFT" class="documentStatus draft">{{PROCESS_STATUS.DRAFT}}</a>
                                                                            <a v-else-if="purchase_order.status[purchase_order.status.length-1].status===PROCESS_STATUS.DECLINED" class="txt-uppercase fs-12 fw-600 cl-amref">Declined</a>
                                                                            <a v-else-if="purchase_order.status[purchase_order.status.length-1].status===PROCESS_STATUS.EXPIRED" class="txt-uppercase fs-12 fw-600 cl-787887">Expired</a>
                                                                            <a v-else-if="purchase_order.status[purchase_order.status.length-1].status===PROCESS_STATUS.INVOICED" class="txt-uppercase fs-12 fw-600 cl-success-light">Invoiced</a>
                                                                            <a v-else-if="purchase_order.status[purchase_order.status.length-1].status===PROCESS_STATUS.SENT" class="txt-uppercase fs-12 fw-600 cl-blue-link">Sent</a>
                                                                            <a v-else-if="purchase_order.status[purchase_order.status.length-1].status===PROCESS_STATUS.OPEN" class="documentStatus open">{{PROCESS_STATUS.OPEN}}</a>
                                                                            <a v-else-if="purchase_order.status[purchase_order.status.length-1].status===PROCESS_STATUS.CLOSED" class="documentStatus closed">{{PROCESS_STATUS.CLOSED}}</a>
                                                                            <a v-else="" class="txt-uppercase fs-12 fw-600 cl-787887">Pending</a>
                                                                        </router-link>
                                                                        <delete-modal :modal_title="'Delete Account'" :confirm_message="'Are you sure?'" :modal_id="'delete_transaction_'"></delete-modal>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>

                                                        <div class="width-20-pc float-left">
                                                            <div class="btn-group" role="group">
                                                                <button :disabled="is_initializing || processing || selected_po.length===0 " :id="'btnGroupDrop2_1'" class="dropdown-toggle btn btn-secondary banking-process-amref" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                    <span v-if="selected_po.length">{{selected_po.length}} PO selected</span>
                                                                    <span v-else>Batch Action</span>
                                                                </button>
                                                                <div class="dropdown-menu" :aria-labelledby="'btnGroupDrop2_1'">
                                                                    <a data-toggle="modal" data-target="#" class="dropdown-item pointer-cursor fs-12">Add Bill</a>
                                                                    <a class="dropdown-item separator"></a>
                                                                    <a data-toggle="modal" data-target="#" class="dropdown-item pointer-cursor fs-12">Update status</a>
                                                                    <a data-toggle="modal" data-target="#" class="dropdown-item pointer-cursor fs-12">Copy Purchase Order</a>
                                                                    <a class="dropdown-item separator"></a>
                                                                    <a data-toggle="modal" data-target="#" class="dropdown-item pointer-cursor fs-12">Delete</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="width-80-pc float-right text-right">
                                                            <paginate-template v-if="pagination.last_page > 1" :pagination="pagination" :offset="5" @paginate="filterPo('Page')" :custom="true"></paginate-template>
                                                        </div>
                                                    </div>
                                                    <div v-else class="width-100-pc float-left mg-top-60 text-center">
                                                        <img class="loader" src="/assets/icons/dashboard/loader.gif">
                                                    </div>
                                                    <copy-right></copy-right>
                                                    <po-modal v-if="page_ready" :currency="currency" :taxations="taxations" :supplier_po_api="SUPPLIER_PO_URL" :user_mode="'Create'" :filters="filters" @po-create-event="loadPo(true)" :suppliers="suppliers" :facilities="facilities" :customers="customers" :modal_id="'new_po_modal'" :modal_title="'New Purchase Order'"></po-modal>
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
    // import Datepicker from 'vuejs-datepicker';
    import {removeElement,paginator,formatMoney, createHtmlErrorString,printing} from "../../../../../../helpers/functionmixin";
    import {AC_TYPES, PROCESS_STATUS,ACCOUNTING,TRANSACTION_TYPES} from "../../../../../../helpers/process_status";
    import {BANKING_ACCOUNTS_TYPES_URL,SUPPLIER_PO_URL,PRACTICES_API,SUPPLIER_URL,PRODUCT_TAX_URL} from '../../../../../../router/api_routes';
    export default {
        name: "PoIndex",
        components: {TopNavBar,PaginateTemplate,SideBar,DeleteModal,CopyRight,
        ProcessingOverlay,PoModal},
        data(){
            return {
                purchase_orders: [],
                selected_po: [],
                msg: 'Loading. Please wait...',
                progress_overlay: 'hide',
                page_ready: false,
                is_initializing: false,
                processing: false,
                //
                pagination: paginator(),
                currency: ACCOUNTING.CURRENCY,
                filters: {},
                suppliers: [],
                facilities: [],
                customers: [],
                taxations: [],
                PROCESS_STATUS: PROCESS_STATUS,
                default_filter: 'All',
                default_api: SUPPLIER_PO_URL+'?page=1',
                SUPPLIER_PO_URL:SUPPLIER_PO_URL,
            }
        },

        watch: {
            default_api: function(){
                this.loadPo(true);
            }
        },

        methods: {

            format_money(money_to){
                return formatMoney(money_to);
            },

            printDocs(element_id) {
                printing(element_id);
            },

            check_all(event){
                this.selected_po = [];
                if(event.target.checked){
                    for (let index = 0; index < this.purchase_orders.length; index++) {
                        const element = this.purchase_orders[index];
                        this.selected_po.push(element.id);
                    }
                }
            },

            filterPo(filter_by='All'){
                switch (filter_by) {
                    case PROCESS_STATUS.CANCELLED:
                    case PROCESS_STATUS.CLOSED:
                    case PROCESS_STATUS.PARTIAL_BILLED:
                    case PROCESS_STATUS.BILLED:
                    case PROCESS_STATUS.OPEN:
                    case PROCESS_STATUS.DRAFT:
                    case PROCESS_STATUS.PENDING_APPROVAL:
                    case PROCESS_STATUS.APPROVED:
                        this.default_filter = filter_by;
                        this.default_api = SUPPLIER_PO_URL+'?page='+this.pagination.current_page+'&filter_by='+this.default_filter;
                        break;
                    case "Page":
                        if(this.default_filter==='All'){
                            this.default_api = SUPPLIER_PO_URL+'?page='+this.pagination.current_page;
                        }else{
                            this.default_api = SUPPLIER_PO_URL+'?page='+this.pagination.current_page+'&filter_by='+this.default_filter;
                        }
                        break;
                    default:
                        this.default_filter = filter_by;
                        this.default_api = SUPPLIER_PO_URL+'?page='+this.pagination.current_page;
                        break;
                }
            },

            loadPo(show_progress=false){
                if(show_progress){
                    this.processing = true;
                }
                get(this.default_api)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.purchase_orders = res.data.results.data;
                        this.filters = res.data.results.filters;
                        this.pagination = res.data.results.pagination;
                        //console.info(this.pagination);
                        this.progress_overlay = "hide";
                        this.page_ready = true;
                        this.is_initializing = false;
                        this.processing = false;
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
                        //console.info(this.suppliers);
                        this.loadFacilities();
                        // this.progress_overlay = "hide";
                        // this.page_ready = true;
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

            loadFacilities(state_load="show"){
                //this.progress_overlay = state_load;
                get(PRACTICES_API)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.facilities = res.data.results;
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
                get(PRODUCT_TAX_URL)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.taxations = res.data.results.data;
                        this.loadPo();
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