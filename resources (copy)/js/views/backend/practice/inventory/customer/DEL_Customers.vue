<template>

    <div>

        <processing-overlay :message="'Loading. Please wait...'" :status="progress_overlay"></processing-overlay>

        <top-nav-bar :inventory="true"></top-nav-bar>

        <side-bar></side-bar>

        <div class="wp-content">

            <div class="row">

                <div class="col-md-12 col-lg-12 col-sm-12 padding-left-0">

                    <div class="settings-header shadowed main-heading bg-foo">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="pull pull-left app-header width-50-pc">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="ui fitted divider"></div>

                    <div class="row mg-top-35">

                        <div class="col-md-2 col-lg-2 col-sm-2 padding-right-0 bg-foo content-calculated-height">
                            <side-bar-customer :scrollable="false" :width="true" :transparent="true" :title="'Customers'" :active_num="'customers'"></side-bar-customer>
                        </div>


                        <div class="padding-right-0 padding-left-0 bg-foo content-calculated-height col-md-10 col-lg-10 col-sm-10">
                            
                            <div class="box box-primary bg-white border-top-0 mg-bottom-0 content-calculated-height border-bottom-0 no-shadowed">
                                <div class="width-40-pc padding-top-20 padding-bottom-20 pull-left mg-left-20">
                                    <search-item-form-control :field_wdth="300" :placeholder="'Search by name'"></search-item-form-control>
                                </div>
                                <div class="width-40-pc padding-left-20 padding-top-20 padding-bottom-20 pull-right mg-right-30">
                                    <div  class="btn-group float-right" role="group" aria-label="Button group with nested dropdown">
                                        <button data-toggle="modal" data-target="#customerModal" type="button" class="btn combo-button combo-default">+ New</button>
                                        <div class="btn-group" role="group">
                                            <button id="btnGroupDrop" type="button" class="btn combo-button combo-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="btnGroupDrop">
                                                <a class="dropdown-item"> Import Customers</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="width-100-pc padding-left-20 padding-top-20 padding-bottom-20 padding-right-50">
                                    <table class="user-table employees" role="presentation">
                                        <thead>
                                            <tr>
                                                <th class="no-rb" style="width:2%"></th>
                                                <th style="width:10%">ID</th>
                                                <th style="width:15%">Name</th>
                                                <th style="width:18%">Company</th>
                                                <th style="width:10%">Mobile</th>
                                                <th style="width:15%">Email</th>
                                                <th style="width:10%">Balance</th>
                                                <th style="width:10%">Status</th>
                                                <th style="width:10%"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(customer,index) in customers" class="tb-1" :key="'customers_'+index">
                                                <td class="no-rb" tabindex="0">
                                                    {{index+1}}
                                                </td>
                                                <td class="">
                                                    {{customer.business_id}}
                                                </td>
                                                <td class="">
                                                    {{customer.first_name}}
                                                </td>
                                                <td class="">
                                                    {{customer.company}}
                                                </td>
                                                <td class="">
                                                    {{customer.mobile}}
                                                </td>
                                                <td class="">
                                                    {{customer.email}}
                                                </td>
                                                <td class="">
                                                    <a v-if="customer.balance" data-toggle="modal" :data-target="'#receive_payment_'+index" class="fw-600 fs-12 pointer-cursor">{{formatMoneys(customer.balance)}}</a>
                                                    <a v-else>{{formatMoneys(customer.balance)}}</a>
                                                </td>
                                                <td class="">
                                                    <span v-if="customer.status" class="cl-success-light fw-600 fs-12">Active</span>
                                                    <span v-else class="fw-600 fs-12 cl-amref">Inactive</span>
                                                </td>
                                                <td class="">
                                                    <div  class="btn-group float-right" role="group" aria-label="Button group">
                                                        <div class="btn-group" role="group">
                                                            <a :id="'btnGroupDrop2_1'" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</a>
                                                            <div class="dropdown-menu" :aria-labelledby="'btnGroupDrop2_1'">
                                                                <a data-toggle="modal" :data-target="'#customerModal_'+index" class="dropdown-item">Edit</a>
                                                                <a class="dropdown-item">Preview</a>
                                                                <a class="dropdown-item">Print</a>
                                                                <a class="dropdown-item">Send</a>
                                                                <a class="dropdown-item">Update status</a>
                                                                <a class="dropdown-item">Copy</a>
                                                                <a v-if="customer.balance" data-toggle="modal" :data-target="'#receive_payment_'+index" class="dropdown-item">Receive Payment</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <!-- <customer-modal :user_mode="'Edit'" v-on:customerAdded="loadCustomers('hide')" :initial_url="CUSTOMERS_API" :title="'Customer Information'" :initializations="initializations" :modal_id="'customerModal_'+index"></customer-modal> -->
                                                <payment-modal v-if="customer.balance" :initializations="initializations" :user_mode="'Existing'" :customer="customer" :modal_title="'Receive Payment'" :modal_id="'receive_payment_'+index"></payment-modal>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <customer-modal v-if="page_loaded" :user_mode="'Create'" v-on:customerAdded="loadCustomers('hide')" :initial_url="CUSTOMERS_API" :title="'Customer Information'" :initializations="initializations" :modal_id="'customerModal'"></customer-modal>
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
    import SideBarSupply from "../../partials/sidebars/SideBarSupply";
    //import SideBarRequisitions from "../../partials/sidebars/SideBarRequisitions";
    import SideBarCustomer from "../../partials/sidebars/customer/SideBarCustomer";
    import PurchasesFilters from "../../partials/filters/PurchasesFilters";
    import PurchasesTable from "../../partials/tables/PurchasesTable";
    import CreatePurchaseModal from "../../partials/modals/purchase/CreatePurchaseModal";
    //import SupplyModal from "../../partials/modals/supply/SupplyModal";
    import ConfirmModal from "../../partials/modals/ConfirmModal";
    import EstimateModal from '../../partials/modals/customer/EstimateModal';
    import PaymentModal from '../../partials/modals/customer/PaymentModal';
    import CustomerModal from '../../partials/modals/customer/CustomerModal';
    import PaginateTemplate from '../../partials/pagination/PaginateTemplate';
    //import SupplyPreview from "../../partials/modals/supply/SupplyPreview";
    //import RequistionModal from '../../partials/modals/product/RequistionModal';
    import ProcessingOverlay from '../../../../progress/ProcessingOverlay';
    //  import SearchDatabaseFormControl from '../../partials/search/SearchDatabaseFormControl';
    import SearchItemFormControl from "../../partials/modals/product/SearchItemFormControl";
    import CommonLinks from "../../partials/sidebars/CommonLinks";
    import {get} from "../../../../../helpers/api";
    import Auth from "../../../../../store/auth";
    import EstimateView from './partials/Estimates';
    import {CUSTOMERS_ESTIMATES_API,CUSTOMERS_API,ACCOUNTS_INITIALS,PRODUCT_ITEMS_URL} from '../../../../../router/api_routes';
    import {createHtmlErrorString,formatMoney} from '../../../../../helpers/functionmixin';
    import {PROCESS_STATUS,ACCOUNTING} from '../../../../../helpers/process_status';
    export default {
        name: "Index",
        components: {TopNavBar,SideBar,ConfirmModal,PaginateTemplate,CustomerModal,EstimateView,CustomerModal,
        SideBarCustomer,ProcessingOverlay,CommonLinks,SearchItemFormControl,EstimateModal,PaymentModal},
        data(){
            return {
                
                initializations: {},
                products: [],
                customers: [],
                estimate_list: [],
                estimate: {},
                estimate_selected: false,
                view_toggler: true,
                page_loaded: false,
                progress_overlay: 'hide',
                pagination: {
                    'current_page': 1
                },
                active_menu: -1,
                PROCESS_STATUS : PROCESS_STATUS,
                initial_url:CUSTOMERS_ESTIMATES_API,
                CUSTOMERS_API:CUSTOMERS_API,
                ACCOUNTING:ACCOUNTING
            }
        },
        methods: {

            check_permissions(perm_){
                return Auth.menuChecker(perm_);
            },

            toggleView(state_){
                this.view_toggler = state_;
            },

            setEstimate(ests,index=-1){
                this.estimate = ests;
                this.estimate_selected = true;
                this.active_menu = index;
            },

            check_status(array_to,pin_to){
                let result = null;
                for (let index = 0; index < array_to.length; index++) {
                    const element = array_to[index];
                    if(element.status === pin_to){
                        result = element.date;
                        break;
                    }
                }
                return result;
            },

            customerModal(){
                $("#customerModal_0").modal('show');
            },

            formatMoneys(money_to){
                return formatMoney(money_to);
            },

            loadInitials(show_state="hide"){
              this.progress_overlay = show_state;
                get(ACCOUNTS_INITIALS)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.initializations = res.data.results;
                        console.info(this.initializations);
                        // this.progress_overlay = "hide";
                        // this.page_loaded = true;
                        this.loadCustomers(show_state);
                    }
                }).catch((err) => {
                    this.progress_overlay = "hide";
                    this.page_loaded = false;
                    if(err.response.status === 422) {
                        this.$awn.warning(createHtmlErrorString(err.response.data.errors))
                    }else if (err.response.status === 500){
                        this.$awn.warning(err.response.data.description);
                        window.location.href = "/500";
                    }
                    else{
                        this.processing = false;
                        this.$awn.warning(err.response.data.description)
                    }
                });
            },

            loadProducts(show_state){
                this.progress_overlay = show_state;
                get(PRODUCT_ITEMS_URL)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.products = res.data.results.data;
                        //console.info(this.products);
                        // this.progress_overlay = "hide";
                        // this.page_loaded = true;
                        this.loadEstimates(show_state);
                    }
                }).catch((err) => {
                    this.progress_overlay = "hide";
                    this.page_loaded = false;
                    if(err.response.status === 422) {
                        this.$awn.warning(createHtmlErrorString(err.response.data.errors))
                    }else if (err.response.status === 500){
                        this.$awn.warning(err.response.data.description);
                        window.location.href = "/500";
                    }
                    else{
                        this.processing = false;
                        this.$awn.warning(err.response.data.description)
                    }
                });
            },

            loadCustomers(show_state='show'){
                this.progress_overlay = show_state;
                get(CUSTOMERS_API)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.customers = res.data.results.data;
                        console.info(this.customers);
                        this.progress_overlay = "hide";
                        this.page_loaded = true;
                    }
                }).catch((err) => {
                    this.progress_overlay = "hide";
                    this.page_loaded = false;
                    if(err.response.status === 422) {
                        this.$awn.warning(createHtmlErrorString(err.response.data.errors))
                    }else if (err.response.status === 500){
                        this.$awn.warning(err.response.data.description);
                        window.location.href = "/500";
                    }
                    else{
                        this.processing = false;
                        this.$awn.warning(err.response.data.description)
                    }
                });
            }
            
        },
        mounted() {
            //this.initializations = Auth.getAccounting();
            //console.info(Auth.getAccounting())
            this.loadInitials("show");
        }
    }
</script>

