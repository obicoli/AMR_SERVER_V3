<template>

    <div>

        <processing-overlay :message="'Loading. Please wait...'" :status="progress_overlay"></processing-overlay>

        <top-nav-bar :inventory="true"></top-nav-bar>

        <side-bar></side-bar>

        <div class="wp-content">

            <div class="row">

                <div class="col-md-12 col-lg-12 col-sm-12 padding-left-0">

                    <div class="settings-header shadowed main-heading bg-foo">
                    </div>

                    <div class="ui fitted divider"></div>

                    <div class="row mg-top-35">

                        <div class="col-md-2 col-lg-2 col-sm-2 padding-right-0 bg-foo min-height-100-vh">
                            <side-bar-requistion :scrollable="false" :width="true" :transparent="true" :title="'Requistions'" :active_num="'all'"></side-bar-requistion>
                        </div>

                        <div class="col-md-10 col-lg-10 col-sm-10 padding-right-0 padding-left-0 bg-foo min-height-100-vh">
                            
                            <div class="box box-primary bg-white border-top-0 border-bottom-0 no-shadowed">
                                
                                <div class="width-100-pc padding-left-20 padding-right-20 padding-top-20 padding-bottom-20 mg-bottom-30">
                                    <div class="float-left width-60-pc">
                                        <purchases-filters></purchases-filters>
                                    </div>
                                    <div  class="btn-group float-right" role="group" aria-label="Button group with nested dropdown">
                                        <button data-toggle="modal" data-target="#create_purchase_modal" type="button" class="btn combo-button combo-default">+ Create Purchase</button>
                                        <div class="btn-group" role="group">
                                            <button id="btnGroupDrop" type="button" class="btn combo-button combo-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="btnGroupDrop">
                                                <a class="dropdown-item"> Print Report</a>
                                                <a class="dropdown-item"> Export to Csv</a>
                                            </div>
                                        </div>
                                    </div>
                                    <create-purchase-modal v-if="page_loaded" :modal_id="'create_purchase_modal'" :title="'Create Purchase'" :practice_id="practice_id" :initializations="initializations" :user_mode="'Create'" v-on:requestVendorForm="showVendor"></create-purchase-modal>
                                    <supplier-modal v-if="page_loaded" :initializations="initializations" :practice_id="practice_id" :modal_id="'new_vendor_modal_id'" :user_mode="'Create'" :title="'Supplier Information'" v-on:supplierAdded="loadInitials"></supplier-modal>
                                </div>

                                <div class="page-content bg-white min-height-100-vh padding-10">
                                    <div class="dgrid dgrid-grid ui-widget dgrid-03 mg-bottom-30 universal-grid border-ccc padding-left-20 padding-right-20" role="grid">
                                        <purchases-table v-if="page_loaded" :purchases="purchases" :organ_data="organ_data" v-on:deletionSuccessful="loadPurchases"></purchases-table>
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
    import SideBarRequistion from "../../partials/sidebars/SideBarRequistion";
    import PurchasesFilters from "../../partials/filters/PurchasesFilters";
    import PurchasesTable from "../../partials/tables/PurchasesTable";
    import CreatePurchaseModal from "../../partials/modals/purchase/CreatePurchaseModal";
    import ProcessingOverlay from '../../../../progress/ProcessingOverlay';
    import {get} from "../../../../../helpers/api";
    import Auth from "../../../../../store/auth";
    import SupplierModal from '../../partials/modals/vendors/SupplierModal';
    import {PURCHASES_URL,PURCHASES_FACILITY_URL,PURCHASES_ATTRIBUTES_URL} from '../../../../../router/api_routes';
    import {createHtmlErrorString} from '../../../../../helpers/functionmixin';
    export default {
        name: "Index",
        components: {TopNavBar,SideBar,
        SideBarRequistion,ProcessingOverlay,
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
                }
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

