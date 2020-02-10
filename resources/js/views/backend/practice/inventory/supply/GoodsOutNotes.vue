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
                            <side-bar-supply :scrollable="false" :width="true" :transparent="true" :title="'Goods Out Notes'" :active_num="'good_out_notes'"></side-bar-supply>
                        </div>

                        <div class="col-md-10 col-lg-10 col-sm-10 padding-right-0 padding-left-0 bg-foo min-height-100-vh">
                            
                            <div class="box box-primary bg-white border-top-0 border-bottom-0 no-shadowed">
                                <div class="width-40-pc mg-left-30 padding-left-20 padding-right-20 padding-top-20 padding-bottom-20 mg-bottom-30 pull-left">
                                    <search-database-form-control v-if="page_loaded" :search_type="'Supply'" :placeholder="'Search here'" :field_wdth="250" :rounded_px="4"></search-database-form-control>
                                </div>
                                <div class="width-40-pc padding-left-20 padding-right-20 padding-top-20 padding-bottom-20 mg-bottom-30 pull-right">
                                    <!-- <div  class="btn-group float-right" role="group" aria-label="Button group with nested dropdown">
                                        <button v-if="check_permissions('create.inv.supply')" data-toggle="modal" data-target="#create_supply_modal" type="button" class="btn combo-button combo-default">+ Create Supply</button>
                                        <button v-if="!check_permissions('create.inv.supply')" data-toggle="modal" type="button" class="btn combo-button combo-default">Action</button>
                                        <div class="btn-group" role="group">
                                            <button id="btnGroupDrop" type="button" class="btn combo-button combo-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="btnGroupDrop">
                                                <a class="dropdown-item"> Download List</a>
                                                <a class="dropdown-item"> Print List</a>
                                            </div>
                                        </div>
                                    </div> -->
                                </div>

                                <div class="page-content bg-white min-height-100-vh padding-10">
                                    <div class="mg-bottom-30 universal-grid padding-left-20 padding-right-20" role="grid">
                                        <table class="receipt-item-table-2 table table-bordered mg-top-5">
                                            <thead>
                                                <tr>
                                                    <th style="width: 4%;"></th>
                                                    <th style="width: 9%;">GON_ID</th>
                                                    <th style="width: 11%;">Order</th>
                                                    <th style="width: 30%;">DeliverTo</th>
                                                    <th style="width: 13%;">Department</th>
                                                    <th style="width: 5%;">Printed</th>
                                                    <th style="width: 7%;">Picked</th>
                                                    <th style="width: 7%;">Packed</th>
                                                    <th style="width: 7%;">Shipped</th>
                                                    <th style="width: 4%;"></th>
                                                </tr>
                                            </thead>
                                            <tbody v-for="(purchase, index) in supply_list" :key="'good_out_note_'+index">
                                                <tr class="pointer-cursor" data-toggle="collapse" :data-target="'#collapse_gon_'+index">
                                                    <td class="padded">{{index+1}}</td>
                                                    <td class="padded cl-amref fw-600">{{purchase.trans_number}}</td>
                                                    <td class="padded">{{purchase.transaction_type.trans_number}}</td>
                                                    <td class="padded">{{purchase.transaction_type.destination_facility.facility_name}}</td>
                                                    <td class="padded">{{purchase.transaction_type.destination_facility.department.name}}</td>
                                                    <td class="padded text-center">
                                                        <span v-if="!check_status(purchase.transaction_type.trans_status, PROCESS_STATUS.PRINTED)" class="cl-amref fw-600">x</span>
                                                        <span v-if="check_status(purchase.transaction_type.trans_status, PROCESS_STATUS.PRINTED)" class="fw-600 cl-success-light"><i class="fa fa-check"></i></span>
                                                    </td>
                                                    <td class="padded text-center">
                                                        <span v-if="!check_status(purchase.transaction_type.trans_status, PROCESS_STATUS.PICKED)" class="cl-amref fw-600">x</span>
                                                        <span v-if="check_status(purchase.transaction_type.trans_status, PROCESS_STATUS.PICKED)" class="fw-600 cl-success-light"><i class="fa fa-check"></i></span>
                                                    </td>
                                                    <td class="padded text-center">
                                                        <span v-if="!check_status(purchase.transaction_type.trans_status, PROCESS_STATUS.PACKED)" class="cl-amref fw-600">x</span>
                                                        <span v-if="check_status(purchase.transaction_type.trans_status, PROCESS_STATUS.PACKED)" class="fw-600 cl-success-light"><i class="fa fa-check"></i></span>
                                                    </td>
                                                    <td class="padded text-center">
                                                        <span v-if="!check_status(purchase.transaction_type.trans_status, PROCESS_STATUS.SHIPPED)" class="cl-amref fw-600">x</span>
                                                        <span v-if="check_status(purchase.transaction_type.trans_status, PROCESS_STATUS.SHIPPED)" class="fw-600 cl-success-light"><i class="fa fa-check"></i></span>
                                                    </td>
                                                    <td>
                                                        
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="11" class="zeroPadding bg-pinksh">
                                                        <div class="collapse out width-100-pc" :id="'collapse_gon_'+index">
                                                            <div class="row">
                                                                <div class="col-lg-12 mg-bottom-30">
                                                                    <div class="bg-foo mg-top-10 mg-right-10 mg-left-10 padding-10 min-height-68">
                                                                        <h4 class="fs-16 fw-600">Goods-out note #<span class="cl-amref">{{purchase.trans_number}}</span>*{{index+1}}</h4>
                                                                        <h6 class="width-50-pc float-left fs-13 fw-600 mg-top-10">Date: <span class="cl-787887">{{purchase.trans_date}}</span> Tracking ref:<span class="cl-787887">_</span> Shipping method:<span class="cl-787887">_</span></h6>
                                                                        <div class=" width-50-pc float-right text-right">
                                                                            <button class="btn btn-default btn-white btn-inventory">Print</button>
                                                                            <button class="btn btn-default btn-white btn-inventory">Send Email</button>
                                                                            <div class="btn-group" role="group">
                                                                                <button :id="'btnGroupDrop'+index" type="button" class="btn pointer-cursor combo-button combo-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                                    Action
                                                                                </button>
                                                                                <div class="dropdown-menu" :aria-labelledby="'btnGroupDrop'+index">
                                                                                    <!-- <a v-if="check_permissions('approve.inv.supply')" @click="submit_request('Save & Print')" class="dropdown-item pointer-cursor"> Save & Print</a>
                                                                                    <a v-if="check_permissions('dispatch.inv.supply')" @click="submit_request('Save & Pick')" class="dropdown-item pointer-cursor"> Save & Pick</a>
                                                                                    <a v-if="check_permissions('dispatch.inv.supply')" @click="submit_request('Save & Pack')" class="dropdown-item pointer-cursor"> Save & Pack</a>
                                                                                    <a v-if="check_permissions('dispatch.inv.supply')" @click="submit_request('Save & Ship')" class="dropdown-item pointer-cursor"> Save & Ship</a>
                                                                                    <a v-if="check_permissions('create.inv.supply')" @click="submit_request('Save & New')" class="dropdown-item pointer-cursor"> Save & New</a>
                                                                                    <a v-if="check_permissions('create.inv.supply')" @click="submit_request('Save & Close')" class="dropdown-item pointer-cursor"> Save & Close</a> -->
                                                                                    <a v-if="check_permissions('print.inv.supply') && check_status(purchase.transaction_type.trans_status, PROCESS_STATUS.PENDING)" data-toggle="modal" :data-target="'#print_gon'+index" class="dropdown-item">Print</a>
                                                                                    <a v-if="check_permissions('pick.inv.supply') && check_status(purchase.transaction_type.trans_status, PROCESS_STATUS.PRINTED)" data-toggle="modal" :data-target="'#pick_gon'+index" class="dropdown-item">Pick</a>
                                                                                    <a v-if="check_permissions('pack.inv.supply') && check_status(purchase.transaction_type.trans_status, PROCESS_STATUS.PICKED)" data-toggle="modal" :data-target="'#pack_gon'+index" class="dropdown-item">Pack</a>
                                                                                    <a v-if="check_permissions('ship.inv.supply') && check_status(purchase.transaction_type.trans_status, PROCESS_STATUS.PACKED)" @click="set_gon_status(PROCESS_STATUS.SHIPPED)" data-toggle="modal" :data-target="'#ship_gon'+index" class="pointer-cursor fs-13 dropdown-item">Ship</a>
                                                                                    <a v-if="check_status(purchase.transaction_type.trans_status, PROCESS_STATUS.SHIPPED)" data-toggle="modal" :data-target="'#ship_gon'+index" class="dropdown-item">Create Invoice</a>
                                                                                    <!--  check_permissions('ship.inv.supply') &&  <a data-toggle="modal" :data-target="'#delete_gon'+index" class="dropdown-item">Delete</a> -->
                                                                                    <a class="pointer-cursor dropdown-item">Delete</a>
                                                                                    
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="mg-right-10 mg-left-10 padding-0">
                                                                        <div v-if="check_status(purchase.transaction_type.trans_status, PROCESS_STATUS.PRINTED)" class="width-25-pc bd bg-white padding-left-10 padding-right-10 float-left">
                                                                            <label class="width-100-pc mg-bottom-0 cl-444 fs-12 fw-600">Print</label>
                                                                            <label class="width-100-pc cl-success-light text-right mg-bottom-0 fs-12 fw-600"><i class="fa fa-check"></i> {{check_status(purchase.transaction_type.trans_status, PROCESS_STATUS.PRINTED)}}</label>
                                                                        </div>
                                                                        <div v-if="check_status(purchase.transaction_type.trans_status, PROCESS_STATUS.PICKED)" class=" width-25-pc bd bg-white padding-left-10 padding-right-10 float-left">
                                                                            <label class="width-100-pc mg-bottom-0 cl-444 fs-12 fw-600">Pick</label>
                                                                            <label class="width-100-pc cl-success-light text-right mg-bottom-0 fs-12 fw-600"><i class="fa fa-check"></i> {{check_status(purchase.transaction_type.trans_status, PROCESS_STATUS.PRINTED)}}</label>
                                                                        </div>
                                                                        <div v-if="check_status(purchase.transaction_type.trans_status, PROCESS_STATUS.PACKED)" class=" width-25-pc bd bg-white padding-left-10 padding-right-10 float-left">
                                                                            <label class="width-100-pc mg-bottom-0 cl-444 fs-12 fw-600">Pack</label>
                                                                            <label class="width-100-pc cl-success-light text-right mg-bottom-0 fs-12 fw-600"><i class="fa fa-check"></i> {{check_status(purchase.transaction_type.trans_status, PROCESS_STATUS.PRINTED)}}</label>
                                                                        </div>
                                                                        <div v-if="check_status(purchase.transaction_type.trans_status, PROCESS_STATUS.SHIPPED)" class=" width-25-pc bd bg-white padding-left-10 padding-right-10 float-left">
                                                                            <label class="width-100-pc mg-bottom-0 cl-444 fs-12 fw-600">Ship</label>
                                                                            <label class="width-100-pc cl-success-light text-right mg-bottom-0 fs-12 fw-600"><i class="fa fa-check"></i> {{check_status(purchase.transaction_type.trans_status, PROCESS_STATUS.PRINTED)}}</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row justify-content-center">
                                                                <div class="col-lg-10 mg-bottom-30">

                                                                    <section class="content padding-10" id="print_section">
                                                                        <div class="invoice invoice-2 invoice-body invoice-border zero-border">
                                                                            <div class="row">
                                                                                <div class="col-md-7 col-sm-7 pull-left text-center report-header">
                                                                                    <img class="print-logo-size" :src="organ_data.data.facility.app_data.logo">
                                                                                    <h2 class="invoice-title txt-uppercase fs-14"><b class="cl-amref">{{organ_data.data.facility.app_data.name}}</b></h2>
                                                                                </div>
                                                                                <div class="col-md-5 col-sm-5 pull-right text-right">
                                                                                    <h2 class="invoice-title txt-uppercase fs-15"><b>Delivery Note</b></h2>
                                                                                </div>
                                                                            </div>
                                                                            <div class="row set-border-bottom">
                                                                                <div class="col-md-5 col-sm-5 pull-left to-address padding-top-20 mg-top-20">
                                                                                    <h2 class="invoice-title txt-uppercase fs-15"><b>Bill To:</b></h2>
                                                                                    <h5 class="fs-12 cl-444"><label class="fs-13 fw-600 txt-uppercase">Facility:</label> <small class="fs-12 cl-787887">{{purchase.transaction_type.destination_facility.facility_name}}</small></h5>
                                                                                    <h5 class="fs-12 cl-444"><label class="fs-13 fw-600 txt-uppercase">Dep:</label> <small class="fs-12 cl-787887">{{purchase.transaction_type.destination_facility.department.name}}</small></h5>
                                                                                    <h5 class="fs-13 cl-444"><label class="fs-13 fw-600 txt-uppercase">Address:</label> <small class="fs-13 cl-787887">{{purchase.transaction_type.destination_facility.address}}</small></h5>
                                                                                </div>
                                                                                <div class="col-md-2 col-sm-2 pull-right mg-top-20">
                                                                                </div>
                                                                                <div class="col-md-5 col-sm-5 pull-right to-address padding-top-20 mg-top-20">
                                                                                    <span class="pull-right receipt-details">
                                                                                        <h2 class="invoice-title txt-uppercase fs-15"><b>Ship To:</b></h2>
                                                                                        <h5 class="fs-12 cl-444"><label class="fs-13 fw-600 txt-uppercase">Facility:</label> <small class="fs-12 cl-787887">{{purchase.transaction_type.destination_facility.facility_name}}</small></h5>
                                                                                        <h5 class="fs-12 cl-444"><label class="fs-13 fw-600 txt-uppercase">Dep:</label> <small class="fs-12 cl-787887">{{purchase.transaction_type.destination_facility.department.name}}</small></h5>
                                                                                        <h5 class="fs-13 cl-444"><label class="fs-13 fw-600 txt-uppercase">Address:</label> <small class="fs-13 cl-787887">{{purchase.transaction_type.destination_facility.address}}</small></h5>
                                                                                    </span>
                                                                                </div>
                                                                            </div>

                                                                            <div class="row">
                                                                                <div class="col-md-12">
                                                                                    <table class="receipt-item-table table table-bordered">
                                                                                        <thead>
                                                                                            <tr>
                                                                                                <th style="width:10%;">No</th>
                                                                                                <th style="width:20%;">Qty</th>
                                                                                                <th style="width:20%;">Item Code</th>
                                                                                                <th style="width:50%;">Description</th>
                                                                                            </tr>
                                                                                        </thead>
                                                                                        <tbody class="noprintclass">
                                                                                            <tr v-for="(item,index_i) in purchase.transaction_type.items" :key="'index_i'+index_i">
                                                                                                <td>{{index_i+1}}</td>
                                                                                                <td>{{formatMoneys(item.qty)}}</td>
                                                                                                <td>{{item.sku_code}}</td>
                                                                                                <td>{{item.item_name}} | {{item.brand}} | {{item.brand_sector}} | {{item.unit_weight}}{{item.measure_unit_sympol}}</td>
                                                                                            </tr>
                                                                                        </tbody>
                                                                                    </table>
                                                                                </div>
                                                                            </div>

                                                                            
                                                                            <div class="row">
                                                                                <div class="col-md-12 text-center accepted-row padding-top-10">
                                                                                    <p class="fs-13">Delivery Note was created on a computer and is valid without the signature and seal.</p>
                                                                                </div>
                                                                            </div>

                                                                        </div>
                                                                    </section>

                                                                </div>
                                                            </div>

                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>

                                            <tbody v-if="!supply_list.length">
                                                <tr>
                                                    <td colspan="11" class="cl-amref text-center fs-16 padding-top-20 padding-bottom-20">No data to display</td>
                                                </tr>
                                            </tbody>
                                            
                                            <tfoot>
                                                <tr>
                                                    <th colspan="11" class="bg-foo">
                                                        <paginate-template v-if="pagination.last_page > 1" :pagination="pagination" :offset="5" @paginate="loadPo()" :custom="true"></paginate-template>
                                                    </th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                                <supplier-modal v-if="page_loaded" :initializations="initializations" :practice_id="practice_id" :modal_id="'new_vendor_modal_id'" :user_mode="'Create'" :title="'Supplier Information'" v-on:supplierAdded="loadInitials"></supplier-modal>
                                <supply-modal v-if="page_loaded" v-on:successSupply="loadSupplies('hide')" :address_ob="address_ob" :practice_id="temp_practice_id" :modal_title="'Inventory Transfers(Supply)'" :initializations="initializations" :label_txt="'SEARCH ITEM'" :modal_id="'create_supply_modal'"></supply-modal>
                                <div v-for="(purchase, index_g) in supply_list" :key="'index_g'+index_g">
                                    <confirm-modal :form_inputs="form_inputs" :modal_id="'ship_gon'+index_g" :modal_title="'Goods Out Note'" v-on:successReq="loadSupplies('hide')" :confirm_message="'Are you sure?'" :item_url="initial_url+'/'+purchase.id"></confirm-modal>
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
    import SupplyModal from "../../partials/modals/supply/SupplyModal";
    import ConfirmModal from "../../partials/modals/ConfirmModal";
    import SupplyPreview from "../../partials/modals/supply/SupplyPreview";
    import ProcessingOverlay from '../../../../progress/ProcessingOverlay';
     import SearchDatabaseFormControl from '../../partials/search/SearchDatabaseFormControl';
    import CommonLinks from "../../partials/sidebars/CommonLinks";
    import {get} from "../../../../../helpers/api";
    import Auth from "../../../../../store/auth";
    import SupplierModal from '../../partials/modals/vendors/SupplierModal';
    import {PURCHASES_URL,PURCHASES_FACILITY_URL,PURCHASES_ATTRIBUTES_URL,PRODUCT_SUPPLY,PRODUCT_GON} from '../../../../../router/api_routes';
    import {createHtmlErrorString,formatMoney} from '../../../../../helpers/functionmixin';
    import {PROCESS_STATUS} from '../../../../../helpers/process_status';
    export default {
        name: "GoodsOutNotes",
        components: {TopNavBar,SideBar,SupplyPreview,ConfirmModal,
        SideBarSupply,ProcessingOverlay,CommonLinks,SearchDatabaseFormControl,
        PurchasesFilters,PurchasesTable,SupplyModal,SupplierModal},
        data(){
            return {
                organ_data: {},
                form_inputs: {
                    status : 'Printed',
                    action : 'Goods Out Note',
                    staff_id : ''
                },
                address_ob: {},
                practice_id: '',
                temp_practice_id: '',
                supplies: [],
                initializations: {},
                page_loaded: false,
                progress_overlay: 'hide',
                pagination: {
                    'current_page': 1
                },
                supply_list: [],
                PROCESS_STATUS : PROCESS_STATUS,
                initial_url:PRODUCT_GON
            }
        },
        methods: {

            check_permissions(perm_){
                return Auth.menuChecker(perm_);
            },

            set_gon_status(status_){
                this.form_inputs.status = status_;
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

            loadSupplies(overlay_status="hide"){
              this.progress_overlay = overlay_status;
                get(this.initial_url+'/'+this.practice_id+'?page='+this.pagination.current_page)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        console.info(res.data.results);
                        this.supply_list = res.data.results.data;
                        this.progress_overlay = "hide";
                        console.info(this.supply_list);
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

            formatMoneys(money_to){
                return formatMoney(money_to);
            },

            loadInitials(){
              this.progress_overlay = "show";
                get(PURCHASES_ATTRIBUTES_URL+'/'+this.practice_id)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.initializations = res.data.results;
                        this.loadSupplies("show");
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
            
        },
        mounted() {
            this.practice_id = Auth.getCurrentAccount('id');
            this.organ_data = Auth.getCurrentAccount('account');
            this.address_ob = Auth.getCurrentAccount('address');
            this.form_inputs.staff_id = this.address_ob.staff_address.staff_id;
            this.temp_practice_id = this.practice_id;
            this.loadInitials();
        }
    }
</script>

