<template>

    <div>

        <processing-overlay :message="'Loading. Please wait...'" :status="progress_overlay"></processing-overlay>

        <top-nav-bar :inventory="true"></top-nav-bar>

        <side-bar></side-bar>

        <div class="wp-content mg-top-30 bg-dashboard">
            
            <div class="row">

                <div class="col-lg-12">

                    <section class="content mg-top-0">

                        <div class="row bg-dashboard">
                            <div class="mg-top-30 col-lg-9 col-md-9 col-sm-9 bd-right">
                                <div class="width-100-pc padding-bottom-20">
                                    <h6 class="lh-1 fs-14 fw-600 mg-bottom-20 txt-uppercase">Inventory Transfer Activity</h6>
                                    <div v-if="page_loaded" class="row">
                                        <div class="col-lg-3 col-xs-6">
                                            <div class="layers bd bg-white padding-top-10 padding-bottom-10 padding-right-20 padding-left-20">
                                                <div class="layer width-100-pc mg-bottom-10">
                                                    <div class="peers ai-sb fxw-nw">
                                                        <div class="peer text-center">
                                                            <span class="d-ib lh-0 va-m fw-600 bdrs-10em pX-15 pY-15 cl-blue-link fs-17">{{format_money(server_data.transfer_summary.to_be_picked)}}</span>
                                                        </div>
                                                        <div class="peer text-center">
                                                            <span class="fs-13">(Packs)</span>
                                                        </div>
                                                        <div class="peer text-center">
                                                            <span class="fs-13 fw-600">To Be Packed</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-xs-6">
                                            <div class="layers bd bg-white padding-top-10 padding-bottom-10 padding-right-20 padding-left-20">
                                                <div class="layer width-100-pc mg-bottom-10">
                                                    <div class="peers ai-sb fxw-nw">
                                                        <div class="peer text-center">
                                                            <span class="d-ib lh-0 va-m fw-600 bdrs-10em pX-15 pY-15 cl-amref fs-17">{{format_money(server_data.transfer_summary.to_be_shipped)}}</span>
                                                        </div>
                                                        <div class="peer text-center">
                                                            <span class="fs-13">(Packs)</span>
                                                        </div>
                                                        <div class="peer text-center">
                                                            <span class="fs-13 fw-600">To Be Shipped</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-xs-6">
                                            <div class="layers bd bg-white padding-top-10 padding-bottom-10 padding-right-20 padding-left-20">
                                                <div class="layer width-100-pc mg-bottom-10">
                                                    <div class="peers ai-sb fxw-nw">
                                                        <div class="peer text-center">
                                                            <span class="d-ib lh-0 va-m fw-600 bdrs-10em pX-15 pY-15 cl-success-light fs-17">{{format_money(server_data.transfer_summary.to_be_delivered)}}</span>
                                                        </div>
                                                        <div class="peer text-center">
                                                            <span class="fs-13">(Packs)</span>
                                                        </div>
                                                        <div class="peer text-center">
                                                            <span class="fs-13 fw-600">To Be Delivered</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-xs-6">
                                            <div class="layers bd bg-white padding-top-10 padding-bottom-10 padding-right-20 padding-left-20">
                                                <div class="layer width-100-pc mg-bottom-10">
                                                    <div class="peers ai-sb fxw-nw">
                                                        <div class="peer text-center">
                                                            <span class="d-ib lh-0 va-m fw-600 bdrs-10em pX-15 pY-15 cl-787887 fs-17">{{format_money(server_data.transfer_summary.to_be_invoiced)}}</span>
                                                        </div>
                                                        <div class="peer text-center">
                                                            <span class="fs-13">(Packs)</span>
                                                        </div>
                                                        <div class="peer text-center">
                                                            <span class="fs-13 fw-600">To Be Invoiced</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mg-top-30 col-lg-3 col-md-3 col-sm-3">
                                <div v-if="page_loaded" class=" width-100-pc">
                                    <h6 class="lh-1 fs-14 fw-600 mg-bottom-20 txt-uppercase">Inventory Summary</h6>
                                    <div class="filter-block form-inline pull-left">
                                        <div class="filter-group input-group">
                                            <span class="filter">Quantity In Hand&nbsp;&nbsp;</span>
                                            <span class="filter">{{format_money(server_data.inventory_summary.qty_in_hand)}}</span>
                                        </div>
                                    </div>
                                    <div class="filter-block form-inline pull-left mg-top-20">
                                        <div class="filter-group input-group">
                                            <span class="filter">Qty To Be Received&nbsp;&nbsp;</span>
                                            <span class="filter">{{format_money(server_data.inventory_summary.qty_to_receive)}}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row bg-white min-height-330">
                            <div class="col-lg-8 col-md-8 col-sm-8 padding-right-0">
                                <div class="width-100-pc mg-bottom-20 map-container min-height-330">
                                    <stock-map-view v-if="page_loaded" :server_data="server_data"></stock-map-view>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4">
                                <div class="width-100-pc mg-bottom-20 padding-top-10">
                                    <h6 class="lh-1 fs-14 fw-600 mg-bottom-20 txt-uppercase">Inventory Status Map View:</h6>
                                    <div v-if="page_loaded && server_data.coordinates.length">
                                        <p class="cl-amref fs-12 fw-600 txt-deco-underline">Key:</p>
                                        <table class="receipt-item-table-2 table table-bordered table-hover mg-top-5">
                                            <thead>
                                                <tr>
                                                    <th style="width:10%;">Priority</th>
                                                    <th style="width:15%;">Color</th>
                                                    <th style="width:75%;">Description</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>1</td>
                                                    <td class="cl-amref fw-600">Red</td>
                                                    <td>Stock out of a product</td>
                                                </tr>
                                                <tr>
                                                    <td>2</td>
                                                    <td class="fw-600 cl-blue-link">Blue</td>
                                                    <td>A product stock is below Reorder Point</td>
                                                </tr>
                                                <tr>
                                                    <td>3</td>
                                                    <td class="fw-600 cl-success-light">Green</td>
                                                    <td>No stock out on any product category</td>
                                                </tr>
                                                <tr>
                                                    <td>4</td>
                                                    <td class="fw-600 cl-444">Black</td>
                                                    <td class="fs-13">No Product Item found in a Facility</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div v-if="page_loaded && server_data.coordinates.length<1" class="text-center">
                                        <span class="cl-amref fs-12 fw-600">No facility</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- =========================================== -->
                        <div v-if="page_loaded" class="row bg-dashboard">
                            <div class="col-lg-7 col-md-7 col-sm-7">
                                <div class="layers mg-top-20 bd bg-white padding-top-10 padding-bottom-10 padding-right-20 padding-left-20 min-height-330">
                                    <div class="width-100-pc mg-bottom-20 padding-top-10">
                                        <h6 class="lh-1 fs-14 fw-600 mg-bottom-20 txt-uppercase">Product Details:</h6>
                                    </div>
                                    <hr>
                                    <div v-if="page_loaded" class="peers ai-sb fxw-nw width-100-pc">
                                        <div class="peer">
                                            <div class="width-50-pc float-left padding-right-10">
                                                <div class="width-100-pc">
                                                    <span class="cl-amref fs-13 fw-600 float-left width-60-pc mg-bottom-10">Out of Stock Items</span>
                                                    <span class="cl-amref fs-13 fw-600 float-right width-40-pc text-right mg-bottom-10">{{format_money(server_data.product_details.stock_out_items)}}</span>
                                                </div>
                                                <div class="width-100-pc">
                                                    <span class="fs-13 fw-600 float-left width-60-pc mg-bottom-10 cl-blue-link">Low Stock Items</span>
                                                    <span class="fs-13 fw-600 float-right width-40-pc text-right mg-bottom-10 cl-blue-link">{{format_money(server_data.product_details.low_stock_item)}}</span>
                                                </div>
                                                <div class="width-100-pc">
                                                    <span class="cl-444 fs-13 fw-600 float-left width-60-pc mg-bottom-10">All Item Categories</span>
                                                    <span class="cl-444 fs-13 fw-600 float-right width-40-pc text-right mg-bottom-10">{{format_money(server_data.product_details.item_category)}}</span>
                                                </div>
                                                <div class="width-100-pc">
                                                    <span class="cl-444 fs-13 fw-600 float-left width-60-pc mg-bottom-10">All Items</span>
                                                    <span class="cl-444 fs-13 fw-600 float-right width-40-pc text-right mg-bottom-10">{{format_money(server_data.product_details.items)}}</span>
                                                </div>
                                                <div class="width-100-pc">
                                                    <span class="cl-amref fs-13 fw-600 float-left width-60-pc mg-bottom-10">Unconfirmed Items</span>
                                                    <span class="cl-amref fs-13 fw-600 float-right width-40-pc text-right mg-bottom-10">{{format_money(server_data.product_details.unconfirmed_item)}}</span>
                                                </div>
                                            </div>
                                            <div class="width-50-pc float-left text-center padding-right-10 padding-left-20 border-left">
                                                <span class="fs-13 fw-600 mg-bottom-10">Active Items</span>
                                                <!-- <am-doughnut v-if="page_loaded" :bg_hero="false" :chart_value="server_data.active_percentage"></am-doughnut> -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-5 col-md-5 col-sm-5 padding-left-0">
                                <div class="layers mg-top-20 bd bg-white padding-top-10 padding-bottom-10 padding-right-20 padding-left-20 min-height-330">
                                    <div class="width-100-pc mg-bottom-20 padding-top-10">
                                        <h6 class="lh-1 fs-14 fw-600 mg-bottom-20 txt-uppercase width-70-pc float-left">Purchase Order:</h6>
                                        <div  class="btn-group float-right" role="group" aria-label="Button group with nested dropdown">
                                            <div class="btn-group" role="group">
                                                <a class="cl-444 fs-13 fw-600 mg-bottom-5">
                                                    This Month
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>

                                    <div class="layer width-100-pc mg-bottom-10">
                                        <div class="peers ai-sb fxw-nw">
                                            <div class="peer text-center">
                                                <span class="fs-13">.</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="peers ai-sb fxw-nw mg-bottom-10">
                                        <div class="peer text-center width-100-pc">
                                            <span class="fs-13 fw-600">Total POs</span>
                                        </div>
                                        <div class="peer text-center">
                                            <span class="d-ib lh-0 va-m fw-600 bdrs-10em pX-15 pY-15 cl-blue-link fs-13">{{format_money(server_data.po_summary.total_po)}}</span>
                                        </div>
                                    </div>

                                    <div class="width-100-pc text-center">
                                        <hr class="width-60-pc">
                                    </div>
                                    
                                    <div class="peers ai-sb fxw-nw mg-bottom-10">
                                        <div class="peer text-center width-100-pc">
                                            <span class="fs-13 fw-600">Quantity Ordered</span>
                                        </div>
                                        <div class="peer text-center">
                                            <span class="d-ib lh-0 va-m fw-600 bdrs-10em pX-15 pY-15 cl-blue-link fs-13">{{format_money(server_data.po_summary.total_items)}}</span>
                                        </div>
                                    </div>
                                    <div class="width-100-pc text-center">
                                        <hr class="width-60-pc">
                                    </div>
                                    <div class="peers ai-sb fxw-nw mg-top-10">
                                        <div class="peer text-center">
                                            <span class="fs-13 fw-600">Total Cost</span>
                                        </div>
                                        <div class="peer text-center">
                                            <span class="d-ib lh-0 va-m fw-600 bdrs-10em pX-15 pY-15 cl-blue-link fs-13">KES {{format_money(server_data.po_summary.total_cost)}}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- ============================================= -->

                        <!-- =========================================== -->
                        <div v-if="page_loaded" class="row bg-dashboard">
                            <div class="col-lg-8 col-md-8 col-sm-8">
                                <div class="layers mg-top-20 bd bg-white padding-top-10 padding-bottom-10 padding-right-20 padding-left-20 min-height-330">
                                    <div class="width-100-pc mg-bottom-20 padding-top-10">
                                        <h6 class="lh-1 fs-14 fw-600 mg-bottom-20 txt-uppercase">Most Requested Product:</h6>
                                    </div>
                                    <hr>
                                    <table class="receipt-item-table-2 table table-bordered table-hover mg-top-5">
                                        <thead>
                                            <tr>
                                                <th style="width:10%;">Code</th>
                                                <th style="width:70%;">Item</th>
                                                <th style="width:20%;">Category</th>
                                            </tr>
                                        </thead>
                                        <tbody v-if="server_data.requisitions.requisition_list.length>0">
                                            <tr v-for="(req_item,index) in server_data.requisitions.requisition_list" :key="'requisition_list'+index">
                                                <td class="padded cl-amref fw-600" tabindex="0">
                                                    {{req_item.sku_code}}
                                                </td>
                                                <td class="padded">
                                                    {{req_item.item_name}} | {{req_item.brand}} | {{req_item.brand_sector}} | {{req_item.unit_weight}}{{req_item.measure_unit_sympol}}
                                                </td>
                                                <td class="padded">
                                                    {{req_item.category}}
                                                </td>
                                            </tr>
                                        </tbody>
                                        <tbody v-if="server_data.requisitions.requisition_list.length === 0">
                                            <tr>
                                                <td colspan="4" class="padded text-center cl-amref">
                                                    No requisition to show!
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4 padding-left-0">
                                <div class="layers mg-top-20 bd bg-white padding-top-10 padding-bottom-10 padding-right-20 padding-left-20 min-height-330">
                                    <div class="width-100-pc mg-bottom-20 padding-top-10">
                                        <h6 class="lh-1 fs-14 fw-600 mg-bottom-20 txt-uppercase width-70-pc float-left">Requisition:</h6>
                                        <div  class="btn-group float-right" role="group" aria-label="Button group with nested dropdown">
                                            <div class="btn-group" role="group">
                                                <a class="cl-444 fs-13 fw-600 mg-bottom-5">
                                                    This Month
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="width-100-pc float-left text-center padding-right-10 padding-left-20">
                                        <span class="fs-13 fw-600 mg-bottom-10">Requisition Summary</span>
                                        <!-- <am-doughnut v-if="page_loaded" :bg_hero="false" :chart_value="server_data.active_percentage"></am-doughnut> -->
                                        <show-pie v-if="page_loaded" :bg_hero="false" :server_data="server_data.active_percentage"></show-pie>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- ============================================= -->
                    </section>
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
    import AmDoughnut from '../../../../analytics/AmDoughnut';
    import ShowPie from '../../../../analytics/ShowPie';
    import {get,post} from "../../../../helpers/api";
    import Auth from "../../../../store/auth";
    import StockMapView from '../../../../maps/StockMapView';
    import {formatMoney,removeElement} from "../../../../helpers/functionmixin";
    import {INVENTORY_WEB_ROUTES} from '../../../../router/web_routes';
    import {PRODUCT_REPORTS_URL} from '../../../../router/api_routes';

    export default {
        name: "Home",
        components: {TopNavBar,StockMapView,AmDoughnut,ShowPie,SideBar,SideBarHr,ProductModal,ProcessingOverlay,DeleteModal,ViewProductItemModal},
        data(){
            return {
                form: {
                    practice_id: '',
                    report_type: 'Dashboard Summary',
                },
                server_data: {},
                page_loaded: false,
                practice_id: '',
                is_page_ready: false,
                progress_overlay: 'hide',
                INVENTORY_WEB_ROUTES:INVENTORY_WEB_ROUTES
            }
        },
        methods: {

            loadReports(){
                this.progress_overlay = "show";
                post(PRODUCT_REPORTS_URL, this.form)
                .then((res) => {
                    if(res.data.status_code === 200) {
                        this.server_data = res.data.results;
                        this.page_loaded = true;
                        this.progress_overlay = "hide";
                        console.info(res.data.results);
                    }
                }).catch((err) => {
                    this.progress_overlay = "hide";
                    if(err.response.status === 422) {
                        this.$awn.warning(createHtmlErrorString(err.response.data.errors))
                    }else if (err.response.status === 500){
                        this.progress_overlay = "hide";
                        Auth.remove();
                        this.$awn.warning(err.response.data.description);
                        //this.$router.push("/500");
                        window.location.href = "/login";
                    }
                    else{
                        this.processing = false;
                        this.$awn.warning(err.response.data.description)
                    }
                });
            },
            format_money(money_to){
                return formatMoney(money_to);
            },

        },
        mounted(){
            this.practice_id = Auth.getCurrentAccount('id');
            this.form.practice_id = this.practice_id;
            this.loadReports();
        }
    }
</script>

<style scoped>
  .map-container {
    height: 300px!important;
  }
</style>