<template>

    <div>

        <processing-overlay :message="'Loading. Please wait...'" :status="progress_overlay"></processing-overlay>

        <top-nav-bar :inventory="true"></top-nav-bar>

        <side-bar></side-bar>

        <div class="wp-content content-calculated-height-wc">

            <div class="row">

                <div class="col-md-12 col-lg-12 col-sm-12 padding-left-0 content-calculated-height-50">

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

                        <div class="col-md-2 col-lg-2 col-sm-2 padding-right-0 bg-foo content-calculated-height-50">
                            <side-bar-inventory v-if="page_loaded" :supplier="true" :scrollable="true" :width="true" :transparent="true" :active_num="'vendors'" :title="'Vendors'"></side-bar-inventory>
                        </div>

                        <div class="col-md-3 col-lg-3 col-sm-3 padding-right-0 bg-white padding-left-0 content-calculated-height-50 max-width-150-px">
                            <div class="estimate-list width-100-pc content-calculated-height-50">
                                <div class="estimate-list-head">
                                    <div class=" width-50-pc float-left">
                                        <div  class="btn-group" role="group" aria-label="Button group">
                                            <div class="btn-group" role="group">
                                                <a :id="'btnGroupDrop2_1'" class="dropdown-toggle fs-14 pointer-cursor fw-600 txt-uppercase" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    All Vendors
                                                </a>
                                                <div class="dropdown-menu" :aria-labelledby="'btnGroupDrop2_1'">
                                                    <a class="dropdown-item txt-uppercase cl-777 fs-12">Default Filters</a>
                                                    <a class="dropdown-item pointer-cursor">All Vendors</a>
                                                    <a class="dropdown-item pointer-cursor">Active</a>
                                                    <a class="dropdown-item pointer-cursor">Inactive</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="width-50-pc float-right">
                                        <div class="btn-group float-right" role="group">
                                            <a :id="'btnGroupDrop2_1'" class="dropdown-toggle btn btn-default btn-inventory btn-white" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fa fa-list"></i>
                                            </a>
                                            <div class="dropdown-menu" :aria-labelledby="'btnGroupDrop2_1'">
                                                <a class="dropdown-item txt-uppercase fw-600 fs-12 cl-787887">Sort By</a>
                                                <a class="dropdown-item pointer-cursor">Name</a>
                                                <a class="dropdown-item pointer-cursor">Company name</a>
                                                <a class="dropdown-item pointer-cursor">Payable</a>
                                                <a class="dropdown-item pointer-cursor">Created Time</a>
                                                <a class="dropdown-item pointer-cursor">Last Modified name</a>
                                                <a class="dropdown-item separator"></a>
                                                <a class="dropdown-item pointer-cursor"><i class="fa fa-sign-in"></i> Import vendors</a>
                                                <a class="dropdown-item pointer-cursor"><i class="fa fa-sign-out"></i> Export vendors</a>
                                                <a class="dropdown-item separator"></a>
                                                <a class="dropdown-item pointer-cursor"><i class="fa fa-cog"></i> Vendor preference</a>
                                                <a class="dropdown-item separator"></a>
                                                <a class="dropdown-item pointer-cursor"><i class="fa fa-refresh"></i> Refresh List</a>
                                            </div>
                                        </div>
                                        <button type="button" data-toggle="modal" title="Create Vendor" data-target="#estimate_modal_id" class="btn btn-default btn-inventory btn-amref float-right"><i class="fa fa-plus"></i></button>
                                    </div>
                                </div>
                                <div class="estimate-list-body height-scrollable-body">
                                    <table class="width-100-pc">
                                        <router-link v-for="(supplie,index) in suppliers" :to="'/vendors/'+supplie.id+'/overview'" tag="tbody" class="pointer-cursor" :key="'estimate_list_'+index">
                                            <tr class="parent">
                                                <td style="width:10%"><input type="checkbox"> </td>
                                                <td style="width:55%">{{supplie.first_name}} {{supplie.last_name}}</td>
                                                <td style="width:35%" class="text-right fs-12 cl-444 fw-600"></td>
                                            </tr>
                                            <tr class="child">
                                                <td style="width:10%" class="text-right"></td>
                                                <td style="width:55%">
                                                    <a class="fs-12 cl-787887 fw-600 txt-uppercase">{{supplie.currency.currency_sympol}}{{formatMoneys(supplie.account.balance)}}</a>
                                                </td>
                                                <td style="width:35%" class="text-right">
                                                </td>
                                            </tr>
                                        </router-link>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="padding-right-0 padding-left-0 bg-foo content-calculated-height-50 col-md-7 col-lg-7 col-sm-7 min-width-7000-px">
                            
                            <div class="box box-primary bg-white border-top-0 mg-bottom-0 content-calculated-height-50 border-bottom-0 no-shadowed">
                                <!-- ========================================================= -->
                                 <div  class="width-100-pc action-header padding-left-20 padding-top-10 padding-bottom-10">
                                    <div class="float-left width-40-pc">
                                        <h3 class="fs-17">Test Company</h3>
                                    </div>
                                    <div class="float-right width-60-pc text-right padding-right-30">
                                        <button type="button" class="btn btn-inventory btn-gray">Edit</button>
                                        <button class="btn btn-default btn-inventory btn-gray mg-left-5"><i class="fa fa-paperclip"></i></button>
                                        <div  class="btn-group" role="group" aria-label="Button group with nested dropdown">
                                            <div class="btn-group" role="group">
                                                <button id="btnGroupDrop" type="button" class="btn btn-default btn-inventory btn-amref dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    New Transaction
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="btnGroupDrop">
                                                    <a class="dropdown-item txt-uppercase fw-600 fs-12 cl-787887">Purchases</a>
                                                    <a class="dropdown-item separator"></a>
                                                    <a class="dropdown-item pointer-cursor" data-toggle="modal" data-target="#customerModal_0">Bill</a>
                                                    <a class="dropdown-item pointer-cursor" data-toggle="modal" data-target="#customerModal_0">Bill Payment</a>
                                                    <a class="dropdown-item pointer-cursor" data-toggle="modal" data-target="#customerModal_0">Expense</a>
                                                    <a class="dropdown-item pointer-cursor" data-toggle="modal" data-target="#customerModal_0">Recurring Bill</a>
                                                    <a class="dropdown-item pointer-cursor" data-toggle="modal" data-target="#customerModal_0">Recurring Expense</a>
                                                    <a class="dropdown-item pointer-cursor" data-toggle="modal" data-target="#poModal0">Purchase Order</a>
                                                    <a class="dropdown-item pointer-cursor" data-toggle="modal" data-target="#customerModal_0">Vendor Credit</a>
                                                    <a class="dropdown-item pointer-cursor" data-toggle="modal" data-target="#customerModal_0">Journal</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div  class="btn-group" role="group" aria-label="Button group with nested dropdown">
                                            <div class="btn-group" role="group">
                                                <button id="btnGroupDrop" type="button" class="btn btn-default btn-inventory btn-gray dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    More
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="btnGroupDrop">
                                                    <a class="dropdown-item pointer-cursor" data-toggle="modal" data-target="#customerModal_0">Email vendor</a>
                                                    <a class="dropdown-item separator"></a>
                                                    <a class="dropdown-item pointer-cursor" data-toggle="modal" data-target="#customerModal_0"> Mark As Inactive</a>
                                                    <a class="dropdown-item pointer-cursor" data-toggle="modal" data-target="#customerModal_0"> Delete</a>
                                                </div>
                                            </div>
                                        </div>
                                        <router-link :to="SUPPLIERS" tag="i" class="fa fa-close pointer-cursor mg-left-5"></router-link>
                                    </div>
                                    <div class="width-100-pc mg-top-45 content-links">
                                        <supplier-header v-if="page_loaded" :supplier="supplier" :active="'statement'"></supplier-header>
                                    </div>
                                </div>

                                <div class="page-content bg-white padding-left-0 height-scrollable">

                                    <div class="dgrid dgrid-grid ui-widget dgrid-03 mg-bottom-30 universal-grid border-ccc" role="grid">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div  class="width-100-pc">
                                                    <div class="float-left width-40-pc">
                                                        <div class="btn-group" role="group">
                                                            <button id="btnGroupDrop" type="button" class="btn btn-default btn-inventory btn-white dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                <i class="fa fa-calendar"></i> This Month
                                                            </button>
                                                            <div class="dropdown-menu" aria-labelledby="btnGroupDrop">
                                                                <a class="dropdown-item pointer-cursor" data-toggle="modal" data-target="#customerModal_0">Today</a>
                                                                <a class="dropdown-item pointer-cursor" data-toggle="modal" data-target="#customerModal_0">This Week</a>
                                                                <a class="dropdown-item pointer-cursor" data-toggle="modal" data-target="#customerModal_0">This Month</a>
                                                                <a class="dropdown-item pointer-cursor" data-toggle="modal" data-target="#customerModal_0">This Quarter</a>
                                                                <a class="dropdown-item pointer-cursor" data-toggle="modal" data-target="#customerModal_0">This Year</a>
                                                                <a class="dropdown-item pointer-cursor" data-toggle="modal" data-target="#customerModal_0">Yesterday</a>
                                                                <a class="dropdown-item pointer-cursor" data-toggle="modal" data-target="#customerModal_0">Previous Week</a>
                                                                <a class="dropdown-item pointer-cursor" data-toggle="modal" data-target="#customerModal_0">Previous Month</a>
                                                                <a class="dropdown-item pointer-cursor" data-toggle="modal" data-target="#customerModal_0">Previous Quarter</a>
                                                                <a class="dropdown-item pointer-cursor" data-toggle="modal" data-target="#customerModal_0">Previous Year</a>
                                                                <a class="dropdown-item separator"></a>
                                                                <a class="dropdown-item pointer-cursor" data-toggle="modal" data-target="#customerModal_0">Custom</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="float-right width-60-pc text-right padding-right-30">
                                                        <button type="button" class="btn btn-inventory btn-gray"><i class="fa fa-print"></i></button>
                                                        <button class="btn btn-default btn-inventory btn-gray mg-left-5"><i class="fa fa-file-pdf-o"></i></button>
                                                        <button class="btn btn-default btn-inventory btn-gray mg-left-5"><i class="fa fa-file-excel-o"></i></button>
                                                        <button class="btn btn-default btn-inventory btn-amref mg-left-5"><i class="fa fa-envelope-o"></i> Send Mail</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div  class="width-100-pc mg-top-45 text-center">
                                                    <h3 class="txt-uppercase fs-16">Vendor Statement For Test Company </h3>
                                                    <small class="fs-13">From {{statement.date_range}}</small>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div  class="width-100-pc mg-top-30 mg-left-10 padding-20 text-center hidden-overflow box-shadow">
                                                    <div class="width-60-pc text-right float-right">
                                                        <h4 class="fs-13">Test Organisation</h4>
                                                        <h4 class="fs-13">Address Corp</h4>
                                                        <h4 class="fs-13">Street Address</h4>
                                                        <h4 class="fs-13">Nairobi Nairobi Nairobi</h4>
                                                        <h4 class="fs-13">Kenya</h4>
                                                    </div>
                                                    <div class="width-50-pc float-left text-left mg-top-20">
                                                        <h4 class="fs-14 fw-600 txt-uppercase">Bill To:</h4>
                                                        <h4 class="fs-13">Test Organisation</h4>
                                                        <h4 class="fs-13">Address Corp</h4>
                                                        <h4 class="fs-13">Street Address</h4>
                                                        <h4 class="fs-13">Nairobi Nairobi Nairobi</h4>
                                                        <h4 class="fs-13">Kenya</h4>
                                                    </div>
                                                    <div class="width-50-pc float-right text-right mg-top-20">
                                                        <h4 class="txt-uppercase fs-18 cl-444 fw-600">STATEMENT OF ACCOUNTS</h4>
                                                        <small class="fs-13"><span class="cl-444 fw-600">Date: </span>{{statement.date_range}}</small><br>
                                                        <small class="fs-13"><span class="cl-444 fw-600">Account No: </span> {{statement.account_number}}</small>
                                                    </div>
                                                    <div class="width-40-pc text-right float-right mg-top-20">
                                                        <table class="sales-table">
                                                            <tr class="title">
                                                                <td colspan="2" class="text-left">Account Summary</td>
                                                            </tr>
                                                            <tr class="info">
                                                                <td style="width:40%;" class="no-bd text-left">Opening Balance:</td>
                                                                <td class="no-bd text-right">KES {{formatMoneys(statement.opening_balance)}}</td>
                                                            </tr>
                                                            <tr class="info">
                                                                <td style="width:40%;" class="no-bd text-left">Billed Amount:</td>
                                                                <td class="no-bd text-right">KES {{formatMoneys(statement.billed_amount)}}</td>
                                                            </tr>
                                                            <tr class="info">
                                                                <td style="width:40%;" class="no-bd text-left">Paid Amount:</td>
                                                                <td class="no-bd text-right">KES {{formatMoneys(statement.paid_amount)}}</td>
                                                            </tr>
                                                            <tr class="total">
                                                                <td style="width:40%;" class="text-left no-bd">
                                                                    Balance Due:
                                                                </td>
                                                                <td class="text-right no-bd">
                                                                    KES {{formatMoneys(statement.balance)}}
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </div>

                                                    <div class="width-100-pc">
                                                        <table class="account-statement mg-top-20">
                                                            <tr>
                                                                <th style="width:13%" class="text-left">Date</th>
                                                                <th style="width:13%" class="text-left">Transaction</th>
                                                                <th style="width:29%" class="text-left">Detail</th>
                                                                <th style="width:15%" class="text-right">Amount</th>
                                                                <th style="width:15%" class="text-right">Payment</th>
                                                                <th style="width:15%" class="text-right">Balance</th>
                                                            </tr>
                                                            <tr>
                                                                <td class="text-left">15 Oct 2018</td>
                                                                <td class="text-left">15 Oct 2018</td>
                                                                <td class="text-left">15 Oct 2018</td>
                                                                <td class="text-right">15 Oct 2018</td>
                                                                <td class="text-right">15 Oct 2018</td>
                                                                <td class="text-right">15 Oct 2018</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="text-left">15 Oct 2018</td>
                                                                <td class="text-left">15 Oct 2018</td>
                                                                <td class="text-left">15 Oct 2018</td>
                                                                <td class="text-right">15 Oct 2018</td>
                                                                <td class="text-right">15 Oct 2018</td>
                                                                <td class="text-right">15 Oct 2018</td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <po-modal v-if="page_loaded" :supplier="supplier" :suppliers="suppliers" :facilities="facilities" :customers="customers" :modal_id="'poModal0'" :modal_title="'Purchase Order'"></po-modal>
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
    //import SideBarCustomer from "../../partials/sidebars/customer/SideBarCustomer";
    import PurchasesFilters from "../../partials/filters/PurchasesFilters";
    import PurchasesTable from "../../partials/tables/PurchasesTable";
    import CreatePurchaseModal from "../../partials/modals/purchase/CreatePurchaseModal";
    import SideBarInventory from "../../partials/sidebars/inventory/SideBarInventory";
    //import SupplyModal from "../../partials/modals/supply/SupplyModal";
    //import ConfirmModal from "../../partials/modals/ConfirmModal";
    //import EstimateModal from '../../partials/modals/customer/EstimateModal';
    import PaginateTemplate from '../../partials/pagination/PaginateTemplate';
    //import SupplyPreview from "../../partials/modals/supply/SupplyPreview";
    //import RequistionModal from '../../partials/modals/product/RequistionModal';
    import ProcessingOverlay from '../../../../progress/ProcessingOverlay';
    import SearchDatabaseFormControl from '../../partials/search/SearchDatabaseFormControl';
    import CommonLinks from "../../partials/sidebars/CommonLinks";
    import {get} from "../../../../../helpers/api";
    import Auth from "../../../../../store/auth";
    import SupplierHeader from './partials/SupplierHeader';
    import PoModal from "../../partials/modals/purchase/PoModal";
    // import EstimateView from './partials/Estimates'
    // import CustomerModal from '../../partials/modals/customer/CustomerModal';
    import {ACCOUNTS_INITIALS,PRODUCT_ITEMS_URL,SUPPLIER_URL,ACCOUNTS_ACCOUNT,PRACTICES_API} from '../../../../../router/api_routes';
    import {createHtmlErrorString,formatMoney} from '../../../../../helpers/functionmixin';
    import {PROCESS_STATUS,ACCOUNTING} from '../../../../../helpers/process_status';
    import {INVENTORY_WEB_ROUTES} from "../../../../../router/web_routes";
    export default {
        name: "Index",
        components: {TopNavBar,SideBar,PaginateTemplate,SupplierHeader,PoModal,
        SideBarInventory,ProcessingOverlay,CommonLinks,SearchDatabaseFormControl},
        data(){
            return {
                
                initializations: {},
                products: [],
                estimate_list: [],
                suppliers: [],
                facilities: [],
                customers: [],
                supplier: {},
                statement: {},
                //estimate: {},
                estimate_selected: false,
                view_toggler: true,
                page_loaded: false,
                progress_overlay: 'hide',
                pagination: {
                    'current_page': 1
                },
                active_menu: -1,
                PROCESS_STATUS : PROCESS_STATUS,
                //initial_url:CUSTOMERS_ESTIMATES_API,
                //CUSTOMERS_API:CUSTOMERS_API,
                ACCOUNTING:ACCOUNTING,
                SUPPLIERS:INVENTORY_WEB_ROUTES.PURCHASES.VENDORS,
                SUPPLIER_URL: SUPPLIER_URL,
            }
        },
        methods: {

            check_permissions(perm_){
                return Auth.menuChecker(perm_);
            },

            customerModal(){
                $("#customerModal_0").modal('show');
            },

            formatMoneys(money_to){
                return formatMoney(money_to);
            },

            loadSuppliers(state_load="show"){

                this.progress_overlay = state_load;
                get(this.SUPPLIER_URL+'?page='+this.pagination.current_page)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.suppliers = res.data.results.data;
                        this.pagination = res.data.results.pagination;
                        // this.progress_overlay = "hide";
                        // this.page_ready = true;
                        this.loadSupplier();
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

            loadSupplier(state_load="show"){
                this.progress_overlay = state_load;
                get(this.SUPPLIER_URL+'/'+this.$route.params.uuid)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.supplier = res.data.results;
                        // this.progress_overlay = "hide";
                        // //this.page_ready = true;
                        // this.page_loaded = true;
                        this.loadStatement();
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

            loadStatement(state_load="show"){
                this.progress_overlay = state_load;
                get(ACCOUNTS_ACCOUNT+'/'+this.supplier.account.id)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.statement = res.data.results;
                        this.loadInitials();
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

            loadInitials(){
                get(PRACTICES_API)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.facilities = res.data.results;
                        //console.info(this.initializations);
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
            },
            
        },
        mounted() {
            this.loadSuppliers();
        }
    }
</script>

