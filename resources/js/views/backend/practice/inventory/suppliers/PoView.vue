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
                            <side-bar-inventory v-if="page_loaded" :supplier="true" :scrollable="true" :width="true" :transparent="true" :active_num="'purchase_orders'" :title="'Purchase Orders'"></side-bar-inventory>
                        </div>

                        <div class="col-md-3 col-lg-3 col-sm-3 padding-right-0 bg-white padding-left-0 content-calculated-height-50 max-width-150-px">
                            <div class="estimate-list width-100-pc content-calculated-height-50">
                                <div class="estimate-list-head">
                                    <div class=" width-70-pc float-left">
                                        <div  class="btn-group" role="group" aria-label="Button group">
                                            <div class="btn-group" role="group">
                                                <a :id="'btnGroupDrop2_1'" class="dropdown-toggle fs-14 pointer-cursor fw-600 txt-uppercase" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    All Purchase Orders
                                                </a>
                                                <div class="dropdown-menu" :aria-labelledby="'btnGroupDrop2_1'">
                                                    <a class="dropdown-item pointer-cursor">All</a>
                                                    <a class="dropdown-item pointer-cursor">Draft</a>
                                                    <a class="dropdown-item pointer-cursor">Pending Approval</a>
                                                    <a class="dropdown-item pointer-cursor">Approved</a>
                                                    <a class="dropdown-item pointer-cursor">Open</a>
                                                    <a class="dropdown-item pointer-cursor">Billed</a>
                                                    <a class="dropdown-item pointer-cursor">Partial Billed</a>
                                                    <a class="dropdown-item pointer-cursor">Closed</a>
                                                    <a class="dropdown-item pointer-cursor">Cancelled</a>
                                                    <a class="dropdown-item separator"></a>
                                                    <a class="dropdown-item pointer-cursor">New Custom view</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="width-30-pc float-right">

                                        <!-- <div class="btn-group float-right" role="group">
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
                                        </div> -->
                                        <button type="button" data-toggle="modal" title="Create Vendor" data-target="#estimate_modal_id" class="btn btn-default btn-inventory btn-amref float-right"><i class="fa fa-plus"></i></button>
                                    </div>
                                </div>
                                <div class="estimate-list-body height-scrollable-body">
                                    <table class="width-100-pc">
                                        <!-- <router-link v-for="(supplie,index) in suppliers" :to="'/vendors/'+supplie.id+'/overview'" tag="tbody" class="pointer-cursor" :key="'estimate_list_'+index">
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
                                        </router-link> -->

                                        <router-link v-for="(purchase_orde,index) in purchase_orders" :to="'/purchases/purchase_orders/'+purchase_orde.id+'/view'" tag="tbody" v-bind:class="{'active':active_menu===index}" :key="'po_list_'+index">
                                            <tr class="parent">
                                                <td style="width:10%"><input type="checkbox"> </td>
                                                <td style="width:55%">{{purchase_orde.vendor.display_as}}</td>
                                                <td style="width:35%" class="text-right fs-12 cl-444 fw-600">{{purchase_orde.vendor.currency.currency_sympol}}{{formatMoneys(purchase_orde.total_grand-purchase_orde.discount_allowed)}}</td>
                                            </tr>
                                            <tr class="child">
                                                <td style="width:10%" class="text-right"></td>
                                                <td style="width:55%">
                                                    <a class="txt-uppercase fs-12 cl-blue-link fw-600">{{purchase_orde.trans_number}}</a> | <a class="fs-12 cl-787887 fw-600 txt-uppercase">{{purchase_orde.po_date}}</a>
                                                </td>
                                                <td style="width:35%" class="text-right">
                                                    <a v-if="check_status(purchase_orde.status,PROCESS_STATUS.ACCEPTED)" class="txt-uppercase fs-12 fw-600 cl-success-light">Accepted</a>
                                                    <a v-else-if="check_status(purchase_orde.status,PROCESS_STATUS.DRAFT)" class="txt-uppercase fs-12 fw-600 cl-787887">Draft</a>
                                                    <a v-else-if="check_status(purchase_orde.status,PROCESS_STATUS.DECLINED)" class="txt-uppercase fs-12 fw-600 cl-amref">Declined</a>
                                                    <a v-else-if="check_status(purchase_orde.status,PROCESS_STATUS.EXPIRED)" class="txt-uppercase fs-12 fw-600 cl-787887">Expired</a>
                                                    <a v-else-if="check_status(purchase_orde.status,PROCESS_STATUS.INVOICED)" class="txt-uppercase fs-12 fw-600 cl-success-light">Invoiced</a>
                                                    <a v-else-if="check_status(purchase_orde.status,PROCESS_STATUS.SENT)" class="txt-uppercase fs-12 fw-600 cl-blue-link">Sent</a>
                                                    <a v-else-if="check_status(purchase_orde.status,PROCESS_STATUS.OPEN)" class="txt-uppercase fs-12 fw-600 cl-blue-link">Open</a>
                                                    <a v-else-if="check_status(purchase_orde.status,PROCESS_STATUS.CLOSED)" class="txt-uppercase fs-12 fw-600 cl-success-light">{{PROCESS_STATUS.CLOSED}}</a>
                                                    <a v-else="" class="txt-uppercase fs-12 fw-600 cl-787887">Pending</a>
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
                                    <div class="float-left width-20-pc">
                                        <h3 class="fs-17 cl-777">{{purchase_order.trans_number}}</h3>
                                    </div>
                                    <div class="float-right width-80-pc text-right padding-right-30">

                                        <div class="filter-block form-inline">
                                            <div class="filter-group input-group">
                                                <span class="filter"><i class="fa fa-pencil"></i></span>
                                                <span class="filter"><i class="fa fa-file-pdf-o"></i></span>
                                                <span class="filter"><i class="fa fa-print"></i></span>
                                                <span class="filter"><i class="fa fa-envelope-o"></i></span>
                                            </div>
                                        </div>
                                        <button class="btn btn-default btn-inventory btn-gray mg-left-5"><i class="fa fa-paperclip"></i></button>
                                        <button v-if="page_loaded && check_status(purchase_order.status,PROCESS_STATUS.DRAFT)" type="button" data-toggle="modal" data-target="#convert_po_to_state" class="btn btn-inventory btn-gray">Convert to Open</button>
                                        <button v-else-if="page_loaded && check_status(purchase_order.status,PROCESS_STATUS.OPEN)" type="button" data-toggle="modal" data-target="#new_bill_id" class="btn btn-inventory btn-gray">Convert to Bill</button>
                                        <span v-else></span>
                                        <div  class="btn-group" role="group" aria-label="Button group with nested dropdown">
                                            <div class="btn-group" role="group">
                                                <button id="btnGroupDrop" type="button" class="btn btn-default btn-inventory btn-gray dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    More
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="btnGroupDrop">
                                                    <a class="dropdown-item pointer-cursor" data-toggle="modal" data-target="#new_bill_id">Convert to Bill</a>
                                                    <a class="dropdown-item pointer-cursor" data-toggle="modal" data-target="#customerModal_0">Due Date</a>
                                                    <a class="dropdown-item pointer-cursor" data-toggle="modal" data-target="#customerModal_0"> Mark as Cancelled</a>
                                                    <a class="dropdown-item separator"></a>
                                                    <a class="dropdown-item pointer-cursor" data-toggle="modal" data-target="#customerModal_0"> Delete</a>
                                                </div>
                                            </div>
                                        </div>
                                        <router-link :to="PURCHASE_ORDERS" tag="i" class="fa fa-close pointer-cursor mg-left-5"></router-link>
                                    </div>
                                    <div class="width-100-pc mg-top-45 content-links">
                                        <!-- <supplier-header v-if="page_loaded" :supplier="supplier" :active="'statement'"></supplier-header> -->
                                    </div>
                                </div>

                                <div class="page-content bg-white padding-left-0 height-scrollable">
                                    <div class="dgrid dgrid-grid ui-widget dgrid-03 mg-bottom-30 universal-grid border-ccc" role="grid">
                                        <div class="row">
                                            <div class="col-lg-12 padding-right-0">
                                                <section v-if="page_loaded" class="padding-right-0 padding-left-0 padding-top-20" id="print_section">
                                                    
                                                    <div class="invoice invoice-2 invoice-body mg-left-5 mg-right-10 mg-top-5 invoice-border zero-border padding-20">
                                                        <div class="row">
                                                            <div class="col-md-5 col-sm-5 pull-left text-center report-header padding-left-0">

                                                                <!-- <div v-if="check_status(purchase_order.status,PROCESS_STATUS.OPEN)" class="ribbon text-ellipsis popovercontainer ember-view" data-original-title="" title=""><div class="ribbon-inner ribbon-open">{{PROCESS_STATUS.OPEN}}</div></div>
                                                                <div v-else-if="check_status(purchase_order.status,PROCESS_STATUS.DRAFT)" class="ribbon text-ellipsis popovercontainer ember-view" data-original-title="" title=""><div class="ribbon-inner ribbon-draft">{{PROCESS_STATUS.DRAFT}}</div></div>
                                                                <span v-else></span> -->

                                                                <ribbon-maker :STATUS_ARRAY="purchase_order.status" :PROCESS_STATUS="PROCESS_STATUS"></ribbon-maker>
                        
                                                                <img class="print-logo-size" src="/assets/img/amref-white.png">
                                                                <h2 class="invoice-title txt-uppercase fs-12">
                                                                    <span class="fw-600 cl-amref fs-12">AMREF ENTERPRISE</span> | <span class="fw-600 cl-444 fs-12">AMREF HEALTH AFRICA</span>
                                                                </h2>
                                                            </div>
                                                            <div class="col-md-3 col-sm-3"></div>
                                                            <div class="col-md-4 col-sm-4 pull-right text-right">
                                                                <h2 class="invoice-title txt-uppercase fs-20"><b>Purchase Order</b></h2>
                                                                <table class="sales-table">
                                                                    <tr class="info">
                                                                        <td style="width:50%;" class="no-bd text-right">Date:</td>
                                                                        <td style="width:50%;" class="text-right">{{purchase_order.po_date}}</td>
                                                                    </tr>
                                                                    <tr class="info">
                                                                        <td style="width:50%;" class="no-bd text-right">PO Number:</td>
                                                                        <td style="width:50%;" class="text-right">{{purchase_order.trans_number}}</td>
                                                                    </tr>
                                                                    <tr class="info">
                                                                        <td style="width:50%;" class="no-bd text-right">Ref:</td>
                                                                        <td style="width:50%;" class="text-right">{{purchase_order.ref_number}}</td>
                                                                    </tr>
                                                                    <tr class="info">
                                                                        <td style="width:50%;" class="no-bd text-right">Due Date:</td>
                                                                        <td style="width:50%;" class="text-right">{{purchase_order.po_due_date}}</td>
                                                                    </tr>
                                                                </table>
                                                            </div>
                                                        </div>
                                                        <div class="row set-border-bottom">
                                                            <div class="col-md-4 col-sm-4 pull-left to-address padding-top-20 mg-top-20">
                                                                <table class="sales-table width-100-pc">
                                                                    <tr class="title">
                                                                        <td colspan="2" class="">Vendor</td>
                                                                    </tr>
                                                                    <tr class="info">
                                                                        <td colspan="2" class="width-100-pc no-bd">
                                                                            {{purchase_order.vendor.display_as}}<br>
                                                                            {{purchase_order.vendor.company.name}}<br>
                                                                            {{purchase_order.vendor.addresses.billing.address}}, {{purchase_order.vendor.addresses.billing.postal_code}}<br>
                                                                            {{purchase_order.vendor.addresses.billing.phone}} | {{purchase_order.vendor.email}}<br>
                                                                            {{purchase_order.vendor.addresses.billing.fax}}<br>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </div>
                                                            <div class="col-md-4 col-sm-4"></div>
                                                            <div class="col-md-4 col-sm-4 pull-right to-address padding-top-20 mg-top-20 text-right">
                                                                <table class="sales-table width-100-pc">
                                                                    <tr class="title">
                                                                        <td colspan="2" class="">Ship To</td>
                                                                    </tr>
                                                                    <tr class="info">
                                                                        <td colspan="2" class="width-100-pc no-bd">
                                                                            {{purchase_order.shipping.name}}<br>
                                                                            {{purchase_order.shipping.address}}<br>
                                                                            {{purchase_order.shipping.postal_code}} {{purchase_order.shipping.city}}, {{purchase_order.shipping.country}}<br>
                                                                            {{purchase_order.shipping.phone}}<br>
                                                                            {{purchase_order.shipping.email}}<br>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-md-12 mg-top-20">

                                                                <table class="sales-table width-100-pc">
                                                                    <tr class="title">
                                                                        <td class="" style="width:50%;">Item</td>
                                                                        <td class="text-right" style="width:10%;">Qty</td>
                                                                        <td class="text-right" style="width:10%;">Rate</td>
                                                                        <td class="text-right" style="width:10%;">Disc</td>
                                                                        <td class="text-center" style="width:5%;">Tax</td>
                                                                        <td class="text-right" style="width:15%;">Line Total</td>
                                                                    </tr>
                                                                    <tr v-for="(po_item,est_index) in purchase_order.items" class="info" :key="'estimate_'+est_index">
                                                                        <td class="no-top-bottom-bd" style="width:50%;">{{po_item.brand.name}} | {{po_item.single_unit_weight}}{{po_item.measure_unit.slug}}</td>
                                                                        <td class="no-top-bottom-bd text-right">{{formatMoneys(po_item.qty)}}</td>
                                                                        <td class="no-top-bottom-bd text-right">{{formatMoneys(po_item.price.pack_cost)}}</td>
                                                                        <td class="no-top-bottom-bd text-right">{{formatMoneys(po_item.line_discount)}}</td>
                                                                        <td class="no-top-bottom-bd text-center"><span v-if="po_item.line_taxation.length">x</span></td>
                                                                        <td class="no-top-bottom-bd text-right fw-600">{{formatMoneys(po_item.amount-po_item.line_discount)}}</td>
                                                                    </tr>
                                                                    <tr class="info">
                                                                        <td style="width:50%;" colspan="2" class="txt-italic">{{purchase_order.notes}}</td>
                                                                        <td class="txt-uppercase fw-600" colspan="4"><a class="float-left">Discount:</a><a class="float-right">{{formatMoneys(purchase_order.discount_allowed)}} </a></td>
                                                                    </tr>
                                                                    <tr class="info">
                                                                        <td style="width:50%;" colspan="2" class="no-bd"></td>
                                                                        <td class="no-top-bottom-bd txt-uppercase fw-600" colspan="4">
                                                                            <a class="float-left">SubTotal:</a>
                                                                            <a class="float-right">{{formatMoneys(purchase_order.total_grand-purchase_order.total_tax)}}</a>
                                                                        </td>
                                                                    </tr>
                                                                    <tr class="info">
                                                                        <td style="width:50%;" colspan="2" class="no-bd"></td>
                                                                        <td class="no-top-bottom-bd txt-uppercase fw-600" colspan="4">
                                                                            <a class="float-left">Sales Tax:</a>
                                                                            <a class="float-right">{{formatMoneys(purchase_order.total_tax)}}</a>
                                                                        </td>
                                                                    </tr>
                                                                    <tr class="info">
                                                                        <td style="width:50%;" colspan="2" class="no-bd"></td>
                                                                        <td class="no-top-bottom-bd txt-uppercase fw-600" colspan="4">
                                                                            <a class="float-left">Shipping:</a>
                                                                            <a class="float-right">{{formatMoneys(purchase_order.shipping_total)}}</a>
                                                                        </td>
                                                                    </tr>
                                                                    <tr class="info">
                                                                        <td style="width:50%;" colspan="2" class="no-bd"></td>
                                                                        <td class="no-top-bottom-bd txt-uppercase fw-600" colspan="4">
                                                                            <a class="float-left">Other:</a>
                                                                            <a class="float-right">{{formatMoneys(purchase_order.other_total)}}</a>
                                                                        </td>
                                                                    </tr>
                                                                    <tr class="title">
                                                                        <td style="width:50%;" colspan="2" class="no-bd"></td>
                                                                        <td class="txt-uppercase fw-600" colspan="4">
                                                                            <a class="float-left">Total:</a>
                                                                            <a class="float-right">{{formatMoneys(purchase_order.total_bill)}}</a>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-md-12 fw-600 accepted-row mg-top-20 text-center">
                                                                <hr>
                                                                <p class="fs-13">{{purchase_order.vendor.supplier_term.notes}}</p>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-12 text-center accepted-row">
                                                                <p class="fs-13">If you have any questions, please contact: [{{purchase_order.status[purchase_order.status.length-1].signatory.first_name}} {{purchase_order.status[purchase_order.status.length-1].signatory.mobile}} {{purchase_order.status[purchase_order.status.length-1].signatory.email}}]</p>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </section>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- <po-modal v-if="page_loaded" :supplier="supplier" :suppliers="suppliers" :facilities="facilities" :customers="customers" :modal_id="'poModal0'" :modal_title="'Purchase Order'"></po-modal> -->
                                 <bill-modal v-if="page_loaded" v-on:billCreated="loadPo('hide')" :initial_api="SUPPLIER_BILL_URL" :billable_type="'PO'" :suppliers="suppliers" :order="purchase_order" :payment_terms="payment_terms" :modal_id="'new_bill_id'" :modal_title="'New Bill'"></bill-modal>
                                 <confirm-modal v-if="page_loaded" v-on:successReq="loadPo('hide')" :confirm_message="'Are you sure?'" :form_inputs="open_form" :item_url="initial_api+'/'+purchase_order.id" :modal_title="'Convert to Open'" :modal_id="'convert_po_to_state'"></confirm-modal>
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
    import ConfirmModal from "../../partials/modals/ConfirmModal";
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
    import RibbonMaker from "../../partials/RibbonMaker";
    import BillModal from "../../partials/modals/vendors/BillModal";
    // import EstimateView from './partials/Estimates'
    // import CustomerModal from '../../partials/modals/customer/CustomerModal';
    import {ACCOUNTS_INITIALS,SUPPLIER_BILL_URL,PRODUCT_ITEMS_URL,SUPPLIER_URL,ACCOUNTS_ACCOUNT,PRACTICES_API,SUPPLIER_PO_URL} from '../../../../../router/api_routes';
    import {createHtmlErrorString,formatMoney} from '../../../../../helpers/functionmixin';
    import {PROCESS_STATUS,ACCOUNTING} from '../../../../../helpers/process_status';
    import {INVENTORY_WEB_ROUTES} from "../../../../../router/web_routes";
    export default {
        name: "PoView",
        components: {TopNavBar,SideBar,PaginateTemplate,SupplierHeader,PoModal,BillModal,ConfirmModal,
        SideBarInventory,ProcessingOverlay,CommonLinks,SearchDatabaseFormControl,RibbonMaker},
        data(){
            return {
                PURCHASE_ORDERS: INVENTORY_WEB_ROUTES.PURCHASES.PURCHASE_ORDERS,
                initializations: {},
                products: [],
                estimate_list: [],
                purchase_orders: [],
                payment_terms: [],
                purchase_order: {},
                //facilities: [],
                //customers: [],
                suppliers: [],
                //supplier: {},
                //statement: {},
                //estimate: {},
                //estimate_selected: false,
                //view_toggler: true,
                page_loaded: false,
                progress_overlay: 'hide',
                pagination: {
                    'current_page': 1
                },
                active_menu: -1,
                PROCESS_STATUS : PROCESS_STATUS,
                //initial_url:CUSTOMERS_ESTIMATES_API,
                //CUSTOMERS_API:CUSTOMERS_API,
                //ACCOUNTING:ACCOUNTING,
                //SUPPLIERS:INVENTORY_WEB_ROUTES.PURCHASES.VENDORS,
                //SUPPLIER_URL: SUPPLIER_URL,
                SUPPLIER_BILL_URL:SUPPLIER_BILL_URL,
                initial_api: SUPPLIER_PO_URL,
                open_form: {
                    status_action: "status",
                    status: PROCESS_STATUS.OPEN,
                    notes: "",
                }
            }
        },
        methods: {

            check_permissions(perm_){
                return Auth.menuChecker(perm_);
            },

            // customerModal(){
            //     $("#customerModal_0").modal('show');
            // },

            formatMoneys(money_to){
                return formatMoney(money_to);
            },

            loadPos(state_load="show"){

                this.progress_overlay = state_load;
                get(SUPPLIER_PO_URL+'?page='+this.pagination.current_page)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.purchase_orders = res.data.results.data;
                        this.pagination = res.data.results.pagination;
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

            loadPo(state_load="show"){
                this.progress_overlay = state_load;
                get(SUPPLIER_PO_URL+'/'+this.$route.params.uuid)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.purchase_order = res.data.results;
                        console.info(this.purchase_order);
                        this.progress_overlay = "hide";
                        this.page_loaded = true;
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

            // check_status(array_to,pin_to){
            //     let result = null;
            //     for (let index = 0; index < array_to.length; index++) {
            //         const element = array_to[index];
            //         if(element.status === pin_to){
            //             result = element.date;
            //             break;
            //         }
            //     }
            //     return result;
            // },
            check_status(array_to,pin_to){
                let result = false;
                if( array_to[array_to.length-1].status === pin_to ){
                    result = true;
                }
                return result;
            },

            // loadStatement(state_load="show"){
            //     this.progress_overlay = state_load;
            //     get(ACCOUNTS_ACCOUNT+'/'+this.supplier.account.id)
            //     .then((res) => {
            //         if(res.data.status_code === 200) {
            //             this.statement = res.data.results;
            //             this.loadInitials();
            //         }
            //     }).catch((err) => {
            //         this.progress_overlay = "hide";
            //         this.page_loaded = false;
            //         if(err.response.status === 422) {
            //             this.$awn.warning(createHtmlErrorString(err.response.data.errors));
            //         }else if (err.response.status === 500){
            //             this.$awn.warning(err.response.data.description);
            //         }
            //         else{
            //             this.processing = false;
            //             this.$awn.warning(err.response.data.description);
            //         }
            //     });
            // },

            // loadInitials(){
            //     get(PRACTICES_API)
            //     .then((res) => {
            //         if(res.data.status_code === 200) {
            //             this.facilities = res.data.results;
            //             //console.info(this.initializations);
            //             this.progress_overlay = "hide";
            //             this.page_loaded = true;
            //         }
            //     }).catch((err) => {
            //         this.progress_overlay = "hide";
            //         this.page_loaded = false;
            //         if(err.response.status === 422) {
            //             this.$awn.warning(createHtmlErrorString(err.response.data.errors))
            //         }else if (err.response.status === 500){
            //             this.$awn.warning(err.response.data.description);
            //             window.location.href = "/500";
            //         }
            //         else{
            //             this.processing = false;
            //             this.$awn.warning(err.response.data.description)
            //         }
            //     });
            // },
            
        },
        mounted() {
            this.loadPos();
        }
    }
</script>

