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
                                <div class="pull pull-right app-header width-80-pc">
                                    <common-links :active_link="'supply'"></common-links>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="ui fitted divider"></div>

                    <div class="row mg-top-35">

                        <div class="col-md-2 col-lg-2 col-sm-2 padding-right-0 bg-foo min-height-100-vh">
                            <side-bar-supply :scrollable="false" :width="true" :transparent="true" :title="'Supply'" :active_num="'vehicle'"></side-bar-supply>
                        </div>

                        <div class="col-md-10 col-lg-10 col-sm-10 padding-right-0 padding-left-0 bg-foo min-height-100-vh">
                            
                            <div class="box box-primary bg-white border-top-0 border-bottom-0 no-shadowed">
                                
                                <div class="width-100-pc padding-left-20 padding-right-20 padding-top-20 padding-bottom-20 mg-bottom-30">
                                    <div  class="btn-group float-right" role="group" aria-label="Button group with nested dropdown">
                                        <button data-toggle="modal" data-target="#create_purchase_modal" type="button" class="btn combo-button combo-default">+ Create Vehicle</button>
                                        <div class="btn-group" role="group">
                                            <button id="btnGroupDrop" type="button" class="btn combo-button combo-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="btnGroupDrop">
                                                <a class="dropdown-item"> Download List</a>
                                                <a class="dropdown-item"> Print List</a>
                                            </div>
                                        </div>
                                    </div>
                                    <create-purchase-modal v-if="page_loaded" :modal_id="'create_purchase_modal'" :title="'Create Purchase'" :practice_id="practice_id" :initializations="initializations" :user_mode="'Create'" v-on:requestVendorForm="showVendor"></create-purchase-modal>
                                    <supplier-modal v-if="page_loaded" :initializations="initializations" :practice_id="practice_id" :modal_id="'new_vendor_modal_id'" :user_mode="'Create'" :title="'Supplier Information'" v-on:supplierAdded="loadInitials"></supplier-modal>
                                </div>

                                <div class="page-content bg-white min-height-100-vh padding-10">
                                    <div class="dgrid dgrid-grid ui-widget dgrid-03 mg-bottom-30 universal-grid border-ccc padding-left-20 padding-right-20" role="grid">
                                        <table class="receipt-item-table-2 table table-bordered table-hover mg-top-5">
                                            <thead>
                                                <tr>
                                                    <th style="width: 3%;"></th>
                                                    <th style="width: 20%;">Name</th>
                                                    <th style="width: 15%;">VehicleNo.</th>
                                                    <th style="width: 25%;">VehicleID.</th>
                                                    <th style="width: 10%;">ChaseNo.</th>
                                                    <th style="width: 10%;">EngineNo</th>
                                                    <th style="width: 10%;">Date</th>
                                                    <th style="width: 10%;">Status</th>
                                                    <th style="width: 2%;">
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody v-if="supply_list.length">
                                                <tr class="pointer-cursor" v-for="(purchase, index) in supply_list" :key="'category_'+index">
                                                    <td class="padded">{{index+1}}</td>
                                                    <td class="padded cl-amref fw-600">#PO{{purchase.po_number}}</td>
                                                    <td class="padded">{{purchase.po_date}}</td>
                                                    <td class="padded">{{purchase.po_due_date}}</td>
                                                    <td class="padded">{{formatMoneys(purchase.grand_total)}}</td>
                                                    <td class="padded">
                                                        <span v-if="purchase.status==='Delivered'" class="btn-approved">{{purchase.status}}</span>
                                                        <span v-if="purchase.status==='Pending'" class="btn-pending">{{purchase.status}}</span>
                                                        <span v-if="purchase.status==='Submitted'" class="btn-declined">{{purchase.status}}</span>
                                                    </td>
                                                    <td class="padded">
                                                        <div class="btn-group float-right" role="group" aria-label="Button group">
                                                            <div class="btn-group" role="group">
                                                                <a :id="'btnGroupDrop2_'+index" class="dropdown-toggle pointer-cursor" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                </a>
                                                                <div class="dropdown-menu" :aria-labelledby="'btnGroupDrop2_'+index">
                                                                    <a data-toggle="modal" :data-target="'#preview_purchase_'+index" class="dropdown-item">Preview</a>
                                                                    <a v-if="purchase.status==='Pending'" class="dropdown-item pointer-cursor">Edit</a>
                                                                    <a v-if="!purchase.status==='Delivered'" class="dropdown-item pointer-cursor">Pending</a>
                                                                    <a v-if="purchase.status==='Delivered'" class="dropdown-item pointer-cursor">Close</a>
                                                                    <a v-if="purchase.status==='Pending' && check_permissions('approve.purchase')" class="dropdown-item">Accepted</a>
                                                                    <a v-if="purchase.status==='Pending' && check_permissions('approve.purchase')" class="dropdown-item">Rejected</a>
                                                                    <a v-if="purchase.status==='Submitted' && check_permissions('approve.purchase')" data-toggle="modal" :data-target="'#grn_note_'+index" class="dropdown-item pointer-cursor">Receive Goods</a>
                                                                    <a v-if="purchase.status==='Delivered' && check_permissions('create.purchase')" class="dropdown-item">Grn Note</a>
                                                                    <a v-if="purchase.status==='Delivered' && check_permissions('create.stock')" data-toggle="modal" :data-target="'#add_stock_item_'+index" class="dropdown-item">Update to stock</a>
                                                                    <a v-if="!purchase.status==='Delivered'" data-toggle="modal" :data-target="'#delete_purchase_'+index" class="dropdown-item">Delete</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <po-preview-modal :modal_id="'preview_purchase_'+index" :purchase="purchase" :organ_data="organ_data"></po-preview-modal>
                                                    <grn-note-modal :modal_id="'grn_note_'+index" :purchase="purchase" v-on:poReceived="alter_status()" :key="'po'+purchase.id" :initializations="initializations" :organ_data="organ_data" :modal_title="'Goods Received Note: PO#'+purchase.po_number"></grn-note-modal>
                                                    <add-stock-item-modal :modal_id="'add_stock_item_'+index" :purchase="purchase" :key="'poss'+purchase.id" :initializations="initializations" :organ_data="organ_data" :modal_title="'Add Stock Item'"></add-stock-item-modal>
                                                </tr>
                                            </tbody>
                                            <tbody v-if="!supply_list.length">
                                                <tr>
                                                    <td colspan="9" class="cl-amref text-center fs-16 padding-top-20 padding-bottom-20">No vehicle to dispalay</td>
                                                </tr>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th colspan="9" class="bg-foo">
                                                        <paginate-template v-if="pagination.last_page > 1" :pagination="pagination" :offset="5" @paginate="loadPo()" :custom="true"></paginate-template>
                                                    </th>
                                                </tr>
                                            </tfoot>
                                        </table>
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
    import PurchasesFilters from "../../partials/filters/PurchasesFilters";
    import PurchasesTable from "../../partials/tables/PurchasesTable";
    import CreatePurchaseModal from "../../partials/modals/purchase/CreatePurchaseModal";
    import ProcessingOverlay from '../../../../progress/ProcessingOverlay';
    import CommonLinks from "../../partials/sidebars/CommonLinks";
    import {get} from "../../../../../helpers/api";
    import Auth from "../../../../../store/auth";
    import SupplierModal from '../../partials/modals/vendors/SupplierModal';
    import {PURCHASES_URL,PURCHASES_FACILITY_URL,PURCHASES_ATTRIBUTES_URL} from '../../../../../router/api_routes';
    import {createHtmlErrorString} from '../../../../../helpers/functionmixin';
    export default {
        name: "Index",
        components: {TopNavBar,SideBar,
        SideBarSupply,ProcessingOverlay,CommonLinks,
        PurchasesFilters,PurchasesTable,CreatePurchaseModal,SupplierModal},
        data(){
            return {
                organ_data: {},
                practice_id: '',
                purchases: [],
                initializations: {},
                page_loaded: false,
                progress_overlay: 'hide',
                pagination: {
                    'current_page': 1
                },
                supply_list: [],
            }
        },
        methods: {

            loadPurchases(){
              this.progress_overlay = "show";
                get(PURCHASES_FACILITY_URL+'/'+this.practice_id+'?page='+this.pagination.current_page)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.purchases = res.data.results.data;
                        //this.progress_overlay = "hide";
                        console.info(this.purchases);
                        //this.page_loaded = true;
                        this.loadInitials();
                    }
                }).catch((err) => {
                    this.progress_overlay = "hide";
                    this.page_loaded = false;
                    if(err.response.status === 422) {
                        this.$awn.warning(createHtmlErrorString(err.response.data.errors))
                    }else if (err.response.status === 500){
                        this.$awn.warning(err.response.data.description);
                        //this.$router.push('/500');
                        window.location.href = "/500";
                    }
                    else{
                        this.processing = false;
                        this.$awn.warning(err.response.data.description)
                    }
                });
            },

            loadInitials(){
              this.progress_overlay = "show";
                get(PURCHASES_ATTRIBUTES_URL+'/'+this.practice_id)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.initializations = res.data.results;
                        this.progress_overlay = "hide";
                        // console.info(this.initializations);
                        this.page_loaded = true;
                    }
                }).catch((err) => {
                    this.progress_overlay = "hide";
                    this.page_loaded = false;
                    if(err.response.status === 422) {
                        this.$awn.warning(createHtmlErrorString(err.response.data.errors))
                    }else if (err.response.status === 500){
                        this.$awn.warning(err.response.data.description);
                        //this.$router.push('/500');
                        window.location.href = "/500";
                    }
                    else{
                        this.processing = false;
                        this.$awn.warning(err.response.data.description)
                    }
                });
            },
            
            showVendor(){
                $("#new_vendor_modal_id").modal('show');
            },
            
        },
        mounted() {
            this.practice_id = Auth.getCurrentAccount('id');
            this.organ_data = Auth.getCurrentAccount('account');
            console.info('.......');
            console.info(this.organ_data);
            this.loadPurchases();
        }
    }
</script>

