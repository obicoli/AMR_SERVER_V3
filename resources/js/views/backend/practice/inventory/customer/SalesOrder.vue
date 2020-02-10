<template>

    <div>

        <processing-overlay :message="msg" :status="progress_overlay"></processing-overlay>

        <top-nav-bar :inventory="true" :bg_f7="true"></top-nav-bar>

        <side-bar></side-bar>

        <div class="wp-content mg-top-50 content-calculated-height-wc">

            <div class="row">

                <div class="col-md-12 col-lg-12 col-sm-12 padding-left-0">

                    <div class="row">
                        <div class="col-md-2 col-lg-2 col-sm-2 padding-right-0 bg-foo content-calculated-height-wc">
                            <side-bar-inventory v-if="page_ready" :customer="true" :scrollable="true" :width="true" :transparent="true" :active_num="'salesorder'" :title="'Sales Orders'"></side-bar-inventory>
                        </div>
                        <div class="col-md-10 col-lg-10 col-sm-10 padding-right-0 padding-left-0 bg-white content-calculated-height-wc">

                            <div class="settings-header shadowed main-heading bg-white min-height-68 bottom-border top-border">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div v-if="selected_pos.length>0" class="pull pull-left mg-top-10">
                                            <div class="padding-right-10 min-height-30 width-100-pc">
                                                <a class="btn btn-default btn-inventory btn-gray" title="Send Mail"><i class="fa fa-envelope-o"></i></a>
                                                <div class="btn-group" role="group">
                                                    <a :id="'btnGroupDrop2_1'" class="dropdown-toggle btn btn-default btn-inventory btn-gray" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        More Action
                                                    </a>
                                                    <div class="dropdown-menu" :aria-labelledby="'btnGroupDrop2_1'">
                                                        <a class="dropdown-item pointer-cursor">Mark as Inactive</a>
                                                        <a class="dropdown-item pointer-cursor">Delete</a>
                                                    </div>
                                                </div>
                                                <a class="fs-14 cl-ccc">{{selected_pos.length}} PO(s) selected</a>
                                            </div>
                                        </div>
                                        <div v-else class="btn-group" role="group" aria-label="Button group">
                                            <div class="btn-group" role="group">
                                                <a :id="'btnGroupDrop2_1'" class="dropdown-toggle fs-14 pointer-cursor fw-600 txt-uppercase" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    All Sales Order
                                                </a>
                                                <div class="dropdown-menu" :aria-labelledby="'btnGroupDrop2_1'">
                                                    <a class="dropdown-item txt-uppercase cl-777 fs-12">Default Filters</a>
                                                    <a class="dropdown-item pointer-cursor">All</a>
                                                    <a class="dropdown-item pointer-cursor">Draft</a>
                                                    <a class="dropdown-item pointer-cursor">Pending Approval</a>
                                                    <a class="dropdown-item pointer-cursor">Approved</a>
                                                    <a class="dropdown-item pointer-cursor">Open</a>
                                                    <a class="dropdown-item pointer-cursor">Overdue</a>
                                                    <a class="dropdown-item pointer-cursor">Partially Invoiced</a>
                                                    <a class="dropdown-item pointer-cursor">Invoiced</a>
                                                    <a class="dropdown-item pointer-cursor">Closed</a>
                                                    <a class="dropdown-item pointer-cursor">Void</a>
                                                    <a class="dropdown-item separator"></a>
                                                    <a class="dropdown-item pointer-cursor">+ New Custom view</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="pull pull-left mg-top-10">
                                            <div class="padding-right-10 min-height-30 width-100-pc">
                                                <a data-toggle="modal" data-target="#new_po_modal" class="btn btn-default btn-inventory btn-amref cl-white">+New</a>
                                                <a class="btn btn-default btn-inventory btn-gray" title="Vendor Preferences"><i class="fa fa-cog"></i></a>
                                                <!-- <a class="btn btn-default btn-inventory btn-gray"><i class="fa fa-list"></i></a> |  -->
                                                <div class="btn-group" role="group">
                                                    <a :id="'btnGroupDrop2'" class="dropdown-toggle btn btn-default btn-inventory btn-gray" data-toggle="dropdown">
                                                        <i class="fa fa-list"></i>
                                                    </a>
                                                    <div class="dropdown-menu" :aria-labelledby="'btnGroupDrop2'">
                                                        <a class="dropdown-item pointer-cursor">Created Time</a>
                                                        <a class="dropdown-item pointer-cursor">Date</a>
                                                        <a class="dropdown-item pointer-cursor">Sales Order#</a>
                                                        <a class="dropdown-item pointer-cursor">Reference</a>
                                                        <a class="dropdown-item pointer-cursor">Amount</a>
                                                        <a class="dropdown-item separator"></a>
                                                        <a class="dropdown-item pointer-cursor">Import Sales Orders</a>
                                                        <a class="dropdown-item pointer-cursor">Export Sales Orders</a>
                                                        <a class="dropdown-item separator"></a>
                                                        <a class="dropdown-item pointer-cursor">Refresh List</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="box box-primary bg-white border-top-0 border-bottom-0 no-shadowed padding-right-20 content-calculated-height-110 top-68">
                                

                                <div class="page-content bg-white padding-0 mg-right-0 mg-left-0">
                                    <div class="dgrid dgrid-grid ui-widget dgrid-03 mg-bottom-30 universal-grid border-ccc" role="grid">
                                        <div v-if="purchase_orders.length > 0" class="row">
                                            <div class="col-md-12 padding-right-0 col-lg-12 bg-white border-bottom">
                                                <table class="table table-vendor-list table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th style="width:2%;">
                                                                <input type="checkbox" class="pointer-cursor" @click="check_all($event)">
                                                            </th>
                                                            <th style="width:13%;">Date</th>
                                                            <th style="width:10%;">PO Number</th>
                                                            <th style="width:10%;">Reference</th>
                                                            <th style="width:18%;">Vendor Name</th>
                                                            <th style="width:13%;" class="text-right">Amount</th>
                                                            <th style="width:10%;">Billed Status</th>
                                                            <th style="width:14%;">Due Date</th>
                                                            <th style="width:10%;">Status</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr v-for="(purchase_order,index) in purchase_orders" :key="'purchase_order_'+index">
                                                            <td>
                                                                <input class="pointer-cursor" type="checkbox" v-model="selected_pos" :value="purchase_order.id">
                                                            </td>
                                                            <router-link tag="td" :to="'/purchases/purchase_orders/'+purchase_order.id+'/view'" class="padded pointer-cursor txt-uppercase">
                                                                {{purchase_order.po_date}}
                                                            </router-link>
                                                            <router-link tag="td" :to="'/purchases/purchase_orders/'+purchase_order.id+'/view'" class="padded pointer-cursor cl-amref fw-600 txt-uppercase">
                                                                {{purchase_order.trans_number}}
                                                            </router-link>
                                                            <router-link tag="td" :to="'/purchases/purchase_orders/'+purchase_order.id+'/view'" class="padded pointer-cursor">
                                                                {{purchase_order.ref_number}}
                                                            </router-link>
                                                            <router-link tag="td" :to="'/purchases/purchase_orders/'+purchase_order.id+'/view'" class="padded pointer-cursor">
                                                                {{purchase_order.vendor.display_as}}
                                                            </router-link>
                                                            <router-link tag="td" :to="'/purchases/purchase_orders/'+purchase_order.id+'/view'" class="padded pointer-cursor fw-600 fs-12 cl-444 txt-uppercase text-right">
                                                                {{purchase_order.vendor.currency.currency_sympol+' '+format_Money(purchase_order.total-purchase_order.discount_allowed)}}
                                                            </router-link>
                                                            <router-link tag="td" :to="'/purchases/purchase_orders/'+purchase_order.id+'/view'" class="padded pointer-cursor txt-uppercase">
                                                                
                                                            </router-link>
                                                            <router-link tag="td" :to="'/purchases/purchase_orders/'+purchase_order.id+'/view'" class="padded pointer-cursor">
                                                                {{purchase_order.po_due_date}}
                                                            </router-link>
                                                            <router-link tag="td" :to="'/purchases/purchase_orders/'+purchase_order.id+'/view'" class="padded pointer-cursor">
                                                                <a v-if="check_status(purchase_order.status,PROCESS_STATUS.ACCEPTED)" class="txt-uppercase fs-12 fw-600 cl-success-light">Accepted</a>
                                                                <a v-else-if="check_status(purchase_order.status,PROCESS_STATUS.DRAFT)" class="txt-uppercase fs-12 fw-600 cl-787887">Draft</a>
                                                                <a v-else-if="check_status(purchase_order.status,PROCESS_STATUS.DECLINED)" class="txt-uppercase fs-12 fw-600 cl-amref">Declined</a>
                                                                <a v-else-if="check_status(purchase_order.status,PROCESS_STATUS.EXPIRED)" class="txt-uppercase fs-12 fw-600 cl-787887">Expired</a>
                                                                <a v-else-if="check_status(purchase_order.status,PROCESS_STATUS.INVOICED)" class="txt-uppercase fs-12 fw-600 cl-success-light">Invoiced</a>
                                                                <a v-else-if="check_status(purchase_order.status,PROCESS_STATUS.SENT)" class="txt-uppercase fs-12 fw-600 cl-blue-link">Sent</a>
                                                                <a v-else-if="check_status(purchase_order.status,PROCESS_STATUS.OPEN)" class="txt-uppercase fs-12 fw-600 cl-blue-link">Open</a>
                                                                <a v-else="" class="txt-uppercase fs-12 fw-600 cl-787887">Pending</a>
                                                            </router-link>

                                                        </tr>
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <th colspan="10" class="bg-foo">
                                                                <paginate-template v-if="pagination.last_page > 1" :pagination="pagination" :offset="5" @paginate="loadSuppliers()" :custom="true"></paginate-template>
                                                            </th>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>

                                        <div v-else class="row">

                                            <div class="col-md-12 col-lg-12 bg-white text-center border-bottom mg-top-30 padding-top-30">
                                                <p class="fs-20">Start Managing Your Sales Activities!</p><br>
                                                <small class="fs-14 cl-777">Create, customize and send professional Sales Orders.</small><br><br>
                                                <a data-toggle="modal" data-target="#new_po_modal" class="btn btn-default btn-inventory btn-amref cl-white txt-uppercase">Create Sales Order</a>
                                            </div>

                                            <div class="col-md-12 col-lg-12 bg-white text-center border-bottom mg-top-20 padding-bottom-10">
                                                <img src="/assets/icons/dashboard/sales_order.png" class=" mg-bottom-20">
                                                <ul class="custom-list">
                                                    <li class="title">In the Sales Orders section, you can:</li>
                                                    <li>Create sales orders to follow up an estimate or customer request.</li>
                                                    <li>Convert the sales order into a purchase order if you are low on stock.</li>
                                                    <li>Convert the sales order into an invoice if the sale goes through.</li>
                                                </ul>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <!-- <po-modal v-if="page_ready" :suppliers="suppliers" :facilities="facilities" :customers="customers" :modal_id="'new_po_modal'" :modal_title="'Purchase Order'"></po-modal> -->
                                <!-- <supplier-modal v-if="page_ready" v-on:supplierAdded="loadSuppliers('hide')" :companies="companies" :countries="countries" :accountings="accountings" :title="'Supplier Information'" :initializations="initializations" :user_mode="'Create'" :initial_url="SUPPLIER_URL" :modal_id="'new_supplier_modal'"></supplier-modal>
                                <general-import-modal v-if="page_ready" :title="'Import Suppliers'" :modal_id="'import_supplier_modal'" :modal_min_width="1000" :sample_file="'suppliers'" :upload_type="'Suppliers'"></general-import-modal> -->
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
    // import SideBarSupplier from "../../partials/sidebars/SideBarSupplier";
    import SideBarInvSettings from "../../partials/sidebars/SideBarInvSettings";
    import SideBarInventory from "../../partials/sidebars/inventory/SideBarInventory";
    import SupplierModal from "../../partials/modals/vendors/SupplierModal";
    // import ImportSupplierModal from "../../partials/modals/vendors/ImportSupplierModal";
    import EditUserModal from "../../partials/modals/users/EditUserModal";
    import CommonLinks from "../../partials/sidebars/CommonLinks";
    import ConfirmModal from '../../partials/modals/ConfirmModal';
    // import SupplierHeader from './partials/SupplierHeader';
    import GeneralImportModal from "../../partials/modals/GeneralImportModal";
    import PaginateTemplate from '../../partials/pagination/PaginateTemplate';
    import PoModal from "../../partials/modals/purchase/PoModal";
    // import InviteModal from "../../partials/modals/InviteModal";
    // import MasterModal from "../../partials/modals/MasterModal";
    import DeleteModal from "../../partials/modals/DeleteModal";
    import ProcessingOverlay from "../../../../progress/ProcessingOverlay";
    // import DeleteStuffModal from "../../pharmacy/patials/DeleteStuffModal";
    import {get} from "../../../../../helpers/api";
    import Auth from "../../../../../store/auth";
    import AppInfo from "../../../../../helpers/config";
    import {removeElement,paginator,formatMoney} from "../../../../../helpers/functionmixin";
    import {PROCESS_STATUS} from "../../../../../helpers/process_status";
    import {COUNTRIES_URL,SUPPLIER_URL,ACCOUNTS_INITIALS,SUPPLIER_COMPANIES_URL,SUPPLIER_PO_URL} from '../../../../../router/api_routes';
    export default {
        name: "Index",
        components: {TopNavBar,CommonLinks,SideBar,SideBarInvSettings,PoModal,
        DeleteModal,SupplierModal,GeneralImportModal,ConfirmModal,PaginateTemplate,
        ProcessingOverlay,SideBarInventory},
        data(){
            return {
                //current_facility: {},
                PROCESS_STATUS: PROCESS_STATUS,
                initializations: {},
                accountings: {},
                suppliers: [],
                countries: [],
                companies: [],
                facilities: [],
                customers: [],
                purchase_orders: [],
                selected_pos: [],
                msg: 'Loading. Please wait...',
                //current_role_name: null,
                progress_overlay: 'hide',
                page_ready: false,
                pagination: paginator(),
                SUPPLIER_URL: SUPPLIER_URL,
            }
        },
        methods: {

            format_Money(money_to){
                return formatMoney(money_to);
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

            check_all(event){
                this.selected_pos = [];
                if(event.target.checked){
                    for (let index = 0; index < this.purchase_orders.length; index++) {
                        const element = this.purchase_orders[index];
                        this.selected_pos.push(element.id);
                    }
                }else{
                    this.selected_pos = [];
                }
            },

            reload_suppliers(supplier){
                this.suppliers.concat(supplier);
            },

            loadPo(){
              this.progress_overlay = "show";
                get(SUPPLIER_PO_URL)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.purchase_orders = res.data.results.data;
                        this.progress_overlay = "hide";
                        this.page_ready = true;
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

            check_permissions(perm_){
                return Auth.menuChecker(perm_);
            }

        },
        mounted() {
            //this.loadPo();
            this.page_ready = true;
        }
    }
</script>

<style lang="scss">
    th {
        position: sticky;
        top: 0px;
    }
</style>