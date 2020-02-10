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
                                    <search-database-form-control :field_wdth="300" :placeholder="'Search here'"></search-database-form-control>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="ui fitted divider"></div>

                    <div class="row mg-top-35">

                        <div class="col-md-2 col-lg-2 col-sm-2 padding-right-0 bg-foo content-calculated-height">
                            <side-bar-customer :scrollable="false" :width="true" :transparent="true" :title="'Credit Notes'" :active_num="'credit_notes'"></side-bar-customer>
                        </div>

                        <div v-if="view_toggler" class="col-md-3 col-lg-3 col-sm-3 padding-right-0 bg-white padding-left-0 content-calculated-height">
                            <div class="estimate-list width-100-pc content-calculated-height">
                                <div class="estimate-list-head">
                                    <div class=" width-50-pc float-left">
                                        <div  class="btn-group" role="group" aria-label="Button group">
                                            <div class="btn-group" role="group">
                                                <a :id="'btnGroupDrop2_1'" class="dropdown-toggle fs-14 pointer-cursor fw-600" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    All Credit Notes
                                                </a>
                                                <div class="dropdown-menu" :aria-labelledby="'btnGroupDrop2_1'">
                                                    <a class="dropdown-item pointer-cursor">All</a>
                                                    <a class="dropdown-item pointer-cursor">Draft</a>
                                                    <a class="dropdown-item pointer-cursor">Sent</a>
                                                    <a class="dropdown-item pointer-cursor">Client viewed</a>
                                                    <a class="dropdown-item pointer-cursor">Invoiced</a>
                                                    <a class="dropdown-item pointer-cursor">Declined</a>
                                                    <a class="dropdown-item pointer-cursor">Expired</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class=" width-50-pc float-right">
                                        <button type="button" data-toggle="modal" data-target="#modal_id_invoice" class="btn btn-default btn-inventory btn-amref float-left">+New</button>
                                        <button v-if="estimate_selected" @click="toggleView(false)" type="button" class="btn btn-inventory btn-amref float-right"><i class="fa fa-bars" aria-hidden="true"></i></button>
                                        <credit-note-modal :modal_id="'modal_id_invoice'" :modal_title="'Credit Note'"></credit-note-modal>
                                    </div>
                                </div>
                                <div class="estimate-list-body height-scrollable-body">
                                    <table class="width-100-pc">
                                        
                                        <tbody v-for="(ests,index) in estimate_list" v-bind:class="{'active':active_menu===index}" :key="'estimate_list_'+index">
                                            <tr class="parent">
                                                <td style="width:10%"><input type="checkbox"> </td>
                                                <td style="width:55%">{{ests.customer.first_name}} {{ests.customer.other_name}}</td>
                                                <td style="width:35%" class="text-right fs-12 cl-444 fw-600">{{ACCOUNTING.CURRENCY}}{{formatMoneys(ests.total-ests.discount_allowed-ests.taxe_collected)}}</td>
                                            </tr>
                                            <tr class="child">
                                                <td style="width:10%" class="text-right"></td>
                                                <td style="width:55%">
                                                    <a @click="setEstimate(ests,index)" class="txt-uppercase fs-12 cl-blue-link fw-600">{{ests.trans_number}}</a> | <a @click="setEstimate(ests,index)" class="fs-12 cl-787887 fw-600 txt-uppercase">{{ests.estimate_date}}</a>
                                                </td>
                                                <td style="width:35%" class="text-right">
                                                    <a v-if="check_status(ests.trans_status,PROCESS_STATUS.ACCEPTED)" @click="setEstimate(ests,index)" class="txt-uppercase fs-12 fw-600 cl-success-light">Accepted</a>
                                                    <a v-else-if="check_status(ests.trans_status,PROCESS_STATUS.DRAFT)" @click="setEstimate(ests,index)" class="txt-uppercase fs-12 fw-600 cl-787887">Draft</a>
                                                    <a v-else-if="check_status(ests.trans_status,PROCESS_STATUS.DECLINED)" @click="setEstimate(ests,index)" class="txt-uppercase fs-12 fw-600 cl-amref">Declined</a>
                                                    <a v-else-if="check_status(ests.trans_status,PROCESS_STATUS.EXPIRED)" @click="setEstimate(ests,index)" class="txt-uppercase fs-12 fw-600 cl-787887">Expired</a>
                                                    <a v-else-if="check_status(ests.trans_status,PROCESS_STATUS.INVOICED)" @click="setEstimate(ests,index)" class="txt-uppercase fs-12 fw-600 cl-success-light">Invoiced</a>
                                                    <a v-else-if="check_status(ests.trans_status,PROCESS_STATUS.SENT)" @click="setEstimate(ests,index)" class="txt-uppercase fs-12 fw-600 cl-blue-link">Sent</a>
                                                    <a v-else="" @click="setEstimate(ests,index)" class="txt-uppercase fs-12 fw-600 cl-787887">Pending</a>
                                                </td>
                                            </tr>
                                        </tbody>

                                    </table>
                                </div>
                            </div>
                        </div>

                        <div v-if="view_toggler" class="padding-right-0 padding-left-0 bg-foo content-calculated-height col-md-7 col-lg-7 col-sm-7">
                            
                            <div v-if="estimate_selected" class="box box-primary bg-white border-top-0 mg-bottom-0 content-calculated-height border-bottom-0 no-shadowed">

                                <estimate-view :ACCOUNTING="ACCOUNTING" v-on:toggleView="toggleView" :estimate="estimate" :view_toggler="view_toggler"></estimate-view>

                                <estimate-modal v-if="page_loaded" :modal_id="'estimate_modal_id'" :products="products" :initializations="initializations" v-on:customerForm="customerModal" :modal_title="'Estimate'"></estimate-modal>
                                <customer-modal v-if="page_loaded" :user_mode="'Create'" v-on:customerAdded="loadInitials('hide')" :initial_url="CUSTOMERS_API" :title="'Customer Information'" :initializations="initializations" :modal_id="'customerModal_0'"></customer-modal>

                            </div>

                            <div v-else class="box box-primary bg-white border-top-0 mg-bottom-0 content-calculated-height border-bottom-0 no-shadowed">

                                <div class="row justify-content-center">

                                    <div class="col-md-3">

                                        <div class="no-doc mg-top-170">

                                            <img src="/assets/icons/dashboard/quotation">

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>


                        <div v-if="!view_toggler" class="padding-right-0 padding-left-0 bg-foo content-calculated-height col-md-10 col-lg-10 col-sm-10">
                            
                            <div v-if="estimate_selected" class="box box-primary bg-white border-top-0 mg-bottom-0 content-calculated-height border-bottom-0 no-shadowed">

                                <estimate-view :ACCOUNTING="ACCOUNTING" v-on:toggleView="toggleView" :estimate="estimate" :view_toggler="view_toggler"></estimate-view>

                                <estimate-modal v-if="page_loaded" :modal_id="'estimate_modal_id'" :products="products" :initializations="initializations" v-on:customerForm="customerModal" :modal_title="'Estimate'"></estimate-modal>
                                <customer-modal v-if="page_loaded" :user_mode="'Create'" v-on:customerAdded="loadInitials('hide')" :initial_url="CUSTOMERS_API" :title="'Customer Information'" :initializations="initializations" :modal_id="'customerModal_0'"></customer-modal>

                            </div>

                            <div v-else class="box box-primary bg-white border-top-0 mg-bottom-0 content-calculated-height border-bottom-0 no-shadowed">

                                <div class="row justify-content-center">

                                    <div class="col-md-3">

                                        <div class="no-doc mg-top-170">

                                            <img src="/assets/icons/dashboard/quotation">

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
    import SideBarSupply from "../../partials/sidebars/SideBarSupply";
    //import SideBarRequisitions from "../../partials/sidebars/SideBarRequisitions";
    import SideBarCustomer from "../../partials/sidebars/customer/SideBarCustomer";
    import PurchasesFilters from "../../partials/filters/PurchasesFilters";
    import PurchasesTable from "../../partials/tables/PurchasesTable";
    import CreatePurchaseModal from "../../partials/modals/purchase/CreatePurchaseModal";
    //import SupplyModal from "../../partials/modals/supply/SupplyModal";
    import ConfirmModal from "../../partials/modals/ConfirmModal";
    import EstimateModal from '../../partials/modals/customer/EstimateModal';
    import CreditNoteModal from '../../partials/modals/product/CreditNoteModal'
    import PaginateTemplate from '../../partials/pagination/PaginateTemplate';
    //import SupplyPreview from "../../partials/modals/supply/SupplyPreview";
    //import RequistionModal from '../../partials/modals/product/RequistionModal';
    import ProcessingOverlay from '../../../../progress/ProcessingOverlay';
     import SearchDatabaseFormControl from '../../partials/search/SearchDatabaseFormControl';
    import CommonLinks from "../../partials/sidebars/CommonLinks";
    import {get} from "../../../../../helpers/api";
    import Auth from "../../../../../store/auth";
    import EstimateView from './partials/Estimates';
    import CustomerModal from '../../partials/modals/customer/CustomerModal';
    import {CUSTOMERS_ESTIMATES_API,ACCOUNTS_INITIALS,CUSTOMERS_API,PRODUCT_ITEMS_URL} from '../../../../../router/api_routes';
    import {createHtmlErrorString,formatMoney} from '../../../../../helpers/functionmixin';
    import {PROCESS_STATUS,ACCOUNTING} from '../../../../../helpers/process_status';
    export default {
        name: "Index",
        components: {TopNavBar,SideBar,ConfirmModal,PaginateTemplate,CustomerModal,EstimateView,CreditNoteModal,
        SideBarCustomer,ProcessingOverlay,CommonLinks,SearchDatabaseFormControl,EstimateModal},
        data(){
            return {
                
                initializations: {},
                products: [],
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
                        // console.info(this.initializations);
                        // this.progress_overlay = "hide";
                        // this.page_loaded = true;
                        this.loadProducts(show_state);
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
            loadEstimates(show_state='show'){
                this.progress_overlay = show_state;
                get(CUSTOMERS_ESTIMATES_API)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.estimate_list = res.data.results.data;
                        console.info(this.estimate_list);
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

