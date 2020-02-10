<template>

    <div>

        <processing-overlay :message="'Loading. Please wait...'" :status="progress_overlay"></processing-overlay>

        <top-nav-bar :inventory="true"></top-nav-bar>

        <side-bar></side-bar>

        <div class="wp-content">
            
            <div class="row">

                <div class="col-lg-12">

                    <div class="settings-header shadowed  main-heading bg-foo">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="pull pull-left app-header width-40-pc">
                                    <h2 class="txt-uppercase fs-13 fw-600">
                                        Accounting Integration
                                    </h2>
                                </div>
                                <!-- <div class="pull pull-right width-60-pc text-right padding-right-70">
                                    <a href="/analytic/dashboard" class="top-links mg-right-10"><i class="fa fa-bar-chart"></i> Dashboard</a>
                                    <a href="" class="top-links mg-right-10"><i class="fa fa-arrow-left"></i> Go to Requests</a>
                                    <a href="/inventory/stock" class="top-links mg-right-10"><i class="fa fa-shopping-basket"></i> Go to Stock</a>
                                    <div  class="btn-group float-right" role="group" aria-label="Button group with nested dropdown" style="box-shadow: inset 0 -1px 0 #DFDFDF;">
                                        <button data-toggle="modal" data-target="#product_item_modal" type="button" class="btn combo-button primary">+ New Item</button>
                                        <div class="btn-group" role="group">
                                            <button id="btnGroupDrop" type="button" class="btn combo-button primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            </button>
                                            <div class="dropdown-menu right-0" aria-labelledby="btnGroupDrop">
                                                <a class="dropdown-item" href="#"><i class="fa fa-download"></i> Import Items</a>
                                                <a class="dropdown-item"><i class="fa fa-file-excel-o"></i> Export as CSV</a>
                                            </div>
                                        </div>
                                    </div>
                                </div> -->
                            </div>
                        </div>
                    </div>

                    <section class="content bg-white mg-top-30">

                        <div class="row">

                            <div class="col-lg-3 col-xs-6">
                                <div class="small-box bordered-card">
                                    <div class="inner">
                                        <h3><label class="label cl-grey">0.00</label></h3>
                                        <h4 class="paragraph cl-grey">Cash in hand ( KES )</h4>
                                    </div>
                                    <div class="icon">
                                        <i class="fa fa-money " aria-hidden="true"></i>
                                    </div>
                                    <a href="" class="small-box-footer cl-grey fs-14 fw-600">More info <i class="fa fa-arrow-circle-right"></i></a>
                                </div>
                            </div>

                            <div class="col-lg-3 col-xs-6">
                                <div class="small-box bordered-card">
                                    <div class="inner">
                                        <h3><label class="label cl-grey">(0)</label></h3>
                                        <h4 class="paragraph cl-grey">Accounts Payables (KES)</h4>
                                    </div>
                                    <div class="icon">
                                        <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                    </div>
                                    <a href="" class="small-box-footer cl-grey fs-14 fw-600">More info <i class="fa fa-arrow-circle-right"></i></a>
                                </div>
                            </div>

                            <div class="col-lg-3 col-xs-6">
                                <div class="small-box bordered-card">
                                    <div class="inner">
                                        <h3><label class="label cl-grey">00.00</label></h3>
                                        <h4 class="paragraph cl-grey">Accounts receivable (KES)</h4>
                                    </div>
                                    <div class="icon">
                                        <i class="fa fa-lemon-o"></i>
                                    </div>
                                    <a href="" class="small-box-footer cl-grey fs-14 fw-600">More info <i class="fa fa-arrow-circle-right"></i></a>
                                </div>
                            </div>

                            <div class="col-lg-3 col-xs-6">
                                <div class="small-box bordered-card">
                                    <div class="inner">
                                        <h3><label class="label cl-grey">0</label></h3>
                                        <h4 class="paragraph cl-grey">Shortage Items</h4>
                                    </div>
                                    <div class="icon">
                                        <i class="fa fa-folder-o"></i>
                                    </div>
                                    <a href="" class="small-box-footer cl-grey fs-14 fw-600">More info <i class="fa fa-arrow-circle-right"></i></a>
                                </div>
                            </div>

                            <div class="col-lg-3 col-xs-6">
                                <div class="small-box bordered-card">
                                    <div class="inner">
                                        <h3><label class="label cl-grey">0</label></h3>
                                        <h4 class="paragraph cl-grey">Account Holders</h4>
                                    </div>
                                    <div class="icon">
                                        <i class="fa fa-user " aria-hidden="true"></i>
                                    </div>
                                    <a href="" class="small-box-footer cl-grey fs-14 fw-600">More info <i class="fa fa-arrow-circle-right"></i></a>
                                </div>
                            </div>

                            <div class="col-lg-3 col-xs-6">
                                <div class="small-box bordered-card">
                                    <div class="inner">
                                        <h3><label class="label cl-grey">00.00</label></h3>
                                        <h4 class="paragraph cl-grey">Cash in Bank ( USD )</h4>
                                    </div>
                                    <div class="icon">
                                        <i class="fa fa-bank" aria-hidden="true"></i>
                                    </div>
                                    <a href="" class="small-box-footer cl-grey fs-14 fw-600">More info <i class="fa fa-arrow-circle-right"></i></a>
                                </div>
                            </div>

                            <div class="col-lg-3 col-xs-6">
                                <div class="small-box bordered-card">
                                    <div class="inner">
                                        <h3><label class="label cl-grey">00.00</label></h3>
                                        <h4 class="paragraph cl-grey">Expense This Month ( KES )</h4>
                                    </div>
                                    <div class="icon">
                                        <i class="fa fa-rocket" aria-hidden="true"></i>
                                    </div>
                                    <a href="" class="small-box-footer cl-grey fs-14 fw-600">More info <i class="fa fa-arrow-circle-right"></i></a>
                                </div>
                            </div>

                            <div class="col-lg-3 col-xs-6">
                                <div class="small-box bordered-card">
                                    <div class="inner">
                                        <h3><label class="label cl-grey">00.00</label></h3>
                                        <h4 class="paragraph cl-grey">Purchases This Month ( KES )</h4>
                                    </div>
                                    <div class="icon">
                                        <i class="fa fa-cubes"></i>
                                    </div>
                                    <a href="" class="small-box-footer cl-grey fs-14 fw-600">More info <i class="fa fa-arrow-circle-right"></i></a>
                                </div>
                            </div>

                        </div>

                        <div class="row tiles-bg-settings">

                            <div class="col-lg-3 col-xs-6">
                                <div class="small-box bordered-card">
                                    <div class="inner">
                                        <h3><label class="label cl-grey">0</label></h3>
                                        <h4 class="paragraph cl-grey">Products Qty</h4>
                                    </div>
                                    <div class="icon">
                                        <i class="fa fa-shopping-basket" aria-hidden="true"></i>
                                    </div>
                                    <a href="" class="small-box-footer cl-grey fs-14 fw-600">More info <i class="fa fa-arrow-circle-right"></i></a>
                                </div>
                            </div>

                            <div class="col-lg-3 col-xs-6">
                                <div class="small-box bordered-card">
                                    <div class="inner">
                                        <h3><label class="label cl-grey">0</label></h3>
                                        <h4 class="paragraph cl-grey">Sales Today</h4>
                                    </div>
                                    <div class="icon">
                                        <i class="fa fa-bar-chart "></i>
                                    </div>
                                    <a href="" class="small-box-footer cl-grey fs-14 fw-600">More info <i class="fa fa-arrow-circle-right"></i></a>
                                </div>
                            </div>

                            <div class="col-lg-3 col-xs-6">
                                <div class="small-box bordered-card">
                                    <div class="inner">
                                        <h3><label class="label cl-grey">00.00</label></h3>
                                        <h4 class="paragraph cl-grey">Return this month ( KES )</h4>
                                    </div>
                                    <div class="icon">
                                        <i class="fa fa-fire" aria-hidden="true"></i>
                                    </div>
                                    <a href="" class="small-box-footer cl-grey fs-14 fw-600">More info <i class="fa fa-arrow-circle-right"></i></a>
                                </div>
                            </div>

                            <div class="col-lg-3 col-xs-6">
                                <div class="small-box bordered-card ">
                                    <div class="inner">
                                        <h3><label class="label cl-grey">00.00</label></h3>
                                        <h4 class="paragraph cl-grey">Worth of items in stock ( KES )</h4>
                                    </div>
                                    <div class="icon">
                                        <i class="fa fa-dollar" aria-hidden="true"></i>
                                    </div>
                                    <router-link :to="INVENTORY_WEB_ROUTES.INV_STOCK" class="small-box-footer cl-grey fs-14 fw-600">More info <i class="fa fa-arrow-circle-right"></i></router-link>
                                </div>
                            </div>

                        </div>

                    </section>

                    <!-- <div class="modal fade" id="view_product_item_modal">
                        <div class="modal-dialog modal-lg-custom modal-dialog-centered zoomInUp flipOutX">
                            <view-product-item-modal v-if="prod_loaded" :product_item="practice_product_item" :stocks="practice_product_item.stocks"></view-product-item-modal>
                        </div>
                    </div> -->

                    <product-modal v-if="is_page_ready" :initialization="initializations" :modal_id="'product_item_modal'" :item_url="initialUrl" v-on:productAdded="loadInitializations" v-on:taxAdded="loadInitializations" :user_mode="'Create'"></product-modal>

                </div>

            </div>
        </div>

    </div>
</template>

<script>
    import SideBar from "../partials/sidebars/SideBar"
    import TopNavBar from "../partials/topbars/TopNavBar"
    import SideBarHr from "../partials/sidebars/SideBarHr"
    import ProcessingOverlay from "../../../progress/ProcessingOverlay";
    import DeleteModal from '../../practice/partials/modals/DeleteModal'
    import ViewProductItemModal from '../../pharmacy/product/partials/ViewProductItemModal'
    import ProductModal from '../../practice/partials/modals/product/ProductModal'
    import {get} from "../../../../helpers/api";
    import AppInfo from "../../../../helpers/config";
    import Auth from "../../../../store/auth";
    import {formatMoney,removeElement} from "../../../../helpers/functionmixin";
    import {INVENTORY_WEB_ROUTES} from '../../../../router/web_routes';

    export default {
        name: "Home",
        components: {TopNavBar, SideBar,SideBarHr,ProductModal,ProcessingOverlay,DeleteModal,ViewProductItemModal},
        data(){
            return {
                initialUrl: '/api/practices/products/items',
                initializations: {},
                practice_product_items: [],
                prod_loaded: false,
                practice_id: '',
                is_page_ready: false,
                progress_overlay: 'hide',
                product_list_filters: [],
                active_filter: 0,
                INVENTORY_WEB_ROUTES:INVENTORY_WEB_ROUTES
            }
        },
        methods: {

            loadProducts(load_type){
                this.progress_overlay = "show";
                get(AppInfo.app_data.server_domain+'/api/practices/'+this.practice_id+'/'+load_type)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        //this.practice_product_items = res.data.results;
                        //this.loadProductType();
                        this.initializations.product_items = res.data.results;
                        this.practice_product_items = this.initializations.product_items;
                        this.progress_overlay = "hide";
                        if( this.practice_product_items.length < 1 ){
                            this.search_message = 'You dont have any '+load_type+' in your inventory';
                        }
                        console.info(res.data.results);
                    }
                }).catch((err) => {
                    this.progress_overlay = "hide";
                });
            },

            filter_method(index_to,item_type_id,item_type_name){
                this.active_filter = index_to;
                switch(item_type_name){
                    case "All":
                        this.loadInitializations();
                        break;
                    default:
                        this.loadProducts(item_type_name);
                        break;
                }
            },

            loadInitializations(){
                this.progress_overlay = "show";
                get(AppInfo.app_data.server_domain+'/api/practices/'+this.practice_id+'/Items Page Initialization')
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.initializations = res.data.results.resources;
                        //this.loadProductType();
                        console.info(this.initializations);
                        this.practice_product_items = this.initializations.product_items;
                        this.product_list_filters = this.initializations.product_types;
                        this.is_page_ready = true;
                        this.prod_loaded = true;
                        this.progress_overlay = "hide";
                        //this.loadProducts();
                        console.info(this.initializations);
                    }
                }).catch((err) => {
                    this.progress_overlay = "hide";
                });
            },
            format_money(money_to){
                return formatMoney(money_to);
            },

            delete_item(item_to){
                this.initializations.product_items = removeElement(this.initializations.product_items,item_to);
                this.practice_product_items = this.initializations.product_items;
            }

        },
        mounted(){
            this.practice_id = Auth.getCurrentAccount('id');
            this.loadInitializations();
        }
    }
</script>

<style scoped>

</style>