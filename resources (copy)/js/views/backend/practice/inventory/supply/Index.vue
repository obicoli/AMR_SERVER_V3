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
                            <side-bar-supply :scrollable="false" :width="true" :transparent="true" :title="'Transfer(Supply)'" :active_num="'supply'"></side-bar-supply>
                        </div>

                        <div class="col-md-10 col-lg-10 col-sm-10 padding-right-0 padding-left-0 bg-foo min-height-100-vh">
                            
                            <div class="box box-primary bg-white border-top-0 border-bottom-0 no-shadowed">
                                <div class="width-40-pc mg-left-30 padding-left-20 padding-right-20 padding-top-20 padding-bottom-20 mg-bottom-30 pull-left">
                                    <search-database-form-control v-if="page_loaded" :search_type="'Supply'" :placeholder="'Search here'" :field_wdth="250" :rounded_px="4"></search-database-form-control>
                                </div>
                                <div class="width-40-pc padding-left-20 padding-right-20 padding-top-20 padding-bottom-20 mg-bottom-30 pull-right">
                                    <div  class="btn-group float-right" role="group" aria-label="Button group with nested dropdown">
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
                                    </div>
                                </div>

                                <div class="page-content bg-white min-height-100-vh padding-10">
                                    <div class="mg-bottom-30 universal-grid padding-left-20 padding-right-20" role="grid">
                                        <table class="receipt-item-table-2 table table-bordered table-hover mg-top-5">
                                            <thead>
                                                <tr>
                                                    <th style="width: 10%;">#No</th>
                                                    <th style="width: 10%;">Date</th>
                                                    <th style="width: 30%;">Facility/Customer</th>
                                                    <th style="width: 8%;">Method</th>
                                                    <th style="width: 10%;">Total</th>
                                                    <th style="width: 10%;">Discount(kes)</th>
                                                    <th style="width: 10%;">Received</th>
                                                    <th style="width: 10%;">Status</th>
                                                    <th style="width: 2%;">
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody v-if="supply_list.length">
                                                <tr class="pointer-cursor" v-for="(purchase, index) in supply_list" :key="'category_'+index">
                                                    <td class="padded cl-amref fw-600">{{purchase.trans_number}}</td>
                                                    <td class="padded">{{purchase.sp_date}}</td>
                                                    <td class="padded">{{purchase.destination_facility.facility_name}}</td>
                                                    <td class="padded cl-amref fw-600">{{purchase.payment_type.name}}</td>
                                                    <td class="padded">{{formatMoneys(purchase.total_amount)}}</td>
                                                    <td class="padded">{{formatMoneys(purchase.discount)}}</td>
                                                    <td class="padded">{{formatMoneys(purchase.paid_amount)}}</td>
                                                    <td class="padded">
                                                        {{purchase.trans_status[purchase.trans_status.length-1].status}}
                                                    </td>
                                                    <td class="padded">
                                                        <div class="btn-group float-right" role="group" aria-label="Button group">
                                                            <div class="btn-group" role="group">
                                                                <a :id="'btnGroupDrop2_'+index" class="dropdown-toggle pointer-cursor" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                </a>
                                                                <div class="dropdown-menu" :aria-labelledby="'btnGroupDrop2_'+index">
                                                                    <a data-toggle="modal" :data-target="'#supply_preview_'+index" class="dropdown-item">Preview Transfer</a>
                                                                    <a v-if="purchase.trans_status[purchase.trans_status.length-1].status === PROCESS_STATUS.PENDING" data-toggle="modal" :data-target="'#gon_'+index" class="dropdown-item">Generate Goods Out Note</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <supply-preview :modal_id="'supply_preview_'+index" :purchase="purchase" :organ_data="organ_data"></supply-preview>
                                                    <confirm-modal v-if="purchase.trans_status[purchase.trans_status.length-1].status === PROCESS_STATUS.PENDING" :form_inputs="form_inputs" v-on:successReq="loadSupplies" :modal_id="'gon_'+index" :modal_title="'Goods Out Note'" :confirm_message="'Are you sure?'" :item_url="initial_url+'/'+purchase.id"></confirm-modal>
                                                </tr>
                                            </tbody>

                                            <tbody v-if="!supply_list.length">
                                                <tr>
                                                    <td colspan="10" class="cl-amref text-center fs-16 padding-top-20 padding-bottom-20">No supply to display</td>
                                                </tr>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th colspan="10" class="bg-foo">
                                                        <paginate-template v-if="pagination.last_page > 1" :pagination="pagination" :offset="5" @paginate="loadPo()" :custom="true"></paginate-template>
                                                    </th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                                <supplier-modal v-if="page_loaded" :initializations="initializations" :practice_id="practice_id" :modal_id="'new_vendor_modal_id'" :user_mode="'Create'" :title="'Supplier Information'" v-on:supplierAdded="loadInitials"></supplier-modal>
                                <supply-modal v-if="page_loaded" v-on:successSupply="loadSupplies('hide')" :address_ob="address_ob" :practice_id="temp_practice_id" :modal_title="'Inventory Transfers(Supply)'" :initializations="initializations" :label_txt="'SEARCH ITEM'" :modal_id="'create_supply_modal'"></supply-modal>
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
    import {PURCHASES_URL,PURCHASES_FACILITY_URL,PURCHASES_ATTRIBUTES_URL,PRODUCT_SUPPLY} from '../../../../../router/api_routes';
    import {createHtmlErrorString,formatMoney} from '../../../../../helpers/functionmixin';
    import {PROCESS_STATUS} from '../../../../../helpers/process_status';
    export default {
        name: "Index",
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
                initial_url:PRODUCT_SUPPLY
            }
        },
        methods: {

            check_permissions(perm_){
                return Auth.menuChecker(perm_);
            },

            loadSupplies(overlay_status="hide"){
                this.progress_overlay = overlay_status;
                get(PRODUCT_SUPPLY+'/'+this.practice_id+'?page='+this.pagination.current_page)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        //console.info(res.data.results);
                        this.supply_list = res.data.results.data;
                        this.progress_overlay = "hide";
                        //console.info(this.supply_list);
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

            formatMoneys(money_to){
                return formatMoney(money_to);
            },

            loadInitials(){
              this.progress_overlay = "show";
                get(PURCHASES_ATTRIBUTES_URL)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.initializations = res.data.results;
                        //this.progress_overlay = "hide";
                        console.info(this.initializations);
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
            
            showVendor(){
                $("#new_vendor_modal_id").modal('show');
            },
            
        },
        mounted() {
            this.practice_id = Auth.getCurrentAccount('id');
            this.organ_data = Auth.getCurrentAccount('account');
            this.address_ob = Auth.getCurrentAccount('address');
            //console.info(this.address_ob);
            this.form_inputs.staff_id = this.address_ob.staff_address.staff_id;
            this.temp_practice_id = this.practice_id;
            this.loadInitials();
        }
    }
</script>

